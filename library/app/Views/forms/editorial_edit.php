<div class="modal fade" id="editEdModal" tabindex="-1" aria-labelledby="editAuthorTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content"><?= csrf_field() ?>
            <form id="editAuthorForm" action="<?= base_url("edit_edt") ?>" method="POST">

                <!-- Campo nombre -->
                <div class="mb-3">
                    <label for="edit_name" class="form-label">
                        Nombre
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person-fill"></i>
                        </span>

                        <input
                            type="text"
                            class="form-control"
                            id="edit_name"
                            name="edit_name"
                            placeholder="Ej. Bloomsbury"
                            required>
                    </div>
                </div>

                <!-- Botón registrar -->
                <button
                    type="submit"
                    class="btn btn-primary w-100">
                    <i class="bi bi-check-circle-fill"></i>
                    Guardar
                </button>

            </form>
        </div>
    </div>
</div>