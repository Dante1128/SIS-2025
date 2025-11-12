@extends('base')

@section('content')
<link rel="stylesheet" href="{{ asset('css/gestion.css') }}">

<div class="dominio-container">
    <h1 class="dominio-title">Gestión de Bibliografía Académica</h1>

    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="form-grid">
        <div class="card">
            <div class="card-header">
                <h2 class="section-title" style="margin: 0;">Nueva Referencia Bibliográfica</h2>
            </div>
            <form action="{{ route('bibliografia.store') }}" method="POST">
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
                    <label for="autor" class="form-label">Autor</label>
                    <input type="text" id="autor" name="autor" class="form-input" maxlength="100" placeholder="Ej: Kotler, Philip" value="{{ old('autor') }}" required>
                    @error('autor')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" id="titulo" name="titulo" class="form-input" maxlength="200" placeholder="Ej: Marketing Management" value="{{ old('titulo') }}" required>
                    @error('titulo')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="editorial" class="form-label">Editorial</label>
                    <input type="text" id="editorial" name="editorial" class="form-input" maxlength="50" placeholder="Ej: Pearson" value="{{ old('editorial') }}">
                </div>

                <div class="form-group">
                    <label for="anio" class="form-label">Año</label>
                    <input type="number" id="anio" name="anio" class="form-input" min="1900" max="{{ date('Y') }}" value="{{ old('anio') }}">
                </div>

                <div class="form-group">
                    <label for="id_edicion" class="form-label">Edición</label>
                    <input type="number" id="id_edicion" name="id_edicion" class="form-input" min="1" placeholder="Ej: 3">
                </div>

                <div class="form-group">
                    <label for="pais_ciudad" class="form-label">País / Ciudad</label>
                    <input type="text" id="pais_ciudad" name="pais_ciudad" class="form-input" maxlength="100" placeholder="Ej: México D.F.">
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Registrar Bibliografía</button>
                </div>
            </form>
        </div>
    </div>

    <hr class="divider">

    <h2 class="section-title">Lista de Bibliografía</h2>

    @if($bibliografias->count() > 0)
        <div class="dominios-list">
            @foreach ($bibliografias as $biblio)
                <div class="dominio-item fade-in">
                    <div class="dominio-header">
                        <div>
                            <div class="dominio-name">
                                {{ $biblio->titulo }}
                                <span style="font-weight: normal; color: var(--text-secondary); margin-left: 0.5rem;">
                                    - {{ $biblio->autor }}
                                </span>
                            </div>
                            <span class="dominio-status status-active">
                                {{ $biblio->curso->nombre_curso ?? 'Sin curso' }} | {{ $biblio->anio ?? 'S/F' }}
                            </span>
                        </div>
                        <div class="dominio-actions">
                            <button type="button" class="btn btn-success btn-sm" onclick="editarBibliografia({{ $biblio->id_biblio }}, '{{ $biblio->id_curso }}', '{{ $biblio->autor }}', '{{ $biblio->titulo }}', '{{ $biblio->editorial }}', '{{ $biblio->anio }}', '{{ $biblio->id_edicion }}', '{{ $biblio->pais_ciudad }}')">Editar</button>
                            <form action="{{ route('bibliografia.destroy', $biblio->id_biblio) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar esta bibliografía?');">
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
            <div class="empty-state-icon">📚</div>
            <div class="empty-state-title">No hay bibliografía registrada</div>
            <p>Comience creando una nueva referencia usando el formulario superior.</p>
        </div>
    @endif
</div>

{{-- Modal de Edición --}}
<div id="modalEditBibliografia" class="modal-overlay">
    <div class="modal-content-wrapper">
        <button onclick="cerrarModal()" class="modal-close">&times;</button>
        <h2 class="section-title" style="margin-top: 0;">Editar Bibliografía</h2>
        <form id="formEditBibliografia" method="POST">
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
                <label for="edit_autor" class="form-label">Autor</label>
                <input type="text" id="edit_autor" name="autor" class="form-input" maxlength="100" required>
            </div>

            <div class="form-group">
                <label for="edit_titulo" class="form-label">Título</label>
                <input type="text" id="edit_titulo" name="titulo" class="form-input" maxlength="200" required>
            </div>

            <div class="form-group">
                <label for="edit_editorial" class="form-label">Editorial</label>
                <input type="text" id="edit_editorial" name="editorial" class="form-input" maxlength="50">
            </div>

            <div class="form-group">
                <label for="edit_anio" class="form-label">Año</label>
                <input type="number" id="edit_anio" name="anio" class="form-input" min="1900" max="{{ date('Y') }}">
            </div>

            <div class="form-group">
                <label for="edit_id_edicion" class="form-label">Edición</label>
                <input type="number" id="edit_id_edicion" name="id_edicion" class="form-input" min="1">
            </div>

            <div class="form-group">
                <label for="edit_pais_ciudad" class="form-label">País / Ciudad</label>
                <input type="text" id="edit_pais_ciudad" name="pais_ciudad" class="form-input" maxlength="100">
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
function editarBibliografia(id, curso, autor, titulo, editorial, anio, edicion, pais) {
    const modal = document.getElementById('modalEditBibliografia');
    const form = document.getElementById('formEditBibliografia');

    form.action = '{{ url("/bibliografia") }}/' + id;
    document.getElementById('edit_id_curso').value = curso;
    document.getElementById('edit_autor').value = autor;
    document.getElementById('edit_titulo').value = titulo;
    document.getElementById('edit_editorial').value = editorial;
    document.getElementById('edit_anio').value = anio;
    document.getElementById('edit_id_edicion').value = edicion;
    document.getElementById('edit_pais_ciudad').value = pais;

    modal.classList.add('show');
}

function cerrarModal() {
    document.getElementById('modalEditBibliografia').classList.remove('show');
}

document.getElementById('modalEditBibliografia').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModal();
});
</script>

@endsection
