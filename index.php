<?php include("includes/a_config.php"); ?>
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

    <main>
        <section class="banner">
            <img src="assets/img/placeholder.png" alt="Banner" class="bannerIMG">
        </section>

        <section class="products">
            <div class="container-fluid">
                <div class="row g-4 justify-content-center">
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                        $productImage = 'assets/img/fc26.jpg';
                        $discount = '-30%';
                        $price = '39.99€';
                        include("includes/product-card.php"); 
                        ?>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                        $productImage = 'assets/img/fc26.jpg';
                        $discount = '-30%';
                        $price = '39.99€';
                        include("includes/product-card.php"); 
                        ?>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                        $productImage = 'assets/img/fc26.jpg';
                        $discount = '-30%';
                        $price = '39.99€';
                        include("includes/product-card.php"); 
                        ?>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                        $productImage = 'assets/img/fc26.jpg';
                        $discount = '-30%';
                        $price = '39.99€';
                        include("includes/product-card.php"); 
                        ?>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                        $productImage = 'assets/img/fc26.jpg';
                        $discount = '-30%';
                        $price = '39.99€';
                        include("includes/product-card.php"); 
                        ?>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                        $productImage = 'assets/img/fc26.jpg';
                        $discount = '-30%';
                        $price = '39.99€';
                        include("includes/product-card.php"); 
                        ?>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                        $productImage = 'assets/img/fc26.jpg';
                        $discount = '-30%';
                        $price = '39.99€';
                        include("includes/product-card.php"); 
                        ?>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                        $productImage = 'assets/img/fc26.jpg';
                        $discount = '-30%';
                        $price = '39.99€';
                        include("includes/product-card.php"); 
                        ?>
                    </div>
                </div>
            </div>
        </section>


        <section class="banner-video-container">
            <div>
                <video class="banner-video" 
                    id="miVideo"
                    muted 
                    loop 
                    playsinline
                    autoplay>
                    <source src="assets/video/Trailer_GOW.mp4" type="video/mp4">
                </video>

                <div class="banner-overlay"></div>

                <div class="video-controles">
                    <button class="control-btn control-play" id="btnPlayPausa" title="Play/Pausa">
                        <svg viewBox="0 0 24 24" width="24" height="24">
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

                    <button class="control-btn control-volumen" id="btnVolumen" title="Volumen">
                        <svg viewBox="0 0 24 24" width="20" height="20">
                            <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.26 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z" fill="currentColor"/>
                        </svg>
                    </button>

                    <input type="range" class="control-volumen-slider" id="volumenSlider" min="0" max="100" value="100" title="Volumen">

                    <button class="control-btn control-pantalla-completa" id="btnPantallaCompleta" title="Pantalla completa">
                        <svg viewBox="0 0 24 24" width="20" height="20">
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