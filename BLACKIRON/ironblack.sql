-- CREAR BASE DE DATOS
DROP DATABASE IF EXISTS `ironblack`;
CREATE DATABASE IF NOT EXISTS `ironblack` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ironblack`;

-- TABLA: usuario
CREATE TABLE `usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(20) DEFAULT NULL,
  `apellido` VARCHAR(50) DEFAULT NULL,
  `contra` CHAR(32) NOT NULL,
  `dni` INT(9) DEFAULT NULL,
  `rol` TINYINT(1) DEFAULT 0,
  PRIMARY KEY (`id`)
);

-- TABLA: productos
CREATE TABLE `productos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(40) DEFAULT NULL,
  `descrip` VARCHAR(255) DEFAULT NULL,
  `precio` FLOAT DEFAULT NULL,
  `stock` INT(11) DEFAULT NULL,
  `imagen` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- TABLA: kits
CREATE TABLE `kits` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_pro` INT(11) DEFAULT NULL,
  `nombre` VARCHAR(40) DEFAULT NULL,
  `descrip` VARCHAR(255) DEFAULT NULL,
  `precio` FLOAT DEFAULT NULL,
  `stock` INT(11) DEFAULT NULL,
  `imagen` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pro` (`id_pro`),
  CONSTRAINT `kits_ibfk_1` FOREIGN KEY (`id_pro`) REFERENCES `productos` (`id`)
);

-- TABLA: kit_productos
CREATE TABLE `kit_productos` (
  `id_kit` INT(11) NOT NULL,
  `id_producto` INT(11) NOT NULL,
  PRIMARY KEY (`id_kit`, `id_producto`),
  KEY `kit_productos_ibfk_2` (`id_producto`),
  CONSTRAINT `kit_productos_ibfk_1` FOREIGN KEY (`id_kit`) REFERENCES `kits` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kit_productos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE
);

-- TABLA: carrito
CREATE TABLE `carrito` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_prod` INT(11) DEFAULT NULL,
  `id_kit` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_prod` (`id_prod`),
  KEY `id_kit` (`id_kit`),
  CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `productos` (`id`),
  CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`id_kit`) REFERENCES `kits` (`id`)
);

-- TABLA: compra
CREATE TABLE `compra` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_prod` INT(11) DEFAULT NULL,
  `id_kit` INT(11) DEFAULT NULL,
  `id_usuario` INT(11),
  PRIMARY KEY (`id`),
  KEY `id_prod` (`id_prod`),
  KEY `id_kit` (`id_kit`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `productos` (`id`),
  CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`id_kit`) REFERENCES `kits` (`id`),
  CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
);

-- PROCEDIMIENTOS
DELIMITER //

-- 1. Agregar producto
CREATE PROCEDURE insertarProductos(
  IN nom VARCHAR(40),
  IN des TEXT,
  IN pre FLOAT,
  IN stk INT,
  IN img VARCHAR(255)
)
BEGIN
  INSERT INTO productos (nombre, descrip, precio, stock, imagen)
  VALUES (nom, des, pre, stk, img);
END //

-- 2. Crear kit sin productos
CREATE PROCEDURE insertarKit(
  IN nom VARCHAR(40),
  IN des TEXT,
  IN pre FLOAT,
  IN img VARCHAR(255)
)
BEGIN
  INSERT INTO kits (nombre, descrip, precio, stock, imagen)
  VALUES (nom, des, pre, 0, img);
END //

-- 3. Asociar productos al kit
CREATE PROCEDURE agregarProductoAKit(
  IN kit_id INT,
  IN prod_id INT
)
BEGIN
  INSERT INTO kit_productos (id_kit, id_producto)
  VALUES (kit_id, prod_id);
END //

-- 4. Insertar compra de producto
CREATE PROCEDURE insertarCompraProducto(
  IN prod_id INT,
  IN user_id INT
)
BEGIN
  INSERT INTO compra (id_prod, id_usuario) VALUES (prod_id, user_id);
END //

-- 5. Insertar compra de kit
CREATE PROCEDURE insertarCompraKit(
  IN kit_id INT,
  IN user_id INT
)
BEGIN
  INSERT INTO compra (id_kit, id_usuario) VALUES (kit_id, user_id);
END //

-- 6. Descontar stock de producto
CREATE PROCEDURE descontarStockProducto(
  IN prod_id INT
)
BEGIN
  UPDATE productos SET stock = stock - 1
  WHERE id = prod_id AND stock > 0;
END //

-- 7. Actualizar stock de un kit según sus productos
CREATE PROCEDURE actualizarStockKit(
  IN kit_id INT
)
BEGIN
  DECLARE nuevo_stock INT;
  SELECT MIN(p.stock) INTO nuevo_stock
  FROM productos p
  INNER JOIN kit_productos kp ON kp.id_producto = p.id
  WHERE kp.id_kit = kit_id;

  UPDATE kits SET stock = IFNULL(nuevo_stock, 0)
  WHERE id = kit_id;
END //

-- 8. Crear usuario
CREATE PROCEDURE crearUsuario(
  IN nombre VARCHAR(20),
  IN apellido VARCHAR(50),
  IN dni INT,
  IN contra VARCHAR(100)
)
BEGIN
  INSERT INTO usuario (nombre, apellido, dni, contra, rol)
  VALUES (nombre, apellido, dni, MD5(contra), 0);
END //

DELIMITER ;

ALTER TABLE kit_productos ADD cantidad INT NOT NULL DEFAULT 1;

ALTER TABLE productos ADD COLUMN oculto TINYINT(1) NOT NULL DEFAULT 0;
ALTER TABLE kits ADD COLUMN oculto TINYINT(1) NOT NULL DEFAULT 0;

