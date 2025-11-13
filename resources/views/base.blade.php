<!DOCTYPE html>
<html lang="es" class="html-full">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inicio</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/base.css">

</head>

<body class="body-layout">
    <aside class="sidebar">
        <div class="sidebar-logo-container">
            <img src='{{ asset("img/logo-emi.png") }}' alt="Logo" class="sidebar-logo">
        </div>

        <div class="menu-item">
            <a href="#" class="menu-toggle menu-link">
                <i class="fa-solid fa-gear menu-icon"></i>Configuración
                <i class="fa-solid fa-chevron-down submenu-toggle-icon"></i>
            </a>
            <div class="submenu submenu-hidden">
                <a href="{{ route("dominioSubdominio") }}" class="submenu-link"><i
                        class="fa-solid fa-diagram-project submenu-icon"></i>Dominio / Subdominio</a>
                <a href="{{ route("gestiones.index") }}" class="submenu-link"><i
                        class="fa-solid fa-screwdriver-wrench submenu-icon"></i>Gestión</a>
                <a href="#" class="submenu-link"><i class="fa-solid fa-users submenu-icon"></i>Usuarios</a>
                <a href="#" class="submenu-link"><i class="fa-solid fa-user-shield submenu-icon"></i>Roles</a>
                <a href="#" class="submenu-link"><i class="fa-solid fa-key submenu-icon"></i>Privilegios</a>
            </div>
        </div>

        <div class="menu-item">
            <a href="#" class="menu-toggle menu-link">
                <i class="fa-solid fa-building-columns menu-icon"></i>Administración
                <i class="fa-solid fa-chevron-down submenu-toggle-icon"></i>
            </a>
            <div class="submenu submenu-hidden">
                <a href="#" class="submenu-link"><i class="fa-solid fa-school submenu-icon"></i>Unidad Académica</a>
                <a href="#" class="submenu-link"><i class="fa-solid fa-building submenu-icon"></i>Departamentos /
                    Facultades</a>
                <a href="#" class="submenu-link"><i class="fa-solid fa-book-open submenu-icon"></i>Programa</a>
                <a href="#" class="submenu-link"><i class="fa-solid fa-graduation-cap submenu-icon"></i>Curso</a>
                <a href="#" class="submenu-link"><i class="fa-solid fa-bullseye submenu-icon"></i>Competencia</a>
            </div>
        </div>

        <a href="#" class="sidebar-link-standalone">
            <i class="fa-solid fa-upload menu-icon"></i>Carga
        </a>

        <a href="#" class="sidebar-link-standalone">
            <i class="fa-solid fa-chart-line menu-icon"></i>Reportes
        </a>
    </aside>

    <script>
        document.querySelectorAll('.menu-toggle').forEach(toggle => {
            toggle.addEventListener('click', e => {
                e.preventDefault();
                const submenu = toggle.nextElementSibling;
                const icon = toggle.querySelector('.fa-chevron-down');
                // Usamos clases para gestionar el estado visible/oculto
                const isVisible = submenu.classList.contains('submenu-visible');

                // Cierra todos los demás submenús
                document.querySelectorAll('.submenu-visible').forEach(s => s.classList.replace('submenu-visible', 'submenu-hidden'));
                document.querySelectorAll('.menu-toggle .fa-chevron-down').forEach(i => i.style.transform = 'rotate(0deg)');

                // Alterna el actual
                if (isVisible) {
                    submenu.classList.replace('submenu-visible', 'submenu-hidden');
                    icon.style.transform = 'rotate(0deg)';
                } else {
                    submenu.classList.replace('submenu-hidden', 'submenu-visible');
                    icon.style.transform = 'rotate(180deg)';
                }
                icon.style.transition = 'transform 0.3s ease';
            });
        });
    </script>

    <div class="main-content-container">
        @yield('content')
    </div>
    <main class="content">
        @yield('content')
    </main>
</body>

</html>