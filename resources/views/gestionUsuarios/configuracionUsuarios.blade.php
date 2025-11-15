@extends('base')

@section('content')
  <link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">

  <div class="dominio-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
      <h1 class="dominio-title" style="margin: 0;">Gestión de Usuarios</h1>
      <button type="button" class="btn btn-primary" onclick="abrirModalNuevo()">
        + Agregar Usuario
      </button>
    </div>

    @if(session('success'))
      <div class="alert alert-success">
        <span class="alert-icon">✓</span>
        <span>{{ session('success') }}</span>
      </div>
    @endif

    <h2 class="section-title">Lista de Usuarios Registrados</h2>

    @if($usuarios->count() > 0)
      <div style="overflow-x: auto;">
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Código Persona</th>
              <th>Nombre Completo</th>
              <th>Email</th>
              <th>Género</th>
              <th>Celular</th>
              <th>Cargo</th>
              <th style="text-align: center;">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($usuarios as $usuario)
              <tr>
                <td>{{ $usuario->id_persona }}</td>
                <td>{{ $usuario->cod_persona }}</td>
                <td>{{ $usuario->nombres }} {{ $usuario->apellidos }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->genero ?? '-' }}</td>
                <td>{{ $usuario->celular ?? '-' }}</td>
                <td>{{ $usuario->cargoPersona->cargo->nombre_cargo ?? 'Sin asignar' }}</td>
                <td style="text-align: center;">
                  <div style="display: flex; gap: 0.5rem; justify-content: center;">
                    <button type="button" class="btn btn-success btn-sm"
                      onclick="editarUsuario({{ $usuario->id_persona }}, '{{ $usuario->nombres }}', '{{ $usuario->apellidos }}', '{{ $usuario->email }}', '{{ $usuario->genero }}', '{{ $usuario->celular }}', '{{ $usuario->cod_persona }}', {{  $usuario->cargoPersona->cargo->id_cargo ?? 'null' }})">
                      Editar
                    </button>
                    <form action="{{ route('usuarios.destroy', $usuario->id_persona) }}" method="POST"
                      style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este usuario?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">
                        Eliminar
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <div class="empty-state">
        <div class="empty-state-icon">👥</div>
        <div class="empty-state-title">No hay usuarios registrados</div>
        <p>Comience creando un nuevo usuario usando el botón "Agregar Usuario".</p>
      </div>
    @endif
  </div>

  {{-- Modal de Nuevo Usuario --}}
  <div id="modalNuevoUsuario" class="modal-overlay">
    <div class="modal-content-wrapper" style="max-width: 700px;">
      <button onclick="cerrarModalNuevo()" class="modal-close">&times;</button>
      <h2 class="section-title" style="margin-top: 0;">Nuevo Usuario</h2>
      <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div class="form-group">
          <label for="nombres" class="form-label">Nombres</label>
          <input type="text" id="nombres" name="nombres" class="form-input" placeholder="Ingrese los nombres"
            value="{{ old('nombres') }}" required>
          @error('nombres')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="apellidos" class="form-label">Apellidos</label>
          <input type="text" id="apellidos" name="apellidos" class="form-input" placeholder="Ingrese los apellidos"
            value="{{ old('apellidos') }}" required>
          @error('apellidos')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="email" class="form-label">Email</label>
          <input type="email" id="email" name="email" class="form-input" placeholder="usuario@dominio.com"
            value="{{ old('email') }}" required>
          @error('email')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="genero" class="form-label">Género</label>
          <select id="genero" name="genero" class="form-select">
            <option value="">Seleccione</option>
            <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
          </select>
          @error('genero')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="celular" class="form-label">Celular</label>
          <input type="text" id="celular" name="celular" class="form-input" placeholder="70000000"
            value="{{ old('celular') }}" pattern="^\d{6,15}$">
          @error('celular')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="cod_persona" class="form-label">Código de Persona</label>
          <input type="text" id="cod_persona" name="cod_persona" class="form-input"
            placeholder="Ingrese el código de persona" maxlength="20" value="{{ old('cod_persona') }}" required>
          @error('cod_persona')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="id_cargo" class="form-label">Cargo</label>
          <select id="id_cargo" name="id_cargo" class="form-select">
            <option value="">Sin cargo</option>
            @foreach($cargos as $cargo)
              <option value="{{ $cargo->id_cargo }}" {{ old('id_cargo') == $cargo->id_cargo ? 'selected' : '' }}>
                {{ $cargo->nombre_cargo }}
              </option>
            @endforeach
          </select>
          @error('id_cargo')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
        <div class="btn-group">
          <button type="submit" class="btn btn-primary">Registrar Usuario</button>
          <button type="button" class="btn btn-secondary" onclick="cerrarModalNuevo()">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal de Edición --}}
  <div id="modalEditUsuario" class="modal-overlay">
    <div class="modal-content-wrapper" style="max-width: 700px;">
      <button onclick="cerrarModal()" class="modal-close">&times;</button>
      <h2 class="section-title" style="margin-top: 0;">Editar Usuario</h2>
      <form id="formEditUsuario" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label for="edit_nombres" class="form-label">Nombres</label>
          <input type="text" id="edit_nombres" name="nombres" class="form-input" required>
        </div>
        <div class="form-group">
          <label for="edit_apellidos" class="form-label">Apellidos</label>
          <input type="text" id="edit_apellidos" name="apellidos" class="form-input" required>
        </div>
        <div class="form-group">
          <label for="edit_email" class="form-label">Email</label>
          <input type="email" id="edit_email" name="email" class="form-input" required>
        </div>
        <div class="form-group">
          <label for="edit_genero" class="form-label">Género</label>
          <select id="edit_genero" name="genero" class="form-select">
            <option value="">Seleccione</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
          </select>
        </div>
        <div class="form-group">
          <label for="edit_celular" class="form-label">Celular</label>
          <input type="text" id="edit_celular" name="celular" class="form-input" pattern="^\d{6,15}$">
        </div>
        <div class="form-group">
          <label for="edit_cod_persona" class="form-label">Código de Persona</label>
          <input type="text" id="edit_cod_persona" name="cod_persona" class="form-input" maxlength="20" required>
        </div>
        <div class="form-group">
          <label for="edit_id_cargo" class="form-label">Cargo</label>
          <select id="edit_id_cargo" name="id_cargo" class="form-select">
            <option value="">Sin cargo</option>
            @foreach($cargos as $cargo)
              <option value="{{ $cargo->id_cargo }}">{{ $cargo->nombre_cargo }}</option>
            @endforeach
          </select>
        </div>
        <div class="btn-group">
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Funciones para modal de nuevo usuario
    function abrirModalNuevo() {
      document.getElementById('modalNuevoUsuario').classList.add('show');
    }

    function cerrarModalNuevo() {
      document.getElementById('modalNuevoUsuario').classList.remove('show');
    }

    // Funciones para modal de edición
    function editarUsuario(id, nombres, apellidos, email, genero, celular, codPersona, idCargo) {
      const modal = document.getElementById('modalEditUsuario');
      const form = document.getElementById('formEditUsuario');

      form.action = '{{ url("/usuarios") }}/' + id;
      document.getElementById('edit_nombres').value = nombres;
      document.getElementById('edit_apellidos').value = apellidos;
      document.getElementById('edit_email').value = email;
      document.getElementById('edit_genero').value = genero || '';
      document.getElementById('edit_celular').value = celular || '';
      document.getElementById('edit_cod_persona').value = codPersona || '';
      document.getElementById('edit_id_cargo').value = idCargo || '';

      modal.classList.add('show');
    }

    function cerrarModal() {
      document.getElementById('modalEditUsuario').classList.remove('show');
    }

    // Cerrar modales al hacer clic fuera
    document.getElementById('modalEditUsuario').addEventListener('click', function (e) {
      if (e.target === this) {
        cerrarModal();
      }
    });

    document.getElementById('modalNuevoUsuario').addEventListener('click', function (e) {
      if (e.target === this) {
        cerrarModalNuevo();
      }
    });

    // Cerrar modales con tecla Escape
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        cerrarModal();
        cerrarModalNuevo();
      }
    });

    // Abrir modal automáticamente si hay errores de validación
    @if($errors->any() && !request()->route()->parameter('usuario'))
      abrirModalNuevo();
    @endif
  </script>

@endsection