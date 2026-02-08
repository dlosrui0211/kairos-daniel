<?php include("includes/a_config.php"); 
require_once __DIR__ . "/controlador/ProductoController.php";

$productoController = new ProductoController();
// PlayStation tiene ID 2 en la BD (según tu insert)
$productos = $productoController->obtenerPorPlataforma(3);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nintendo - Kairos</title>
    <?php include("includes/head-tag-contents.php"); ?>
</head>
<body>
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>

    <main>
        <section class="banner">
            <img src="assets/img/placeholder.png" alt="Banner Nintendo" class="bannerIMG">
        </section>

        <section class="productos-section">
            <div class="container-fluid">
                <div class="row g-5 justify-content-center">
                    
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                        $productImage = 'assets/img/nintendo.png';
                        $discount = '-20%';
                        $price = '29,99€';
                        $platformName = 'Nintendo';
                        include("includes/product-card.php"); 
                        ?>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                        $productImage = 'assets/img/nintendo.png';
                        $discount = '-20%';
                        $price = '29,99€';
                        $platformName = 'Nintendo';
                        include("includes/product-card.php"); 
                        ?>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                        $productImage = 'assets/img/nintendo.png';
                        $discount = '-20%';
                        $price = '29,99€';
                        $platformName = 'Nintendo';
                        include("includes/product-card.php"); 
                        ?>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                        $productImage = 'assets/img/nintendo.png';
                        $discount = '-20%';
                        $price = '29,99€';
                        $platformName = 'Nintendo';
                        include("includes/product-card.php"); 
                        ?>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                        $productImage = 'assets/img/nintendo.png';
                        $discount = '-20%';
                        $price = '29,99€';
                        $platformName = 'Nintendo';
                        include("includes/product-card.php"); 
                        ?>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                        $productImage = 'assets/img/nintendo.png';
                        $discount = '-20%';
                        $price = '29,99€';
                        $platformName = 'Nintendo';
                        include("includes/product-card.php"); 
                        ?>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php
                        $productImage = 'assets/img/nintendo.png';
                        $discount = '-20%';
                        $price = '29,99€';
                        $platformName = 'Nintendo';
                        include("includes/product-card.php"); 
                        ?>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <?php 
                        $productImage = 'assets/img/nintendo.png';
                        $discount = '-20%';
                        $price = '29,99€';
                        $platformName = 'Nintendo';
                        include("includes/product-card.php"); 
                        ?>
                    </div>

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