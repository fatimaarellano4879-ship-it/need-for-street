
@extends('layouts.app')

@section('title', 'Inicio | NEED FOR STREET')

@section('content')
    <div class="nfs-card">
        <h1 class="display-5 fw-bold">NEED FOR STREET</h1>

        <p class="text-secondary">
            Sistema de gestión y venta de productos.
        </p>

        <a href="{{ route('productos.index') }}" class="btn btn-primary">
            Ver productos
        </a>

        <a href="{{ route('productos.create') }}"
           class="btn btn-outline-primary ms-2">
            Registrar producto
        </a>
    </div>
@endsection
