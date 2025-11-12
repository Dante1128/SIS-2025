@extends('base')

@section('content')
<link rel="stylesheet" href="{{ asset('css/gestion.css') }}">

<div class="dominio-container">
    <h1 class="dominio-title">Gestión de Áreas Académicas</h1>

    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="form-grid">
        <div class="card">
            <div class="card-header">
                <h2 class="section-title" style="margin: 0;">Nueva Área</h2>
            </div>
            <form action="{{ route('areas.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre del Área</label>
                    <input type="text" 
                           id="nombre" 
                           name="nombre" 
                           class="form-input" 
                           placeholder="Ej: Matemáticas, Programación, Física..."
                           maxlength="50"
                           value="{{ old('nombre') }}"
                           required>
                    @error('nombre')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea id="descripcion" 
                              name="descripcion" 
                              class="form-input" 
                              rows="2"
                              placeholder="Ingrese una breve descripción">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Registrar Área</button>
                </div>
            </form>
        </div>
    </div>

    <hr class="divider">

    <h2 class="section-title">Lista de Áreas</h2>

    @if($areas->count() > 0)
        <div class="dominios-list">
            @foreach ($areas as $area)
                <div class="dominio-item fade-in">
                    <div class="dominio-header">
                        <div>
                            <div class="dominio-name">
                                {{ $area->nombre }}
                                @if($area->descripcion)
                                    <span style="font-weight: normal; color: var(--text-secondary); margin-left: 0.5rem;">
                                        - {{ $area->descripcion }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="dominio-actions">
                            <button type="button" 
                                    class="btn btn-success btn-sm" 
                                    onclick="editarArea({{ $area->id_area }}, '{{ $area->nombre }}', '{{ $area->descripcion }}')">
                                Editar
                            </button>
                            <form action="{{ route('areas.destroy', $area->id_area) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar esta área?');">
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
            <div class="empty-state-title">No hay áreas registradas</div>
            <p>Comience creando una nueva área usando el formulario superior.</p>
        </div>
    @endif
</div>

{{-- Modal de Edición --}}
<div id="modalEditArea" class="modal-overlay">
    <div class="modal-content-wrapper">
        <button onclick="cerrarModal()" class="modal-close">&times;</button>
        <h2 class="section-title" style="margin-top: 0;">Editar Área</h2>
        <form id="formEditArea" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_nombre" class="form-label">Nombre</label>
                <input type="text" id="edit_nombre" name="nombre" class="form-input" maxlength="50" required>
            </div>
            <div class="form-group">
                <label for="edit_descripcion" class="form-label">Descripción</label>
                <textarea id="edit_descripcion" name="descripcion" class="form-input" rows="2"></textarea>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
function editarArea(id, nombre, descripcion) {
    const modal = document.getElementById('modalEditArea');
    const form = document.getElementById('formEditArea');

    form.action = '{{ url("/areas") }}/' + id;
    document.getElementById('edit_nombre').value = nombre;
    document.getElementById('edit_descripcion').value = descripcion;

    modal.classList.add('show');
}

function cerrarModal() {
    document.getElementById('modalEditArea').classList.remove('show');
}

document.getElementById('modalEditArea').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModal();
});
</script>

@endsection
