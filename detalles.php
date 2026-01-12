<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto - Kairos</title>
    <?php include("includes/head-tag-contents.php"); ?>
</head>
<body>
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>

    <main class="details-main">
        <div class="container-fluid">
            <div class="details-container">
                
                <div class="row g-3 mb-4">
                    <div class="col-12 col-lg-4">
                        <div class="details-image">
                            <img src="assets/img/fifa-22.jpg">
                        </div>
                    </div>

                    <div class="col-12 col-lg-8">
                        <div class="details-info">
                            <h1 class="details-title">EA SPORTS FC 25</h1>
                            
                            <div class="details-meta">
                                <p><strong>Género:</strong> Deportes</p>
                                <p><strong>Modo:</strong> Singleplayer / Multiplayer Online</p>
                            </div>

                            <div class="details-description">
                                <p>Fútbol con nuevas animaciones, modos renovados y mejoras de jugabilidad orientadas al competitivo.</p>
                            </div>

                            <div class="details-price-section">
                                <div class="details-price">49.99€</div>
                                <button class="details-add-btn">AÑADIR AL CARRITO</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <h2 class="requirements-title">REQUISITOS DEL SISTEMA</h2>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="requirements-card">
                            <h3 class="requirements-subtitle">MÍNIMOS</h3>
                            <ul class="requirements-list">
                                <li><strong>SO:</strong> Windows 10/11 64-bit</li>
                                <li><strong>Procesador:</strong> Intel i5-6600K / AMD Ryzen 5 1600</li>
                                <li><strong>Memoria:</strong> 8 GB RAM</li>
                                <li><strong>Gráficos:</strong> GTX 1050 Ti / RX 570</li>
                                <li><strong>Almacenamiento:</strong> 60 GB libres</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="requirements-card">
                            <h3 class="requirements-subtitle">RECOMENDADOS</h3>
                            <ul class="requirements-list">
                                <li><strong>SO:</strong> Windows 11 64-bit</li>
                                <li><strong>Procesador:</strong> Intel i7-8700 / Ryzen 5 3600</li>
                                <li><strong>Memoria:</strong> 16 GB RAM</li>
                                <li><strong>Gráficos:</strong> RTX 3060 / RX 6600 XT</li>
                                <li><strong>Almacenamiento:</strong> 80 GB SSD</li>
                            </ul>
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