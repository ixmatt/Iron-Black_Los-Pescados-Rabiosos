<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    die("Acceso denegado");
}

if (isset($_POST['nuevo_stock'])) {
    $nuevo_stock = intval($_POST['nuevo_stock']);

    if (isset($_POST['id_producto'])) {
        $id = intval($_POST['id_producto']);
        $stmt = $conexion->prepare("UPDATE productos SET stock = ? WHERE id = ?");
        $stmt->bind_param("ii", $nuevo_stock, $id);
    } elseif (isset($_POST['id_kit'])) {
        $id = intval($_POST['id_kit']);
        $stmt = $conexion->prepare("UPDATE kits SET stock = ? WHERE id = ?");
        $stmt->bind_param("ii", $nuevo_stock, $id);
    } else {
        die("Datos inválidos");
    }

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error al actualizar el stock.";
    }
}
?>
