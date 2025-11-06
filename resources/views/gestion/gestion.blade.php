@extends('base')

@section('content')
<link rel="stylesheet" href="{{ asset('css/gestion.css') }}">

<div class="dominio-container">
    <h1 class="dominio-title">Gestión de Gestiones Académicas</h1>

    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="form-grid">
        <div class="card">
            <div class="card-header">
                <h2 class="section-title" style="margin: 0;">Nueva Gestión</h2>
            </div>
            <form action="{{ route('gestiones.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="num_resolucion" class="form-label">N° Resolución</label>
                    <input type="text" 
                           id="num_resolucion" 
                           name="num_resolucion" 
                           class="form-input" 
                           placeholder="Ingrese el número de resolución"
                           maxlength="20"
                           value="{{ old('num_resolucion') }}"
                           required>
                    @error('num_resolucion')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="desc_gestion" class="form-label">Descripción</label>
                    <input type="text" 
                           id="desc_gestion" 
                           name="desc_gestion" 
                           class="form-input" 
                           placeholder="Ingrese la descripción de la gestión"
                           maxlength="255"
                           value="{{ old('desc_gestion') }}">
                    @error('desc_gestion')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                    <input type="date" 
                           id="fecha_inicio" 
                           name="fecha_inicio" 
                           class="form-input"
                           value="{{ old('fecha_inicio') }}"
                           required>
                    @error('fecha_inicio')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="fecha_final" class="form-label">Fecha Final</label>
                    <input type="date" 
                           id="fecha_final" 
                           name="fecha_final" 
                           class="form-input"
                           value="{{ old('fecha_final') }}"
                           required>
                    @error('fecha_final')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        Registrar Gestión
                    </button>
                </div>
            </form>
        </div>
    </div>

    <hr class="divider">

    <h2 class="section-title">Lista de Gestiones</h2>

    @if($gestiones->count() > 0)
        <div class="dominios-list">
            @foreach ($gestiones as $gestion)
                <div class="dominio-item fade-in">
                    <div class="dominio-header">
                        <div>
                            <div class="dominio-name">
                                {{ $gestion->num_resolucion }}
                                @if($gestion->desc_gestion)
                                    <span style="font-weight: normal; color: var(--text-secondary); margin-left: 0.5rem;">
                                        - {{ $gestion->desc_gestion }}
                                    </span>
                                @endif
                            </div>
                            <span class="dominio-status status-active">
                                <span>📅</span>
                                {{ $gestion->fecha_inicio->format('d/m/Y') }} - {{ $gestion->fecha_final->format('d/m/Y') }}
                            </span>
                        </div>
                        <div class="dominio-actions">
                            <button type="button" 
                                    class="btn btn-success btn-sm" 
                                    onclick="editarGestion({{ $gestion->id_gestion }}, '{{ $gestion->num_resolucion }}', '{{ $gestion->desc_gestion }}', '{{ $gestion->fecha_inicio->format('Y-m-d') }}', '{{ $gestion->fecha_final->format('Y-m-d') }}')">
                                Editar
                            </button>
                            <form action="{{ route('gestiones.destroy', $gestion->id_gestion) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar esta gestión?');">
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
            <div class="empty-state-title">No hay gestiones registradas</div>
            <p>Comience creando una nueva gestión usando el formulario superior.</p>
        </div>
    @endif
</div>

{{-- Modal de Edición --}}
<div id="modalEditGestion" class="modal-overlay">
    <div class="modal-content-wrapper">
        <button onclick="cerrarModal()" class="modal-close">&times;</button>
        <h2 class="section-title" style="margin-top: 0;">Editar Gestión</h2>
        <form id="formEditGestion" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_num_resolucion" class="form-label">N° Resolución</label>
                <input type="text" 
                       id="edit_num_resolucion" 
                       name="num_resolucion" 
                       class="form-input" 
                       maxlength="20"
                       required>
            </div>
            <div class="form-group">
                <label for="edit_desc_gestion" class="form-label">Descripción</label>
                <input type="text" 
                       id="edit_desc_gestion" 
                       name="desc_gestion" 
                       class="form-input" 
                       maxlength="255">
            </div>
            <div class="form-group">
                <label for="edit_fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" 
                       id="edit_fecha_inicio" 
                       name="fecha_inicio" 
                       class="form-input"
                       required>
            </div>
            <div class="form-group">
                <label for="edit_fecha_final" class="form-label">Fecha Final</label>
                <input type="date" 
                       id="edit_fecha_final" 
                       name="fecha_final" 
                       class="form-input"
                       required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
function editarGestion(id, numResolucion, descripcion, fechaInicio, fechaFinal) {
    const modal = document.getElementById('modalEditGestion');
    const form = document.getElementById('formEditGestion');
    
    form.action = '{{ url("/gestiones") }}/' + id;
    document.getElementById('edit_num_resolucion').value = numResolucion;
    document.getElementById('edit_desc_gestion').value = descripcion;
    document.getElementById('edit_fecha_inicio').value = fechaInicio;
    document.getElementById('edit_fecha_final').value = fechaFinal;
    
    modal.classList.add('show');
}

function cerrarModal() {
    document.getElementById('modalEditGestion').classList.remove('show');
}

document.getElementById('modalEditGestion').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModal();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModal();
    }
});
</script>

@endsection
