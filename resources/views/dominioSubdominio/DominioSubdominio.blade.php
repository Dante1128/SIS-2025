@extends('base')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dominio.css') }}">

<div class="dominio-container">
    <h1 class="dominio-title">Gestión de Dominios y Subdominios</h1>

    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="form-grid">
        <div class="card">
            <div class="card-header">
                <h2 class="section-title" style="margin: 0;">Nuevo Dominio</h2>
            </div>
            <form action="{{ route('dominio.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="descripcion_dominio" class="form-label">Descripción del Dominio</label>
                    <input type="text" 
                           id="descripcion_dominio" 
                           name="descripcion_dominio" 
                           class="form-input" 
                           placeholder="Ingrese la descripción del dominio"
                           maxlength="150"
                           required>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        Registrar Dominio
                    </button>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="section-title" style="margin: 0;">Nuevo Subdominio</h2>
            </div>
            <form action="{{ route('subdominio.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="id_dominio" class="form-label">Dominio</label>
                    <select id="id_dominio" name="id_dominio" class="form-select" required>
                        <option value="">Seleccione un dominio</option>
                        @foreach ($dominios as $dominio)
                            <option value="{{ $dominio->id_dominio }}">{{ $dominio->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="descripcion_subdominio" class="form-label">Descripción del Subdominio</label>
                    <input type="text" 
                           id="descripcion_subdominio" 
                           name="descripcion_subdominio" 
                           class="form-input" 
                           placeholder="Ingrese la descripción del subdominio"
                           maxlength="150"
                           required>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        Registrar Subdominio
                    </button>
                </div>
            </form>
        </div>
    </div>

    <hr class="divider">

    <h2 class="section-title">Lista de Dominios y Subdominios</h2>

    @if($dominios->count() > 0)
        <div class="dominios-list">
            @foreach ($dominios as $dominio)
                <div class="dominio-item fade-in">
                    <div class="dominio-header">
                        <div>
                            <div class="dominio-name">{{ $dominio->descripcion }}</div>
                            <span class="dominio-status {{ $dominio->estado ? 'status-active' : 'status-inactive' }}">
                                <span>{{ $dominio->estado ? '✓' : '✗' }}</span>
                                {{ $dominio->estado ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        <div class="dominio-actions">
                            <form action="{{ route('dominio.update', $dominio->id_dominio) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="descripcion" value="{{ $dominio->descripcion }}">
                                <button type="button" 
                                        class="btn btn-success btn-sm" 
                                        onclick="editarDominio({{ $dominio->id_dominio }}, '{{ $dominio->descripcion }}')">
                                    Editar
                                </button>
                            </form>
                            <form action="{{ route('dominio.toggle', $dominio->id_dominio) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning btn-sm">
                                    {{ $dominio->estado ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Subdominios --}}
                    <div class="subdominios-container">
                        <h4 style="font-size: 0.875rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 0.75rem; text-transform: uppercase;">
                            Subdominios ({{ $dominio->subdominios->count() }})
                        </h4>
                        @if($dominio->subdominios->count() > 0)
                            <div class="subdominios-list">
                                @foreach ($dominio->subdominios as $sub)
                                    <div class="subdominio-item">
                                        <div class="subdominio-name">
                                            {{ $sub->descripcion }}
                                            <span class="badge {{ $sub->estado ? 'badge-success' : 'badge-danger' }}" style="margin-left: 0.5rem;">
                                                {{ $sub->estado ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </div>
                                        <div class="subdominio-actions">
                                            <form action="{{ route('subdominio.update', $sub->id_subdominio) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="descripcion" value="{{ $sub->descripcion }}">
                                                <input type="hidden" name="id_dominio" value="{{ $sub->id_dominio }}">
                                                <button type="button" 
                                                        class="btn btn-success btn-sm" 
                                                        onclick="editarSubdominio({{ $sub->id_subdominio }}, '{{ $sub->descripcion }}', {{ $sub->id_dominio }})">
                                                    Editar
                                                </button>
                                            </form>
                                            <form action="{{ route('subdominio.toggle', $sub->id_subdominio) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    {{ $sub->estado ? 'Desactivar' : 'Activar' }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-subdominios">
                                No hay subdominios registrados para este dominio.
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📁</div>
            <div class="empty-state-title">No hay dominios registrados</div>
            <p>Comience creando un nuevo dominio usando el formulario superior.</p>
        </div>
    @endif
</div>

<div id="modalEditDominio" class="modal-overlay">
    <div class="modal-content-wrapper">
        <button onclick="cerrarModalDominio()" class="modal-close">&times;</button>
        <h2 class="section-title" style="margin-top: 0;">Editar Dominio</h2>
        <form id="formEditDominio" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_descripcion_dominio" class="form-label">Descripción</label>
                <input type="text" 
                       id="edit_descripcion_dominio" 
                       name="descripcion" 
                       class="form-input" 
                       maxlength="150"
                       required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarModalDominio()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEditSubdominio" class="modal-overlay">
    <div class="modal-content-wrapper">
        <button onclick="cerrarModalSubdominio()" class="modal-close">&times;</button>
        <h2 class="section-title" style="margin-top: 0;">Editar Subdominio</h2>
        <form id="formEditSubdominio" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_id_dominio_sub" class="form-label">Dominio</label>
                <select id="edit_id_dominio_sub" name="id_dominio" class="form-select" required>
                    @foreach ($dominios as $dominio)
                        <option value="{{ $dominio->id_dominio }}">{{ $dominio->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="edit_descripcion_subdominio" class="form-label">Descripción</label>
                <input type="text" 
                       id="edit_descripcion_subdominio" 
                       name="descripcion" 
                       class="form-input" 
                       maxlength="150"
                       required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarModalSubdominio()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/dominio.js') }}"></script>
<script>
function editarDominio(id, descripcion) {
    const modal = document.getElementById('modalEditDominio');
    const form = document.getElementById('formEditDominio');
    const input = document.getElementById('edit_descripcion_dominio');
    
    form.action = '{{ url("/dominio") }}/' + id;
    input.value = descripcion;
    modal.classList.add('show');
}

function cerrarModalDominio() {
    document.getElementById('modalEditDominio').classList.remove('show');
}

function editarSubdominio(id, descripcion, idDominio) {
    const modal = document.getElementById('modalEditSubdominio');
    const form = document.getElementById('formEditSubdominio');
    const inputDesc = document.getElementById('edit_descripcion_subdominio');
    const selectDominio = document.getElementById('edit_id_dominio_sub');
    
    form.action = '{{ url("/subdominio") }}/' + id;
    inputDesc.value = descripcion;
    selectDominio.value = idDominio;
    modal.classList.add('show');
}

function cerrarModalSubdominio() {
    document.getElementById('modalEditSubdominio').classList.remove('show');
}

document.getElementById('modalEditDominio').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalDominio();
    }
});

document.getElementById('modalEditSubdominio').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalSubdominio();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalDominio();
        cerrarModalSubdominio();
    }
});
</script>

@endsection
