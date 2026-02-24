<?php 
include("includes/a_config.php"); 
require_once __DIR__ . "/controller/ProductoController.php";
require_once __DIR__ . "/controller/CarritoController.php";
require_once __DIR__ . "/controller/ValoracionController.php";

// Obtener el ID del producto
$productoId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$productoId) {
    header("Location: index.php");
    exit();
}

$productoController = new ProductoController();
$producto = $productoController->obtenerPorId($productoId);

// Si no existe el producto, redirigir
if (!$producto) {
    header("Location: index.php");
    exit();
}

// ✅ VARIABLES CON VALORES POR DEFECTO (evita warnings)
$titulo = $producto['titulo'] ?? 'Producto sin título';
$cover = $producto['cover'] ?? 'assets/img/placeholder.png';
$descripcion = $producto['descripcion'] ?? 'Sin descripción disponible';
$precio = $producto['precio'] ?? 0;
$descuento = $producto['descuento'] ?? 0;
$stock = $producto['stock'] ?? 0;
$plataformaNombre = $producto['plataforma_nombre'] ?? 'Sin plataforma';
$modoNombre = $producto['modo_nombre'] ?? 'Varios modos';
$fechaLanzamiento = $producto['fecha_lanzamiento'] ?? null;

// Calcular precio final con descuento
$precioFinal = $productoController->calcularPrecioFinal($precio, $descuento);
$precioOriginal = $precio;
$descuentoTexto = $descuento > 0 ? '-' . $descuento . '%' : '';

// Verificar si el usuario está logueado y si el producto está en el carrito
$idUsuario = $_SESSION['usuario_id'] ?? null;
$enCarrito = false;
if ($idUsuario) {
    $carritoController = new CarritoController();
    $enCarrito = $carritoController->productoEnCarrito($idUsuario, $productoId);
}

// Obtener géneros del producto
$generosProducto = $productoController->obtenerGenerosProducto($productoId);
$generosTexto = !empty($generosProducto) ? implode(', ', array_column($generosProducto, 'nombre')) : 'Sin especificar';
// Obtener valoraciones del producto
$valoracionController = new ValoracionController();
$valoraciones = $valoracionController->obtenerPorProducto($productoId);
$mediaValoracion = $valoracionController->obtenerMediaProducto($productoId);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($titulo); ?> - Kairos</title>
    <?php include("includes/head-tag-contents.php"); ?>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
        <?php include("includes/valoracion.php"); ?>
    </header>

    <!-- Main Content -->
    <main id="main-content" class="details-main">
        <div class="container-fluid">
            <div class="details-container">

                <!-- SECCIÓN SUPERIOR: IMAGEN + INFO DEL JUEGO -->
                <div class="row g-3 mb-4">
                    <!-- IMAGEN DEL PRODUCTO -->
                    <div class="col-12 col-lg-4">
                        <div class="details-image">
                            <img src="<?php echo htmlspecialchars($cover); ?>"
                                alt="<?php echo htmlspecialchars($titulo); ?>"
                                onerror="this.src='https://placehold.co/400x550/1c0538/ffffff?text=<?php echo urlencode($titulo); ?>'">

                            <!-- Badge de descuento (si existe) -->
                            <?php if ($descuentoTexto): ?>
                            <div class="details-discount-badge" role="img" aria-label="Descuento del <?php echo $descuento; ?> por ciento">
                                <?php echo $descuentoTexto; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- INFO DEL PRODUCTO -->
                    <div class="col-12 col-lg-8">
                        <div class="details-info">
                            <h1 class="details-title"><?php echo htmlspecialchars($titulo); ?></h1>

                            <div class="details-meta">
                                <p><strong>Género:</strong> <?php echo htmlspecialchars($generosTexto); ?></p>
                                <p><strong>Modo:</strong> <?php echo htmlspecialchars($modoNombre); ?></p>
                                <?php if (!empty($fechaLanzamiento)): ?>
                                <p><strong>Lanzamiento:</strong>
                                    <?php echo date('d/m/Y', strtotime($fechaLanzamiento)); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($plataformaNombre)): ?>
                                <p><strong>Plataforma:</strong>
                                    <?php echo htmlspecialchars($plataformaNombre); ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="details-description">
                                <p><?php echo nl2br(htmlspecialchars($descripcion)); ?></p>
                            </div>

                            <div class="details-price-section" role="region" aria-label="Información de precio">
                                <?php if ($descuento > 0): ?>
                                <!-- Precio con descuento -->
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="text-decoration-line-through text-muted" style="font-size: 1.2rem;" aria-label="Precio original tachado">
                                        <?php echo number_format($precioOriginal, 2); ?>€
                                    </span>
                                    <div class="details-price" aria-label="Precio con descuento"><?php echo number_format($precioFinal, 2); ?>€</div>
                                </div>
                                <?php else: ?>
                                <!-- Precio normal -->
                                <div class="details-price" aria-label="Precio del producto"><?php echo number_format($precioFinal, 2); ?>€</div>
                                <?php endif; ?>

                                <!-- Botón añadir al carrito -->
                                <?php if ($stock > 0): ?>
                                <?php if ($idUsuario): ?>
                                <?php if ($enCarrito): ?>
                                <!-- Ya está en el carrito -->
                                <a href="zonadepago.php" class="btn btn-primary w-100 mt-2" aria-label="<?php echo htmlspecialchars($titulo); ?> ya está en tu carrito. Ir al carrito de compras">
                                    IR AL CARRITO
                                </a>
                                <?php else: ?>
                                <!-- Botón para añadir -->
                                <button class="details-add-btn btn-add-to-cart-detalle"
                                    data-product-id="<?php echo $productoId; ?>"
                                    data-product-name="<?php echo htmlspecialchars($titulo); ?>"
                                    aria-label="Añadir <?php echo htmlspecialchars($titulo); ?> al carrito">
                                    AÑADIR AL CARRITO
                                </button>
                                <?php endif; ?>
                                <?php else: ?>
                                <!-- No está logueado -->
                                <a href="login.php" class="details-add-btn"
                                    style="text-decoration: none; display: block; text-align: center;"
                                    role="button"
                                    aria-label="Inicia sesión para comprar <?php echo htmlspecialchars($titulo); ?>">
                                    INICIA SESIÓN PARA COMPRAR
                                </a>
                                <?php endif; ?>
                                <?php else: ?>
                                <!-- Sin stock -->
                                <button class="details-add-btn" disabled
                                    style="opacity: 0.5; cursor: not-allowed; background: #666;"
                                    aria-disabled="true"
                                    aria-label="Producto agotado: <?php echo htmlspecialchars($titulo); ?> sin stock disponible">
                                    PRODUCTO AGOTADO
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN DE REQUISITOS DEL SISTEMA -->
                <div class="row mb-3">
                    <div class="col-12">
                        <h2 class="requirements-title">REQUISITOS DEL SISTEMA</h2>
                    </div>
                </div>

                <div class="row g-3">
                    <!-- REQUISITOS MÍNIMOS -->
                    <div class="col-12 col-md-6">
                        <div class="requirements-card">
                            <h3 class="requirements-subtitle">MÍNIMOS</h3>
                            <ul class="requirements-list">
                                <li><strong>SO:</strong> Windows 10/11 64-bit</li>
                                <li><strong>Procesador:</strong> Intel i5-6600K / AMD Ryzen 5 1600</li>
                                <li><strong>Memoria:</strong> 8 GB RAM</li>
                                <li><strong>Gráficos:</strong> GTX 1050 Ti / RX 570</li>
                                <li><strong>Almacenamiento:</strong> 60 GB libres</li>
                            </ul>
                        </div>
                    </div>

                    <!-- REQUISITOS RECOMENDADOS -->
                    <div class="col-12 col-md-6">
                        <div class="requirements-card">
                            <h3 class="requirements-subtitle">RECOMENDADOS</h3>
                            <ul class="requirements-list">
                                <li><strong>SO:</strong> Windows 11 64-bit</li>
                                <li><strong>Procesador:</strong> Intel i7-8700 / Ryzen 5 3600</li>
                                <li><strong>Memoria:</strong> 16 GB RAM</li>
                                <li><strong>Gráficos:</strong> RTX 3060 / RX 6600 XT</li>
                                <li><strong>Almacenamiento:</strong> 80 GB SSD</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN DE VALORACIONES -->
                <div class="row mb-3 mt-4">
                    <div class="col-12">
                        <h2 class="requirements-title">VALORACIONES DE USUARIOS</h2>
                        <?php if ($mediaValoracion && $mediaValoracion['total'] > 0): ?>
                        <div class="mb-3">
                            <span style="color: #f5c518; font-size: 1.3rem;" 
                                  role="img" 
                                  aria-label="Valoración media: <?php echo number_format($mediaValoracion['media'], 1); ?> de 5 estrellas">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span aria-hidden="true"><?php echo $i <= round($mediaValoracion['media']) ? '★' : '☆'; ?></span>
                                <?php endfor; ?>
                            </span>
                            <span class="text-muted ms-2" aria-label="<?php echo $mediaValoracion['total']; ?> <?php echo $mediaValoracion['total'] == 1 ? 'valoración' : 'valoraciones'; ?> totales">
                                <?php echo number_format($mediaValoracion['media'], 1); ?>/5
                                (<?php echo $mediaValoracion['total']; ?>
                                <?php echo $mediaValoracion['total'] == 1 ? 'valoración' : 'valoraciones'; ?>)
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($idUsuario): ?>
                <div class="row mb-3">
                    <div class="col-12">
                        <button class="btn btn-primary"
                            onclick="abrirModalValoracion(<?php echo $productoId; ?>, '<?php echo htmlspecialchars(addslashes($titulo)); ?>')"
                            aria-label="Escribir una valoración para <?php echo htmlspecialchars($titulo); ?>">
                            <span aria-hidden="true">✍️</span> Escribir una valoración
                        </button>
                    </div>
                </div>
                <?php endif; ?>
                <div class="row g-3 mb-4">
                    <?php if (!empty($valoraciones)): ?>
                    <?php foreach ($valoraciones as $val): ?>
                    <div class="col-12">
                        <article class="requirements-card" style="padding: 1rem 1.5rem;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong
                                    style="color: #e0d0ff;"><?php echo htmlspecialchars($val['username']); ?></strong>
                                <time datetime="<?php echo $val['fecha_valoracion']; ?>" class="text-muted">
                                    <?php echo date('d/m/Y', strtotime($val['fecha_valoracion'])); ?>
                                </time>
                            </div>
                            <div class="mb-2" style="color: #f5c518;" 
                                 role="img" 
                                 aria-label="Valoración: <?php echo $val['puntuacion']; ?> de 5 estrellas">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span aria-hidden="true"><?php echo $i <= $val['puntuacion'] ? '★' : '☆'; ?></span>
                                <?php endfor; ?>
                                <span class="text-muted ms-2">(<?php echo $val['puntuacion']; ?>/5)</span>
                            </div>
                            <?php if (!empty($val['comentario'])): ?>
                            <p style="color: #ccc; margin-bottom: 0;">
                                <?php echo nl2br(htmlspecialchars($val['comentario'])); ?></p>
                            <?php else: ?>
                            <p class="text-muted" style="margin-bottom: 0;"><em>Sin comentario</em></p>
                            <?php endif; ?>
                        </article>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <div class="col-12">
                        <p class="text-muted">Aún no hay valoraciones para este producto. ¡Sé el primero en valorar!</p>
                    </div>
                    <?php endif; ?>
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