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
            
            <a   href="<?= base_url("/login") ?>" class="btn btn-success">
                <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
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
                    <p class="text-muted small">Stock: <?= esc($libro["stock"]) ?></p>
                    <p class="text-muted small">Autor(es): <?= esc($libro["authors"]) ?></p>
                    <div class="book-price mb-2">$<?= number_format($libro['price'], 2) ?>
                    MXN</div>
                </div>
                    
            </div>
            <?php endforeach; ?>

        </div>

        <div class="d-flex justify-content-center pagination-container">
            <?= $pager->links('default', 'bootstrap_pagination') ?>
        </div>
    </main>
</html>