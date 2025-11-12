@extends('base')

@section('content')
<link rel="stylesheet" href="{{ asset('css/gestion.css') }}">

<div class="dominio-container">
    <h1 class="dominio-title">Gestión de Departamentos Académicos</h1>

    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="form-grid">
        <div class="card">
            <div class="card-header">
                <h2 class="section-title" style="margin: 0;">Nuevo Departamento</h2>
            </div>
            <form action="{{ route('departamentos.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre_departamento" class="form-label">Nombre del Departamento</label>
                    <input type="text" 
                           id="nombre_departamento" 
                           name="nombre_departamento" 
                           class="form-input" 
                           placeholder="Ingrese el nombre del departamento"
                           maxlength="100"
                           value="{{ old('nombre_departamento') }}"
                           required>
                    @error('nombre_departamento')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="desc_departamento" class="form-label">Descripción</label>
                    <textarea id="desc_departamento" 
                              name="desc_departamento" 
                              class="form-input" 
                              rows="2"
                              placeholder="Ingrese una breve descripción">{{ old('desc_departamento') }}</textarea>
                    @error('desc_departamento')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cod_departamento" class="form-label">Código del Departamento</label>
                    <input type="text" 
                           id="cod_departamento" 
                           name="cod_departamento" 
                           class="form-input" 
                           maxlength="20"
                           placeholder="Ej: INF-001"
                           value="{{ old('cod_departamento') }}"
                           required>
                    @error('cod_departamento')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Registrar Departamento</button>
                </div>
            </form>
        </div>
    </div>

    <hr class="divider">

    <h2 class="section-title">Lista de Departamentos</h2>

    @if($departamentos->count() > 0)
        <div class="dominios-list">
            @foreach ($departamentos as $dep)
                <div class="dominio-item fade-in">
                    <div class="dominio-header">
                        <div>
                            <div class="dominio-name">
                                {{ $dep->nombre_departamento }}
                                @if($dep->desc_departamento)
                                    <span style="font-weight: normal; color: var(--text-secondary); margin-left: 0.5rem;">
                                        - {{ $dep->desc_departamento }}
                                    </span>
                                @endif
                            </div>
                            <span class="dominio-status status-active">
                                Código: {{ $dep->cod_departamento }}
                            </span>
                        </div>
                        <div class="dominio-actions">
                            <button type="button" 
                                    class="btn btn-success btn-sm" 
                                    onclick="editarDepartamento({{ $dep->id_departamento }}, '{{ $dep->nombre_departamento }}', '{{ $dep->desc_departamento }}', '{{ $dep->cod_departamento }}')">
                                Editar
                            </button>
                            <form action="{{ route('departamentos.destroy', $dep->id_departamento) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este departamento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📁</div>
            <div class="empty-state-title">No hay departamentos registrados</div>
            <p>Comience creando un nuevo departamento usando el formulario superior.</p>
        </div>
    @endif
</div>

{{-- Modal de Edición --}}
<div id="modalEditDepartamento" class="modal-overlay">
    <div class="modal-content-wrapper">
        <button onclick="cerrarModal()" class="modal-close">&times;</button>
        <h2 class="section-title" style="margin-top: 0;">Editar Departamento</h2>
        <form id="formEditDepartamento" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_nombre_departamento" class="form-label">Nombre</label>
                <input type="text" id="edit_nombre_departamento" name="nombre_departamento" class="form-input" maxlength="100" required>
            </div>
            <div class="form-group">
                <label for="edit_desc_departamento" class="form-label">Descripción</label>
                <textarea id="edit_desc_departamento" name="desc_departamento" class="form-input" rows="2"></textarea>
            </div>
            <div class="form-group">
                <label for="edit_cod_departamento" class="form-label">Código</label>
                <input type="text" id="edit_cod_departamento" name="cod_departamento" class="form-input" maxlength="20" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
function editarDepartamento(id, nombre, descripcion, codigo) {
    const modal = document.getElementById('modalEditDepartamento');
    const form = document.getElementById('formEditDepartamento');

    form.action = '{{ url("/departamentos") }}/' + id;
    document.getElementById('edit_nombre_departamento').value = nombre;
    document.getElementById('edit_desc_departamento').value = descripcion;
    document.getElementById('edit_cod_departamento').value = codigo;

    modal.classList.add('show');
}

function cerrarModal() {
    document.getElementById('modalEditDepartamento').classList.remove('show');
}

document.getElementById('modalEditDepartamento').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModal();
});
</script>

@endsection
