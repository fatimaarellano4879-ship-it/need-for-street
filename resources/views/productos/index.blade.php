<!DOCTYPE html>
<html>
<head>
    <title>Productos - Need For Street</title>
</head>

<body>

<h1>Catálogo de productos</h1>

@if(session('success'))
    <p>
        {{ session('success') }}
    </p>
@endif

<table border="1">

<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Precio</th>
</tr>

@foreach($productos as $producto)

<tr>
    <td>{{ $producto->id }}</td>
    <td>{{ $producto->nombre }}</td>
    <td>${{ $producto->precio }}</td>
</tr>

@endforeach

</table>

<br>

<a href="/productos/crear">
Registrar producto
</a>

<a href="/">
    Regresar al inicio
</a>

</body>
</html>