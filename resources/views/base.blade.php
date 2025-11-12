<!DOCTYPE html>
<html lang="es" style="width: 100%; height: 100%;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <!-- Sidebar -->
    <aside style="
    flex:0 0 250px; width:250px;
    display:flex; flex-direction:column;
    border-right:10px solid #CCE54F;
    background-color:#152039; color:#ffffff;
    position:sticky; top:0; height:100vh; overflow:auto;
    box-sizing:border-box;
    ">
    <!-- Logo -->
    <div style="margin-bottom:20px;">
        <img src='{{ asset("img/logo-emi.png") }}' alt="Logo" style="width:85%; padding:30px 20px 20px 20px;">
    </div>

    <!-- CONFIGURACIÓN -->
    <div class="menu-item">
        <a href="#" class="menu-toggle" style="display:flex; align-items:center; text-decoration:none; color:#ffffff; font-size:18px; padding:10px 20px;">
        <i class="fa-solid fa-gear" style="padding-right:10px;font-size: 17px;"></i>Configuración
        <i class="fa-solid fa-chevron-down" style="margin-left:auto;"></i>
        </a>
        <div class="submenu" style="display:none; margin-left:25px; font-size:16px;">
        <a href="#" style="display:block; color:#ffffff; text-decoration:none; margin:10px 0 10px 10px;font-size: 17px;"><i class="fa-solid fa-diagram-project" style="padding-right:8px;"></i>Dominio</a>
        <a href="#" style="display:block; color:#ffffff; text-decoration:none; margin:10px 0 10px 10px;font-size: 17px;"><i class="fa-solid fa-diagram-next" style="padding-right:8px;"></i>Subdominio</a>
        <a href="#" style="display:block; color:#ffffff; text-decoration:none; margin:10px 0 10px 10px;font-size: 17px;"><i class="fa-solid fa-screwdriver-wrench" style="padding-right:8px;"></i>Gestión</a>
        <a href="#" style="display:block; color:#ffffff; text-decoration:none; margin:10px 0 10px 10px;font-size: 17px;"><i class="fa-solid fa-users" style="padding-right:8px;"></i>Usuarios</a>
        <a href="#" style="display:block; color:#ffffff; text-decoration:none; margin:10px 0 10px 10px;font-size: 17px;"><i class="fa-solid fa-user-shield" style="padding-right:8px;"></i>Roles</a>
        <a href="#" style="display:block; color:#ffffff; text-decoration:none; margin:10px 0 10px 10px;font-size: 17px;"><i class="fa-solid fa-key" style="padding-right:8px;"></i>Privilegios</a>
        </div>
    </div>

    <!-- ADMINISTRACIÓN -->
    <div class="menu-item">
        <a href="#" class="menu-toggle" style="display:flex; align-items:center; text-decoration:none; color:#ffffff; font-size:18px; padding:10px 20px;">
        <i class="fa-solid fa-building-columns" style="padding-right:10px;font-size: 17px;"></i>Administración
        <i class="fa-solid fa-chevron-down" style="margin-left:auto;"></i>
        </a>
        <div class="submenu" style="display:none; margin-left:25px; font-size:16px;">
        <a href="#" style="display:block; color:#ffffff; text-decoration:none; margin:10px 0 10px 10px;font-size: 17px;"><i class="fa-solid fa-school" style="padding-right:8px;"></i>Unidad Académica</a>
        <a href="#" style="display:block; color:#ffffff; text-decoration:none; margin:10px 0 10px 10px;font-size: 17px;"><i class="fa-solid fa-building" style="padding-right:8px;"></i>Departamentos / Facultades</a>
        <a href="#" style="display:block; color:#ffffff; text-decoration:none; margin:10px 0 10px 10px;font-size: 17px;"><i class="fa-solid fa-book-open" style="padding-right:8px;"></i>Programa</a>
        <a href="#" style="display:block; color:#ffffff; text-decoration:none; margin:10px 0 10px 10px;font-size: 17px;"><i class="fa-solid fa-graduation-cap" style="padding-right:8px;"></i>Curso</a>
        <a href="#" style="display:block; color:#ffffff; text-decoration:none; margin:10px 0 10px 10px;font-size: 17px;"><i class="fa-solid fa-bullseye" style="padding-right:8px;"></i>Competencia</a>
        </div>
    </div>

    <!-- CARGA -->
    <a href="#" style="margin:10px 20px; text-decoration:none; color:#ffffff; font-size:18px; display:flex; align-items:center;">
        <i class="fa-solid fa-upload" style="padding-right:10px;font-size: 17px;"></i>Carga
    </a>

    <!-- REPORTES -->
    <a href="#" style="margin:10px 20px; text-decoration:none; color:#ffffff; font-size:18px; display:flex; align-items:center;">
        <i class="fa-solid fa-chart-line" style="padding-right:10px;font-size: 17px;"></i>Reportes
    </a>
    </aside>

    <!-- JS PARA DESPLEGAR SUBMENÚS -->
    <script>
    document.querySelectorAll('.menu-toggle').forEach(toggle => {
        toggle.addEventListener('click', e => {
        e.preventDefault();
        const submenu = toggle.nextElementSibling;
        const icon = toggle.querySelector('.fa-chevron-down');
        const isVisible = submenu.style.display === 'block';
        
        // Cierra todos los demás submenús
        document.querySelectorAll('.submenu').forEach(s => s.style.display = 'none');
        document.querySelectorAll('.menu-toggle .fa-chevron-down').forEach(i => i.style.transform = 'rotate(0deg)');
        
        // Alterna el actual
        submenu.style.display = isVisible ? 'none' : 'block';
        icon.style.transform = isVisible ? 'rotate(0deg)' : 'rotate(180deg)';
        icon.style.transition = 'transform 0.3s ease';
        });
    });
    </script>



    <!-- Contenido principal -->
    <div style="flex-grow: 1; padding: 20px;">
        @yield('content')
    </div>
    <main class="content">
        @yield('content')
    </main>
</body>
</html>
