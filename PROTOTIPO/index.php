<?php include 'conexion.php'; ?>
<h2>Productos disponibles</h2>
<form method="POST" action="compra.php">
  <table border="1">
    <tr><th>Seleccionar</th><th>Nombre</th><th>Precio</th><th>Stock</th></tr>
    <?php
    $res = $conexion->query("SELECT * FROM productos");
    while ($row = $res->fetch_assoc()) {
        echo "<tr>
          <td><input type='checkbox' name='productos[]' value='{$row['id']}'></td>
          <td>{$row['nombre']}</td>
          <td>\${$row['precio']}</td>
          <td>{$row['stock']}</td>
        </tr>";
    }
    ?>
  </table>

  <h2>Kits disponibles</h2>
  <table border="1">
    <tr><th>Seleccionar</th><th>Nombre</th><th>Precio</th><th>Stock</th></tr>
    <?php
    $res = $conexion->query("SELECT * FROM kits");
    while ($row = $res->fetch_assoc()) {
        echo "<tr>
          <td><input type='checkbox' name='kits[]' value='{$row['id']}'></td>
          <td>{$row['nombre']}</td>
          <td>\${$row['precio']}</td>
          <td>{$row['stock']}</td>
        </tr>";
    }
    ?>
  </table>
  <br>
  <input type="submit" value="Comprar">
</form>

<br><br>
<a href="agregar_producto.php">Agregar Producto</a> |
<a href="agregar_kit.php">Agregar Kit</a> |
<a href="listaVentas.php">Ver Ventas</a>