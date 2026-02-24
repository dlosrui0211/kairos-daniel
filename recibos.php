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
    <!-- Header -->
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>

    <!-- Main Content -->
    <main id="main-content" class="recibos-main">
        <div class="container">
            <!-- Título -->
            <div class="row">
                <div class="col-12">
                    <div class="recibos-header">
                        <h1>RECIBOS</h1>
                        <br>
                    </div>
                </div>
            </div>

            <!-- Lista de Recibos -->
            <div class="row g-4">
                <!-- Recibo 1 -->
                <div class="col-12">
                    <div class="recibo-card">
                        <div class="recibo-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                                <polyline points="10 9 9 9 8 9"/>
                            </svg>
                        </div>
                        <div class="recibo-info">
                            <h2 class="recibo-titulo">Recibo 1</h2>
                            <p class="recibo-subtitulo">Solicitar devolución</p>
                        </div>
                        <div class="recibo-fecha">
                            <span>30 días</span>
                        </div>
                        <button class="recibo-delete" aria-label="Eliminar recibo">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                <line x1="10" y1="11" x2="10" y2="17"/>
                                <line x1="14" y1="11" x2="14" y2="17"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Recibo 2 -->
                <div class="col-12">
                    <div class="recibo-card">
                        <div class="recibo-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                                <polyline points="10 9 9 9 8 9"/>
                            </svg>
                        </div>
                        <div class="recibo-info">
                            <h2 class="recibo-titulo">Recibo 2</h2>
                            <p class="recibo-subtitulo">Solicitar devolución</p>
                        </div>
                        <div class="recibo-fecha">
                            <span>30 días</span>
                        </div>
                        <button class="recibo-delete" aria-label="Eliminar recibo">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                <line x1="10" y1="11" x2="10" y2="17"/>
                                <line x1="14" y1="11" x2="14" y2="17"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Recibo 3 -->
                <div class="col-12">
                    <div class="recibo-card">
                        <div class="recibo-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                                <polyline points="10 9 9 9 8 9"/>
                            </svg>
                        </div>
                        <div class="recibo-info">
                            <h2 class="recibo-titulo">Recibo 3</h2>
                            <p class="recibo-subtitulo">Solicitar devolución</p>
                        </div>
                        <div class="recibo-fecha">
                            <span>30 días</span>
                        </div>
                        <button class="recibo-delete" aria-label="Eliminar recibo">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                <line x1="10" y1="11" x2="10" y2="17"/>
                                <line x1="14" y1="11" x2="14" y2="17"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Recibo 4 -->
                <div class="col-12">
                    <div class="recibo-card">
                        <div class="recibo-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                                <polyline points="10 9 9 9 8 9"/>
                            </svg>
                        </div>
                        <div class="recibo-info">
                            <h2 class="recibo-titulo">Recibo 4</h2>
                            <p class="recibo-subtitulo">Solicitar devolución</p>
                        </div>
                        <div class="recibo-fecha">
                            <span>30 días</span>
                        </div>
                        <button class="recibo-delete" aria-label="Eliminar recibo">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                <line x1="10" y1="11" x2="10" y2="17"/>
                                <line x1="14" y1="11" x2="14" y2="17"/>
                            </svg>
                        </button>
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