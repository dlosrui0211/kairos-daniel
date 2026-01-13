<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona de Pago - Kairos</title>
    <?php include("includes/head-tag-contents.php"); ?>
</head>
<body>
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>

    <main class="zona-pago-main">
        <div class="contenedor-pago">
            <div class="row g-0">
                <div class="col-md-7">
                    <div class="productos-list">
                        <div class="producto-item">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <img src="assets/img/fc26.jpg" alt="Producto 1" class="producto-img rounded" style="width: 55px; height: 55px; object-fit: cover;">
                                </div>

                                <div class="flex-grow-1">
                                    <h6 class="mb-1 producto-nombre">Producto 1</h6>
                                    <p class="mb-0 producto-precio">99€</p>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <div class="cantidad-control">
                                        <button class="cantidad-btn decrement-btn" aria-label="Disminuir">−</button>
                                        <span class="cantidad-valor">1</span>
                                        <button class="cantidad-btn increment-btn" aria-label="Aumentar">+</button>
                                    </div>

                                    <button class="btn btn-sm eliminar-btn" aria-label="Eliminar">
                                        🗑️
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="producto-item">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <img src="assets/img/fc26.jpg" alt="Producto 2" class="producto-img rounded" style="width: 55px; height: 55px; object-fit: cover;">
                                </div>

                                <div class="flex-grow-1">
                                    <h6 class="mb-1 producto-nombre">Producto 2</h6>
                                    <p class="mb-0 producto-precio">99€</p>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <div class="cantidad-control">
                                        <button class="cantidad-btn decrement-btn" aria-label="Disminuir">−</button>
                                        <span class="cantidad-valor">1</span>
                                        <button class="cantidad-btn increment-btn" aria-label="Aumentar">+</button>
                                    </div>

                                    <button class="btn btn-sm eliminar-btn" aria-label="Eliminar">
                                        🗑️
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Producto 3 -->
                        <div class="producto-item">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <img src="assets/img/fc26.jpg" alt="Producto 3" class="producto-img rounded" style="width: 55px; height: 55px; object-fit: cover;">
                                </div>

                                <div class="flex-grow-1">
                                    <h6 class="mb-1 producto-nombre">Producto 3</h6>
                                    <p class="mb-0 producto-precio">99€</p>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <div class="cantidad-control">
                                        <button class="cantidad-btn decrement-btn" aria-label="Disminuir">−</button>
                                        <span class="cantidad-valor">1</span>
                                        <button class="cantidad-btn increment-btn" aria-label="Aumentar">+</button>
                                    </div>

                                    <button class="btn btn-sm eliminar-btn" aria-label="Eliminar">
                                        🗑️
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="resumen-card">
                        <h4 class="resumen-titulo mb-4">Resumen del pedido</h4>

                        <div class="resumen-row">
                            <span class="resumen-label">Subtotal (3 productos)</span>
                            <span class="resumen-valor">€297</span>
                        </div>

                        <div class="resumen-row">
                            <span class="resumen-label">Envío estimado</span>
                            <span class="resumen-valor">Gratuito</span>
                        </div>

                        <div class="resumen-row info-row">
                            <span class="resumen-info">Devolución gratuita en 30 días</span>
                        </div>

                        <div class="resumen-row total-row">
                            <span class="resumen-total">Total del pedido:</span>
                            <span class="resumen-total-valor">€297</span>
                        </div>

                        <button class="btn btn-primary btn-lg w-100 mt-4 confirmar-btn">
                            Confirmar Pedido
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <?php include("includes/footer.php"); ?>
    </footer>

    <script src="js/scripts.js"></script>
</body>
</html>