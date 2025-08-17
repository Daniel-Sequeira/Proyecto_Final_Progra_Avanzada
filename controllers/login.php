<?php

require 'models/empleadomodel.php';
require_once 'config/config.php';

class Login extends Controller {

    function __construct() {
        parent::__construct();
        $this->model = new EmpleadoModel();
    }

    // Procesa el login
    function authenticate() {
        $mensaje = '';

        if ($this->existPOST(['cedula', 'contrasena'])) {
            $cedula = $this->getPost('cedula');
            $contrasena = $this->getPost('contrasena');

            if (empty($cedula) || empty($contrasena)) {
                $mensaje= 'Debe ingresar ambos campos.';
                $this->render('login/index', ['mensaje' => $mensaje ?? '']);
                return;
            }

            // Usamos la función autenticar del modelo
            $resultado = $this->model->autenticar($cedula, $contrasena);

            if ($resultado['success']) {
                if (isset($resultado['empleado']['activo']) && !$resultado['empleado']['activo']) {
                    $mensaje = 'Usuario Inactivo.';
                   $this->render('login/index', ['mensaje' => $mensaje ?? '']);
                    return;
                }
                // Guardar datos importantes en la sesión
                session_start();
                $_SESSION['id_empleado'] = $resultado['empleado']['id_empleado'];
                $_SESSION['cedula']      = $resultado['empleado']['cedula'];
                $_SESSION['nombre']      = $resultado['empleado']['nombre'];
                $_SESSION['id_rol'] = $resultado['empleado']['id_rol'];
                // Redirige a dashboard/pages
                $this->redirect('dashboard', []);
                exit();
            } else {
                $mensaje = 'Usuario o Contraseña Incorrectos.';
                $this->render('login/index', ['mensaje' => $mensaje, 'modal' => true]);
                return;
            }
        }
        // Si no llegan los campos, regresamos al login vacío
       $this->render('login/index', ['mensaje' => '']);
    }
}
?>