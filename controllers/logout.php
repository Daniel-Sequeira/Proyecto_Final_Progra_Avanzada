<?php
class Logout extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index($data= []) {
        session_unset();
        session_destroy();
        // Redirige al login
        $this->redirect('login', []);
        exit();
    }
}
?>