-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 20-08-2020 a las 15:19:25
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
-- Base de datos: `prcata`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amigos`
--

DROP TABLE IF EXISTS `amigos`;
CREATE TABLE IF NOT EXISTS `amigos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario1` int(11) NOT NULL,
  `idUsuario2` int(11) NOT NULL,
  `aceptada` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `idUsuario1` (`idUsuario1`),
  KEY `idUsuario2` (`idUsuario2`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cata`
--

DROP TABLE IF EXISTS `cata`;
CREATE TABLE IF NOT EXISTS `cata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `en_curso` bit(1) NOT NULL DEFAULT b'1',
  `password` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` date NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin` (`admin`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

 --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cerveza`
--

DROP TABLE IF EXISTS `cerveza`;
CREATE TABLE IF NOT EXISTS `cerveza` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCata` int(11) DEFAULT NULL,
  `nombre` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idCata` (`idCata`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medias`
--

DROP TABLE IF EXISTS `medias`;
CREATE TABLE IF NOT EXISTS `medias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aroma` float NOT NULL,
  `apariencia` float NOT NULL,
  `sabor` float NOT NULL,
  `cuerpo` float NOT NULL,
  `botellin` float NOT NULL,
  `media` float NOT NULL,
  `idCerveza` int(11) NOT NULL,
  `idCata` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idCerveza` (`idCerveza`),
  KEY `idCerveza_2` (`idCerveza`),
  KEY `idCata` (`idCata`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opinion`
--

DROP TABLE IF EXISTS `opinion`;
CREATE TABLE IF NOT EXISTS `opinion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idPersona` int(11) NOT NULL,
  `idCerveza` int(11) NOT NULL,
  `aroma` int(11) NOT NULL,
  `apariencia` int(11) NOT NULL,
  `sabor` int(11) NOT NULL,
  `cuerpo` int(11) NOT NULL,
  `botellin` int(11) NOT NULL,
  `foto` blob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idPersona` (`idPersona`),
  KEY `idCerveza` (`idCerveza`)
) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

DROP TABLE IF EXISTS `persona`;
CREATE TABLE IF NOT EXISTS `persona` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona_cata`
--

DROP TABLE IF EXISTS `persona_cata`;
CREATE TABLE IF NOT EXISTS `persona_cata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idPersona` int(11) NOT NULL,
  `idCata` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idPersona` (`idPersona`),
  KEY `idCata` (`idCata`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  UNIQUE KEY `usuario` (`usuario`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
