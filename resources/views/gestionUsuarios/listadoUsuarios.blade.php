@extends('base')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Listado de Usuarios</h2>
        <a href="{{ route('usuarios.configuracion') }}" class="btn btn-primary">
            Configuración de gestión de usuarios
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
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
@endsection
