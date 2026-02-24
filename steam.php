<?php include("includes/a_config.php"); 
require_once __DIR__ . "/controller/ProductoController.php";

$productoController = new ProductoController();
try {
    // PC/Steam tiene ID 4 en la BD
    $productos = $productoController->obtenerPorPlataforma(4);
} catch (Exception $e) {
    $productos = [];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steam - Kairos</title>
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
        <h1 class="visually-hidden">Steam - Kairos</h1>
        <!-- Productos Grid -->
        <section class="productos-section">
            <h2 class="visually-hidden">Productos de Steam</h2>
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
                                $platformName = $producto['plataforma_nombre'] ?? 'PC';
                                $productName = $producto['titulo'];
                                $productId = $producto['id'];
                                $isRealProduct = true;
                                include("includes/product-card.php"); 
                                ?>
                    </div>
                    <?php
                        }
                    } else {
                        // Productos estáticos de ejemplo para Steam/PC
                        $productosSteam = [
                            ['name' => 'Starfield', 'img' => 'assets/img/fc26.jpg', 'price' => '59.99€', 'discount' => ''],
                            ['name' => 'Baldur\'s Gate 3', 'img' => 'assets/img/fc26.jpg', 'price' => '50.99€', 'discount' => '-15%'],
                            ['name' => 'Cyberpunk 2077', 'img' => 'assets/img/fc26.jpg', 'price' => '31.99€', 'discount' => '-20%'],
                            ['name' => 'Counter-Strike 2', 'img' => 'assets/img/fc26.jpg', 'price' => '0.00€', 'discount' => ''],
                            ['name' => 'Half-Life: Alyx', 'img' => 'assets/img/fc26.jpg', 'price' => '49.99€', 'discount' => '-10%'],
                            ['name' => 'Portal 2', 'img' => 'assets/img/fc26.jpg', 'price' => '9.99€', 'discount' => '-50%'],
                            ['name' => 'DOTA 2', 'img' => 'assets/img/fc26.jpg', 'price' => '0.00€', 'discount' => ''],
                            ['name' => 'Left 4 Dead 2', 'img' => 'assets/img/fc26.jpg', 'price' => '7.99€', 'discount' => '-40%'],
                        ];
                        foreach ($productosSteam as $i => $prod) { ?>
                    <div class="col-12 col-sm-4 col-lg-3">
                        <?php 
                            $productImage = $prod['img'];
                            $discount = $prod['discount'];
                            $price = $prod['price'];
                            $platformName = 'Steam';
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