<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist - Kairos</title>
    <?php include("includes/head-tag-contents.php"); ?>
</head>
<body>
    <!-- Header -->
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>

    <main class="wishlist-main">
        <div class="container-fluid">
            <div class="wishlist-container">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="wishlist-item">
                            <div class="wishlist-image">
                                <img src="assets/img/placeholder.png" alt="Producto" >
                            </div>
                            <div class="wishlist-content">
                                <div class="wishlist-info">
                                    <h3 class="wishlist-title">Read Redemption 2</h3>
                                    <p class="wishlist-description">Vive la vida de un cowboy</p>
                                </div>
                                <div class="wishlist-actions">
                                    <div class="wishlist-price">47.99€</div>
                                    <button class="wishlist-add-btn">Añadir al carro</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="wishlist-item">
                            <div class="wishlist-image">
                                <img src="assets/img/placeholder.png" alt="Producto">
                            </div>
                            <div class="wishlist-content">
                                <div class="wishlist-info">
                                    <h3 class="wishlist-title">Read redemption 2</h3>
                                    <p class="wishlist-description">Vive la vida de un cowboy</p>
                                </div>
                                <div class="wishlist-actions">
                                    <div class="wishlist-price">47.99€</div>
                                    <button class="wishlist-add-btn">Añadir al carro</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="wishlist-item">
                            <div class="wishlist-image">
                                <img src="assets/img/placeholder.png" alt="Producto">
                            </div>
                            <div class="wishlist-content">
                                <div class="wishlist-info">
                                    <h3 class="wishlist-title">Read redemption 2</h3>
                                    <p class="wishlist-description">Vive la vida de un cowboy</p>
                                </div>
                                <div class="wishlist-actions">
                                    <div class="wishlist-price">47.99€</div>
                                    <button class="wishlist-add-btn">Añadir al carro</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="wishlist-item">
                            <div class="wishlist-image">
                                <img src="assets/img/placeholder.png" alt="Producto">
                            </div>
                            <div class="wishlist-content">
                                <div class="wishlist-info">
                                    <h3 class="wishlist-title">Read redemption 2</h3>
                                    <p class="wishlist-description">Vive la vida de un cowboy</p>
                                </div>
                                <div class="wishlist-actions">
                                    <div class="wishlist-price">47.99€</div>
                                    <button class="wishlist-add-btn">Añadir al carro</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-12">
                        <div class="wishlist-delete-all">
                            <button class="btn-delete-all">Eliminar Todo</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <?php include("includes/footer.php"); ?>
    </footer>

    <script src="js/scripts.js"></script>
</body>
</html>