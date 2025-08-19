<?php
if (!isset($mensaje)) {
    $mensaje = '';
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Zapateria SM</title>
    <link href="<?php echo constant('URL'); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo constant('URL'); ?>css/login.css" rel="stylesheet">
</head>

<body class="text-center">
    <main class="form-signin w-100 m-auto">
        <form action="<?php echo constant('URL'); ?>login/authenticate" method="post">
            <img class="mb-4" src="<?php echo constant('URL'); ?>img/LogoZapateria.png" alt="Logo Zapatería" width="85"
                height="70">
            <h1 class="h3 mb-3 fw-normal">Inicio de Sesión</h1>

            <div class="form-floating mb-2">
                <input name="cedula" type="text" class="form-control" id="floatingInput" placeholder="Cédula" required>
                <label for="floatingInput">Cédula</label>
            </div>
            <div class="form-floating mb-2">
                <input name="contrasena" type="password" class="form-control" id="floatingPassword"
                    placeholder="Contraseña" required>
                <label for="floatingPassword">Contraseña</label>
            </div>
            <?php if (!empty($mensaje)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error:</strong> <?= htmlspecialchars($mensaje) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <button class="w-100 btn btn-lg btn-primary mt-2" type="submit">Iniciar sesión</button>
            <p class="mt-5 mb-3 text-muted">Zapatería SM &copy; <?= date('Y') ?></p>
        </form>
    </main>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>