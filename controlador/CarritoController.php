<?php
require_once __DIR__ . "/../model/Conexion.php";
require_once __DIR__ . "/../model/Carrito.php";
require_once __DIR__ . "/../model/CarritoProducto.php";

class CarritoController {
    private $conexion;
    private $carrito;

    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    // ============================================
    // OBTENER O CREAR CARRITO DEL USUARIO
    // ============================================
    private function obtenerOCrearCarritoUsuario($idUsuario) {
        try {
            $sql = "SELECT id FROM carrito WHERE id_usuario = :id_usuario";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($resultado) {
                return $resultado['id'];
            }
            
            // Si no existe carrito, crear uno nuevo
            $sql = "INSERT INTO carrito (id_usuario) VALUES (:id_usuario)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            return $this->conexion->lastInsertId();
        } catch (Exception $e) {
            error_log("Error en obtenerOCrearCarritoUsuario: " . $e->getMessage());
            return null;
        }
    }

    // ============================================
    // OBTENER PRODUCTOS DEL CARRITO
    // ============================================
    public function obtenerProductosCarrito($idUsuario) {
        if (!$idUsuario) {
            return [];
        }
        
        try {
            $idCarrito = $this->obtenerOCrearCarritoUsuario($idUsuario);
            
            if (!$idCarrito) {
                return [];
            }
            
            $sql = "SELECT 
                        p.id,
                        p.titulo,
                        p.cover,
                        p.precio,
                        p.descuento,
                        cp.cantidad,
                        pl.nombre as plataforma_nombre
                    FROM carrito_producto cp
                    INNER JOIN producto p ON cp.id_producto = p.id
                    LEFT JOIN plataforma pl ON p.platform_id = pl.id
                    WHERE cp.id_carrito = :id_carrito
                    ORDER BY cp.fecha_agregado DESC";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_carrito', $idCarrito, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error en obtenerProductosCarrito: " . $e->getMessage());
            return [];
        }
    }

    // ============================================
    // AGREGAR PRODUCTO AL CARRITO
    // ============================================
    public function agregarProducto($idUsuario, $idProducto, $cantidad = 1) {
        if (!$idUsuario || !$idProducto || $cantidad < 1) {
            throw new Exception("Parámetros inválidos");
        }
        
        try {
            $idCarrito = $this->obtenerOCrearCarritoUsuario($idUsuario);
            
            if (!$idCarrito) {
                throw new Exception("No se pudo crear o obtener el carrito");
            }
            
            // Verificar si el producto ya está en el carrito
            $sql = "SELECT cantidad FROM carrito_producto 
                    WHERE id_carrito = :id_carrito AND id_producto = :id_producto";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_carrito', $idCarrito, PDO::PARAM_INT);
            $stmt->bindParam(':id_producto', $idProducto, PDO::PARAM_INT);
            $stmt->execute();
            $productoExistente = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($productoExistente) {
                // Si existe, incrementar cantidad
                $nuevaCantidad = $productoExistente['cantidad'] + $cantidad;
                $sql = "UPDATE carrito_producto 
                        SET cantidad = :cantidad 
                        WHERE id_carrito = :id_carrito AND id_producto = :id_producto";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':cantidad', $nuevaCantidad, PDO::PARAM_INT);
                $stmt->bindParam(':id_carrito', $idCarrito, PDO::PARAM_INT);
                $stmt->bindParam(':id_producto', $idProducto, PDO::PARAM_INT);
                return $stmt->execute();
            } else {
                // Si no existe, insertar nuevo producto
                $sql = "INSERT INTO carrito_producto (id_carrito, id_producto, cantidad) 
                        VALUES (:id_carrito, :id_producto, :cantidad)";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':id_carrito', $idCarrito, PDO::PARAM_INT);
                $stmt->bindParam(':id_producto', $idProducto, PDO::PARAM_INT);
                $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
                return $stmt->execute();
            }
        } catch (Exception $e) {
            error_log("Error en agregarProducto: " . $e->getMessage());
            throw $e;
        }
    }

    // ============================================
    // ACTUALIZAR CANTIDAD DE UN PRODUCTO
    // ============================================
    public function actualizarCantidad($idUsuario, $idProducto, $cantidad) {
        if (!$idUsuario || !$idProducto || $cantidad < 1) {
            throw new Exception("Parámetros inválidos");
        }
        
        try {
            $idCarrito = $this->obtenerOCrearCarritoUsuario($idUsuario);
            
            if (!$idCarrito) {
                throw new Exception("Carrito no encontrado");
            }
            
            $sql = "UPDATE carrito_producto 
                    SET cantidad = :cantidad 
                    WHERE id_carrito = :id_carrito AND id_producto = :id_producto";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':id_carrito', $idCarrito, PDO::PARAM_INT);
            $stmt->bindParam(':id_producto', $idProducto, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en actualizarCantidad: " . $e->getMessage());
            throw $e;
        }
    }

    // ============================================
    // ELIMINAR PRODUCTO DEL CARRITO
    // ============================================
    public function eliminarProducto($idUsuario, $idProducto) {
        if (!$idUsuario || !$idProducto) {
            throw new Exception("Parámetros inválidos");
        }
        
        try {
            $idCarrito = $this->obtenerOCrearCarritoUsuario($idUsuario);
            
            if (!$idCarrito) {
                throw new Exception("Carrito no encontrado");
            }
            
            $sql = "DELETE FROM carrito_producto 
                    WHERE id_carrito = :id_carrito AND id_producto = :id_producto";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_carrito', $idCarrito, PDO::PARAM_INT);
            $stmt->bindParam(':id_producto', $idProducto, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en eliminarProducto: " . $e->getMessage());
            throw $e;
        }
    }

    // ============================================
    // VACIAR CARRITO COMPLETO
    // ============================================
    public function vaciarCarrito($idUsuario) {
        if (!$idUsuario) {
            throw new Exception("Usuario no especificado");
        }
        
        try {
            $idCarrito = $this->obtenerOCrearCarritoUsuario($idUsuario);
            
            if (!$idCarrito) {
                throw new Exception("Carrito no encontrado");
            }
            
            $sql = "DELETE FROM carrito_producto WHERE id_carrito = :id_carrito";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_carrito', $idCarrito, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en vaciarCarrito: " . $e->getMessage());
            throw $e;
        }
    }

    // ============================================
    // CALCULAR TOTAL DEL CARRITO
    // ============================================
    public function calcularTotal($idUsuario) {
        $productos = $this->obtenerProductosCarrito($idUsuario);
        $total = 0;
        
        foreach ($productos as $producto) {
            $precioFinal = $this->calcularPrecioFinal($producto['precio'], $producto['descuento']);
            $total += $precioFinal * $producto['cantidad'];
        }
        
        return round($total, 2);
    }

    // ============================================
    // CONTAR PRODUCTOS EN EL CARRITO
    // ============================================
    public function contarProductos($idUsuario) {
        if (!$idUsuario) {
            return 0;
        }
        
        try {
            $idCarrito = $this->obtenerOCrearCarritoUsuario($idUsuario);
            
            if (!$idCarrito) {
                return 0;
            }
            
            $sql = "SELECT COALESCE(SUM(cantidad), 0) as total 
                    FROM carrito_producto 
                    WHERE id_carrito = :id_carrito";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_carrito', $idCarrito, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return intval($result['total']);
        } catch (Exception $e) {
            error_log("Error en contarProductos: " . $e->getMessage());
            return 0;
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
    // VERIFICAR SI PRODUCTO EXISTE EN CARRITO
    // ============================================
    public function productoEnCarrito($idUsuario, $idProducto) {
        try {
            $idCarrito = $this->obtenerOCrearCarritoUsuario($idUsuario);
            
            if (!$idCarrito) {
                return false;
            }
            
            $sql = "SELECT id_carrito FROM carrito_producto 
                    WHERE id_carrito = :id_carrito AND id_producto = :id_producto";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_carrito', $idCarrito, PDO::PARAM_INT);
            $stmt->bindParam(':id_producto', $idProducto, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error en productoEnCarrito: " . $e->getMessage());
            return false;
        }
    }

    // ============================================
    // OBTENER DATOS DEL CARRITO (para la vista)
    // ============================================
    public function obtenerDatosCarrito($idUsuario) {
        try {
            return [
                'productos' => $this->obtenerProductosCarrito($idUsuario),
                'total' => $this->calcularTotal($idUsuario),
                'total_items' => $this->contarProductos($idUsuario)
            ];
        } catch (Exception $e) {
            error_log("Error en obtenerDatosCarrito: " . $e->getMessage());
            return [
                'productos' => [],
                'total' => 0,
                'total_items' => 0
            ];
        }
    }
}
?>