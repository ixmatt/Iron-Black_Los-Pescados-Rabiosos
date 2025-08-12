<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Agregar Kit</title>
  <link rel="stylesheet" href="estilos.css" />
</head>
<body>
  <header>
    <a href="index.php " style = "text-decoration: none;"><h1>BLACKIRON</h1></a>
  </header>

  <main class="contenedor">
    <div class="form-container">
      <h2>AGREGAR KIT</h2>
      <form method="POST" enctype="multipart/form-data">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Descripción:</label>
        <input type="text" name="descrip" required>

        <label>Precio:</label>
        <input type="number" step="0.01" name="precio" required>

        <label>Imagen:</label>
        <input type="file" name="imagen" accept="image/*" required>

        <h4>Seleccionar productos para el kit:</h4>
        <table border ="1" cellpadding="5" cellspacing="0">
          <tr>
            <th>Seleccionar</th>
            <th>Nombre</th>
            <th>Stock</th>
          </tr>
          <?php
            include 'conexion.php';
            $res = $conexion->query("SELECT * FROM productos");

            while ($row = $res->fetch_assoc()) {
                $id = intval($row['id']);
                echo "<tr>
                        <td>
                            <input type='checkbox' name='productos[$id][id]' value='$id'>
                        </td>
                        <td>" . htmlspecialchars($row['nombre']) . "</td>
                        <td>" . intval($row['stock']) . "</td>
                        <td>
                            <input type='number' name='productos[$id][cantidad]' min='1' value='1'>
                        </td>
                      </tr>";
            }
          ?>

?>


        </table>

        <input type="submit" value="Agregar Kit">
      </form>

      <?php
      include 'conexion.php';

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $nombre = $_POST['nombre'];
          $descrip = $_POST['descrip'];
          $precio = floatval($_POST['precio']);
          $productos = isset($_POST['productos']) ? $_POST['productos'] : [];

          if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
              $archivoTmp = $_FILES['imagen']['tmp_name'];
              $nombreArchivo = basename($_FILES['imagen']['name']);
              $carpetaDestino = "uploads/";

              if (!is_dir($carpetaDestino)) {
                  mkdir($carpetaDestino, 0755, true);
              }

              $ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
              $nombreArchivoNuevo = uniqid('kitimg_') . "." . $ext;
              $rutaDestino = $carpetaDestino . $nombreArchivoNuevo;

              if (move_uploaded_file($archivoTmp, $rutaDestino)) {
                  $stmt = $conexion->prepare("CALL insertarKit(?, ?, ?, ?)");
                  $stmt->bind_param("ssds", $nombre, $descrip, $precio, $rutaDestino);
                  $stmt->execute();
                  $stmt->close();

                  $resId = $conexion->query("SELECT MAX(id) AS id FROM kits");
                  $rowId = $resId->fetch_assoc();
                  $id_kit = $rowId['id'];

             if (!empty($productos)) {
                  foreach ($productos as $prod) {
                      if (!empty($prod['id']) && !empty($prod['cantidad'])) {
                          $id_prod = intval($prod['id']);
                          $cantidad = intval($prod['cantidad']);

                          $stmt = $conexion->prepare(
                              "INSERT INTO kit_productos (id_kit, id_producto, cantidad) VALUES (?, ?, ?)"
                          );
                          $stmt->bind_param("iii", $id_kit, $id_prod, $cantidad);
                          $stmt->execute();
                          $stmt->close();
                      }
    }
}


                  }

                  $stmt = $conexion->prepare("CALL actualizarStockKit(?)");
                  $stmt->bind_param("i", $id_kit);
                  $stmt->execute();
                  $stmt->close();

                  echo "<p class='mensaje'>Kit agregado con imagen.<br><a href='index.php'>Volver</a></p>";
                  exit;
              } else {
                  echo "<p class='mensaje'>Error al mover la imagen.</p>";
              }
          } else {
              echo "<p class='mensaje'>No se subió ninguna imagen o hubo un error.</p>";
          }
      
      ?>
    </div>
  </main>
</body>
</html>
