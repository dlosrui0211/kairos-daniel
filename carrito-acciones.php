<?php
// Procesar acciones del carrito: agregar, aumentar, disminuir, eliminar, vaciar
include("includes/a_config.php");
require_once __DIR__ . "/controlador/CarritoController.php";

$idUsuario = $_SESSION['usuario_id'] ?? null;

// Si no hay usuario logeado, redirige a login
if (!$idUsuario) {
    header("Location: login.php");
    exit;
}

$carritoController = new CarritoController();
$accion = $_POST['accion'] ?? $_GET['accion'] ?? null;
$productoId = $_POST['producto_id'] ?? $_GET['producto_id'] ?? null;

try {
    switch($accion) {
        // Agregar producto
        case 'agregar':
            if ($productoId) {
                $carritoController->agregarProducto($idUsuario, $productoId, 1);
            }
            break;

        // Aumentar cantidad
        case 'aumentar':
            if ($productoId) {
                $productos = $carritoController->obtenerProductosCarrito($idUsuario);
                $cantidadActual = 0;
                
                foreach ($productos as $producto) {
                    if ($producto['id'] == $productoId) {
                        $cantidadActual = $producto['cantidad'];
                        break;
                    }
                }
                
                $carritoController->actualizarCantidad($idUsuario, $productoId, $cantidadActual + 1);
            }
            break;

        // Disminuir cantidad
        case 'disminuir':
            if ($productoId) {
                $productos = $carritoController->obtenerProductosCarrito($idUsuario);
                $cantidadActual = 0;
                
                foreach ($productos as $producto) {
                    if ($producto['id'] == $productoId) {
                        $cantidadActual = $producto['cantidad'];
                        break;
                    }
                }
                
                if ($cantidadActual <= 1) {
                    $carritoController->eliminarProducto($idUsuario, $productoId);
                } else {
                    $carritoController->actualizarCantidad($idUsuario, $productoId, $cantidadActual - 1);
                }
            }
            break;

        // Eliminar producto
        case 'eliminar':
            if ($productoId) {
                $carritoController->eliminarProducto($idUsuario, $productoId);
            }
            break;

        // Vaciar carrito
        case 'vaciar':
            $carritoController->vaciarCarrito($idUsuario);
            break;
    }
} catch (Exception $e) {
    error_log("Error en carrito-acciones.php: " . $e->getMessage());
}

// Redirigir de vuelta a la página anterior (o a index si no hay referrer)
$referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header("Location: " . $referer);
exit;
?>