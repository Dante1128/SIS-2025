<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>

<div style="display: flex; height: 100vh;">

    <!-- Sidebar -->
    <div style="width: 250px; display: flex; flex-direction: column;border-right: 10px solid #CCE54F;background-color: #152039;color:#ffffff">
        <!-- Imagen superior -->
        <div style="margin-bottom: 20px;">
            <img src="{{ asset('img/logo-emi.png') }}" alt="Logo" style="width: 85%; padding:30px 20px 20px 20px;">
        </div>

        <!-- Links -->
    
        <a href="#" style="margin-bottom: 10px;text-decoration: none;padding: 17px 5px 10px 21px;color:#ffffff;font-size:18px;"><i class="fa-solid fa-building" style="padding-right:10px;"></i>Departamentos</a>
        <a href="#" style="margin-bottom: 10px;text-decoration: none;padding: 17px 5px 10px 21px;color:#ffffff;font-size:18px;"><i class="fa-solid fa-book-open" style="padding-right:10px;"></i>Programas</a>
        <a href="#" style="margin-bottom: 10px;text-decoration: none;padding: 17px 5px 10px 21px;color:#ffffff;font-size:18px;"><i class="fa-solid fa-graduation-cap" style="padding-right:10px;"></i>Curso</a>
        <a href="#" style="margin-bottom: 10px;text-decoration: none;padding: 17px 5px 10px 21px;color:#ffffff;font-size:18px;"><i class="fa-solid fa-bullseye" style="padding-right:10px;"></i>Competencias</a>
        <a href="#" style="margin-bottom: 10px;text-decoration: none;padding: 17px 5px 10px 21px;color:#ffffff;font-size:18px;"><i class="fa-solid fa-layer-group" style="padding-right:10px;"></i>Area</a>
        <a href="{{ route('dominioSubdominio') }}" style="margin-bottom: 10px;padding: 17px 5px 10px 21px;;text-decoration: none;color:#ffffff;font-size:18px;"><i class="fa-solid fa-diagram-project" style="padding-right:10px;"></i>Dominio y Subdomino</a>
    </div>

    <!-- Contenido principal -->
    <div style="flex-grow: 1; padding: 20px;">
        @yield('content')
    </div>

</div>

</body>
</html>
