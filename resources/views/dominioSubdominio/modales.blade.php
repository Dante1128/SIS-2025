{{-- Modal Crear Dominio --}}
<div class="modal fade" id="modalDominio" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('dominio.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Registrar Dominio</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <label>Descripción del Dominio:</label>
          <input type="text" name="descripcion_dominio" class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Registrar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal Crear Subdominio --}}
<div class="modal fade" id="modalSubdominio" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('subdominio.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Registrar Subdominio</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <label>Dominio:</label>
          <select name="id_dominio" class="form-control" required>
              <option value="">Seleccione un dominio</option>
              @foreach($dominios as $dominio)
                  <option value="{{ $dominio->id_dominio }}">{{ $dominio->descripcion }}</option>
              @endforeach
          </select>

          <label class="mt-2">Descripción del Subdominio:</label>
          <input type="text" name="descripcion_subdominio" class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Registrar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal Editar Dominio --}}
<div class="modal fade" id="modalEditDominio" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditDominio" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Editar Dominio</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <label>Descripción:</label>
          <input type="text" name="descripcion" id="editDominioDescripcion" class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal Editar Subdominio --}}
<div class="modal fade" id="modalEditSubdominio" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditSubdominio" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Editar Subdominio</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <label>Dominio:</label>
          <select name="id_dominio" id="editSubdominioDominio" class="form-control" required>
              @foreach($dominios as $dominio)
                  <option value="{{ $dominio->id_dominio }}">{{ $dominio->descripcion }}</option>
              @endforeach
          </select>

          <label class="mt-2">Descripción:</label>
          <input type="text" name="descripcion" id="editSubdominioDescripcion" class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
