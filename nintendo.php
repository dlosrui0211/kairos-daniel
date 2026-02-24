<?php include("includes/a_config.php"); 
require_once __DIR__ . "/controller/ProductoController.php";

$productoController = new ProductoController();
try {
    // Nintendo tiene ID 3 en la BD
    $productos = $productoController->obtenerPorPlataforma(3);
} catch (Exception $e) {
    $productos = [];
}
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
    <!-- Header -->
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>

    <!-- Main Content -->
    <main id="main-content">
        <h1 class="visually-hidden">Nintendo - Kairos</h1>
        <!-- Productos Grid -->
        <section class="productos-section">
            <h2 class="visually-hidden">Productos de Nintendo</h2>
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
                                $platformName = $producto['plataforma_nombre'] ?? 'Nintendo Switch';
                                $productName = $producto['titulo'];
                                $productId = $producto['id'];
                                $isRealProduct = true;
                                include("includes/product-card.php"); 
                                ?>
                    </div>
                    <?php
                        }
                    } else {
                        // Productos estáticos de ejemplo para Nintendo
                        $productosNintendo = [
                            ['name' => 'Zelda: Tears of the Kingdom', 'img' => 'assets/img/fc26.jpg', 'price' => '59.99€', 'discount' => ''],
                            ['name' => 'Super Mario Bros. Wonder', 'img' => 'assets/img/fc26.jpg', 'price' => '49.99€', 'discount' => '-15%'],
                            ['name' => 'Mario Kart 8 Deluxe', 'img' => 'assets/img/fc26.jpg', 'price' => '39.99€', 'discount' => '-30%'],
                            ['name' => 'Splatoon 3', 'img' => 'assets/img/fc26.jpg', 'price' => '49.99€', 'discount' => '-10%'],
                            ['name' => 'Animal Crossing: New Horizons', 'img' => 'assets/img/fc26.jpg', 'price' => '39.99€', 'discount' => '-20%'],
                            ['name' => 'Pokémon Escarlata', 'img' => 'assets/img/fc26.jpg', 'price' => '49.99€', 'discount' => '-25%'],
                            ['name' => 'Metroid Dread', 'img' => 'assets/img/fc26.jpg', 'price' => '44.99€', 'discount' => '-10%'],
                            ['name' => 'Super Smash Bros. Ultimate', 'img' => 'assets/img/fc26.jpg', 'price' => '49.99€', 'discount' => '-20%'],
                        ];
                        foreach ($productosNintendo as $i => $prod) { ?>
                    <div class="col-12 col-sm-4 col-lg-3">
                        <?php 
                            $productImage = $prod['img'];
                            $discount = $prod['discount'];
                            $price = $prod['price'];
                            $platformName = 'Nintendo Switch';
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