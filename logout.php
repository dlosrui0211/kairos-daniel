<?php 
session_start();
require_once __DIR__ . "/controlador/UsuarioController.php";

// Usar el método logout del controller
$controller = new UsuarioController();
$controller->logout();

// Redireccionar al login
header("Location: login.php");
exit();
?>