@extends('base')

@section('content')
<link rel="stylesheet" href="{{ asset('css/gestion.css') }}">

<div class="dominio-container">
    <h1 class="dominio-title">Gestión de Prerequisitos de Cursos</h1>

    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="form-grid">
        <div class="card">
            <div class="card-header">
                <h2 class="section-title" style="margin: 0;">Nuevo Prerequisito</h2>
            </div>
            <form action="{{ route('prerequisitos.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="id_curso" class="form-label">Curso</label>
                    <select name="id_curso" id="id_curso" class="form-input" required>
                        <option value="">Seleccione un curso</option>
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id_curso }}">{{ $curso->nombre_curso }}</option>
                        @endforeach
                    </select>
                    @error('id_curso')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="desc_prerequisito" class="form-label">Descripción del Prerequisito</label>
                    <input type="text" id="desc_prerequisito" name="desc_prerequisito" class="form-input" maxlength="100" placeholder="Ej: Haber aprobado Álgebra Lineal" required>
                    @error('desc_prerequisito')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Registrar Prerequisito</button>
                </div>
            </form>
        </div>
    </div>

    <hr class="divider">

    <h2 class="section-title">Lista de Prerequisitos</h2>

    @if($prerequisitos->count() > 0)
        <div class="dominios-list">
            @foreach ($prerequisitos as $pre)
                <div class="dominio-item fade-in">
                    <div class="dominio-header">
                        <div>
                            <div class="dominio-name">
                                {{ $pre->curso->nombre_curso ?? 'Sin curso' }}
                                <span style="font-weight: normal; color: var(--text-secondary); margin-left: 0.5rem;">
                                    → {{ $pre->desc_prerequisito }}
                                </span>
                            </div>
                        </div>
                        <div class="dominio-actions">
                            <button type="button"
                                    class="btn btn-success btn-sm"
                                    onclick="editarPrerequisito({{ $pre->id_prerequisitos }}, '{{ $pre->id_curso }}', '{{ $pre->desc_prerequisito }}')">
                                Editar
                            </button>
                            <form action="{{ route('prerequisitos.destroy', $pre->id_prerequisitos) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este prerequisito?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <div class="empty-state-title">No hay prerequisitos registrados</div>
            <p>Comience creando un nuevo prerequisito usando el formulario superior.</p>
        </div>
    @endif
</div>

{{-- Modal de Edición --}}
<div id="modalEditPrerequisito" class="modal-overlay">
    <div class="modal-content-wrapper">
        <button onclick="cerrarModal()" class="modal-close">&times;</button>
        <h2 class="section-title" style="margin-top: 0;">Editar Prerequisito</h2>
        <form id="formEditPrerequisito" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="edit_id_curso" class="form-label">Curso</label>
                <select name="id_curso" id="edit_id_curso" class="form-input" required>
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->id_curso }}">{{ $curso->nombre_curso }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="edit_desc_prerequisito" class="form-label">Descripción</label>
                <input type="text" id="edit_desc_prerequisito" name="desc_prerequisito" class="form-input" maxlength="100" required>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
function editarPrerequisito(id, curso, descripcion) {
    const modal = document.getElementById('modalEditPrerequisito');
    const form = document.getElementById('formEditPrerequisito');

    form.action = '{{ url("/prerequisitos") }}/' + id;
    document.getElementById('edit_id_curso').value = curso;
    document.getElementById('edit_desc_prerequisito').value = descripcion;

    modal.classList.add('show');
}

function cerrarModal() {
    document.getElementById('modalEditPrerequisito').classList.remove('show');
}

document.getElementById('modalEditPrerequisito').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModal();
});
</script>

@endsection
