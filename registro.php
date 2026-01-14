<?php include("includes/a_config.php"); ?>
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
                <div class="col-12 text-center mb-4">
                    <img class="img-fluid" style="max-width: 150px; height: auto;" src="assets/img/kairos.png" alt="Logo"/>
                </div>

                <div class="col-12 col-sm-10 col-md-8 col-lg-7 col-xl-5">
                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-body p-4 p-md-5">
                            <h1 class="card-title text-center mb-2">¡Regístrate rellenando el formulario!</h1>

                            <form method="POST" action="" novalidate>
                                
                                <div class="mb-3">
                                    <label for="nombre" class="form-label small fw-bold">Nombre</label>
                                    <input 
                                        type="text" 
                                        id="nombre" 
                                        name="nombre"
                                        class="form-control form-control-lg" 
                                        placeholder="Tu nombre"/>
                                </div>

                                <div class="mb-3">
                                    <label for="apellidos" class="form-label small fw-bold">Apellidos</label>
                                    <input 
                                        type="text" 
                                        id="apellidos" 
                                        name="apellidos"
                                        class="form-control form-control-lg" 
                                        placeholder="Tus apellidos"/>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label small fw-bold">Email</label>
                                    <input 
                                        type="email" 
                                        id="email" 
                                        name="email"
                                        class="form-control form-control-lg bg-white" 
                                        placeholder="correo@ejemplo.com"/>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label small">Contraseña</label>
                                    <input 
                                        type="password" 
                                        id="password" 
                                        name="password"
                                        class="form-control form-control-lg" 
                                        placeholder="Crea una contraseña" />
                                </div>

                                <div class="d-grid gap-2 mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                        Aceptar
                                    </button>
                                    <a href="login.php" class="btn btn-outline-secondary btn-lg">
                                        Cancelar
                                    </a>
                                </div>

                                <div class="text-center border-top pt-3">
                                    <p class="small mb-1 text-muted">¿Ya tienes cuenta registrada?</p>
                                    <a href="login.php" class="text-decoration-none">
                                        Inicia sesión aquí
                                    </a>
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