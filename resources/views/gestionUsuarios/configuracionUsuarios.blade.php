@extends('base')

@section('content')
<div class="container">
    <h2 class="mb-4">Configuración de Usuarios</h2>

    {{-- Formulario de creación --}}
    <form action="{{ route('usuarios.store') }}" method="POST" class="mb-5">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nombres</label>
                <input type="text" name="nombres" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Apellidos</label>
                <input type="text" name="apellidos" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Género</label>
                <select name="genero" class="form-control">
                    <option value="">Seleccione</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Celular</label>
                <input type="text" name="celular" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Cargo</label>
                <select name="id_cargo" class="form-control">
                    <option value="">Seleccione un cargo</option>
                    @foreach($cargos as $cargo)
                        <option value="{{ $cargo->id_cargo }}">{{ $cargo->nombre_cargo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Rol</label>
                <select name="id_rol" class="form-control">
                    <option value="">Seleccione un rol</option>
                    @foreach($roles as $rol)
                        <option value="{{ $rol->id_rol }}">{{ $rol->nombre_rol }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Guardar Usuario</button>
        <a href="{{ route('usuarios.listado') }}" class="btn btn-secondary">Volver</a>
    </form>

    {{-- Tabla de usuarios --}}
    <h4>Lista de Usuarios Registrados</h4>
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Email</th>
                <th>Género</th>
                <th>Celular</th>
                <th>Cargo</th>
                <th>Rol</th>
                <th>Acciones</th>
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
                    <td>
                        {{-- Botón editar --}}
                        <button type="button" class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editarUsuarioModal"
                                data-id="{{ $usuario->id_persona }}"
                                data-nombres="{{ $usuario->nombres }}"
                                data-apellidos="{{ $usuario->apellidos }}"
                                data-email="{{ $usuario->email }}"
                                data-genero="{{ $usuario->genero }}"
                                data-celular="{{ $usuario->celular }}"
                                data-id_cargo="{{ $usuario->id_cargo }}"
                                data-id_rol="{{ $usuario->id_rol }}">
                            Editar
                        </button>

                        {{-- Formulario eliminar --}}
                        <form action="{{ route('usuarios.destroy', $usuario->id_persona) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" 
                                    onclick="return confirm('¿Eliminar este usuario?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal para editar usuario --}}
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditarUsuario" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header bg-warning">
          <h5 class="modal-title" id="editarUsuarioLabel">Editar Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_persona" id="edit_id_persona">

          <div class="mb-3">
            <label class="form-label">Nombres</label>
            <input type="text" name="nombres" id="edit_nombres" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Apellidos</label>
            <input type="text" name="apellidos" id="edit_apellidos" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" id="edit_email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Género</label>
            <select name="genero" id="edit_genero" class="form-control">
                <option value="">Seleccione</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Celular</label>
            <input type="text" name="celular" id="edit_celular" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Cargo</label>
            <select name="id_cargo" id="edit_id_cargo" class="form-control">
                <option value="">Seleccione un cargo</option>
                @foreach($cargos as $cargo)
                    <option value="{{ $cargo->id_cargo }}">{{ $cargo->nombre_cargo }}</option>
                @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Rol</label>
            <select name="id_rol" id="edit_id_rol" class="form-control">
                <option value="">Seleccione un rol</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol->id_rol }}">{{ $rol->nombre_rol }}</option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-warning">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Script para llenar el modal --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    var editarModal = document.getElementById('editarUsuarioModal');

    if (editarModal) {
        editarModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            if (!button) return;

            var id = button.getAttribute('data-id');
            var nombres = button.getAttribute('data-nombres');
            var apellidos = button.getAttribute('data-apellidos');
            var email = button.getAttribute('data-email');
            var genero = button.getAttribute('data-genero');
            var celular = button.getAttribute('data-celular');
            var id_cargo = button.getAttribute('data-id_cargo');
            var id_rol = button.getAttribute('data-id_rol');

            // Llenar campos
            document.getElementById('edit_id_persona').value = id;
            document.getElementById('edit_nombres').value = nombres;
            document.getElementById('edit_apellidos').value = apellidos;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_genero').value = genero;
            document.getElementById('edit_celular').value = celular;
            document.getElementById('edit_id_cargo').value = id_cargo;
            document.getElementById('edit_id_rol').value = id_rol;

            // Asignar action del formulario
            document.getElementById('formEditarUsuario').action = `/usuarios/${id}`;
        });
    }
});
</script>
@endsection
