<?php
session_start();
require_once __DIR__ . '/../controller/UsuarioController.php';

$controller = new UsuarioController();

// Verificar que sea administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    if (isset($_SESSION['rol']) && $_SESSION['rol'] == 2) {
        header("Location: productos.php");
        exit();
    }
    header("Location: ../index.php");
    exit();
}

// Manejar operaciones CRUD
$mensaje = "";
$tipoMensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    
    switch ($accion) {
        case 'crear':
            $resultado = $controller->registrar($_POST);
            $mensaje = $resultado['message'];
            $tipoMensaje = $resultado['success'] ? 'success' : 'danger';
            break;
            
        case 'editar':
            $resultado = $controller->actualizarUsuario($_POST);
            $mensaje = $resultado['message'];
            $tipoMensaje = $resultado['success'] ? 'success' : 'danger';
            break;
            
        case 'eliminar':
            $resultado = $controller->eliminarUsuario($_POST['id']);
            $mensaje = $resultado['message'];
            $tipoMensaje = $resultado['success'] ? 'success' : 'danger';
            break;
            
        case 'toggle_activo':
            $resultado = $controller->toggleActivo($_POST['id']);
            $mensaje = $resultado['message'];
            $tipoMensaje = $resultado['success'] ? 'success' : 'danger';
            break;
    }
}

// Obtener todos los usuarios
$usuarios = $controller->obtenerTodosUsuarios();
$roles = $controller->obtenerRoles();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios - Kairos</title>
    <!-- Font Awesome icons (free version) -->
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" crossorigin="anonymous"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gasoek+One&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <!-- Core theme CSS -->
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <!-- Menú sencillo -->
    <nav class="admin-menu" role="navigation" aria-label="Menú de administración">
        <div class="menu-container">
            <a href="../index.php" class="menu-link" aria-label="Ir a la tienda principal">Ir a la Tienda</a>
            <a href="productos.php" class="menu-link" aria-label="Administrar productos">Productos</a>
            <a href="usuarios.php" class="menu-link active" aria-current="page" aria-label="Administrar usuarios">Usuarios</a>
            <a href="valoraciones.php" class="menu-link" aria-label="Administrar valoraciones">Valoraciones</a>
            <a href="../logout.php" class="menu-link" aria-label="Cerrar sesión">Logout</a>
        </div>
    </nav>

    <div class="admin-panel">
        <div class="container">
            <header class="admin-header">
                <h1><i class="bi bi-people-fill" aria-hidden="true"></i> Gestión de Usuarios</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearUsuario"
                    aria-label="Abrir formulario para crear nuevo usuario">
                    <i class="bi bi-plus-circle" aria-hidden="true"></i> Nuevo Usuario
                </button>
            </header>

            <?php if ($mensaje): ?>
            <div class="alert alert-<?= $tipoMensaje ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($mensaje) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar alerta"></button>
            </div>
            <?php endif; ?>

            <div class="admin-content">
                <div class="admin-cards-grid admin-cards-grid--wide">
                    <?php foreach ($usuarios as $usuario): ?>
                    <article class="admin-card admin-card--user">
                        <div class="admin-card-user-header">
                            <div class="admin-card-avatar">
                                <?= strtoupper(substr($usuario['username'], 0, 1)) ?>
                            </div>
                            <div>
                                <h2 class="admin-card-title"><?= htmlspecialchars($usuario['username']) ?></h2>
                                <p class="admin-card-subtitle"><?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']) ?></p>
                            </div>
                        </div>
                        <div class="admin-card-body">
                            <div class="admin-card-meta">
                                <span class="badge bg-<?= $usuario['rol'] == 1 ? 'danger' : ($usuario['rol'] == 2 ? 'warning' : 'info') ?>"
                                    role="status"
                                    aria-label="Rol: <?= $usuario['rol'] == 1 ? 'Administrador' : ($usuario['rol'] == 2 ? 'Trabajador' : 'Cliente') ?>">
                                    <?= $usuario['rol'] == 1 ? 'Admin' : ($usuario['rol'] == 2 ? 'Trabajador' : 'Cliente') ?>
                                </span>
                                <span class="badge bg-<?= $usuario['activo'] ? 'success' : 'secondary' ?>"
                                    role="status"
                                    aria-label="Estado: <?= $usuario['activo'] ? 'Activo' : 'Inactivo' ?>">
                                    <?= $usuario['activo'] ? 'Activo' : 'Inactivo' ?>
                                </span>
                            </div>
                            <div class="admin-card-details">
                                <div class="admin-card-detail">
                                    <span class="detail-label"><i class="bi bi-envelope" aria-hidden="true"></i> Email</span>
                                    <span class="detail-value"><?= htmlspecialchars($usuario['correo']) ?></span>
                                </div>
                                <div class="admin-card-detail">
                                    <span class="detail-label"><i class="bi bi-telephone" aria-hidden="true"></i> Teléfono</span>
                                    <span class="detail-value"><?= htmlspecialchars($usuario['telefono']) ?></span>
                                </div>
                                <div class="admin-card-detail">
                                    <span class="detail-label"><i class="bi bi-calendar" aria-hidden="true"></i> Registro</span>
                                    <span class="detail-value"><time datetime="<?= $usuario['fecha_creacion'] ?>"><?= date('d/m/Y', strtotime($usuario['fecha_creacion'])) ?></time></span>
                                </div>
                            </div>
                        </div>
                        <div class="admin-card-actions">
                            <button class="btn btn-sm btn-info"
                                onclick="editarUsuario(<?= htmlspecialchars(json_encode($usuario)) ?>)"
                                aria-label="Editar usuario <?= htmlspecialchars($usuario['username']) ?>">
                                <i class="bi bi-pencil" aria-hidden="true"></i> Editar
                            </button>
                            <form method="POST" style="display: inline;"
                                onsubmit="return confirm('¿Cambiar estado del usuario?')"
                                aria-label="Cambiar estado de <?= htmlspecialchars($usuario['username']) ?>">
                                <input type="hidden" name="accion" value="toggle_activo">
                                <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-warning"
                                    aria-label="<?= $usuario['activo'] ? 'Desactivar' : 'Activar' ?> usuario <?= htmlspecialchars($usuario['username']) ?>">
                                    <i class="bi bi-toggle-<?= $usuario['activo'] ? 'on' : 'off' ?>" aria-hidden="true"></i>
                                    <?= $usuario['activo'] ? 'Desactivar' : 'Activar' ?>
                                </button>
                            </form>
                            <form method="POST" style="display: inline;"
                                onsubmit="return confirm('¿Eliminar este usuario permanentemente?')"
                                aria-label="Eliminar usuario <?= htmlspecialchars($usuario['username']) ?>">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger"
                                    aria-label="Eliminar permanentemente a <?= htmlspecialchars($usuario['username']) ?>">
                                    <i class="bi bi-trash" aria-hidden="true"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear Usuario -->
    <div class="modal fade" id="modalCrearUsuario" tabindex="-1" aria-labelledby="modalCrearUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="modalCrearUsuarioLabel"><i class="bi bi-person-plus" aria-hidden="true"></i> Crear Nuevo Usuario</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar formulario"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="accion" value="crear">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="crear_username" class="form-label">Username *</label>
                                <input type="text" id="crear_username" name="username" class="form-control" 
                                    autocomplete="username" 
                                    aria-describedby="crear_usernameHelp" 
                                    required>
                                <small id="crear_usernameHelp" class="form-text text-muted">Mínimo 3 caracteres</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="crear_correo" class="form-label">Email *</label>
                                <input type="email" id="crear_correo" name="correo" class="form-control" 
                                    autocomplete="email" 
                                    aria-describedby="crear_correoHelp" 
                                    required>
                                <small id="crear_correoHelp" class="form-text text-muted">Formato: correo@ejemplo.com</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="crear_nombre" class="form-label">Nombre *</label>
                                <input type="text" id="crear_nombre" name="nombre" class="form-control" 
                                    autocomplete="given-name" 
                                    aria-describedby="crear_nombreHelp" 
                                    required>
                                <small id="crear_nombreHelp" class="form-text text-muted">Solo letras y espacios</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="crear_apellidos" class="form-label">Apellidos *</label>
                                <input type="text" id="crear_apellidos" name="apellidos" class="form-control" 
                                    autocomplete="family-name" 
                                    aria-describedby="crear_apellidosHelp" 
                                    required>
                                <small id="crear_apellidosHelp" class="form-text text-muted">Solo letras y espacios</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="crear_password" class="form-label">Contraseña *</label>
                                <input type="password" id="crear_password" name="password" class="form-control" 
                                    autocomplete="new-password" 
                                    aria-describedby="crear_passwordHelp" 
                                    required>
                                <small id="crear_passwordHelp" class="form-text text-muted">Mín. 8 caracteres, mayúscula, minúscula, número y carácter especial</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="crear_fecha_nacimiento" class="form-label">Fecha Nacimiento *</label>
                                <input type="date" id="crear_fecha_nacimiento" name="fecha_nacimiento" class="form-control" 
                                    autocomplete="bday" 
                                    aria-describedby="crear_fechaHelp" 
                                    required>
                                <small id="crear_fechaHelp" class="form-text text-muted">Debe ser mayor de 16 años</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="crear_telefono" class="form-label">Teléfono *</label>
                                <input type="text" id="crear_telefono" name="telefono" class="form-control" 
                                    pattern="[0-9]{9}" 
                                    inputmode="tel" 
                                    autocomplete="tel" 
                                    aria-describedby="crear_telefonoHelp" 
                                    required>
                                <small id="crear_telefonoHelp" class="form-text text-muted">9 dígitos sin espacios</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="crear_codigo_postal" class="form-label">Código Postal *</label>
                                <input type="text" id="crear_codigo_postal" name="codigo_postal" class="form-control" 
                                    pattern="[0-9]{5}" 
                                    inputmode="numeric" 
                                    autocomplete="postal-code" 
                                    aria-describedby="crear_codigoPostalHelp" 
                                    required>
                                <small id="crear_codigoPostalHelp" class="form-text text-muted">5 dígitos</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="crear_rol" class="form-label">Rol *</label>
                                <select id="crear_rol" name="rol" class="form-select" 
                                    aria-describedby="crear_rolHelp" 
                                    required>
                                    <?php foreach ($roles as $rol): ?>
                                    <option value="<?= $rol['id'] ?>"><?= ucfirst($rol['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small id="crear_rolHelp" class="form-text text-muted">Seleccione el rol del usuario</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" 
                            aria-label="Cancelar creación de usuario">Cancelar</button>
                        <button type="submit" class="btn btn-primary" 
                            aria-label="Crear nuevo usuario">Crear Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Usuario -->
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="modalEditarUsuarioLabel"><i class="bi bi-pencil-square" aria-hidden="true"></i> Editar Usuario</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar formulario de edición"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="accion" value="editar">
                        <input type="hidden" name="id" id="edit_id">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_username" class="form-label">Username *</label>
                                <input type="text" name="username" id="edit_username" class="form-control" 
                                    autocomplete="username" 
                                    aria-describedby="edit_usernameHelp" 
                                    required>
                                <small id="edit_usernameHelp" class="form-text text-muted">Mínimo 3 caracteres</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_correo" class="form-label">Email *</label>
                                <input type="email" name="correo" id="edit_correo" class="form-control" 
                                    autocomplete="email" 
                                    aria-describedby="edit_correoHelp" 
                                    required>
                                <small id="edit_correoHelp" class="form-text text-muted">Formato: correo@ejemplo.com</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_nombre" class="form-label">Nombre *</label>
                                <input type="text" name="nombre" id="edit_nombre" class="form-control" 
                                    autocomplete="given-name" 
                                    aria-describedby="edit_nombreHelp" 
                                    required>
                                <small id="edit_nombreHelp" class="form-text text-muted">Solo letras y espacios</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_apellidos" class="form-label">Apellidos *</label>
                                <input type="text" name="apellidos" id="edit_apellidos" class="form-control" 
                                    autocomplete="family-name" 
                                    aria-describedby="edit_apellidosHelp" 
                                    required>
                                <small id="edit_apellidosHelp" class="form-text text-muted">Solo letras y espacios</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_password" class="form-label">Nueva Contraseña (dejar vacío para no cambiar)</label>
                                <input type="password" id="edit_password" name="password" class="form-control" 
                                    autocomplete="new-password" 
                                    aria-describedby="edit_passwordHelp">
                                <small id="edit_passwordHelp" class="form-text text-muted">Mín. 8 caracteres, mayúscula, minúscula, número y carácter especial</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_fecha_nacimiento" class="form-label">Fecha Nacimiento *</label>
                                <input type="date" name="fecha_nacimiento" id="edit_fecha_nacimiento"
                                    class="form-control" 
                                    autocomplete="bday" 
                                    aria-describedby="edit_fechaHelp" 
                                    required>
                                <small id="edit_fechaHelp" class="form-text text-muted">Debe ser mayor de 16 años</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="edit_telefono" class="form-label">Teléfono *</label>
                                <input type="text" name="telefono" id="edit_telefono" class="form-control"
                                    pattern="[0-9]{9}" 
                                    inputmode="tel" 
                                    autocomplete="tel" 
                                    aria-describedby="edit_telefonoHelp" 
                                    required>
                                <small id="edit_telefonoHelp" class="form-text text-muted">9 dígitos sin espacios</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_codigo_postal" class="form-label">Código Postal *</label>
                                <input type="text" name="codigo_postal" id="edit_codigo_postal" class="form-control"
                                    pattern="[0-9]{5}" 
                                    inputmode="numeric" 
                                    autocomplete="postal-code" 
                                    aria-describedby="edit_codigoPostalHelp" 
                                    required>
                                <small id="edit_codigoPostalHelp" class="form-text text-muted">5 dígitos</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_rol" class="form-label">Rol *</label>
                                <select name="rol" id="edit_rol" class="form-select" 
                                    aria-describedby="edit_rolHelp" 
                                    required>
                                    <?php foreach ($roles as $rol): ?>
                                    <option value="<?= $rol['id'] ?>"><?= ucfirst($rol['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small id="edit_rolHelp" class="form-text text-muted">Seleccione el rol del usuario</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" 
                            aria-label="Cancelar edición">Cancelar</button>
                        <button type="submit" class="btn btn-primary" 
                            aria-label="Guardar cambios del usuario">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function editarUsuario(usuario) {
        document.getElementById('edit_id').value = usuario.id;
        document.getElementById('edit_username').value = usuario.username;
        document.getElementById('edit_correo').value = usuario.correo;
        document.getElementById('edit_nombre').value = usuario.nombre;
        document.getElementById('edit_apellidos').value = usuario.apellidos;
        document.getElementById('edit_fecha_nacimiento').value = usuario.fecha_nacimiento;
        document.getElementById('edit_telefono').value = usuario.telefono;
        document.getElementById('edit_codigo_postal').value = usuario.codigo_postal;
        document.getElementById('edit_rol').value = usuario.rol;

        const modal = new bootstrap.Modal(document.getElementById('modalEditarUsuario'));
        modal.show();
    }
    </script>
</body>

</html>