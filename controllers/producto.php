<?php
class Producto extends Controller {

    function __construct(){
        parent::__construct();
    }

    // Mostrar formulario y producto registrado (si existe)
    public function index() {
        $limit = 5;
    $paginaActual = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($paginaActual - 1) * $limit;

    // Obtener productos y total
    $productos = $this->model->getUltimosProductos($limit, $offset);
    $totalRegistros = $this->model->getTotalProductos();
    $totalPaginas = ceil($totalRegistros / $limit);

    // Pasar datos a la vista
    $this->view->productos = $productos;
    $this->view->paginaActual = $paginaActual;
    $this->view->totalPaginas = $totalPaginas;
        // Opcional: Pasa un producto a la vista si se agregó uno
        $this->view->producto = null;
        $this->view->render('producto/index');
    }

    // Registrar producto
    public function registrarProducto() {
        $datos = [
            'marca'       => $_POST['marca'],
            'descripcion' => $_POST['descripcion'],
            'talla'       => $_POST['talla'],
            'precio'      => $_POST['precio'],
            'cantidad'    => $_POST['cantidad'],
            'estado'      => $_POST['estado']
        ];

       $idProducto = $this->model->insert($datos);

    if ($idProducto !== false && $idProducto !== null && $idProducto !== 0 && $idProducto !== '') {
        // Obtener producto recién insertado
        $producto = $this->model->getById($idProducto);

        // Obtener los últimos 5 productos actualizados (debería incluir el nuevo)
        $productos = $this->model->getUltimosProductos(5, 0);

        // Variables de paginación si las necesitas
        $totalRegistros = $this->model->getTotalProductos();
        $totalPaginas = ceil($totalRegistros / 5);

        // Pasar todo a la vista
        $this->view->producto = $producto;
        $this->view->productos = $productos;
        $this->view->paginaActual = 1;
        $this->view->totalPaginas = $totalPaginas;

        $this->view->render('producto/index');
    } else {
        echo "Error al registrar producto";
    }
}

    // Actualizar producto (opcional, según si quieres manejarlo aquí)
    public function actualizarProducto() {
        $datos = [
            'idProducto'  => $_POST['idProducto'],
            'marca'       => $_POST['marca'],
            'descripcion' => $_POST['descripcion'],
            'talla'       => $_POST['talla'],
            'precio'      => $_POST['precio'],
            'cantidad'    => $_POST['cantidad'],
            'estado'      => $_POST['estado']
        ];

        if($this->model->update($datos)){
            header('Location: ' . constant('URL') . 'producto');
            exit();
        } else {
            echo "Error al actualizar producto";
        }
    }
}
?>