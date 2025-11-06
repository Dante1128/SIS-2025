<!DOCTYPE html>
<html lang="es" style="width: 100%; height: 100%;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>

<body style="width: 100%; height: 100%;">
    <div style="display: flex; height: 100%;">

        <!-- Sidebar -->
        <section
            style="width: 20%; background-color: #152039; height: 100%; display: flex; flex-direction: column; justify-content: space-between; padding-top: 20px; padding-bottom: 20px; align-items: center; margin: 0;">
            <!-- Imagen superior -->
            <nav
                style="display: flex; align-items: center; justify-content: start; flex-direction: column; width: 100%; height: 100%; padding: 0; margin: 0;">
                <img src="{{ asset('img/logo-emi.png') }}" alt="Logo"
                    style="width: 80%;display: flex;align-items: center; justify-content: center; padding: 10px;">
                <!-- Links -->
                <ul
                    style="display: flex; flex-direction: column; list-style-type: none; padding: 0; gap: 10px; width: 100%; align-items: center; justify-content: center;">
                    <a href="#" style="margin-bottom: 10px; text-decoration: none; color: #ffff;"><button type="button"
                            style="display: flex; align-items: center; gap: 10px; background-color: transparent; border: none; color: white; text-align: left; padding: 15px 20px; font-size: 16px; cursor: pointer; width: 95%;">Departamentos</button></a>
                    <a href="#" style="margin-bottom: 10px; text-decoration: none; color: #ffff;">Programas</a>
                    <a href="#" style="margin-bottom: 10px; text-decoration: none; color: #ffff;">Curso</a>
                    <a href="#" style="margin-bottom: 10px; text-decoration: none; color: #ffff;">Competencias</a>
                    <a href="#" style="margin-bottom: 10px; text-decoration: none; color: #ffff;">Area</a>
                    <a href="{{ route('dominioSubdominio') }}"
                        style="margin-bottom: 10px; text-decoration: none; color: #ffff;">Dominio y Subdomino</a>
                    <a href="{{ route('dominioSubdominio') }}"
                        style="margin-bottom: 10px; text-decoration: none; color: #ffff;">Gestión</a>
                </ul>
            </nav>
        </section>

        <!-- Contenido principal -->
        <div style="flex-grow: 1; padding: 20px;">
            @yield('content')
        </div>

    </div>

</body>

</html>