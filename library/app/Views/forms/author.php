
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuario</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">
</head>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<body class="bg-light">

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

                <!-- Modal de edición -->
                <div class="modal fade" id="editAuthorModal" tabindex="-1" aria-labelledby="editAuthorTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="editAuthorForm" action="" method="POST">
                                <?= csrf_field() ?>

                                <div class="modal-header">
                                    <h5 class="modal-title" id="editAuthorTitle">Editar autor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="edit_name" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="edit_name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_last_name" class="form-label">Apellido</label>
                                        <input type="text" class="form-control" id="edit_last_name" name="last_name" required>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Guardar cambios
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</body>
</html>