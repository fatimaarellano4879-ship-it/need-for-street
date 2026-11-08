<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();

        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0.01',
        ]);

        $producto = Producto::create($datos);

        Log::info('Nuevo producto registrado', [
            'producto_id' => $producto->id,
            'nombre' => $producto->nombre,
        ]);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto registrado correctamente.');
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0.01',
        ]);

        $producto->update($datos);

        Log::info('Producto actualizado', [
            'producto_id' => $producto->id,
            'nombre' => $producto->nombre,
        ]);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

        public function destroy(Producto $producto)
    {
        $nombre = $producto->nombre;

        $producto->delete();

        Log::info('Producto eliminado', [
            'producto_id' => $producto->id,
            'nombre' => $nombre,
        ]);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
