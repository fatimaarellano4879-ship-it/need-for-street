
@extends('layouts.app')

@section('title', 'Registrar producto | NEED FOR STREET')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Registrar producto</h1>
        <p class="text-secondary mb-0">
            Agrega un producto al catálogo de NEED FOR STREET.
        </p>
    </div>

    <div class="nfs-card">
        <form action="{{ route('productos.store') }}" method="POST">
            @csrf
                        
            <div class="mb-3">
                <label for="nombre" class="form-label">
                    Nombre del producto
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    class="form-control @error('nombre') is-invalid @enderror"
                    value="{{ old('nombre') }}"
                    maxlength="100"
                >

                @error('nombre')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="precio" class="form-label">Precio</label>

                <input
                    type="number"
                    id="precio"
                    name="precio"
                    class="form-control @error('precio') is-invalid @enderror"
                    value="{{ old('precio') }}"
                    placeholder="Ej. 500.00"
                    min="0"
                    step="0"
                    required
                >

                @error('precio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary">
                    Guardar producto
                </button>

                <a href="{{ route('productos.index') }}"
                   class="btn btn-outline-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection