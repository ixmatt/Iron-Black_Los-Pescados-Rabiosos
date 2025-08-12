<?php
session_start(); 
include 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>BlackIron - Productos</title>
    <link rel="stylesheet" href="estilos.css" />
</head>
<body>
<?php

$nombre_usuario = "Usuario"; 

if (isset($_SESSION['usuario_id'])) {
    $id_usuario = $_SESSION['usuario_id'];
    //esto consulta la base de datos isma
    $stmt = $conexion->prepare("SELECT nombre FROM usuario WHERE id = ?");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();
        $nombre_usuario = $fila['nombre'];
        // y aca se guarda 
        $_SESSION['usuario_nombre'] = $nombre_usuario;
    }
    $stmt->close();
}
?>

<header>
    <a href="index.php " style = "text-decoration: none;"><h1>BLACKIRON</h1></a>
    <nav>
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
            <br>
    <a href="info.php" style="color:#fff; margin-right:15px; text-decoration:none;">Sobre Nosotros</a>
    </nav>
</header>

<main class="contenedor">
    <section class="seccion">
        <h2>PRODUCTOS INDIVIDUALES</h2>
        <div class="grid">
            <?php
            // Mostrar solo productos NO ocultos
            $sql = "SELECT * FROM productos WHERE oculto = 0";
            $resultado = $conexion->query($sql);
            while ($fila = $resultado->fetch_assoc()):
            ?>
            <div class="card">
                <img src="<?php echo htmlspecialchars($fila['imagen']); ?>" alt="Producto" style="max-width:150px; height:auto;" />
                <h3><?php echo htmlspecialchars($fila['nombre']); ?></h3>
                <p><?php echo htmlspecialchars($fila['descrip']); ?></p>
                <p class="precio">$<?php echo number_format($fila['precio']); ?></p>
                <p>Stock: <?php echo intval($fila['stock']); ?></p>

                <?php if ($fila['stock'] == 0): ?>
                    <p style="color:red;font-weight:bold;">SIN STOCK</p>
                <?php endif; ?>

                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <form method="POST" action="compra.php" style="display:inline;">
                        <input type="hidden" name="id_producto" value="<?php echo $fila['id']; ?>">
                        <button type="submit" <?php if ($fila['stock'] == 0) echo 'disabled style="opacity:0.5;cursor:not-allowed;"'; ?>>
                            COMPRAR
                        </button>
                    </form>

                    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1): ?>
                        <form method="POST" action="actualizar_stock.php" style="display:inline;">
                            <input type="hidden" name="id_producto" value="<?php echo $fila['id']; ?>">
                            <input type="number" name="nuevo_stock" value="<?php echo intval($fila['stock']); ?>" min="0" style="width:60px;">
                            <button type="submit">Actualizar</button>
                        </form>
                        <form method="POST" action="ocultar_producto.php" style="display:inline;">
                            <input type="hidden" name="id_producto" value="<?php echo $fila['id']; ?>">
                            <input type="hidden" name="accion" value="ocultar">
                            <button type="submit">Ocultar</button>
                        </form>
                    <?php endif; ?>
                <?php else: ?>
                    <a class="btn" href="login.php">INICIAR SESIÓN</a>
                <?php endif; ?>

            </div>
            <?php endwhile; ?>
        </div>
    </section>

    <section class="seccion">
        <h2>KITS</h2>
        <div class="grid">
            <?php
            // Mostrar solo kits NO ocultos
            $sql = "SELECT * FROM kits WHERE oculto = 0";
            $resultado = $conexion->query($sql);
            while ($fila = $resultado->fetch_assoc()):
            ?>
            <div class="card">
                <img src="<?php echo htmlspecialchars($fila['imagen']); ?>" alt="Kit" style="max-width:150px; height:auto;" />
                <h3><?php echo htmlspecialchars($fila['nombre']); ?></h3>
                <p><?php echo htmlspecialchars($fila['descrip']); ?></p>
                <p class="precio">$<?php echo number_format($fila['precio']); ?></p>
                <p>Stock: <?php echo intval($fila['stock']); ?></p>

                <?php if ($fila['stock'] == 0): ?>
                    <p style="color:red;font-weight:bold;">SIN STOCK</p>
                <?php endif; ?>

                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <form method="POST" action="compra.php" style="display:inline;">
                        <input type="hidden" name="id_kit" value="<?php echo $fila['id']; ?>">
                        <button type="submit" <?php if ($fila['stock'] == 0) echo 'disabled style="opacity:0.5;cursor:not-allowed;"'; ?>>
                            COMPRAR
                        </button>
                    </form>

                    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1): ?>
                        <form method="POST" action="actualizar_stock.php" style="display:inline;">
                            <input type="hidden" name="id_kit" value="<?php echo $fila['id']; ?>">
                            <input type="number" name="nuevo_stock" value="<?php echo intval($fila['stock']); ?>" min="0" style="width:60px;">
                            <button type="submit">Actualizar</button>
                        </form>
                        <form method="POST" action="ocultar_producto.php" style="display:inline;">
                            <input type="hidden" name="id_kit" value="<?php echo $fila['id']; ?>">
                            <input type="hidden" name="accion" value="ocultar">
                            <button type="submit">Ocultar</button>
                        </form>
                    <?php endif; ?>
                <?php else: ?>
                    <a class="btn" href="login.php">INICIAR SESIÓN</a>
                <?php endif; ?>

            </div>
            <?php endwhile; ?>
        </div>
    </section>

    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1): ?>
    <section class="seccion">
        <h2>OCULTOS</h2>
        <div class="grid">
            <?php
            // Productos ocultos
            $sql = "SELECT * FROM productos WHERE oculto = 1";
            $res_prod = $conexion->query($sql);
            while ($fila = $res_prod->fetch_assoc()):
            ?>
            <div class="card">
                <img src="<?php echo htmlspecialchars($fila['imagen']); ?>" alt="Producto Oculto" style="max-width:150px; height:auto;" />
                <h3><?php echo htmlspecialchars($fila['nombre']); ?></h3>
                <p><?php echo htmlspecialchars($fila['descrip']); ?></p>
                <p class="precio">$<?php echo number_format($fila['precio']); ?></p>
                <p>Stock: <?php echo intval($fila['stock']); ?></p>
                <form method="POST" action="ocultar_producto.php" style="display:inline;">
                    <input type="hidden" name="id_producto" value="<?php echo $fila['id']; ?>">
                    <input type="hidden" name="accion" value="mostrar">
                    <button type="submit">Mostrar</button>
                </form>
            </div>
            <?php endwhile; ?>

            <?php
            // Kits ocultos
            $sql = "SELECT * FROM kits WHERE oculto = 1";
            $res_kit = $conexion->query($sql);
            while ($fila = $res_kit->fetch_assoc()):
            ?>
            <div class="card">
                <img src="<?php echo htmlspecialchars($fila['imagen']); ?>" alt="Kit Oculto" style="max-width:150px; height:auto;" />
                <h3><?php echo htmlspecialchars($fila['nombre']); ?></h3>
                <p><?php echo htmlspecialchars($fila['descrip']); ?></p>
                <p class="precio">$<?php echo number_format($fila['precio']); ?></p>
                <p>Stock: <?php echo intval($fila['stock']); ?></p>
                <form method="POST" action="ocultar_producto.php" style="display:inline;">
                    <input type="hidden" name="id_kit" value="<?php echo $fila['id']; ?>">
                    <input type="hidden" name="accion" value="mostrar">
                    <button type="submit">Mostrar</button>
                </form>
            </div>
            <?php endwhile; ?>
        </div>
    </section>
    <?php endif; ?>

</main>
</body>
</html>
