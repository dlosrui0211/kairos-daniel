<?php include("includes/a_config.php"); ?>
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
            <img src="assets/img/placeholder.png" class="bannerIMG img-fluid w-100">
        </section>

        <section class="products py-5">
            <div class="container-fluid px-4">
                <div class="row g-4 g-md-5 justify-content-center">
                    
                    <?php 

                    $productData = [
                        'image' => 'assets/img/nintendo.png',
                        'discount' => '-25%',
                        'price' => '49.99€',
                        'platform' => 'Nintendo'
                    ];

                    for ($i = 0; $i < 8; $i++): 
                    ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <?php 
                            $productImage = $productData['image'];
                            $discount = $productData['discount'];
                            $price = $productData['price'];
                            $platformName = $productData['platform'];
                            include("includes/product-card.php"); 
                            ?>
                        </div>
                    <?php endfor; ?>

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