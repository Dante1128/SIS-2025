@extends('base')

@section('content')
<link rel="stylesheet" href="{{ asset('css/gestion.css') }}">

<div class="dominio-container">
    <h1 class="dominio-title">Gestión de Cursos Académicos</h1>

    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="form-grid">
        <div class="card">
            <div class="card-header">
                <h2 class="section-title" style="margin: 0;">Nuevo Curso</h2>
            </div>
            <form action="{{ route('cursos.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre_curso" class="form-label">Nombre del Curso</label>
                    <input type="text" 
                           id="nombre_curso" 
                           name="nombre_curso" 
                           class="form-input" 
                           placeholder="Ej: Programación I, Álgebra Lineal..."
                           maxlength="100"
                           value="{{ old('nombre_curso') }}"
                           required>
                    @error('nombre_curso')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="codigo_curso" class="form-label">Código del Curso</label>
                    <input type="text" 
                           id="codigo_curso" 
                           name="codigo_curso" 
                           class="form-input" 
                           placeholder="Ej: CURS-001"
                           maxlength="20"
                           value="{{ old('codigo_curso') }}"
                           required>
                    @error('codigo_curso')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_programa" class="form-label">Programa</label>
                    <select name="id_programa" id="id_programa" class="form-input" required>
                        <option value="">Seleccione un programa</option>
                        @foreach($programas as $prog)
                            <option value="{{ $prog->id_programa }}">{{ $prog->nombre_programa }}</option>
                        @endforeach
                    </select>
                    @error('id_programa')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_area" class="form-label">Área</label>
                    <select name="id_area" id="id_area" class="form-input" required>
                        <option value="">Seleccione un área</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id_area }}">{{ $area->nombre }}</option>
                        @endforeach
                    </select>
                    @error('id_area')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_semestre" class="form-label">Semestre</label>
                    <input type="number" 
                           id="id_semestre" 
                           name="id_semestre" 
                           class="form-input" 
                           placeholder="Ej: 1"
                           min="1"
                           value="{{ old('id_semestre') }}">
                </div>

                <div class="form-group">
                    <label for="cant_semanas_sem" class="form-label">Cantidad de Semanas</label>
                    <input type="number" 
                           id="cant_semanas_sem" 
                           name="cant_semanas_sem" 
                           class="form-input" 
                           placeholder="Ej: 16"
                           min="1"
                           value="{{ old('cant_semanas_sem') }}">
                </div>

                <div class="form-group">
                    <label for="competencia_curso" class="form-label">Competencia del Curso</label>
                    <textarea id="competencia_curso" 
                              name="competencia_curso" 
                              class="form-input" 
                              rows="2"
                              placeholder="Describa la competencia del curso">{{ old('competencia_curso') }}</textarea>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Registrar Curso</button>
                </div>
            </form>
        </div>
    </div>

    <hr class="divider">

    <h2 class="section-title">Lista de Cursos</h2>

    @if($cursos->count() > 0)
        <div class="dominios-list">
            @foreach ($cursos as $curso)
                <div class="dominio-item fade-in">
                    <div class="dominio-header">
                        <div>
                            <div class="dominio-name">
                                {{ $curso->nombre_curso }}
                                <span style="font-weight: normal; color: var(--text-secondary); margin-left: 0.5rem;">
                                    ({{ $curso->codigo_curso }})
                                </span>
                            </div>
                            <span class="dominio-status status-active">
                                {{ $curso->programa->nombre_programa ?? 'Sin programa' }} | 
                                {{ $curso->area->nombre ?? 'Sin área' }}
                            </span>
                        </div>
                        <div class="dominio-actions">
                            <button type="button" 
                                    class="btn btn-success btn-sm" 
                                    onclick="editarCurso({{ $curso->id_curso }}, '{{ $curso->nombre_curso }}', '{{ $curso->codigo_curso }}', '{{ $curso->id_programa }}', '{{ $curso->id_area }}', '{{ $curso->id_semestre }}', '{{ $curso->cant_semanas_sem }}', `{{ $curso->competencia_curso }}`)">
                                Editar
                            </button>
                            <form action="{{ route('cursos.destroy', $curso->id_curso) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este curso?');">
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
            <div class="empty-state-title">No hay cursos registrados</div>
            <p>Comience creando un nuevo curso usando el formulario superior.</p>
        </div>
    @endif
</div>

{{-- Modal de Edición --}}
<div id="modalEditCurso" class="modal-overlay">
    <div class="modal-content-wrapper">
        <button onclick="cerrarModal()" class="modal-close">&times;</button>
        <h2 class="section-title" style="margin-top: 0;">Editar Curso</h2>
        <form id="formEditCurso" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_nombre_curso" class="form-label">Nombre</label>
                <input type="text" id="edit_nombre_curso" name="nombre_curso" class="form-input" maxlength="100" required>
            </div>
            <div class="form-group">
                <label for="edit_codigo_curso" class="form-label">Código</label>
                <input type="text" id="edit_codigo_curso" name="codigo_curso" class="form-input" maxlength="20" required>
            </div>
            <div class="form-group">
                <label for="edit_id_programa" class="form-label">Programa</label>
                <select name="id_programa" id="edit_id_programa" class="form-input" required>
                    @foreach($programas as $prog)
                        <option value="{{ $prog->id_programa }}">{{ $prog->nombre_programa }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="edit_id_area" class="form-label">Área</label>
                <select name="id_area" id="edit_id_area" class="form-input" required>
                    @foreach($areas as $area)
                        <option value="{{ $area->id_area }}">{{ $area->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="edit_id_semestre" class="form-label">Semestre</label>
                <input type="number" id="edit_id_semestre" name="id_semestre" class="form-input" min="1">
            </div>
            <div class="form-group">
                <label for="edit_cant_semanas_sem" class="form-label">Cantidad de Semanas</label>
                <input type="number" id="edit_cant_semanas_sem" name="cant_semanas_sem" class="form-input" min="1">
            </div>
            <div class="form-group">
                <label for="edit_competencia_curso" class="form-label">Competencia</label>
                <textarea id="edit_competencia_curso" name="competencia_curso" class="form-input" rows="2"></textarea>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
function editarCurso(id, nombre, codigo, programa, area, semestre, semanas, competencia) {
    const modal = document.getElementById('modalEditCurso');
    const form = document.getElementById('formEditCurso');

    form.action = '{{ url("/cursos") }}/' + id;
    document.getElementById('edit_nombre_curso').value = nombre;
    document.getElementById('edit_codigo_curso').value = codigo;
    document.getElementById('edit_id_programa').value = programa;
    document.getElementById('edit_id_area').value = area;
    document.getElementById('edit_id_semestre').value = semestre;
    document.getElementById('edit_cant_semanas_sem').value = semanas;
    document.getElementById('edit_competencia_curso').value = competencia;

    modal.classList.add('show');
}

function cerrarModal() {
    document.getElementById('modalEditCurso').classList.remove('show');
}

document.getElementById('modalEditCurso').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModal();
});
</script>

@endsection
