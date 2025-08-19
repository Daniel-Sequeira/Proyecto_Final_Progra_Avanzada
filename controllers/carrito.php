<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'models/productoModel.php';
class Carrito extends Controller {

    function __construct() {
        parent::__construct();
        
    }

    public function index($data = []) {
        $_SESSION['mensaje_carrito'] = 'Agregado al carrito';
        header('Location: ' . constant('URL') . 'dashboard');
        exit();
    }

    // Funciones del carrito y productos
    public function agregar() {
        session_start();

        if (!isset($_POST['idProducto'])) {
            header('Location: ' . constant('URL') . 'dashboard?error=Producto_invalido');
            exit();
        }
        $idProducto = $_POST['idProducto'];
        // Usa el modelo del controlador base
        $productoModel = new ProductoModel();
        $producto = $productoModel->getById($idProducto);
        if (!$producto) {
            header('Location: ' . constant('URL') . 'dashboard?error=No_existe_el_producto');
            exit();
        }

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        if (isset($_SESSION['carrito'][$idProducto])) {
            $_SESSION['carrito'][$idProducto]['cantidad']++;
        } else {
            $_SESSION['carrito'][$idProducto] = [
                'idProducto' => $producto['idProducto'],
                'marca' => $producto['marca'],
                'descripcion' => $producto['descripcion'],
                'precio' => $producto['precio'],
                'cantidad' => 1
            ];
        }

        $_SESSION['mensaje_carrito'] = 'Agregado al carrito';
        header('Location: ' . constant('URL') . 'dashboard');
        exit();
    }

    public function quitar() {
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

    public function vaciar() {
        session_start();
        unset($_SESSION['carrito']);
        header('Location: ' . constant('URL') . 'carrito');
        exit();
    }

    public function finalizar() {
        session_start();
        $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
        unset($_SESSION['carrito']);
        header('Location: ' . constant('URL') . 'carrito?mensaje=Compra+realizada');
        exit();
    }

    public function actualizar() {
        session_start();

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        if (!empty($_POST['descuento'])) {
            foreach ($_POST['descuento'] as $idProducto => $valor_descuento) {
                $valor_descuento = max(0, min(100, intval($valor_descuento)));
                foreach ($_SESSION['carrito'] as &$item) {
                    if ($item['idProducto'] == $idProducto) {
                        $item['descuento'] = $valor_descuento;
                    }
                }
                unset($item);
            }
        }

        $_SESSION['mensaje_carrito'] = "Carrito actualizado correctamente.";
        $_SESSION['abrir_modal_carrito'] = true;

        header("Location: " . constant('URL') . "dashboard");
        exit();
    }

    // Funciones enfocadas al Cliente al facturar
    public function buscarCliente() {
        session_start();
        $cedula = $_POST['cedula'];

        require_once 'models/clienteModel.php';
        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->getByCedula($cedula);

        if ($cliente) {
            $_SESSION['datos_cliente'] = $cliente;
            header("Location: " . constant('URL') . "carrito/facturar");
            exit();
        } else {
            $_SESSION['mensaje_carrito'] = "Por favor registre el cliente antes de facturar.";
            $_SESSION['abrir_modal_carrito'] = true;
            header("Location: " . constant('URL') . "dashboard");
            exit();
        }
    }


   public function facturar() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Validar datos de cliente en sesión
    if (empty($_SESSION['datos_cliente'])) {
        header("Location: " . constant('URL') . "dashboard");
        exit();
    }

    $cliente    = $_SESSION['datos_cliente'];
    $nombre     = $cliente['nombre'];
    $cedula     = $cliente['cedula'];
    $carrito    = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
    $total_general = 0;

    // CALCULA TOTAL DE LA FACTURA
    foreach ($carrito as $item) {
        $descuento      = isset($item['descuento']) ? $item['descuento'] : 0;
        $impuesto       = isset($item['impuesto']) ? $item['impuesto'] : 0;
        $precio_desc    = $item['precio'] * (1 - $descuento / 100);
        $subtotal       = $precio_desc * $item['cantidad'];
        $total_impuestos= $subtotal * ($impuesto / 100);
        $total          = $subtotal + $total_impuestos;
        $total_general += $total;
    }

   // ---- GÉNERA PDF DE LA FACTURA ----
require_once(__DIR__ . '/../libs/fpdf/fpdf.php');
$pdf = new FPDF('L', 'mm', 'Letter'); // Horizontal, carta
$pdf->AddPage();

// Título
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode('Factura de Compra'), 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, utf8_decode('Cliente: ' . $nombre), 0, 1);
$pdf->Cell(0, 8, utf8_decode('Cédula: ' . $cedula), 0, 1);

// --- Encabezado personalizado ---
$pdf->SetFont('Arial', 'B', 18);

// Texto a la izquierda
$pdf->SetXY(10, 10); // Posición superior izquierda
$pdf->Cell(0, 15, utf8_decode('Zapatería SM'), 0, 0, 'L');

// Logo a la derecha, dentro de un recuadro
$logoX = 180; // Ajusta si necesitas (según ancho del PDF)
$logoY = 10;
$pdf->Rect($logoX-5, $logoY-2, 95, 20); // Recuadro (x, y, ancho, alto)

// Inserta logo
$pdf->Image(constant('URL').'img/LogoZapateria.png', $logoX, $logoY, 85, 16); // (ruta, x, y, ancho, alto)
$pdf->Ln(25); // Espacio debajo del encabezado

// Encabezados (sumados ~269mm)
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 8, 'Marca', 1, 0, 'C');
$pdf->Cell(55, 8, 'Descripción', 1, 0, 'C');
$pdf->Cell(25, 8, 'Talla', 1, 0, 'C');
$pdf->Cell(18, 8, 'Cantidad', 1, 0, 'C');
$pdf->Cell(25, 8, 'Precio', 1, 0, 'C');
$pdf->Cell(23, 8, 'Subtotal', 1, 0, 'C');
$pdf->Cell(23, 8, 'Descuento', 1, 0, 'C');
$pdf->Cell(23, 8, 'Impuesto', 1, 0, 'C');
$pdf->Cell(24, 8, 'Total', 1, 1, 'C');

$pdf->SetFont('Arial', '', 9);
$total_general_pdf = 0;

foreach ($carrito as $item) {
    $marca          = isset($item['marca']) ? $item['marca'] : '';
    $descripcion    = isset($item['descripcion']) ? $item['descripcion'] : '';
    $talla          = isset($item['talla']) ? $item['talla'] : '';
    $cantidad       = isset($item['cantidad']) ? $item['cantidad'] : 1;
    $precio         = isset($item['precio']) ? $item['precio'] : 0;
    $descuento      = isset($item['descuento']) ? $item['descuento'] : 0;
    $impuesto       = isset($item['impuesto']) ? $item['impuesto'] : 0;

    $subtotal        = $precio * $cantidad;
    $descuento_valor = $subtotal * ($descuento / 100);
    $subtotal_desc   = $subtotal - $descuento_valor;
    $impuesto_valor  = $subtotal_desc * ($impuesto / 100);
    $total           = $subtotal_desc + $impuesto_valor;
    $total_general_pdf += $total;

    // Calcular alto de descripción
    $w_desc = 55;
    $desc_str = utf8_decode($descripcion);
    $desc_len = $pdf->GetStringWidth($desc_str);
    $h_desc = 8;
    $num_lines = ceil($desc_len / $w_desc);
    $h_total = max($num_lines * 5, $h_desc);

    // Marca
    $pdf->Cell(30, $h_total, utf8_decode($marca), 1, 0, 'C');

    // Descripción (MultiCell)
    $x_desc = $pdf->GetX();
    $y_desc = $pdf->GetY();
    $pdf->MultiCell($w_desc, 5, $desc_str, 1);

    // Mover X después de descripcion
    $pdf->SetXY($x_desc + $w_desc, $y_desc);

    // Las demás celdas con el mismo alto
    $pdf->Cell(25, $h_total, utf8_decode($talla), 1, 0, 'C');
    $pdf->Cell(18, $h_total, $cantidad, 1, 0, 'C');
    $pdf->Cell(25, $h_total, number_format($precio, 2), 1, 0, 'C');
    $pdf->Cell(23, $h_total, number_format($subtotal, 2), 1, 0, 'C');
    $pdf->Cell(23, $h_total, number_format($descuento_valor, 2).' ('.$descuento.'%)', 1, 0, 'C');
    $pdf->Cell(23, $h_total, number_format($impuesto_valor, 2).' ('.$impuesto.'%)', 1, 0, 'C');
    $pdf->Cell(24, $h_total, number_format($total, 2), 1, 1, 'C');
}

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(249, 10, utf8_decode('Total General'), 1, 0, 'R');
$pdf->Cell(24, 10, number_format($total_general_pdf, 2), 1, 1, 'C');

$pdf->Output('I', 'factura.pdf');
exit();

   }

   
}
?>
