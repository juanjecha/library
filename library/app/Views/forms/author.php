
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

            </div>
        </div>
    </div>
</body>
</html>