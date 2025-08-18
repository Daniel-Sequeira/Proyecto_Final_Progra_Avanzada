<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Zapatería SM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require __DIR__ . '/../../layout/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <?php require  __DIR__ . '/../../layout/sidebar.php'?>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h1 class="h2">Menú Principal</h1>
                <div class="container">

                    <!-- Buscador por marca -->
                    <form action="<?php echo constant('URL'); ?>dashboard/buscar" method="get"
                        class="mb-3 d-flex gap-2">
                        <input name="q" type="text" class="form-control" placeholder="Buscar por marca..."
                            value="<?= isset($busqueda) ? htmlspecialchars($busqueda) : '' ?>">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                        <!-- Botón para abrir el modal -->
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#carritoModal">
                            <i class="bi bi-cart4"></i> Ver Carrito
                        </button>
                    </form>


                    <div class="table-responsive">
                        <table class="table table-striped table-sm w-100">
                            <thead>
                                <tr>
                                    <th>Marca</th>
                                    <th>Descripción</th>
                                    <th>Talla</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($productos)) : ?>
                                <?php foreach ($productos as $producto) : ?>
                                <?php
                                        $estado_color = $producto['estado'] == 1 ? 'success' : 'danger';
                                        $estado_icon = $producto['estado'] == 1
                                            ? '<span data-feather="check-circle" class="align-text-bottom"></span>'
                                            : '<span data-feather="clock" class="align-text-bottom"></span>';
                                        $estado_nombre = $producto['estado'] == 1 ? "Activo" : "Inactivo";
                                    ?>
                                <tr id="producto-<?= $producto['idProducto'] ?>">
                                    <td><?= htmlspecialchars($producto['marca']) ?></td>
                                    <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                                    <td><?= htmlspecialchars($producto['talla']) ?></td>
                                    <td>$<?= number_format($producto['precio'], 2) ?></td>
                                    <td><?= htmlspecialchars($producto['cantidad']) ?></td>
                                    <td>
                                        <span class="badge text-bg-<?= $estado_color ?>">
                                            <?= $estado_icon ?> <?= $estado_nombre ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form action="<?php echo constant('URL'); ?>carrito/agregar" method="post"
                                            style="display:inline;">
                                            <input type="hidden" name="idProducto"
                                                value="<?= htmlspecialchars($producto['idProducto']) ?>">
                                            <button type="submit" class="btn btn-success btn-sm">Agregar al
                                                carrito</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else : ?>
                                <tr>
                                    <td colspan="7" class="text-center">No se encontraron productos.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal del Carrito -->
                    <div class="modal fade" id="carritoModal" tabindex="-1" aria-labelledby="carritoModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="carritoModalLabel">
                                        <i class="bi bi-cart4 me-2"></i>Carrito de Compras
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <?php if (!empty($_SESSION['carrito'])): ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Producto</th>
                                                    <th scope="col">Marca</th>
                                                    <th scope="col">Descripción</th>
                                                    <th scope="col" class="text-end">Precio</th>
                                                    <th scope="col" class="text-center">Cantidad</th>
                                                    <th scope="col" class="text-end">Subtotal</th>
                                                    <th scope="col" class="text-center">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $total = 0; ?>
                                                <?php foreach ($_SESSION['carrito'] as $item): ?>
                                                <?php $subtotal = $item['precio'] * $item['cantidad'];
                                  $total += $subtotal; ?>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-box"></i>
                                                        <?= htmlspecialchars($item['idProducto']) ?>
                                                    </td>
                                                    <td><?= htmlspecialchars($item['marca']) ?></td>
                                                    <td><?= htmlspecialchars($item['descripcion']) ?></td>
                                                    <td class="text-end">$<?= number_format($item['precio'], 2) ?></td>
                                                    <td class="text-center"><?= $item['cantidad'] ?></td>
                                                    <td class="text-end">$<?= number_format($subtotal, 2) ?></td>
                                                    <td class="text-center">
                                                        <form action="<?php echo constant('URL'); ?>carrito/quitar"
                                                            method="post" class="d-inline">
                                                            <input type="hidden" name="idProducto"
                                                                value="<?= htmlspecialchars($item['idProducto']) ?>">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="Eliminar">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr class="fw-bold">
                                                    <td colspan="5" class="text-end">Total:</td>
                                                    <td class="text-end text-success">$<?= number_format($total, 2) ?>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-between mt-4">
                                        <form action="<?php echo constant('URL'); ?>carrito/vaciar" method="post">
                                            <button class="btn btn-outline-secondary">
                                                <i class="bi bi-x-circle"></i> Vaciar Carrito
                                            </button>
                                        </form>
                                        <form action="<?php echo constant('URL'); ?>carrito/finalizar" method="post">
                                            <button class="btn btn-success">
                                                <i class="bi bi-cash-coin"></i> Confirmar y Facturar
                                            </button>
                                        </form>
                                    </div>
                                    <?php else: ?>
                                    <div class="alert alert-info text-center" role="alert">
                                        <i class="bi bi-info-circle"></i> ¡Tu carrito está vacío!<br>
                                        Agrega productos desde el menú principal.
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Feather Icons -->
                    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
                    <script>
                    feather.replace();
                    </script>
                </div>
                <!-- Mensaje de éxito al agregar al carrito -->
                <?php if (!empty($_SESSION['mensaje_carrito'])): ?>
                <div class="container my-3">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>¡Listo!</strong> <?php echo $_SESSION['mensaje_carrito']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
                <?php unset($_SESSION['mensaje_carrito']); ?>
                <?php endif; ?>
            </main>


        </div>
    </div>

    <?php require __DIR__ . '/../../layout/footer.php'?>
    <script>
    // cierra el alert automáticamente
    setTimeout(function() {
        var alertEl = document.querySelector('.alert-dismissible');
        if (alertEl) {
            var bsAlert = bootstrap.Alert.getOrCreateInstance(alertEl);
            bsAlert.close();
        }
    }, 2500); // 2500 ms = 2.5 segundos
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>