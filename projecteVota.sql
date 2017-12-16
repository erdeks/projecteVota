-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 16-12-2017 a las 21:25:23
-- Versión del servidor: 5.7.20-0ubuntu0.16.04.1
-- Versión de PHP: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `projecteVota`
--
CREATE DATABASE IF NOT EXISTS `projecteVota` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `projecteVota`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesoEncuestas`
--

DROP TABLE IF EXISTS `accesoEncuestas`;
CREATE TABLE `accesoEncuestas` (
  `idAcceso` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idEncuesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

DROP TABLE IF EXISTS `encuestas`;
CREATE TABLE `encuestas` (
  `idEncuesta` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `multirespuesta` tinyint(1) NOT NULL DEFAULT '0',
  `descripcion` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `inicio` datetime NOT NULL,
  `fin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcionesEncuestas`
--

DROP TABLE IF EXISTS `opcionesEncuestas`;
CREATE TABLE `opcionesEncuestas` (
  `idOpcion` int(11) NOT NULL,
  `idEncuesta` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

DROP TABLE IF EXISTS `permisos`;
CREATE TABLE `permisos` (
  `idPermiso` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`idPermiso`, `nombre`, `descripcion`) VALUES
(1, 'No registrado', 'Persona invitada sin estar registrada'),
(2, 'Normal', 'Persona registrada'),
(3, 'Admin', 'Administrador de la pagina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `idPermiso` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `validado` tinyint(1) NOT NULL DEFAULT '0',
  `validando` tinyint(1) NOT NULL DEFAULT '0',
  `cambiarPassword` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votosEncuestas`
--

DROP TABLE IF EXISTS `votosEncuestas`;
CREATE TABLE `votosEncuestas` (
  `hash` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `idOpcion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votosEncuestasEncriptado`
--

DROP TABLE IF EXISTS `votosEncuestasEncriptado`;
CREATE TABLE `votosEncuestasEncriptado` (
  `idVoto` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `hashEncriptado` varbinary(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesoEncuestas`
--
ALTER TABLE `accesoEncuestas`
  ADD PRIMARY KEY (`idAcceso`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idEncuestas` (`idEncuesta`);

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`idEncuesta`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `opcionesEncuestas`
--
ALTER TABLE `opcionesEncuestas`
  ADD PRIMARY KEY (`idOpcion`),
  ADD KEY `idEncuestas` (`idEncuesta`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`idPermiso`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idPermisos` (`idPermiso`),
  ADD KEY `email_2` (`email`);

--
-- Indices de la tabla `votosEncuestas`
--
ALTER TABLE `votosEncuestas`
  ADD PRIMARY KEY (`hash`),
  ADD KEY `idOpcion` (`idOpcion`);

--
-- Indices de la tabla `votosEncuestasEncriptado`
--
ALTER TABLE `votosEncuestasEncriptado`
  ADD PRIMARY KEY (`idVoto`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accesoEncuestas`
--
ALTER TABLE `accesoEncuestas`
  MODIFY `idAcceso` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `idEncuesta` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `opcionesEncuestas`
--
ALTER TABLE `opcionesEncuestas`
  MODIFY `idOpcion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idPermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `votosEncuestasEncriptado`
--
ALTER TABLE `votosEncuestasEncriptado`
  MODIFY `idVoto` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accesoEncuestas`
--
ALTER TABLE `accesoEncuestas`
  ADD CONSTRAINT `accesoEncuestas_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `accesoEncuestas_ibfk_2` FOREIGN KEY (`idEncuesta`) REFERENCES `encuestas` (`idEncuesta`);

--
-- Filtros para la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD CONSTRAINT `encuestas_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `opcionesEncuestas`
--
ALTER TABLE `opcionesEncuestas`
  ADD CONSTRAINT `opcionesEncuestas_ibfk_1` FOREIGN KEY (`idEncuesta`) REFERENCES `encuestas` (`idEncuesta`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idPermiso`) REFERENCES `permisos` (`idPermiso`);

--
-- Filtros para la tabla `votosEncuestas`
--
ALTER TABLE `votosEncuestas`
  ADD CONSTRAINT `votosEncuestas_ibfk_1` FOREIGN KEY (`idOpcion`) REFERENCES `opcionesEncuestas` (`idOpcion`);

--
-- Filtros para la tabla `votosEncuestasEncriptado`
--
ALTER TABLE `votosEncuestasEncriptado`
  ADD CONSTRAINT `votosEncuestasEncriptado_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `accesoEncuestas` (`idUsuario`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
