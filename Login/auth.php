<?php
session_start();

// Simple authentication for demo purposes
// In a real application, you should use a database and secure password handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    
    // For testing purposes only - replace with database authentication
    if ($usuario === "admin" && $password === "admin123") {
        $_SESSION['usuario_nombre'] = $usuario;
        $_SESSION['message'] = "Bienvenido al sistema, $usuario!";
        header("Location: ../indexx.php");
        exit();
    } else {
        header("Location: ../index.php?error=1");
        exit();
    }
} else {
    // If not a POST request, redirect to login page
    header("Location: ../index.php");
    exit();
}
?>