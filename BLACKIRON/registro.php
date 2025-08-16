<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Registro</title>
  <link rel="stylesheet" href="estilos.css" />
</head>
<body>
  <header>
    <a href="index.php " style = "text-decoration: none;"><h1>BLACKIRON</h1></a>
  </header>

  <main class="contenedor">
    <div class="form-container">
      <h2>REGISTRARSE</h2>
      <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Apellido:</label>
        <input type="text" name="apellido" required>

        <label>DNI:</label>
        <input type="number" name="dni" required>

        <label>Contraseña:</label>
        <input type="password" name="contra" required>

        <input type="submit" value="Registrarse">
      </form>
      <?php
      include 'conexion.php';
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $nombre = $_POST['nombre'];
          $apellido = $_POST['apellido'];
          $dni = $_POST['dni'];
          $contra = $_POST['contra'];

          $stmt = $conexion->prepare("CALL crearUsuario(?, ?, ?, ?)");
          $stmt->bind_param("ssis", $nombre, $apellido, $dni, $contra);
          $stmt->execute();
          $stmt->close();

          echo "<p class='mensaje'>Registro exitoso. <a href='login.php'>Iniciar sesión</a></p>";
      }
      ?>
    </div>
  </main>
</body>
</html>