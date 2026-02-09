<?php
require_once __DIR__ . "/../modelo/Conexion.php";

class ProductoController {
    private $conexion;

    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    // ============================================
    // OBTENER TODOS LOS PRODUCTOS
    // ============================================
    public function obtenerTodos() {
        try {
            $sql = "SELECT p.*, pl.nombre as plataforma_nombre 
                    FROM producto p
                    LEFT JOIN plataforma pl ON p.platform_id = pl.id
                    ORDER BY p.id DESC";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    // ============================================
    // OBTENER PRODUCTOS POR PLATAFORMA
    // ============================================
    public function obtenerPorPlataforma($platform_id) {
        try {
            $sql = "SELECT p.*, pl.nombre as plataforma_nombre 
                    FROM producto p
                    LEFT JOIN plataforma pl ON p.platform_id = pl.id
                    WHERE p.platform_id = :platform_id
                    ORDER BY p.id DESC";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':platform_id', $platform_id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    // ============================================
    // OBTENER PRODUCTO POR ID
    // ============================================
    public function obtenerPorId($id) {
        try {
            $sql = "SELECT p.*, pl.nombre as plataforma_nombre, m.nombre as modo_nombre
                    FROM producto p
                    LEFT JOIN plataforma pl ON p.platform_id = pl.id
                    LEFT JOIN modo_juego m ON p.modo = m.id
                    WHERE p.id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return null;
        }
    }

    // ============================================
    // OBTENER GÉNEROS DE UN PRODUCTO
    // ============================================
    public function obtenerGeneros($producto_id) {
        try {
            $sql = "SELECT g.* FROM genero g
                    INNER JOIN producto_genero pg ON g.id = pg.id_genero
                    WHERE pg.id_producto = :producto_id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    /**
 * Obtener géneros de un producto específico
 */
public function obtenerGenerosProducto($idProducto) {
    try {
        $sql = "SELECT g.id, g.nombre 
                FROM genero g
                INNER JOIN producto_genero pg ON g.id = pg.id_genero
                WHERE pg.id_producto = :id_producto
                ORDER BY g.nombre ASC";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_producto', $idProducto, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Error en obtenerGenerosProducto: " . $e->getMessage());
        return [];
    }
}


    // ============================================
    // CALCULAR PRECIO CON DESCUENTO
    // ============================================
    public function calcularPrecioFinal($precio, $descuento) {
        if ($descuento > 0) {
            return $precio - ($precio * $descuento / 100);
        }
        return $precio;
    }

    // ============================================
    // OBTENER PLATAFORMAS
    // ============================================
    public function obtenerPlataformas() {
        try {
            $sql = "SELECT * FROM plataforma ORDER BY nombre";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }


        public function obtenerTodosGeneros() {
        try {
            $sql = "SELECT * FROM genero ORDER BY nombre";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    // ============================================
    // OBTENER TODOS LOS MODOS DE JUEGO
    // ============================================
    public function obtenerTodosModos() {
        try {
            $sql = "SELECT * FROM modo_juego ORDER BY nombre";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    // ============================================
    // CREAR PRODUCTO
    // ============================================
    public function crearProducto($datos, $archivos) {
        try {
            // Validar campos obligatorios
            $camposObligatorios = ['titulo', 'precio', 'stock', 'platform_id', 'modo', 'descripcion'];
            
            foreach ($camposObligatorios as $campo) {
                if (empty($datos[$campo]) && $datos[$campo] !== '0') {
                    return ["success" => false, "message" => "Campo requerido: $campo"];
                }
            }

            // Validar que se haya seleccionado al menos un género
            if (empty($datos['generos']) || !is_array($datos['generos'])) {
                return ["success" => false, "message" => "Debe seleccionar al menos un género"];
            }

            // Procesar imagen de portada
            $coverPath = 'assets/img/placeholder.png'; // Valor por defecto
            
            if (isset($archivos['cover']) && $archivos['cover']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../assets/img/';
                $fileName = time() . '_' . basename($archivos['cover']['name']);
                $targetPath = $uploadDir . $fileName;
                
                // Validar que sea una imagen
                $imageInfo = getimagesize($archivos['cover']['tmp_name']);
                if ($imageInfo === false) {
                    return ["success" => false, "message" => "El archivo no es una imagen válida"];
                }
                
                if (move_uploaded_file($archivos['cover']['tmp_name'], $targetPath)) {
                    $coverPath = 'assets/img/' . $fileName;
                }
            }

            // Insertar producto
            $sql = "INSERT INTO producto 
                    (titulo, cover, platform_id, descuento, precio, modo, descripcion, stock, fecha_lanzamiento) 
                    VALUES 
                    (:titulo, :cover, :platform_id, :descuento, :precio, :modo, :descripcion, :stock, :fecha_lanzamiento)";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':titulo', $datos['titulo'], PDO::PARAM_STR);
            $stmt->bindParam(':cover', $coverPath, PDO::PARAM_STR);
            $stmt->bindParam(':platform_id', $datos['platform_id'], PDO::PARAM_INT);
            
            $descuento = $datos['descuento'] ?? 0;
            $stmt->bindParam(':descuento', $descuento, PDO::PARAM_INT);
            $stmt->bindParam(':precio', $datos['precio'], PDO::PARAM_STR);
            $stmt->bindParam(':modo', $datos['modo'], PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $datos['descripcion'], PDO::PARAM_STR);
            $stmt->bindParam(':stock', $datos['stock'], PDO::PARAM_INT);
            
            $fechaLanzamiento = !empty($datos['fecha_lanzamiento']) ? $datos['fecha_lanzamiento'] : null;
            $stmt->bindParam(':fecha_lanzamiento', $fechaLanzamiento, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $productoId = $this->conexion->lastInsertId();
                
                // Insertar géneros
                foreach ($datos['generos'] as $generoId) {
                    $sqlGenero = "INSERT INTO producto_genero (id_producto, id_genero) VALUES (:producto, :genero)";
                    $stmtGenero = $this->conexion->prepare($sqlGenero);
                    $stmtGenero->bindParam(':producto', $productoId, PDO::PARAM_INT);
                    $stmtGenero->bindParam(':genero', $generoId, PDO::PARAM_INT);
                    $stmtGenero->execute();
                }
                
                return ["success" => true, "message" => "Producto creado correctamente"];
            } else {
                return ["success" => false, "message" => "Error al crear producto"];
            }

        } catch (Exception $e) {
            return ["success" => false, "message" => "Error: " . $e->getMessage()];
        }
    }

    // ============================================
    // ACTUALIZAR PRODUCTO
    // ============================================
    public function actualizarProducto($datos, $archivos) {
        try {
            // Validar que el ID esté presente
            if (empty($datos['id'])) {
                return ["success" => false, "message" => "ID de producto requerido"];
            }

            // Validar que se haya seleccionado al menos un género
            if (empty($datos['generos']) || !is_array($datos['generos'])) {
                return ["success" => false, "message" => "Debe seleccionar al menos un género"];
            }

            // Obtener producto actual para mantener la imagen si no se sube nueva
            $productoActual = $this->obtenerPorId($datos['id']);
            $coverPath = $productoActual['cover'];
            
            // Procesar nueva imagen si se subió
            if (isset($archivos['cover']) && $archivos['cover']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../assets/img/';
                $fileName = time() . '_' . basename($archivos['cover']['name']);
                $targetPath = $uploadDir . $fileName;
                
                // Validar que sea una imagen
                $imageInfo = getimagesize($archivos['cover']['tmp_name']);
                if ($imageInfo === false) {
                    return ["success" => false, "message" => "El archivo no es una imagen válida"];
                }
                
                if (move_uploaded_file($archivos['cover']['tmp_name'], $targetPath)) {
                    // Eliminar imagen anterior si no es placeholder
                    if ($productoActual['cover'] !== 'assets/img/placeholder.png' && file_exists($productoActual['cover'])) {
                        @unlink($productoActual['cover']);
                    }
                    $coverPath = 'assets/img/' . $fileName;
                }
            }

            // Actualizar producto
            $sql = "UPDATE producto SET 
                    titulo = :titulo,
                    cover = :cover,
                    platform_id = :platform_id,
                    descuento = :descuento,
                    precio = :precio,
                    modo = :modo,
                    descripcion = :descripcion,
                    stock = :stock,
                    fecha_lanzamiento = :fecha_lanzamiento
                    WHERE id = :id";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':titulo', $datos['titulo'], PDO::PARAM_STR);
            $stmt->bindParam(':cover', $coverPath, PDO::PARAM_STR);
            $stmt->bindParam(':platform_id', $datos['platform_id'], PDO::PARAM_INT);
            
            $descuento = $datos['descuento'] ?? 0;
            $stmt->bindParam(':descuento', $descuento, PDO::PARAM_INT);
            $stmt->bindParam(':precio', $datos['precio'], PDO::PARAM_STR);
            $stmt->bindParam(':modo', $datos['modo'], PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $datos['descripcion'], PDO::PARAM_STR);
            $stmt->bindParam(':stock', $datos['stock'], PDO::PARAM_INT);
            
            $fechaLanzamiento = !empty($datos['fecha_lanzamiento']) ? $datos['fecha_lanzamiento'] : null;
            $stmt->bindParam(':fecha_lanzamiento', $fechaLanzamiento, PDO::PARAM_STR);
            $stmt->bindParam(':id', $datos['id'], PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Eliminar géneros anteriores
                $sqlDeleteGeneros = "DELETE FROM producto_genero WHERE id_producto = :producto";
                $stmtDelete = $this->conexion->prepare($sqlDeleteGeneros);
                $stmtDelete->bindParam(':producto', $datos['id'], PDO::PARAM_INT);
                $stmtDelete->execute();
                
                // Insertar nuevos géneros
                foreach ($datos['generos'] as $generoId) {
                    $sqlGenero = "INSERT INTO producto_genero (id_producto, id_genero) VALUES (:producto, :genero)";
                    $stmtGenero = $this->conexion->prepare($sqlGenero);
                    $stmtGenero->bindParam(':producto', $datos['id'], PDO::PARAM_INT);
                    $stmtGenero->bindParam(':genero', $generoId, PDO::PARAM_INT);
                    $stmtGenero->execute();
                }
                
                return ["success" => true, "message" => "Producto actualizado correctamente"];
            } else {
                return ["success" => false, "message" => "Error al actualizar producto"];
            }

        } catch (Exception $e) {
            return ["success" => false, "message" => "Error: " . $e->getMessage()];
        }
    }

    // ============================================
    // ELIMINAR PRODUCTO
    // ============================================
    public function eliminarProducto($id) {
        try {
            // Obtener producto para eliminar imagen
            $producto = $this->obtenerPorId($id);
            
            // Eliminar producto (las relaciones se eliminan por CASCADE)
            $sql = "DELETE FROM producto WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Eliminar imagen si no es placeholder
                if ($producto && $producto['cover'] !== 'assets/img/placeholder.png' && file_exists($producto['cover'])) {
                    @unlink($producto['cover']);
                }
                
                return ["success" => true, "message" => "Producto eliminado correctamente"];
            } else {
                return ["success" => false, "message" => "Error al eliminar producto"];
            }

        } catch (Exception $e) {
            return ["success" => false, "message" => "Error: " . $e->getMessage()];
        }
    }


}

?>