<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kairos</title>
    <?php include("includes/head-tag-contents.php"); ?>
</head>
<body> 
    <main class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                
                <div class="col-12 text-center mb-4">
                    <img class="img-fluid" style="max-width: 160px;" src="assets/img/kairos.png"/>
                </div>

                <div class="col-11 col-sm-8 col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4"> <div class="card-body p-4 p-md-5">
                            
                        <h1 class="card-title text-center mb-4">¡Bienvenido a Kairos!</h1>

                        <form method="POST" action="index.php" novalidate>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label small fw-bold text-secondary">Email</label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    class="form-control" 
                                    placeholder="correo@ejemplo.com"/>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label small fw-bold text-secondary">Contraseña</label>
                                <input 
                                    class="control" 
                                    type="password" 
                                    id="password" 
                                    placeholder="password"/>
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg py-3">
                                    Iniciar Sesión
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="mb-1 text-muted small">¿Aún no tienes cuenta?</p>
                                <a href="registro.php" class="text-primary text-decoration-none fw-bold small">
                                    Regístrate aquí
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>