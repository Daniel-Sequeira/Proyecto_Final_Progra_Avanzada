
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF'])=="index.php"?'active':''?>" aria-current="page" href="producto">
                    <span data-feather="log-out" class="align-text-bottom"></span>
                    Salir
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF'])=="index.php"?'active':''?>" href="factura">
                    <span data-feather="book" class="align-text-bottom"></span>
                   Facturas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF'])=="index.php"?'active':''?>" href="cliente">
                    <span data-feather="users" class="align-text-bottom"></span>
                    Clientes
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
            <span>Configuraciones</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF'])=="index.php"?'active':''?>" href="empleado">
                    <span data-feather="user-check" class="align-text-bottom"></span>
                    Gestión Empleados
                </a>
                 <a class="nav-link <?= basename($_SERVER['PHP_SELF'])=="index.php"?'active':''?>" href="producto">
                    <span data-feather="user-check" class="align-text-bottom"></span>
                    Gestión Productos
                </a>
            </li>
        </ul>
    </div>
</nav>