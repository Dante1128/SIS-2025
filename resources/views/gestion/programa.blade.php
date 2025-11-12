@extends('base')

@section('content')
<link rel="stylesheet" href="{{ asset('css/gestion.css') }}">

<div class="dominio-container">
    <h1 class="dominio-title">Gestión de Programas Académicos</h1>

    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="form-grid">
        <div class="card">
            <div class="card-header">
                <h2 class="section-title" style="margin: 0;">Nuevo Programa</h2>
            </div>
            <form action="{{ route('programas.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nombre_programa" class="form-label">Nombre del Programa</label>
                    <input type="text" 
                           id="nombre_programa" 
                           name="nombre_programa" 
                           class="form-input" 
                           placeholder="Ej: Ingeniería de Sistemas"
                           maxlength="150"
                           value="{{ old('nombre_programa') }}"
                           required>
                    @error('nombre_programa')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cod_programa" class="form-label">Código del Programa</label>
                    <input type="text" 
                           id="cod_programa" 
                           name="cod_programa" 
                           class="form-input" 
                           placeholder="Ej: ISI-001"
                           maxlength="20"
                           value="{{ old('cod_programa') }}"
                           required>
                    @error('cod_programa')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="num_resolucion" class="form-label">N° Resolución</label>
                    <input type="text" 
                           id="num_resolucion" 
                           name="num_resolucion" 
                           class="form-input" 
                           placeholder="Ingrese número de resolución"
                           maxlength="20"
                           value="{{ old('num_resolucion') }}">
                    @error('num_resolucion')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_departamento" class="form-label">Departamento</label>
                    <select name="id_departamento" id="id_departamento" class="form-input" required>
                        <option value="">Seleccione un departamento</option>
                        @foreach($departamentos as $dep)
                            <option value="{{ $dep->id_departamento }}" 
                                    {{ old('id_departamento') == $dep->id_departamento ? 'selected' : '' }}>
                                {{ $dep->nombre_departamento }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_departamento')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_gestion" class="form-label">Gestión</label>
                    <select name="id_gestion" id="id_gestion" class="form-input" required>
                        <option value="">Seleccione una gestión</option>
                        @foreach($gestiones as $ges)
                            <option value="{{ $ges->id_gestion }}" 
                                    {{ old('id_gestion') == $ges->id_gestion ? 'selected' : '' }}>
                                {{ $ges->desc_gestion ?? 'Gestión ' . $ges->num_resolucion }} 
                                ({{ \Carbon\Carbon::parse($ges->fecha_inicio)->format('Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_gestion')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Registrar Programa</button>
                </div>
            </form>
        </div>
    </div>

    <hr class="divider">

    <h2 class="section-title">Lista de Programas</h2>

    @if($programas->count() > 0)
        <div class="dominios-list">
            @foreach ($programas as $prog)
                <div class="dominio-item fade-in">
                    <div class="dominio-header">
                        <div>
                            <div class="dominio-name">
                                {{ $prog->nombre_programa }}
                                <span style="font-weight: normal; color: var(--text-secondary); margin-left: 0.5rem;">
                                    ({{ $prog->cod_programa }})
                                </span>
                            </div>
                            <span class="dominio-status status-active">
                                {{ $prog->departamento->nombre_departamento ?? 'Sin departamento' }} 
                                | {{ $prog->gestion->desc_gestion ?? 'Sin gestión' }}
                            </span>
                        </div>
                        <div class="dominio-actions">
                            <button type="button" 
                                    class="btn btn-success btn-sm" 
                                    onclick="editarPrograma({{ $prog->id_programa }}, '{{ $prog->nombre_programa }}', '{{ $prog->cod_programa }}', '{{ $prog->num_resolucion }}', '{{ $prog->id_departamento }}', '{{ $prog->id_gestion }}')">
                                Editar
                            </button>
                            <form action="{{ route('programas.destroy', $prog->id_programa) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este programa?');">
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
            <div class="empty-state-title">No hay programas registrados</div>
            <p>Comience creando un nuevo programa usando el formulario superior.</p>
        </div>
    @endif
</div>

{{-- Modal de Edición --}}
<div id="modalEditPrograma" class="modal-overlay">
    <div class="modal-content-wrapper">
        <button onclick="cerrarModal()" class="modal-close">&times;</button>
        <h2 class="section-title" style="margin-top: 0;">Editar Programa</h2>
        <form id="formEditPrograma" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_nombre_programa" class="form-label">Nombre</label>
                <input type="text" id="edit_nombre_programa" name="nombre_programa" class="form-input" maxlength="150" required>
            </div>
            <div class="form-group">
                <label for="edit_cod_programa" class="form-label">Código</label>
                <input type="text" id="edit_cod_programa" name="cod_programa" class="form-input" maxlength="20" required>
            </div>
            <div class="form-group">
                <label for="edit_num_resolucion" class="form-label">N° Resolución</label>
                <input type="text" id="edit_num_resolucion" name="num_resolucion" class="form-input" maxlength="20">
            </div>
            <div class="form-group">
                <label for="edit_id_departamento" class="form-label">Departamento</label>
                <select name="id_departamento" id="edit_id_departamento" class="form-input" required>
                    @foreach($departamentos as $dep)
                        <option value="{{ $dep->id_departamento }}">{{ $dep->nombre_departamento }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="edit_id_gestion" class="form-label">Gestión</label>
                <select name="id_gestion" id="edit_id_gestion" class="form-input" required>
                    @foreach($gestiones as $ges)
                        <option value="{{ $ges->id_gestion }}">{{ $ges->desc_gestion ?? 'Gestión ' . $ges->num_resolucion }}</option>
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
function editarPrograma(id, nombre, codigo, resolucion, departamento, gestion) {
    const modal = document.getElementById('modalEditPrograma');
    const form = document.getElementById('formEditPrograma');

    form.action = '{{ url("/programas") }}/' + id;
    document.getElementById('edit_nombre_programa').value = nombre;
    document.getElementById('edit_cod_programa').value = codigo;
    document.getElementById('edit_num_resolucion').value = resolucion;
    document.getElementById('edit_id_departamento').value = departamento;
    document.getElementById('edit_id_gestion').value = gestion;

    modal.classList.add('show');
}

function cerrarModal() {
    document.getElementById('modalEditPrograma').classList.remove('show');
}

document.getElementById('modalEditPrograma').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModal();
});
</script>

@endsection
