<?php
require_once __DIR__ . "/../model/Conexion.php";

class ValoracionController {
    private $conexion;

    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    // ============================================
    // OBTENER VALORACIONES DE UN PRODUCTO
    // ============================================
    public function obtenerPorProducto($id_producto) {
        try {
            $sql = "SELECT v.*, u.username, u.nombre
                    FROM valoracion_producto v
                    INNER JOIN usuario u ON v.id_usuario = u.id
                    WHERE v.id_producto = :id_producto
                    ORDER BY v.fecha_valoracion DESC";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    // ============================================
    // OBTENER VALORACIÓN DE UN USUARIO A UN PRODUCTO
    // ============================================
    public function obtenerValoracionUsuario($id_usuario, $id_producto) {
        try {
            $sql = "SELECT * FROM valoracion_producto
                    WHERE id_usuario = :id_usuario
                    AND id_producto = :id_producto";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return null;
        }
    }

    // ============================================
    // INSERTAR O ACTUALIZAR VALORACIÓN
    // ============================================
    public function guardarValoracion($id_usuario, $id_producto, $puntuacion, $comentario = null) {
        try {
            $sql = "INSERT INTO valoracion_producto 
                    (id_usuario, id_producto, puntuacion, comentario)
                    VALUES (:id_usuario, :id_producto, :puntuacion, :comentario)
                    ON DUPLICATE KEY UPDATE
                        puntuacion = VALUES(puntuacion),
                        comentario = VALUES(comentario),
                        fecha_valoracion = CURRENT_TIMESTAMP";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
            $stmt->bindParam(':puntuacion', $puntuacion, PDO::PARAM_INT);
            $stmt->bindParam(':comentario', $comentario, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    // ============================================
    // ELIMINAR VALORACIÓN
    // ============================================
    public function eliminarValoracion($id_usuario, $id_producto) {
        try {
            $sql = "DELETE FROM valoracion_producto
                    WHERE id_usuario = :id_usuario
                    AND id_producto = :id_producto";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    // ============================================
    // OBTENER MEDIA DE VALORACIONES DE UN PRODUCTO
    // ============================================
    public function obtenerMediaProducto($id_producto) {
        try {
            $sql = "SELECT 
                        AVG(puntuacion) as media,
                        COUNT(*) as total
                    FROM valoracion_producto
                    WHERE id_producto = :id_producto";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [
                'media' => 0,
                'total' => 0
            ];
        }
    }

    // ============================================
    // COMPROBAR SI UN USUARIO YA VALORÓ UN PRODUCTO
    // ============================================
    public function existeValoracion($id_usuario, $id_producto) {
        try {
            $sql = "SELECT COUNT(*) FROM valoracion_producto
                    WHERE id_usuario = :id_usuario
                    AND id_producto = :id_producto";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchColumn() > 0;
        } catch (Exception $e) {
            return false;
        }
    }

        public function obtenerTodasValoraciones() {
        try {
            $sql = "SELECT 
                        v.*,
                        u.username,
                        u.nombre,
                        p.titulo as producto_titulo,
                        pl.nombre as plataforma_nombre
                    FROM valoracion_producto v
                    INNER JOIN usuario u ON v.id_usuario = u.id
                    INNER JOIN producto p ON v.id_producto = p.id
                    LEFT JOIN plataforma pl ON p.platform_id = pl.id
                    ORDER BY v.fecha_valoracion DESC";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error en obtenerTodasValoraciones: " . $e->getMessage());
            return [];
        }
    }

}
?>