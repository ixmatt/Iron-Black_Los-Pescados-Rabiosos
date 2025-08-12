<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conexion = new mysqli("localhost", "root", "", "ironblack");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
