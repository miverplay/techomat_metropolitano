<?php
session_start();

// Control estricto de acceso: Si no hay sesión o el rol no es 'admin', se le deniega la entrada
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Techomat Metropolitano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Techomat Metropolitano - Panel Admin</span>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?> (Admin)</span>
                <a href="logout.php" class="btn btn-danger btn-sm">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        
        <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'guardado') { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ¡Producto agregado exitosamente al inventario!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>

        <div class="row text-center mt-4">
            
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title mt-2">Gestionar Inventario</h5>
                            <p class="card-text text-muted mt-3">Visualiza la lista completa de productos disponibles, actualiza sus características o elimínalos del sistema.</p>
                        </div>
                        <a href="crud/listar_productos.php" class="btn btn-primary w-100 mt-4">Ver Todos los Productos</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Agregar Nuevo Producto</h5>
                    </div>
                    <div class="card-body text-start">
                        <form action="crud/agregar_producto.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-2">
                                <label class="form-label small">Nombre del Producto</label>
                                <input type="text" name="nombre" class="form-control form-control-sm" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small">Categoría</label>
                                <input type="text" name="categoria" class="form-control form-control-sm" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label small">Precio ($)</label>
                                    <input type="number" step="0.01" name="precio" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label small">Stock / Cantidad</label>
                                    <input type="number" name="stock" class="form-control form-control-sm" value="0" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Descripción</label>
                                <textarea name="descripcion" class="form-control form-control-sm" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Imagen del Producto</label>
                                <input type="file" name="imagen" class="form-control form-control-sm" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm w-100">Guardar Producto</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>