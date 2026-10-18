<div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="editBookForm" action="" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="editBookTitle">Editar libro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">

                    <!-- Portada -->
                    <div class="mb-3">
                        <label for="edit_book_cover" class="form-label">Portada</label>
                        <div>
                            <img id="edit_book_cover_preview" class="img-thumbnail mb-2 d-none"
                                alt="Portada actual" style="max-height: 120px;">
                        </div>
                        <input type="file" class="form-control" id="edit_book_cover" name="cover"
                            accept="image/png, image/jpeg, image/webp">
                        <div class="form-text">Déjalo vacío para conservar la portada actual. Máximo 2 MB.</div>
                    </div>

                    <div class="row">
                        <!-- ISBN (solo lectura) -->
                        <div class="col-md-5 mb-3">
                            <label for="edit_book_isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="edit_book_isbn" readonly>
                            <div class="form-text">El ISBN no se puede modificar.</div>
                        </div>

                        <!-- Título -->
                        <div class="col-md-7 mb-3">
                            <label for="edit_book_title" class="form-label">Título</label>
                            <input type="text" class="form-control" id="edit_book_title" name="title"
                                maxlength="200" required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Autores -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">Autores</label>
                            <div class="border rounded p-2" style="max-height: 150px; overflow-y: auto;">
                                <?php foreach (($authors ?? []) as $author): ?>
                                    <div class="form-check">
                                        <input class="form-check-input edit-author-check" type="checkbox"
                                            name="author_ids[]"
                                            id="edit_author_<?= esc($author['id'], 'attr') ?>"
                                            value="<?= esc($author['id'], 'attr') ?>">
                                        <label class="form-check-label" for="edit_author_<?= esc($author['id'], 'attr') ?>">
                                            <?= esc($author['name'] . ' ' . $author['last_name']) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Editorial -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_book_editorial" class="form-label">Editorial</label>
                            <select class="form-select" id="edit_book_editorial" name="editorial_id" required>
                                <?php foreach (($editorials ?? []) as $editorial): ?>
                                    <option value="<?= esc($editorial['id'], 'attr') ?>">
                                        <?= esc($editorial['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Precio -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_book_price" class="form-label">Precio (MXN)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="edit_book_price" name="price"
                                    min="0" step="0.01" required>
                            </div>
                        </div>

                        <!-- Stock -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_book_stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="edit_book_stock" name="stock"
                                min="0" step="1" required>
                        </div>
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