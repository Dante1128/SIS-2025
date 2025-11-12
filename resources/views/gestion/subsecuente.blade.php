@extends('base')

@section('content')
<link rel="stylesheet" href="{{ asset('css/gestion.css') }}">

<div class="dominio-container">
    <h1 class="dominio-title">Gestión de Cursos Subsecuentes</h1>

    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="form-grid">
        <div class="card">
            <div class="card-header">
                <h2 class="section-title" style="margin: 0;">Nuevo Curso Subsecuente</h2>
            </div>
            <form action="{{ route('subsecuentes.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="id_curso" class="form-label">Curso Base</label>
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
                    <label for="desc_subsecuente" class="form-label">Descripción del Curso Subsecuente</label>
                    <input type="text" id="desc_subsecuente" name="desc_subsecuente" class="form-input" maxlength="100" placeholder="Ej: Cálculo III depende de Cálculo II" required>
                    @error('desc_subsecuente')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Registrar Subsecuente</button>
                </div>
            </form>
        </div>
    </div>

    <hr class="divider">

    <h2 class="section-title">Lista de Cursos Subsecuentes</h2>

    @if($subsecuentes->count() > 0)
        <div class="dominios-list">
            @foreach ($subsecuentes as $sub)
                <div class="dominio-item fade-in">
                    <div class="dominio-header">
                        <div>
                            <div class="dominio-name">
                                {{ $sub->curso->nombre_curso ?? 'Sin curso base' }}
                                <span style="font-weight: normal; color: var(--text-secondary); margin-left: 0.5rem;">
                                    → {{ $sub->desc_subsecuente }}
                                </span>
                            </div>
                        </div>
                        <div class="dominio-actions">
                            <button type="button"
                                    class="btn btn-success btn-sm"
                                    onclick="editarSubsecuente({{ $sub->id_subsecuente }}, '{{ $sub->id_curso }}', '{{ $sub->desc_subsecuente }}')">
                                Editar
                            </button>
                            <form action="{{ route('subsecuentes.destroy', $sub->id_subsecuente) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este registro?');">
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
            <div class="empty-state-icon">📘</div>
            <div class="empty-state-title">No hay cursos subsecuentes registrados</div>
            <p>Comience creando un nuevo registro usando el formulario superior.</p>
        </div>
    @endif
</div>

{{-- Modal de Edición --}}
<div id="modalEditSubsecuente" class="modal-overlay">
    <div class="modal-content-wrapper">
        <button onclick="cerrarModal()" class="modal-close">&times;</button>
        <h2 class="section-title" style="margin-top: 0;">Editar Subsecuente</h2>
        <form id="formEditSubsecuente" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="edit_id_curso" class="form-label">Curso Base</label>
                <select name="id_curso" id="edit_id_curso" class="form-input" required>
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->id_curso }}">{{ $curso->nombre_curso }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="edit_desc_subsecuente" class="form-label">Descripción</label>
                <input type="text" id="edit_desc_subsecuente" name="desc_subsecuente" class="form-input" maxlength="100" required>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
function editarSubsecuente(id, curso, descripcion) {
    const modal = document.getElementById('modalEditSubsecuente');
    const form = document.getElementById('formEditSubsecuente');

    form.action = '{{ url("/subsecuentes") }}/' + id;
    document.getElementById('edit_id_curso').value = curso;
    document.getElementById('edit_desc_subsecuente').value = descripcion;

    modal.classList.add('show');
}

function cerrarModal() {
    document.getElementById('modalEditSubsecuente').classList.remove('show');
}

document.getElementById('modalEditSubsecuente').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModal();
});
</script>

@endsection
