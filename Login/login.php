<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: index.php");
    exit();
}

// Function to display flash messages
function display_flash_message() {
    if (isset($_SESSION['message'])) {
        echo '<div class="flash-message">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }
}
?>