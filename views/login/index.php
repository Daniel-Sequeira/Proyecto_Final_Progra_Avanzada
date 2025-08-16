<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.104.2">
  <title>Login - Biblioteca</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">
</head>

<body class="text-center">

  <main class="form-signin w-100 m-auto">
    <form action="" method="post">
      <img class="mb-4" src="<?php echo constant('URL');?>img/LogoZapateria.png" alt="Logo Zapatería" width="85" height="70">
      <h1 class="h3 mb-3 fw-normal">Inicio de Sesion</h1>

      <div class="form-floating">
        <input name="usuario" type="text" class="form-control" id="floatingInput" placeholder="1-1234-5678 | name@example.com">
        <label for="floatingInput">Cedula o Correo Electronico</label>
      </div>
      <div class="form-floating">
        <input name="contra" type="password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Contraseña</label>
      </div>

      <?php
      if (!empty($mensaje_error)) {
      ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="mensaje_error">
          <strong>Ups!</strong> <?= $mensaje_error ?>
          <button type="button" class="btn-close" onclick="mensaje_error.style.display='none';"></button>
        </div>
      <?php
      }
      ?>
      <a href="<?php echo constant('URL'); ?>dashboard" class="btn btn-primary">Iniciar sesión</a>
      <p class="mt-5 mb-3 text-muted">Zapatería SM &copy; <?= date('Y') ?></p>
    </form>
  </main>


</body>

</html>