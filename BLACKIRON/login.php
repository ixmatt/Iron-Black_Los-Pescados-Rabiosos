<?php
session_start();
include 'conexion.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $contra = md5($_POST['contra']);  

    $sql = "SELECT * FROM usuario WHERE nombre = ? AND contra = ?";
    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        $error = "Error en la consulta SQL: " . $conexion->error;
    } else {
        $stmt->bind_param("ss", $nombre, $contra);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['rol'] = $usuario['rol'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Nombre o contraseña incorrectos.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Login</title>
  <link rel="stylesheet" href="estilos.css" />
</head>
<body>
  <header>
    <a href="index.php " style = "text-decoration: none;"><h1>BLACKIRON</h1></a>
  </header>

  <main class="contenedor">
    <div class="form-container">
      <h2>INICIAR SESIÓN</h2>
      <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Contraseña:</label>
        <input type="password" name="contra" required>

        <input type="submit" value="Ingresar">
      </form>

      <?php if ($error): ?>
          <p class="mensaje"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>
    </div>
  </main>
</body>
</html>
