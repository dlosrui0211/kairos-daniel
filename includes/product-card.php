<?php
$platform = $platform ?? 'steam';
$platformImage = $platformImage ?? 'assets/img/platforms/steam.png';
$productImage = $productImage ?? 'assets/img/products/default.png';
$discount = $discount ?? '-30%';
$price = $price ?? '39.99€';
$platformName = $platformName ?? 'Steam';
?>

<div class="product-card">
    <div class="product-card-inner">
        <div class="product-card-media">
            
            <div class="product-card-discount">
                <?php echo $discount; ?>
            </div>
            
            <img class="product-card-cover"
                src="<?php echo $productImage; ?>">
        </div>

        <div class="product-card-bottom">
            <div class="product-card-price">
                <?php echo $price; ?>
            </div>
            <a class="product-card-button" href="detalles.php">
                AÑADIR AL CARRITO
            </a>
        </div>
    </div>
</div>