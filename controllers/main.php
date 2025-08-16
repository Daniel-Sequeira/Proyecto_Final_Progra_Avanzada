<?php

class Main extends Controller {

    function __construct(){
        parent::__construct();
      
    }
      function index(){
        $this->view->render('main/index');
    }

   
}
?>