@extends('base')

@section('content')
<link rel="stylesheet" href="{{ asset('css/gestion.css') }}">

<div class="dominio-container">
    <h1 class="dominio-title">Gestión del Cuerpo del Curso (Unidades Didácticas)</h1>

    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="form-grid">
        <div class="card">
            <div class="card-header">
                <h2 class="section-title" style="margin: 0;">Nueva Unidad Didáctica</h2>
            </div>
            <form action="{{ route('cursocuerpo.store') }}" method="POST">
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
                    <label for="unidad_didactica" class="form-label">Unidad Didáctica</label>
                    <textarea id="unidad_didactica" name="unidad_didactica" class="form-input" rows="2" placeholder="Ej: Unidad 1 - Conceptos básicos de programación"></textarea>
                </div>

                <div class="form-group">
                    <label for="criterio_desempeno" class="form-label">Criterio de Desempeño</label>
                    <textarea id="criterio_desempeno" name="criterio_desempeno" class="form-input" rows="2" placeholder="Criterios de evaluación o logros esperados"></textarea>
                </div>

                <div class="form-group">
                    <label for="react_desarrollo" class="form-label">Reactividad de Desarrollo</label>
                    <textarea id="react_desarrollo" name="react_desarrollo" class="form-input" rows="2"></textarea>
                </div>

                <div class="form-group">
                    <label for="cargah_teoria" class="form-label">Carga Horaria Teórica</label>
                    <input type="number" id="cargah_teoria" name="cargah_teoria" class="form-input" min="0" placeholder="Ej: 20">
                </div>

                <div class="form-group">
                    <label for="porc_eval_ateorico" class="form-label">Porcentaje Evaluación Teórica (%)</label>
                    <input type="number" id="porc_eval_ateorico" name="porc_eval_ateorico" class="form-input" min="0" max="100" placeholder="Ej: 30">
                </div>

                <div class="form-group">
                    <label for="semanas" class="form-label">Semanas</label>
                    <input type="text" id="semanas" name="semanas" class="form-input" maxlength="20" placeholder="Ej: 1-4">
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Registrar Unidad</button>
                </div>
            </form>
        </div>
    </div>

    <hr class="divider">

    <h2 class="section-title">Lista de Unidades Didácticas</h2>

    @if($cursosCuerpo->count() > 0)
        <div class="dominios-list">
            @foreach ($cursosCuerpo as $cc)
                <div class="dominio-item fade-in">
                    <div class="dominio-header">
                        <div>
                            <div class="dominio-name">
                                {{ $cc->curso->nombre_curso ?? 'Curso no asignado' }}
                                <span style="font-weight: normal; color: var(--text-secondary); margin-left: 0.5rem;">
                                    - {{ $cc->unidad_didactica ?? 'Sin título' }}
                                </span>
                            </div>
                            <span class="dominio-status status-active">
                                {{ $cc->cargah_teoria ?? 0 }}h teoría | {{ $cc->porc_eval_ateorico ?? 0 }}%
                            </span>
                        </div>
                        <div class="dominio-actions">
                            <button type="button" 
                                    class="btn btn-success btn-sm" 
                                    onclick="editarCursoCuerpo({{ $cc->id_curso_cuerpo }}, '{{ $cc->id_curso }}', `{{ $cc->unidad_didactica }}`, `{{ $cc->criterio_desempeno }}`, '{{ $cc->cargah_teoria }}', '{{ $cc->porc_eval_ateorico }}', '{{ $cc->semanas }}')">
                                Editar
                            </button>
                            <form action="{{ route('cursocuerpo.destroy', $cc->id_curso_cuerpo) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar esta unidad?');">
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
            <div class="empty-state-title">No hay unidades registradas</div>
            <p>Comience creando una nueva unidad usando el formulario superior.</p>
        </div>
    @endif
</div>

{{-- Modal de Edición --}}
<div id="modalEditCuerpo" class="modal-overlay">
    <div class="modal-content-wrapper">
        <button onclick="cerrarModal()" class="modal-close">&times;</button>
        <h2 class="section-title" style="margin-top: 0;">Editar Unidad Didáctica</h2>
        <form id="formEditCuerpo" method="POST">
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
                <label for="edit_unidad_didactica" class="form-label">Unidad Didáctica</label>
                <textarea id="edit_unidad_didactica" name="unidad_didactica" class="form-input" rows="2"></textarea>
            </div>

            <div class="form-group">
                <label for="edit_criterio_desempeno" class="form-label">Criterio de Desempeño</label>
                <textarea id="edit_criterio_desempeno" name="criterio_desempeno" class="form-input" rows="2"></textarea>
            </div>

            <div class="form-group">
                <label for="edit_cargah_teoria" class="form-label">Carga Horaria Teórica</label>
                <input type="number" id="edit_cargah_teoria" name="cargah_teoria" class="form-input" min="0">
            </div>

            <div class="form-group">
                <label for="edit_porc_eval_ateorico" class="form-label">Porcentaje Evaluación Teórica (%)</label>
                <input type="number" id="edit_porc_eval_ateorico" name="porc_eval_ateorico" class="form-input" min="0" max="100">
            </div>

            <div class="form-group">
                <label for="edit_semanas" class="form-label">Semanas</label>
                <input type="text" id="edit_semanas" name="semanas" class="form-input" maxlength="20">
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
function editarCursoCuerpo(id, curso, unidad, criterio, teoria, porcTeo, semanas) {
    const modal = document.getElementById('modalEditCuerpo');
    const form = document.getElementById('formEditCuerpo');

    form.action = '{{ url("/curso-cuerpo") }}/' + id;
    document.getElementById('edit_id_curso').value = curso;
    document.getElementById('edit_unidad_didactica').value = unidad;
    document.getElementById('edit_criterio_desempeno').value = criterio;
    document.getElementById('edit_cargah_teoria').value = teoria;
    document.getElementById('edit_porc_eval_ateorico').value = porcTeo;
    document.getElementById('edit_semanas').value = semanas;

    modal.classList.add('show');
}

function cerrarModal() {
    document.getElementById('modalEditCuerpo').classList.remove('show');
}

document.getElementById('modalEditCuerpo').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModal();
});
</script>

@endsection
