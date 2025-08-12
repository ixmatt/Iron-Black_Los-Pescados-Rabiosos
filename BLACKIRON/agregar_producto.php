<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Agregar Producto</title>
  <link rel="stylesheet" href="estilos.css" />
</head>
<body>
  <header>
    <a href="index.php " style = "text-decoration: none;"><h1>BLACKIRON</h1></a>
  </header>

  <main class="contenedor">
    <div class="form-container">
      <h2>AGREGAR PRODUCTO</h2>
      <form method="POST" enctype="multipart/form-data">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Descripción:</label>
        <input type="text" name="descrip" required>

        <label>Precio:</label>
        <input type="number" step="0.01" name="precio" required>

        <label>Stock:</label>
        <input type="number" name="stock" required>

        <label>Imagen:</label>
        <input type="file" name="imagen" accept="image/*" required>

        <input type="submit" value="Agregar">
      </form>

      <?php
      include 'conexion.php';

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $nombre = $_POST['nombre'];
          $descrip = $_POST['descrip'];
          $precio = floatval($_POST['precio']);
          $stock = intval($_POST['stock']);

          if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
              $archivoTmp = $_FILES['imagen']['tmp_name'];
              $nombreArchivo = basename($_FILES['imagen']['name']);
              $carpetaDestino = "uploads/";

              if (!is_dir($carpetaDestino)) {
                  mkdir($carpetaDestino, 0755, true);
              }

              $ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
              $nombreArchivoNuevo = uniqid('img_') . "." . $ext;
              $rutaDestino = $carpetaDestino . $nombreArchivoNuevo;

              if (move_uploaded_file($archivoTmp, $rutaDestino)) {
                  $stmt = $conexion->prepare("CALL insertarProductos(?, ?, ?, ?, ?)");
                  $stmt->bind_param('ssdis', $nombre, $descrip, $precio, $stock, $rutaDestino);

                  $stmt->execute();
                  $stmt->close();

                  echo "<p class='mensaje'>Producto agregado con imagen.<br><a href='index.php'>Volver</a></p>";
                  exit;
              } else {
                  echo "<p class='mensaje'>Error al mover la imagen.</p>";
              }
          } else {
              echo "<p class='mensaje'>No se subió ninguna imagen o hubo un error.</p>";
          }
      }
      ?>
    </div>
  </main>
</body>
</html>
