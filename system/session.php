<?php
session_start();

if(!isset($_SESSION['id_empleado'])) {
    header("Location: ../logout.php");
    exit();
}


require 'config.php';

// Usamos el campo de cédula guardado en sesión
$cedula = $_SESSION['cedula'];

$query = "SELECT * FROM empleado WHERE cedula = '$cedula' LIMIT 1";
$result = mysqli_query($connection, $query);

if(mysqli_num_rows($result) == 0) {
    header("Location: ../logout.php");
    exit();
}

$empleado = mysqli_fetch_assoc($result);

// Verifica que el empleado esté activo
if($empleado['estado'] != 1) {
    header("Location: ../logout.php");
    exit();
}
