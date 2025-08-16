<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    die("Acceso denegado");
}

if (isset($_POST['id_producto']) || isset($_POST['id_kit'])) {
    $accion = $_POST['accion'] ?? '';
    $nuevo_estado = ($accion === 'ocultar') ? 1 : 0;

    if (isset($_POST['id_producto'])) {
        $id = intval($_POST['id_producto']);
        $stmt = $conexion->prepare("UPDATE productos SET oculto = ? WHERE id = ?");
        $stmt->bind_param("ii", $nuevo_estado, $id);
    } elseif (isset($_POST['id_kit'])) {
        $id = intval($_POST['id_kit']);
        $stmt = $conexion->prepare("UPDATE kits SET oculto = ? WHERE id = ?");
        $stmt->bind_param("ii", $nuevo_estado, $id);
    }

    $stmt->execute();
    header("Location: index.php");
    exit;
}
?>
