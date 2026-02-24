<?php 
include("includes/a_config.php"); 
require_once __DIR__ . "/controller/ProductoController.php";
require_once __DIR__ . "/controller/ValoracionController.php";

// Obtener el ID del producto
$productoId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$productoId) {
    header("Location: index.php");
    exit();
}

$productoController = new ProductoController();
$valoracionController = new ValoracionController();

try {
    $producto = $productoController->obtenerPorId($productoId);
} catch (Exception $e) {
    $producto = null;
}

// Si no existe el producto, mostrar página con mensaje en vez de redirigir
$titulo = $producto['titulo'] ?? 'Producto #' . $productoId;
$cover = $producto['cover'] ?? 'assets/img/placeholder.png';

$valoraciones = [];
$mediaValoracion = null;
try {
    $valoraciones = $valoracionController->obtenerPorProducto($productoId);
    $mediaValoracion = $valoracionController->obtenerMediaProducto($productoId);
} catch (Exception $e) {
    // Sin valoraciones disponibles
}

$idUsuario = $_SESSION['usuario_id'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valorar <?php echo htmlspecialchars($titulo); ?> - Kairos</title>
    <?php include("includes/head-tag-contents.php"); ?>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>

    <!-- Main Content -->
    <main id="main-content" class="valoracion-main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">

                    <!-- Producto info -->
                    <div class="valoracion-producto-info">
                        <img src="<?php echo htmlspecialchars($cover); ?>" 
                             alt="<?php echo htmlspecialchars($titulo); ?>"
                             onerror="this.src='https://placehold.co/120x160/1c0538/ffffff?text=<?php echo urlencode($titulo); ?>'"
                             class="valoracion-producto-img">
                        <div>
                            <h1 class="valoracion-producto-titulo"><?php echo htmlspecialchars($titulo); ?></h1>
                            <?php if ($mediaValoracion && $mediaValoracion['total'] > 0): ?>
                            <div class="valoracion-media">
                                <span class="valoracion-estrellas-media" role="img" 
                                      aria-label="Valoración media: <?php echo number_format($mediaValoracion['media'], 1); ?> de 5">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span aria-hidden="true"><?php echo $i <= round($mediaValoracion['media']) ? '★' : '☆'; ?></span>
                                    <?php endfor; ?>
                                </span>
                                <span class="valoracion-media-texto">
                                    <?php echo number_format($mediaValoracion['media'], 1); ?>/5
                                    (<?php echo $mediaValoracion['total']; ?> <?php echo $mediaValoracion['total'] == 1 ? 'valoración' : 'valoraciones'; ?>)
                                </span>
                            </div>
                            <?php else: ?>
                            <p class="text-muted">Aún no hay valoraciones. ¡Sé el primero!</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Botón para valorar -->
                    <?php if ($idUsuario): ?>
                    <div class="valoracion-escribir">
                        <button class="btn btn-primary btn-lg" 
                                onclick="abrirModalValoracion(<?php echo $productoId; ?>, '<?php echo htmlspecialchars(addslashes($titulo)); ?>')">
                                Escribir una valoración
                        </button>
                    </div>
                    <?php else: ?>
                    <div class="valoracion-escribir">
                        <a href="login.php" class="btn btn-primary btn-lg">
                            Inicia sesión para valorar
                        </a>
                    </div>
                    <?php endif; ?>

                    <!-- Lista de valoraciones -->
                    <div class="valoracion-lista">
                        <h2 class="valoracion-lista-titulo">Valoraciones de usuarios</h2>

                        <?php if (!empty($valoraciones)): ?>
                        <?php foreach ($valoraciones as $val): ?>
                        <article class="valoracion-card">
                            <div class="valoracion-card-header">
                                <strong class="valoracion-card-usuario"><?php echo htmlspecialchars($val['username']); ?></strong>
                                <time datetime="<?php echo $val['fecha_valoracion']; ?>" class="valoracion-card-fecha">
                                    <?php echo date('d/m/Y', strtotime($val['fecha_valoracion'])); ?>
                                </time>
                            </div>
                            <div class="valoracion-card-estrellas" role="img" 
                                 aria-label="Valoración: <?php echo $val['puntuacion']; ?> de 5 estrellas">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span aria-hidden="true"><?php echo $i <= $val['puntuacion'] ? '★' : '☆'; ?></span>
                                <?php endfor; ?>
                                <span class="valoracion-card-puntuacion">(<?php echo $val['puntuacion']; ?>/5)</span>
                            </div>
                            <?php if (!empty($val['comentario'])): ?>
                            <p class="valoracion-card-comentario"><?php echo nl2br(htmlspecialchars($val['comentario'])); ?></p>
                            <?php else: ?>
                            <p class="valoracion-card-sin-comentario"><em>Sin comentario</em></p>
                            <?php endif; ?>
                        </article>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <p class="text-muted text-center">Aún no hay valoraciones para este producto.</p>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("includes/footer.php"); ?>
    </footer>

    <!-- Modal de valoración -->
    <?php include("includes/valoracion.php"); ?>

    <script src="js/scripts.js"></script>
</body>

</html>
