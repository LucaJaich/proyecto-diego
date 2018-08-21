-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 11-08-2018 a las 14:21:38
-- Versión del servidor: 10.2.16-MariaDB
-- Versión de PHP: 7.1.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u853587864_ortp`
--
CREATE DATABASE IF NOT EXISTS `u853587864_ortp` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `u853587864_ortp`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncios`
--

CREATE TABLE `anuncios` (
  `id_anuncio` int(33) NOT NULL,
  `anuncio` varchar(240) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` int(33) NOT NULL,
  `time_stamp` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aptos`
--

CREATE TABLE `aptos` (
  `id_apto` int(33) NOT NULL,
  `persona` int(33) NOT NULL,
  `fecha` date NOT NULL,
  `micosis` int(1) NOT NULL,
  `pediculosis` int(1) NOT NULL,
  `otros` int(1) NOT NULL,
  `saf` int(1) NOT NULL,
  `notas` varchar(280) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usuario` int(33) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aptos_higienicos`
--

CREATE TABLE `aptos_higienicos` (
  `id_apto_higienico` int(33) NOT NULL,
  `persona` int(33) NOT NULL,
  `usuario` int(33) NOT NULL,
  `time_stamp` timestamp NOT NULL,
  `pediculosis` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `micosis` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `otras` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `notas` varchar(240) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `aptos_higienicos`
--

INSERT INTO `aptos_higienicos` (`id_apto_higienico`, `persona`, `usuario`, `time_stamp`, `pediculosis`, `micosis`, `otras`, `notas`) VALUES
(18, 2, 2, '2018-06-02 23:39:56', 'si', 'no', 'no', ''),
(19, 3, 2, '2018-06-03 23:40:34', 'no', 'si', 'no', ''),
(20, 2, 2, '2018-06-04 00:02:16', 'no', 'no', 'no', ''),
(21, 2, 2, '2018-06-04 02:13:19', 'no', 'si', 'no', ''),
(22, 2, 2, '2018-06-04 02:13:34', 'si', 'si', 'no', ''),
(23, 2, 2, '2018-06-04 02:13:39', 'no', 'no', 'no', ''),
(24, 1, 2, '2018-06-04 13:23:55', 'no', 'si', 'no', ''),
(25, 5, 2, '2018-06-04 13:24:02', 'no', 'no', 'no', ''),
(26, 4, 5, '2018-06-04 16:18:54', 'si', 'si', 'no', ''),
(27, 4, 5, '2018-06-04 16:18:57', 'si', 'si', 'no', ''),
(28, 2, 5, '2018-06-04 16:19:23', 'no', 'no', 'si', ''),
(29, 6, 2, '2018-06-05 15:54:04', 'no', 'no', 'no', ''),
(30, 1, 2, '2018-06-05 15:54:09', 'no', 'no', 'no', ''),
(31, 7, 2, '2018-06-05 15:54:14', 'no', 'no', 'no', ''),
(32, 2, 5, '2018-06-06 12:46:39', 'no', 'si', 'si', ''),
(33, 2, 2, '2018-08-07 15:55:39', 'no', 'no', 'no', ''),
(34, 2, 2, '2018-08-09 18:06:07', 'si', 'no', 'no', ''),
(35, 3, 2, '2018-08-10 12:50:06', 'si', 'no', 'no', ''),
(36, 2, 2, '2018-08-10 12:54:50', 'no', 'no', 'no', ''),
(37, 2, 2, '2018-08-10 23:55:00', 'no', 'no', 'no', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id_grupo` int(33) NOT NULL,
  `identificador` varchar(28) COLLATE utf8_unicode_ci NOT NULL,
  `docente` varchar(56) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id_grupo`, `identificador`, `docente`) VALUES
(1, '1A-2018', 'Marilina'),
(2, '2B-2018', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(33) NOT NULL,
  `nombres` varchar(46) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(46) COLLATE utf8_unicode_ci NOT NULL,
  `legajo` varchar(22) COLLATE utf8_unicode_ci NOT NULL,
  `grupo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` int(33) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `nombres`, `apellidos`, `legajo`, `grupo`, `usuario`) VALUES
(1, 'Jose', 'Perez', '33333', '1A-2018', 2),
(2, 'Josefina', 'Gomez', '44444', '1A-2018', 2),
(3, 'Carlos', 'Gonzalez', '77777', '1A-2018', 2),
(4, 'Pedro', 'Garcia', '99999', '2B-2018', 3),
(5, 'Luke', 'Skywalker', '22222', '1A-2018', 2),
(6, 'Rick', 'Sanchez', '34567', '1A-2018', 2),
(7, 'Morty', 'Smith', '23675', '1A-2018', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(33) NOT NULL,
  `usuario` varchar(46) COLLATE utf8_unicode_ci NOT NULL,
  `contrasena` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `nivel` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario`, `contrasena`, `nivel`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 5),
(2, 'diego.garcia', '81dc9bdb52d04dc20036dbd8313ed055', 5),
(3, 'claudio.brunetti', '81dc9bdb52d04dc20036dbd8313ed055', 4),
(4, 'patricio.neilan', '81dc9bdb52d04dc20036dbd8313ed055', 4),
(5, 'gabriel.arambel', '81dc9bdb52d04dc20036dbd8313ed055', 5);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  ADD PRIMARY KEY (`id_anuncio`);

--
-- Indices de la tabla `aptos`
--
ALTER TABLE `aptos`
  ADD PRIMARY KEY (`id_apto`);

--
-- Indices de la tabla `aptos_higienicos`
--
ALTER TABLE `aptos_higienicos`
  ADD PRIMARY KEY (`id_apto_higienico`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  MODIFY `id_anuncio` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `aptos`
--
ALTER TABLE `aptos`
  MODIFY `id_apto` int(33) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aptos_higienicos`
--
ALTER TABLE `aptos_higienicos`
  MODIFY `id_apto_higienico` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id_grupo` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;