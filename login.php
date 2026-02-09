<?php 
session_start();
include("includes/a_config.php");
require_once __DIR__ . "/config_oauth.php";
require_once __DIR__ . "/captcha.php";
require_once __DIR__ . "/cookie_manager.php";

require_once __DIR__ . "/modelo/Conexion.php";
require_once __DIR__ . "/modelo/Usuario.php";
require_once __DIR__ . "/controlador/UsuarioController.php";
$controller = new UsuarioController();

// Auto-login si ya hay sesión o cookie
if ($_SESSION['usuario_id'] ?? false || $controller->validarRememberMe()) {
    $rol = $_SESSION['rol'] ?? 3;
    $redir = match ($rol) {
        1 => '/admin/usuarios.php',
        2 => '/admin/productos.php',
        3 => '/index.php',
        default => '/index.php'
    };
    header("Location: $redir");
    exit;
}

$error = '';
$exito = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $rememberMe = isset($_POST['remember_me']);
    $captchaRespuesta = $_POST['captcha_respuesta'] ?? '';

    if (!CaptchaMath::verificar($captchaRespuesta)) {
        $error = "Respuesta incorrecta al captcha. Inténtalo de nuevo.";
    } else {
        $resultado = $controller->login($username, $password);
        if ($resultado['success']) {
            $exito = $resultado['message'];
            if ($rememberMe) $controller->crearRememberMe($_SESSION['usuario_id']);
            $rol = $_SESSION['rol'] ?? 3;
            $redir = match ($rol) {
                1 => '/admin/usuarios.php',
                2 => '/admin/productos.php',
                3 => '/index.php',
                default => '/index.php'
            };
            header("Location: $redir");
            exit;
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
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>
<body>
<main class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Logo -->
            <div class="col-12 text-center mb-5">
                <img class="img-fluid" style="max-width:150px;" src="assets/img/kairos.png"
                     onerror="this.src='https://placehold.co/150x50/1c0538/ffffff?text=Kairos'" alt="Kairos Logo" />
            </div>

            <!-- Login Card -->
            <div class="col-12 col-sm-9 col-md-7 col-lg-5 col-xl-4">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <h1 class="card-title h2 text-center mb-4">¡Bienvenido a Kairos!</h1>

                        <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error:</strong> <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <?php if ($exito): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Éxito:</strong> <?= htmlspecialchars($exito) ?> Redirigiendo...
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <form method="POST" action="" novalidate>
                            <div class="mb-3">
                                <label for="email" class="form-label fw-500">Email o Usuario</label>
                                <input type="text" id="email" name="email" class="form-control form-control-lg"
                                    placeholder="correo@ejemplo.com o usuario_nombre"
                                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required />
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-500">Contraseña</label>
                                <input type="password" id="password" name="password" class="form-control form-control-lg"
                                       placeholder="Escribe tu contraseña" required />
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                                <label class="form-check-label" for="remember_me">Recordarme (30 días)</label>
                            </div>

                            <?= CaptchaMath::generarHTML(); ?>

                            <div class="d-grid gap-2 mb-4">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold">Iniciar Sesión</button>
                            </div>

                            <div class="text-center">
                                <p class="mb-0">
                                    ¿Aún no tienes cuenta?
                                    <a href="registro.php" class="text-primary fw-bold">Regístrate aquí</a>
                                </p>
                            </div>
                        </form>

                        <hr class="my-4">

                        <!-- Google OAuth Button -->
                        <div class="d-grid gap-2">
                            <div id="g_id_onload" data-client_id="<?= GOOGLE_CLIENT_ID ?>"
                                 data-callback="handleGoogleLogin" data-auto_prompt="false"></div>
                            <div class="g_id_signin" data-type="standard" data-size="large"
                                 data-theme="outline" data-text="signin_with" data-shape="rectangular"
                                 data-logo_alignment="left" data-width="100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="js/scripts.js"></script>
<script>
function handleGoogleLogin(response) {
    const existingForm = document.getElementById('googleLoginForm');
    if (existingForm) return;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'login_google.php';
    form.id = 'googleLoginForm';

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'credential';
    input.value = response.credential;

    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}
</script>

<?php
echo CookieManager::generarModalCookies();
echo CookieManager::generarModalSugerenciaRegistro();
echo CookieManager::generarModalNovedades();
?>
</body>
</html>
