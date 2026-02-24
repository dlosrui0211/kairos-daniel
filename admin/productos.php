<?php
session_start();
require_once __DIR__ . "/../controller/ProductoController.php";

$controller = new ProductoController();

// Verificar que sea administrador y trabajador
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)) {
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
            $resultado = $controller->crearProducto($_POST, $_FILES);
            $mensaje = $resultado['message'];
            $tipoMensaje = $resultado['success'] ? 'success' : 'danger';
            break;
            
        case 'editar':
            $resultado = $controller->actualizarProducto($_POST, $_FILES);
            $mensaje = $resultado['message'];
            $tipoMensaje = $resultado['success'] ? 'success' : 'danger';
            break;
            
        case 'eliminar':
            $resultado = $controller->eliminarProducto($_POST['id']);
            $mensaje = $resultado['message'];
            $tipoMensaje = $resultado['success'] ? 'success' : 'danger';
            break;
    }
}

// Obtener datos necesarios
$productos = $controller->obtenerTodos();
$plataformas = $controller->obtenerPlataformas();
$generos = $controller->obtenerTodosGeneros();
$modos = $controller->obtenerTodosModos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Productos - Kairos</title>
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
            <a href="productos.php" class="menu-link active" aria-current="page" aria-label="Administrar productos">Productos</a>
            <a href="usuarios.php" class="menu-link" aria-label="Administrar usuarios">Usuarios</a>
            <a href="valoraciones.php" class="menu-link" aria-label="Administrar valoraciones">Valoraciones</a>
            <a href="../logout.php" class="menu-link" aria-label="Cerrar sesión">Logout</a>
        </div>
    </nav>

    <div class="admin-panel">
        <div class="container">
            <header class="admin-header">
                <h1><i class="bi bi-box-seam" aria-hidden="true"></i> Gestión de Productos</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearProducto"
                    aria-label="Abrir formulario para crear nuevo producto">
                    <i class="bi bi-plus-circle" aria-hidden="true"></i> Nuevo Producto
                </button>
            </header>

            <?php if ($mensaje): ?>
            <div class="alert alert-<?= $tipoMensaje ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($mensaje) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar alerta"></button>
            </div>
            <?php endif; ?>

            <div class="admin-content">
                <div class="admin-cards-grid">
                    <?php foreach ($productos as $producto): ?>
                    <?php $precioFinal = $controller->calcularPrecioFinal($producto['precio'], $producto['descuento']); ?>
                    <article class="admin-card">
                        <div class="admin-card-img">
                            <img src="<?= htmlspecialchars($producto['cover']) ?>"
                                alt="<?= htmlspecialchars($producto['titulo']) ?>"
                                onerror="this.src='https://placehold.co/200x260/1c0538/ffffff?text=<?= urlencode($producto['titulo']) ?>'">
                            <?php if ($producto['descuento'] > 0): ?>
                            <span class="admin-card-badge badge-discount">-<?= $producto['descuento'] ?>%</span>
                            <?php endif; ?>
                        </div>
                        <div class="admin-card-body">
                            <h2 class="admin-card-title"><?= htmlspecialchars($producto['titulo']) ?></h2>
                            <div class="admin-card-meta">
                                <span class="badge bg-secondary"><?= htmlspecialchars($producto['plataforma_nombre'] ?? 'N/A') ?></span>
                                <span class="badge bg-<?= $producto['stock'] > 10 ? 'success' : ($producto['stock'] > 0 ? 'warning' : 'danger') ?>">
                                    <?= $producto['stock'] ?> uds
                                </span>
                            </div>
                            <div class="admin-card-details">
                                <div class="admin-card-detail">
                                    <span class="detail-label">Precio</span>
                                    <?php if ($producto['descuento'] > 0): ?>
                                    <span class="detail-value">
                                        <span class="text-decoration-line-through text-muted"><?= number_format($producto['precio'], 2) ?>€</span>
                                        <span class="text-success fw-bold"><?= number_format($precioFinal, 2) ?>€</span>
                                    </span>
                                    <?php else: ?>
                                    <span class="detail-value"><?= number_format($producto['precio'], 2) ?>€</span>
                                    <?php endif; ?>
                                </div>
                                <div class="admin-card-detail">
                                    <span class="detail-label">Modo</span>
                                    <span class="detail-value"><?= htmlspecialchars($producto['modo_nombre'] ?? 'N/A') ?></span>
                                </div>
                                <div class="admin-card-detail">
                                    <span class="detail-label">Lanzamiento</span>
                                    <span class="detail-value"><?= $producto['fecha_lanzamiento'] ? date('d/m/Y', strtotime($producto['fecha_lanzamiento'])) : 'N/A' ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="admin-card-actions">
                            <button class="btn btn-sm btn-info"
                                onclick="editarProducto(<?= htmlspecialchars(json_encode($producto)) ?>)"
                                aria-label="Editar producto <?= htmlspecialchars($producto['titulo']) ?>">
                                <i class="bi bi-pencil" aria-hidden="true"></i> Editar
                            </button>
                            <form method="POST" style="display: inline;"
                                onsubmit="return confirm('¿Eliminar este producto?')">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger"
                                    aria-label="Eliminar producto <?= htmlspecialchars($producto['titulo']) ?>">
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

    <!-- Modal Crear Producto -->
    <div class="modal fade" id="modalCrearProducto" tabindex="-1" aria-labelledby="modalCrearProductoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="modalCrearProductoLabel"><i class="bi bi-box-seam" aria-hidden="true"></i> Crear Nuevo Producto</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="accion" value="crear">

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="crear_titulo" class="form-label">Título *</label>
                                <input type="text" id="crear_titulo" name="titulo" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="crear_fecha_lanzamiento" class="form-label">Fecha Lanzamiento</label>
                                <input type="date" id="crear_fecha_lanzamiento" name="fecha_lanzamiento" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="crear_precio" class="form-label">Precio (€) *</label>
                                <input type="number" id="crear_precio" name="precio" class="form-control" step="0.01" min="0" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="crear_descuento" class="form-label">Descuento (%)</label>
                                <input type="number" id="crear_descuento" name="descuento" class="form-control" min="0" max="100" value="0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="crear_stock" class="form-label">Stock *</label>
                                <input type="number" id="crear_stock" name="stock" class="form-control" min="0" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="crear_platform_id" class="form-label">Plataforma *</label>
                                <select id="crear_platform_id" name="platform_id" class="form-select" required>
                                    <option value="">Seleccionar...</option>
                                    <?php foreach ($plataformas as $plat): ?>
                                    <option value="<?= $plat['id'] ?>"><?= htmlspecialchars($plat['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="crear_modo" class="form-label">Modo de Juego *</label>
                                <select id="crear_modo" name="modo" class="form-select" required>
                                    <option value="">Seleccionar...</option>
                                    <?php foreach ($modos as $modo): ?>
                                    <option value="<?= $modo['id'] ?>"><?= htmlspecialchars($modo['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="crear_cover" class="form-label">Imagen de Portada</label>
                                <input type="file" id="crear_cover" name="cover" class="form-control" accept="image/*">
                                <small class="text-muted">Si no se sube imagen, se usará placeholder.png</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Géneros *</label>
                            <div class="generos-checkbox" role="group" aria-label="Seleccione los géneros del juego">
                                <?php foreach ($generos as $genero): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="generos[]"
                                        value="<?= $genero['id'] ?>" id="genero_<?= $genero['id'] ?>">
                                    <label class="form-check-label" for="genero_<?= $genero['id'] ?>">
                                        <?= htmlspecialchars($genero['nombre']) ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="crear_descripcion" class="form-label">Descripción *</label>
                            <textarea id="crear_descripcion" name="descripcion" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Crear Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Producto -->
    <div class="modal fade" id="modalEditarProducto" tabindex="-1" aria-labelledby="modalEditarProductoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="modalEditarProductoLabel"><i class="bi bi-pencil-square" aria-hidden="true"></i> Editar Producto</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="accion" value="editar">
                        <input type="hidden" name="id" id="edit_id">

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="edit_titulo" class="form-label">Título *</label>
                                <input type="text" name="titulo" id="edit_titulo" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_fecha_lanzamiento" class="form-label">Fecha Lanzamiento</label>
                                <input type="date" name="fecha_lanzamiento" id="edit_fecha_lanzamiento"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="edit_precio" class="form-label">Precio (€) *</label>
                                <input type="number" name="precio" id="edit_precio" class="form-control" step="0.01"
                                    min="0" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="edit_descuento" class="form-label">Descuento (%)</label>
                                <input type="number" name="descuento" id="edit_descuento" class="form-control" min="0"
                                    max="100">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="edit_stock" class="form-label">Stock *</label>
                                <input type="number" name="stock" id="edit_stock" class="form-control" min="0" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="edit_platform_id" class="form-label">Plataforma *</label>
                                <select name="platform_id" id="edit_platform_id" class="form-select" required>
                                    <?php foreach ($plataformas as $plat): ?>
                                    <option value="<?= $plat['id'] ?>"><?= htmlspecialchars($plat['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_modo" class="form-label">Modo de Juego *</label>
                                <select name="modo" id="edit_modo" class="form-select" required>
                                    <?php foreach ($modos as $modo): ?>
                                    <option value="<?= $modo['id'] ?>"><?= htmlspecialchars($modo['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_cover" class="form-label">Nueva Imagen (dejar vacío para mantener actual)</label>
                                <input type="file" id="edit_cover" name="cover" class="form-control" accept="image/*">
                                <small class="text-muted">Ningún archivo seleccionado</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Géneros *</label>
                            <div class="generos-checkbox" id="edit_generos" role="group" aria-label="Seleccione los géneros del juego">
                                <?php foreach ($generos as $genero): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="generos[]"
                                        value="<?= $genero['id'] ?>" id="edit_gen_<?= $genero['id'] ?>">
                                    <label class="form-check-label" for="edit_gen_<?= $genero['id'] ?>">
                                        <?= htmlspecialchars($genero['nombre']) ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_descripcion" class="form-label">Descripción *</label>
                            <textarea name="descripcion" id="edit_descripcion" class="form-control" rows="4"
                                required></textarea>
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

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function editarProducto(producto) {
        document.getElementById('edit_id').value = producto.id;
        document.getElementById('edit_titulo').value = producto.titulo;
        document.getElementById('edit_precio').value = producto.precio;
        document.getElementById('edit_descuento').value = producto.descuento;
        document.getElementById('edit_stock').value = producto.stock;
        document.getElementById('edit_platform_id').value = producto.platform_id;
        document.getElementById('edit_modo').value = producto.modo;
        document.getElementById('edit_descripcion').value = producto.descripcion;
        document.getElementById('edit_fecha_lanzamiento').value = producto.fecha_lanzamiento || '';

        // Cargar géneros del producto
        fetch(`api/obtener-generos-producto.php?id=${producto.id}`)
            .then(res => res.json())
            .then(generos => {
                const generosIds = generos.map(g => g.id);
                document.querySelectorAll('#edit_generos input[type="checkbox"]').forEach(checkbox => {
                    checkbox.checked = generosIds.includes(parseInt(checkbox.value));
                });
            });

        const modal = new bootstrap.Modal(document.getElementById('modalEditarProducto'));
        modal.show();
    }
    </script>
</body>

</html>