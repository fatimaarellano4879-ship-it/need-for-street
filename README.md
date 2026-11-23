# NEED FOR STREET

**Sistema web de gestión de productos, inventario, ventas y pedidos.**

NEED FOR STREET es una aplicación web desarrollada con Laravel y PHP, diseñada para centralizar la administración de productos, materias primas, movimientos de inventario, ventas y pedidos de clientes mediante una interfaz modular y adaptable.

El proyecto busca facilitar el control de las operaciones del negocio, mantener organizada la información y proporcionar acceso mediante autenticación de usuarios.

## 1. Objetivo del proyecto

Desarrollar un sistema de gestión que permita administrar las operaciones principales desde una plataforma centralizada, reduciendo la dependencia de registros manuales y facilitando el seguimiento de la información.

## 2. Tecnologías utilizadas

- **Backend:** PHP y Laravel.
- **Frontend:** Blade, HTML, CSS y JavaScript.
- **Base de datos local:** SQLite.
- **Base de datos prevista para despliegue:** MySQL.
- **Gestión de dependencias:** Composer.
- **Control de versiones:** Git y GitHub.
- **Plataforma de alojamiento prevista:** Wasmer Edge.

## 3. Módulos del sistema

El sistema cuenta con los siguientes componentes:

| Módulo | Funcionalidad |
|---|---|
| Usuarios | Administración de cuentas y acceso mediante PIN. |
| Productos | Registro y consulta de productos. |
| Colores | Administración de la paleta de colores. |
| Materias primas | Control de materiales y existencias. |
| Inventario | Registro de movimientos de inventario. |
| Ventas | Registro de operaciones y sus detalles. |
| Clientes | Administración de clientes personalizados. |
| Pedidos | Registro y seguimiento de pedidos. |
| Configuración | Administración de parámetros generales. |
| Sincronización | Comunicación entre la interfaz y la base de datos. |

## 4. Arquitectura de la base de datos

La estructura principal se encuentra organizada en diez tablas:

1. `users`
2. `palette_colors`
3. `raw_materials`
4. `products`
5. `stock_movements`
6. `sales`
7. `sale_items`
8. `custom_clients`
9. `orders`
10. `system_settings`

Se utilizan identificadores únicos (`uid`) para conservar la identidad de los registros durante las operaciones de consulta y sincronización.

Las estructuras de base de datos se administran mediante migraciones de Laravel.

## 5. Autenticación y seguridad

El acceso al sistema se realiza mediante PIN de cuatro dígitos, cuya validación se procesa en el servidor.

Las medidas implementadas incluyen:

- Almacenamiento de PIN mediante hashes bcrypt.
- Autenticación mediante sesiones de Laravel.
- Protección de las rutas de consulta y sincronización.
- Limitación de intentos de inicio de sesión.
- Cierre de sesión con invalidación de la sesión.
- Conservación de las sesiones al reiniciar el servidor.

Se conservan los roles existentes:

- Administrador.
- Ventas / Mostrador.
- Producción / Taller.

## 6. Interfaz de usuario

El sistema utiliza una interfaz de diseño Bento Modular, organizada en componentes visuales independientes.

Su presentación está diseñada para adaptarse a diferentes tamaños de pantalla, incluyendo computadoras, tabletas y teléfonos móviles.

## 7. Estructura del proyecto

```text
need-for-street/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── NeedForStreetController.php
│   └── Models/
│       └── User.php
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   └── views/
│       └── welcome.blade.php
├── routes/
│   └── web.php
├── storage/
├── tests/
├── docs/
├── .env.example
├── .gitignore
├── composer.json
└── README.md
```

## 8. Instalación local

### Requisitos

- PHP 8.4.
- Composer.
- Extensión PDO SQLite.
- Git.

### Clonar el repositorio

```bash
git clone https://github.com/fatimaarellano4879-ship-it/need-for-street.git

cd need-for-street
```

Para obtener la versión de desarrollo, cambiar a la rama correspondiente:

```bash
git checkout feature/evidencia-3-base-datos
```

### Instalar dependencias

```bash
composer install
```

### Configurar el entorno

```bash
cp .env.example .env
```

En Windows PowerShell se puede utilizar:

```powershell
Copy-Item .env.example .env
```

Configurar la conexión local a SQLite en `.env` y crear el archivo de base de datos si todavía no existe.

```powershell
if (!(Test-Path .\database\database.sqlite)) {
    New-Item -ItemType File .\database\database.sqlite
}
```

### Generar la clave de aplicación

```bash
php artisan key:generate
```

### Ejecutar migraciones

```bash
php artisan migrate
```

### Iniciar el servidor

```bash
php artisan serve
```

Abrir:

```text
http://127.0.0.1:8000
```

## 9. Estado del despliegue

La versión local utiliza SQLite.

Se contempla el traslado de la aplicación a Wasmer Edge y la migración de la información a MySQL administrado.

Esta etapa requiere configurar las variables de entorno, validar las migraciones y transferir los registros existentes antes de publicar la aplicación.

## 10. Consideraciones de seguridad

- No publicar el archivo `.env`.
- No subir bases de datos SQLite ni respaldos.
- No compartir credenciales ni tokens.
- No ejecutar migraciones destructivas sobre bases de datos con información.
- Conservar respaldos antes de realizar cambios estructurales.

## 11. Estado del proyecto

NEED FOR STREET se encuentra en desarrollo y preparación para su demostración académica.

Las siguientes etapas contemplan la publicación en Wasmer Edge, la migración a MySQL y la validación del sistema en un entorno alojado.

---

**NEED FOR STREET — Sistema de gestión modular.**
