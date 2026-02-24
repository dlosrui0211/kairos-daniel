<?php
// Variables por defecto si no se pasan desde la página
$platform = $platform ?? 'steam';
$platformImage = $platformImage ?? 'assets/img/platforms/steam.png';
$productImage = $productImage ?? 'assets/img/products/default.png';
$discount = $discount ?? '-30%';
$price = $price ?? '39.99€';
$platformName = $platformName ?? 'Steam';
$productName = $productName ?? 'Producto';
$productId = $productId ?? '#';
$isRealProduct = $isRealProduct ?? false;
?>
<div class="product-card">
    <div class="product-card-inner">
        <!-- Imagen clickeable que lleva a detalles -->
        <a href="detalles.php?id=<?php echo $productId; ?>" class="product-card-media-link">
            <div class="product-card-media">
                <!-- Descuento -->
                <?php if (!empty($discount) && $discount !== ''): ?>
                <div class="product-card-discount">
                    <?php echo $discount; ?>
                </div>
                <?php endif; ?>

                <!-- Imagen del producto -->
                <img class="product-card-cover" src="<?php echo $productImage; ?>"
                    onerror="this.src='https://placehold.co/200x200/5e3a8b/ffffff?text=<?php echo urlencode($productName); ?>'"
                    alt="<?php echo $productName; ?>">
            </div>
        </a>

        <div class="product-card-bottom">
            <div class="product-card-price">
                <?php echo $price; ?>
            </div>

            <!-- Botón Valorar -->
            <?php if (is_numeric($productId) && $productId > 0): ?>
            <a href="valoracion.php?id=<?php echo $productId; ?>" class="product-card-button btn-valorar"
                aria-label="Valorar <?php echo htmlspecialchars($productName); ?>"
                style="text-decoration: none; text-align: center;">
                <span aria-hidden="true">⭐</span> VALORAR
            </a>
            <?php else: ?>
            <button class="product-card-button btn-valorar" disabled
                style="opacity: 0.5; cursor: not-allowed;">
                <span aria-hidden="true">⭐</span> VALORAR
            </button>
            <?php endif; ?>


            <!-- Botón añadir al carrito -->
            <?php if ($isRealProduct): ?>
            <button class="product-card-button btn-add-to-cart" data-product-id="<?php echo $productId; ?>"
                data-product-name="<?php echo htmlspecialchars($productName); ?>"
                aria-label="Añadir <?php echo htmlspecialchars($productName); ?> al carrito">
                <span aria-hidden="true">🛒</span> AÑADIR AL CARRITO
            </button>
            <?php else: ?>
            <button class="product-card-button btn-add-to-cart" disabled
                style="opacity: 0.5; cursor: not-allowed;"
                title="Producto no disponible">
                <span aria-hidden="true">🛒</span> AÑADIR AL CARRITO
            </button>
            <?php endif; ?>
        </div>
    </div>
</div>