<?php 
//Enrutamiento del sistema, requiere controlador de errores en caso que no se encuentre el controlador solicitado.
require_once 'controllers/errores.php';
class App{
    function __construct(){
       //Constructor obtiene la url, elimina la barra al final (/) y la divide en un array. ['main', 'index']
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);
       
        if(empty($url[0])){
            // Si no hay controlador, cargamos el controlador por defecto
             $archivoController = 'controllers/main.php';
              require_once $archivoController;
              $controller = new Main();
              $controller->loadModel('main'); // Carga el modelo correspondiente al controlador.
              $controller->index(); // Llama al método index del controlador.
              return;
        }
           
        
        $archivoController = 'controllers/'. $url[0] . '.php';

        if(file_exists($archivoController)){
            // Si el archivo existe, lo incluimos y crea instancia del controlador.
            require_once $archivoController;
            $controller = new $url[0];
            $controller->loadModel($url[0]); // Carga el modelo correspondiente al controlador.
            // Si existe un segundo segmento, lo cargamos, que seria la vista o metodo del controlador.
            if(isset($url[1])){
                $controller->{$url[1]}();
            }else{
            // Si no existe el metodo, cargamos el controlador index por defecto
            $controller->index();
        }
        }else{
            // Si no existe el controlador, cargamos el controlador de errores.
            $controller = new Errores();
            
        }   

    }   
}  
?>