<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Librería Universitaria - Catálogo Paginado</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/
bootstrap.min.css">
<link rel=""stylesheet href="<?= base_url("css/books.css") ?>">

</head>
<body>
    <header class="bg-dark text-white py-3 mb-4 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">Librería Juanito</h1>
            <a href="#" 
                class="btn btn-primary" 
                data-bs-toggle="modal" 
                data-bs-target="#ModalAut">
                Autores
            </a>

            <a href="<?= site_url('libreria/carrito') ?>" class="btn btn-primary">
                Ver Carrito (<?= count(session()->get('libro_carrito') ?? []) ?>)
            </a>

            <a href="<?= base_url('logout') ?>"class="btn btn-danger">
                <i class="bi bi-box-arrow-right"></i>
                Cerrar sesión
            </a>

        </div>
    </header>

    <main class="container py-2">
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
            <?php foreach ($libros as $libro): ?>
            <div class="col">
                <div class="card h-100 book-card shadow-sm p-3">
                    <span class="badge isbn-badge w-auto me-auto mb-2">ISBN: <?=
                    esc($libro['isbn']) ?></span>

                    <h2 class="book-title"><?= esc($libro['titulo']) ?></h2>
                    <p class="text-muted small">Autor: <?= esc($libro['autor']) ?></p>
                    <div class="book-price mb-2">$<?= number_format($libro['precio'], 2) ?>
                    MXN</div>

                    <form action="<?= site_url('libreria/carrito/agregar') ?>"method="post" class="mt-auto">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= $libro['id'] ?>">

                        <div class="row g-2 mb-2">
                            <div class="col-7">
                                <select name="formato" class="form-select form-select-sm">
                                    <option value="Físico Rústica">Rústica</option>
                                    <option value="Tapa Dura">Tapa Dura</option>
                                    <option value="Digital PDF">PDF Digital</option>
                                </select>
                            </div>
                            <div class="col-5">
                                <input type="number"
                                       name="cantidad"
                                       value="1"
                                       min="1"max="<?= $libro['stock'] ?>"
                                       class="form-control form-control-sm">
                            </div>
                        </div>

                        <button class="btn btn-outline-primary btn-sm w-100" type="submit"
                            <?= $libro['stock'] <= 0 ? 'disabled' : '' ?>>
                            <?= $libro['stock'] > 0 ? 'Agregar al Carrito' : 'Agotado' ?>
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>

        </div>

        <div class="d-flex justify-content-center pagination-container">
            <?= $pager->links('default', 'bootstrap_pagination') ?>
        </div>
    </main>



    <!-- Ventanas modales para los registros -->

                
    <div class="modal fade" id="ModalAut" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="miModalLabel">Registro de Autores</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <?= view("forms/author") ?>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(session()->getFlashdata('success')): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: '<?= session()->getFlashdata('success') ?>'
});
</script>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: '<?= session()->getFlashdata('error') ?>'
});
</script>
<?php endif; ?>

</html>