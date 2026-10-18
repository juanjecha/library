<div class="card shadow mb-4">
    <div class="card-body">
        <form action="<?= base_url('save_book') ?>" method="POST">
            <?= csrf_field() ?>

            <!-- Portada -->
            <div class="mb-3">
                <label for="cover" class="form-label">Portada</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-image"></i></span>
                    <input type="file" 
                           class="form-control" 
                           id="cover"
                           name="cover"
                           accept="image/png, image/jpeg, image/webp">
                </div>
                <div class="form-text">JPG, PNG o WEBP. Máximo 2 MB.</div>
            </div>

            <div class="row">
                <!-- ISBN -->
                <div class="col-md-5 mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                        <input type="text" class="form-control" id="isbn" name="isbn"
                            placeholder="Ej. 978-607-0000-00-0"
                            maxlength="17" value="<?= esc(old('isbn')) ?>" required>
                    </div>
                </div>

                <!-- Título -->
                <div class="col-md-7 mb-3">
                    <label for="title" class="form-label">Título</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-book-fill"></i></span>
                        <input type="text" class="form-control" id="title" name="title"
                            placeholder="Ej. Cien años de soledad"
                            maxlength="200" value="<?= esc(old('title')) ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">


            <!-- Autores (checklist) -->
            <div class="col-md-6 mb-3">
                <label class="form-label d-block">Autores</label>

                <?php $selected = (array) old('author_ids'); ?>

                <?php if (empty($authors)): ?>
                    <div class="form-text text-danger">Primero registra al menos un autor.</div>
                <?php else: ?>
                    <div class="border rounded p-2" id="authorChecklist" style="max-height: 150px; overflow-y: auto;">
                        <?php foreach ($authors as $author): ?>
                            <div class="form-check">
                                <input class="form-check-input author-check" type="checkbox"
                                    name="author_ids[]"
                                    id="author_<?= esc($author['id'], 'attr') ?>"
                                    value="<?= esc($author['id'], 'attr') ?>"
                                    <?= in_array($author['id'], $selected) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="author_<?= esc($author['id'], 'attr') ?>">
                                    <?= esc($author['name'] . ' ' . $author['last_name']) ?>
                                </label>
                            </div>

                            <button type="button"
                                class="btn btn-sm btn-outline-primary btn-edit-author"
                                data-bs-toggle="modal"
                                data-bs-target="#editAuthorModal"
                                data-id="<?= esc($author['id'], 'attr') ?>"
                                data-name="<?= esc($author['name'], 'attr') ?>"
                                data-last-name="<?= esc($author['last_name'], 'attr') ?>">
                                <i class="bi bi-pencil-square"></i> Editar
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-text">Marca uno o más autores.</div>
                <?php endif; ?>
            </div>


                <!-- Editorial -->
                <div class="col-md-6 mb-3">
                    <label for="editorial_id" class="form-label">Editorial</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-building"></i></span>
                        <select class="form-select" id="editorial_id" name="editorial_id" required>
                            <option value="" disabled <?= old('editorial_id') ? '' : 'selected' ?>>
                                Selecciona una editorial
                            </option>
                            <?php foreach (($editorials ?? []) as $editorial): ?>
                                <option value="<?= esc($editorial['id'], 'attr') ?>"
                                    <?= old('editorial_id') == $editorial['id'] ? 'selected' : '' ?>>
                                    <?= esc($editorial['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php if (empty($editorials)): ?>
                        <div class="form-text text-danger">Primero registra al menos una editorial.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <!-- Precio -->
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Precio (MXN)</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="price" name="price"
                            placeholder="0.00" min="0" step="0.01"
                            value="<?= esc(old('price')) ?>" required>
                    </div>
                </div>

                <!-- Stock -->
                <div class="col-md-6 mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-boxes"></i></span>
                        <input type="number" class="form-control" id="stock" name="stock"
                            min="0" step="1" value="<?= esc(old('stock') ?: 0) ?>" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-check-circle-fill"></i> Guardar libro
            </button>
        </form>
    </div>
</div>