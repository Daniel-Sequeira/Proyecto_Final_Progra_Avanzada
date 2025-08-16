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
    
     // Método index universal y dinámico
    public function index() {
        $clase = get_class($this); // Ej: 'Empleado'
        $vistaCarpeta = strtolower($clase); // pasa a ser 'empleado'
        $this->view->render($vistaCarpeta . '/index'); // Renderiza la vista de forma dinamica segun cada carpeta.
    }

   
}


?>