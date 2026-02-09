<?php 
session_start();
include("includes/a_config.php");
require_once __DIR__ . "/config_oauth.php";
require_once __DIR__ . "/captcha.php"; 

if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . "/modelo/Conexion.php";
    require_once __DIR__ . "/modelo/Usuario.php";
    require_once __DIR__ . "/controlador/UsuarioController.php";
    
    $controller = new UsuarioController();
    
    $captchaRespuesta = $_POST['captcha_respuesta'] ?? '';
    
    // Verificar CAPTCHA personalizado
    if (!CaptchaMath::verificar($captchaRespuesta)) {
        $error = "Respuesta incorrecta al captcha. Inténtalo de nuevo.";
    } else {
        $datos = [
            'username' => $_POST['username'] ?? '',
            'password' => $_POST['password'] ?? '',
            'nombre' => $_POST['nombre'] ?? '',
            'apellidos' => $_POST['apellidos'] ?? '',
            'correo' => $_POST['email'] ?? '',
            'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
        ];
        
        $resultado = $controller->registrar($datos);
        
        if ($resultado['success']) {
            $exito = $resultado['message'];
            // Limpiar formulario
            $_POST = [];
        } else {
            $error = $resultado['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Kairos</title>
    <?php include("includes/head-tag-contents.php"); ?>
</head>

<body>
    <main class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Logo -->
                <div class="col-12 text-center mb-5">
                    <img class="img-fluid" style="max-width: 150px; height: auto;" src="assets/img/kairos.png"
                        onerror="this.src='https://placehold.co/150x50/1c0538/ffffff?text=Kairos'" alt="Kairos Logo" />
                </div>

                <div class="col-12 col-sm-10 col-md-8 col-lg-7 col-xl-5">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <!-- Título -->
                            <h1 class="card-title h2 text-center mb-2">
                                ¡Regístrate!
                            </h1>
                            <p class="text-center text-muted small mb-4">
                                Crea tu cuenta rellenando el formulario
                            </p>

                            <!-- Mostrar Error -->
                            <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>❌ Error:</strong> <?php echo htmlspecialchars($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <?php endif; ?>

                            <!-- Mostrar Éxito -->
                            <?php if ($exito): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>✅ Éxito:</strong> <?php echo htmlspecialchars($exito); ?>
                                <p class="mt-2 mb-0">Redirigiendo a login en 2 segundos...</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <script>
                            setTimeout(() => {
                                window.location.href = 'login.php';
                            }, 2000);
                            </script>
                            <?php endif; ?>

                            <!-- Formulario Registro -->
                            <form method="POST" action="" novalidate>

                                <!-- Username Input -->
                                <div class="mb-3">
                                    <label for="username" class="form-label fw-500">Nombre de Usuario</label>
                                    <input type="text" id="username" name="username"
                                        class="form-control form-control-lg" placeholder="usuario_nombre"
                                        value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                                        required />
                                    <small class="text-muted">Alfanumérico y guion bajo, 3-50 caracteres</small>
                                </div>

                                <!-- Nombre Input -->
                                <div class="mb-3">
                                    <label for="nombre" class="form-label fw-500">Nombre</label>
                                    <input type="text" id="nombre" name="nombre" class="form-control form-control-lg"
                                        placeholder="Tu nombre"
                                        value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>"
                                        required />
                                </div>

                                <!-- Apellidos Input -->
                                <div class="mb-3">
                                    <label for="apellidos" class="form-label fw-500">Apellidos</label>
                                    <input type="text" id="apellidos" name="apellidos"
                                        class="form-control form-control-lg" placeholder="Tus apellidos"
                                        value="<?php echo isset($_POST['apellidos']) ? htmlspecialchars($_POST['apellidos']) : ''; ?>"
                                        required />
                                </div>

                                <!-- Email Input -->
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-500">Email</label>
                                    <input type="email" id="email" name="email" class="form-control form-control-lg"
                                        placeholder="correo@ejemplo.com"
                                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                        required />
                                </div>

                                <!-- Fecha Nacimiento Input -->
                                <div class="mb-3">
                                    <label for="fecha_nacimiento" class="form-label fw-500">Fecha de Nacimiento</label>
                                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                                        class="form-control form-control-lg"
                                        value="<?php echo isset($_POST['fecha_nacimiento']) ? htmlspecialchars($_POST['fecha_nacimiento']) : ''; ?>"
                                        required />
                                    <small class="text-muted">Debes ser mayor de 18 años</small>
                                </div>

                                <!-- Password Input -->
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-500">Contraseña</label>
                                    <input type="password" id="password" name="password"
                                        class="form-control form-control-lg" placeholder="Crea una contraseña segura"
                                        required />
                                    <small class="text-muted">Mínimo 8 caracteres: minúscula, mayúscula, número y
                                        carácter especial (@$!%*?&)</small>
                                </div>

                                <!-- CAPTCHA Matemático Personalizado -->
                                <?php echo CaptchaMath::generarHTML(); ?>

                                <!-- Buttons Row -->
                                <div class="d-grid gap-2 mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                        Registrarse
                                    </button>
                                    <a href="login.php" class="btn btn-outline-secondary btn-lg fw-bold">
                                        Cancelar
                                    </a>
                                </div>

                                <!-- Login Link -->
                                <div class="text-center">
                                    <p class="small mb-0">
                                        ¿Ya tienes cuenta?
                                        <a href="login.php" class="text-primary text-decoration-none fw-bold">
                                            Inicia sesión aquí
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="js/scripts.js"></script>
</body>

</html>