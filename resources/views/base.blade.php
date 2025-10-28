<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Simple</title>
</head>
<body>

<div style="display: flex; height: 100vh;">

    <!-- Sidebar -->
    <div style="width: 200px; display: flex; flex-direction: column; border-right: 1px solid #000; padding: 10px;">
        <!-- Imagen superior -->
        <div style="margin-bottom: 20px;">
            <img src="{{ asset('img/logo-emi.png') }}" alt="Logo" style="width: 100%;">
        </div>

        <!-- Links -->
        <a href="#" style="margin-bottom: 10px;">Departamentos</a>
        <a href="#" style="margin-bottom: 10px;">Programas</a>
        <a href="#" style="margin-bottom: 10px;">Curso</a>
        <a href="#" style="margin-bottom: 10px;">Competencias</a>
        <a href="#" style="margin-bottom: 10px;">Area</a>
    </div>

    <!-- Contenido principal -->
    <div style="flex-grow: 1; padding: 20px;">
        @yield('content')
    </div>

</div>

</body>
</html>
