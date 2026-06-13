<?php

include("../config/conexion.php");

// Verificamos si el ID fue enviado a través de la URL (método GET)
if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    // Convertimos a entero para asegurar que no nos pasen código malicioso por la URL
    $id = intval($_GET['id']);

    // Preparamos la consulta SQL de eliminación con un marcador de posición
    $sql = "DELETE FROM productos WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        
        // Vinculamos el parámetro (i = entero)
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        // Ejecutamos la eliminación
        if (mysqli_stmt_execute($stmt)) {
            // Si se elimina con éxito, redirige a la lista con un mensaje de éxito
            header("Location: listar_productos.php?mensaje=eliminado");
            exit();
        } else {
            echo "Error al intentar eliminar el producto: " . mysqli_stmt_error($stmt);
        }
        
        // Cerramos la sentencia preparada
        mysqli_stmt_close($stmt);
    } else {
        echo "Error al preparar la consulta de eliminación: " . mysqli_error($conn);
    }
} else {
    // Si entran al archivo sin un ID válido, los mandamos de vuelta a la lista
    header("Location: listar_productos.php");
    exit();
}

// Cerramos la conexión
mysqli_close($conn);

?>