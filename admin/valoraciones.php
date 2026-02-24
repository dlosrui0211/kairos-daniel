<?php
session_start();
require_once __DIR__ . "/../controller/ValoracionController.php";
require_once __DIR__ . "/../controller/ProductoController.php";
require_once __DIR__ . "/../controller/UsuarioController.php";

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
            <a href="usuarios.php" class="menu-link" aria-label="Administrar usuarios">Usuarios</a>
            <a href="valoraciones.php" class="menu-link active" aria-current="page" aria-label="Administrar valoraciones">Valoraciones</a>
            <a href="../logout.php" class="menu-link" aria-label="Cerrar sesión">Logout</a>
        </div>
    </nav>

    <main id="main-content" tabindex="-1">
    <div class="admin-panel">
        <div class="container">
            <header class="admin-header">
                <h1><i class="bi bi-star-fill" aria-hidden="true"></i> Gestión de Valoraciones</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearValoracion"
                    aria-label="Abrir formulario para crear nueva valoración">
                    <i class="bi bi-plus-circle" aria-hidden="true"></i> Nueva Valoración
                </button>
            </header>

            <?php if ($mensaje): ?>
            <div class="alert alert-<?= $tipoMensaje ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($mensaje) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar alerta"></button>
            </div>
            <?php endif; ?>

            <div class="admin-content">
                <!-- Filtros -->
                <div class="filters-section mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="filtroProducto" class="form-label">Filtrar por Producto</label>
                            <select class="form-select" id="filtroProducto" onchange="filtrarTabla()">
                                <option value="">Todos los productos</option>
                                <?php foreach ($productos as $prod): ?>
                                <option value="<?= $prod['id'] ?>"><?= htmlspecialchars($prod['titulo']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="filtroUsuario" class="form-label">Filtrar por Usuario</label>
                            <select class="form-select" id="filtroUsuario" onchange="filtrarTabla()">
                                <option value="">Todos los usuarios</option>
                                <?php foreach ($usuarios as $usr): ?>
                                <option value="<?= $usr['id'] ?>"><?= htmlspecialchars($usr['username']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="filtroPuntuacion" class="form-label">Filtrar por Puntuación</label>
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

                <div class="admin-cards-grid admin-cards-grid--wide" id="tarjetasValoraciones">
                    <?php foreach ($valoraciones as $valoracion): ?>
                    <article class="admin-card admin-card--valoracion"
                        data-producto="<?= $valoracion['id_producto'] ?>"
                        data-usuario="<?= $valoracion['id_usuario'] ?>"
                        data-puntuacion="<?= $valoracion['puntuacion'] ?>">
                        <div class="admin-card-body">
                            <div class="admin-card-valoracion-header">
                                <div class="admin-card-avatar admin-card-avatar--sm">
                                    <?= strtoupper(substr($valoracion['username'], 0, 1)) ?>
                                </div>
                                <div>
                                    <h2 class="admin-card-title"><?= htmlspecialchars($valoracion['username']) ?></h2>
                                    <p class="admin-card-subtitle"><?= htmlspecialchars($valoracion['nombre']) ?></p>
                                </div>
                            </div>
                            <div class="admin-card-valoracion-producto">
                                <i class="bi bi-controller" aria-hidden="true"></i>
                                <span><?= htmlspecialchars($valoracion['producto_titulo']) ?></span>
                                <small class="text-muted"><?= htmlspecialchars($valoracion['plataforma_nombre'] ?? '') ?></small>
                            </div>
                            <div class="admin-card-valoracion-stars" role="img" aria-label="Puntuación: <?= $valoracion['puntuacion'] ?> de 5 estrellas">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="bi bi-star<?= $i <= $valoracion['puntuacion'] ? '-fill' : '' ?> text-warning" aria-hidden="true"></i>
                                <?php endfor; ?>
                                <span>(<?= $valoracion['puntuacion'] ?>/5)</span>
                            </div>
                            <?php if ($valoracion['comentario']): ?>
                            <p class="admin-card-valoracion-comment">
                                "<?= htmlspecialchars(substr($valoracion['comentario'], 0, 120)) ?><?= strlen($valoracion['comentario']) > 120 ? '...' : '' ?>"
                            </p>
                            <?php else: ?>
                            <p class="admin-card-valoracion-comment text-muted"><em>Sin comentario</em></p>
                            <?php endif; ?>
                            <small class="admin-card-valoracion-date">
                                <i class="bi bi-clock" aria-hidden="true"></i>
                                <?= date('d/m/Y H:i', strtotime($valoracion['fecha_valoracion'])) ?>
                            </small>
                        </div>
                        <div class="admin-card-actions">
                            <button class="btn btn-sm btn-info"
                                onclick='editarValoracion(<?= htmlspecialchars(json_encode($valoracion), ENT_QUOTES, "UTF-8") ?>)'
                                aria-label="Editar valoración de <?= htmlspecialchars($valoracion['username']) ?> sobre <?= htmlspecialchars($valoracion['producto_titulo']) ?>">
                                <i class="bi bi-pencil" aria-hidden="true"></i> Editar
                            </button>
                            <button class="btn btn-sm btn-primary"
                                onclick='verComentario(<?= htmlspecialchars(json_encode($valoracion), ENT_QUOTES, "UTF-8") ?>)'
                                aria-label="Ver comentario completo de <?= htmlspecialchars($valoracion['username']) ?>">
                                <i class="bi bi-eye" aria-hidden="true"></i> Ver
                            </button>
                            <form method="POST" style="display: inline;"
                                onsubmit="return confirm('¿Eliminar esta valoración?')"
                                aria-label="Eliminar valoración">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id_usuario" value="<?= $valoracion['id_usuario'] ?>">
                                <input type="hidden" name="id_producto" value="<?= $valoracion['id_producto'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger"
                                    aria-label="Eliminar valoración de <?= htmlspecialchars($valoracion['username']) ?>">
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

    <!-- Modal Crear Valoración -->
    <div class="modal fade" id="modalCrearValoracion" tabindex="-1" aria-labelledby="modalCrearValoracionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="modalCrearValoracionLabel"><i class="bi bi-star" aria-hidden="true"></i> Crear Nueva Valoración</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="accion" value="crear">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="crear_id_usuario" class="form-label">Usuario *</label>
                                <select id="crear_id_usuario" name="id_usuario" class="form-select" required>
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
                                <label for="crear_id_producto" class="form-label">Producto *</label>
                                <select id="crear_id_producto" name="id_producto" class="form-select" required>
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
                            <div class="rating-input" role="group" aria-label="Seleccione la puntuación de 1 a 5 estrellas">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                <input type="radio" name="puntuacion" id="star<?= $i ?>" value="<?= $i ?>" required>
                                <label for="star<?= $i ?>">
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <span class="visually-hidden">Puntuación: <?= $i ?> estrellas</span>
                                </label>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="crear_comentario" class="form-label">Comentario</label>
                            <textarea id="crear_comentario" name="comentario" class="form-control" rows="4" maxlength="500"
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
    <div class="modal fade" id="modalEditarValoracion" tabindex="-1" aria-labelledby="modalEditarValoracionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="modalEditarValoracionLabel"><i class="bi bi-pencil-square" aria-hidden="true"></i> Editar Valoración</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar modal"></button>
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
                            <div class="rating-input" role="group" aria-label="Seleccione la puntuación de 1 a 5 estrellas">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                <input type="radio" name="puntuacion" id="edit_star<?= $i ?>" value="<?= $i ?>"
                                    required>
                                <label for="edit_star<?= $i ?>">
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <span class="visually-hidden">Puntuación: <?= $i ?> estrellas</span>
                                </label>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_comentario" class="form-label">Comentario</label>
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
    <div class="modal fade" id="modalVerComentario" tabindex="-1" aria-labelledby="modalVerComentarioLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="modalVerComentarioLabel"><i class="bi bi-chat-square-text" aria-hidden="true"></i> Comentario Completo</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar modal"></button>
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

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    </main>

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

        const tarjetas = document.querySelectorAll('#tarjetasValoraciones .admin-card--valoracion');

        tarjetas.forEach(tarjeta => {
            let mostrar = true;

            if (filtroProducto && tarjeta.dataset.producto !== filtroProducto) {
                mostrar = false;
            }

            if (filtroUsuario && tarjeta.dataset.usuario !== filtroUsuario) {
                mostrar = false;
            }

            if (filtroPuntuacion && tarjeta.dataset.puntuacion !== filtroPuntuacion) {
                mostrar = false;
            }

            tarjeta.style.display = mostrar ? '' : 'none';
        });
    }
    </script>
</body>

</html>