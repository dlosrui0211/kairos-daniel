<?php
session_start();
require_once __DIR__ . "/config_oauth.php";
require_once __DIR__ . "/modelo/Conexion.php";
require_once __DIR__ . "/modelo/Usuario.php";
require_once __DIR__ . "/controller/UsuarioController.php";

$controller = new UsuarioController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['credential'])) {
    $googleToken = $_POST['credential'];
    
    $resultado = $controller->loginGoogle($googleToken);
    
    if ($resultado['success']) {
        // Login exitoso, redirigir según rol
        $rol = $_SESSION['rol'] ?? 3;
        
        switch ($rol) {
            case 1: // Administrador
                header("Location: /admin/usuarios.php");
                exit;
            case 2: // Trabajador
                header("Location: /admin/productos.php");
                exit;
            case 3: // Cliente
            default:
                header("Location: /index.php");
                exit;
        }
    } else {
        // Error en login de Google
        $_SESSION['error_google'] = $resultado['message'];
        header("Location: login.php");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>