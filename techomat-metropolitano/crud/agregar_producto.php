<?php
include("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Captura de datos
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $stock = isset($_POST['stock']) ? $_POST['stock'] : 0;

// 1. Manejo del archivo de imagen
$ruta_final = "";

// Verificamos si existe la llave y si no hay errores previos
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
    
    if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $directorio_raiz = dirname(__DIR__);
        $carpeta_destino = $directorio_raiz . "/img/";
        
        if (!is_dir($carpeta_destino)) {
            mkdir($carpeta_destino, 0777, true);
        }

        $nombre_archivo = time() . "_" . basename($_FILES['imagen']['name']);
        $ruta_destino = $carpeta_destino . $nombre_archivo;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
            $ruta_final = "img/" . $nombre_archivo;
        } else {
            die("Error al mover el archivo. Verifica permisos en la carpeta /img.");
        }
    } else {
        die("Error en la subida: Código de error " . $_FILES['imagen']['error']);
    }
}

    // 2. Consulta SQL: Asegúrate de que esta estructura coincida con tu tabla
    $sql = "INSERT INTO productos (nombre, categoria, precio, descripcion, stock, imagen) VALUES (?, ?, ?, ?, ?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssdsis", $nombre, $categoria, $precio, $descripcion, $stock, $ruta_final);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../admin.php?mensaje=guardado");
            exit();
        } else {
            echo "Error al guardar en BD: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error en la preparación SQL: " . mysqli_error($conn);
    }
}
mysqli_close($conn);
?>