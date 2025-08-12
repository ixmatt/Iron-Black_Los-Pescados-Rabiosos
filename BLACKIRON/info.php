<?php
session_start();
include 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Nosotros - BlackIron</title>
    <link rel="stylesheet" href="estilos.css" />
</head>
<body>
<?php
$nombre_usuario = "Usuario";
if (isset($_SESSION['usuario_id'])) {
    $id_usuario = $_SESSION['usuario_id'];
    $stmt = $conexion->prepare("SELECT nombre FROM usuario WHERE id = ?");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();
        $nombre_usuario = $fila['nombre'];
        $_SESSION['usuario_nombre'] = $nombre_usuario;
    }
    $stmt->close();
}
?>

<header>
    <h1>BLACKIRON</h1>
    <nav>
        <a href="index.php" style="color:#fff; margin-right:15px; text-decoration:none;">Inicio</a>

        <?php if (isset($_SESSION['usuario_id'])): ?>
            <span style="margin-right:15px;">Hola, <strong><?php echo htmlspecialchars($nombre_usuario); ?></strong>!</span>
            <a href="logout.php" style="color:#fff; margin-right:15px; text-decoration:none;">Cerrar sesión</a>

            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1): ?>
                <a href="agregar_producto.php" style="color:#fff; margin-right:15px; text-decoration:none;">Agregar Producto</a>
                <a href="agregar_kit.php" style="color:#fff; margin-right:15px; text-decoration:none;">Agregar Kit</a>
                <a href="listaVentas.php" style="color:#fff; margin-right:15px; text-decoration:none;">Ver Ventas</a>
            <?php endif; ?>

        <?php else: ?>
            <a href="login.php" style="color:#fff; margin-right:15px; text-decoration:none;">Iniciar sesión</a>
            <a href="registro.php" style="color:#fff; text-decoration:none;">Registrarse</a>
        <?php endif; ?>
    </nav>
</header>

<main class="contenedor">
    <section class="seccion">
        <h2>INFORMACIÓN SOBRE BLACKIRON</h2>
        <div class="card">
            <p>
                Bienvenido a nuestra tienda online.
                En este sitio vas a poder encontrar el mejor equipamiento deportivo para tu gimnasio, box de crossfit o simplemente para tu casa.
                Somos fabricantes con más de 40 años de experiencia en barras olímpicas, mancuernas, barras EZ, etc.
            </p>
            <p>
                Enamorate de la calidad de nuestros diseños y equipate con lo mejor del mercado, al mejor precio.
                Llevate un producto de calidad y con el mejor servicio postventa. Si alguno de nuestros productos presenta una falla de fabricación,
                podés enviarnos un mail a <strong>reclamos@blackiron.com.ar</strong> y reparamos tu producto sin costo alguno.
            </p>
            <p>
                Somos <strong>BLACK IRON</strong>, una empresa de vanguardia creada para el desarrollo y producción de piezas de precisión.
                Desde 1979 abastecemos a distintas empresas líderes de mercado. Y hoy, tras cumplir 40 años, continúa siendo “la calidad” nuestra mayor prioridad.
            </p>
            <p>
                Desde 2014 tomamos el compromiso de generar un producto propio, de elaboración 100% argentina.
                Hemos desarrollado un abanico de productos para equipar espacios de entrenamiento, sin dejar de lado la estética y la calidad.
            </p>
            <p>
                Contamos con maquinaria de última generación, instrumentos certificados por normas ISO 9001 y un equipo profesional.
                Nuestro compromiso es ofrecer siempre calidad y servicio garantizado.
            </p>


        </div>
    </section>

    <section class="seccion">
        <h2>UBICACIÓN</h2>
        <p>Lobos 1380, B1650 San Martín, Provincia de Buenos Aires</p>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3283.7748858484256!2d-58.539839124915!3d-34.608891372952814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcb77d557fdd3b%3A0xb928efefb8d7f27c!2sLobos%201380%2C%20B1650%20San%20Mart%C3%ADn%2C%20Provincia%20de%20Buenos%20Aires!5e0!3m2!1ses-419!2sar!4v1722450000000"
          width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
    </section>

    <section class="seccion">
        <h2>CONTACTO</h2>
        <ul>
            <li><strong>Dirección:</strong> Lobos 1380, B1650 San Martín, Buenos Aires</li>
            <li><strong>Teléfono:</strong> +54 11 1234-5678</li>
            <li><strong>Email:</strong> contacto@blackiron.com.ar</li>
            <li><strong>Reclamos:</strong> reclamos@blackiron.com.ar</li>
            <li><strong>Instagram:</strong> @blackiron.ar</li>
            <li><strong>Horario:</strong> Lunes a Viernes de 10 a 18 hs</li>
        </ul>
    </section>
</main>
</body>
</html>