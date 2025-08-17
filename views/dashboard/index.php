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
                <h1 class="h2">Dashboard</h1>
                <div class="container">

                <!-- Buscador por marca -->
                <form action="<?php echo constant('URL'); ?>dashboard/buscar" method="get" class="mb-3">
                    <input name="q" type="text" class="form-control" placeholder="Buscar por marca..."
                        value="<?= isset($busqueda) ? htmlspecialchars($busqueda) : '' ?>">
                    <button class="btn btn-primary mt-2" type="submit">Buscar</button>
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
                                            <form action="<?php echo constant('URL'); ?>carrito/agregar" method="post" style="display:inline;">
                                                <input type="hidden" name="idProducto" value="<?= htmlspecialchars($producto['idProducto']) ?>">
                                                <button type="submit" class="btn btn-success btn-sm">Agregar al carrito</button>
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

                <!-- Feather Icons -->
                <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
                <script>
                    feather.replace();
                </script>
                </div>
            </main>
        </div>
    </div>
    <?php require __DIR__ . '/../../layout/footer.php'?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
