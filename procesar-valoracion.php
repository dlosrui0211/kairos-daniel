<?php
session_start();
require_once __DIR__ . "/model/Conexion.php";
require_once __DIR__ . "/controller/ValoracionController.php";

header('Content-Type: application/json');

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Debes estar logueado para valorar productos'
    ]);
    exit;
}

// Obtener datos del POST
$data = json_decode(file_get_contents('php://input'), true);

// Validar datos
if (!isset($data['id_producto']) || !isset($data['puntuacion'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);
    exit;
}

$id_producto = (int)$data['id_producto'];
$puntuacion = (int)$data['puntuacion'];
$comentario = isset($data['comentario']) ? trim($data['comentario']) : null;
$id_usuario = $_SESSION['usuario_id'];

// Validar que la puntuación esté entre 1 y 5
if ($puntuacion < 1 || $puntuacion > 5) {
    echo json_encode([
        'success' => false,
        'message' => 'La puntuación debe estar entre 1 y 5'
    ]);
    exit;
}

// Validar que el comentario no supere 500 caracteres
if ($comentario && strlen($comentario) > 500) {
    echo json_encode([
        'success' => false,
        'message' => 'El comentario no puede superar 500 caracteres'
    ]);
    exit;
}

try {
    $valoracionController = new ValoracionController();
    
    // Guardar la valoración
    $resultado = $valoracionController->guardarValoracion(
        $id_usuario,
        $id_producto,
        $puntuacion,
        $comentario
    );

    if ($resultado) {
        echo json_encode([
            'success' => true,
            'message' => 'Valoración guardada correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al guardar la valoración'
        ]);
    }
} catch (Exception $e) {
    error_log("Error en procesar-valoracion.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor'
    ]);
}
?>