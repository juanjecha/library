    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="card shadow">
                    <div class="card-body">
                        <form action="<?= base_url("save_ed") ?>" method="POST">

                            <!-- Campo nombre -->
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    Nombre
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-person-fill"></i>
                                    </span>

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="name"
                                        name="name"
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


                <!-- Lista de Editoriales -->
                <div class="card shadow">
                    <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                        Editoriales registradas
                        <span class="badge bg-primary"><?= count($editorials ?? []) ?></span>
                    </div>

                    <?php if (empty($editorials)): ?>
                        <div class="card-body text-muted text-center">
                            Aún no hay editoriales registrados.
                        </div>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($editorials as $editorial): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="bi bi-person me-2 text-secondary"></i>
                                        <?= esc($editorial['name']) ?>
                                    </span>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-primary btn-edit-editorial"
                                        data-id="<?= esc($editorial['id'], 'attr') ?>"
                                        data-name="<?= esc($editorial['name'], 'attr') ?>">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </button>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>