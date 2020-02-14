-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 14-02-2020 a las 11:55:48
-- Versión del servidor: 10.4.10-MariaDB
-- Versión de PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `servidor_cata`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cata`
--

DROP TABLE IF EXISTS `cata`;
CREATE TABLE IF NOT EXISTS `cata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cata`
--

INSERT INTO `cata` (`id`, `nombre`, `fecha`) VALUES
(27, 'III_Cata_Impresentable', '2019-12-23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cerveza`
--

DROP TABLE IF EXISTS `cerveza`;
CREATE TABLE IF NOT EXISTS `cerveza` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `idCata` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idCata` (`idCata`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cerveza`
--

INSERT INTO `cerveza` (`id`, `nombre`, `idCata`) VALUES
(7, 'Cubanisto', 27),
(8, 'La_Bella_Lola', 27),
(9, 'ZYWIEC', 27),
(10, 'Miller', 27),
(11, 'Pacifico', 27),
(12, 'Weltnburguer_Kloster', 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opinion`
--

DROP TABLE IF EXISTS `opinion`;
CREATE TABLE IF NOT EXISTS `opinion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCerveza` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `apariencia` int(11) NOT NULL,
  `aroma` int(11) NOT NULL,
  `sabor` int(11) NOT NULL,
  `cuerpo` int(11) NOT NULL,
  `botellin` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idCerveza` (`idCerveza`,`idPersona`),
  KEY `idPersona` (`idPersona`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `opinion`
--

INSERT INTO `opinion` (`id`, `idCerveza`, `idPersona`, `apariencia`, `aroma`, `sabor`, `cuerpo`, `botellin`) VALUES
(1, 8, 7, 7, 9, 3, 3, NULL),
(2, 7, 7, 8, 6, 5, 7, NULL),
(3, 8, 8, 6, 9, 8, 8, NULL),
(4, 9, 7, 8, 7, 7, 8, NULL),
(5, 8, 10, 8, 7, 6, 8, NULL),
(6, 7, 8, 5, 7, 2, 3, NULL),
(7, 9, 8, 6, 6, 8, 7, NULL),
(8, 7, 10, 7, 8, 1, 1, NULL),
(9, 8, 12, 5, 6, 6, 6, NULL),
(10, 7, 12, 5, 3, 1, 1, NULL),
(11, 11, 7, 6, 1, 5, 4, NULL),
(12, 12, 7, 8, 8, 7, 5, NULL),
(13, 10, 7, 8, 2, 4, 4, NULL),
(14, 9, 10, 8, 7, 7, 9, NULL),
(15, 8, 11, 7, 7, 8, 7, NULL),
(16, 11, 8, 5, 1, 5, 5, NULL),
(17, 10, 8, 5, 1, 5, 5, NULL),
(18, 8, 9, 6, 8, 6, 7, NULL),
(19, 12, 8, 9, 7, 7, 7, NULL),
(20, 7, 11, 8, 7, 8, 6, NULL),
(21, 9, 12, 5, 5, 5, 5, NULL),
(22, 12, 10, 7, 1, 2, 1, NULL),
(23, 11, 10, 9, 1, 3, 7, NULL),
(24, 10, 10, 4, 5, 2, 5, NULL),
(25, 9, 11, 6, 6, 6, 5, NULL),
(26, 7, 9, 7, 6, 8, 4, NULL),
(27, 11, 12, 3, 3, 3, 3, NULL),
(28, 9, 9, 8, 7, 8, 9, NULL),
(29, 10, 12, 3, 3, 3, 3, NULL),
(30, 12, 12, 4, 4, 5, 4, NULL),
(31, 11, 11, 5, 5, 5, 0, NULL),
(32, 12, 11, 8, 6, 9, 9, NULL),
(33, 10, 11, 0, 6, 0, 0, NULL),
(34, 12, 9, 9, 8, 9, 8, NULL),
(35, 10, 9, 6, 6, 8, 7, NULL),
(36, 11, 9, 5, 5, 5, 4, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

DROP TABLE IF EXISTS `persona`;
CREATE TABLE IF NOT EXISTS `persona` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idCata` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idCata` (`idCata`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `nombre`, `idCata`) VALUES
(7, 'Guille', 27),
(8, 'Rube', 27),
(9, 'Carlos', 27),
(10, 'Mpa', 27),
(11, 'Pavvol', 27),
(12, 'Enri', 27);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cerveza`
--
ALTER TABLE `cerveza`
  ADD CONSTRAINT `cerveza_ibfk_1` FOREIGN KEY (`idCata`) REFERENCES `cata` (`id`);

--
-- Filtros para la tabla `opinion`
--
ALTER TABLE `opinion`
  ADD CONSTRAINT `opinion_ibfk_1` FOREIGN KEY (`idCerveza`) REFERENCES `cerveza` (`id`),
  ADD CONSTRAINT `opinion_ibfk_2` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`id`);

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`idCata`) REFERENCES `cata` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
