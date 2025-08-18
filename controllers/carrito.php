<?php
require_once 'models/productoModel.php';
class Carrito extends Controller
{

    function __construct(){
        parent::__construct();
    }

   public function index($data = [])
{
    $_SESSION['mensaje_carrito'] = 'Agregado al carrito';
    header('Location: ' . constant('URL') . 'dashboard');
    exit();
}


    public function agregar()
    {
            session_start();

            if (!isset($_POST['idProducto'])) {
            // Manejo de error si no se envía ID
            header('Location: ' . constant('URL') . 'dashboard?error=Producto_invalido');
            exit();
        }
            $idProducto = $_POST['idProducto'];
            //Consultar el modelo para Traer los datos del producto
            $productoModel = new ProductoModel();
            $producto = $productoModel->getById($idProducto);
            if (!$producto) {
            // Manejo de error si producto no existe
            header('Location: ' . constant('URL') . 'dashboard?error=No_existe_el_producto');
            exit();
        }

            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }

            // Si ya existe el producto en el carrito, suma cantidad
        if (isset($_SESSION['carrito'][$idProducto])) {
            $_SESSION['carrito'][$idProducto]['cantidad']++;
        } else {
            // Agrega nuevo producto al carrito con cantidad=1
            $_SESSION['carrito'][$idProducto] = [
                'idProducto' => $producto['idProducto'],
                'marca' => $producto['marca'],
                'descripcion' => $producto['descripcion'],
                'precio' => $producto['precio'],
                'cantidad' => 1
            ];
        }

        // Redirecciona a la vista del carrito o al dashboard
        $_SESSION['mensaje_carrito'] = 'Agregado al carrito';
        header('Location: ' . constant('URL') . 'dashboard');
        exit();
  }


    public function quitar()
{
    session_start();
    if (isset($_POST['idProducto'])) {
        $idProducto = $_POST['idProducto'];
        if (isset($_SESSION['carrito'][$idProducto])) {
            unset($_SESSION['carrito'][$idProducto]);
        }
    }
    header('Location: ' . constant('URL') . 'carrito');
    exit();
}

   public function vaciar()
{
    session_start();
    unset($_SESSION['carrito']);
    header('Location: ' . constant('URL') . 'carrito');
    exit();
}

    public function finalizar()
{
    session_start();
    $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
    // Lógica para registrar la venta aquí
    unset($_SESSION['carrito']);
    header('Location: ' . constant('URL') . 'carrito?mensaje=Compra+realizada');
    exit();
}

}
?>