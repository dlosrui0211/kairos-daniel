<?php
// carrito-acciones.php - Procesa las acciones del carrito
// Este archivo maneja: aumentar, disminuir, eliminar, vaciar, agregar

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
        // ============================================
        // AGREGAR PRODUCTO AL CARRITO
        // ============================================
        case 'agregar':
            if ($productoId) {
                $carritoController->agregarProducto($idUsuario, $productoId, 1);
            }
            break;

        // ============================================
        // AUMENTAR CANTIDAD
        // ============================================
        case 'aumentar':
            if ($productoId) {
                // Obtener cantidad actual
                $productos = $carritoController->obtenerProductosCarrito($idUsuario);
                $cantidadActual = 0;
                
                foreach ($productos as $producto) {
                    if ($producto['id'] == $productoId) {
                        $cantidadActual = $producto['cantidad'];
                        break;
                    }
                }
                
                // Actualizar con cantidad + 1
                $carritoController->actualizarCantidad($idUsuario, $productoId, $cantidadActual + 1);
            }
            break;

        // ============================================
        // DISMINUIR CANTIDAD
        // ============================================
        case 'disminuir':
            if ($productoId) {
                // Obtener cantidad actual
                $productos = $carritoController->obtenerProductosCarrito($idUsuario);
                $cantidadActual = 0;
                
                foreach ($productos as $producto) {
                    if ($producto['id'] == $productoId) {
                        $cantidadActual = $producto['cantidad'];
                        break;
                    }
                }
                
                // Si cantidad es 1, eliminar el producto
                if ($cantidadActual <= 1) {
                    $carritoController->eliminarProducto($idUsuario, $productoId);
                } else {
                    // Si es mayor, disminuir en 1
                    $carritoController->actualizarCantidad($idUsuario, $productoId, $cantidadActual - 1);
                }
            }
            break;

        // ============================================
        // ELIMINAR PRODUCTO
        // ============================================
        case 'eliminar':
            if ($productoId) {
                $carritoController->eliminarProducto($idUsuario, $productoId);
            }
            break;

        // ============================================
        // VACIAR CARRITO
        // ============================================
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