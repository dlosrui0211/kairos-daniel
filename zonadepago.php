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
    <!-- Header -->
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>

    <!-- Main Content -->
    <main id="main-content" class="zona-pago-main">
        <div class="contenedor-pago">
            <h1 class="visually-hidden">Zona de Pago</h1>
            <div class="row g-0">
                <!-- Productos (Izquierda) -->
                <div class="col-md-7">
                    <div class="productos-list">
                        <h2 class="visually-hidden">Productos en tu carrito</h2>
                        <!-- Producto 1 -->
                        <div class="producto-item">
                            <div class="d-flex gap-3">
                                <!-- Imagen -->
                                <div class="flex-shrink-0">
                                    <img src="assets/img/fc26.jpg" 
                                         onerror="this.src='https://placehold.co/55x55/5e3a8b/ffffff?text=P1'" 
                                         alt="" 
                                         class="producto-img rounded"
                                         style="width: 55px; height: 55px; object-fit: cover;">
                                </div>

                                <!-- Información -->
                                <div class="flex-grow-1">
                                    <h3 class="mb-1 producto-nombre">Producto 1</h3>
                                    <p class="mb-0 producto-precio">99€</p>
                                </div>

                                <!-- Cantidad y acciones -->
                                <div class="d-flex align-items-center gap-2">
                                    <!-- Control cantidad -->
                                    <div class="cantidad-control">
                                        <button class="cantidad-btn decrement-btn" aria-label="Disminuir">−</button>
                                        <span class="cantidad-valor">1</span>
                                        <button class="cantidad-btn increment-btn" aria-label="Aumentar">+</button>
                                    </div>

                                    <!-- Eliminar -->
                                    <button class="btn btn-sm eliminar-btn" aria-label="Eliminar">
                                        🗑️
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Producto 2 -->
                        <div class="producto-item">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <img src="assets/img/fc26.jpg" 
                                         onerror="this.src='https://placehold.co/55x55/5e3a8b/ffffff?text=P2'" 
                                         alt="" 
                                         class="producto-img rounded"
                                         style="width: 55px; height: 55px; object-fit: cover;">
                                </div>

                                <div class="flex-grow-1">
                                    <h3 class="mb-1 producto-nombre">Producto 2</h3>
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
                                    <img src="assets/img/fc26.jpg" 
                                         onerror="this.src='https://placehold.co/55x55/5e3a8b/ffffff?text=P3'" 
                                         alt="" 
                                         class="producto-img rounded"
                                         style="width: 55px; height: 55px; object-fit: cover;">
                                </div>

                                <div class="flex-grow-1">
                                    <h3 class="mb-1 producto-nombre">Producto 3</h3>
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

                <!-- Resumen Pedido (Derecha) -->
                <div class="col-md-5">
                    <div class="resumen-card">
                        <!-- Título -->
                        <h2 class="resumen-titulo mb-4">Resumen del pedido</h2>

                        <!-- Subtotal -->
                        <div class="resumen-row">
                            <span class="resumen-label">Subtotal (3 productos)</span>
                            <span class="resumen-valor">€297</span>
                        </div>

                        <!-- Envío -->
                        <div class="resumen-row">
                            <span class="resumen-label">Envío estimado</span>
                            <span class="resumen-valor">Gratuito</span>
                        </div>

                        <!-- Devolución -->
                        <div class="resumen-row info-row">
                            <span class="resumen-info">Devolución gratuita en 30 días</span>
                        </div>

                        <!-- Total -->
                        <div class="resumen-row total-row">
                            <span class="resumen-total">Total del pedido:</span>
                            <span class="resumen-total-valor">€297</span>
                        </div>

                        <!-- Botón Confirmar -->
                        <button class="btn btn-primary btn-lg w-100 mt-4 confirmar-btn">
                            Confirmar Pedido
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("includes/footer.php"); ?>
    </footer>

    <script src="js/scripts.js"></script>
</body>
</html>