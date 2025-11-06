<!DOCTYPE html>
<html lang="es" style="width: 100%; height: 100%;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            background-color: #f4f6f9;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 20%;
            background-color: #152039;
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px 0;
            text-align: center;
        }

        .sidebar img {
            width: 80%;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            width: 100%;
            padding: 0;
        }

        .sidebar a {
            display: block;
            text-decoration: none;
            color: #ffffff;
            padding: 15px 20px;
            margin: 5px 10px;
            font-size: 16px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .sidebar a:hover {
            background-color: #1f2d4d;
        }

        /* Content */
        .content {
            margin-left: 20%;
            width: 80%;
            padding: 20px;
            overflow-y: auto;
            height: 100vh;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav>
            <img src="{{ asset('img/logo-emi.png') }}" alt="Logo">
            <ul>
                <li><a href="#">Departamentos</a></li>
                <li><a href="#">Programas</a></li>
                <li><a href="#">Curso</a></li>
                <li><a href="#">Competencias</a></li>
                <li><a href="#">Área</a></li>
                <li><a href="{{ route('dominioSubdominio') }}">Dominio y Subdominio</a></li>
                <li><a href="{{ route('gestiones.index') }}">Gestión</a></li>
            </ul>
        </nav>
    </aside>

    <main class="content">
        @yield('content')
    </main>

</body>

</html>
