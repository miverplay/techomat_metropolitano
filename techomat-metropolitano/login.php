<?php
include("config/conexion.php");
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, nombre, password, rol FROM usuarios WHERE email = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        if ($usuario = mysqli_fetch_assoc($resultado)) {
            if (password_verify($password, $usuario['password'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['rol'] = $usuario['rol'];

                if ($usuario['rol'] == 'admin') {
                    header("Location: admin.php");
                } else {
                    header("Location: vendedor.php");
                }
                exit();
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "El correo no está registrado.";
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
    <title>Login - Techomat Metropolitano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            /* Imagen de fondo profesional (tecnología/construcción) */
            background: url('https://images.unsplash.com/photo-1581094794329-c8112a433a04?q=80&w=2000') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95); /* Fondo blanco traslúcido */
            backdrop-filter: blur(10px); /* Efecto cristal */
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }
        .btn-custom {
            background: #212529;
            color: white;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background: #343a40;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="login-card shadow-lg">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-dark">Techomat</h3>
        <p class="text-muted">Acceso al Sistema Administrativo</p>
    </div>

    <?php if(!empty($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
    
    <form action="login.php" method="POST">
        <div class="mb-3">
            <label class="form-label text-secondary">Correo Electrónico</label>
            <input type="email" name="email" class="form-control form-control-lg" placeholder="usuario@techomat.com" required>
        </div>
        <div class="mb-3">
            <label class="form-label text-secondary">Contraseña</label>
            <input type="password" name="password" class="form-control form-control-lg" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn btn-custom btn-lg w-100 mt-3">Ingresar</button>
        <p class="text-center mt-4 text-muted small">
            ¿No tienes acceso? <a href="registro.php" class="text-decoration-none">Regístrate aquí</a>
        </p>
    </form>
</div>

<style>
        body {
            /* Usamos un color de fondo sólido como respaldo */
            background-color: #2c3e50; 
            /* Forzamos la carga de la imagen con una URL directa y simple */
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
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            width: 90%;
            max-width: 400px;
            padding: 2.5rem;
        }
    </style>

</body>
</html>