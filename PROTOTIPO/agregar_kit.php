
<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descrip = $_POST['descrip'];
    $precio = $_POST['precio'];
    $productos = $_POST['productos'];

    // Insertar kit sin stock aún
    $conexion->query("INSERT INTO kits (nombre, descrip, precio, stock) VALUES ('$nombre', '$descrip', $precio, 0)");
    $id_kit = $conexion->insert_id;

    // Insertar productos asociados
    foreach ($productos as $id_prod) {
        $conexion->query("INSERT INTO kit_productos (id_kit, id_producto) VALUES ($id_kit, $id_prod)");
    }

    // Calcular stock del kit como el mínimo stock entre sus productos
    $res = $conexion->query("
      SELECT MIN(p.stock) AS stock_kit
      FROM productos p
      INNER JOIN kit_productos kp ON kp.id_producto = p.id
      WHERE kp.id_kit = $id_kit
    ");
    $stock_kit = $res->fetch_assoc()['stock_kit'] ?? 0;

    $conexion->query("UPDATE kits SET stock = $stock_kit WHERE id = $id_kit");

    echo "Kit agregado.<br><a href='index.php'>Volver</a>";
    exit;
}
?>

<h2>Agregar Kit</h2>
<form method="POST">
  Nombre: <input type="text" name="nombre"><br>
  Descripción: <input type="text" name="descrip"><br>
  Precio: <input type="number" step="0.01" name="precio"><br>

  <h4>Seleccionar productos para el kit:</h4>
  <table border="1">
    <tr><th>Seleccionar</th><th>Nombre</th><th>Stock</th></tr>
    <?php
    $res = $conexion->query("SELECT * FROM productos");
    while ($row = $res->fetch_assoc()) {
        echo "<tr>
          <td><input type='checkbox' name='productos[]' value='{$row['id']}'></td>
          <td>{$row['nombre']}</td>
          <td>{$row['stock']}</td>
        </tr>";
    }
    ?>
  </table><br>

  <input type="submit" value="Agregar Kit">
</form>