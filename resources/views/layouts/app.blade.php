
<!DOCTYPE html>
<html lang="es" class="light-style layout-menu-fixed" dir="ltr"
      data-theme="theme-default"
      data-assets-path="/assets/"
      data-template="vertical-menu-template-free">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'NEED FOR STREET')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Fuente principal de Sneat --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    {{-- Recursos CSS y SCSS compilados por Vite --}}
    @vite([
        'resources/css/app.css',
        'resources/assets/css/demo.css',
        'resources/js/app.js',
        'resources/assets/vendor/scss/core.scss',
        'resources/assets/vendor/fonts/iconify/iconify.css',
        'resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.scss'
    ])

    @stack('styles')

    {{-- Ajustes propios de NEED FOR STREET --}}
    
<style>
    /* Configuración general */
    * {
        box-sizing: border-box;
    }

    html,
    body {
        margin: 0;
        min-height: 100%;
        width: 100%;
        font-family: 'Public Sans', sans-serif;
    }

    body {
        overflow-x: hidden;
        background: #f5f5f9;
    }

    /* Distribución para computadoras */
    .layout-wrapper {
        width: 100%;
        min-height: 100vh;
    }

    .layout-container {
        display: flex !important;
        flex-direction: row !important;
        align-items: stretch;
        width: 100%;
        min-height: 100vh;
    }

    #layout-menu.layout-menu {
        position: relative !important;
        inset: auto !important;
        transform: none !important;
        visibility: visible !important;
        display: block !important;
        flex: 0 0 260px !important;
        width: 260px !important;
        min-width: 260px !important;
        max-width: 260px !important;
        height: auto !important;
        min-height: 100vh;
        overflow-y: auto;
        z-index: 2;
    }

    .layout-page {
        flex: 1 1 0 !important;
        width: auto !important;
        min-width: 0 !important;
        max-width: 100%;
        margin: 0 !important;
        padding: 0 !important;
    }

    .content-wrapper,
    .container-xxl {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0;
    }

    .layout-navbar {
        width: calc(100% - 2rem) !important;
        margin: 1rem !important;
    }

    /* Tarjetas y contenido */
    .nfs-card {
        width: 100%;
        min-width: 0;
        padding: 1.5rem;
        overflow-wrap: anywhere;
        background: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 2px 6px rgba(67, 89, 113, 0.12);
    }

    .nfs-page-heading {
        margin-bottom: 1.5rem;
    }

    .nfs-footer {
        padding: 1.25rem 1.5rem;
        color: #8592a3;
        font-size: 0.875rem;
    }

    .nfs-alert {
        margin-bottom: 1.25rem;
        overflow-wrap: anywhere;
    }

    img,
    table {
        max-width: 100%;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Tabletas y teléfonos */
    @media (max-width: 767.98px) {
        .layout-container {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
        }

        #layout-menu.layout-menu {
            position: relative !important;
            inset: auto !important;
            transform: none !important;
            display: block !important;
            flex: 0 0 auto !important;
            width: 100% !important;
            min-width: 0 !important;
            max-width: 100% !important;
            min-height: auto !important;
            height: auto !important;
            overflow: visible;
        }

        .layout-menu .app-brand {
            min-width: 0;
            max-width: 100%;
        }

        .layout-menu .app-brand-text {
            overflow-wrap: anywhere;
        }

        .layout-menu .menu-inner {
            width: 100%;
            max-width: 100%;
            padding-bottom: 0.75rem;
        }

        .layout-page {
            display: block !important;
            flex: 1 1 auto !important;
            width: 100% !important;
            min-width: 0 !important;
            max-width: 100% !important;
            margin: 0 !important;
        }

        .layout-navbar {
            width: calc(100% - 1.5rem) !important;
            margin: 0.75rem !important;
            padding: 0.75rem !important;
        }

        .content-wrapper {
            width: 100% !important;
            min-width: 0 !important;
        }

        .container-xxl {
            width: 100% !important;
            padding-right: 0.75rem !important;
            padding-left: 0.75rem !important;
        }

        .nfs-card {
            padding: 1rem;
        }

        .nfs-footer {
            padding: 1rem;
        }

        h1,
        .display-5,
        .display-6 {
            font-size: clamp(1.5rem, 6vw, 2rem);
            overflow-wrap: anywhere;
        }

        .btn {
            white-space: normal;
        }
    }
</style>

</head>

<body>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            {{-- Menú lateral reutilizable de NEED FOR STREET --}}
            @include('partials.navigation')

            {{-- Contenedor de la página --}}
            <div class="layout-page">

                {{-- Barra superior --}}
                <nav
                    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    aria-label="Barra superior"
                >
                    <div class="navbar-nav-right d-flex align-items-center w-100">
                        <span class="fw-semibold">
                            Panel de administración
                        </span>
                    </div>
                </nav>

                {{-- Contenido principal --}}
                <div class="content-wrapper">

                    <main class="container-xxl flex-grow-1 container-p-y">

                        {{-- Mensajes de confirmación --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible nfs-alert" role="alert">
                                {{ session('success') }}

                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="Cerrar"
                                ></button>
                            </div>
                        @endif

                        {{-- Mensajes de advertencia --}}
                        @if (session('warning'))
                            <div class="alert alert-warning alert-dismissible nfs-alert" role="alert">
                                {{ session('warning') }}

                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="Cerrar"
                                ></button>
                            </div>
                        @endif

                        {{-- Mensajes de error --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible nfs-alert" role="alert">
                                {{ session('error') }}

                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="Cerrar"
                                ></button>
                            </div>
                        @endif

                        {{-- Errores de validación --}}
                        @if ($errors->any())
                            <div class="alert alert-danger nfs-alert" role="alert">
                                <p class="fw-semibold mb-2">
                                    Revisa los siguientes errores:
                                </p>

                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Cada vista coloca aquí su contenido --}}
                        @yield('content')

                    </main>

                    {{-- Pie de página --}}
                    <footer class="nfs-footer">
                        <div class="container-xxl">
                            © {{ date('Y') }} NEED FOR STREET
                            <span class="ms-1">
                                Sistema de gestión de productos.
                            </span>
                        </div>
                    </footer>

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    {{-- Scripts adicionales de cada vista --}}
    @stack('scripts')

</body>
</html>