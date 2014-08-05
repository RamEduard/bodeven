-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 05-08-2014 a las 00:44:07
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `tania_serrano`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `created`, `updated`) VALUES
(5, 'Camisa', '2014-07-24 06:12:22', '2014-07-24 22:37:21'),
(6, 'Chemise', '2014-07-24 18:11:19', '2014-07-24 22:37:39'),
(7, 'Mono', '2014-07-24 18:11:37', '2014-07-24 22:37:58'),
(8, 'Gabardina', '2014-07-24 18:11:59', '2014-07-24 18:11:59'),
(9, 'Chaqueta', '2014-07-24 18:12:56', '2014-07-24 22:37:29'),
(10, 'Franela', '2014-07-24 21:40:30', '2014-07-24 22:37:48'),
(11, 'Suéter', '2014-07-24 22:37:13', '2014-07-24 22:37:13'),
(12, 'Falda', '2014-07-24 23:36:18', '2014-07-24 23:36:18'),
(13, 'Pantalón', '2014-07-24 23:47:45', '2014-07-24 23:47:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colors`
--

CREATE TABLE IF NOT EXISTS `colors` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `product_id` int(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `color_hex` varchar(7) NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `colors`
--

INSERT INTO `colors` (`id`, `product_id`, `name`, `color_hex`, `created`, `updated`) VALUES
(2, 5, 'Blanco', '#ffffff', '0000-00-00 00:00:00', '2014-07-24 18:19:23'),
(3, 6, 'Blanco', '#ffffff', '0000-00-00 00:00:00', '2014-07-24 18:26:30'),
(4, 8, 'Azul', '#50afcd', '0000-00-00 00:00:00', '2014-07-24 18:31:45'),
(5, 8, 'Beige', '#f7f7b5', '0000-00-00 00:00:00', '2014-07-24 18:33:45'),
(6, 34, 'Rojo', '#d70202', '0000-00-00 00:00:00', '2014-07-24 22:15:48'),
(7, 34, 'Blanco', '#ffffff', '0000-00-00 00:00:00', '2014-07-24 22:16:06'),
(8, 34, 'Amarillo', '#ffea07', '0000-00-00 00:00:00', '2014-07-24 22:16:31'),
(9, 47, 'Azul marino', '#000425', '0000-00-00 00:00:00', '2014-07-24 23:43:56'),
(10, 53, 'Azul marino', '#101226', '0000-00-00 00:00:00', '2014-07-25 00:00:01'),
(11, 54, 'Azul marino', '#101226', '0000-00-00 00:00:00', '2014-07-25 00:00:19'),
(12, 55, 'Azul marino', '#101226', '0000-00-00 00:00:00', '2014-07-25 00:23:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus`
--

CREATE TABLE IF NOT EXISTS `estatus` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `estatus`
--

INSERT INTO `estatus` (`id`, `name`) VALUES
(1, 'Activo'),
(2, 'Inactivo'),
(3, 'Eliminado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE IF NOT EXISTS `imagen` (
  `id` int(255) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de cada registro',
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Nombre de la imagen',
  `link` text COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Dirección URL de la imagen',
  `imagen` mediumtext COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Imagen transformada para el navegador',
  `creado` datetime NOT NULL COMMENT 'Fecha cuando se crea el registro',
  `modificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha cuando se modifica el registro',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci COMMENT='Imágenes del periódico' AUTO_INCREMENT=34 ;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`id`, `nombre`, `link`, `imagen`, `creado`, `modificado`) VALUES
(31, 'franela1.jpg', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/franela1.jpg', '', '2014-07-25 02:16:09', '2014-07-25 02:16:09'),
(25, 'maiquer7.png', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer7.png', '', '2014-07-25 00:27:37', '2014-07-25 00:27:37'),
(24, 'maiquer12.png', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer12.png', '', '2014-07-25 00:27:37', '2014-07-25 00:27:37'),
(23, 'maiquer9.png', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer9.png', '', '2014-07-25 00:27:19', '2014-07-25 00:27:19'),
(22, 'maiquer4.png', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer4.png', '', '2014-07-25 00:27:19', '2014-07-25 00:27:19'),
(21, 'pantalon-poliester.jpg', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/pantalon-poliester.jpg', '', '2014-07-24 23:51:16', '2014-07-24 23:51:16'),
(20, 'bambino24.png', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino24.png', '', '2014-07-24 23:39:35', '2014-07-24 23:39:35'),
(19, 'bambino22.png', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino22.png', '', '2014-07-24 23:30:41', '2014-07-24 23:30:41'),
(18, 'bambino19.png', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino19.png', '', '2014-07-24 23:30:35', '2014-07-24 23:30:35'),
(17, 'bambino1.png', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino1.png', '', '2014-07-24 21:38:46', '2014-07-24 21:38:46'),
(16, 'bambino18.png', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino18.png', '', '2014-07-24 21:36:39', '2014-07-24 21:36:39'),
(15, 'bambino15.png', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino15.png', '', '2014-07-24 21:36:35', '2014-07-24 21:36:35'),
(14, 'bambino12.png', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino12.png', '', '2014-07-24 21:36:28', '2014-07-24 21:36:28'),
(13, 'bambino11.png', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino11.png', '', '2014-07-24 21:36:24', '2014-07-24 21:36:24'),
(11, 'gabardina-pinzas.jpg', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/gabardina-pinzas.jpg', '', '2014-07-24 20:54:45', '2014-07-24 20:54:45'),
(10, '21.png', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/21.png', '', '2014-07-24 18:08:24', '2014-07-24 18:08:24'),
(12, 'bambino6.png', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino6.png', '', '2014-07-24 21:36:15', '2014-07-24 21:36:15'),
(8, '12.png', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/12.png', '', '2014-07-24 18:08:13', '2014-07-24 18:08:13'),
(7, '9.png', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/9.png', '', '2014-07-24 18:07:59', '2014-07-24 18:07:59'),
(6, '8.png', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/8.png', '', '2014-07-24 18:07:53', '2014-07-24 18:07:53'),
(4, '1.png', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/1.png', '', '2014-07-24 18:07:39', '2014-07-24 18:07:39'),
(5, '6.png', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/6.png', '', '2014-07-24 18:07:46', '2014-07-24 18:07:46'),
(27, 'maiquer20.png', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer20.png', '', '2014-07-25 00:53:02', '2014-07-25 00:53:02'),
(28, 'maiquer23.png', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer23.png', '', '2014-07-25 00:53:06', '2014-07-25 00:53:06'),
(29, 'maiquer15.png', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer15.png', '', '2014-07-25 00:53:08', '2014-07-25 00:53:08'),
(30, 'maiquer18.png', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer18.png', '', '2014-07-25 00:54:07', '2014-07-25 00:54:07'),
(32, 'franela2.jpg', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/franela2.jpg', '', '2014-07-25 02:16:12', '2014-07-25 02:16:12'),
(33, 'franela3.jpg', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/franela3.jpg', '', '2014-07-25 02:16:14', '2014-07-25 02:16:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfils`
--

CREATE TABLE IF NOT EXISTS `perfils` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `perfils`
--

INSERT INTO `perfils` (`id`, `name`) VALUES
(1, 'ROLE_Programador'),
(2, 'ROLE_Administrador'),
(3, 'ROLE_Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `provider_id` int(255) NOT NULL,
  `category_id` int(255) NOT NULL,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `price` text COLLATE utf8_spanish2_ci NOT NULL,
  `image` longtext COLLATE utf8_spanish2_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `provider_id` (`provider_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=84 ;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `provider_id`, `category_id`, `name`, `price`, `image`, `created`, `updated`) VALUES
(5, 4, 6, 'Chemise blanca', '510.30', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/1.png', '0000-00-00 00:00:00', '2014-07-24 18:25:46'),
(7, 4, 6, 'Chemise blanca', '695.72', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/1.png', '2014-07-24 18:29:21', '2014-07-24 18:29:21'),
(6, 4, 6, 'Chemise blanca', '624.47', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/1.png', '2014-07-24 18:25:33', '2014-07-24 18:25:33'),
(8, 4, 6, 'Chemise azul - beige', '695.72', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/1.png', '2014-07-24 18:30:52', '2014-07-24 18:30:52'),
(9, 4, 6, 'Chemise azul - beige', '695.72', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/1.png', '0000-00-00 00:00:00', '2014-07-24 22:14:06'),
(10, 4, 6, 'Chemise (Niña)', '542.69', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/6.png', '2014-07-24 18:47:46', '2014-07-24 18:47:46'),
(11, 4, 6, 'Chemise (Niña)', '586.04', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/6.png', '2014-07-24 18:55:43', '2014-07-24 18:55:43'),
(12, 4, 7, 'Mono algodón reforzado en rodillas', '851.20', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/8.png', '2014-07-24 18:57:07', '2014-07-24 18:57:07'),
(13, 4, 7, 'Mono algodón', '651.58', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/9.png', '2014-07-24 18:58:00', '2014-07-24 18:58:00'),
(14, 4, 7, 'Mono algodón', '735.55', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/9.png', '2014-07-24 19:01:02', '2014-07-24 19:01:02'),
(15, 4, 7, 'Mono algodón', '923.63', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/9.png', '2014-07-24 19:02:09', '2014-07-24 19:02:09'),
(16, 4, 8, 'Gabardina engomado', '1077.17', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/12.png', '2014-07-24 19:04:06', '2014-07-24 19:04:06'),
(17, 4, 8, 'Gabardina engomado', '1132.35', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/12.png', '2014-07-24 19:25:23', '2014-07-24 19:25:23'),
(18, 4, 8, 'Gabardina engomado', '1187.52', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/12.png', '2014-07-24 19:27:02', '2014-07-24 19:27:02'),
(19, 4, 8, 'Gabardina pinzas niño', '1197.12', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/gabardina-pinzas.jpg', '2014-07-24 20:57:41', '2014-07-24 20:57:41'),
(20, 4, 8, 'Gabardina pinzas niño', '1132.35', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/gabardina-pinzas.jpg', '2014-07-24 20:58:25', '2014-07-24 20:58:25'),
(21, 4, 8, 'Gabardina pinzas niño', '1187.52', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/gabardina-pinzas.jpg', '2014-07-24 20:59:17', '2014-07-24 20:59:17'),
(22, 4, 9, 'Chaqueta con capucha', '1163.53', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/21.png', '2014-07-24 21:00:30', '2014-07-24 21:00:30'),
(23, 4, 9, 'Chaqueta con capucha', '1259.50', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/21.png', '2014-07-24 21:01:25', '2014-07-24 21:01:25'),
(24, 3, 10, 'Franela blanca', '254.75', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/franela2.jpg', '0000-00-00 00:00:00', '2014-07-25 02:25:31'),
(25, 3, 10, 'Franela blanca', '300.39', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/franela2.jpg', '0000-00-00 00:00:00', '2014-07-25 02:16:55'),
(26, 3, 10, 'Franela blanca', '363.37', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/franela3.jpg', '0000-00-00 00:00:00', '2014-07-25 02:17:29'),
(27, 3, 10, 'Franela amarilla', '259.99', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/franela2.jpg', '0000-00-00 00:00:00', '2014-07-25 02:25:48'),
(28, 3, 10, 'Franela roja', '264.93', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/franela3.jpg', '0000-00-00 00:00:00', '2014-07-25 02:26:17'),
(29, 3, 6, 'Chemise blanca', '600.36', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino6.png', '2014-07-24 21:53:10', '2014-07-24 21:53:10'),
(30, 3, 6, 'Chemise blanca', '734.67', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino6.png', '2014-07-24 21:53:56', '2014-07-24 21:53:56'),
(31, 3, 6, 'Chemise blanca', '818.50', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino6.png', '2014-07-24 22:11:40', '2014-07-24 22:11:40'),
(32, 3, 6, 'Chemise azul - beige', '818.50', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino6.png', '2014-07-24 22:12:27', '2014-07-24 22:12:27'),
(33, 3, 6, 'Chemise azul - beige', '818.50', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino6.png', '2014-07-24 22:13:43', '2014-07-24 22:13:43'),
(34, 3, 6, 'Chemise (Niña)', '689.46', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino11.png', '2014-07-24 22:14:58', '2014-07-24 22:14:58'),
(35, 3, 7, 'Mono algodón', '766.56', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino12.png', '2014-07-24 22:18:00', '2014-07-24 22:18:00'),
(36, 3, 7, 'Mono algodón', '865.35', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino12.png', '2014-07-24 22:18:48', '2014-07-24 22:18:48'),
(37, 3, 7, 'Mono algodón', '1086.62', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino12.png', '2014-07-24 22:19:51', '2014-07-24 22:19:51'),
(38, 3, 8, 'Gabardina sin pinzas niño', '1332.17', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino15.png', '0000-00-00 00:00:00', '2014-07-24 22:22:31'),
(39, 3, 8, 'Gabardina sin pinzas niño', '1397.09', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino15.png', '2014-07-24 22:23:28', '2014-07-24 22:23:28'),
(40, 3, 8, 'Gabardina fashion niño azul', '1332.17', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino15.png', '2014-07-24 22:26:03', '2014-07-24 22:26:03'),
(41, 3, 11, 'Suéter sin capucha', '1481.76', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino18.png', '2014-07-24 23:00:03', '2014-07-24 23:00:03'),
(42, 3, 12, 'Falda de gabardina 4 tachones', '993.48', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino19.png', '0000-00-00 00:00:00', '2014-07-24 23:37:24'),
(43, 3, 12, 'Falda de gabardina 4 tachones', '1044.29', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino19.png', '0000-00-00 00:00:00', '2014-07-24 23:37:30'),
(44, 3, 12, 'Falda de gabardina 4 tachones', '1095.09', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino19.png', '0000-00-00 00:00:00', '2014-07-24 23:37:35'),
(45, 3, 12, 'Falda short', '879.00', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino22.png', '2014-07-24 23:37:06', '2014-07-24 23:37:06'),
(46, 3, 12, 'Falda short', '984.77', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino22.png', '2014-07-24 23:38:23', '2014-07-24 23:38:23'),
(47, 3, 8, 'Gabardina pinzas niño', '1408.38', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino24.png', '2014-07-24 23:40:34', '2014-07-24 23:40:34'),
(48, 3, 8, 'Gabardina pinzas niño', '1332.17', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino24.png', '2014-07-24 23:45:36', '2014-07-24 23:45:36'),
(49, 3, 8, 'Gabardina pinzas niño', '1397.09', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino24.png', '2014-07-24 23:47:11', '2014-07-24 23:47:11'),
(50, 3, 13, 'Pantalón poliester niño', '1044.29', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/pantalon-poliester.jpg', '2014-07-24 23:52:07', '2014-07-24 23:52:07'),
(51, 3, 13, 'Pantalón poliester niño', '1144.85', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/pantalon-poliester.jpg', '2014-07-24 23:53:36', '2014-07-24 23:53:36'),
(52, 3, 13, 'Pantalón poliester niño', '1199.52', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/pantalon-poliester.jpg', '2014-07-24 23:54:33', '2014-07-24 23:54:33'),
(53, 3, 8, 'Gabardina pinzas niña', '1332.17', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino24.png', '0000-00-00 00:00:00', '2014-07-24 23:57:54'),
(54, 3, 8, 'Gabardina pinzas niña', '1408.38', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino24.png', '0000-00-00 00:00:00', '2014-07-24 23:58:25'),
(55, 3, 8, 'Gabardina pinzas niña', '1397.09', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino24.png', '2014-07-25 00:23:01', '2014-07-25 00:23:01'),
(56, 3, 8, 'Gabardina engomado', '1267.26', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino24.png', '2014-07-25 00:24:45', '2014-07-25 00:24:45'),
(57, 3, 8, 'Gabardina engomado', '1332.17', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino24.png', '2014-07-25 00:25:12', '2014-07-25 00:25:12'),
(58, 3, 8, 'Gabardina engomado', '1397.09', 'http://bodeven.com.ve/web/resources/uploads/24-07-2014/bambino24.png', '2014-07-25 00:25:34', '2014-07-25 00:25:34'),
(59, 5, 13, 'Pantalón poliester niño', '1044.29', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer9.png', '0000-00-00 00:00:00', '2014-07-25 00:59:23'),
(60, 5, 13, 'Pantalón poliester niño', '1.114,85', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer9.png', '0000-00-00 00:00:00', '2014-07-25 00:59:38'),
(61, 5, 13, 'Pantalón poliester niño', '1.199,52', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer9.png', '0000-00-00 00:00:00', '2014-07-25 00:59:53'),
(62, 5, 7, 'Mono algodón', '766,56', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer4.png', '2014-07-25 01:07:10', '2014-07-25 01:07:10'),
(63, 5, 7, 'Mono algodón', '865,35', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer4.png', '2014-07-25 01:07:24', '2014-07-25 01:07:24'),
(64, 5, 7, 'Mono algodón', '1.086,62', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer4.png', '2014-07-25 01:07:40', '2014-07-25 01:07:40'),
(65, 5, 7, 'Mono bota recta Suplex', '962,44', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer7.png', '2014-07-25 01:09:04', '2014-07-25 01:09:04'),
(66, 5, 7, 'Mono bota recta Suplex', '1044.29', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer7.png', '2014-07-25 01:09:25', '2014-07-25 01:09:25'),
(67, 5, 8, 'Gabardina engomado', '1267.26', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer9.png', '2014-07-25 01:11:51', '2014-07-25 01:11:51'),
(68, 5, 8, 'Gabardina engomado', '1332.17', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer9.png', '2014-07-25 01:12:18', '2014-07-25 01:12:18'),
(69, 5, 8, 'Gabardina engomado', '1397.09', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer9.png', '2014-07-25 01:12:38', '2014-07-25 01:12:38'),
(70, 5, 8, 'Gabardina pinzas niño', '1408.38', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer12.png', '0000-00-00 00:00:00', '2014-07-25 01:25:26'),
(71, 5, 8, 'Gabardina pinzas niño', '1332.17', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer12.png', '0000-00-00 00:00:00', '2014-07-25 01:25:31'),
(72, 5, 8, 'Gabardina pinzas niño', '1397.09', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer12.png', '0000-00-00 00:00:00', '2014-07-25 01:25:36'),
(73, 5, 8, 'Gabardina pinzas niña', '1408.38', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer15.png', '2014-07-25 01:35:09', '2014-07-25 01:35:09'),
(74, 5, 8, 'Gabardina pinzas niña', '1332.17', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer15.png', '2014-07-25 01:36:03', '2014-07-25 01:36:03'),
(75, 5, 8, 'Gabardina pinzas niña', '1397.09', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer15.png', '2014-07-25 01:36:28', '2014-07-25 01:36:28'),
(76, 5, 9, 'Chaqueta sin y con capucha', '1368.86', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer18.png', '2014-07-25 01:40:27', '2014-07-25 01:40:27'),
(77, 5, 9, 'Chaqueta sin y con capucha', '1481.76', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer18.png', '2014-07-25 01:40:49', '2014-07-25 01:40:49'),
(78, 5, 12, 'Falda de gabardina 4 tachones', '993.48', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer20.png', '2014-07-25 01:48:23', '2014-07-25 01:48:23'),
(79, 5, 12, 'Falda de gabardina 4 tachones', '1044.29', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer20.png', '2014-07-25 01:51:42', '2014-07-25 01:51:42'),
(80, 5, 12, 'Falda de gabardina 4 tachones', '1095.09', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer20.png', '2014-07-25 01:52:25', '2014-07-25 01:52:25'),
(81, 5, 13, 'Pantalón pretina ancha strech niña', '1232.00', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer23.png', '2014-07-25 01:55:02', '2014-07-25 01:55:02'),
(82, 5, 13, 'Pantalón pretina ancha strech niña', '1344.00', 'http://bodeven.com.ve/web/resources/uploads/25-07-2014/maiquer23.png', '2014-07-25 01:58:24', '2014-07-25 01:58:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `providers`
--

CREATE TABLE IF NOT EXISTS `providers` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `providers`
--

INSERT INTO `providers` (`id`, `name`, `created`, `updated`) VALUES
(3, 'Bambino', '2014-07-24 06:12:36', '2014-07-24 06:12:36'),
(4, 'Confecciones propias', '2014-07-24 18:15:47', '2014-07-24 18:15:47'),
(5, 'Maiquer', '2014-07-25 00:54:45', '2014-07-25 00:54:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sizes`
--

CREATE TABLE IF NOT EXISTS `sizes` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `product_id` int(255) NOT NULL,
  `size` varchar(10) NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `perfil_id` int(255) NOT NULL,
  `estatus_id` int(255) NOT NULL,
  `name` text COLLATE utf8_spanish2_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `perfil_id` (`perfil_id`),
  KEY `estatus_id` (`estatus_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `perfil_id`, `estatus_id`, `name`, `username`, `password`, `email`, `created`, `updated`) VALUES
(1, 1, 1, 'Ramón Serrano', 'RamEduard', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg==', 'ramon.calle.88@gmail.com', '2014-02-22 22:31:00', '2014-07-08 02:58:25'),
(5, 2, 1, 'Ramon Serrano', 'admin', 'nhDr7OyKlXQju+Ge/WKGrPQ9lPBSUFfpK+B1xqx/+8zLZqRNX0+5G1zBQklXUFy86lCpkAofsExlXiorUcKSNQ==', 'ramon.calle.88@gmail.com', '2014-06-14 16:03:50', '2014-07-25 21:52:27'),
(6, 3, 1, 'Ramon Serrano', 'prueba', 'e8rq7FOtPi5vQuQ1regdeG3UC57KM6OzVwDBgr+JtgolGjYHVDz8MLlBU2iNnNu395rdPVq0gF/IHqHhhiYeew==', 'prueba@bodeven', '2014-07-25 12:01:39', '2014-07-25 16:31:39');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
