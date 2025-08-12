<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    die("Acceso restringido solo para administradores.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Ventas realizadas</title>
  <link rel="stylesheet" href="estilos.css" />
</head>
<body>
  <header>
    <a href="index.php " style = "text-decoration: none;"><h1>BLACKIRON</h1></a>
  </header>

  <main class="contenedor">
    <div class="form-container">
      <h2>VENTAS REALIZADAS</h2>

      <?php
      $res = $conexion->query("
        SELECT c.id, u.nombre AS comprador, p.nombre AS producto, k.nombre AS kit
        FROM compra c
        LEFT JOIN productos p ON c.id_prod = p.id
        LEFT JOIN kits k ON c.id_kit = k.id
        LEFT JOIN usuario u ON c.id_usuario = u.id
      ");

      if ($res->num_rows > 0) {
          echo "<table border='1' style='width:100%; border-collapse: collapse;'>";
          echo "<tr><th>ID Compra</th><th>Comprador</th><th>Producto</th><th>Kit</th></tr>";

          while ($row = $res->fetch_assoc()) {
              echo "<tr>
                      <td>" . htmlspecialchars($row['id']) . "</td>
                      <td>" . htmlspecialchars($row['comprador']) . "</td>
                      <td>" . htmlspecialchars($row['producto']) . "</td>
                      <td>" . htmlspecialchars($row['kit']) . "</td>
                    </tr>";
          }
          echo "</table>";
      } else {
          echo "<p class='mensaje'>No hay ventas registradas.</p>";
      }
      ?>

      <br>
      <a href="index.php" class="btn">Volver</a>
    </div>
  </main>
</body>
</html>
