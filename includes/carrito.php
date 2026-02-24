<?php
// includes/carrito.php - Offcanvas Bootstrap con productos dinámicos desde BD

require_once __DIR__ . "/../controller/CarritoController.php";

$idUsuario = $_SESSION['usuario_id'] ?? null;
$carritoController = new CarritoController();
$productosCarrito = [];
$totalCarrito = 0;
$totalItems = 0;

if ($idUsuario) {
    $productosCarrito = $carritoController->obtenerProductosCarrito($idUsuario);
    $totalCarrito = $carritoController->calcularTotal($idUsuario);
    $totalItems = $carritoController->contarProductos($idUsuario);
}
?>

<!-- Offcanvas Carrito (se abre de derecha a izquierda) -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="cartModal" aria-labelledby="cartModalLabel">
    <!-- Header -->
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="cartModalLabel">Tu Carrito</h5>
        <button type="button" id="closeCartModal" class="btn-close" data-bs-dismiss="offcanvas"
            aria-label="Cerrar"></button>
    </div>

    <!-- Body - Lista de productos -->
    <div class="offcanvas-body">
        <div class="product-list" id="productList">

            <?php if (empty($productosCarrito)): ?>
            <!-- Carrito vacío -->
            <p class="text-center text-muted">El carrito está vacío</p>

            <?php else: ?>
            <!-- Productos del carrito -->
            <?php foreach ($productosCarrito as $producto): ?>
            <?php 
                        $precioFinal = $carritoController->calcularPrecioFinal($producto['precio'], $producto['descuento']);
                        $precioTotal = $precioFinal * $producto['cantidad'];
                    ?>
            <div class="list-group-item elemento-carrito" data-product-id="<?php echo $producto['id']; ?>"
                data-price="<?php echo number_format($precioFinal, 2, '.', ''); ?>">
                <div class="d-flex gap-3">
                    <!-- Imagen -->
                    <div class="flex-shrink-0">
                        <img src="<?php echo htmlspecialchars($producto['cover']); ?>"
                            alt="<?php echo htmlspecialchars($producto['titulo']); ?>" class="car-tula rounded"
                            style="width: 70px; height: 70px; object-fit: cover;">
                    </div>

                    <!-- Información -->
                    <div class="flex-grow-1">
                        <h6 class="mb-1 producto-title"><?php echo htmlspecialchars($producto['titulo']); ?></h6>
                        <p class="mb-0 product-price"><?php echo number_format($precioFinal, 2); ?>€</p>
                    </div>

                    <!-- Acciones: Cantidad + Eliminar -->
                    <div class="d-flex align-items-center gap-2">
                        <!-- Control de cantidad -->
                        <div class="item-quantity">
                            <!-- Botón decrementar -->
                            <form method="POST" action="carrito-acciones.php" style="display: inline;">
                                <input type="hidden" name="accion" value="disminuir">
                                <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                                <button type="submit" class="quantity-btn decrement-btn"
                                    aria-label="Disminuir cantidad">−</button>
                            </form>

                            <!-- Cantidad mostrada -->
                            <span class="quantity-display" data-quantity><?php echo $producto['cantidad']; ?></span>

                            <!-- Botón incrementar -->
                            <form method="POST" action="carrito-acciones.php" style="display: inline;">
                                <input type="hidden" name="accion" value="aumentar">
                                <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                                <button type="submit" class="quantity-btn increment-btn"
                                    aria-label="Aumentar cantidad">+</button>
                            </form>
                        </div>

                        <!-- Botón eliminar -->
                        <form method="POST" action="carrito-acciones.php" style="display: inline;">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                            <button type="submit" class="btn btn-sm remove-item-btn" aria-label="Eliminar producto">
                                <i class="bi bi-trash" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>

    <!-- Footer - Subtotal y botones -->
    <div class="offcanvas-footer">
        <div class="w-100">
            <!-- Subtotal -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="subtotal-text">Subtotal:</span>
                <span class="subtotal-price" id="subtotalPrice"><?php echo number_format($totalCarrito, 2); ?>€</span>
            </div>

            <!-- Botones -->
            <div class="d-grid gap-2">
                <a href="zonadepago.php" class="btn btn-primary btn-lg fw-bold">
                    COMPRAR
                </a>

                <?php if (!empty($productosCarrito)): ?>
                <form method="POST" action="carrito-acciones.php" style="width: 100%;">
                    <input type="hidden" name="accion" value="vaciar">
                    <button type="submit" class="btn btn-outline-secondary btn-lg fw-bold w-100">
                        ELIMINAR TODOS
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>