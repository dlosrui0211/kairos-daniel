<?php 
session_start();
include("includes/a_config.php");
require_once __DIR__ . "/config_oauth.php";
require_once __DIR__ . "/captcha.php"; // CAPTCHA personalizado
require_once __DIR__ . "/cookie_manager.php"; // Gestión de cookies

if (isset($_SESSION['usuario_id'])) {
    // Si ya está logueado, redirigir según su rol
    switch ($_SESSION['rol']) {
            case 1: // Administrador
                header("Location: /admin/usuarios.php");
                exit;
            case 2: // Trabajador
                header("Location: /admin/productos.php");
                exit;
            case 3: // Cliente
                header("Location: /index.php");                
            default:
                header("Location: /index.php");
                exit;
    }
    exit();
}

// Verificar si hay cookie de "Remember Me"
require_once __DIR__ . "/model/Conexion.php";
require_once __DIR__ . "/model/Usuario.php";
require_once __DIR__ . "/controller/UsuarioController.php";
$controller = new UsuarioController();

if ($controller->validarRememberMe()) {
    // Auto-login exitoso, redirigir según rol
    $rol = $_SESSION['rol'] ?? 3;
    switch ($rol) {
        case 1:
            header("Location: /admin/usuarios.php");
            exit;
        case 2:
            header("Location: /admin/productos.php");
            exit;
        case 3:
        default:
            header("Location: /index.php");
            exit;
    }
}

$error = '';
$exito = '';
$resultado = null;

// Mostrar error de Google OAuth si existe
if (isset($_SESSION['error_google'])) {
    $error = $_SESSION['error_google'];
    unset($_SESSION['error_google']);
}

// Si el formulario se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $rememberMe = isset($_POST['remember_me']);
    $captchaRespuesta = $_POST['captcha_respuesta'] ?? '';
    
    // Verificar CAPTCHA personalizado
    if (!CaptchaMath::verificar($captchaRespuesta)) {
        $error = "Respuesta incorrecta al captcha. Inténtalo de nuevo.";
    } else {
        $resultado = $controller->login($username, $password);
        
        if ($resultado['success']) {
            $exito = $resultado['message'];
            
            // Crear cookie "Remember Me" si está marcado
            if ($rememberMe) {
                $controller->crearRememberMe($_SESSION['usuario_id']);
            }
            
            // Redirigir según el rol del usuario
            $rol = $_SESSION['rol'] ?? 3;
            
            switch ($rol) {
                case 1: // Administrador
                    header("Location: /admin/usuarios.php");
                    exit;
                case 2: // Trabajador
                    header("Location: /admin/productos.php");
                    exit;
                case 3: // Cliente
                    header("Location: /index.php");                
                default:
                    header("Location: /index.php");
                    exit;
            }

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
    <title>Login - Kairos</title>
    <?php include("includes/head-tag-contents.php"); ?>
    <!-- Google OAuth -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>

<body>
    <main id="main-content" class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Logo -->
                <div class="col-12 text-center mb-5">
                    <img class="img-fluid" style="max-width: 150px; height: auto;" src="assets/img/kairos.png"
                        onerror="this.src='https://placehold.co/150x50/1c0538/ffffff?text=Kairos'" alt="Kairos Logo" />
                </div>

                <!-- Login Form Card -->
                <div class="col-12 col-sm-9 col-md-7 col-lg-5 col-xl-4">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <!-- Título -->
                            <h1 class="card-title h2 text-center mb-4">
                                ¡Bienvenido a Kairos!
                            </h1>

                            <!-- Mostrar Error -->
                            <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><span aria-hidden="true">❌</span> Error:</strong> <?php echo htmlspecialchars($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Cerrar alerta de error"></button>
                            </div>
                            <?php endif; ?>

                            <!-- Mostrar Éxito -->
                            <?php if ($exito): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong><span aria-hidden="true">✅</span> Éxito:</strong> <?php echo htmlspecialchars($exito); ?> Redirigiendo...
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Cerrar alerta de éxito"></button>
                            </div>
                            <?php endif; ?>

                            <!-- Formulario Login -->
                            <form method="POST" action="" novalidate aria-label="Formulario de inicio de sesión">

                                <!-- Email/Username Input -->
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-500">Email o Usuario</label>
                                    <input type="text" id="email" name="email" class="form-control form-control-lg"
                                        placeholder="correo@ejemplo.com o usuario_nombre"
                                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                        autocomplete="username"
                                        aria-describedby="emailHelp"
                                        required />
                                    <div id="emailHelp" class="invalid-feedback">
                                        Por favor introduce un email o usuario válido.
                                    </div>
                                </div>

                                <!-- Password Input -->
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-500">Contraseña</label>
                                    <input type="password" id="password" name="password"
                                        class="form-control form-control-lg" placeholder="••••••••"
                                        autocomplete="current-password"
                                        aria-describedby="passwordHelp"
                                        required />
                                    <div id="passwordHelp" class="invalid-feedback">
                                        Por favor introduce tu contraseña.
                                    </div>
                                </div>

                                <!-- Remember Me Checkbox -->
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                                    <label class="form-check-label" for="remember_me">
                                        Recordarme (30 días)
                                    </label>
                                </div>

                                <!-- CAPTCHA Matemático Personalizado -->
                                <?php echo CaptchaMath::generarHTML(); ?>

                                <!-- Login Button -->
                                <div class="d-grid gap-2 mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg fw-bold" name="enviar"
                                        id="enviar" aria-label="Iniciar sesión en Kairos">
                                        Iniciar Sesión
                                    </button>
                                </div>

                                <!-- Register Link -->
                                <div class="text-center">
                                    <p class="mb-0">
                                        ¿Aún no tienes cuenta?
                                        <a href="register.php" class="text-primary text-decoration-none fw-bold">
                                            Regístrate aquí
                                        </a>
                                    </p>
                                </div>
                            </form>

                            <!-- Divider -->
                            <hr class="my-4">

                            <!-- Google OAuth Button -->
                            <div class="d-grid gap-2">
                                <div id="g_id_onload" data-client_id="<?php echo GOOGLE_CLIENT_ID; ?>"
                                    data-callback="handleGoogleLogin" data-auto_prompt="false">
                                </div>
                                <div class="g_id_signin" data-type="standard" data-size="large" data-theme="outline"
                                    data-text="signin_with" data-shape="rectangular" data-logo_alignment="left"
                                    data-width="100%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="js/scripts.js"></script>

    <!-- Google OAuth Callback Handler -->
    <script>
    function handleGoogleLogin(response) {
        // Enviar el token JWT a login_google.php
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'login_google.php';

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'credential';
        input.value = response.credential;

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
    </script>

    <!-- Modales de Gestión de Cookies -->
    <?php 
    // Modal de aceptación de cookies (primera visita)
    echo CookieManager::generarModalCookies();
    
    // Modal de sugerencia de registro (primera visita, si ya aceptó cookies)
    echo CookieManager::generarModalSugerenciaRegistro();
    
    // Modal de novedades (1 vez al mes, solo usuarios logueados)
    echo CookieManager::generarModalNovedades();
    ?>
</body>

</html>