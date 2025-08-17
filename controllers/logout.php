<?php
class Logout extends Controller {
    public function index($data = []) {
        session_start();
        $_SESSION = [];
        session_destroy();
        header("Location: " . constant('URL') . "login");
        exit();
    }
}
?>