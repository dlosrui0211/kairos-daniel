<?php
session_start();
require_once __DIR__ . "/../controlador/ProductoController.php";

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
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <!-- Menú sencillo -->
    <nav class="admin-menu">
        <div class="menu-container">
            <a href="productos.php" class="menu-link active">Productos</a>
            <a href="usuarios.php" class="menu-link">Usuarios</a>
            <a href="valoraciones.php" class="menu-link">Valoraciones</a>
            <a href="../logout.php" class="menu-link active">Logout</a>

        </div>
    </nav>

    <div class="admin-panel">
        <div class="container">
            <div class="admin-header">
                <h1><i class="bi bi-box-seam"></i> Gestión de Productos</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearProducto">
                    <i class="bi bi-plus-circle"></i> Nuevo Producto
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
                                <th>Imagen</th>
                                <th>Título</th>
                                <th>Plataforma</th>
                                <th>Precio</th>
                                <th>Descuento</th>
                                <th>Stock</th>
                                <th>Modo</th>
                                <th>Fecha Lanzamiento</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto): ?>
                            <?php
                                $precioFinal = $controller->calcularPrecioFinal($producto['precio'], $producto['descuento']);
                                ?>
                            <tr>
                                <td><?= $producto['id'] ?></td>
                                <td>
                                    <img src="<?= htmlspecialchars($producto['cover']) ?>"
                                        alt="<?= htmlspecialchars($producto['titulo']) ?>" class="product-thumbnail">
                                </td>
                                <td><?= htmlspecialchars($producto['titulo']) ?></td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= htmlspecialchars($producto['plataforma_nombre'] ?? 'N/A') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($producto['descuento'] > 0): ?>
                                    <span
                                        class="text-decoration-line-through text-muted">€<?= number_format($producto['precio'], 2) ?></span><br>
                                    <span class="text-success fw-bold">€<?= number_format($precioFinal, 2) ?></span>
                                    <?php else: ?>
                                    €<?= number_format($producto['precio'], 2) ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($producto['descuento'] > 0): ?>
                                    <span class="badge bg-danger"><?= $producto['descuento'] ?>%</span>
                                    <?php else: ?>
                                    <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-<?= $producto['stock'] > 10 ? 'success' : ($producto['stock'] > 0 ? 'warning' : 'danger') ?>">
                                        <?= $producto['stock'] ?> uds
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($producto['modo_nombre'] ?? 'N/A') ?></td>
                                <td><?= $producto['fecha_lanzamiento'] ? date('d/m/Y', strtotime($producto['fecha_lanzamiento'])) : 'N/A' ?>
                                </td>
                                <td class="action-buttons">
                                    <button class="btn btn-sm btn-info"
                                        onclick="editarProducto(<?= htmlspecialchars(json_encode($producto)) ?>)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form method="POST" style="display: inline;"
                                        onsubmit="return confirm('¿Eliminar este producto?')">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="id" value="<?= $producto['id'] ?>">
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

    <!-- Modal Crear Producto -->
    <div class="modal fade" id="modalCrearProducto" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-box-seam"></i> Crear Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="accion" value="crear">

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Título *</label>
                                <input type="text" name="titulo" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Fecha Lanzamiento</label>
                                <input type="date" name="fecha_lanzamiento" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Precio (€) *</label>
                                <input type="number" name="precio" class="form-control" step="0.01" min="0" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Descuento (%)</label>
                                <input type="number" name="descuento" class="form-control" min="0" max="100" value="0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Stock *</label>
                                <input type="number" name="stock" class="form-control" min="0" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Plataforma *</label>
                                <select name="platform_id" class="form-select" required>
                                    <option value="">Seleccionar...</option>
                                    <?php foreach ($plataformas as $plat): ?>
                                    <option value="<?= $plat['id'] ?>"><?= htmlspecialchars($plat['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Modo de Juego *</label>
                                <select name="modo" class="form-select" required>
                                    <option value="">Seleccionar...</option>
                                    <?php foreach ($modos as $modo): ?>
                                    <option value="<?= $modo['id'] ?>"><?= htmlspecialchars($modo['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Imagen de Portada</label>
                                <input type="file" name="cover" class="form-control" accept="image/*">
                                <small class="text-muted">Si no se sube imagen, se usará placeholder.png</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Géneros *</label>
                            <div class="generos-checkbox">
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
                            <label class="form-label">Descripción *</label>
                            <textarea name="descripcion" class="form-control" rows="4" required></textarea>
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
    <div class="modal fade" id="modalEditarProducto" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="accion" value="editar">
                        <input type="hidden" name="id" id="edit_id">

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Título *</label>
                                <input type="text" name="titulo" id="edit_titulo" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Fecha Lanzamiento</label>
                                <input type="date" name="fecha_lanzamiento" id="edit_fecha_lanzamiento"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Precio (€) *</label>
                                <input type="number" name="precio" id="edit_precio" class="form-control" step="0.01"
                                    min="0" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Descuento (%)</label>
                                <input type="number" name="descuento" id="edit_descuento" class="form-control" min="0"
                                    max="100">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Stock *</label>
                                <input type="number" name="stock" id="edit_stock" class="form-control" min="0" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Plataforma *</label>
                                <select name="platform_id" id="edit_platform_id" class="form-select" required>
                                    <?php foreach ($plataformas as $plat): ?>
                                    <option value="<?= $plat['id'] ?>"><?= htmlspecialchars($plat['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Modo de Juego *</label>
                                <select name="modo" id="edit_modo" class="form-select" required>
                                    <?php foreach ($modos as $modo): ?>
                                    <option value="<?= $modo['id'] ?>"><?= htmlspecialchars($modo['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nueva Imagen (dejar vacío para mantener actual)</label>
                                <input type="file" name="cover" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Géneros *</label>
                            <div class="generos-checkbox" id="edit_generos">
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
                            <label class="form-label">Descripción *</label>
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

    <?php include 'includes/footer.php'; ?>

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