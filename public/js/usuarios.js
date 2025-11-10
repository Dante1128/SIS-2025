// Filtro por texto en tabla (cliente)
(() => {
  const search = document.querySelector('[data-table-search]');
  const table = document.querySelector(search?.dataset.tableSearch || '');
  if (search && table) {
    search.addEventListener('input', () => {
      const q = search.value.trim().toLowerCase();
      table.querySelectorAll('tbody tr').forEach(tr => {
        tr.style.display = tr.innerText.toLowerCase().includes(q) ? '' : 'none';
      });
    });
  }

  // Validación HTML5 con Bootstrap
  document.querySelectorAll('form.needs-validation').forEach(form => {
    form.addEventListener('submit', e => {
      if (!form.checkValidity()) { e.preventDefault(); e.stopPropagation(); }
      form.classList.add('was-validated');
    });
  });

  // Confirmación de borrado
  document.querySelectorAll('[data-confirm]').forEach(btn => {
    btn.addEventListener('click', e => { if (!confirm(btn.dataset.confirm)) e.preventDefault(); });
  });

  // Rellenar modal Editar
  const modal = document.getElementById('editarUsuarioModal');
  if (modal) {
    modal.addEventListener('show.bs.modal', ev => {
      const b = ev.relatedTarget; if (!b) return;
      const get = a => b.getAttribute(a) || '';
      const id  = get('data-id');

      modal.querySelector('#edit_id_persona').value = id;
      modal.querySelector('#edit_nombres').value = get('data-nombres');
      modal.querySelector('#edit_apellidos').value = get('data-apellidos');
      modal.querySelector('#edit_email').value = get('data-email');
      modal.querySelector('#edit_genero').value = get('data-genero');
      modal.querySelector('#edit_celular').value = get('data-celular');
      modal.querySelector('#edit_id_cargo').value = get('data-id_cargo');
      modal.querySelector('#edit_id_rol').value   = get('data-id_rol');

      modal.querySelector('#formEditarUsuario').action = `/usuarios/${id}`;
    });
  }
})();
