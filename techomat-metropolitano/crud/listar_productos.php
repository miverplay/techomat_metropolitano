<?php

include("../config/conexion.php");

// Consultamos todos los productos de la base de datos
$sql = "SELECT * FROM productos";
$resultado = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-content-center mb-4">
        <h2>Lista de Productos</h2>
        <a href="../admin.php" class="btn btn-secondary">Volver al Panel</a>
    </div>

    <table class="table table-bordered table-striped">

        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            <?php while($fila = mysqli_fetch_assoc($resultado)) { ?>

            <tr>
                <td><?php echo $fila['id']; ?></td>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $fila['categoria']; ?></td>
                <td>$<?php echo number_format($fila['precio'], 2); ?>
                </td>
                <td><?php echo $fila['descripcion']; ?></td>
                
                <td>
                    <a href="editar_producto.php?id=<?php echo $fila['id']; ?>" class="btn btn-warning btn-sm">
                        Editar
                    </a>
                    
                    <a href="eliminar_producto.php?id=<?php echo $fila['id']; ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('¿Seguro que deseas eliminar este producto?');">
                        Eliminar
                    </a>
                </td>
            </tr>

            <?php } ?>

            <?php if(mysqli_num_rows($resultado) == 0) { ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">No hay productos registrados aún.</td>
                </tr>
            <?php } ?>

        </tbody>

    </table>

</div>

</body>
</html>