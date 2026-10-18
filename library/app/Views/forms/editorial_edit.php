<div class="modal fade" id="editEdModal" tabindex="-1" aria-labelledby="editEdTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editEditorialForm" action="" method="POST">
                <?= csrf_field() ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="editEdTitle">Editar editorial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <label for="edit_ed_name" class="form-label">Nombre</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-building"></i></span>
                        <input type="text" class="form-control" id="edit_ed_name"
                            name="edit_name" placeholder="Ej. Bloomsbury" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle-fill"></i> Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>