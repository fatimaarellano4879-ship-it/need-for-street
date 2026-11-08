
@extends('layouts.app')

@section('title', 'Editar producto | NEED FOR STREET')

@section('content')
    <div class="nfs-page-heading">
        <h1 class="h3 fw-bold">Editar producto</h1>
        <p class="text-secondary">
            Modifica la información del producto seleccionado.
        </p>
    </div>

    <div class="nfs-card">
        <form action="{{ route('productos.update', $producto) }}"
              method="POST">
            @csrf
            @method('PUT')     
            
            <div class="mb-3">
                <label for="nombre" class="form-label">
                    Nombre del producto
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    class="form-control @error('nombre') is-invalid @enderror"
                    value="{{ old('nombre', $producto->nombre) }}"
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
                    value="{{ old('precio', $producto->precio) }}"
                    min="0"
                    step="0"
                    required
                >

                @error('precio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Guardar cambios
            </button>

            <a href="{{ route('productos.index') }}"
               class="btn btn-outline-secondary">
                Cancelar
            </a>
        </form>
    </div>
@endsection
