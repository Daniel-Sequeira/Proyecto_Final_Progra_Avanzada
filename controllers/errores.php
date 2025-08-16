<?php
class Errores extends Controller {
    
    function __construct(){
        parent::__construct();
       
        echo "<p>Error: La página que buscas no existe.</p>";
       
    }
}

?>