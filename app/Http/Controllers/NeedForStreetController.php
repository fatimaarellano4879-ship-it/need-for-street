<?php

namespace App\Http\Controllers;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class NeedForStreetController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    /**
     * Lista mínima de usuarios activos para mostrar el selector de acceso.
     * No devuelve PIN, hashes ni información comercial.
     */
    public function loginUsers()
    {
        $users = DB::table('users')
            ->where('active', true)
            ->orderBy('position')
            ->get(['uid', 'name', 'alias', 'role'])
            ->map(fn ($user) => [
                'id' => $user->uid,
                'name' => $user->name,
                'alias' => $user->alias,
                'role' => $user->role,
            ])
            ->values();

        return response()->json(['users' => $users]);
    }

    /**
     * Verifica el PIN en el servidor y crea una sesión Laravel.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'uid' => ['required', 'string', 'max:64'],
            'pin' => ['required', 'digits:4'],
        ]);

        $user = User::query()
            ->where('uid', $credentials['uid'])
            ->where('active', true)
            ->first();

        if (! $user || ! $user->pin_hash || ! Hash::check($credentials['pin'], $user->pin_hash)) {
            return response()->json([
                'message' => 'Usuario o PIN incorrecto.',
            ], 422);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'ok' => true,
            'user' => $this->safeUser($user),
        ]);
    }

    /**
     * Comprueba si el navegador conserva una sesión válida.
     */
    public function sessionStatus(Request $request)
    {
        if (! Auth::check()) {
            return response()->json(['authenticated' => false], 401);
        }

        $user = Auth::user();

        if (! $user || ! $user->active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json(['authenticated' => false], 401);
        }

        return response()->json([
            'authenticated' => true,
            'user' => $this->safeUser($user),
        ]);
    }

    /**
     * Cierra la sesión autenticada.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['ok' => true]);
    }

    /** Devuelve el estado de la aplicación solo a un usuario autenticado. */
    public function bootstrap(Request $request)
    {
        $actor = $this->activeUser($request);

        if (! DB::table('system_settings')->where('key', 'initialized')->exists()) {
            return response()->json(['initialized' => false]);
        }

        $setting = fn (string $key, $default) =>
            DB::table('system_settings')->where('key', $key)->value('value') ?? $default;
        $itemsBySale = DB::table('sale_items')->orderBy('id')->get()->groupBy('sale_uid');

        return response()->json([
            'initialized' => true,
            'currentUser' => $this->safeUser($actor),
            'terminalFeePct' => (float) $setting('terminal_fee_pct', 3.5),
            'quoteFolioCounter' => (int) $setting('quote_folio_counter', 301),

            // Nunca enviar pin_hash ni PIN al navegador.
            'users' => DB::table('users')->orderBy('position')->get()->map(fn ($r) => [
                'id' => $r->uid,
                'name' => $r->name,
                'alias' => $r->alias,
                'role' => $r->role,
                'active' => (bool) $r->active,
            ])->values(),

            'colorPalette' => DB::table('palette_colors')->orderBy('position')->get()->map(fn ($r) => [
                'name' => $r->name, 'hex' => $r->hex,
            ])->values(),

            'rawMaterials' => DB::table('raw_materials')->orderBy('position')->get()->map(fn ($r) => [
                'id' => $r->uid, 'name' => $r->name, 'category' => $r->category,
                'subType' => $r->sub_type ?? '', 'color' => $r->color,
                'sizeOrMeasure' => $r->size_or_measure, 'qty' => (int) $r->qty,
                'cost' => (float) $r->cost, 'updatedBy' => $r->updated_by,
            ])->values(),

            'products' => DB::table('products')->orderBy('position')->get()->map(fn ($r) => [
                'id' => $r->uid, 'qr' => $r->qr, 'name' => $r->name, 'category' => $r->category,
                'color' => $r->color, 'size' => $r->size, 'stock' => (int) $r->stock,
                'cost' => (float) $r->cost, 'price' => (float) $r->price,
            ])->values(),

            'stockMovements' => DB::table('stock_movements')->orderByDesc('id')->get()->map(fn ($r) => [
                'id' => $r->uid, 'date' => $r->movement_date, 'product' => $r->product, 'qr' => $r->qr,
                'type' => $r->type, 'delta' => (int) $r->delta, 'user' => $r->user_name,
            ])->values(),

            'sales' => DB::table('sales')->orderByDesc('id')->get()->map(fn ($r) => [
                'id' => $r->uid, 'folio' => $r->folio, 'date' => $r->sale_date,
                'user' => $r->user_name, 'method' => $r->method,
                'splitDetails' => $r->split_details ? json_decode($r->split_details, true) : null,
                'grossAmount' => (float) $r->gross_amount, 'feeAmount' => (float) $r->fee_amount,
                'netAmount' => (float) $r->net_amount, 'costAmount' => (float) $r->cost_amount,
                'items' => $itemsBySale->get($r->uid, collect())->map(fn ($i) => [
                    'name' => $i->name, 'category' => $i->category, 'qty' => (int) $i->qty,
                    'price' => (float) $i->price, 'cost' => (float) $i->cost,
                ])->values(),
            ])->values(),

            'orders' => DB::table('orders')->orderBy('position')->get()->map(fn ($r) => [
                'id' => $r->uid, 'folio' => $r->folio, 'date' => $r->order_date,
                'clientName' => $r->client_name, 'clientPhone' => $r->client_phone,
                'summary' => $r->summary, 'totalAmount' => (float) $r->total_amount,
                'advancePaid' => (float) $r->advance_paid, 'prodStatus' => $r->prod_status,
                'createdBy' => $r->created_by,
            ])->values(),

            'customClients' => DB::table('custom_clients')->orderBy('position')->get()->map(fn ($r) => [
                'id' => $r->uid, 'name' => $r->name, 'phone' => $r->phone, 'notes' => $r->notes ?? '',
            ])->values(),
        ]);
    }

    /** Guarda el estado que manda el navegador en una transacción. */
    public function sync(Request $request)
    {
        $actor = $this->activeUser($request);

        $d = $request->validate([
            'users' => 'present|array',
            'colorPalette' => 'present|array',
            'products' => 'present|array',
            'rawMaterials' => 'present|array',
            'orders' => 'present|array',
            'customClients' => 'present|array',
            'sales' => 'present|array',
            'stockMovements' => 'present|array',
            'terminalFeePct' => 'required|numeric|min:0|max:100',
            'quoteFolioCounter' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($d, $actor) {
            // La administración de cuentas queda reservada al rol Administrador.
            // Para los demás roles se ignora el arreglo users aunque el navegador lo envíe.
            if ($actor->role === 'Administrador') {
                $this->syncUsers($d['users'], $actor);
            }

            $this->syncTable('palette_colors', $d['colorPalette'], fn ($r, $i) => [
                'uid' => (string) ($r['name'] ?? ''), 'name' => (string) ($r['name'] ?? ''),
                'hex' => (string) ($r['hex'] ?? '#000000'), 'position' => $i,
            ], true);

            $this->syncTable('raw_materials', $d['rawMaterials'], fn ($r, $i) => [
                'uid' => (string) ($r['id'] ?? ''), 'name' => (string) ($r['name'] ?? ''),
                'category' => (string) ($r['category'] ?? ''), 'sub_type' => (string) ($r['subType'] ?? ''),
                'color' => (string) ($r['color'] ?? 'N/A'), 'size_or_measure' => (string) ($r['sizeOrMeasure'] ?? ''),
                'qty' => (int) ($r['qty'] ?? 0), 'cost' => (float) ($r['cost'] ?? 0),
                'updated_by' => $actor->name, 'position' => $i,
            ], true);

            $this->syncTable('products', $d['products'], fn ($r, $i) => [
                'uid' => (string) ($r['id'] ?? ''), 'qr' => strtoupper((string) ($r['qr'] ?? '')),
                'name' => (string) ($r['name'] ?? ''), 'category' => (string) ($r['category'] ?? ''),
                'color' => (string) ($r['color'] ?? 'N/A'), 'size' => (string) ($r['size'] ?? ''),
                'stock' => (int) ($r['stock'] ?? 0), 'cost' => (float) ($r['cost'] ?? 0),
                'price' => (float) ($r['price'] ?? 0), 'position' => $i,
            ], true);

            $this->syncTable('orders', $d['orders'], fn ($r, $i) => [
                'uid' => (string) ($r['id'] ?? ''), 'folio' => (string) ($r['folio'] ?? ''),
                'order_date' => (string) ($r['date'] ?? ''), 'client_name' => (string) ($r['clientName'] ?? ''),
                'client_phone' => (string) ($r['clientPhone'] ?? ''), 'summary' => (string) ($r['summary'] ?? ''),
                'total_amount' => (float) ($r['totalAmount'] ?? 0), 'advance_paid' => (float) ($r['advancePaid'] ?? 0),
                'prod_status' => (string) ($r['prodStatus'] ?? 'Pendiente'),
                'created_by' => $actor->name, 'position' => $i,
            ], true);

            $this->syncTable('custom_clients', $d['customClients'], fn ($r, $i) => [
                'uid' => (string) ($r['id'] ?? ''), 'name' => (string) ($r['name'] ?? ''),
                'phone' => (string) ($r['phone'] ?? ''), 'notes' => (string) ($r['notes'] ?? ''), 'position' => $i,
            ], true);

            // Movimientos y ventas solo se agregan/actualizan por UID; nunca se podan.
            $this->syncTable('stock_movements', array_reverse(array_values($d['stockMovements'])), fn ($r, $i) => [
                'uid' => (string) ($r['id'] ?? ''), 'movement_date' => (string) ($r['date'] ?? ''),
                'product' => (string) ($r['product'] ?? ''), 'qr' => (string) ($r['qr'] ?? ''),
                'type' => (string) ($r['type'] ?? ''), 'delta' => (int) ($r['delta'] ?? 0),
                'user_name' => $actor->name,
            ], false);

            $sales = array_reverse(array_values($d['sales']));
            $this->syncTable('sales', $sales, fn ($r, $i) => [
                'uid' => (string) ($r['id'] ?? ''), 'folio' => (string) ($r['folio'] ?? ''),
                'sale_date' => (string) ($r['date'] ?? ''), 'user_name' => $actor->name,
                'method' => (string) ($r['method'] ?? ''),
                'split_details' => ! empty($r['splitDetails']) ? json_encode($r['splitDetails']) : null,
                'gross_amount' => (float) ($r['grossAmount'] ?? 0), 'fee_amount' => (float) ($r['feeAmount'] ?? 0),
                'net_amount' => (float) ($r['netAmount'] ?? 0), 'cost_amount' => (float) ($r['costAmount'] ?? 0),
            ], false);

            foreach ($sales as $sale) {
                $uid = (string) ($sale['id'] ?? '');
                if ($uid === '') {
                    continue;
                }

                DB::table('sale_items')->where('sale_uid', $uid)->delete();

                foreach ($sale['items'] ?? [] as $item) {
                    DB::table('sale_items')->insert([
                        'sale_uid' => $uid,
                        'name' => (string) ($item['name'] ?? ''),
                        'category' => (string) ($item['category'] ?? ''),
                        'qty' => (int) ($item['qty'] ?? 0),
                        'price' => (float) ($item['price'] ?? 0),
                        'cost' => (float) ($item['cost'] ?? 0),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            $settings = [
                'quote_folio_counter' => $d['quoteFolioCounter'],
                'initialized' => 1,
            ];

            // Solo Administración puede cambiar la comisión global de terminal.
            if ($actor->role === 'Administrador') {
                $settings['terminal_fee_pct'] = $d['terminalFeePct'];
            }

            foreach ($settings as $key => $value) {
                DB::table('system_settings')->upsert(
                    [[
                        'key' => $key,
                        'value' => (string) $value,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]],
                    ['key'],
                    ['value', 'updated_at']
                );
            }
        });

        return response()->json(['ok' => true]);
    }

    /**
     * Sincroniza usuarios para administradores. Los PIN entrantes se convierten
     * a hash y nunca se devuelven al navegador.
     */
    private function syncUsers(array $items, User $actor): void
    {
        $allowedRoles = [
            'Administrador',
            'Ventas / Mostrador',
            'Producción / Taller',
        ];

        $rows = [];
        $uids = [];
        $aliases = [];
        $now = now();

        foreach (array_values($items) as $index => $item) {
            $uid = trim((string) ($item['id'] ?? ''));
            $name = trim((string) ($item['name'] ?? ''));
            $alias = trim((string) ($item['alias'] ?? ''));
            $role = (string) ($item['role'] ?? '');

            if ($uid === '' || $name === '' || $alias === '') {
                throw ValidationException::withMessages([
                    'users' => 'Cada usuario debe tener identificador, nombre y alias.',
                ]);
            }

            if (! in_array($role, $allowedRoles, true)) {
                throw ValidationException::withMessages([
                    'users' => 'Se recibió un rol no permitido.',
                ]);
            }

            if (in_array($uid, $uids, true) || in_array(mb_strtolower($alias), $aliases, true)) {
                throw ValidationException::withMessages([
                    'users' => 'Hay identificadores o alias duplicados.',
                ]);
            }

            $existing = DB::table('users')->where('uid', $uid)->first();
            $pin = trim((string) ($item['pin'] ?? ''));

            if ($pin !== '') {
                if (! preg_match('/^\d{4}$/', $pin)) {
                    throw ValidationException::withMessages([
                        'users' => 'Los PIN nuevos deben contener exactamente cuatro dígitos.',
                    ]);
                }

                $pinHash = Hash::make($pin);
            } elseif ($existing && ! empty($existing->pin_hash)) {
                $pinHash = $existing->pin_hash;
            } else {
                throw ValidationException::withMessages([
                    'users' => "El usuario {$name} necesita configurar un PIN de cuatro dígitos.",
                ]);
            }

            $rows[] = [
                'uid' => $uid,
                'name' => $name,
                'alias' => $alias,
                'pin_hash' => $pinHash,
                'role' => $role,
                'active' => ! empty($item['active']),
                'position' => $index,
                'created_at' => $existing->created_at ?? $now,
                'updated_at' => $now,
            ];

            $uids[] = $uid;
            $aliases[] = mb_strtolower($alias);
        }

        $actorRow = collect($rows)->firstWhere('uid', $actor->uid);

        if (! $actorRow || ! $actorRow['active']) {
            throw ValidationException::withMessages([
                'users' => 'No puedes eliminar o desactivar tu propia cuenta durante esta sesión.',
            ]);
        }

        $activeAdmins = collect($rows)->filter(
            fn ($row) => $row['active'] && $row['role'] === 'Administrador'
        )->count();

        if ($activeAdmins < 1) {
            throw ValidationException::withMessages([
                'users' => 'Debe permanecer al menos un administrador activo.',
            ]);
        }

        foreach (array_chunk($rows, 40) as $chunk) {
            DB::table('users')->upsert(
                $chunk,
                ['uid'],
                ['name', 'alias', 'pin_hash', 'role', 'active', 'position', 'updated_at']
            );
        }

        DB::table('users')->whereNotIn('uid', $uids)->delete();
    }

    /** Inserta/actualiza por uid. Con $prune=true también borra lo que ya no viene en la lista. */
    private function syncTable(string $table, array $items, Closure $map, bool $prune): void
    {
        $now = now();
        $rows = [];

        foreach (array_values($items) as $index => $item) {
            $row = $map($item, $index);

            if ($row['uid'] === '') {
                continue;
            }

            $rows[] = $row + ['created_at' => $now, 'updated_at' => $now];
        }

        if ($prune) {
            $stale = array_diff(DB::table($table)->pluck('uid')->all(), array_column($rows, 'uid'));

            foreach (array_chunk($stale, 500) as $chunk) {
                DB::table($table)->whereIn('uid', $chunk)->delete();
            }
        }

        if ($rows) {
            $update = array_values(array_diff(array_keys($rows[0]), ['uid', 'created_at']));

            foreach (array_chunk($rows, 40) as $chunk) {
                DB::table($table)->upsert($chunk, ['uid'], $update);
            }
        }
    }

    /**
     * QR ISO/IEC 18004 servido desde el almacenamiento privado de Laravel.
     */
    public function qr(Request $request, string $code)
    {
        $this->activeUser($request);

        $code = strtoupper($code);
        $size = max(100, min(600, (int) $request->query('size', 300)));
        $path = 'qr/' . $code . '_' . $size . '.png';

        if (! Storage::exists($path)) {
            $res = Http::timeout(8)->get('https://api.qrserver.com/v1/create-qr-code/', [
                'size' => $size . 'x' . $size,
                'data' => $code,
                'margin' => 10,
                'ecc' => 'M',
                'format' => 'png',
            ]);

            abort_unless(
                $res->successful() && str_starts_with((string) $res->header('Content-Type'), 'image/'),
                502,
                'QRServer no respondió'
            );

            Storage::put($path, $res->body());
        }

        return response(Storage::get($path), 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'private, max-age=86400',
        ]);
    }

    private function activeUser(Request $request): User
    {
        $user = $request->user();

        if (! $user instanceof User || ! $user->active) {
            abort(403, 'La sesión no tiene un usuario activo.');
        }

        return $user;
    }

    private function safeUser(User $user): array
    {
        return [
            'id' => $user->uid,
            'name' => $user->name,
            'alias' => $user->alias,
            'role' => $user->role,
            'active' => (bool) $user->active,
        ];
    }
}
