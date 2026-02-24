<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/plain; charset=utf-8');

echo '=== DIAGNOSTICO KAIROS ===

';

// Test conexion
try {
    require_once __DIR__ . '/model/Conexion.php';
     = new Conexion();
     = ->getConexion();
    echo '[OK] Conexion a BD exitosa
';
} catch (Exception ) {
    echo '[ERROR] Conexion: ' . ->getMessage() . '
';
    exit;
}

// Check tables
 = ['plataforma','producto','usuario','valoracion_producto','carrito','carrito_producto'];
foreach ( as ) {
    try {
         = ->query('SELECT COUNT(*) as c FROM ' . );
         = ->fetch(PDO::FETCH_ASSOC);
        echo '[OK] Tabla ' .  . ' existe - ' . ['c'] . ' registros
';
    } catch (Exception ) {
        echo '[ERROR] Tabla ' .  . ': ' . ->getMessage() . '
';
    }
}

// Check usuarios
echo '
=== USUARIOS ===
';
try {
     = ->query('SELECT id, username, correo, nombre, rol FROM usuario LIMIT 5');
     = ->fetchAll(PDO::FETCH_ASSOC);
    foreach ( as ) {
        echo 'ID=' . ['id'] . ' user=' . ['username'] . ' email=' . ['correo'] . ' rol=' . ['rol'] . '
';
    }
    if (empty()) echo '(sin usuarios)
';
} catch (Exception ) {
    echo '[ERROR] ' . ->getMessage() . '
';
}

// Check productos 
echo '
=== PRODUCTOS (primeros 5) ===
';
try {
     = ->query('SELECT id, titulo, platform_id FROM producto LIMIT 5');
     = ->fetchAll(PDO::FETCH_ASSOC);
    foreach ( as ) {
        echo 'ID=' . ['id'] . ' titulo=' . ['titulo'] . ' platform=' . ['platform_id'] . '
';
    }
    if (empty()) echo '(sin productos)
';
} catch (Exception ) {
    echo '[ERROR] ' . ->getMessage() . '
';
}

// Check valoraciones
echo '
=== VALORACIONES ===
';
try {
     = ->query('SELECT * FROM valoracion_producto LIMIT 5');
     = ->fetchAll(PDO::FETCH_ASSOC);
    foreach ( as ) {
        echo 'usuario=' . ['id_usuario'] . ' producto=' . ['id_producto'] . ' puntuacion=' . ['puntuacion'] . '
';
    }
    if (empty()) echo '(sin valoraciones)
';
} catch (Exception ) {
    echo '[ERROR] ' . ->getMessage() . '
';
}

// Test inserting a valoracion
echo '
=== TEST INSERT VALORACION ===
';
try {
    // Get first user and product
     = ->query('SELECT id FROM usuario LIMIT 1');
     = ->fetch(PDO::FETCH_ASSOC);
     = ->query('SELECT id FROM producto LIMIT 1');
     = ->fetch(PDO::FETCH_ASSOC);
    
    if ( && ) {
        echo 'Intentando insertar: usuario=' . ['id'] . ' producto=' . ['id'] . '
';
         = 'INSERT INTO valoracion_producto (id_usuario, id_producto, puntuacion, comentario) VALUES (:u, :p, 5, :c) ON DUPLICATE KEY UPDATE puntuacion = VALUES(puntuacion), comentario = VALUES(comentario)';
         = ->prepare();
        ->execute([':u' => ['id'], ':p' => ['id'], ':c' => 'Test diagnostic']);
        echo '[OK] Insert exitoso
';
        
        // Clean up test
        ->prepare('DELETE FROM valoracion_producto WHERE id_usuario = :u AND id_producto = :p AND comentario = :c')->execute([':u' => ['id'], ':p' => ['id'], ':c' => 'Test diagnostic']);
        echo '[OK] Limpieza exitosa
';
    } else {
        echo '[WARN] No hay usuarios o productos para probar
';
    }
} catch (Exception ) {
    echo '[ERROR] Insert: ' . ->getMessage() . '
';
}
?>