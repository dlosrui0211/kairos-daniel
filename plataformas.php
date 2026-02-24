<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataformas - Kairos</title>
    <?php include("includes/head-tag-contents.php"); ?>
</head>
<body>
    <!-- Header -->
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>

    <!-- Main Content -->
    <main id="main-content" class="plataformas-main">
        <div class="container">
            <!-- Contenedor principal con borde punteado -->
            <div class="plataformas-wrapper">
                
                <!-- Título de Plataformas con borde -->
                <div class="plataformas-header">
                    <h1>PLATAFORMAS</h1>
                </div>

                <!-- Grid de Plataformas -->
                <div class="plataformas-grid">
                    <div class="row g-2">
                        <!-- PlayStation -->
                        <div class="col-12 col-md-6">
                            <a href="playstation.php" class="platform-card playstation">
                                <div class="platform-content">
                                    <img src="assets/img/pslogo.png" 
                                         alt="PlayStation"
                                         class="platform-logo"
                                         onerror="this.src='https://placehold.co/300x200/003087/ffffff?text=PS'">
                                </div>
                                <div class="platform-label">
                                    PLAYSTATION
                                </div>
                            </a>
                        </div>

                        <!-- Nintendo -->
                        <div class="col-12 col-md-6">
                            <a href="nintendo.php" class="platform-card nintendo">
                                <div class="platform-content">
                                    <img src="assets/img/nintendo.png" 
                                         alt="Nintendo"
                                         class="platform-logo"
                                         onerror="this.src='https://placehold.co/300x200/e60012/ffffff?text=Nintendo'">
                                </div>
                                <div class="platform-label">
                                    NINTENDO
                                </div>
                            </a>
                        </div>

                        <!-- Xbox -->
                        <div class="col-12 col-md-6">
                            <a href="xbox.php" class="platform-card xbox">
                                <div class="platform-content">
                                    <img src="assets/img/xbox.jpg" 
                                         alt="Xbox"
                                         class="platform-logo"
                                         onerror="this.src='https://placehold.co/300x200/107c10/ffffff?text=Xbox'">
                                </div>
                                <div class="platform-label">
                                    XBOX
                                </div>
                            </a>
                        </div>

                        <!-- Steam -->
                        <div class="col-12 col-md-6">
                            <a href="steam.php" class="platform-card steam">
                                <div class="platform-content">
                                    <img src="assets/img/steam.png" 
                                         alt="Steam"
                                         class="platform-logo"
                                         onerror="this.src='https://placehold.co/300x200/171a21/66c0f4?text=Steam'">
                                </div>
                                <div class="platform-label">
                                    STEAM
                                </div>
                            </a>
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