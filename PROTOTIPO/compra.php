<?php
include 'conexion.php';

if (!empty($_POST['productos'])) {
    foreach ($_POST['productos'] as $id) {
        $conexion->query("INSERT INTO compra (id_prod) VALUES ($id)");
        $conexion->query("UPDATE productos SET stock = stock - 1 WHERE id = $id AND stock > 0");
    }
}

// Comprar kits
if (!empty($_POST['kits'])) {
    foreach ($_POST['kits'] as $id_kit) {
        // Insertar compra
        $conexion->query("INSERT INTO compra (id_kit) VALUES ($id_kit)");

        // Obtener productos del kit
        $res = $conexion->query("SELECT id_producto FROM kit_productos WHERE id_kit = $id_kit");
        while ($prod = $res->fetch_assoc()) {
            $id_prod = $prod['id_producto'];
            $conexion->query("UPDATE productos SET stock = stock - 1 WHERE id = $id_prod AND stock > 0");
        }

        // Recalcular stock del kit
        $res2 = $conexion->query("
          SELECT MIN(p.stock) AS stock_kit
          FROM productos p
          INNER JOIN kit_productos kp ON kp.id_producto = p.id
          WHERE kp.id_kit = $id_kit
        ");
        $nuevo_stock = $res2->fetch_assoc()['stock_kit'] ?? 0;
        $conexion->query("UPDATE kits SET stock = $nuevo_stock WHERE id = $id_kit");
    }
}

echo "Compra realizada.<br><a href='index.php'>Volver al inicio</a>";
?>
