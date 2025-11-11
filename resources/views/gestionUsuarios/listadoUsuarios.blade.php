@extends('base')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="/css/usuarios.css" rel="stylesheet">

<div class="container py-4 bg-emi">
  <div class="d-flex justify-content-between align-items-center mb-3 headline">
    <h2>Listado de Usuarios</h2>
    <a href="{{ route('usuarios.configuracion') }}" class="btn btn-emi">Gestión de Usuarios</a>
  </div>

  <div class="card-emi p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="card-title mb-0">Usuarios</h5>
      <input type="search" class="form-control" style="max-width:320px"
             placeholder="Buscar..." data-table-search="#tablaListado">
    </div>

    <div class="table-responsive">
      <table class="table table-emi align-middle mb-0" id="tablaListado">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre Completo</th>
            <th>Email</th>
            <th>Género</th>
            <th>Celular</th>
            <th>Cargo</th>
            <th>Rol</th>
          </tr>
        </thead>
        <tbody>
          @foreach($usuarios as $usuario)
          <tr>
            <td>{{ $usuario->id_persona }}</td>
            <td>{{ $usuario->nombres }} {{ $usuario->apellidos }}</td>
            <td>{{ $usuario->email }}</td>
            <td>{{ $usuario->genero }}</td>
            <td>{{ $usuario->celular }}</td>
            <td>{{ $usuario->cargo->nombre_cargo ?? 'Sin asignar' }}</td>
            <td>{{ $usuario->rol->nombre_rol ?? 'Sin asignar' }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/usuarios.js"></script>
@endsection
