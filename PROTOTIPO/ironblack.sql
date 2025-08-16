SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `ironblack`;
USE `ironblack`;

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_prod` int(11) DEFAULT NULL,
  `id_kit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_prod` (`id_prod`),
  KEY `id_kit` (`id_kit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `compra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_prod` int(11) DEFAULT NULL,
  `id_kit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_prod` (`id_prod`),
  KEY `id_kit` (`id_kit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `kits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pro` int(11) DEFAULT NULL,
  `nombre` varchar(40) DEFAULT NULL,
  `descrip` varchar(255) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pro` (`id_pro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `kit_productos` (
  `id_kit` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) DEFAULT NULL,
  `descrip` varchar(255) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `contra` varchar(50) DEFAULT NULL,
  `dni` int(9) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Claves foráneas
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`id_kit`) REFERENCES `kits` (`id`);

ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`id_kit`) REFERENCES `kits` (`id`);

ALTER TABLE `kits`
  ADD CONSTRAINT `kits_ibfk_1` FOREIGN KEY (`id_pro`) REFERENCES `productos` (`id`);

COMMIT;
