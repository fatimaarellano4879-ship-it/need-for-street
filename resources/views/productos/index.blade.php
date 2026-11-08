@extends('layouts.app')

@section('title', 'Productos | NEED FOR STREET')

@section('content')

    {{-- Encabezado del catálogo --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold">Catálogo de productos</h1>
            <p class="text-secondary mb-0">
                Administra los productos de NEED FOR STREET.
            </p>
        </div>

        <a href="{{ route('productos.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i>
            Registrar producto
        </a>
    </div>

    {{-- Listado de productos --}}
    <div class="nfs-card">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h2 class="h5 mb-0">Productos registrados</h2>

            <span class="badge bg-label-primary">
                Total: {{ $productos->count() }}
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($productos as $producto)
                        <tr>
                            <td>{{ $producto->id }}</td>

                            <td class="fw-semibold">
                                {{ $producto->nombre }}
                            </td>

                            <td>
                                ${{ number_format((float) $producto->precio, 2) }}
                            </td>

                            
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">

                                    {{-- Botón editar --}}
                                    <a
                                        href="{{ route('productos.edit', $producto) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        <i class="bx bx-edit-alt me-1"></i>
                                        Editar
                                    </a>

                                    {{-- Botón eliminar --}}
                                    <form
                                        action="{{ route('productos.destroy', $producto) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Estás seguro de eliminar este producto?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bx bx-trash me-1"></i>
                                            Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="bx bx-package display-4 text-secondary"></i>

                                <h5 class="mt-3">
                                    No hay productos registrados
                                </h5>

                                <p class="text-secondary">
                                    Registra tu primer producto para comenzar.
                                </p>

                                <a
                                    href="{{ route('productos.create') }}"
                                    class="btn btn-primary"
                                >
                                    <i class="bx bx-plus me-1"></i>
                                    Registrar primer producto
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection