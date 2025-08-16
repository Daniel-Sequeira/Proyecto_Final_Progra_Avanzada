<?php  
//Controlador padre
class Controller{
    //propiedades que almacenan instancias de la vista y el modelo, controladores hijos podrán acceder a ellas.
    
    
//Constructor de la clase
    function __construct(){
        //Instancia de objeto de la clase view, se asigna a la propiedad view.
        $this->view = new View();
    }

    function loadModel($model){
        $url = 'models/' . $model . 'model.php';
        if(file_exists($url)){
            require $url;
            $modelName = $model . 'Model';
            $this->model = new $modelName();
        }
    } 

     // Método universal para renderizar cualquier vista con datos
    function render($vista, $data = []) {
    foreach ($data as $key => $value) {
        $$key = $value;
    }
    require 'views/' . $vista . '.php';
    }
    
     // Método index universal y dinámico
    public function index($data = []) {
        $clase = get_class($this); // Ej: 'Empleado'
        $vistaCarpeta = strtolower($clase); // pasa a ser 'empleado'
        $this->view->render($vistaCarpeta . '/index', $data); // Renderiza la vista de forma dinamica segun cada carpeta.
    }

    public function existPOST($params) {
        foreach ($params as $param) {
            if (!isset($_POST[$param])) {
                return false;
            }
        }
        return true;
    }

     public function getPost($name) {
        return isset($_POST[$name]) ? $_POST[$name] : '';
    }

     public function redirect($route, $params = []) {
        $data = [];
        foreach($params as $key => $value){
            $data[] = $key . '=' . urlencode($value);
        }
        $queryString = '';
        if (count($data) > 0) {
            $queryString = '?' . implode('&', $data);
        }
        $baseUrl = rtrim(constant('URL'), '/');
        $route = ltrim($route, '/');
        header('Location: ' . $baseUrl . '/' . $route . $queryString);
        exit();
    }


    
   
}


?>