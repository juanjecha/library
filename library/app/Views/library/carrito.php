<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Carrito | Librería Juanito</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= base_url('css/books.css') ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<script src="<?= base_url('js/inactividad.js') ?>"
        data-logout-url="<?= site_url('logout') ?>"
        data-minutes="10"></script>
</head>
<body>
    <header class="bg-dark text-white py-3 mb-4 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">Librería Juanito</h1>
            <div class="d-flex gap-2">
                <a href="<?= site_url('libreria/catalogo') ?>" class="btn btn-outline-light">
                    <i class="bi bi-arrow-left"></i> Seguir comprando
                </a>
                <a href="<?= base_url('logout') ?>" class="btn btn-danger">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </a>
            </div>
        </div>
    </header>

    <main class="container py-2">
        <h2 class="h4 mb-3"><i class="bi bi-cart3"></i> Tu carrito</h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= esc(session()->getFlashdata('success')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (empty($carrito)): ?>

            <div class="card shadow-sm text-center p-5">
                <div class="text-muted mb-3"><i class="bi bi-cart-x display-3"></i></div>
                <p class="mb-3">Tu carrito está vacío.</p>
                <div>
                    <a href="<?= site_url('libreria/catalogo') ?>" class="btn btn-primary">
                        Ver catálogo
                    </a>
                </div>
            </div>

        <?php else: ?>

            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Libro</th>
                                <th>Formato</th>
                                <th class="text-end">Precio</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($carrito as $key => $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <?php if (! empty($item['portada'])): ?>
                                                <img src="<?= base_url('uploads/' . esc($item['portada'], 'url')) ?>"
                                                    alt="Portada de <?= esc($item['titulo'], 'attr') ?>"
                                                    class="rounded"
                                                    style="height: 70px; width: auto;">
                                            <?php else: ?>
                                                <div class="text-muted d-flex align-items-center justify-content-center"
                                                    style="height: 70px; width: 50px;">
                                                    <i class="bi bi-book fs-3"></i>
                                                </div>
                                            <?php endif; ?>

                                            <div>
                                                <div class="fw-bold"><?= esc($item['titulo']) ?></div>
                                                <div class="small text-muted"><?= esc($item['autor']) ?></div>
                                                <span class="badge isbn-badge">ISBN: <?= esc($item['isbn']) ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= esc($item['formato']) ?></td>
                                    <td class="text-end">$<?= number_format($item['precio'], 2) ?></td>
                                    <td class="text-center"><?= (int) $item['cantidad'] ?></td>
                                    <td class="text-end fw-bold">$<?= number_format($item['subtotal'], 2) ?></td>
                                    <td class="text-end">
                                        <a href="<?= site_url('libreria/carrito/eliminar/' . rawurlencode($key)) ?>"
                                           class="btn btn-sm btn-outline-danger"
                                           title="Quitar del carrito">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Total</td>
                                <td class="text-end">
                                    <span class="book-price">$<?= number_format($total, 2) ?> MXN</span>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="<?= site_url('libreria/carrito/vaciar') ?>"
                   class="btn btn-outline-danger"
                   onclick="return confirm('¿Vaciar todo el carrito?');">
                    <i class="bi bi-trash3"></i> Vaciar carrito
                </a>
                <a href="<?= site_url('libreria/catalogo') ?>" class="btn btn-primary">
                    Seguir comprando
                </a>
            </div>

        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>