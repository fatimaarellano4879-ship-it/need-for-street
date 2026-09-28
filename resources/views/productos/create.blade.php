<!DOCTYPE html>
<html>

<head>
    <title>Registrar producto</title>
</head>

<body>

<h1>Registrar producto</h1>


@if(session('success'))
    <p>
        {{ session('success') }}
    </p>
@endif


<form method="POST" action="/productos">

    @csrf

    <label>
        Nombre:
    </label>

    <input type="text" name="nombre">

    <br><br>


    <label>
        Precio:
    </label>

    <input type="number" name="precio">

    <br><br>


    <button type="submit">
        Guardar
    </button>

</form>


</body>

</html>