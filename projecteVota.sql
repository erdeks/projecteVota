-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 20, 2017 at 05:11 PM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projecteVota`
--
CREATE DATABASE IF NOT EXISTS `projecteVota` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `projecteVota`;

-- --------------------------------------------------------

--
-- Table structure for table `accesoEncuestas`
--

DROP TABLE IF EXISTS `accesoEncuestas`;
CREATE TABLE `accesoEncuestas` (
  `idAcceso` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idEncuestas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

--
-- Truncate table before insert `accesoEncuestas`
--

TRUNCATE TABLE `accesoEncuestas`;
-- --------------------------------------------------------

--
-- Table structure for table `encuestas`
--

DROP TABLE IF EXISTS `encuestas`;
CREATE TABLE `encuestas` (
  `idEncuestas` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `nombre` int(50) NOT NULL,
  `multirespuesta` tinyint(1) NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncate table before insert `encuestas`
--

TRUNCATE TABLE `encuestas`;
-- --------------------------------------------------------

--
-- Table structure for table `opcionesEncuestas`
--

DROP TABLE IF EXISTS `opcionesEncuestas`;
CREATE TABLE `opcionesEncuestas` (
  `idOpciones` int(11) NOT NULL,
  `idEncuestas` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncate table before insert `opcionesEncuestas`
--

TRUNCATE TABLE `opcionesEncuestas`;
-- --------------------------------------------------------

--
-- Table structure for table `permisos`
--

DROP TABLE IF EXISTS `permisos`;
CREATE TABLE `permisos` (
  `idPermisos` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncate table before insert `permisos`
--

TRUNCATE TABLE `permisos`;
--
-- Dumping data for table `permisos`
--

INSERT INTO `permisos` (`idPermisos`, `nombre`, `descripcion`) VALUES
(1, 'Invitado', 'Persona invitada sin estar registrada'),
(2, 'Normal', 'Persona registrada'),
(3, 'Admin', 'Administrador de la pagina');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `idPermisos` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(40) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncate table before insert `usuarios`
--

TRUNCATE TABLE `usuarios`;
-- --------------------------------------------------------

--
-- Table structure for table `votosEncuestas`
--

DROP TABLE IF EXISTS `votosEncuestas`;
CREATE TABLE `votosEncuestas` (
  `idVotos` int(11) NOT NULL,
  `idOpciones` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncate table before insert `votosEncuestas`
--

TRUNCATE TABLE `votosEncuestas`;
--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesoEncuestas`
--
ALTER TABLE `accesoEncuestas`
  ADD PRIMARY KEY (`idAcceso`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idEncuestas` (`idEncuestas`);

--
-- Indexes for table `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`idEncuestas`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indexes for table `opcionesEncuestas`
--
ALTER TABLE `opcionesEncuestas`
  ADD PRIMARY KEY (`idOpciones`),
  ADD KEY `idEncuestas` (`idEncuestas`);

--
-- Indexes for table `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`idPermisos`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idPermisos` (`idPermisos`);

--
-- Indexes for table `votosEncuestas`
--
ALTER TABLE `votosEncuestas`
  ADD PRIMARY KEY (`idVotos`),
  ADD KEY `idOpciones` (`idOpciones`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesoEncuestas`
--
ALTER TABLE `accesoEncuestas`
  MODIFY `idAcceso` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `idEncuestas` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `opcionesEncuestas`
--
ALTER TABLE `opcionesEncuestas`
  MODIFY `idOpciones` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idPermisos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `votosEncuestas`
--
ALTER TABLE `votosEncuestas`
  MODIFY `idVotos` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `accesoEncuestas`
--
ALTER TABLE `accesoEncuestas`
  ADD CONSTRAINT `accesoEncuestas_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `accesoEncuestas_ibfk_2` FOREIGN KEY (`idEncuestas`) REFERENCES `encuestas` (`idEncuestas`);

--
-- Constraints for table `encuestas`
--
ALTER TABLE `encuestas`
  ADD CONSTRAINT `encuestas_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`);

--
-- Constraints for table `opcionesEncuestas`
--
ALTER TABLE `opcionesEncuestas`
  ADD CONSTRAINT `opcionesEncuestas_ibfk_1` FOREIGN KEY (`idEncuestas`) REFERENCES `encuestas` (`idEncuestas`);

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idPermisos`) REFERENCES `permisos` (`idPermisos`);

--
-- Constraints for table `votosEncuestas`
--
ALTER TABLE `votosEncuestas`
  ADD CONSTRAINT `votosEncuestas_ibfk_1` FOREIGN KEY (`idOpciones`) REFERENCES `opcionesEncuestas` (`idOpciones`),
  ADD CONSTRAINT `votosEncuestas_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
