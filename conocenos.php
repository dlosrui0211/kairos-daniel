<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conócenos - Kairos</title>
    <?php include("includes/head-tag-contents.php"); ?>
</head>
<body>
    <!-- Header -->
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>

    <!-- Main Content -->
    <main id="main-content" class="conocenos-main">
        <div class="container">
            <h1 class="visually-hidden">Conócenos - Kairos</h1>
            
            <!-- SECCIÓN 1: ¿QUIÉNES SOMOS? - SIN IMAGEN -->
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="conocenos-section-title">¿QUIÉNES SOMOS?</h2>
                    <p class="conocenos-text">Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que también ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenían pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.</p>
                </div>
            </div>

            <!-- SECCIÓN 2: HISTORIA - CON IMAGEN A LA IZQUIERDA -->
            <div class="row mb-5 align-items-center"> <!-- ✅ align-items-center para alinear verticalmente -->
                <!-- IMAGEN -->
                <div class="col-12 col-md-3"> <!-- ✅ 3 columnas para la imagen -->
                    <div class="conocenos-placeholder">
                        <img src="assets/img/placeholder.png" 
                             alt="" 
                             onerror="this.src='https://placehold.co/250x300/1c0538/ffffff?text=PLACEHOLDER+DE+ANUNCIO'">
                    </div>
                </div>
                <!-- TEXTO -->
                <div class="col-12 col-md-9"> <!-- ✅ 9 columnas para el texto -->
                    <h2 class="conocenos-section-title">HISTORIA</h2>
                    <p class="conocenos-text">Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que también ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenían pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.</p>
                </div>
            </div>

            <!-- SECCIÓN 3: ¿DE DÓNDE OBTENEMOS NUESTRAS CLAVES? - CON IMAGEN A LA IZQUIERDA -->
            <div class="row mb-5 align-items-center">
                <!-- IMAGEN -->
                <div class="col-12 col-md-3">
                    <div class="conocenos-placeholder">
                        <img src="assets/img/placeholder.png" 
                             alt="" 
                             onerror="this.src='https://placehold.co/250x300/1c0538/ffffff?text=PLACEHOLDER+DE+ANUNCIO'">
                    </div>
                </div>
                <!-- TEXTO -->
                <div class="col-12 col-md-9">
                    <h2 class="conocenos-section-title">¿DE DÓNDE OBTENEMOS NUESTRAS CLAVES?</h2>
                    <p class="conocenos-text">Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que también ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenían pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.</p>
                </div>
            </div>

            <!-- SECCIÓN 4: NUESTRO OBJETIVO - SIN IMAGEN -->
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="conocenos-section-title">NUESTRO OBJETIVO: HACER EL GAMING MÁS ACCESIBLE</h2>
                    <p class="conocenos-text">Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que también ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenían pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.</p>
                </div>
            </div>

            <!-- SECCIÓN 5: ¿QUIERES UNIRTE A NOSOTROS? -->
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="conocenos-section-title">¿QUIERES UNIRTE A NOSOTROS?</h2>
                </div>
            </div>

            <!-- BOTÓN UNIRSE -->
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <a href="trabaja.php" class="btn conocenos-join-btn">UNIRSE</a>
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