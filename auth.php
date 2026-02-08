<?php
// Iniciar sesión y configurar respuesta JSON
session_start();
header('Content-Type: application/json');

require_once "modelo/Conexion.php";
require_once "modelo/Usuario.php";
require_once "controlador/UsuarioController.php";

$controller = new UsuarioController();
$accion = $_POST['accion'] ?? $_GET['accion'] ?? null;
$response = ["success" => false, "message" => "Acción no válida"];

try {
    switch ($accion) {
        
        // Login tradicional
        case 'login':
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $response = $controller->login($username, $password);
            
            if ($response['success']) {
                $rol = $_SESSION['rol'] ?? 3;
                
                switch ($rol) {
                    case 1: // Administrador
                        $redirectUrl = 'admin-usuarios.php';
                        break;
                    case 2: // Trabajador
                        $redirectUrl = 'admin-productos.php';
                        break;
                    case 3: // Cliente
                    default:
                        $redirectUrl = 'index.php';
                        break;
                }
                
                $response['rol'] = $rol;
                $response['rol_nombre'] = $rol == 1 ? 'Administrador' : ($rol == 2 ? 'Trabajador' : 'Cliente');
                $response['redirect'] = $redirectUrl;
            }
            break;
        
        // Registro de nuevo usuario
        case 'registrar':
            $datos = [
                'username' => $_POST['username'] ?? '',
                'password' => $_POST['password'] ?? '',
                'nombre' => $_POST['nombre'] ?? '',
                'apellidos' => $_POST['apellidos'] ?? '',
                'correo' => $_POST['correo'] ?? '',
                'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
                'codigo_postal' => $_POST['codigo_postal'] ?? '',
                'telefono' => $_POST['telefono'] ?? ''
            ];
            
            $response = $controller->registrar($datos);
            break;
        
        // Login con Google
        case 'loginGoogle':
            $googleToken = $_POST['token'] ?? '';
            
            $response = $controller->loginGoogle($googleToken);
            
            if ($response['success']) {
                $rol = $_SESSION['rol'] ?? 3;
                
                switch ($rol) {
                    case 1: // Administrador
                        $redirectUrl = 'admin-usuarios.php';
                        break;
                    case 2: // Trabajador
                        $redirectUrl = 'admin-productos.php';
                        break;
                    case 3: // Cliente
                    default:
                        $redirectUrl = 'index.php';
                        break;
                }
                
                $response['rol'] = $rol;
                $response['rol_nombre'] = $rol == 1 ? 'Administrador' : ($rol == 2 ? 'Trabajador' : 'Cliente');
                $response['redirect'] = $redirectUrl;
            }
            break;
        
        // Cerrar sesión
        case 'logout':
            $response = $controller->logout();
            break;
        
        // Verificar sesión activa
        case 'verificarSesion':
            if ($controller->verificarSesion()) {
                $usuario = $controller->usuarioActual();
                $rol = $_SESSION['rol'] ?? 3;
                $esAdmin = ($rol == 1 || $rol == 2);
                
                $response = [
                    "success" => true,
                    "logueado" => true,
                    "usuario" => $usuario,
                    "rol" => $rol,
                    "rol_nombre" => $rol == 1 ? 'Administrador' : ($rol == 2 ? 'Trabajador' : 'Cliente'),
                    "es_admin" => $esAdmin
                ];
            } else {
                $response = [
                    "success" => true,
                    "logueado" => false
                ];
            }
            break;
        
        // Obtener usuario actual
        case 'obtenerUsuario':
            $usuario = $controller->usuarioActual();
            
            if ($usuario) {
                $rol = $_SESSION['rol'] ?? 3;
                $esAdmin = ($rol == 1 || $rol == 2);
                
                $response = [
                    "success" => true,
                    "usuario" => $usuario,
                    "rol" => $rol,
                    "rol_nombre" => $rol == 1 ? 'Administrador' : ($rol == 2 ? 'Trabajador' : 'Cliente'),
                    "es_admin" => $esAdmin
                ];
            } else {
                $response = [
                    "success" => false,
                    "message" => "No hay usuario logueado"
                ];
            }
            break;
        
        default:
            // Acción no reconocida
            $response = ["success" => false, "message" => "Acción no encontrada"];
    }
    
} catch (Exception $e) {
    $response = ["success" => false, "message" => "Error: " . $e->getMessage()];
}

echo json_encode($response);
?>