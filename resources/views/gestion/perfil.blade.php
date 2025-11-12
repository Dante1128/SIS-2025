@extends('base')

@section('content')
<link rel="stylesheet" href="{{ asset('css/gestion.css') }}">

<div class="dominio-container">
    <h1 class="dominio-title">Gestión de Perfiles de Formación</h1>

    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="form-grid">
        <div class="card">
            <div class="card-header">
                <h2 class="section-title" style="margin: 0;">Nuevo Perfil</h2>
            </div>
            <form action="{{ route('perfiles.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="id_programa" class="form-label">Programa</label>
                    <select name="id_programa" id="id_programa" class="form-input" required>
                        <option value="">Seleccione un programa</option>
                        @foreach($programas as $programa)
                            <option value="{{ $programa->id_programa }}">{{ $programa->nombre_programa }}</option>
                        @endforeach
                    </select>
                    @error('id_programa')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

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

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Registrar Perfil</button>
                </div>
            </form>
        </div>
    </div>

    <hr class="divider">

    <h2 class="section-title">Lista de Perfiles</h2>

    @if($perfiles->count() > 0)
        <div class="dominios-list">
            @foreach ($perfiles as $perfil)
                <div class="dominio-item fade-in">
                    <div class="dominio-header">
                        <div>
                            <div class="dominio-name">
                                {{ $perfil->programa->nombre_programa ?? 'Sin programa' }}
                                <span style="font-weight: normal; color: var(--text-secondary); margin-left: 0.5rem;">
                                    → {{ $perfil->curso->nombre_curso ?? 'Sin curso' }}
                                </span>
                            </div>
                        </div>
                        <div class="dominio-actions">
                            <button type="button"
                                    class="btn btn-success btn-sm"
                                    onclick="editarPerfil({{ $perfil->id_perfil }}, '{{ $perfil->id_programa }}', '{{ $perfil->id_curso }}')">
                                Editar
                            </button>
                            <form action="{{ route('perfiles.destroy', $perfil->id_perfil) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este perfil?');">
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
            <div class="empty-state-title">No hay perfiles registrados</div>
            <p>Comience creando un nuevo perfil usando el formulario superior.</p>
        </div>
    @endif
</div>

{{-- Modal de Edición --}}
<div id="modalEditPerfil" class="modal-overlay">
    <div class="modal-content-wrapper">
        <button onclick="cerrarModal()" class="modal-close">&times;</button>
        <h2 class="section-title" style="margin-top: 0;">Editar Perfil</h2>
        <form id="formEditPerfil" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_id_programa" class="form-label">Programa</label>
                <select name="id_programa" id="edit_id_programa" class="form-input" required>
                    @foreach($programas as $programa)
                        <option value="{{ $programa->id_programa }}">{{ $programa->nombre_programa }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="edit_id_curso" class="form-label">Curso</label>
                <select name="id_curso" id="edit_id_curso" class="form-input" required>
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->id_curso }}">{{ $curso->nombre_curso }}</option>
                    @endforeach
                </select>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
function editarPerfil(id, programa, curso) {
    const modal = document.getElementById('modalEditPerfil');
    const form = document.getElementById('formEditPerfil');

    form.action = '{{ url("/perfiles") }}/' + id;
    document.getElementById('edit_id_programa').value = programa;
    document.getElementById('edit_id_curso').value = curso;

    modal.classList.add('show');
}

function cerrarModal() {
    document.getElementById('modalEditPerfil').classList.remove('show');
}

document.getElementById('modalEditPerfil').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModal();
});
</script>

@endsection
