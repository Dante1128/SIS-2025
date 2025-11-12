@extends('base')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="/css/usuarios.css" rel="stylesheet">

<div class="container py-4 bg-emi">
  <div class="headline">
    <h2>Gestión de Usuarios</h2>
  </div>

  <div class="row g-4">
    <!-- Card: Nuevo Usuario -->
    <div class="col-12 row-4">
      <div class="card-emi p-4">
        <h5 class="card-title mb-3">Nuevo Usuario</h5>

        <form action="{{ route('usuarios.store') }}" method="POST" class="row g-3 needs-validation" novalidate>
          @csrf

          <div class="col-md-6">
            <label class="form-label">Nombres *</label>
            <input type="text" name="nombres" class="form-control" placeholder="Ej. Juan Carlos" required>
            <div class="invalid-feedback">Campo requerido.</div>
          </div>

          <div class="col-md-6">
            <label class="form-label">Apellidos *</label>
            <input type="text" name="apellidos" class="form-control" placeholder="Ej. Pérez López" required>
            <div class="invalid-feedback">Campo requerido.</div>
          </div>

          <div class="col-md-6">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control" placeholder="usuario@dominio.com" required>
            <div class="invalid-feedback">Email inválido.</div>
          </div>

          <div class="col-md-3">
            <label class="form-label">Género</label>
            <select name="genero" class="form-select">
              <option value="">Seleccione</option>
              <option>Masculino</option>
              <option>Femenino</option>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label">Celular</label>
            <input type="text" name="celular" class="form-control" placeholder="70000000" pattern="^\d{6,15}$">
            <div class="form-text form-text-hint">Solo números, 6–15 dígitos.</div>
          </div>

          <div class="col-md-6">
            <label class="form-label">Cargo</label>
            <select name="id_cargo" class="form-select">
            <option value="">Sin cargo</option>
            @foreach($cargos as $cargo)
              <option value="{{ $cargo->id_cargo }}" {{ old('id_cargo') == $cargo->id_cargo ? 'selected' : '' }}>
                {{ $cargo->nombre_cargo }}
              </option>
            @endforeach
          </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Rol</label>
            <select name="id_rol" class="form-select" required>
              <option value="">Seleccione un rol</option>
              @foreach($roles as $rol)
                <option value="{{ $rol->id_rol }}" {{ old('id_rol') == $rol->id_rol ? 'selected' : '' }}>
                  {{ $rol->nombre_rol }}
                </option>
              @endforeach
            </select>

          </div>

          <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-emi"><i class="bi bi-check2-circle me-1"></i> Registrar Usuario</button>
            <a href="{{ route('usuarios.listado') }}" class="btn btn-outline-secondary"><i class="bi bi-list-ul me-1"></i> Ver Listado</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Tabla -->
    <div class="col-12">
      <div class="card-emi p-4">
        <h5 class="card-title mb-3">Lista de Usuarios Registrados</h5>
        <div class="table-responsive">
          <table class="table table-emi align-middle mb-0" id="tablaUsuarios">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Email</th>
                <th>Género</th>
                <th>Celular</th>
                <th>Cargo</th>
                <th>Rol</th>
                <th class="actions-col">Acciones</th>
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
                <td><span class="badge badge-role">{{ $usuario->rol->nombre_rol ?? 'Sin asignar' }}</span></td>
                <td>
                  <div class="d-flex gap-2">
                    <button type="button" class="btn btn-warning btn-sm"
                      data-bs-toggle="modal" data-bs-target="#editarUsuarioModal"
                      data-id="{{ $usuario->id_persona }}"
                      data-nombres="{{ $usuario->nombres }}"
                      data-apellidos="{{ $usuario->apellidos }}"
                      data-email="{{ $usuario->email }}"
                      data-genero="{{ $usuario->genero }}"
                      data-celular="{{ $usuario->celular }}"
                      data-id_cargo="{{ $usuario->id_cargo }}"
                      data-id_rol="{{ $usuario->id_rol }}">
                      <i class="bi bi-pencil-square"></i> Editar
                    </button>

                    <form action="{{ route('usuarios.destroy', $usuario->id_persona) }}" method="POST" class="d-inline">
                      @csrf @method('DELETE')
                      <button class="btn btn-danger btn-sm" data-confirm="¿Eliminar este usuario?">
                        <i class="bi bi-trash"></i> Eliminar
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-1">
      <form id="formEditarUsuario" method="POST" class="needs-validation" novalidate>
        @csrf @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editarUsuarioLabel">Editar Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_persona" id="edit_id_persona">

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nombres *</label>
              <input type="text" name="nombres" id="edit_nombres" class="form-control" required>
              <div class="invalid-feedback">Requerido.</div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Apellidos *</label>
              <input type="text" name="apellidos" id="edit_apellidos" class="form-control" required>
              <div class="invalid-feedback">Requerido.</div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email *</label>
              <input type="email" name="email" id="edit_email" class="form-control" required>
              <div class="invalid-feedback">Email inválido.</div>
            </div>
            <div class="col-md-3">
              <label class="form-label">Género</label>
              <select name="genero" id="edit_genero" class="form-select">
                <option value="">Seleccione</option>
                <option>Masculino</option>
                <option>Femenino</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Celular</label>
              <input type="text" name="celular" id="edit_celular" class="form-control" pattern="^\d{6,15}$">
            </div>
            <div class="col-md-6">
              <label class="form-label">Cargo</label>
              <select name="id_cargo" id="edit_id_cargo" class="form-select">
                <option value="">Seleccione un cargo</option>
                @foreach($cargos as $cargo)
                  <option value="{{ $cargo->id_cargo }}">{{ $cargo->nombre_cargo }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Rol</label>
              <select name="id_rol" id="edit_id_rol" class="form-select">
                <option value="">Seleccione un rol</option>
                @foreach($roles as $rol)
                  <option value="{{ $rol->id_rol }}">{{ $rol->nombre_rol }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-emi">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/usuarios.js"></script>
@endsection
