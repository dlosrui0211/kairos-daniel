<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devoluciones - Kairos</title>
    <?php include("includes/head-tag-contents.php"); ?>
</head>
<body>
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>

    <main class="devoluciones-main">
        <div class="container">
            
            <div class="row">
                <div class="col-12">
                    <h1 class="devoluciones-title">DEVOLUCIÓN</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="devoluciones-content">
                        
                        <div class="row mb-4"> 
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="devoluciones-text">Subtotal: (X productos)</span>
                                    <span class="devoluciones-price">99€</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="devoluciones-text">Coste de recogida a domicilio</span>
                                    <span class="devoluciones-price">2,99€</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <p class="devoluciones-note">El importe de la devolución se reembolsará en el mismo método de pago en el que realizó la compra en un plazo máximo de 10 días hábiles.</p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="devoluciones-divider"></div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="devoluciones-total-text">Total de la devolución:</span>
                                    <span class="devoluciones-total-price">99€</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="text-center">
                                    <button class="btn-confirmar">Confirmar devolución</button>
                                </div>
                            </div>
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