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
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>

    <main class="plataformas-main">
        <div class="container">
            <div class="plataformas-wrapper">
                
                <div class="plataformas-header">
                    <h1>PLATAFORMAS</h1>
                </div>

                <div class="plataformas-grid">
                    <div class="row g-2">
                        <div class="col-12 col-md-6">
                            <a href="playstation.php" class="platform-card playstation">
                                <div class="platform-content">
                                    <img src="assets/img/pslogo.png" class="platform-logo">
                                </div>
                                <div class="platform-label">
                                    PLAYSTATION
                                </div>
                            </a>
                        </div>

                        <div class="col-12 col-md-6">
                            <a href="nintendo.php" class="platform-card nintendo">
                                <div class="platform-content">
                                    <img src="assets/img/nintendo.png" class="platform-logo">        
                                </div>
                                <div class="platform-label">
                                    NINTENDO
                                </div>
                            </a>
                        </div>

                        <div class="col-12 col-md-6">
                            <a href="xbox.php" class="platform-card xbox">
                                <div class="platform-content">
                                    <img src="assets/img/xbox.jpg" class="platform-logo">   
                                </div>
                                <div class="platform-label">
                                    XBOX
                                </div>
                            </a>
                        </div>

                        <div class="col-12 col-md-6">
                            <a href="steam.php" class="platform-card steam">
                                <div class="platform-content">
                                    <img src="assets/img/steam.png" class="platform-logo">
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

    <footer>
        <?php include("includes/footer.php"); ?>
    </footer>

    <script src="js/scripts.js"></script>
</body>
</html>