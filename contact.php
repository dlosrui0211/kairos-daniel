<?php 
include("includes/a_config.php");

$error = '';
$exito = '';

// Procesar formulario de contacto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['phone'] ?? '');
    $mensaje = trim($_POST['message'] ?? '');
    
    // Validaciones
    if (empty($nombre) || empty($email) || empty($telefono) || empty($mensaje)) {
        $error = 'Todos los campos son obligatorios';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El email no es válido';
    } elseif (strlen($mensaje) < 10) {
        $error = 'El mensaje debe tener al menos 10 caracteres';
    } else {
        // Aquí podrías enviar el email o guardar en base de datos
        // Por ahora solo mostramos mensaje de éxito
        $exito = 'Tu mensaje ha sido enviado correctamente. Te contactaremos pronto.';
        
        // Limpiar campos
        $nombre = $email = $telefono = $mensaje = '';
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Contacto - Kairos</title>
    <?php include("includes/head-tag-contents.php");?>
</head>

<body>

    <header>
        <?php include("includes/navigation.php");?>
        <?php include("includes/carrito.php");?>
    </header>
    <main id="main-content">
        <!-- Contact Section-->
        <section class="page-section" id="contact">
            <div class="container">
                <!-- Contact Section Heading-->
                <h1 class="page-section-heading text-center text-uppercase text-secondary mb-0">Contáctanos</h1>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star" aria-hidden="true"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <!-- Contact Section Form-->
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-7">
                        
                        <!-- Mostrar Error -->
                        <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>❌ Error:</strong> <?php echo htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                        <?php endif; ?>

                        <!-- Mostrar Éxito -->
                        <?php if ($exito): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>✅ Éxito:</strong> <?php echo htmlspecialchars($exito); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                        <?php endif; ?>
                        
                        <form id="contactForm" method="POST" action="">
                            <!-- Name input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="name" name="name" type="text" 
                                    placeholder="Ingresa tu nombre..."
                                    value="<?php echo htmlspecialchars($nombre ?? ''); ?>"
                                    required />
                                <label for="name">Nombre completo</label>
                            </div>
                            <!-- Email address input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" name="email" type="email" 
                                    placeholder="nombre@ejemplo.com"
                                    value="<?php echo htmlspecialchars($email ?? ''); ?>"
                                    required />
                                <label for="email">Correo electrónico</label>
                            </div>
                            <!-- Phone number input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="phone" name="phone" type="tel" 
                                    placeholder="600000000"
                                    value="<?php echo htmlspecialchars($telefono ?? ''); ?>"
                                    required />
                                <label for="phone">Número de teléfono</label>
                            </div>
                            <!-- Message input-->
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="message" name="message"
                                    placeholder="Escribe tu mensaje aquí..." style="height: 10rem"
                                    required><?php echo htmlspecialchars($mensaje ?? ''); ?></textarea>
                                <label for="message">Mensaje</label>
                            </div>
                            
                            <!-- Submit Button-->
                            <button class="btn btn-primary btn-xl" id="submitButton" type="submit">
                                Enviar Mensaje
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include("includes/footer.php");?>

</body>

</html>