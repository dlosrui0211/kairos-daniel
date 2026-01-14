<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibos - Kairos</title>
    <?php include("includes/head-tag-contents.php"); ?>
</head>
<body>
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>
    <main class="recibos-main">
        <div class="container-lg">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="recibos-header">
                        <h1>Recibos</h1>
                    </div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-12">
                    <div class="recibo-card">
                        <div class="recibo-icon">
                            <img src="assets/img/recibo.png">
                        </div>
                        <div class="recibo-info">
                            <h3 class="recibo-titulo">Recibo 35</h3>
                            <p class="recibo-subtitulo">Emitido el 27 de Enero, 2026</p>
                        </div>
                        <div class="recibo-fecha">
                            <span>3 días</span>
                        </div>
                        <button class="recibo-delete" aria-label="Eliminar recibo">
                            <img src="assets/img/papelera.png">
                        </button>
                    </div>
                </div>
                <div class="col-12">
                    <div class="recibo-card">
                        <div class="recibo-icon">
                            <img src="assets/img/recibo.png">
                        </div>
                        <div class="recibo-info">
                            <h3 class="recibo-titulo">Recibo 41</h3>
                            <p class="recibo-subtitulo">Emitido el 08 de Enero, 2026</p>
                        </div>
                        <div class="recibo-fecha">
                            <span>20 días</span>
                        </div>
                        <button class="recibo-delete" aria-label="Eliminar recibo">
                            <img src="assets/img/papelera.png">
                        </button>
                    </div>
                </div>
                <div class="col-12">
                    <div class="recibo-card">
                        <div class="recibo-icon">
                            <img src="assets/img/recibo.png">
                        </div>
                        <div class="recibo-info">
                            <h3 class="recibo-titulo">Recibo 43</h3>
                            <p class="recibo-subtitulo">Emitido el 13 de Enero, 2026</p>
                        </div>
                        <div class="recibo-fecha">
                            <span>15 días</span>
                        </div>
                        <button class="recibo-delete" aria-label="Eliminar recibo">
                            <img src="assets/img/papelera.png">
                        </button>
                    </div>
                </div>
                <div class="col-12">
                    <div class="recibo-card">
                        <div class="recibo-icon">
                            <img src="assets/img/recibo.png">
                        </div>
                        <div class="recibo-info">
                            <h3 class="recibo-titulo">Recibo 22</h3>
                            <p class="recibo-subtitulo">Emitido el 14 de Diciembre, 2025</p>
                        </div>
                        <div class="recibo-fecha">
                            <span>30 días</span>
                        </div>
                        <button class="recibo-delete" aria-label="Eliminar recibo">
                            <img src="assets/img/papelera.png">
                        </button>
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