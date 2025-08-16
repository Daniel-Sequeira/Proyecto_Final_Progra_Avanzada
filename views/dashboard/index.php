<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Zapatería SM</title>
    <!-- Asegúrate de incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require __DIR__ . '/../../layout/header.php'; ?>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <?php require  __DIR__ . '/../../layout/sidebar.php'?>
            </nav>
            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h1 class="h2">Dashboard</h1>
                <div class="container">
                    <!-- Buscador -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form class="d-flex" onsubmit="buscarProducto(); return false;">
                                <input class="form-control me-2" type="search" placeholder="Buscar producto..." id="busqueda">
                                <button class="btn btn-primary" type="submit">Buscar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <script src="/js/search.js"></script>
            </main>
        </div>
    </div>

    <?php require  __DIR__ . '/../../layout/footer.php'?>
    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>