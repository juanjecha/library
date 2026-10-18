<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/
bootstrap.min.css">
<link rel="stylesheet" href="<?= base_url("css/books.css") ?>">
<link rel="stylesheet" href="<?= base_url("css/cover.css") ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <header class="bg-dark text-white py-3 mb-4 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">Librería Juanito</h1>
            
            <a href="#" 
                class="btn btn-primary" 
                data-bs-toggle="modal" 
                data-bs-target="#ModalBook">
                Libros
            </a>

            <a href="#" 
                class="btn btn-primary" 
                data-bs-toggle="modal" 
                data-bs-target="#ModalAut">
                Autores
            </a>

            <a href="<?= site_url('libreria/carrito') ?>" class="btn btn-primary">
                Ver Carrito (<?= count(session()->get('libro_carrito') ?? []) ?>)
            </a>

            <a href="#" 
                class="btn btn-primary" 
                data-bs-toggle="modal" 
                data-bs-target="#ModalEd">
                Editoriales
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
                <button type="button"
                    class="btn btn-sm btn-outline-secondary w-100 mt-2"
                    data-bs-toggle="modal"
                    data-bs-target="#editBookModal"
                    data-id="<?= esc($libro['id'], 'attr') ?>"
                    data-isbn="<?= esc($libro['isbn'], 'attr') ?>"
                    data-title="<?= esc($libro['title'], 'attr') ?>"
                    data-price="<?= esc($libro['price'], 'attr') ?>"
                    data-stock="<?= esc($libro['stock'], 'attr') ?>"
                    data-editorial="<?= esc($libro['id_editorial'], 'attr') ?>"
                    data-authors="<?= esc($libro['author_ids'] ?? '', 'attr') ?>"
                    data-cover="<?= esc($libro['cover'] ?? '', 'attr') ?>">
                    <i class="bi bi-pencil-square"></i> Editar
                </button>



                <div class="card h-100 book-card shadow-sm p-3">
                    <div class="book-cover-wrap mb-3">
                        <?php if (! empty($libro['cover'])): ?>
                            <img src="<?= base_url('uploads/' . esc($libro['cover'], 'url')) ?>"
                                alt="Portada de <?= esc($libro['title'] ?? $libro['titulo'], 'attr') ?>"
                                class="book-cover"
                                loading="lazy">
                        <?php else: ?>
                            <div class="book-cover-placeholder">
                                <i class="bi bi-book fs-1"></i>
                            </div>
                        <?php endif; ?>
                    </div>   

                    <span class="badge isbn-badge w-auto me-auto mb-2">ISBN: <?=
                    esc($libro['isbn']) ?></span>

                    <h2 class="book-title"><?= esc($libro['title']) ?></h2>
                    <p class="text-muted small">Editorial: <?= esc($libro["editorial"]) ?></p>
                    
                    <div class="book-price mb-2">$<?= number_format($libro['price'], 2) ?>
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

        <!-- nuevo autor -->     
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


        <!-- Modal de edición autor-->
                <div class="modal-body">
                    <?= view("forms/author_edit") ?>
                </div>


        <!-- nueva editorial -->     
    <div class="modal fade" id="ModalEd" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="miModalLabel">Registro de Editoriales</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <?= view("forms/editorial") ?>
                </div>
            </div>
        </div>
    </div>

        <!-- Modal de edición editorial-->
                <div class="modal-body">
                    <?= view("forms/editorial_edit") ?>
                </div>




        <!-- nuevo libro -->     
    <div class="modal fade" id="ModalBook" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="miModalLabel">Registro de Libros</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <?= view("forms/book") ?>
                </div>
            </div>
        </div>
    </div>

    

            <!-- Modal de edición editorial-->
                <div class="modal-body">
                    <?= view("forms/book_edit") ?>
                </div>


</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- status author -->
<?php if(session()->getFlashdata('success_author')): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Registro exitoso',
    text: '<?= session()->getFlashdata('success_author') ?>'
});
</script>
<?php endif; ?>

<?php if(session()->getFlashdata('error_author')): ?>

<script>
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: '<?= session()->getFlashdata('error_author') ?>'
});
</script>
<?php endif; ?>



<!-- status editorial -->
<?php if(session()->getFlashdata('success_ed')): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Registro exitoso',
    text: '<?= session()->getFlashdata('success_ed') ?>'
});
</script>
<?php endif; ?>

<?php if(session()->getFlashdata('error_ed')): ?>

<script>
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: '<?= session()->getFlashdata('error_ed') ?>'
});
</script>
<?php endif; ?>



<!-- errors book -->
<?php if(session()->getFlashdata('success_book')): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Registro exitoso',
    text: <?= json_encode(session()->getFlashdata('success_book')) ?>
});
</script>
<?php endif; ?>

<?php if(session()->getFlashdata('error_book')): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: <?= json_encode(session()->getFlashdata('error_book')) ?>
});
</script>
<?php endif; ?>


<!-- modal edit author -->

<script>
    const editUrlBase = "<?= base_url('edit_aut') ?>";
    const authorsModalEl = document.getElementById('ModalAut');
    const editModalEl = document.getElementById('editAuthorModal');

    document.querySelectorAll('.btn-edit-author').forEach(function (btn) {
        btn.addEventListener('click', function () {
            // Llenar el formulario de edición
            document.getElementById('editAuthorForm').action = editUrlBase + '/' + btn.dataset.id;
            document.getElementById('edit_name').value = btn.dataset.name;
            document.getElementById('edit_last_name').value = btn.dataset.lastName;

            // Cerrar "Autores" y, cuando termine de cerrarse, abrir "Editar"
            authorsModalEl.addEventListener('hidden.bs.modal', function () {
                bootstrap.Modal.getOrCreateInstance(editModalEl).show();
            }, { once: true });

            bootstrap.Modal.getInstance(authorsModalEl).hide();
        });
    });
</script>


<!-- modal edit editorial -->
<script>
    const editEdUrlBase = "<?= base_url('edit_ed') ?>";
    const edModalEl = document.getElementById('ModalEd');
    const editEdEl = document.getElementById('editEdModal');

    document.querySelectorAll('.btn-edit-editorial').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('editEditorialForm').action = editEdUrlBase + '/' + btn.dataset.id;
            document.getElementById('edit_ed_name').value = btn.dataset.name;

            edModalEl.addEventListener('hidden.bs.modal', function () {
                bootstrap.Modal.getOrCreateInstance(editEdEl).show();
            }, { once: true });

            bootstrap.Modal.getInstance(edModalEl).hide();
        });
    });
</script>



</html>