<?php
session_start();
require_once __DIR__ . "/../controlador/ValoracionController.php";
require_once __DIR__ . "/../controlador/ProductoController.php";
require_once __DIR__ . "/../controlador/UsuarioController.php";

$valoracionController = new ValoracionController();
$productoController = new ProductoController();
$usuarioController = new UsuarioController();

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
            $resultado = $valoracionController->guardarValoracion(
                $_POST['id_usuario'],
                $_POST['id_producto'],
                $_POST['puntuacion'],
                $_POST['comentario']
            );
            $mensaje = $resultado ? "Valoración creada correctamente" : "Error al crear la valoración";
            $tipoMensaje = $resultado ? 'success' : 'danger';
            break;
            
        case 'editar':
            $resultado = $valoracionController->guardarValoracion(
                $_POST['id_usuario'],
                $_POST['id_producto'],
                $_POST['puntuacion'],
                $_POST['comentario']
            );
            $mensaje = $resultado ? "Valoración actualizada correctamente" : "Error al actualizar la valoración";
            $tipoMensaje = $resultado ? 'success' : 'danger';
            break;
            
        case 'eliminar':
            $resultado = $valoracionController->eliminarValoracion(
                $_POST['id_usuario'],
                $_POST['id_producto']
            );
            $mensaje = $resultado ? "Valoración eliminada correctamente" : "Error al eliminar la valoración";
            $tipoMensaje = $resultado ? 'success' : 'danger';
            break;
    }
}

// Obtener todas las valoraciones con información de usuario y producto
$valoraciones = $valoracionController->obtenerTodasValoraciones();
$productos = $productoController->obtenerTodos();
$usuarios = $usuarioController->obtenerTodosUsuarios();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Valoraciones - Kairos</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <!-- Menú sencillo -->
    <nav class="admin-menu">
        <div class="menu-container">
            <a href="productos.php" class="menu-link">Productos</a>
            <a href="usuarios.php" class="menu-link">Usuarios</a>
            <a href="valoraciones.php" class="menu-link active">Valoraciones</a>
            <a href="../logout.php" class="menu-link active">Logout</a>
        </div>
    </nav>

    <div class="admin-panel">
        <div class="container">
            <div class="admin-header">
                <h1><i class="bi bi-star-fill"></i> Gestión de Valoraciones</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearValoracion">
                    <i class="bi bi-plus-circle"></i> Nueva Valoración
                </button>
            </div>

            <?php if ($mensaje): ?>
            <div class="alert alert-<?= $tipoMensaje ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($mensaje) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="admin-content">
                <!-- Filtros -->
                <div class="filters-section mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Filtrar por Producto</label>
                            <select class="form-select" id="filtroProducto" onchange="filtrarTabla()">
                                <option value="">Todos los productos</option>
                                <?php foreach ($productos as $prod): ?>
                                <option value="<?= $prod['id'] ?>"><?= htmlspecialchars($prod['titulo']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Filtrar por Usuario</label>
                            <select class="form-select" id="filtroUsuario" onchange="filtrarTabla()">
                                <option value="">Todos los usuarios</option>
                                <?php foreach ($usuarios as $usr): ?>
                                <option value="<?= $usr['id'] ?>"><?= htmlspecialchars($usr['username']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Filtrar por Puntuación</label>
                            <select class="form-select" id="filtroPuntuacion" onchange="filtrarTabla()">
                                <option value="">Todas las puntuaciones</option>
                                <option value="5">⭐⭐⭐⭐⭐ (5 estrellas)</option>
                                <option value="4">⭐⭐⭐⭐ (4 estrellas)</option>
                                <option value="3">⭐⭐⭐ (3 estrellas)</option>
                                <option value="2">⭐⭐ (2 estrellas)</option>
                                <option value="1">⭐ (1 estrella)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="admin-table" id="tablaValoraciones">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Producto</th>
                                <th>Puntuación</th>
                                <th>Comentario</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($valoraciones as $valoracion): ?>
                            <tr data-producto="<?= $valoracion['id_producto'] ?>"
                                data-usuario="<?= $valoracion['id_usuario'] ?>"
                                data-puntuacion="<?= $valoracion['puntuacion'] ?>">
                                <td>
                                    <div class="user-info">
                                        <strong><?= htmlspecialchars($valoracion['username']) ?></strong><br>
                                        <small class="text-muted"><?= htmlspecialchars($valoracion['nombre']) ?></small>
                                    </div>
                                </td>
                                <td>
                                    <div class="product-info">
                                        <strong><?= htmlspecialchars($valoracion['producto_titulo']) ?></strong><br>
                                        <small
                                            class="text-muted"><?= htmlspecialchars($valoracion['plataforma_nombre'] ?? 'N/A') ?></small>
                                    </div>
                                </td>
                                <td>
                                    <div class="rating-display">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i
                                            class="bi bi-star<?= $i <= $valoracion['puntuacion'] ? '-fill' : '' ?> text-warning"></i>
                                        <?php endfor; ?>
                                        <span class="ms-2">(<?= $valoracion['puntuacion'] ?>/5)</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="comentario-preview">
                                        <?= $valoracion['comentario'] ? htmlspecialchars(substr($valoracion['comentario'], 0, 100)) . (strlen($valoracion['comentario']) > 100 ? '...' : '') : '<em class="text-muted">Sin comentario</em>' ?>
                                    </div>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($valoracion['fecha_valoracion'])) ?></td>
                                <td class="action-buttons">
                                    <button class="btn btn-sm btn-info"
                                        onclick='editarValoracion(<?= json_encode($valoracion) ?>)'>
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary"
                                        onclick='verComentario(<?= json_encode($valoracion) ?>)'>
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <form method="POST" style="display: inline;"
                                        onsubmit="return confirm('¿Eliminar esta valoración?')">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="id_usuario" value="<?= $valoracion['id_usuario'] ?>">
                                        <input type="hidden" name="id_producto"
                                            value="<?= $valoracion['id_producto'] ?>">
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

    <!-- Modal Crear Valoración -->
    <div class="modal fade" id="modalCrearValoracion" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-star"></i> Crear Nueva Valoración</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="accion" value="crear">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Usuario *</label>
                                <select name="id_usuario" class="form-select" required>
                                    <option value="">Seleccionar usuario...</option>
                                    <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?= $usuario['id'] ?>">
                                        <?= htmlspecialchars($usuario['username']) ?> -
                                        <?= htmlspecialchars($usuario['nombre']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Producto *</label>
                                <select name="id_producto" class="form-select" required>
                                    <option value="">Seleccionar producto...</option>
                                    <?php foreach ($productos as $producto): ?>
                                    <option value="<?= $producto['id'] ?>">
                                        <?= htmlspecialchars($producto['titulo']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Puntuación *</label>
                            <div class="rating-input">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                <input type="radio" name="puntuacion" id="star<?= $i ?>" value="<?= $i ?>" required>
                                <label for="star<?= $i ?>"><i class="bi bi-star-fill"></i></label>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Comentario</label>
                            <textarea name="comentario" class="form-control" rows="4" maxlength="500"
                                placeholder="Escribe un comentario sobre el producto (opcional)"></textarea>
                            <small class="text-muted">Máximo 500 caracteres</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Crear Valoración</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Valoración -->
    <div class="modal fade" id="modalEditarValoracion" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Editar Valoración</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="accion" value="editar">
                        <input type="hidden" name="id_usuario" id="edit_id_usuario">
                        <input type="hidden" name="id_producto" id="edit_id_producto">

                        <div class="alert alert-info">
                            <strong>Usuario:</strong> <span id="edit_usuario_nombre"></span><br>
                            <strong>Producto:</strong> <span id="edit_producto_nombre"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Puntuación *</label>
                            <div class="rating-input">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                <input type="radio" name="puntuacion" id="edit_star<?= $i ?>" value="<?= $i ?>"
                                    required>
                                <label for="edit_star<?= $i ?>"><i class="bi bi-star-fill"></i></label>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Comentario</label>
                            <textarea name="comentario" id="edit_comentario" class="form-control" rows="4"
                                maxlength="500"></textarea>
                            <small class="text-muted">Máximo 500 caracteres</small>
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

    <!-- Modal Ver Comentario Completo -->
    <div class="modal fade" id="modalVerComentario" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-chat-square-text"></i> Comentario Completo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <strong>Usuario:</strong> <span id="ver_usuario"></span>
                    </div>
                    <div class="mb-3">
                        <strong>Producto:</strong> <span id="ver_producto"></span>
                    </div>
                    <div class="mb-3">
                        <strong>Puntuación:</strong> <span id="ver_puntuacion"></span>
                    </div>
                    <div class="mb-3">
                        <strong>Fecha:</strong> <span id="ver_fecha"></span>
                    </div>
                    <div>
                        <strong>Comentario:</strong>
                        <p id="ver_comentario" class="mt-2"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function editarValoracion(valoracion) {
        document.getElementById('edit_id_usuario').value = valoracion.id_usuario;
        document.getElementById('edit_id_producto').value = valoracion.id_producto;
        document.getElementById('edit_usuario_nombre').textContent = valoracion.username + ' - ' + valoracion.nombre;
        document.getElementById('edit_producto_nombre').textContent = valoracion.producto_titulo;
        document.getElementById('edit_comentario').value = valoracion.comentario || '';

        // Marcar la puntuación
        document.getElementById('edit_star' + valoracion.puntuacion).checked = true;

        const modal = new bootstrap.Modal(document.getElementById('modalEditarValoracion'));
        modal.show();
    }

    function verComentario(valoracion) {
        document.getElementById('ver_usuario').textContent = valoracion.username + ' - ' + valoracion.nombre;
        document.getElementById('ver_producto').textContent = valoracion.producto_titulo;

        let estrellas = '';
        for (let i = 1; i <= 5; i++) {
            estrellas += i <= valoracion.puntuacion ? '⭐' : '☆';
        }
        document.getElementById('ver_puntuacion').textContent = estrellas + ' (' + valoracion.puntuacion + '/5)';
        document.getElementById('ver_fecha').textContent = new Date(valoracion.fecha_valoracion).toLocaleString(
            'es-ES');
        document.getElementById('ver_comentario').textContent = valoracion.comentario || 'Sin comentario';

        const modal = new bootstrap.Modal(document.getElementById('modalVerComentario'));
        modal.show();
    }

    function filtrarTabla() {
        const filtroProducto = document.getElementById('filtroProducto').value;
        const filtroUsuario = document.getElementById('filtroUsuario').value;
        const filtroPuntuacion = document.getElementById('filtroPuntuacion').value;

        const filas = document.querySelectorAll('#tablaValoraciones tbody tr');

        filas.forEach(fila => {
            let mostrar = true;

            if (filtroProducto && fila.dataset.producto !== filtroProducto) {
                mostrar = false;
            }

            if (filtroUsuario && fila.dataset.usuario !== filtroUsuario) {
                mostrar = false;
            }

            if (filtroPuntuacion && fila.dataset.puntuacion !== filtroPuntuacion) {
                mostrar = false;
            }

            fila.style.display = mostrar ? '' : 'none';
        });
    }
    </script>
</body>

</html>