<?php
require_once 'models/ProductoModel.php'; 
session_start();
if (!isset($_SESSION['id_empleado'])) {
    header("Location: " . constant('URL') . "login");
    exit();
}



class Dashboard extends Controller {

    function __construct(){
        parent::__construct();
        $this->model = new ProductoModel();     
    }

     // Vista principal con todos los productos
    public function index($data = []) {
        $productos = $this->model->getAllProductos();
        $this->render('dashboard/index', ['productos' => $productos]);
    }
  
    // Método para buscar productos por marca
    public function buscar() {
        $marca = isset($_GET['q']) ? trim($_GET['q']) : '';
        if ($marca === '') {
            $productos = $this->model->getAllProductos();
        } else {
            $productos = $this->model->buscarProductosPorMarca($marca);
        }
        $this->render('dashboard/index', ['productos' => $productos, 'busqueda' => $marca]);
    }

}
?>