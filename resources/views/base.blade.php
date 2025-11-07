<!DOCTYPE html>
<html lang="es" style="width:100%;height:100%;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body style="margin:0;">

  <!-- Wrapper del layout -->
  <div style="display:flex; min-height:100vh; width:100%;">

    <!-- Sidebar -->
    <aside style="
      flex:0 0 250px; width:250px;
      display:flex; flex-direction:column;
      border-right:10px solid #CCE54F;
      background-color:#152039; color:#ffffff;
      position:sticky; top:0; height:100vh; overflow:auto;
      box-sizing:border-box;">
      
      <!-- Logo -->
      <div style="margin-bottom:20px;">
        <img src='{{ asset("img/logo-emi.png") }}' alt="Logo" style="width:85%; padding:30px 20px 20px 20px;">
      </div>

      <!-- Links -->
      <a href="#" style="margin-bottom:10px; text-decoration:none; padding:17px 5px 10px 21px; color:#ffffff; font-size:18px;">
        <i class="fa-solid fa-building" style="padding-right:10px;"></i>Departamentos
      </a>
      <a href="#" style="margin-bottom:10px; text-decoration:none; padding:17px 5px 10px 21px; color:#ffffff; font-size:18px;">
        <i class="fa-solid fa-book-open" style="padding-right:10px;"></i>Programas
      </a>
      <a href="#" style="margin-bottom:10px; text-decoration:none; padding:17px 5px 10px 21px; color:#ffffff; font-size:18px;">
        <i class="fa-solid fa-graduation-cap" style="padding-right:10px;"></i>Curso
      </a>
      <a href="#" style="margin-bottom:10px; text-decoration:none; padding:17px 5px 10px 21px; color:#ffffff; font-size:18px;">
        <i class="fa-solid fa-bullseye" style="padding-right:10px;"></i>Competencias
      </a>
      <a href="#" style="margin-bottom:10px; text-decoration:none; padding:17px 5px 10px 21px; color:#ffffff; font-size:18px;">
        <i class="fa-solid fa-layer-group" style="padding-right:10px;"></i>Area
      </a>
      <a href='{{ route("dominioSubdominio") }}' style="margin-bottom:10px; text-decoration:none; padding:17px 5px 10px 21px; color:#ffffff; font-size:18px;">
        <i class="fa-solid fa-diagram-project" style="padding-right:10px;"></i>Dominio y Subdomino
      </a>
    </aside>

    <!-- Contenido principal -->
    <main style="flex:1 1 auto; min-width:0; padding:20px; overflow:auto;">
      @yield('content')
    </main>

  </div>

</body>
</html>
