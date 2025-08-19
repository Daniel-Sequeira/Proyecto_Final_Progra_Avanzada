<?php
class Cliente extends Controller {
    public $db;

    function __construct(){
        parent::__construct();
    }

    // Mostrar la lista de clientes
    function index($data = []) {
        $clientes = $this->model->getAll();
        $this->view->clientes = $clientes;
        $this->view->render('cliente/index');
    }

    // Registrar cliente
    function registrarCliente() {
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo']; 
        $cedula = $_POST['cedula'];

        if($this->model->insert([
            'nombre' => $nombre,
            'correo' => $correo,
            'cedula' => $cedula
        ])){
            header('Location: ' . constant('URL') . 'cliente');
            exit();
        } else {
            echo "Error al registrar cliente";
        }
    }


    // Actualizar cliente
    function actualizarCliente() {
        $datos = [
            'id_cliente' => $_POST['id_cliente'],
            'nombre'     => $_POST['nombre'],
            'correo'     => $_POST['correo'],
            'cedula'     => $_POST['cedula']
        ];

        if($this->model->update($datos)){
            header('Location: ' . constant('URL') . 'cliente');
            exit();
        } else {
            echo "Error al actualizar cliente";
        }
    }

     //Eliminar cliente
   public function eliminar() {
    if (isset($_POST['id_cliente'])) {
        $id_cliente = $_POST['id_cliente'];
        if ($this->model->eliminar($id_cliente)) {
            session_start();
            $_SESSION['mensaje'] = 'Cliente eliminado exitosamente.';
        } else {
            session_start();
            $_SESSION['mensaje'] = 'Error al eliminar el cliente.';
        }
        header('Location: ' . constant('URL') . 'cliente');
        exit();
    } else {
        session_start();
        $_SESSION['mensaje'] = 'ID de cliente no recibido.';
        header('Location: ' . constant('URL') . 'cliente');
        exit();
    }
}

}
?>