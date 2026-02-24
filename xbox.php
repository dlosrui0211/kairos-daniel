<?php include("includes/a_config.php"); 
require_once __DIR__ . "/controller/ProductoController.php";

$productoController = new ProductoController();
try {
    // Xbox tiene ID 1 en la BD
    $productos = $productoController->obtenerPorPlataforma(1);
} catch (Exception $e) {
    $productos = [];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xbox - Kairos</title>
    <?php include("includes/head-tag-contents.php"); ?>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>

    <!-- Main Content -->
    <main id="main-content">
        <h1 class="visually-hidden">Xbox - Kairos</h1>
        <!-- Productos Grid -->
        <section class="productos-section">
            <h2 class="visually-hidden">Productos de Xbox</h2>
            <div class="container-fluid">
                <div class="row g-5 justify-content-center">
                    <?php 
                    if (!empty($productos)) {
                        foreach ($productos as $producto) {
                            $precioFinal = $productoController->calcularPrecioFinal($producto['precio'], $producto['descuento']);
                            $descuentoTexto = $producto['descuento'] > 0 ? '-' . $producto['descuento'] . '%' : '';
                            ?>
                    <div class="col-12 col-sm-4 col-lg-3">
                        <?php 
                                $platformImage = $producto['cover'];
                                $productImage = $producto['cover'];
                                $discount = $descuentoTexto;
                                $price = number_format($precioFinal, 2) . '€';
                                $platformName = $producto['plataforma_nombre'] ?? 'Xbox Series X';
                                $productName = $producto['titulo'];
                                $productId = $producto['id'];
                                $isRealProduct = true;
                                include("includes/product-card.php"); 
                                ?>
                    </div>
                    <?php
                        }
                    } else {
                        // Productos estáticos de ejemplo para Xbox
                        $productosXbox = [
                            ['name' => 'Halo Infinite', 'img' => 'assets/img/fc26.jpg', 'price' => '39.99€', 'discount' => '-30%'],
                            ['name' => 'Forza Horizon 5', 'img' => 'assets/img/fc26.jpg', 'price' => '49.99€', 'discount' => '-20%'],
                            ['name' => 'Gears 5', 'img' => 'assets/img/fc26.jpg', 'price' => '19.99€', 'discount' => '-50%'],
                            ['name' => 'Sea of Thieves', 'img' => 'assets/img/fc26.jpg', 'price' => '29.99€', 'discount' => '-25%'],
                            ['name' => 'Starfield', 'img' => 'assets/img/fc26.jpg', 'price' => '59.99€', 'discount' => ''],
                            ['name' => 'Fable', 'img' => 'assets/img/fc26.jpg', 'price' => '69.99€', 'discount' => ''],
                            ['name' => 'State of Decay 3', 'img' => 'assets/img/fc26.jpg', 'price' => '49.99€', 'discount' => '-10%'],
                            ['name' => 'Senua\'s Saga: Hellblade II', 'img' => 'assets/img/fc26.jpg', 'price' => '49.99€', 'discount' => '-15%'],
                        ];
                        foreach ($productosXbox as $i => $prod) { ?>
                    <div class="col-12 col-sm-4 col-lg-3">
                        <?php 
                            $productImage = $prod['img'];
                            $discount = $prod['discount'];
                            $price = $prod['price'];
                            $platformName = 'Xbox Series X';
                            $productName = $prod['name'];
                            $productId = $i + 1;
                            $isRealProduct = false;
                            include("includes/product-card.php"); 
                        ?>
                    </div>
                    <?php }
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("includes/footer.php"); ?>
    </footer>

    <script src="js/scripts.js"></script>
</body>

</html>