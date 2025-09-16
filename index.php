<?php
session_start();
if (isset($_SESSION['usuario_nombre'])) {
    header("Location: indexx.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-box">
        <img src="img/logo.jpg" class="avatar" alt="Logo">
        <h1>Iniciar Sesión</h1>
        <form action="Login/auth.php" method="POST">
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" placeholder="Ingrese su usuario" required>

            <label for="password">Contraseña</label>
            <input type="password" name="password" placeholder="Ingrese su contraseña" required>

            <button type="submit">Entrar</button>
        </form>
    </div>
    <script>
        // Mostrar error si existe en la URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('error')) {
            alert("Usuario o contraseña incorrectos");
        }
    </script>
</body>
</html>
