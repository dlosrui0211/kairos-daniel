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

    <!-- Main Content -->
    <main id="main-content" class="wishlist-main">
        <h1 class="visually-hidden">Lista de deseos</h1>
        <div class="container-fluid">
            <div class="wishlist-container">
                <!-- Grid de Productos - UNA COLUMNA COMPLETA -->
                <div class="row g-4">
                    <!-- Producto 1 -->
                    <div class="col-12">
                        <div class="wishlist-item">
                            <div class="wishlist-image">
                                <img src="assets/img/placeholder.png" 
                                     alt="" 
                                     onerror="this.src='https://placehold.co/150x200/1c0538/ffffff?text=PLACEHOLDER+DE+ANUNCIO'">
                            </div>
                            <div class="wishlist-content">
                                <div class="wishlist-info">
                                    <h2 class="wishlist-title">DayZ</h2>
                                    <p class="wishlist-description">Survive an open world for KOSA-RS8<br>Record all statements - 09:04:53</p>
                                </div>
                                <div class="wishlist-actions">
                                    <div class="wishlist-price">47.99€</div>
                                    <button class="wishlist-add-btn" aria-label="Añadir DayZ al carrito - producto 1">Añadir al carro</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Producto 2 -->
                    <div class="col-12">
                        <div class="wishlist-item">
                            <div class="wishlist-image">
                                <img src="assets/img/placeholder.png" 
                                     alt=""
                                     onerror="this.src='https://placehold.co/150x200/1c0538/ffffff?text=PLACEHOLDER+DE+ANUNCIO'">
                            </div>
                            <div class="wishlist-content">
                                <div class="wishlist-info">
                                    <h2 class="wishlist-title">DayZ</h2>
                                    <p class="wishlist-description">Survive an open world for KOSA-RS8<br>Record all statements - 09:04:53</p>
                                </div>
                                <div class="wishlist-actions">
                                    <div class="wishlist-price">47.99€</div>
                                    <button class="wishlist-add-btn" aria-label="Añadir DayZ al carrito - producto 2">Añadir al carro</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Producto 3 -->
                    <div class="col-12">
                        <div class="wishlist-item">
                            <div class="wishlist-image">
                                <img src="assets/img/placeholder.png" 
                                     alt=""
                                     onerror="this.src='https://placehold.co/150x200/1c0538/ffffff?text=PLACEHOLDER+DE+ANUNCIO'">
                            </div>
                            <div class="wishlist-content">
                                <div class="wishlist-info">
                                    <h2 class="wishlist-title">DayZ</h2>
                                    <p class="wishlist-description">Survive an open world for KOSA-RS8<br>Record all statements - 09:04:53</p>
                                </div>
                                <div class="wishlist-actions">
                                    <div class="wishlist-price">47.99€</div>
                                    <button class="wishlist-add-btn" aria-label="Añadir DayZ al carrito - producto 3">Añadir al carro</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Producto 4 -->
                    <div class="col-12">
                        <div class="wishlist-item">
                            <div class="wishlist-image">
                                <img src="assets/img/placeholder.png" 
                                     alt=""
                                     onerror="this.src='https://placehold.co/150x200/1c0538/ffffff?text=PLACEHOLDER+DE+ANUNCIO'">
                            </div>
                            <div class="wishlist-content">
                                <div class="wishlist-info">
                                    <h2 class="wishlist-title">DayZ</h2>
                                    <p class="wishlist-description">Survive an open world for KOSA-RS8<br>Record all statements - 09:04:53</p>
                                </div>
                                <div class="wishlist-actions">
                                    <div class="wishlist-price">47.99€</div>
                                    <button class="wishlist-add-btn" aria-label="Añadir DayZ al carrito - producto 4">Añadir al carro</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón Eliminar Todo -->
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

    <!-- Footer -->
    <footer>
        <?php include("includes/footer.php"); ?>
    </footer>

    <script src="js/scripts.js"></script>
</body>
</html>