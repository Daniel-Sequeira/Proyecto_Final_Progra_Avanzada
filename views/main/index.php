<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Zapatería SM</title>
</head>
<body>
    <?php require (__DIR__ . '/../../layout/header.php') ?>
    <div style="background-color: #f5f5f5; padding: 30px 0; text-align: center;">
      <h1 style="margin: 0;">Bienvenido a Zapatería SM</h1>
    </div>
    <div style="background: url('<?php echo constant('URL');?>img/landingpage.jpg') no-repeat center center; background-size: cover; min-height: 70vh; display: flex; justify-content: center; align-items: center;">
      <a href="<?php echo constant('URL'); ?>login" style="padding: 15px 40px; background-color: #007bff; color: #fff; text-decoration: none; font-size: 1.2em; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: background 0.2s;">
        Ingresar
      </a>
    </div>

    <?php require (__DIR__ . '/../../layout/footer.php')?>
</body>
</html>