<?php
include("config/conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rol = $_POST['rol']; 

    $password_encriptada = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssss", $nombre, $email, $password_encriptada, $rol);
        
        if (mysqli_stmt_execute($stmt)) {
            $mensaje = "<div class='alert alert-success mt-3'>Usuario registrado con éxito. Ya puedes <a href='login.php' class='alert-link'>iniciar sesión</a>.</div>";
        } else {
            $mensaje = "<div class='alert alert-danger mt-3'>Error: El correo ya está registrado.</div>";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Techomat Metropolitano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #2c3e50; 
            background-image: url('https://images.unsplash.com/photo-1581094794329-c8112a433a04?auto=format&fit=crop&w=1920&q=80');
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            width: 90%;
            max-width: 450px;
            padding: 2.5rem;
        }
        .btn-custom {
            background: #0d6efd;
            color: white;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background: #0b5ed7;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="register-card shadow-lg">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-dark">Crear Cuenta</h3>
        <p class="text-muted">Únete a Techomat Metropolitano</p>
    </div>

    <form action="registro.php" method="POST">
        <div class="mb-3">
            <label class="form-label text-secondary">Nombre Completo</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label text-secondary">Correo Electrónico</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label text-secondary">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label text-secondary">Rol del Sistema</label>
            <select name="rol" class="form-select">
                <option value="vendedor">Vendedor</option>
                <option value="admin">Administrador</option>
            </select>
        </div>
        <button type="submit" class="btn btn-custom btn-lg w-100 mt-2">Registrarse</button>
        
        <?php echo $mensaje; ?>
        
        <p class="text-center mt-4 text-muted small">
            ¿Ya tienes cuenta? <a href="login.php" class="text-decoration-none">Inicia Sesión</a>
        </p>
    </form>
</div>

</body>
</html>