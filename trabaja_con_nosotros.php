<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabaja con Nosotros - Kairos</title>
    <?php include("includes/head-tag-contents.php"); ?>
</head>
<body>
    <header>
        <?php include("includes/navigation.php"); ?>
        <?php include("includes/carrito.php"); ?>
    </header>

    <main class="afiliacion-main">
        <div class="container">
            
            <div class="row">
                <div class="col-12">
                    <h1 class="afiliacion-title">CONDICIONES DE AFILIACIÓN</h1>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <p class="afiliacion-text">Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que también ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenían pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.</p>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <p class="afiliacion-text">Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que también ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenían pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h2 class="afiliacion-form-title">FORMULARIO DE AFILIACIÓN</h2>
                </div>
            </div>

            
            <div class="row">
                <div class="col-12">
                    <form class="afiliacion-form">
                        
                        <div class="mb-4">
                            <label for="email" class="form-label afiliacion-label">Correo Electrónico</label>
                            <input type="email" class="form-control afiliacion-input" id="email" placeholder="tu@email.com" required>
                        </div>

                        <div class="mb-4">
                            <label for="motivo" class="form-label afiliacion-label">Motivo de Afiliación</label>
                            <textarea class="form-control afiliacion-textarea" id="motivo" placeholder="Cuéntanos por qué quieres trabajar con nosotros..." required></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn afiliacion-submit-btn">ENVIAR</button>
                        </div>

                    </form>
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