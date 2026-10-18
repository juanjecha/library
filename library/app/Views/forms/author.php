    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="card shadow">
                    <div class="card-body">
                        <form action="<?= base_url("save_aut") ?>" method="POST">

                            <!-- Campo nombre -->
                            <div class="mb-3">
                                <label for="nombre" class="form-label">
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
                                        placeholder="Ingresa tu nombre"
                                        required>
                                </div>
                            </div>

                            <!-- Campo apellido -->
                            <div class="mb-3">
                                <label for="apellido" class="form-label">
                                    Apellido
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-person-vcard-fill"></i>
                                    </span>

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="last_name"
                                        name="last_name"
                                        placeholder="Ingresa tu apellido"
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


                <!-- Lista de autores -->
                <div class="card shadow">
                    <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                        Autores registrados
                        <span class="badge bg-primary"><?= count($authors ?? []) ?></span>
                    </div>

                    <?php if (empty($authors)): ?>
                        <div class="card-body text-muted text-center">
                            Aún no hay autores registrados.
                        </div>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($authors as $author): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="bi bi-person me-2 text-secondary"></i>
                                        <?= esc($author['name'] . ' ' . $author['last_name']) ?>
                                    </span>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-primary btn-edit-author"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editAuthorModal"
                                        data-id="<?= esc($author['id'], 'attr') ?>"
                                        data-name="<?= esc($author['name'], 'attr') ?>"
                                        data-last-name="<?= esc($author['last_name'], 'attr') ?>">
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