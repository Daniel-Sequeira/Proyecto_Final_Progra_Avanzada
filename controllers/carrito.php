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

///Funciones del carrito y productos
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

public function actualizar() {
    session_start();

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Validar si viene el array de descuentos
    if (!empty($_POST['descuento'])) {
        foreach ($_POST['descuento'] as $idProducto => $valor_descuento) {
            $valor_descuento = max(0, min(100, intval($valor_descuento))); // limitar 0-100 %

            // Buscar el producto en el carrito y actualizar descuento
            foreach ($_SESSION['carrito'] as &$item) {
                if ($item['idProducto'] == $idProducto) {
                    $item['descuento'] = $valor_descuento;
                }
            }
            unset($item); // romper referencia
        }
    }

    // Opcional: mensaje de éxito
    $_SESSION['mensaje_carrito'] = "Carrito actualizado correctamente.";
    $_SESSION['abrir_modal_carrito'] = true;

    header("Location: " . constant('URL') . "dashboard"); // Redirige al menú ppal
    exit();
}

///Funciones  enfocadas al CLiente al facturar
public function buscarCliente() {
    session_start();
    $cedula = $_POST['cedula'];

    // Utiliza el modelo para buscar el cliente por cédula
    require_once 'models/clienteModel.php';
    $clienteModel = new ClienteModel();
    $cliente = $clienteModel->getByCedula($cedula);

    if ($cliente) {
        // Cliente existe, guarda datos en sesión y redirige a facturar
        $_SESSION['datos_cliente'] = $cliente;
        header("Location: " . constant('URL') . "carrito/facturar");
        exit();
    } else {
        // Cliente no existe, muestra mensaje
        $_SESSION['mensaje_carrito'] = "Por favor registre el cliente antes de facturar.";
        $_SESSION['abrir_modal_carrito'] = true;
        header("Location: " . constant('URL') . "dashboard");
        exit();
    }
}

public function facturar() {
    session_start();
    if (empty($_SESSION['datos_cliente'])) {
        // Seguridad extra
        header("Location: " . constant('URL') . "dashboard");
        exit();
    }
    $cliente = $_SESSION['datos_cliente'];
    $nombre = $cliente['nombre'];
    $cedula = $cliente['cedula'];

    // Obtener carrito
    $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

    // Usar FPDF para generar PDF
    require_once(__DIR__ . '/../libs/fpdf/fpdf.php');
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Factura de Compra', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Cliente: ' . $nombre, 0, 1);
    $pdf->Cell(0, 10, 'Cedula: ' . $cedula, 0, 1);

    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Producto', 1);
    $pdf->Cell(40, 10, 'Marca', 1);
    $pdf->Cell(30, 10, 'Precio', 1);
    $pdf->Cell(20, 10, 'Cant.', 1);
    $pdf->Cell(30, 10, 'Descuento', 1);
    $pdf->Cell(30, 10, 'Total', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
    $total_general = 0;
    foreach ($carrito as $item) {
        $descuento = isset($item['descuento']) ? $item['descuento'] : 0;
        $precio_desc = $item['precio'] * (1 - $descuento / 100);
        $total = $precio_desc * $item['cantidad'];
        $total_general += $total;

        $pdf->Cell(40, 10, $item['descripcion'], 1);
        $pdf->Cell(40, 10, $item['marca'], 1);
        $pdf->Cell(30, 10, number_format($item['precio'], 2), 1);
        $pdf->Cell(20, 10, $item['cantidad'], 1);
        $pdf->Cell(30, 10, $descuento . '%', 1);
        $pdf->Cell(30, 10, number_format($total, 2), 1);
        $pdf->Ln();
    }

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(160, 10, 'Total General', 1);
    $pdf->Cell(30, 10, number_format($total_general, 2), 1);

    // Salida PDF
    $pdf->Output('I', 'factura.pdf');
    exit();
}


}
?>