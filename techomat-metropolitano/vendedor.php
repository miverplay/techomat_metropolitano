<?php
session_start();

// Control de acceso: Si no hay sesión o el rol no es 'vendedor', lo mandamos al login
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'vendedor') {
    header("Location: login.php");
    exit();
}

// Incluimos la conexión a la base de datos para traer los productos
include("config/conexion.php");

// Consultamos todos los productos disponibles
$sql = "SELECT * FROM productos";
$resultado = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Vendedor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand">
        Techomat Metropolitano - Vendedor: <?php echo htmlspecialchars($_SESSION['nombre']); ?>
    </span>
    <div>
        <a href="logout.php" class="btn btn-danger">
            Cerrar Sesión
        </a>
    </div>
</nav>

<div class="container mt-5">

    <h2 class="mb-4">
        Panel de Consulta de Productos
    </h2>

    <div class="alert alert-info">
        Bienvenido al módulo de vendedor. Desde esta sección podrás consultar la información de los productos disponibles para brindar atención a los clientes.
    </div>

    <div class="row">

        <?php 
        // Verificamos si hay productos registrados
        if(mysqli_num_rows($resultado) > 0) {
            // Recorremos cada producto y generamos su tarjeta HTML
            while($producto = mysqli_fetch_assoc($resultado)) { 
        ?>
        
        <div class="col-md-4 mb-4">
    <div class="card shadow h-100">
        
        <?php 
        // Lógica de la imagen
        $ruta_imagen = !empty($producto['imagen']) ? $producto['imagen'] : 'img/default.jpg'; 
        ?>
        
        <img
            src="<?php echo htmlspecialchars($ruta_imagen); ?>"
            class="card-img-top product-img"
            alt="<?php echo htmlspecialchars($producto['nombre']); ?>"
            style="object-fit: cover; height: 200px; background-color: #f8f9fa;">

        <div class="card-body d-flex flex-column">

            <h5 class="card-title text-primary">
                <?php echo htmlspecialchars($producto['nombre']); ?>
            </h5>

            <p class="card-text text-muted" style="flex-grow: 1;">
                <?php echo htmlspecialchars($producto['descripcion']); ?>
            </p>

            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item px-0">
                    <strong>Categoría:</strong> <?php echo htmlspecialchars($producto['categoria']); ?>
                </li>
                <li class="list-group-item px-0">
                    <strong>Precio:</strong> $<?php echo number_format($producto['precio'], 2); ?>
                </li>
                <li class="list-group-item px-0">
                    <strong>Disponibilidad:</strong> 
                    <?php if($producto['stock'] > 0) { ?>
                        <span class="badge bg-success"><?php echo $producto['stock']; ?> en stock</span>
                    <?php } else { ?>
                        <span class="badge bg-danger">Agotado</span>
                    <?php } ?>
                </li>
            </ul>

            <button class="btn btn-outline-primary w-100 mt-auto">
                Consultar Información
            </button>

        </div>
    </div>
</div>

        <?php 
            } // Fin del while
        } else { 
        ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Aún no hay productos registrados en el sistema.
                </div>
            </div>
        <?php } ?>

    </div>
</div>

<script src="js/vendedor.js"></script>

</body>
</html>
<?php 
// Cerramos la conexión al final del archivo
mysqli_close($conn); 
?>