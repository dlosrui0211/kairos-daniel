<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles - Kairos</title>
    <?php include("includes/head-tag-contents.php"); ?>
</head>
<body>
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>

    <main class="detalles-main">
        <div class="container-fluid">
            <div class="detalles-container">
                
                <div class="row g-3 mb-4">
                    <div class="col-12 col-lg-4">
                        <div class="detalles-image">
                            <img src="assets/img/juego.jpg">
                        </div>
                    </div>

                    <div class="col-12 col-lg-8">
                        <div class="detalles-info">
                            <h1 class="detalles-title">Red Dead Redemption 2</h1>
                            
                            <div class="detalles-meta">
                                <p><strong>Género:</strong> Acción</p>
                            </div>

                            <div class="detalles-description">
                                <p>Vive la vida del mejor mercenario y situate con su banda para intentar ser ricos.</p>
                            </div>

                            <div class="detalles-price-section">
                                <div class="detalles-price">15.99€</div>
                                <button class="detalles-add-btn">AÑADIR AL CARRITO</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <h2 class="requerimientos-title">REQUISITOS DEL SISTEMA</h2>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="requerimientos-card">
                            <h3 class="requerimientos-subtitle">REQUISITOS MÍNIMOS</h3>
                            <ul class="requerimientos-list">
                                <li><strong>SO:</strong> Windows 10 64-bit</li>
                                <li><strong>Procesador:</strong> Intel Core i5-4670K / AMD Ryzen FX-9590</li>
                                <li><strong>Memoria:</strong> 8 GB RAM</li>
                                <li><strong>Gráficos:</strong> Nvidia GeForce GTX 960 / AMD Radeon R7 360</li>
                                <li><strong>DirectX:</strong>Version 12</li>
                                <li><strong>Almacenamiento:</strong> 12 GB de espacio disponible</li>
                                <li><strong>Tarjeta de sonido:</strong>Direct X Compatible</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="requerimientos-card">
                            <h3 class="requerimientos-subtitle">REQUISITOS RECOMENDADOS</h3>
                            <ul class="requerimientos-list">
                                <li><strong>SO:</strong> Windows 10 64-bit</li>
                                <li><strong>Procesador:</strong> Intel Core i5-8500 / AMD Ryzen 5 3500X</li>
                                <li><strong>Memoria:</strong> 16 GB RAM</li>
                                <li><strong>Gráficos:</strong> Nvidia GeForce GTX 2070 / AMD Radeon RX 5700 XT</li>
                                <li><strong>DirectX:</strong>Version 12</li>
                                <li><strong>Almacenamiento:</strong> 12 GB de espacio disponible</li>
                                <li><strong>Tarjeta de sonido:</strong>Direct X Compatible</li>
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