<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (isset($_POST['id_producto'])) {
        $id = (int)$_POST['id_producto'];

        $stmt = $conexion->prepare("CALL insertarCompraProducto(?, ?)");
        $stmt->bind_param("ii", $id, $id_usuario);
        $stmt->execute();
        $stmt->close();

        $stmt = $conexion->prepare("CALL descontarStockProducto(?)");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

  
    if (isset($_POST['id_kit'])) {
        $id_kit = (int)$_POST['id_kit'];

        $stmt = $conexion->prepare("CALL insertarCompraKit(?, ?)");
        $stmt->bind_param("ii", $id_kit, $id_usuario);
        $stmt->execute();
        $stmt->close();

        $res = $conexion->query("SELECT id_producto, cantidad FROM kit_productos WHERE id_kit = $id_kit");
        while ($prod = $res->fetch_assoc()) {
            $id_prod = $prod['id_producto'];
            $cant = $prod['cantidad'];
            $stmt = $conexion->prepare("UPDATE productos SET stock = stock - ? WHERE id = ? AND stock >= ?");
            $stmt->bind_param("iii", $cant, $id_prod, $cant);
            $stmt->execute();
            $stmt->close();
        }


        $stmt = $conexion->prepare("CALL actualizarStockKit(?)");
        $stmt->bind_param("i", $id_kit);
        $stmt->execute();
        $stmt->close();
    }

    header('Location: index.php');
    exit;
}
?>
