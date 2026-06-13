<?php
include("../config/conexion.php");

// ==========================================
// PASO 1: PROCESAR LA ACTUALIZACIÓN (POST)
// ==========================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $stock = intval($_POST['stock']);

    // Consulta preparada para actualizar los datos
    $sql_update = "UPDATE productos SET nombre = ?, categoria = ?, precio = ?, descripcion = ?, stock = ? WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql_update)) {
        mysqli_stmt_bind_param($stmt, "ssdsii", $nombre, $categoria, $precio, $descripcion, $stock, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            // Si se actualiza con éxito, redirige a la lista
            header("Location: listar_productos.php?mensaje=actualizado");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error al actualizar: " . mysqli_stmt_error($stmt) . "</div>";
        }
        mysqli_stmt_close($stmt);
    }
}

// ==========================================
// PASO 2: OBTENER LOS DATOS ACTUALES (GET)
// ==========================================
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $sql_select = "SELECT * FROM productos WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql_select)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        // Si el producto existe, guardamos sus datos en la variable $producto
        if ($producto = mysqli_fetch_assoc($resultado)) {
            // Continuamos hacia el HTML con los datos cargados
        } else {
            echo "Producto no encontrado.";
            exit();
        }
        mysqli_stmt_close($stmt);
    }
} else {
    header("Location: listar_productos.php");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Editar Producto</h4>
                </div>
                <div class="card-body">
                    
                    <form action="editar_producto.php" method="POST">
                        
                        <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-label form-control" id="nombre" name="nombre" 
                                   value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <input type="text" class="form-control" id="categoria" name="categoria" 
                                   value="<?php echo htmlspecialchars($producto['categoria']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio ($)</label>
                            <input type="number" step="0.01" class="form-control" id="precio" name="precio" 
                                   value="<?php echo $producto['precio']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock / Cantidad</label>
                            <input type="number" class="form-control" id="stock" name="stock" 
                                   value="<?php echo $producto['stock']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="listar_productos.php" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>