<?php 
include("includes/a_config.php"); 
require_once __DIR__ . "/controller/ProductoController.php";

$productoController = new ProductoController();
try {
    $productos = $productoController->obtenerTodos();
} catch (Exception $e) {
    $productos = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kairos - Tienda de Productos Digitales</title>
    <?php include("includes/head-tag-contents.php"); ?>
</head>
<body>
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>

    <main id="main-content">
        <h1 class="visually-hidden">Kairos - Tienda de Videojuegos</h1>

        <section class="banner">
            <img src="assets/img/placeholder.png" alt="" class="bannerIMG">
        </section>

        <section class="products">
            <h2 class="visually-hidden">Catálogo de productos</h2>
            <div class="container-fluid">
                <div class="row g-4 justify-content-center">
                    <?php 
                    if (!empty($productos)) {
                        foreach ($productos as $producto) {
                            $precioFinal = $productoController->calcularPrecioFinal($producto['precio'], $producto['descuento']);
                            $descuentoTexto = $producto['descuento'] > 0 ? '-' . $producto['descuento'] . '%' : '';
                            ?>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                            $productImage = $producto['cover'];
                            $discount = $descuentoTexto;
                            $price = number_format($precioFinal, 2) . '€';
                            $platformName = $producto['plataforma_nombre'] ?? 'Sin plataforma';
                            $productName = $producto['titulo'];
                            $productId = $producto['id'];
                            $isRealProduct = true;
                            include("includes/product-card.php"); 
                            ?>
                    </div>
                    <?php
                        }
                    } else {
                        // Productos estáticos de ejemplo cuando la BD no está disponible
                        for ($i = 1; $i <= 8; $i++) {
                            ?>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                            $productImage = 'assets/img/fc26.jpg';
                            $discount = '-30%';
                            $price = '39.99€';
                            $productName = 'Producto ' . $i;
                            $productId = $i;
                            $isRealProduct = false;
                            include("includes/product-card.php"); 
                            ?>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </section>


        <section class="banner-video-container banner-video-small">
            <h2 class="visually-hidden">Tráiler destacado</h2>
            <div>
                <video class="banner-video" 
                    id="miVideo"
                    muted 
                    loop 
                    playsinline
                    autoplay>
                    <source src="assets/video/Trailer_GOW.mp4" type="video/mp4">
                    <track kind="captions" src="assets/video/captions.vtt" srclang="es" label="Español" default>
                </video>

                <div class="banner-overlay"></div>

                <div class="video-controles">
                    <button class="control-btn control-play" id="btnPlayPausa" aria-label="Reproducir o pausar vídeo">
                        <svg viewBox="0 0 24 24" width="24" height="24" aria-hidden="true">
                            <path d="M8 5v14l11-7z" fill="currentColor"/>
                        </svg>
                    </button>

                    <div class="progreso-container">
                        <div class="progreso-barra" id="progresoBarra">
                            <div class="progreso-relleno" id="progresoRelleno"></div>
                            <div class="progreso-handle" id="progresoHandle"></div>
                        </div>
                    </div>

                    <span class="tiempo-video" id="tiempoVideo">00:00 / 00:00</span>

                    <button class="control-btn control-volumen" id="btnVolumen" aria-label="Volumen">
                        <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
                            <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.26 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z" fill="currentColor"/>
                        </svg>
                    </button>

                    <input type="range" class="control-volumen-slider" id="volumenSlider" min="0" max="100" value="100" aria-label="Control de volumen">

                    <button class="control-btn control-pantalla-completa" id="btnPantallaCompleta" aria-label="Pantalla completa">
                        <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
                            <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z" fill="currentColor"/>
                        </svg>
                    </button>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <?php include("includes/footer.php"); ?>
    </footer>

    <script src="js/scripts.js"></script>
</body>
</html>