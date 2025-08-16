<?php
class Empleado extends Controller {
    
    function __construct(){
        parent::__construct();
    }

      function index() {
        $empleados = $this->model->getAll();
        $this->view->empleados = $empleados;
        $this->view->render('empleado/index');
    }

      function registrarEmpleado() {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo']; 
    $telefono = $_POST['telefono'];
    $cedula = $_POST['cedula'];
    $contrasena = $_POST['contrasena'];
    $estado = $_POST['estado'];
    $id_rol = $_POST['id_rol'];
    if($this->model->insert([
        'nombre' => $nombre,
        'correo' => $correo,
        'telefono' => $telefono,
        'cedula' => $cedula,
        'contrasena' => $contrasena,
        'estado' => $estado,
        'id_rol' => $id_rol
    ])){
        header('Location: ' . constant('URL') . 'empleado');
        exit();
    } else {
        echo "Error al registrar empleado";
    }
}

  function cambiarEstado() {
    $id_empleado = $_POST['id_empleado'];
    $nuevo_estado = $_POST['nuevo_estado'];
    if($this->model->cambiarEstado( $id_empleado, $nuevo_estado)){
        header('Location: ' . constant('URL') . 'empleado');
        exit();
    } else {
        echo "Error al cambiar estado";
    }
}

function actualizarEmpleado() {
    $datos = [
        'id_empleado' => $_POST['id_empleado'],
        'nombre'    => $_POST['nombre'],
        'correo'    => $_POST['correo'],
        'telefono'  => $_POST['telefono'],
        'cedula'    => $_POST['cedula'],
        'estado'    => $_POST['estado'],
        'id_rol'    => $_POST['id_rol']
    ];
    if (isset($_POST['contrasena']) && $_POST['contrasena'] !== '' && isset($_POST['contrasena'])) {
        $datos['contrasena'] = $_POST['contrasena'];
    }
    if($this->model->update($datos)){
        header('Location: ' . constant('URL') . 'empleado');
        exit();
    } else {
        echo "Error al actualizar empleado";
    }
}


}

?>