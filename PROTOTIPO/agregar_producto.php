<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descrip = $_POST['descrip'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $conexion->query("INSERT INTO productos (nombre, descrip, precio, stock) 
                      VALUES ('$nombre', '$descrip', $precio, $stock)");

    echo "Producto agregado.<br><a href='index.php'>Volver</a>";
    exit;
}
?>

<h2>Agregar Producto</h2>
<form method="POST">
  Nombre: <input type="text" name="nombre"><br>
  Descripción: <input type="text" name="descrip"><br>
  Precio: <input type="number" step="0.01" name="precio"><br>
  Stock: <input type="number" name="stock"><br>
  <input type="submit" value="Agregar">
</form>