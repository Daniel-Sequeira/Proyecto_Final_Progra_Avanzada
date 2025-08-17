<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$rol = isset($_SESSION['id_rol']) ? $_SESSION['id_rol'] : '';
?>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                 <!-- Publico -->
                <a class="nav-link <?= basename($_SERVER['PHP_SELF'])=="index.php"?'active':''?>"
                    href="<?php echo constant('URL'); ?>logout">
                    <span data-feather="book" class="align-text-bottom"></span>
                    Salir
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF'])=="index.php"?'active':''?>"
                    href="<?php echo constant('URL'); ?>factura">
                    <span data-feather="book" class="align-text-bottom"></span>
                    Facturas
                </a>
               
                <a class="nav-link <?= basename($_SERVER['PHP_SELF'])=="index.php"?'active':''?>"
                    href="<?php echo constant('URL'); ?>cliente">
                    <span data-feather="users" class="align-text-bottom"></span>
                    Clientes
                </a>

                <!-- Solo rol administrador = 1 -->
                <?php if ($rol == 1) : ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo constant('URL'); ?>empleado">
                    <span data-feather="user-check" class="align-text-bottom"></span> Gestión Empleados
                </a>
                <a class="nav-link" href="<?php echo constant('URL'); ?>producto">
                    <span data-feather="user-check" class="align-text-bottom"></span> Gestión Productos
                </a>
            </li>
            <?php endif; ?>
            </li>
        </ul>
    </div>
</nav>