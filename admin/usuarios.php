<?php
session_start();
require_once __DIR__ . '/../controlador/UsuarioController.php';

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
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <!-- Menú sencillo -->
    <nav class="admin-menu">
        <div class="menu-container">
            <a href="productos.php" class="menu-link">Productos</a>
            <a href="usuarios.php" class="menu-link active">Usuarios</a>
            <a href="valoraciones.php" class="menu-link">Valoraciones</a>
            <a href="../logout.php" class="menu-link active">Logout</a>

        </div>
    </nav>

    <div class="admin-panel">
        <div class="container">
            <div class="admin-header">
                <h1><i class="bi bi-people-fill"></i> Gestión de Usuarios</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearUsuario">
                    <i class="bi bi-plus-circle"></i> Nuevo Usuario
                </button>
            </div>

            <?php if ($mensaje): ?>
            <div class="alert alert-<?= $tipoMensaje ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($mensaje) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="admin-content">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Nombre Completo</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Fecha Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= $usuario['id'] ?></td>
                                <td><?= htmlspecialchars($usuario['username']) ?></td>
                                <td><?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']) ?></td>
                                <td><?= htmlspecialchars($usuario['correo']) ?></td>
                                <td><?= htmlspecialchars($usuario['telefono']) ?></td>
                                <td>
                                    <span
                                        class="badge bg-<?= $usuario['rol'] == 1 ? 'danger' : ($usuario['rol'] == 2 ? 'warning' : 'info') ?>">
                                        <?= $usuario['rol'] == 1 ? 'Admin' : ($usuario['rol'] == 2 ? 'Trabajador' : 'Cliente') ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $usuario['activo'] ? 'success' : 'secondary' ?>">
                                        <?= $usuario['activo'] ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($usuario['fecha_creacion'])) ?></td>
                                <td class="action-buttons">
                                    <button class="btn btn-sm btn-info"
                                        onclick="editarUsuario(<?= htmlspecialchars(json_encode($usuario)) ?>)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form method="POST" style="display: inline;"
                                        onsubmit="return confirm('¿Cambiar estado del usuario?')">
                                        <input type="hidden" name="accion" value="toggle_activo">
                                        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-warning">
                                            <i class="bi bi-toggle-<?= $usuario['activo'] ? 'on' : 'off' ?>"></i>
                                        </button>
                                    </form>
                                    <form method="POST" style="display: inline;"
                                        onsubmit="return confirm('¿Eliminar este usuario permanentemente?')">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear Usuario -->
    <div class="modal fade" id="modalCrearUsuario" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-person-plus"></i> Crear Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="accion" value="crear">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Username *</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" name="correo" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre *</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Apellidos *</label>
                                <input type="text" name="apellidos" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contraseña *</label>
                                <input type="password" name="password" class="form-control" required>
                                <small class="text-muted">Mín. 8 caracteres, mayúscula, minúscula, número y carácter
                                    especial</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha Nacimiento *</label>
                                <input type="date" name="fecha_nacimiento" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Teléfono *</label>
                                <input type="text" name="telefono" class="form-control" pattern="[0-9]{9}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Código Postal *</label>
                                <input type="text" name="codigo_postal" class="form-control" pattern="[0-9]{5}"
                                    required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Rol *</label>
                                <select name="rol" class="form-select" required>
                                    <?php foreach ($roles as $rol): ?>
                                    <option value="<?= $rol['id'] ?>"><?= ucfirst($rol['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Crear Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Usuario -->
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="accion" value="editar">
                        <input type="hidden" name="id" id="edit_id">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Username *</label>
                                <input type="text" name="username" id="edit_username" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" name="correo" id="edit_correo" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre *</label>
                                <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Apellidos *</label>
                                <input type="text" name="apellidos" id="edit_apellidos" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nueva Contraseña (dejar vacío para no cambiar)</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha Nacimiento *</label>
                                <input type="date" name="fecha_nacimiento" id="edit_fecha_nacimiento"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Teléfono *</label>
                                <input type="text" name="telefono" id="edit_telefono" class="form-control"
                                    pattern="[0-9]{9}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Código Postal *</label>
                                <input type="text" name="codigo_postal" id="edit_codigo_postal" class="form-control"
                                    pattern="[0-9]{5}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Rol *</label>
                                <select name="rol" id="edit_rol" class="form-select" required>
                                    <?php foreach ($roles as $rol): ?>
                                    <option value="<?= $rol['id'] ?>"><?= ucfirst($rol['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

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