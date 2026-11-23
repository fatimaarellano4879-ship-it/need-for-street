# NEED FOR STREET — Parche de autenticación Laravel

Este paquete modifica únicamente los archivos indicados para trasladar la validación del PIN al servidor y proteger la API de datos.

## Archivos incluidos

- `app/Models/User.php`
- `app/Http/Controllers/NeedForStreetController.php`
- `routes/web.php`
- `resources/views/welcome.blade.php`
- `database/migrations/2026_11_22_233444_hash_user_pins.php`

No incluye `.env`, base de datos, credenciales ni tokens.

## Antes de aplicar

1. Conserva el respaldo SQLite verificado que ya generaste en `backups/`.
2. Abre PowerShell en la raíz del proyecto.
3. Ejecuta:

   ```powershell
   php artisan tinker
   ```

4. Consulta los usuarios sin mostrar credenciales:

   ```php
   DB::table('users')->select('uid', 'name', 'role', 'active')->orderBy('position')->get();
   ```

5. Confirma que exista al menos un usuario con `role = Administrador` y `active = 1`. Si no existe, no apliques la migración todavía; primero hay que preparar un procedimiento de recuperación de administrador.

## Aplicación del parche

1. Extrae el ZIP en la raíz de `C:\Proyectos\need-for-street`, conservando las rutas y aceptando reemplazar los cuatro archivos existentes.
2. La migración incluida es nueva; no reemplaza migraciones anteriores.
3. Ejecuta:

   ```powershell
   php artisan migrate
   php artisan optimize:clear
   ```

La migración convierte los PIN actuales a hashes y elimina la columna `pin` que almacenaba texto plano. Los usuarios conservarán los mismos PIN que ya tenían; se validarán mediante `Hash::check` en Laravel. La migración es intencionalmente irreversible: para volver al esquema anterior hay que restaurar el respaldo previo.

## Comprobaciones posteriores

1. Comprueba el estado:

   ```powershell
   php artisan migrate:status
   ```

2. Comprueba las rutas:

   ```powershell
   php artisan route:list --path=nfs -v
   ```

   Rutas esperadas:
   - `GET /nfs/login-users` — pública, solo devuelve identificadores y datos no sensibles de usuarios activos.
   - `POST /nfs/login` — pública con límite de intentos; valida el PIN en servidor.
   - `GET /nfs/session` — devuelve únicamente el estado de autenticación.
   - `GET /nfs/bootstrap` — requiere autenticación.
   - `POST /nfs/sync` — requiere autenticación.
   - `GET /nfs/qr/{code}` — requiere autenticación.
   - `POST /nfs/logout` — requiere autenticación.

3. Abre `http://127.0.0.1:8000`, selecciona el usuario e ingresa su PIN existente.
4. Comprueba el cambio de usuario desde el selector de sesiones.
5. Comprueba que un usuario no administrador no vea el formulario de alta de usuarios.
6. Comprueba que el sistema siga cargando productos, ventas, inventario, pedidos y clientes.

## Alcance de permisos

Este parche aplica autenticación del servidor a las operaciones de datos y reserva la administración de usuarios y la comisión global de terminal al rol `Administrador`. El código original no contiene una matriz completa de permisos por módulo para los roles de Ventas y Producción; por eso este parche no inventa restricciones adicionales sobre esos módulos. Esa matriz debe definirse antes de usar datos comerciales reales.

## Importante

- No ejecutes `migrate:fresh`, `migrate:refresh` ni `db:wipe`.
- No publiques la carpeta `backups/` en GitHub.
- No subas `.env` ni credenciales.
- No ejecutes `wasmer deploy` todavía; primero valida el login local y las rutas protegidas.
