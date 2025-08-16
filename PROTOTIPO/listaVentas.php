<?php
include 'conexion.php';

echo "<h2>Ventas realizadas</h2>";

$res = $conexion->query("
  SELECT c.id, p.nombre AS producto, k.nombre AS kit
  FROM compra c
  LEFT JOIN productos p ON c.id_prod = p.id
  LEFT JOIN kits k ON c.id_kit = k.id
");

echo "<table border='1'>
<tr><th>ID Compra</th><th>Producto</th><th>Kit</th></tr>";

while ($row = $res->fetch_assoc()) {
    echo "<tr>
      <td>{$row['id']}</td>
      <td>{$row['producto']}</td>
      <td>{$row['kit']}</td>
    </tr>";
}

echo "</table><br><a href='index.php'>Volver</a>";
?>

