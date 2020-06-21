-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-06-2020 a las 17:58:14
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdapp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo`
--

CREATE TABLE `catalogo` (
  `codigo` varchar(8) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `catalogo`
--

INSERT INTO `catalogo` (`codigo`, `nombre`) VALUES
('10101501', 'GATOS'),
('10101502', 'PERROS'),
('10101504', 'VISÓN'),
('10101505', 'RATAS'),
('10101507', 'OVEJAS'),
('10101508', 'CABRAS'),
('10101509', 'ASNOS'),
('10101510', 'RATONES'),
('10101511', 'CERDOS'),
('10101512', 'CONEJOS'),
('10101513', 'COBAYAS O CONEJILLOS DE INDIAS'),
('10101514', 'PRIMATES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_created_at` int(11) DEFAULT NULL,
  `id_updated_at` int(11) DEFAULT NULL,
  `id_deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `idempresa`, `codigo`, `nombre`, `created_at`, `updated_at`, `deleted_at`, `id_created_at`, `id_updated_at`, `id_deleted_at`) VALUES
(1, 1, 'Gaseosas', 'Gaseosas', '2020-05-18 19:11:59', '2020-05-18 19:12:27', NULL, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id` char(2) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id`, `nombre`) VALUES
('03', 'APURIMAC'),
('07', 'CALLAO'),
('15', 'LIMA'),
('17', 'MADRE DE DIOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distrito`
--

CREATE TABLE `distrito` (
  `id` char(6) NOT NULL,
  `codigo` char(4) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `distrito`
--

INSERT INTO `distrito` (`id`, `codigo`, `nombre`) VALUES
('150101', '1501', 'LIMA'),
('150102', '1501', 'ANCON'),
('150103', '1501', 'ATE'),
('150104', '1501', 'BARRANCO'),
('150105', '1501', 'BREÑA'),
('150106', '1501', 'CARABAYLLO'),
('150107', '1501', 'CHACLACAYO'),
('150108', '1501', 'CHORRILLOS'),
('170101', '1701', 'TAMBOPATA'),
('170102', '1701', 'INAMBARI'),
('170103', '1701', 'LAS PIEDRAS'),
('170104', '1701', 'LABERINTO'),
('170201', '1702', 'MANU'),
('170202', '1702', 'FITZCARRALD'),
('170203', '1702', 'MADRE DE DIOS'),
('170204', '1702', 'HUEPETUHE'),
('170301', '1703', 'IÑAPARI'),
('170302', '1703', 'IBERIA'),
('170303', '1703', 'TAHUAMANU');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `iddocumento` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `abreviatura` varchar(20) DEFAULT NULL,
  `codigosunat` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `documento`
--

INSERT INTO `documento` (`iddocumento`, `nombre`, `abreviatura`, `codigosunat`) VALUES
(1, 'DOCUMENTO  NACIONAL DE IDENTIDAD', 'DNI', '1'),
(2, 'REG. UNICO DE CONTRIBUYENTES', 'RUC', '6'),
(3, 'PASAPORTE', 'PASAPORTE', '7'),
(4, 'CARNET DE EXTRANJERIA', 'CARNET EXT.', '4'),
(5, 'VARIOS - VENTAS MENORES A S/.700.00 Y OTROS', 'VARIOS ', '-'),
(6, 'NO DOMICILIADO, SIN RUC (EXPORTACIÓN)', 'SIN RUC', '0'),
(7, 'CÉDULA DIPLOMÁTICA DE IDENTIDAD', 'CEDULA DIP.', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentofiscal`
--

CREATE TABLE `documentofiscal` (
  `iddocumentofiscal` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text,
  `tipo` char(1) DEFAULT NULL COMMENT '1:Venta 2:Almacen 3:OtrosIyE',
  `codigosunat` char(2) DEFAULT NULL,
  `codigopse` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `documentofiscal`
--

INSERT INTO `documentofiscal` (`iddocumentofiscal`, `nombre`, `descripcion`, `tipo`, `codigosunat`, `codigopse`) VALUES
(1, 'Factura', NULL, '1', '01', '1'),
(2, 'Boleta de venta', NULL, '1', '03', '2'),
(3, 'Recibo honorario', NULL, '1', '02', NULL),
(4, 'Recibo interno', NULL, '1', NULL, NULL),
(5, 'Guia de entrada almacén', NULL, '2', NULL, NULL),
(6, 'Guia de salida almacén', NULL, '2', NULL, NULL),
(7, 'Boleta', NULL, '3', NULL, NULL),
(8, 'Factura', NULL, '3', NULL, NULL),
(9, 'Recibo interno', NULL, '3', NULL, NULL),
(10, 'Nota de débito', NULL, '1', '08', '4'),
(11, 'R.H. Electrónico', NULL, '1', '02', NULL),
(12, 'Recibo por servicios', NULL, '3', NULL, NULL),
(13, 'Nota de crédito', NULL, '1', '07', '3'),
(14, 'Orden de compra', NULL, '4', NULL, NULL),
(15, 'Cheque', NULL, '3', NULL, NULL),
(16, 'Retiros', NULL, '3', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentoserie`
--

CREATE TABLE `documentoserie` (
  `iddocumentoserie` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `idsede` int(11) DEFAULT NULL,
  `iddocumentofiscal` int(11) NOT NULL,
  `serie` varchar(5) NOT NULL,
  `numero` int(11) DEFAULT NULL,
  `contingencia` char(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_created_at` int(11) DEFAULT NULL,
  `id_updated_at` int(11) DEFAULT NULL,
  `id_deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `documentoserie`
--

INSERT INTO `documentoserie` (`iddocumentoserie`, `idempresa`, `idsede`, `iddocumentofiscal`, `serie`, `numero`, `contingencia`, `created_at`, `updated_at`, `deleted_at`, `id_created_at`, `id_updated_at`, `id_deleted_at`) VALUES
(1, 1, 1, 2, 'B001', 3, '0', '2020-05-17 01:30:13', '2020-05-17 15:50:26', '2020-05-17 15:50:26', 78, 1, NULL),
(2, 1, 1, 13, 'B001', 1, '0', '2020-05-17 01:30:13', '2020-05-17 15:50:26', '2020-05-17 15:50:26', 78, 78, NULL),
(3, 1, 1, 1, 'F001', 1, '0', '2020-05-17 01:30:13', '2020-05-17 15:50:26', '2020-05-17 15:50:26', 78, 78, NULL),
(4, 1, 1, 13, 'F001', 1, '0', '2020-05-17 01:30:13', '2020-05-17 15:50:26', '2020-05-17 15:50:26', 78, 78, NULL),
(5, 1, 1, 2, 'B001', 4, '0', '2020-05-17 15:50:26', '2020-05-17 15:54:22', '2020-05-17 15:54:22', 78, 1, NULL),
(6, 1, 1, 13, 'B001', 1, '0', '2020-05-17 15:50:26', '2020-05-17 15:54:22', '2020-05-17 15:54:22', 78, 78, NULL),
(7, 1, 1, 1, 'F001', 1, '0', '2020-05-17 15:50:26', '2020-05-17 15:54:22', '2020-05-17 15:54:22', 78, 78, NULL),
(8, 1, 1, 13, 'F001', 1, '0', '2020-05-17 15:50:26', '2020-05-17 15:54:22', '2020-05-17 15:54:22', 78, 78, NULL),
(9, 1, 1, 2, 'B001', 5, '0', '2020-05-17 15:54:22', '2020-05-17 15:58:45', '2020-05-17 15:58:45', 78, 1, NULL),
(10, 1, 1, 13, 'B001', 1, '0', '2020-05-17 15:54:22', '2020-05-17 15:58:45', '2020-05-17 15:58:45', 78, 78, NULL),
(11, 1, 1, 1, 'F001', 1, '0', '2020-05-17 15:54:22', '2020-05-17 15:58:45', '2020-05-17 15:58:45', 78, 78, NULL),
(12, 1, 1, 13, 'F001', 1, '0', '2020-05-17 15:54:22', '2020-05-17 15:58:45', '2020-05-17 15:58:45', 78, 78, NULL),
(13, 1, 1, 2, 'B001', 8, '0', '2020-05-17 15:58:45', '2020-05-17 16:03:45', '2020-05-17 16:03:45', 78, 1, NULL),
(14, 1, 1, 13, 'B001', 1, '0', '2020-05-17 15:58:45', '2020-05-17 16:03:45', '2020-05-17 16:03:45', 78, 78, NULL),
(15, 1, 1, 1, 'F001', 1, '0', '2020-05-17 15:58:45', '2020-05-17 16:03:45', '2020-05-17 16:03:45', 78, 78, NULL),
(16, 1, 1, 13, 'F001', 1, '0', '2020-05-17 15:58:45', '2020-05-17 16:03:45', '2020-05-17 16:03:45', 78, 78, NULL),
(17, 1, 1, 2, 'B001', 9, '0', '2020-05-17 16:03:45', '2020-05-17 16:04:22', '2020-05-17 16:04:22', 78, 1, NULL),
(18, 1, 1, 13, 'B001', 1, '0', '2020-05-17 16:03:45', '2020-05-17 16:04:22', '2020-05-17 16:04:22', 78, 78, NULL),
(19, 1, 1, 1, 'F001', 1, '0', '2020-05-17 16:03:45', '2020-05-17 16:04:22', '2020-05-17 16:04:22', 78, 78, NULL),
(20, 1, 1, 13, 'F001', 1, '0', '2020-05-17 16:03:45', '2020-05-17 16:04:22', '2020-05-17 16:04:22', 78, 78, NULL),
(21, 1, 1, 2, 'B001', 10, '0', '2020-05-17 16:04:22', '2020-05-18 18:48:41', '2020-05-18 18:48:41', 78, 1, NULL),
(22, 1, 1, 13, 'B001', 1, '0', '2020-05-17 16:04:22', '2020-05-18 18:48:41', '2020-05-18 18:48:41', 78, 78, NULL),
(23, 1, 1, 1, 'F001', 1, '0', '2020-05-17 16:04:22', '2020-05-18 18:48:41', '2020-05-18 18:48:41', 78, 78, NULL),
(24, 1, 1, 13, 'F001', 1, '0', '2020-05-17 16:04:22', '2020-05-18 18:48:41', '2020-05-18 18:48:41', 78, 78, NULL),
(25, 2, 2, 2, 'B001', 1, '0', '2020-05-17 16:15:19', '2020-05-17 16:15:19', NULL, 78, 78, NULL),
(26, 2, 2, 13, 'B001', 1, '0', '2020-05-17 16:15:19', '2020-05-17 16:15:19', NULL, 78, 78, NULL),
(27, 2, 2, 1, 'F001', 1, '0', '2020-05-17 16:15:19', '2020-05-17 16:15:19', NULL, 78, 78, NULL),
(28, 2, 2, 13, 'F001', 1, '0', '2020-05-17 16:15:19', '2020-05-17 16:15:19', NULL, 78, 78, NULL),
(29, 1, 1, 2, 'B001', 10, '0', '2020-05-18 18:48:42', '2020-05-18 18:50:08', '2020-05-18 18:50:08', 78, 78, NULL),
(30, 1, 1, 13, 'B001', 1, '0', '2020-05-18 18:48:42', '2020-05-18 18:50:08', '2020-05-18 18:50:08', 78, 78, NULL),
(31, 1, 1, 1, 'F001', 1, '0', '2020-05-18 18:48:42', '2020-05-18 18:50:08', '2020-05-18 18:50:08', 78, 78, NULL),
(32, 1, 1, 13, 'F001', 1, '0', '2020-05-18 18:48:42', '2020-05-18 18:50:08', '2020-05-18 18:50:08', 78, 78, NULL),
(33, 1, 3, 2, 'B002', 1, '0', '2020-05-18 18:49:39', '2020-05-18 18:50:20', '2020-05-18 18:50:20', 78, 78, NULL),
(34, 1, 1, 2, 'B001', 17, '0', '2020-05-18 18:50:08', '2020-05-25 10:52:04', '2020-05-25 10:52:04', 78, 1, NULL),
(35, 1, 1, 13, 'B001', 1, '0', '2020-05-18 18:50:08', '2020-05-25 10:52:04', '2020-05-25 10:52:04', 78, 78, NULL),
(36, 1, 1, 1, 'F001', 1, '0', '2020-05-18 18:50:08', '2020-05-25 10:52:04', '2020-05-25 10:52:04', 78, 78, NULL),
(37, 1, 1, 13, 'F001', 1, '0', '2020-05-18 18:50:08', '2020-05-25 10:52:04', '2020-05-25 10:52:04', 78, 78, NULL),
(38, 1, 3, 2, 'B002', 1, '0', '2020-05-18 18:50:20', '2020-05-25 12:14:52', '2020-05-25 12:14:52', 78, 78, NULL),
(39, 1, 1, 2, 'B001', 17, '0', '2020-05-25 10:52:04', '2020-05-25 12:13:08', '2020-05-25 12:13:08', 78, 78, NULL),
(40, 1, 1, 13, 'B001', 1, '0', '2020-05-25 10:52:04', '2020-05-25 12:13:08', '2020-05-25 12:13:08', 78, 78, NULL),
(41, 1, 1, 1, 'F001', 1, '0', '2020-05-25 10:52:04', '2020-05-25 12:13:08', '2020-05-25 12:13:08', 78, 78, NULL),
(42, 1, 1, 13, 'F001', 1, '0', '2020-05-25 10:52:04', '2020-05-25 12:13:08', '2020-05-25 12:13:08', 78, 78, NULL),
(43, 1, 1, 2, 'B001', 19, '0', '2020-05-25 12:13:08', '2020-05-31 19:12:17', '2020-05-31 19:12:17', 78, 1, NULL),
(44, 1, 1, 13, 'B001', 2, '0', '2020-05-25 12:13:08', '2020-05-31 19:12:17', '2020-05-31 19:12:17', 78, 1, NULL),
(45, 1, 1, 1, 'F001', 2, '0', '2020-05-25 12:13:08', '2020-05-31 19:12:17', '2020-05-31 19:12:17', 78, 1, NULL),
(46, 1, 1, 13, 'F001', 1, '0', '2020-05-25 12:13:08', '2020-05-31 19:12:17', '2020-05-31 19:12:17', 78, 78, NULL),
(47, 1, 3, 2, 'B002', 1, '0', '2020-05-25 12:14:52', '2020-05-25 12:26:38', '2020-05-25 12:26:38', 78, 78, NULL),
(48, 1, 3, 2, 'B002', 2, '0', '2020-05-25 12:26:38', '2020-06-07 00:53:43', NULL, 78, 1, NULL),
(49, 1, 1, 2, 'B001', 19, '0', '2020-05-31 19:12:17', '2020-05-31 19:14:41', '2020-05-31 19:14:41', 78, 78, NULL),
(50, 1, 1, 13, 'B001', 2, '0', '2020-05-31 19:12:17', '2020-05-31 19:14:41', '2020-05-31 19:14:41', 78, 78, NULL),
(51, 1, 1, 1, 'F001', 2, '0', '2020-05-31 19:12:17', '2020-05-31 19:14:41', '2020-05-31 19:14:41', 78, 78, NULL),
(52, 1, 1, 13, 'F001', 1, '0', '2020-05-31 19:12:17', '2020-05-31 19:14:41', '2020-05-31 19:14:41', 78, 78, NULL),
(53, 1, 1, 10, 'B001', 1, '0', '2020-05-31 19:12:17', '2020-05-31 19:14:41', '2020-05-31 19:14:41', 78, 78, NULL),
(54, 1, 1, 2, 'B001', 102, '0', '2020-05-31 19:14:41', '2020-06-07 01:12:42', NULL, 78, 1, NULL),
(55, 1, 1, 13, 'B001', 4, '0', '2020-05-31 19:14:41', '2020-05-31 21:18:30', NULL, 78, 1, NULL),
(56, 1, 1, 1, 'F001', 2, '0', '2020-05-31 19:14:41', '2020-05-31 19:14:41', NULL, 78, 78, NULL),
(57, 1, 1, 13, 'F001', 2, '0', '2020-05-31 19:14:41', '2020-05-31 21:17:55', NULL, 78, 1, NULL),
(58, 1, 1, 10, 'B001', 3, '0', '2020-05-31 19:14:41', '2020-05-31 23:58:58', NULL, 78, 1, NULL),
(59, 1, 1, 10, 'F001', 2, '0', '2020-05-31 19:14:41', '2020-05-31 23:54:03', NULL, 78, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `idempresa` int(11) NOT NULL,
  `url` varchar(45) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `ruc` varchar(11) NOT NULL,
  `razonsocial` varchar(100) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `paginaweb` varchar(50) DEFAULT NULL,
  `ctadetraccion` varchar(100) DEFAULT NULL,
  `logopdf` varchar(100) DEFAULT NULL COMMENT 'Logotipo en pdf factura',
  `logocuadrado` varchar(100) DEFAULT NULL,
  `preciounitario` char(1) DEFAULT NULL,
  `tipocambio` char(1) DEFAULT NULL,
  `tipocambiovalor` char(1) DEFAULT NULL COMMENT 'c:comercial s: sunat',
  `tipocalculo` char(1) DEFAULT NULL COMMENT 'v:valorunit c: cantidad',
  `mediopago` char(1) DEFAULT NULL COMMENT 'Ingreso de medios de pago',
  `recargoconsumo` char(1) DEFAULT NULL,
  `recargoconsumovalor` decimal(8,2) DEFAULT NULL,
  `productoselva` char(1) DEFAULT NULL,
  `servicioselva` char(1) DEFAULT NULL,
  `ambiente` char(1) NOT NULL COMMENT '1: Producción 0: Prueba',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idempresa`, `url`, `nombre`, `ruc`, `razonsocial`, `direccion`, `telefono`, `celular`, `email`, `paginaweb`, `ctadetraccion`, `logopdf`, `logocuadrado`, `preciounitario`, `tipocambio`, `tipocambiovalor`, `tipocalculo`, `mediopago`, `recargoconsumo`, `recargoconsumovalor`, `productoselva`, `servicioselva`, `ambiente`, `created_at`, `updated_at`) VALUES
(1, 'ngbsfcu', 'BEJUCO EIRL', '10441200264', 'CHAUCA CHAVEZ JULIO CESAR', NULL, '97087926', '970879206', 'chaucachavez@gmail.com', NULL, '111', 'tG8bc0TFQy9dURa65jWLPHw0Hi3u3ZnaN0hVUd0e.png', 'aEDdMbkGVraV6RKb0zD7GVE7rQQJSbYnG0BKHAAR.png', '1', '0', NULL, NULL, '0', '0', NULL, '0', '0', '0', '2020-05-17 01:30:11', '2020-05-25 14:55:38'),
(2, 'yocvxtj', 'INVERSIONES TURISTICO LA CASA VIKINGO SRL', '20600196368', 'INVERSIONES TURISTICO LA CASA VIKINGO SRL', NULL, NULL, '970879206', 'cesar.cardenaschauca@gmail.com', NULL, NULL, 'logo_pdf.png', 'logo_cuadrado.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2020-05-17 16:15:19', '2020-05-17 16:15:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_users`
--

CREATE TABLE `empresa_users` (
  `id` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `verification_token` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_created_at` int(11) DEFAULT NULL,
  `id_updated_at` int(11) DEFAULT NULL,
  `id_deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad`
--

CREATE TABLE `entidad` (
  `identidad` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `iddocumento` int(11) DEFAULT NULL,
  `numerodoc` varchar(12) DEFAULT NULL,
  `apellidopat` varchar(100) DEFAULT NULL,
  `apellidomat` varchar(100) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `entidad` varchar(100) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `afiliado` char(1) DEFAULT NULL,
  `personal` char(1) DEFAULT NULL,
  `cliente` char(1) DEFAULT NULL,
  `proveedor` char(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_created_at` int(11) DEFAULT NULL,
  `id_updated_at` int(11) DEFAULT NULL,
  `id_deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `entidad`
--

INSERT INTO `entidad` (`identidad`, `idempresa`, `iddocumento`, `numerodoc`, `apellidopat`, `apellidomat`, `nombre`, `entidad`, `direccion`, `email`, `telefono`, `afiliado`, `personal`, `cliente`, `proveedor`, `created_at`, `updated_at`, `deleted_at`, `id_created_at`, `id_updated_at`, `id_deleted_at`) VALUES
(1, 1, 2, '10441200264', NULL, NULL, NULL, 'CHAUCA CHAVEZ JULIO CESAR', '-', 'chaucachavez@gmail.com', NULL, NULL, NULL, '1', NULL, '2020-05-17 01:30:13', '2020-05-17 01:30:13', NULL, NULL, NULL, NULL),
(2, 1, 5, '-', '', '', 'VARIOS', 'VARIOS', 'LIMA - PERU', '', NULL, NULL, NULL, '1', NULL, '2020-05-17 01:30:13', '2020-05-17 01:30:13', NULL, NULL, NULL, NULL),
(3, 1, 1, '44120025', 'LOSTAUNAU BLASS', NULL, 'GILMER VLADIMIR', 'LOSTAUNAU BLASS, GILMER VLADIMIR', NULL, '', NULL, NULL, NULL, '1', NULL, '2020-05-17 01:30:46', '2020-05-17 01:30:46', NULL, NULL, NULL, NULL),
(4, 1, 2, '20603080603', NULL, NULL, NULL, 'EMPRESA ADMINISTRADORA DE SALUD LA UNION S.A.C.', 'AV. JAVIER PRADO OESTE NRO. 757 DPTO. 905 - LIMA LIMA  MAGDALENA DEL MAR', '', NULL, '1', NULL, NULL, NULL, '2020-05-17 01:34:40', '2020-05-17 01:34:40', NULL, NULL, NULL, NULL),
(5, 1, 1, '46833730', 'CHAUCA CHAVEZ', NULL, 'YOLANDA', 'CHAUCA CHAVEZ, YOLANDA', 'Av. León velarde S/N - Puerto Maldonado', 'chaucayolanda@gmail.com', NULL, NULL, NULL, '1', NULL, '2020-05-17 15:45:48', '2020-05-17 15:48:21', NULL, NULL, NULL, NULL),
(6, 1, 1, '44120026', 'CHAUCA CHAVEZ', NULL, 'JULIO CESAR', 'CHAUCA CHAVEZ, JULIO CESAR', NULL, 'chaucachavez@gmail.com', '970879206', NULL, '1', NULL, NULL, '2020-05-17 16:08:48', '2020-05-19 00:35:30', NULL, NULL, NULL, NULL),
(7, 2, 2, '20600196368', NULL, NULL, NULL, 'INVERSIONES TURISTICO LA CASA VIKINGO SRL', 'JR. DANIEL ALCIDES CARRION LT. 10F MZ. D - MADRE DE DIOS TAMBOPATA  TAMBOPATA', 'cesar.cardenaschauca@gmail.com', NULL, NULL, NULL, '1', NULL, '2020-05-17 16:15:19', '2020-05-17 16:15:19', NULL, NULL, NULL, NULL),
(8, 2, 5, '-', '', '', 'VARIOS', 'VARIOS', 'LIMA - PERU', '', NULL, NULL, NULL, '1', NULL, '2020-05-17 16:15:19', '2020-05-17 16:15:19', NULL, NULL, NULL, NULL),
(9, 1, 1, '44120020', 'REQUEJO DIAZ', NULL, 'MAGALI VERONICA', 'REQUEJO DIAZ, MAGALI VERONICA', NULL, '', NULL, NULL, '1', NULL, NULL, '2020-05-28 11:45:06', '2020-05-28 11:45:06', NULL, NULL, NULL, NULL),
(10, 1, 1, '44120023', 'MENDOZA PALACIOS', NULL, 'EDINSON', 'MENDOZA PALACIOS, EDINSON', NULL, '', NULL, NULL, NULL, NULL, NULL, '2020-05-28 14:06:11', '2020-05-28 14:06:11', NULL, NULL, NULL, NULL),
(11, 1, 1, '44120024', 'GUARNIZ SAK', NULL, 'MARIBEL ELENA', 'GUARNIZ SAK, MARIBEL ELENA', 'Jr. Eleazar Guzman y Barrón 2630', 'maribel@gmail.com', '970879200', NULL, NULL, '1', NULL, '2020-05-28 14:07:13', '2020-05-28 14:07:13', NULL, NULL, NULL, NULL),
(12, 1, 1, '44120022', 'SULLON IPANAQUE', NULL, 'RICHARD OSWALDO', 'SULLON IPANAQUE, RICHARD OSWALDO', 'Mi dirección', 'richard@gmail.com', '970879200', NULL, NULL, '1', NULL, '2020-05-28 14:12:04', '2020-05-28 14:12:04', NULL, NULL, NULL, NULL),
(14, 1, 2, '20601303401', NULL, NULL, NULL, 'SERVICIOS DE SALUD ALTERNATIVA JMS E.I.R.L.', 'AV. DEL PINAR NRO. 198 URB. CHACARILLA DEL ESTANQUE - LIMA LIMA  SANTIAGO DE SURCO', '', NULL, NULL, NULL, NULL, '1', '2020-06-01 00:13:31', '2020-06-01 00:13:31', NULL, NULL, NULL, NULL),
(15, 1, 2, '20563622742', NULL, NULL, NULL, 'CLINICA SALAVERRY S.A.C', 'CAL. CAPAC YUPANQUI NRO. 953 URB. FUNDO OYAGUE - LIMA LIMA  JESÚS MARÍA', '', NULL, NULL, NULL, NULL, '1', '2020-06-01 00:30:01', '2020-06-01 00:30:01', NULL, NULL, NULL, NULL),
(16, 1, 1, '44120015', 'CARLOS COLQUI', NULL, 'GUSTAVO', 'CARLOS COLQUI, GUSTAVO', NULL, '', NULL, NULL, NULL, '1', NULL, '2020-06-06 23:49:35', '2020-06-06 23:49:35', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logacceso`
--

CREATE TABLE `logacceso` (
  `idlogacceso` int(11) NOT NULL,
  `identidad` int(11) NOT NULL,
  `fechain` date NOT NULL,
  `horain` time NOT NULL,
  `token` text NOT NULL,
  `tokenstatus` char(1) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `navegador` text,
  `fechaout` date DEFAULT NULL,
  `horaout` time DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `logacceso`
--

INSERT INTO `logacceso` (`idlogacceso`, `identidad`, `fechain`, `horain`, `token`, `tokenstatus`, `ip`, `navegador`, `fechaout`, `horaout`) VALUES
(1, 1, '2020-05-17', '01:30:14', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTY5NzAxNCwiZXhwIjoxNTkwMzAxODE0LCJuYmYiOjE1ODk2OTcwMTQsImp0aSI6IkZQcW9TdTBPUWtmTHpnTjkiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCIwIjoiaWQiLCIxIjoiaG9sYSIsIjIiOiJtdW5kbyJ9.Y2wuqnwP7IGa8EGjtRe7c_tbJSXbQPDnAoApvA_BQVM', '1', NULL, NULL, '2020-05-17', '02:34:26'),
(2, 1, '2020-05-17', '02:34:32', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTcwMDg3MiwiZXhwIjoxNTg5NzA0NDcyLCJuYmYiOjE1ODk3MDA4NzIsImp0aSI6ImZUSVRLQ21ocGdBTElSY3MiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCIwIjoiaWQiLCIxIjoiaG9sYSIsIjIiOiJtdW5kbyJ9.A4NtgjggjxFU9a7Nh9R0Z3KlMhP3QNuEkuI-xmFGhvw', '1', NULL, NULL, '2020-05-17', '02:40:13'),
(3, 1, '2020-05-17', '02:40:16', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTcwMTIxNiwiZXhwIjoxNTg5NzAxMzM2LCJuYmYiOjE1ODk3MDEyMTYsImp0aSI6IjNiU2NIRVBtalMzZktCY3kiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCIwIjoiaWQiLCIxIjoiaG9sYSIsIjIiOiJtdW5kbyJ9.Wi25_1LbeArB3MP40qAt_B5zdsGztStFWgZqouNExDI', '1', NULL, NULL, NULL, NULL),
(4, 1, '2020-05-17', '02:43:47', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTcwMTQyNywiZXhwIjoxNTg5NzAxNTQ3LCJuYmYiOjE1ODk3MDE0MjcsImp0aSI6Imh2djI2WThUbHRVZHpQZWciLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCIwIjoiaWQiLCIxIjoiaG9sYSIsIjIiOiJtdW5kbyJ9._2Lzr7pGKzOBiLF8wKF4RLfxJ8yGZxYJVGV43JXtkZ0', '1', NULL, NULL, NULL, NULL),
(5, 1, '2020-05-17', '02:46:44', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTcwMTYwNCwiZXhwIjoxNTg5NzAxNzI0LCJuYmYiOjE1ODk3MDE2MDQsImp0aSI6Inp2RHRtRE11Q0o0bUEzMUMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCIwIjoiaWQiLCIxIjoiaG9sYSIsIjIiOiJtdW5kbyJ9.GpG4FnksFsfh3sMbfWJRVkIyuKqJydcVZkcr1SuLUQI', '1', NULL, NULL, NULL, NULL),
(6, 1, '2020-05-17', '02:53:20', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTcwMTk5OSwiZXhwIjoxNTg5NzAyMTE5LCJuYmYiOjE1ODk3MDE5OTksImp0aSI6IlNYajhQemh5M0wzVWFHWU4iLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCIwIjoiaWQiLCIxIjoiaG9sYSIsIjIiOiJtdW5kbyJ9.1GAe3EKNHToY5ZfGX185aGPn_n3YzNlqp4ECUaveVig', '1', NULL, NULL, NULL, NULL),
(7, 1, '2020-05-17', '02:59:39', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTcwMjM3OSwiZXhwIjoxNTkwMzA3MTc5LCJuYmYiOjE1ODk3MDIzNzksImp0aSI6IkNLNHJLc2c5dVhocGFPSGYiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCIwIjoiaWQiLCIxIjoiaG9sYSIsIjIiOiJtdW5kbyJ9.VkGFAUTceLEpFd1m0GTv7GrLZjcsocMCIxt3F8P1Sos', '1', NULL, NULL, NULL, NULL),
(8, 1, '2020-05-17', '03:00:55', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTcwMjQ1NSwiZXhwIjoxNTkwMzA3MjU1LCJuYmYiOjE1ODk3MDI0NTUsImp0aSI6ImxlTk9tbWdTNzNwTDJnZ28iLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCIwIjoiaWQiLCIxIjoiaG9sYSIsIjIiOiJtdW5kbyJ9.JPmwQ9UV10Nid6Sx4FidVS0hvZ5sYEgDib9O3jlltQc', '1', NULL, NULL, '2020-05-17', '03:05:43'),
(9, 1, '2020-05-17', '03:05:46', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTcwMjc0NiwiZXhwIjoxNTkwMzA3NTQ2LCJuYmYiOjE1ODk3MDI3NDYsImp0aSI6Ik1IUllLNVpsdXNzaENnT3kiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.IPwhHKlOZpezVed7DvMR1R8_T6fcucQ5w3wH65BX5iw', '1', NULL, NULL, '2020-05-17', '12:32:09'),
(10, 1, '2020-05-17', '15:15:15', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTc0NjUxNCwiZXhwIjoxNTkwMzUxMzE0LCJuYmYiOjE1ODk3NDY1MTUsImp0aSI6Ik9sMmpuZlBoUXcyRlVNTnAiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.QtdmQajRgxg5jEikJWLTvnD-RJxUrUZzl8K1mer1l_g', '1', NULL, NULL, '2020-05-17', '15:18:24'),
(11, 1, '2020-05-17', '15:18:28', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTc0NjcwOCwiZXhwIjoxNTkwMzUxNTA4LCJuYmYiOjE1ODk3NDY3MDgsImp0aSI6InpMdjFTOFVBUENVWTlMbk4iLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.anPBFyGDAXqUU861_Kka9Wf3o8BXZgAB_PgXXdnpoIk', '1', NULL, NULL, '2020-05-17', '15:18:32'),
(12, 1, '2020-05-17', '15:19:35', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTc0Njc3NSwiZXhwIjoxNTkwMzUxNTc1LCJuYmYiOjE1ODk3NDY3NzUsImp0aSI6ImFFdXRTY3B5Sk80VGhnVFgiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.X1vs9pez_bLzLUSeD19uBPUiDgtDfch0O_bFyfzPv7U', '1', NULL, NULL, '2020-05-17', '15:22:09'),
(13, 1, '2020-05-17', '15:23:03', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTc0Njk4MywiZXhwIjoxNTkwMzUxNzgzLCJuYmYiOjE1ODk3NDY5ODMsImp0aSI6Ik5WSWtQTFF2RjhqQktGbFMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.fsRodEcfu92yHXx3du7oStds28scje-IPdpZNbdDzek', '1', NULL, NULL, '2020-05-17', '15:23:12'),
(14, 1, '2020-05-17', '15:31:54', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTc0NzUxMywiZXhwIjoxNTkwMzUyMzEzLCJuYmYiOjE1ODk3NDc1MTMsImp0aSI6Ikl3NVI3Y0IyazdZMHI4MVgiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.VQ8oXjgwviat24MMMGVeS9aGuh9pbjAT22CU-qst5sw', '1', NULL, NULL, '2020-05-17', '15:38:07'),
(15, 1, '2020-05-17', '15:38:10', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTc0Nzg5MCwiZXhwIjoxNTkwMzUyNjkwLCJuYmYiOjE1ODk3NDc4OTAsImp0aSI6IkZBMFhSZUd5QnlpSGN4VEgiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.B7C1Gic8ClbMo86f7-KwWMl4ljmqO_tsDlWDjTrWz2c', '1', NULL, NULL, '2020-05-17', '15:38:25'),
(16, 1, '2020-05-17', '15:38:38', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTc0NzkxOCwiZXhwIjoxNTkwMzUyNzE4LCJuYmYiOjE1ODk3NDc5MTgsImp0aSI6IjVjY2ROT0F0cGlNOEdTeGQiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.mhHJoZkMKW8zwRiQ3fYAABuRPGIH-bXoNtThs6Q5YuA', '1', NULL, NULL, '2020-05-17', '15:42:58'),
(17, 1, '2020-05-17', '15:45:17', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTc0ODMxNywiZXhwIjoxNTkwMzUzMTE3LCJuYmYiOjE1ODk3NDgzMTcsImp0aSI6IkNhNGZQS3JIa205bEVsWTgiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.JiJxK65hr0YG7Gll4T1A0VMk5jQUMe387jdRebKr0zs', '1', NULL, NULL, '2020-05-17', '16:15:11'),
(18, 2, '2020-05-17', '16:15:20', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTc1MDEyMCwiZXhwIjoxNTkwMzU0OTIwLCJuYmYiOjE1ODk3NTAxMjAsImp0aSI6IjVZOXp3bVlLNHBIOWg3WUMiLCJzdWIiOjIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.wNJi3VUvjS_MRe6gQlyrvKl659HNlpERsYsgiG4HraY', '1', NULL, NULL, '2020-05-17', '16:16:15'),
(19, 1, '2020-05-17', '16:16:19', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTc1MDE3OSwiZXhwIjoxNTkwMzU0OTc5LCJuYmYiOjE1ODk3NTAxNzksImp0aSI6InFUN01WeU1DeDFnVzhMWmMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.VTFFhKTW-ouq5lDI8VAGd0Aj3t58R0gXSytdHeLEy4Q', '1', NULL, NULL, '2020-05-17', '16:18:46'),
(20, 1, '2020-05-17', '16:18:54', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTc1MDMzNCwiZXhwIjoxNTkwMzU1MTM0LCJuYmYiOjE1ODk3NTAzMzQsImp0aSI6ImJQNHBQbXZLb3BLMFlvSnMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.TlpJum-vXcTIFYB6eJZ9prDPbje_6aaNSqiiDQEBAD4', '1', NULL, NULL, '2020-05-17', '16:20:50'),
(21, 1, '2020-05-17', '16:28:12', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTc1MDg5MiwiZXhwIjoxNTkwMzU1NjkyLCJuYmYiOjE1ODk3NTA4OTIsImp0aSI6InphS0VwRGVYYkROVm9hdUUiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.2QITjOb3DXCKSQTs8tlOYmzRL4cqaq0id-WGazIqwxw', '1', NULL, NULL, '2020-05-18', '01:00:50'),
(22, 1, '2020-05-18', '01:00:56', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTc4MTY1NiwiZXhwIjoxNTkwMzg2NDU2LCJuYmYiOjE1ODk3ODE2NTYsImp0aSI6IkNncHdPVUhNTkhvaGJMTUsiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.xg8JQ8-HD8WBCgV93j5eMnkulrV07w19vDlP938jKus', '1', NULL, NULL, '2020-05-18', '01:16:53'),
(23, 1, '2020-05-18', '01:17:13', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTc4MjYzMywiZXhwIjoxNTkwMzg3NDMzLCJuYmYiOjE1ODk3ODI2MzMsImp0aSI6ImlPOWdtVG1ZamR3bWtXeE8iLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.bxCW8xXyINl6PYsrBCGE8Jhg2FkcUVHaj0zZx7Ua06Y', '1', NULL, NULL, '2020-05-18', '01:22:23'),
(24, 1, '2020-05-18', '01:22:25', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTc4Mjk0NSwiZXhwIjoxNTkwMzg3NzQ1LCJuYmYiOjE1ODk3ODI5NDUsImp0aSI6InQyamFuV2FoNW8xMXByU28iLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.vlF9jPLiLdf_v7aS1a4aDhVouLBdDQZ1J-Ah-ghColQ', '1', NULL, NULL, '2020-05-18', '01:26:41'),
(25, 1, '2020-05-18', '01:27:59', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTc4MzI3OSwiZXhwIjoxNTkwMzg4MDc5LCJuYmYiOjE1ODk3ODMyNzksImp0aSI6Ind2ZEtGV2NUNzVOamJ1RXUiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.l4rh2gMrDmHtyDuu40otQWZqxoIUasf3gC_TG1FIjS8', '1', NULL, NULL, '2020-05-18', '11:13:25'),
(26, 1, '2020-05-18', '11:13:33', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTgxODQxMywiZXhwIjoxNTkwNDIzMjEzLCJuYmYiOjE1ODk4MTg0MTMsImp0aSI6InhxSzhLSk82Y2NkQkY5QnkiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.nvgFDF1w1N5xPloHHHQvC73ucCMz-S0gS0an7BiY0og', '1', NULL, NULL, '2020-05-18', '13:52:10'),
(27, 1, '2020-05-18', '13:53:06', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTgyNzk4NiwiZXhwIjoxNTkwNDMyNzg2LCJuYmYiOjE1ODk4Mjc5ODYsImp0aSI6Im5WV1lQNjRXMENBeW80OVQiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9._boQXrAaAYNdANJEU578Q0R8cE3txZNjTqt_-JAlrco', '1', NULL, NULL, '2020-05-18', '14:40:37'),
(28, 1, '2020-05-18', '14:40:43', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTgzMDg0MywiZXhwIjoxNTkwNDM1NjQzLCJuYmYiOjE1ODk4MzA4NDMsImp0aSI6IndQV1pja2NRNm43a0xhNzMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.DYDWAOGZ56TKmFVvjLRHfJnY5zWjrNwjJcLI_JQymaw', '1', NULL, NULL, '2020-05-18', '14:55:17'),
(29, 1, '2020-05-18', '14:55:18', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTgzMTcxOCwiZXhwIjoxNTkwNDM2NTE4LCJuYmYiOjE1ODk4MzE3MTgsImp0aSI6IjNLNDloaGRQNGNXeExLcDMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.WNFC7cYEnRlsHYO7u3_fi99O5pICqVfxyh0FTPLcEfk', '1', NULL, NULL, '2020-05-18', '15:29:37'),
(30, 1, '2020-05-18', '15:36:20', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTgzNDE3OSwiZXhwIjoxNTkwNDM4OTc5LCJuYmYiOjE1ODk4MzQxNzksImp0aSI6IndTbVdoZzF0NDRBaGNMTW8iLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.OMYsvkcYpALjgsCmtaF0F2ii0IZOMUlsgGSPYWWi6Gk', '1', NULL, NULL, '2020-05-18', '18:39:08'),
(31, 1, '2020-05-18', '18:39:38', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTg0NTE3OCwiZXhwIjoxNTkwNDQ5OTc4LCJuYmYiOjE1ODk4NDUxNzgsImp0aSI6IkV1Vzh1UWIwZFZCZ2VaMXciLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.wooB5Cp8xRWM8_l4OwUNznKQoYFZggjlsO46A2DmgDg', '1', NULL, NULL, '2020-05-18', '18:50:37'),
(32, 1, '2020-05-18', '18:50:39', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTg0NTgzOSwiZXhwIjoxNTkwNDUwNjM5LCJuYmYiOjE1ODk4NDU4MzksImp0aSI6IklKMkRYaFhYMDJuYkhsVVEiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.2zTjQxQS1HGLdt2sDLdOAbeJtrDYIZGnM2hGcXQ8Jlg', '1', NULL, NULL, '2020-05-18', '18:51:09'),
(33, 1, '2020-05-18', '18:51:10', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTg0NTg3MCwiZXhwIjoxNTkwNDUwNjcwLCJuYmYiOjE1ODk4NDU4NzAsImp0aSI6Im9IMjNDbjBJNWpHVUtwSU0iLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.77FPE61a1PQ4SWZ3jKHwNpIttYiBLtOIgYlDpCYiOII', '1', NULL, NULL, '2020-05-18', '20:31:31'),
(34, 1, '2020-05-18', '20:31:35', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU4OTg1MTg5NSwiZXhwIjoxNTkwNDU2Njk1LCJuYmYiOjE1ODk4NTE4OTUsImp0aSI6IkFJMVBJWURVQkJ4TnRlSU8iLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.PgM4qjF_NIeUg7X1aJgvgfQZq6Kf8oc94FVNuLPB_wk', '1', NULL, NULL, '2020-05-21', '17:37:30'),
(35, 1, '2020-05-21', '17:37:38', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDEwMDY1OCwiZXhwIjoxNTkwNzA1NDU4LCJuYmYiOjE1OTAxMDA2NTgsImp0aSI6IjY3NUozeml0N0tXQkZuakYiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.oE9ZPYEj-Ldo1vG9Pd403NIzvmDZRs_xu22rd0dwbq0', '1', NULL, NULL, '2020-05-21', '19:13:16'),
(36, 1, '2020-05-21', '19:13:46', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDEwNjQyNiwiZXhwIjoxNTkwNzExMjI2LCJuYmYiOjE1OTAxMDY0MjYsImp0aSI6IlgzT3h1U0c1NG9WVVZCWUMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.AHxiTX6MBTk8-57eA_VrVtk0r_9doFt-5nkq4QQHN3E', '1', NULL, NULL, '2020-05-22', '20:18:41'),
(37, 1, '2020-05-22', '20:18:44', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDE5NjcyNCwiZXhwIjoxNTkwODAxNTI0LCJuYmYiOjE1OTAxOTY3MjQsImp0aSI6IjhYOWFRM1RmMlB6U2d1MUMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.JbmXWa44HhEI26_QsaPzictJNRBIPUjFPt_BJUeaWbE', '1', NULL, NULL, NULL, NULL),
(38, 1, '2020-05-23', '14:51:06', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDI2MzQ2NSwiZXhwIjoxNTkwODY4MjY1LCJuYmYiOjE1OTAyNjM0NjUsImp0aSI6InUxM21pWjZpa2lWdGJuRFIiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.5VvLQSwvWeoR8N0GsJdkVJQMZOg3T0Krx8ysLjv47U0', '1', NULL, NULL, '2020-05-24', '11:43:55'),
(39, 1, '2020-05-24', '11:44:04', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDMzODY0NCwiZXhwIjoxNTkwOTQzNDQ0LCJuYmYiOjE1OTAzMzg2NDQsImp0aSI6IlVSN2syUnhFWmlEbndaNkQiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.PF6944W4fQDxNTL0OfH9-bkwKpCVMX0m5Ckys-t07OM', '1', NULL, NULL, '2020-05-24', '13:15:13'),
(40, 1, '2020-05-24', '13:15:19', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDM0NDExOSwiZXhwIjoxNTkwOTQ4OTE5LCJuYmYiOjE1OTAzNDQxMTksImp0aSI6IlhZMk5HZjBuNUFTQnZHakEiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.657nKaQ6jR3QZcHxW6REzDF-MNkWAcOUTMnP8THlsIA', '1', NULL, NULL, '2020-05-24', '13:17:57'),
(41, 1, '2020-05-24', '13:18:01', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDM0NDI4MSwiZXhwIjoxNTkwOTQ5MDgxLCJuYmYiOjE1OTAzNDQyODEsImp0aSI6IngxdnVrZHlNczhHYTMzYlQiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.E9NlP4RbjseRHyukggZvsVsIEFeAR0AIkR_00bttFb0', '1', NULL, NULL, '2020-05-24', '13:23:42'),
(42, 1, '2020-05-24', '13:23:46', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDM0NDYyNiwiZXhwIjoxNTkwOTQ5NDI2LCJuYmYiOjE1OTAzNDQ2MjYsImp0aSI6IjZTY0pBdUU5UXZGVHZjb1UiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.MWCV6OinSUcg7IQfzMJrqsAnv8CYTUbkhaFP9KHymys', '1', NULL, NULL, '2020-05-24', '14:01:44'),
(43, 1, '2020-05-24', '14:01:47', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDM0NjkwNywiZXhwIjoxNTkwOTUxNzA3LCJuYmYiOjE1OTAzNDY5MDcsImp0aSI6Ikp5SGRZVVJuWGNaQWppRVIiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.gFvXna26LA2rYbqSeH8csrpKGIrpv7R7hnfcgDR9FhY', '1', NULL, NULL, '2020-05-24', '20:07:31'),
(44, 1, '2020-05-24', '20:07:37', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDM2ODg1NywiZXhwIjoxNTkwOTczNjU3LCJuYmYiOjE1OTAzNjg4NTcsImp0aSI6IlJSNDljeENHZzI0N2RoVEkiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.KwkNvKh2-P-6yxxyAn8JEIbuQmanzciP02u2A6Uoitc', '1', NULL, NULL, '2020-05-25', '00:56:05'),
(45, 1, '2020-05-25', '00:56:17', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDM4NjE3NywiZXhwIjoxNTkwOTkwOTc3LCJuYmYiOjE1OTAzODYxNzcsImp0aSI6IjJtbTVPUWwzWDJjMXRYUUciLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.i-3PpiDR__9F1pFoJIQBZbn3BIpuiWt53pSAWpsyVBA', '1', NULL, NULL, NULL, NULL),
(46, 1, '2020-05-25', '14:33:05', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDQzNTE4NSwiZXhwIjoxNTkxMDM5OTg1LCJuYmYiOjE1OTA0MzUxODUsImp0aSI6ImhpNm5pVmJKWVI3QTlsYWkiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.wWnVY3p2WS8-zvdqtaM3-nKCvLO3hpuTiJhlb7etJPU', '1', NULL, NULL, '2020-05-25', '14:33:08'),
(47, 1, '2020-05-25', '14:36:00', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDQzNTM2MCwiZXhwIjoxNTkxMDQwMTYwLCJuYmYiOjE1OTA0MzUzNjAsImp0aSI6IlJ6SGV4WWNGS3EyWUdPblMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.P2Y_z1BapNmlw3qyBj6iTLyoq6bpWo-rBS95icy1jUc', '1', NULL, NULL, '2020-05-25', '14:36:18'),
(48, 1, '2020-05-25', '14:36:24', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDQzNTM4NCwiZXhwIjoxNTkxMDQwMTg0LCJuYmYiOjE1OTA0MzUzODQsImp0aSI6Ijgxa1VsNGtwbVJ1NkdwN2QiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.bb12uCwk5TayOl6KzbhSQV1i1W39R5q97TK88BD1PNo', '1', NULL, NULL, '2020-05-25', '14:36:37'),
(49, 1, '2020-05-25', '14:36:42', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDQzNTQwMiwiZXhwIjoxNTkxMDQwMjAyLCJuYmYiOjE1OTA0MzU0MDIsImp0aSI6IkVkb0U5bzA5TjdDenJyamQiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.Y1d9SeW75loihCuhD2I56Jid24PswSn9gDDI_ORU9YE', '1', NULL, NULL, '2020-05-25', '14:47:11'),
(50, 1, '2020-05-25', '14:47:14', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDQzNjAzNCwiZXhwIjoxNTkxMDQwODM0LCJuYmYiOjE1OTA0MzYwMzQsImp0aSI6InMzVW1LZTRhM3FpQTZWMzAiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.NoWRqDKjZ0_-T40rJIAOZzAiCdoz80n5XU3Ugvq4ft4', '1', NULL, NULL, '2020-05-26', '19:43:23'),
(51, 1, '2020-05-26', '19:44:29', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDU0MDI2OSwiZXhwIjoxNTkxMTQ1MDY5LCJuYmYiOjE1OTA1NDAyNjksImp0aSI6ImNZY0lxN2U1VEIzajdHMTAiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.pQoSndEUGCWh59PnDOH3RwkipStZfweWqwfHYJuNNZA', '1', NULL, NULL, '2020-05-26', '20:45:40'),
(52, 1, '2020-05-26', '20:45:45', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDU0Mzk0NSwiZXhwIjoxNTkxMTQ4NzQ1LCJuYmYiOjE1OTA1NDM5NDUsImp0aSI6ImREVWE3Q2lDRWd5ckZhRlIiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.dZ7UZdhfSS6AmhzA3SoUTbkpk8klbIG2XR5yZ6e5MN4', '1', NULL, NULL, '2020-05-26', '20:46:05'),
(53, 1, '2020-05-26', '20:54:47', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDU0NDQ4NywiZXhwIjoxNTkxMTQ5Mjg3LCJuYmYiOjE1OTA1NDQ0ODcsImp0aSI6Ind2TnozbmNibEJkb0RjYXEiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.8mCpZ_4I0zcgFLc2zVgq2VduIVU3F6lla-c2jx1NMe0', '1', NULL, NULL, '2020-05-26', '20:54:55'),
(54, 1, '2020-05-26', '20:54:57', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDU0NDQ5NywiZXhwIjoxNTkxMTQ5Mjk3LCJuYmYiOjE1OTA1NDQ0OTcsImp0aSI6IkIwTmlHMjRubTVLQlVqSFgiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.IKz8lb1L5a-v0pZq7iXTjN5Cqn-v9CVGi8ZX_Ow-6oA', '1', NULL, NULL, '2020-05-26', '21:01:53'),
(55, 1, '2020-05-26', '21:01:56', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDU0NDkxNiwiZXhwIjoxNTkxMTQ5NzE2LCJuYmYiOjE1OTA1NDQ5MTYsImp0aSI6IjZVU0k4a0F5T1g4Vno0REEiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.cKSsAszgIDkBCVJqyGxgqcMlvxUJqejQJBNtObGdr2M', '1', NULL, NULL, NULL, NULL),
(56, 1, '2020-05-29', '20:33:41', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDgwMjQyMCwiZXhwIjoxNTkxNDA3MjIwLCJuYmYiOjE1OTA4MDI0MjAsImp0aSI6IkZXcmdDNFJjYU1QWWRiMmoiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.X0utNGkGK8lFY1NxoD8QV1vOtpsIbdOOzFpPUzMMaSU', '1', NULL, NULL, NULL, NULL),
(57, 1, '2020-05-30', '04:05:46', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDgyOTU0NSwiZXhwIjoxNTkxNDM0MzQ1LCJuYmYiOjE1OTA4Mjk1NDUsImp0aSI6IkU1aXpFYTFGME9wbjVBdG0iLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.As8g6s1F1BwUbf94Pun0AxUbQ567FO5snvt33e12SFk', '1', NULL, NULL, '2020-05-31', '10:42:30'),
(58, 1, '2020-05-31', '10:43:01', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MDkzOTc4MSwiZXhwIjoxNTkxNTQ0NTgxLCJuYmYiOjE1OTA5Mzk3ODEsImp0aSI6ImpUaEE2aWhMRTNtNlpmeHAiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.yIDFoxcj4KSUxy9xRP6ii0rL7bjpWSpdHXrtimC6l2o', '1', NULL, NULL, NULL, NULL),
(59, 1, '2020-06-05', '09:32:18', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTM2NzUzNywiZXhwIjoxNTkxOTcyMzM3LCJuYmYiOjE1OTEzNjc1MzcsImp0aSI6IlpiajlvdGdiYzloZ25aRkciLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.wA3KSzMLa4s71wcQz35Zb7Z2ZLl4l2MaO-cZNFlZd4M', '1', NULL, NULL, NULL, NULL),
(60, 1, '2020-06-05', '15:27:04', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTM4ODgyMywiZXhwIjoxNTkxOTkzNjIzLCJuYmYiOjE1OTEzODg4MjMsImp0aSI6IlozOTZIZFZ3NUxDVUdUVGgiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.J2lRrIWlFc_eo6qf0i3UNZiP_VnQxGOdFsEnnOibMmA', '1', NULL, NULL, '2020-06-05', '15:27:07'),
(61, 1, '2020-06-05', '17:11:01', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTM5NTA2MSwiZXhwIjoxNTkxOTk5ODYxLCJuYmYiOjE1OTEzOTUwNjEsImp0aSI6Ind0RzkxdkNOU0NnSGtrRloiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.iMDIWO66BdAPKAi1Pc3_7LfomQsa2FQ9P9396wp4EYQ', '1', NULL, NULL, '2020-06-05', '17:11:04'),
(62, 1, '2020-06-05', '18:20:32', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTM5OTIzMiwiZXhwIjoxNTkyMDA0MDMyLCJuYmYiOjE1OTEzOTkyMzIsImp0aSI6ImpLODIxVTJOMFhwVFRJcVQiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.E4nLTXf2LQMTQLRUMc-8NtG9epQZkBpUnBYk35QW-HY', '1', NULL, NULL, NULL, NULL),
(63, 1, '2020-06-06', '01:18:43', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTQyNDMyMiwiZXhwIjoxNTkyMDI5MTIyLCJuYmYiOjE1OTE0MjQzMjIsImp0aSI6IjBFM3Z1MFBrdTJwUFA3TTgiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.OJ3HIZ0am4pwc_SXtimzP6MeNclvT_RS665GordHi9A', '1', NULL, NULL, NULL, NULL),
(64, 1, '2020-06-06', '11:29:15', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTQ2MDk1NSwiZXhwIjoxNTkyMDY1NzU1LCJuYmYiOjE1OTE0NjA5NTUsImp0aSI6InJsM0Zvd2pkQndpVDRNY2ciLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.4hg_JoiScSlgNETfMIr0FideM6awV27HPFwcHldCxj0', '1', NULL, NULL, '2020-06-06', '18:57:42'),
(65, 1, '2020-06-06', '12:36:37', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTQ2NDk5NywiZXhwIjoxNTkyMDY5Nzk3LCJuYmYiOjE1OTE0NjQ5OTcsImp0aSI6IkV1MThjOTdCUFdzVlFNSmoiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.KrGDaBMLbcrzGV3k3LMjTqKNIVZi_zekpQjFI9poV7I', '1', NULL, NULL, '2020-06-06', '12:36:45'),
(66, 1, '2020-06-06', '12:36:47', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTQ2NTAwNywiZXhwIjoxNTkyMDY5ODA3LCJuYmYiOjE1OTE0NjUwMDcsImp0aSI6IllwOUxMODNpQlJ2bE1XQlMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.iCmpAIlrgAsk90BYCJyzVLTPsujv_M9pitKnK17dHQg', '1', NULL, NULL, '2020-06-06', '12:36:52'),
(67, 1, '2020-06-06', '13:08:41', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTQ2NjkyMCwiZXhwIjoxNTkyMDcxNzIwLCJuYmYiOjE1OTE0NjY5MjAsImp0aSI6Ijl6Q1NVV1RsRXh5WHdESlYiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.ZpO8LotA-RaOX2g2cmm1QURaJZfPLc_HsSe6KrPvmgo', '1', NULL, NULL, NULL, NULL),
(68, 1, '2020-06-06', '17:30:40', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTQ4MjY0MCwiZXhwIjoxNTkyMDg3NDQwLCJuYmYiOjE1OTE0ODI2NDAsImp0aSI6InpRT3E4bWNBUk9pMkRuSVMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.Xb-FAzlfssePDNxUV6nUg9iRouXDpRTva-mrMr5KqrI', '1', NULL, NULL, NULL, NULL),
(69, 1, '2020-06-06', '18:57:47', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTQ4Nzg2NywiZXhwIjoxNTkyMDkyNjY3LCJuYmYiOjE1OTE0ODc4NjcsImp0aSI6InNGaUNNR1lhVTB3dE9zZDkiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.0tS4gDwAkliccoqKTI70P_oGnWjLK6nF-vnnUPDrbZY', '1', NULL, NULL, '2020-06-06', '19:00:29'),
(70, 1, '2020-06-06', '19:00:31', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTQ4ODAzMSwiZXhwIjoxNTkyMDkyODMxLCJuYmYiOjE1OTE0ODgwMzEsImp0aSI6IkphNUFLZGh6cmQ2SlhnYlQiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.MwpdBLnKcord6V5VMAB3OvnvEzjaC2acLPuHbKIO9Fk', '1', NULL, NULL, '2020-06-06', '19:00:43'),
(71, 1, '2020-06-06', '19:01:01', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTQ4ODA2MSwiZXhwIjoxNTkyMDkyODYxLCJuYmYiOjE1OTE0ODgwNjEsImp0aSI6Im55bFhiMEtORHlDRXNnU3ciLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.DCAir2mMvxkJaNoVCz6BjLMLCrRxyayUquWcx5xqT1w', '1', NULL, NULL, '2020-06-06', '19:14:27'),
(72, 1, '2020-06-06', '19:14:32', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTQ4ODg3MiwiZXhwIjoxNTkyMDkzNjcyLCJuYmYiOjE1OTE0ODg4NzIsImp0aSI6IjVVTFpBZHJYTEx0RjhoMDAiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.EdJPgQ8-UXXD_efKZ_IdUMOKT90n-zjSLKSluq8VjdA', '1', NULL, NULL, '2020-06-06', '19:20:39'),
(73, 1, '2020-06-06', '19:22:40', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTQ4OTM2MCwiZXhwIjoxNTkyMDk0MTYwLCJuYmYiOjE1OTE0ODkzNjAsImp0aSI6Imdza2hSbUtZT2V2UzNWWEYiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.gR5lU75Z_rtE87eUIuJIu9xaHfJtt3gPqsU9QKxYC0E', '1', NULL, NULL, '2020-06-06', '22:48:14'),
(74, 1, '2020-06-06', '22:48:20', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMTcwMCwiZXhwIjoxNTkyMTA2NTAwLCJuYmYiOjE1OTE1MDE3MDAsImp0aSI6IlVJQWV3bHBaS3lHaWdCemIiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.GEvwb-7TC_XUGyGIVClLD3lVvP6Sy-B5q7tDo1wERpI', '1', NULL, NULL, '2020-06-06', '22:48:30'),
(75, 1, '2020-06-06', '22:48:32', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMTcxMiwiZXhwIjoxNTkyMTA2NTEyLCJuYmYiOjE1OTE1MDE3MTIsImp0aSI6InB0WnNPMUNad2ZFT0JOQUciLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.ghKR4B1PB0WrAggl_i-7QAZQyuiToZy4qnKVdSIzf_Q', '1', NULL, NULL, '2020-06-06', '22:49:03'),
(76, 1, '2020-06-06', '22:49:05', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMTc0NSwiZXhwIjoxNTkyMTA2NTQ1LCJuYmYiOjE1OTE1MDE3NDUsImp0aSI6IkFFNFI1Q0kwZzRTbURkQ1QiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.iZYgmK9ZzUquBET2-G0M189iMmeM57eXGJDWHzUj7m0', '1', NULL, NULL, '2020-06-06', '22:49:23'),
(77, 1, '2020-06-06', '22:49:25', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMTc2NSwiZXhwIjoxNTkyMTA2NTY1LCJuYmYiOjE1OTE1MDE3NjUsImp0aSI6Ild2SGFoWlliUEltYW4wQWEiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.pu5xYqwzboOftaNu1FPs7-CxFDohJQq0hdNzKuTpf_w', '1', NULL, NULL, '2020-06-06', '22:49:38'),
(78, 1, '2020-06-06', '22:49:40', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMTc4MCwiZXhwIjoxNTkyMTA2NTgwLCJuYmYiOjE1OTE1MDE3ODAsImp0aSI6ImVpTG96cHdvd3U5ajdQbnUiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.eYFeoe8y04E06yqf1M74b8UKzf03hF2wiYDNLYPlNYQ', '1', NULL, NULL, '2020-06-06', '22:50:20'),
(79, 1, '2020-06-06', '22:50:22', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMTgyMiwiZXhwIjoxNTkyMTA2NjIyLCJuYmYiOjE1OTE1MDE4MjIsImp0aSI6Im1MWjNzVkt0bWZuVjBzNUYiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.E6piouUWOeTBJEzsj0T59jraou9Bhp7C5uUeuxAErDI', '1', NULL, NULL, '2020-06-06', '22:50:40'),
(80, 1, '2020-06-06', '22:50:42', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMTg0MiwiZXhwIjoxNTkyMTA2NjQyLCJuYmYiOjE1OTE1MDE4NDIsImp0aSI6IkdxVTdmNHEwZ1huMk94YkMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.L_xfa7ioLHTHdVNB34ptsxlaM0QbpWFOD3bRsH0_UFQ', '1', NULL, NULL, '2020-06-06', '22:50:52'),
(81, 1, '2020-06-06', '22:50:54', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMTg1NCwiZXhwIjoxNTkyMTA2NjU0LCJuYmYiOjE1OTE1MDE4NTQsImp0aSI6IjViakpaOXRUeUkzN1ZaeEgiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.LHypN2diDDWqIL2eH_ATGc14HW1kP48MvD7Uh-T7i0I', '1', NULL, NULL, '2020-06-06', '22:51:07'),
(82, 1, '2020-06-06', '22:51:08', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMTg2OCwiZXhwIjoxNTkyMTA2NjY4LCJuYmYiOjE1OTE1MDE4NjgsImp0aSI6IjRPbzE4Vm5pU3dWcGQ3NWEiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.upMmbhTxnFj57AWuSrcmxYiY1bU42Z6aFToQVFxCGEA', '1', NULL, NULL, '2020-06-06', '22:51:26'),
(83, 1, '2020-06-06', '22:51:32', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMTg5MiwiZXhwIjoxNTkyMTA2NjkyLCJuYmYiOjE1OTE1MDE4OTIsImp0aSI6IlpBempremVNeEdNa253V1UiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.vih-sOJnaaHWhRQ8XU8ouQruV0Yken9OG3MuvSfIJvc', '1', NULL, NULL, '2020-06-06', '22:51:41'),
(84, 1, '2020-06-06', '22:51:42', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMTkwMiwiZXhwIjoxNTkyMTA2NzAyLCJuYmYiOjE1OTE1MDE5MDIsImp0aSI6IkI2Y2YwYjNSR2FVMnZlakQiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.DnU1UNCR6nV2Fa_gcTznl6s3Y4IoBoCB5dLoTx-7LjA', '1', NULL, NULL, '2020-06-06', '22:52:08'),
(85, 1, '2020-06-06', '22:52:10', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMTkzMCwiZXhwIjoxNTkyMTA2NzMwLCJuYmYiOjE1OTE1MDE5MzAsImp0aSI6Ik5WRTl4aHlnSUh2TEpPS2QiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.nYA-sHCLz-Bixu-0zot8iypTCkE4rZ91Dpz7lJkjkSs', '1', NULL, NULL, '2020-06-06', '22:53:57'),
(86, 1, '2020-06-06', '22:54:00', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMjA0MCwiZXhwIjoxNTkyMTA2ODQwLCJuYmYiOjE1OTE1MDIwNDAsImp0aSI6ImdkNmZEeGd0eDBYck5zSTMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.lsBghPbl-6xtLbUABths6c5AADRPZqTHxNt-O-ZYrd0', '1', NULL, NULL, '2020-06-06', '22:54:31'),
(87, 1, '2020-06-06', '22:54:33', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMjA3MywiZXhwIjoxNTkyMTA2ODczLCJuYmYiOjE1OTE1MDIwNzMsImp0aSI6IkZidEZYcmFmeDk5QXQ5RVQiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.KKuDOXN2e9cxmEdAZH0YNGRbJoDQXM_mDfAMtN7dPoM', '1', NULL, NULL, '2020-06-06', '22:54:58'),
(88, 1, '2020-06-06', '22:55:00', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMjEwMCwiZXhwIjoxNTkyMTA2OTAwLCJuYmYiOjE1OTE1MDIxMDAsImp0aSI6InJuNkt2bVdlZ3dndm1EelUiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.-Q_cxein7WjflGuCIXUuSJC76ncTCKHfVi8D_QZPLCc', '1', NULL, NULL, '2020-06-06', '22:55:08'),
(89, 1, '2020-06-06', '22:55:09', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMjEwOSwiZXhwIjoxNTkyMTA2OTA5LCJuYmYiOjE1OTE1MDIxMDksImp0aSI6Ikd4MjZhUjhIYnRuSWFrRWIiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.T1mvP_fdkay4L0gKtxTlAWor1sJg1lparV5HHRuDjic', '1', NULL, NULL, '2020-06-06', '22:55:20'),
(90, 1, '2020-06-06', '22:55:22', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMjEyMiwiZXhwIjoxNTkyMTA2OTIyLCJuYmYiOjE1OTE1MDIxMjIsImp0aSI6IkRNUXNZeVBzaHdEWEplRHMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.2INHmmvXE8dKxKl1z1i_uKb4z3kWqSy7Fnq0HRSu738', '1', NULL, NULL, '2020-06-06', '22:56:12'),
(91, 1, '2020-06-06', '22:56:14', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMjE3NCwiZXhwIjoxNTkyMTA2OTc0LCJuYmYiOjE1OTE1MDIxNzQsImp0aSI6InB2d0lPb0FZb3FMQUoyTDEiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.Cjqb8tgWDTwHzjkI-Xw58rkPENm2Ju16i-tUVc1i-O8', '1', NULL, NULL, '2020-06-06', '22:56:21'),
(92, 1, '2020-06-06', '22:56:31', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMjE5MSwiZXhwIjoxNTkyMTA2OTkxLCJuYmYiOjE1OTE1MDIxOTEsImp0aSI6ImZZSWRlSlV2Tm1WYW5kY1QiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.WYljBSdZXqx6Br9OJ0tt_21MJFcn3pllc-3Pg1QI8Co', '1', NULL, NULL, '2020-06-06', '22:57:04'),
(93, 1, '2020-06-06', '22:57:11', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMjIzMSwiZXhwIjoxNTkyMTA3MDMxLCJuYmYiOjE1OTE1MDIyMzEsImp0aSI6ImhPcUxmVDJ5elB3Q0F0QnkiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.d5rlClruCXEA6abRWtYQyn2QJZkL47KWCH2xCtC3a9A', '1', NULL, NULL, '2020-06-06', '23:06:40'),
(94, 1, '2020-06-06', '23:06:46', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMjgwNiwiZXhwIjoxNTkyMTA3NjA2LCJuYmYiOjE1OTE1MDI4MDYsImp0aSI6Im82bTJ1ZGduS3lVSDZFdnciLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.t8UYY_zleMwb1ex6JbjWOjFb8Cs7iFkZtj3P-OcquCY', '1', NULL, NULL, '2020-06-06', '23:06:58'),
(95, 1, '2020-06-06', '23:07:00', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMjgyMCwiZXhwIjoxNTkyMTA3NjIwLCJuYmYiOjE1OTE1MDI4MjAsImp0aSI6IjAxU1JCOGxOd1BWejFUNmYiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.3wHHXtwnzi_IJAm9VKjTcKbtvvfBZqMJnKST2oyB7Rc', '1', NULL, NULL, '2020-06-06', '23:07:56'),
(96, 1, '2020-06-06', '23:08:00', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMjg3OSwiZXhwIjoxNTkyMTA3Njc5LCJuYmYiOjE1OTE1MDI4NzksImp0aSI6Iko1VUlBOE10Q0Z3aTVXOUEiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.Kv1LEGxARqE1dsGPGcJEm6na-hM6cV1aIk0vLH_qLK4', '1', NULL, NULL, '2020-06-06', '23:13:37'),
(97, 1, '2020-06-06', '23:15:20', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMzMyMCwiZXhwIjoxNTkyMTA4MTIwLCJuYmYiOjE1OTE1MDMzMjAsImp0aSI6IjlCOUl1S1Rvd1RaUk5oZWYiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.VvxR7X5FUzV9OBAGEQT660D-bUMmLZEEZs2Ew4rJ-70', '1', NULL, NULL, '2020-06-06', '23:15:30'),
(98, 1, '2020-06-06', '23:15:33', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMzMzMywiZXhwIjoxNTkyMTA4MTMzLCJuYmYiOjE1OTE1MDMzMzMsImp0aSI6Im5mSWZHTG9EZ0Q2WnFKdUUiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.wv5FO1vE_eu_nvoF-EtsSb7ILq6buv1djBuOd8zgREU', '1', NULL, NULL, '2020-06-06', '23:15:41'),
(99, 1, '2020-06-06', '23:15:43', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMzM0MywiZXhwIjoxNTkyMTA4MTQzLCJuYmYiOjE1OTE1MDMzNDMsImp0aSI6IkJ6cGJONWhSYVE1czZkSFciLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.YNrdCPrkvA-ipBcw7t7_og_fRU79EwBL_HLaIEUxj9I', '1', NULL, NULL, '2020-06-06', '23:15:51'),
(100, 1, '2020-06-06', '23:15:53', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMzM1MywiZXhwIjoxNTkyMTA4MTUzLCJuYmYiOjE1OTE1MDMzNTMsImp0aSI6IkE2UlVPVFNpSGFVdk1zU3oiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.JHPskTbCOB9jff8UHXh3scE4rIDpWg1wZOrpJNsUC9o', '1', NULL, NULL, '2020-06-06', '23:16:03'),
(101, 1, '2020-06-06', '23:16:05', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMzM2NSwiZXhwIjoxNTkyMTA4MTY1LCJuYmYiOjE1OTE1MDMzNjUsImp0aSI6InR6bW1VcFhiWm1Ta1ZTb2QiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.MlL8DoKvFsCfqIFU8ZyGrkFNycIrnvphxdemkZcum6I', '1', NULL, NULL, '2020-06-06', '23:17:37'),
(102, 1, '2020-06-06', '23:17:39', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMzQ1OSwiZXhwIjoxNTkyMTA4MjU5LCJuYmYiOjE1OTE1MDM0NTksImp0aSI6ImFWZlkyT0tuV0ZDV2gzUWUiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.1iFPB-B8ce-L80DraCFNLM48AFNSUJjm3MIV34DcN5Y', '1', NULL, NULL, '2020-06-06', '23:22:34'),
(103, 1, '2020-06-06', '23:22:37', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMzc1NywiZXhwIjoxNTkyMTA4NTU3LCJuYmYiOjE1OTE1MDM3NTcsImp0aSI6IjJ1ZTlMYkhXY1R2TnpUOXgiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.JNu0xLfZRO4KKoNPd0A1b0sR_hSjc8kyCdG0ChAO0XA', '1', NULL, NULL, '2020-06-06', '23:22:52'),
(104, 1, '2020-06-06', '23:22:54', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMzc3NCwiZXhwIjoxNTkyMTA4NTc0LCJuYmYiOjE1OTE1MDM3NzQsImp0aSI6IlVDY2xIUkpGTzlMa0hvb3QiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.skc02q1k8r3llrb2ENpzvONQhGUceXpE3ZGYYvjfvRc', '1', NULL, NULL, '2020-06-06', '23:23:15'),
(105, 1, '2020-06-06', '23:23:17', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMzc5NywiZXhwIjoxNTkyMTA4NTk3LCJuYmYiOjE1OTE1MDM3OTcsImp0aSI6InpVQThNNEhqWWZvc3V4a0giLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.VUqIT4NmpcZoh2DE52EUMMHv3V0T7l1J-VMdSQmuINY', '1', NULL, NULL, '2020-06-06', '23:23:37'),
(106, 1, '2020-06-06', '23:23:39', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwMzgxOSwiZXhwIjoxNTkyMTA4NjE5LCJuYmYiOjE1OTE1MDM4MTksImp0aSI6Ikh6UHBPUXYwMnduS3hHOTUiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.qy2v97WOxxSQDmC1TiD9Eaog2JUBf9wdTya-vZzpHNA', '1', NULL, NULL, '2020-06-06', '23:36:45'),
(107, 1, '2020-06-06', '23:36:51', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwNDYxMSwiZXhwIjoxNTkyMTA5NDExLCJuYmYiOjE1OTE1MDQ2MTEsImp0aSI6IlhEOXJQenA2OUlUd2hZN2ciLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.fH03W5CDtMqd5l5vjPKzRrhNT3CZUQbCPdNiwqBJpz4', '1', NULL, NULL, '2020-06-06', '23:39:22'),
(108, 1, '2020-06-06', '23:39:25', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwNDc2NSwiZXhwIjoxNTkyMTA5NTY1LCJuYmYiOjE1OTE1MDQ3NjUsImp0aSI6Ik9EWXJJdXZtaUxSeHNBSmMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.89cpmm-iNwG8XLKdZXPVb7ypE9uqZTVpNkMiRj1M4x4', '1', NULL, NULL, '2020-06-06', '23:39:35'),
(109, 1, '2020-06-06', '23:39:36', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwNDc3NiwiZXhwIjoxNTkyMTA5NTc2LCJuYmYiOjE1OTE1MDQ3NzYsImp0aSI6IkVSTUlzYm5Yb3hQdTg5a3UiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.-W3yZdEs4YIZ-JrlaKGZclpXEpButgj4f44m-fCwpkY', '1', NULL, NULL, '2020-06-06', '23:39:44'),
(110, 1, '2020-06-06', '23:39:45', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwNDc4NSwiZXhwIjoxNTkyMTA5NTg1LCJuYmYiOjE1OTE1MDQ3ODUsImp0aSI6IlB3MTN6bzExZDBDQ1FUR0YiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.LqHSApeTJgF33QiFP31m7OHWANKbQ3ATiqxfJ6c_DyU', '1', NULL, NULL, '2020-06-06', '23:39:53'),
(111, 1, '2020-06-06', '23:39:55', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwNDc5NSwiZXhwIjoxNTkyMTA5NTk1LCJuYmYiOjE1OTE1MDQ3OTUsImp0aSI6IlFNZVJGcEFQNE5rRUgydEgiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.tLrzoph5vGBRde44W50TtjTp-qfvfu2ZfernkTf22tY', '1', NULL, NULL, '2020-06-06', '23:40:13'),
(112, 1, '2020-06-06', '23:40:15', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwNDgxNSwiZXhwIjoxNTkyMTA5NjE1LCJuYmYiOjE1OTE1MDQ4MTUsImp0aSI6ImluTVpwREFVWEVSVEwzZWciLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.LIzcygON4LE96G8Ldvcid4IySwirLpB9bI8vSRpw4BY', '1', NULL, NULL, '2020-06-06', '23:42:40'),
(113, 1, '2020-06-06', '23:42:43', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwNDk2MywiZXhwIjoxNTkyMTA5NzYzLCJuYmYiOjE1OTE1MDQ5NjMsImp0aSI6ImU0R2RkYkU1eFM0T1h6cUoiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.u5W0hz01TLeodGeKArbh2ea34DKNZLpQzRpNhTu1XC0', '1', NULL, NULL, '2020-06-06', '23:43:08'),
(114, 1, '2020-06-06', '23:43:10', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwNDk5MCwiZXhwIjoxNTkyMTA5NzkwLCJuYmYiOjE1OTE1MDQ5OTAsImp0aSI6ImpaNVpLeFoxYVNKRG1JR3giLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.qxrpJM3voV69PSjs-5K3MrUAdawrfKbczGf2jfz51yU', '1', NULL, NULL, '2020-06-06', '23:44:37'),
(115, 1, '2020-06-06', '23:44:39', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwNTA3OSwiZXhwIjoxNTkyMTA5ODc5LCJuYmYiOjE1OTE1MDUwNzksImp0aSI6IlJ3ZjQ3a3lnWlpFeGp0dzMiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.Yorpyt_k-OtUyBb3iTP2j4exnl0r5BdEcQAXWmpnCe8', '1', NULL, NULL, '2020-06-06', '23:44:50'),
(116, 1, '2020-06-06', '23:44:52', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwNTA5MiwiZXhwIjoxNTkyMTA5ODkyLCJuYmYiOjE1OTE1MDUwOTIsImp0aSI6Ik1pY1Rjc0ZOTFJKa3Q5OGsiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.NURwJePI74In3myuLFDALMbP8phh10ZTXQc7Ua4TvCs', '1', NULL, NULL, '2020-06-06', '23:48:30'),
(117, 1, '2020-06-06', '23:48:32', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwNTMxMiwiZXhwIjoxNTkyMTEwMTEyLCJuYmYiOjE1OTE1MDUzMTIsImp0aSI6ImI3Q0RWbm1HTVl0QkdMelQiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.YvwQszb570ogH4QHeTSZwu2NaUKiaM7CjJwQKl5s_vk', '1', NULL, NULL, '2020-06-07', '00:16:12'),
(118, 1, '2020-06-07', '00:16:15', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTUwNjk3NSwiZXhwIjoxNTkyMTExNzc1LCJuYmYiOjE1OTE1MDY5NzUsImp0aSI6IlY1eEs4YmZieWk4Q0NwaDEiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.ldtOcERby67zfxy6YBcRbKqamQcRsrvjG8k16_ECnR8', '1', NULL, NULL, '2020-06-08', '19:19:20');
INSERT INTO `logacceso` (`idlogacceso`, `identidad`, `fechain`, `horain`, `token`, `tokenstatus`, `ip`, `navegador`, `fechaout`, `horaout`) VALUES
(119, 1, '2020-06-08', '19:19:34', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTY2MTk3NCwiZXhwIjoxNTkyMjY2Nzc0LCJuYmYiOjE1OTE2NjE5NzQsImp0aSI6IlpkUzBoWlFUN2FIU29abXEiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.-VnjQB2-RuS_kElSlT9ZO08UnuwpYtpfIXib3O634WA', '1', NULL, NULL, '2020-06-08', '19:19:45'),
(120, 1, '2020-06-08', '19:19:46', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTY2MTk4NiwiZXhwIjoxNTkyMjY2Nzg2LCJuYmYiOjE1OTE2NjE5ODYsImp0aSI6Ijhmdm1kcEF0Umk5SVh2S3kiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.HkxHmmNC2ISNr7c8sIefyboekqePDdKJIe_DJcXYWg0', '1', NULL, NULL, '2020-06-08', '19:19:56'),
(121, 1, '2020-06-08', '19:19:58', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MTY2MTk5OCwiZXhwIjoxNTkyMjY2Nzk4LCJuYmYiOjE1OTE2NjE5OTgsImp0aSI6IldjSk9qYkhIYnQ2RmtkVWYiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.uZ2-hSs_Zo4duBV4FCdq26fmG807anbN9Ru0xvNpyMA', '1', NULL, NULL, NULL, NULL),
(122, 1, '2020-06-20', '14:11:18', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MjY4MDI3NywiZXhwIjoxNTkzMjg1MDc3LCJuYmYiOjE1OTI2ODAyNzcsImp0aSI6Ilc0R2ZmY3pWV2t3WDZhanUiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.CkphaUWNjGrvcZTVFseEjlA4Paw74oMpNQD2VV5C8sQ', '1', NULL, NULL, '2020-06-20', '14:15:24'),
(123, 1, '2020-06-20', '14:15:44', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MjY4MDU0NCwiZXhwIjoxNTkzMjg1MzQ0LCJuYmYiOjE1OTI2ODA1NDQsImp0aSI6IlZxRDlGN1J5ektVT1VLUFAiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.vzkm1vVDKzwq6GUBMMBXUrKQrIN3ETGbrRoFzPeUbqA', '1', NULL, NULL, '2020-06-20', '14:15:50'),
(124, 1, '2020-06-20', '14:16:45', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTU5MjY4MDYwNSwiZXhwIjoxNTkzMjg1NDA1LCJuYmYiOjE1OTI2ODA2MDUsImp0aSI6ImZUckN5MWsyaDlFbGxRNXQiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJpZGVtcHJlc2EiOjF9.Gt29WnntFNd5Sk-u7_vjAZf7legqJBrTBgs-dN1jZ1g', '1', NULL, NULL, '2020-06-20', '14:18:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `masivo`
--

CREATE TABLE `masivo` (
  `id` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `idsede` int(11) NOT NULL,
  `iddocumentofiscal` int(11) NOT NULL,
  `serie` varchar(4) NOT NULL,
  `numerodel` int(11) NOT NULL,
  `numeroal` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `fechaemision` date DEFAULT NULL,
  `idestadodocumento` int(11) DEFAULT NULL COMMENT '26: Borrador 27:Emitido 28:Anulado	',
  `progreso` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` char(2) DEFAULT NULL COMMENT 'I, P, PP, F, FF',
  `exonerada` decimal(8,2) DEFAULT NULL,
  `inafecta` decimal(8,2) DEFAULT NULL,
  `gratuita` decimal(8,2) DEFAULT NULL,
  `gravada` decimal(8,2) DEFAULT NULL,
  `descuentoporcentaje` decimal(8,2) DEFAULT NULL,
  `descuentoglobal` decimal(8,2) DEFAULT NULL,
  `descuentoitem` decimal(8,2) DEFAULT NULL,
  `descuentototal` decimal(8,2) DEFAULT NULL,
  `valorimpuesto` decimal(8,2) DEFAULT NULL,
  `cargo` decimal(8,2) DEFAULT NULL,
  `totalimpuestobolsa` decimal(8,2) DEFAULT NULL,
  `total` decimal(8,2) NOT NULL,
  `totalletra` varchar(200) DEFAULT NULL,
  `clientenombre` varchar(250) DEFAULT NULL,
  `clientedoc` varchar(10) DEFAULT NULL,
  `clientenumerodoc` varchar(11) DEFAULT NULL,
  `clientedireccion` varchar(200) DEFAULT NULL,
  `operacion` int(11) DEFAULT NULL,
  `moneda` char(3) DEFAULT NULL,
  `tipocambio` decimal(8,3) DEFAULT NULL,
  `fechavencimiento` date DEFAULT NULL,
  `detraccion` char(1) DEFAULT NULL,
  `selvaproducto` char(1) DEFAULT NULL,
  `selvaservicio` char(1) DEFAULT NULL,
  `condicionpago` varchar(200) DEFAULT NULL,
  `observacion` varchar(200) DEFAULT NULL,
  `pdfformato` varchar(6) DEFAULT NULL,
  `pdf` varchar(10) DEFAULT NULL COMMENT 'PDF masivo de ventas',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_created_at` int(11) NOT NULL,
  `id_updated_at` int(11) DEFAULT NULL,
  `id_deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `masivo`
--

INSERT INTO `masivo` (`id`, `idempresa`, `idsede`, `iddocumentofiscal`, `serie`, `numerodel`, `numeroal`, `idcliente`, `fechaemision`, `idestadodocumento`, `progreso`, `cantidad`, `estado`, `exonerada`, `inafecta`, `gratuita`, `gravada`, `descuentoporcentaje`, `descuentoglobal`, `descuentoitem`, `descuentototal`, `valorimpuesto`, `cargo`, `totalimpuestobolsa`, `total`, `totalletra`, `clientenombre`, `clientedoc`, `clientenumerodoc`, `clientedireccion`, `operacion`, `moneda`, `tipocambio`, `fechavencimiento`, `detraccion`, `selvaproducto`, `selvaservicio`, `condicionpago`, `observacion`, `pdfformato`, `pdf`, `created_at`, `updated_at`, `deleted_at`, `id_created_at`, `id_updated_at`, `id_deleted_at`) VALUES
(1, 1, 1, 2, 'B001', 10, 14, 356, '2020-05-18', 28, 1, 5, 'F', '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', 'VARIOS', '5', '-', NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, 'TICKET', NULL, '2020-05-18 19:08:09', '2020-05-18 19:09:43', NULL, 1, 1, NULL),
(2, 1, 1, 2, 'B001', 22, 31, 356, '2020-06-07', 27, 1, 10, 'F', '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', 'VARIOS', '5', '-', NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, 'TICKET', NULL, '2020-06-07 00:40:57', '2020-06-07 00:41:00', NULL, 1, NULL, NULL),
(3, 1, 1, 2, 'B001', 32, 36, 356, '2020-06-07', 27, 1, 5, 'F', '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', 'VARIOS', '5', '-', NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, 'TICKET', NULL, '2020-06-07 00:42:52', '2020-06-07 00:42:54', NULL, 1, NULL, NULL),
(4, 1, 1, 2, 'B001', 37, 41, 356, '2020-06-07', 27, 5, 5, 'FF', '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', 'VARIOS', '5', '-', NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, 'A4', NULL, '2020-06-07 00:43:35', '2020-06-07 00:43:38', NULL, 1, NULL, NULL),
(5, 1, 1, 2, 'B001', 42, 46, 356, '2020-06-07', 27, 5, 5, 'FF', '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', 'VARIOS', '5', '-', NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, 'A4', NULL, '2020-06-07 00:45:29', '2020-06-07 00:45:31', NULL, 1, NULL, NULL),
(6, 1, 1, 2, 'B001', 47, 51, 356, '2020-06-07', 27, 5, 5, 'FF', '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', 'VARIOS', '5', '-', NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, 'A4', NULL, '2020-06-07 00:47:40', '2020-06-07 00:47:50', NULL, 1, NULL, NULL),
(7, 1, 1, 2, 'B001', 52, 56, 356, '2020-06-07', 27, 5, 5, 'FF', '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', 'VARIOS', '5', '-', NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, 'A4', NULL, '2020-06-07 00:49:11', '2020-06-07 00:49:13', NULL, 1, NULL, NULL),
(8, 1, 1, 2, 'B001', 57, 58, 356, '2020-06-07', 27, 2, 2, 'FF', '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', 'VARIOS', '5', '-', NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, 'A4', NULL, '2020-06-07 00:50:22', '2020-06-07 00:50:23', NULL, 1, NULL, NULL),
(9, 1, 1, 2, 'B001', 59, 60, 356, '2020-06-07', 27, 2, 2, 'FF', '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', 'VARIOS', '5', '-', NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, 'A4', NULL, '2020-06-07 00:54:38', '2020-06-07 00:54:41', NULL, 1, NULL, NULL),
(10, 1, 1, 2, 'B001', 61, 62, 356, '2020-06-07', 27, 2, 2, 'FF', '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', 'VARIOS', '5', '-', NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, 'A4', '10.pdf', '2020-06-07 01:09:59', '2020-06-07 01:10:02', NULL, 1, NULL, NULL),
(11, 1, 1, 2, 'B001', 63, 69, 356, '2020-06-07', 27, 1, 7, 'F', '0.00', '0.00', '0.00', '423.73', NULL, '0.00', '0.00', '0.00', '76.27', NULL, '0.00', '500.00', 'QUINIENTOS CON 00/100 SOLES', 'VARIOS', '5', '-', NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, 'TICKET', NULL, '2020-06-07 01:10:48', '2020-06-07 01:10:49', NULL, 1, NULL, NULL),
(12, 1, 1, 2, 'B001', 70, 76, 356, '2020-06-07', 27, 7, 7, 'FF', '0.00', '0.00', '0.00', '423.73', NULL, '0.00', '0.00', '0.00', '76.27', NULL, '0.00', '500.00', 'QUINIENTOS CON 00/100 SOLES', 'VARIOS', '5', '-', NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, 'A4', '12.pdf', '2020-06-07 01:10:58', '2020-06-07 01:11:01', NULL, 1, NULL, NULL),
(13, 1, 1, 2, 'B001', 77, 84, 356, '2020-06-07', 27, 1, 8, 'F', '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', 'VARIOS', '5', '-', NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, 'TICKET', NULL, '2020-06-07 01:11:51', '2020-06-07 01:11:52', NULL, 1, NULL, NULL),
(14, 1, 1, 2, 'B001', 85, 92, 356, '2020-06-07', 27, 8, 8, 'FF', '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', 'VARIOS', '5', '-', NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, 'A4', '14.pdf', '2020-06-07 01:12:07', '2020-06-07 01:12:09', NULL, 1, NULL, NULL),
(15, 1, 1, 2, 'B001', 93, 101, 356, '2020-06-07', 27, 9, 9, 'FF', '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', 'VARIOS', '5', '-', NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, 'A4', '15.pdf', '2020-06-07 01:12:42', '2020-06-07 01:12:46', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `masivodet`
--

CREATE TABLE `masivodet` (
  `id` int(11) NOT NULL,
  `idmasivo` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` decimal(8,3) NOT NULL,
  `unidadmedida` varchar(5) DEFAULT NULL,
  `idimpuesto` int(11) DEFAULT NULL,
  `valorunit` decimal(8,3) DEFAULT NULL,
  `valorventa` decimal(8,2) DEFAULT NULL,
  `impuestobolsa` decimal(8,2) DEFAULT NULL,
  `montototalimpuestos` decimal(8,2) DEFAULT NULL,
  `preciounit` decimal(8,3) NOT NULL,
  `descuento` decimal(8,3) DEFAULT NULL,
  `total` decimal(8,2) NOT NULL,
  `codigo` varchar(16) DEFAULT NULL,
  `codigosunat` varchar(8) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_created_at` int(11) NOT NULL,
  `id_updated_at` int(11) DEFAULT NULL,
  `id_deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `masivodet`
--

INSERT INTO `masivodet` (`id`, `idmasivo`, `idproducto`, `cantidad`, `unidadmedida`, `idimpuesto`, `valorunit`, `valorventa`, `impuestobolsa`, `montototalimpuestos`, `preciounit`, `descuento`, `total`, `codigo`, `codigosunat`, `nombre`, `descripcion`, `created_at`, `updated_at`, `deleted_at`, `id_created_at`, `id_updated_at`, `id_deleted_at`) VALUES
(1, 1, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', NULL, 'Producto', NULL, '2020-05-18 19:08:09', NULL, NULL, 1, NULL, NULL),
(2, 2, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 00:40:57', NULL, NULL, 1, NULL, NULL),
(3, 3, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:42:52', NULL, NULL, 1, NULL, NULL),
(4, 4, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:43:35', NULL, NULL, 1, NULL, NULL),
(5, 5, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:45:29', NULL, NULL, 1, NULL, NULL),
(6, 6, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:47:41', NULL, NULL, 1, NULL, NULL),
(7, 7, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:49:11', NULL, NULL, 1, NULL, NULL),
(8, 8, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:50:22', NULL, NULL, 1, NULL, NULL),
(9, 9, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:54:38', NULL, NULL, 1, NULL, NULL),
(10, 10, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 01:09:59', NULL, NULL, 1, NULL, NULL),
(11, 11, 16, '1.000', 'NIU', 1, '423.729', '423.73', NULL, '76.27', '500.000', '0.000', '500.00', 'Celular01', NULL, 'Celular Huawei', NULL, '2020-06-07 01:10:48', NULL, NULL, 1, NULL, NULL),
(12, 12, 16, '1.000', 'NIU', 1, '423.729', '423.73', NULL, '76.27', '500.000', '0.000', '500.00', 'Celular01', NULL, 'Celular Huawei', NULL, '2020-06-07 01:10:58', NULL, NULL, 1, NULL, NULL),
(13, 13, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:11:51', NULL, NULL, 1, NULL, NULL),
(14, 14, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:12:07', NULL, NULL, 1, NULL, NULL),
(15, 15, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 01:12:42', NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `idmodulo` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `nivel` int(11) NOT NULL,
  `maticon` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`idmodulo`, `parent`, `nombre`, `url`, `orden`, `nivel`, `maticon`) VALUES
(75, NULL, 'Cotizaciones', '/cotizaciones', 2, 1, 'icInsertDriveFile'),
(77, NULL, 'Guias de remisión', '/guias-de-remision', 5, 1, 'icInsertDriveFile'),
(79, NULL, 'Clientes', '/clientes', 8, 1, 'icAccountCircle'),
(80, NULL, 'Compras', '/compras', 9, 1, 'icInsertDriveFile'),
(81, NULL, 'Anulaciones', '/anulaciones', 10, 1, 'icBlock'),
(82, NULL, 'Resúmenes', '/resumenes', 11, 1, 'icInsertDriveFile'),
(83, NULL, 'Contingencias', '/contingencias', 12, 1, 'icInsertDriveFile'),
(84, NULL, 'Reportes', '/reportes', 14, 1, 'icPrint'),
(86, NULL, 'Ventas', '/ventas', 3, 1, 'icShoppingCart'),
(87, NULL, 'Notas de salida', '/notas-de-salida', 15, 1, 'icInsertDriveFile'),
(88, NULL, 'Productos', '/productos', 7, 1, 'icLocalOffer'),
(89, NULL, 'Categorias', '/categorias', 6, 1, 'icBallot'),
(94, NULL, 'Configuración', '/configuracion', 13, 1, 'icSettings'),
(95, NULL, 'Inicio', '/inicio', 1, 1, 'icHome'),
(96, NULL, 'Empresas', '/empresas', 16, 1, 'icDomain'),
(97, NULL, 'Lotes', '/lotes', 4, 1, 'icInsertDriveFile'),
(98, NULL, 'Afiliados', '/afiliados', 8, 1, 'icAccountCircle'),
(99, NULL, 'Personal', '/personal', 8, 1, 'icAccountCircle'),
(100, NULL, 'Proveedores', '/proveedores', 8, 1, 'icAccountCircle');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moduloempresa`
--

CREATE TABLE `moduloempresa` (
  `idmodulo` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `moduloempresa`
--

INSERT INTO `moduloempresa` (`idmodulo`, `idempresa`) VALUES
(75, 1),
(75, 2),
(77, 1),
(77, 2),
(79, 1),
(79, 2),
(80, 1),
(80, 2),
(81, 1),
(81, 2),
(82, 1),
(82, 2),
(83, 1),
(83, 2),
(84, 1),
(84, 2),
(86, 1),
(86, 2),
(87, 1),
(87, 2),
(88, 1),
(88, 2),
(89, 1),
(89, 2),
(94, 1),
(94, 2),
(95, 1),
(95, 2),
(96, 1),
(96, 2),
(97, 1),
(97, 2),
(98, 1),
(98, 2),
(99, 1),
(99, 2),
(100, 1),
(100, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo_users`
--

CREATE TABLE `modulo_users` (
  `iduser` int(11) NOT NULL,
  `idmodulo` int(11) NOT NULL,
  `permiso` char(1) DEFAULT NULL COMMENT 'L: Lectura E:Lectura y Escritura'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `modulo_users`
--

INSERT INTO `modulo_users` (`iduser`, `idmodulo`, `permiso`) VALUES
(1, 75, 'E'),
(1, 77, 'E'),
(1, 79, 'E'),
(1, 80, 'E'),
(1, 81, 'E'),
(1, 82, 'E'),
(1, 83, 'E'),
(1, 84, 'E'),
(1, 86, 'E'),
(1, 87, 'E'),
(1, 88, 'E'),
(1, 89, 'E'),
(1, 94, 'E'),
(1, 95, 'E'),
(1, 96, 'E'),
(1, 97, 'E'),
(1, 98, 'E'),
(1, 99, 'E'),
(1, 100, 'E'),
(2, 75, 'E'),
(2, 77, 'E'),
(2, 79, 'E'),
(2, 80, 'E'),
(2, 81, 'E'),
(2, 82, 'E'),
(2, 83, 'E'),
(2, 84, 'E'),
(2, 86, 'E'),
(2, 87, 'E'),
(2, 88, 'E'),
(2, 89, 'E'),
(2, 94, 'E'),
(2, 95, 'E'),
(2, 96, 'E'),
(2, 97, 'E'),
(2, 98, 'E'),
(2, 99, 'E'),
(2, 100, 'E');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moneda`
--

CREATE TABLE `moneda` (
  `idmoneda` char(3) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `codigopse` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `moneda`
--

INSERT INTO `moneda` (`idmoneda`, `nombre`, `codigopse`) VALUES
('EUR', 'Euro', '3'),
('PEN', 'Soles', '1'),
('USD', 'Dólares', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `unidadmedida` varchar(5) NOT NULL COMMENT 'NIU=Producto ZZ=Servicio',
  `idcategoria` int(11) DEFAULT NULL,
  `codigo` varchar(16) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `imgportada` varchar(200) DEFAULT NULL,
  `moneda` char(3) DEFAULT NULL,
  `costocompra` decimal(8,2) DEFAULT NULL,
  `valorcompra` decimal(8,2) DEFAULT NULL COMMENT 'Incluye IGV',
  `costoventa` decimal(8,2) DEFAULT NULL,
  `valorventa` decimal(8,2) DEFAULT NULL COMMENT 'Incluye IGV',
  `idimpuesto` int(11) DEFAULT NULL COMMENT '1,2,3, ...15',
  `stock` int(11) DEFAULT NULL,
  `codigosunat` varchar(8) DEFAULT NULL COMMENT 'GS1-128',
  `destacado` char(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_created_at` int(11) DEFAULT NULL,
  `id_updated_at` int(11) DEFAULT NULL,
  `id_deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `idempresa`, `unidadmedida`, `idcategoria`, `codigo`, `nombre`, `imgportada`, `moneda`, `costocompra`, `valorcompra`, `costoventa`, `valorventa`, `idimpuesto`, `stock`, `codigosunat`, `destacado`, `created_at`, `updated_at`, `deleted_at`, `id_created_at`, `id_updated_at`, `id_deleted_at`) VALUES
(1, 1, 'NIU', 1, 'PRO0001', 'Producto', NULL, 'PEN', NULL, NULL, '84.75', '100.00', 1, NULL, '10101508', '0', '2020-05-17 01:30:13', '2020-05-18 19:21:45', NULL, NULL, 1, NULL),
(2, 1, 'ZZ', NULL, 'SER0001', 'Servicio', NULL, 'PEN', NULL, NULL, '84.75', '100.00', 1, NULL, NULL, NULL, '2020-05-17 01:30:13', '2020-05-17 01:30:13', NULL, NULL, NULL, NULL),
(3, 2, 'NIU', NULL, 'PRO0001', 'Producto', NULL, 'PEN', NULL, NULL, '84.75', '100.00', 1, NULL, NULL, NULL, '2020-05-17 16:15:19', '2020-05-17 16:15:19', NULL, NULL, NULL, NULL),
(4, 2, 'ZZ', NULL, 'SER0001', 'Servicio', NULL, 'PEN', NULL, NULL, '84.75', '100.00', 1, NULL, NULL, NULL, '2020-05-17 16:15:19', '2020-05-17 16:15:19', NULL, NULL, NULL, NULL),
(5, 1, 'NIU', NULL, 'POLO001', 'Polo Lacoste', NULL, 'PEN', NULL, NULL, NULL, '25.00', 1, NULL, '10101514', '0', '2020-05-28 21:45:17', '2020-05-28 21:45:17', NULL, 1, NULL, NULL),
(6, 1, 'NIU', 1, 'POLY001', 'Polo Yola', NULL, 'PEN', NULL, NULL, NULL, '22.50', 1, NULL, '10101513', '0', '2020-05-28 21:52:10', '2020-05-28 21:52:10', NULL, 1, NULL, NULL),
(7, 1, 'NIU', 1, 'POLOH', 'Polo Hilgfigther', NULL, 'PEN', NULL, NULL, NULL, '35.00', 1, NULL, NULL, '0', '2020-05-28 21:53:29', '2020-05-28 21:53:29', NULL, 1, NULL, NULL),
(8, 1, 'NIU', 1, 'ADID01', 'Polo Adidas Lux', NULL, 'PEN', NULL, NULL, NULL, '50.00', 1, NULL, '10101509', '0', '2020-05-28 22:26:05', '2020-05-28 22:26:05', NULL, 1, NULL, NULL),
(9, 1, 'NIU', NULL, 'GUI001', 'Afeitador Sick III Doble hoja', NULL, 'PEN', NULL, NULL, NULL, '3.50', 1, 5, '10101508', '0', '2020-05-31 12:09:45', '2020-06-01 14:06:26', NULL, 1, 1, NULL),
(10, 1, 'NIU', NULL, 'POLLO01', 'Pollo a la Brasa', NULL, 'PEN', NULL, NULL, NULL, '50.00', 1, NULL, NULL, '0', '2020-05-31 14:51:36', '2020-05-31 14:51:36', NULL, 1, NULL, NULL),
(11, 1, 'NIU', 1, 'papas01', 'Papas Fritas', NULL, 'PEN', NULL, NULL, NULL, '10.00', 1, NULL, NULL, '0', '2020-05-31 14:54:50', '2020-05-31 14:54:50', NULL, 1, NULL, NULL),
(12, 1, 'NIU', NULL, 'camote01', 'Camote frito', NULL, 'PEN', NULL, NULL, NULL, '11.00', 1, NULL, NULL, '0', '2020-05-31 15:03:41', '2020-05-31 15:03:41', NULL, 1, NULL, NULL),
(13, 1, 'NIU', NULL, 'teclado01', 'Teclado Genius', NULL, 'PEN', NULL, NULL, NULL, '50.00', 1, NULL, NULL, '0', '2020-05-31 15:05:17', '2020-05-31 15:05:17', NULL, 1, NULL, NULL),
(14, 1, 'NIU', NULL, 'Tecla02', 'Teclado Microsfot', NULL, 'PEN', NULL, NULL, NULL, '80.00', 1, NULL, NULL, '0', '2020-05-31 15:05:56', '2020-05-31 15:05:56', NULL, 1, NULL, NULL),
(15, 1, 'NIU', NULL, 'B001', 'Teclado IBM', NULL, 'PEN', NULL, NULL, NULL, '59.90', 1, NULL, NULL, '0', '2020-05-31 15:10:01', '2020-05-31 15:10:01', NULL, 1, NULL, NULL),
(16, 1, 'NIU', NULL, 'Celular01', 'Celular Huawei', NULL, 'PEN', NULL, NULL, NULL, '500.00', 1, NULL, NULL, '0', '2020-05-31 15:48:20', '2020-05-31 15:48:20', NULL, 1, NULL, NULL),
(17, 1, 'NIU', NULL, 'celular02', 'Celular Iphone', NULL, 'PEN', NULL, NULL, NULL, '2999.00', 1, NULL, NULL, '0', '2020-05-31 15:51:00', '2020-05-31 15:51:00', NULL, 1, NULL, NULL),
(18, 1, 'NIU', NULL, 'SAMSU01', 'Celular Galaxy S XI', NULL, 'PEN', NULL, NULL, NULL, '2500.00', 1, NULL, NULL, '0', '2020-05-31 17:37:36', '2020-05-31 17:37:36', NULL, 1, NULL, NULL),
(19, 1, 'NIU', NULL, 'Celular04', 'Celular HTC One', NULL, 'PEN', NULL, NULL, NULL, '1999.00', 1, NULL, NULL, '0', '2020-05-31 17:38:33', '2020-05-31 17:38:33', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE `provincia` (
  `id` char(4) NOT NULL,
  `codigo` char(2) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`id`, `codigo`, `nombre`) VALUES
('1501', '15', 'LIMA'),
('1701', '17', 'TAMBOPATA'),
('1702', '17', 'MANU'),
('1703', '17', 'TAHUAMANU');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sede`
--

CREATE TABLE `sede` (
  `idsede` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `abreviatura` varchar(7) DEFAULT NULL,
  `comercial` char(1) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `ubigeo` char(6) DEFAULT NULL,
  `departamento` varchar(100) DEFAULT NULL,
  `provincia` varchar(100) DEFAULT NULL,
  `distrito` varchar(100) DEFAULT NULL,
  `codigosunat` char(4) DEFAULT NULL COMMENT 'Código de sucursal en Sunat ',
  `pdffactura` varchar(6) DEFAULT NULL COMMENT 'A4, A5, TICKET',
  `pdfboleta` varchar(6) DEFAULT NULL COMMENT 'A4, A5, TICKET',
  `pdfcabecera` varchar(100) DEFAULT NULL,
  `pdfnombre` varchar(100) DEFAULT NULL,
  `pdfcolor` char(11) DEFAULT NULL,
  `imgcpe` varchar(100) DEFAULT NULL,
  `pseurl` varchar(200) DEFAULT NULL,
  `psetoken` varchar(400) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_created_at` int(11) DEFAULT NULL,
  `id_updated_at` int(11) DEFAULT NULL,
  `id_deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sede`
--

INSERT INTO `sede` (`idsede`, `idempresa`, `nombre`, `abreviatura`, `comercial`, `direccion`, `ubigeo`, `departamento`, `provincia`, `distrito`, `codigosunat`, `pdffactura`, `pdfboleta`, `pdfcabecera`, `pdfnombre`, `pdfcolor`, `imgcpe`, `pseurl`, `psetoken`, `created_at`, `updated_at`, `deleted_at`, `id_created_at`, `id_updated_at`, `id_deleted_at`) VALUES
(1, 1, 'Lima', NULL, '1', 'Jr. Eleazar Guzmán y Barrón 2636', '150104', 'LIMA', 'LIMA', 'BARRANCO', '0000', 'A4', 'A4', NULL, NULL, '0,92,184', NULL, NULL, NULL, '2020-05-17 01:30:13', '2020-05-25 12:13:07', NULL, NULL, 1, NULL),
(2, 2, 'Local principal', NULL, '1', 'JR. DANIEL ALCIDES CARRION LT. 10F MZ. D - MADRE DE DIOS TAMBOPATA  TAMBOPATA', NULL, 'MADRE DE DIOS', 'TAMBOPATA ', 'TAMBOPATA', '0000', 'A4', 'A4', NULL, NULL, '25,8,255', NULL, NULL, NULL, '2020-05-17 16:15:19', '2020-05-17 16:15:19', NULL, NULL, NULL, NULL),
(3, 1, 'Puerto Maldonado', NULL, '1', 'Av. León Velarde S/N', '170101', 'MADRE DE DIOS', 'TAMBOPATA', 'TAMBOPATA', '0000', 'A4', 'A4', NULL, NULL, '25,8,255', NULL, NULL, NULL, '2020-05-18 18:49:39', '2020-05-25 12:26:38', NULL, 1, 1, NULL),
(4, 1, 'ssss', NULL, '0', 'd', '170104', 'MADRE DE DIOS', 'TAMBOPATA', 'LABERINTO', '0000', NULL, NULL, NULL, NULL, '25,8,255', NULL, NULL, NULL, '2020-05-25 12:22:29', '2020-05-25 12:23:19', '2020-05-25 12:23:19', 1, 1, 1),
(5, 1, 'MARAVILLA', 'MAR', '0', 'Av. Tambopata S/N', '150103', 'LIMA', 'LIMA', 'ATE', '0000', NULL, NULL, NULL, NULL, '25,8,255', NULL, NULL, NULL, '2020-05-25 12:39:50', '2020-05-25 14:26:18', NULL, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sede_users`
--

CREATE TABLE `sede_users` (
  `idsede` int(11) NOT NULL,
  `iduser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sede_users`
--

INSERT INTO `sede_users` (`idsede`, `iduser`) VALUES
(1, 1),
(2, 2),
(3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubigeo`
--

CREATE TABLE `ubigeo` (
  `idubigeo` char(9) NOT NULL,
  `pais` char(2) NOT NULL COMMENT 'PE: PERU\n',
  `dpto` char(3) DEFAULT NULL,
  `prov` char(2) DEFAULT NULL,
  `dist` char(2) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE `unidad` (
  `nombre` varchar(100) NOT NULL,
  `codigo` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`nombre`, `codigo`) VALUES
('Bolsa', 'BG'),
('Caja', 'BX'),
('Docena', 'DZN'),
('Kilogramo', 'KGM'),
('Metro', 'MTR'),
('Unidades', 'NIU'),
('Otros', 'ZZ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidadempresa`
--

CREATE TABLE `unidadempresa` (
  `codigo` varchar(5) NOT NULL,
  `idempresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `unidadempresa`
--

INSERT INTO `unidadempresa` (`codigo`, `idempresa`) VALUES
('BG', 2),
('BX', 1),
('BX', 2),
('KGM', 2),
('NIU', 1),
('NIU', 2),
('ZZ', 1),
('ZZ', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email_verified_at` char(1) NOT NULL DEFAULT '0' COMMENT 'Varificación vía correo',
  `verified` char(1) DEFAULT NULL,
  `verification_token` text,
  `celular` varchar(20) DEFAULT NULL,
  `acceso` char(1) DEFAULT NULL COMMENT '0: Sin acceso 1: Acceso a sistema',
  `administrador` char(1) DEFAULT NULL,
  `imgperfil` varchar(100) DEFAULT NULL,
  `idempresa` int(11) NOT NULL COMMENT 'Temporal para JWT',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_created_at` int(11) DEFAULT NULL,
  `id_updated_at` int(11) DEFAULT NULL,
  `id_deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `email_verified_at`, `verified`, `verification_token`, `celular`, `acceso`, `administrador`, `imgperfil`, `idempresa`, `created_at`, `updated_at`, `deleted_at`, `id_created_at`, `id_updated_at`, `id_deleted_at`) VALUES
(1, 'CHAUCA CHAVEZ JULIO CESAR', 'chaucachavez@gmail.com', '$2y$10$UYiVSF4MB9AUllJ7QOlBXeIeaPhrpJ6ajW7bVSZPN/zLUJvCKbR/.', '0', '0', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2VtcHJlc2FzIiwiaWF0IjoxNTg5Njk3MDEzLCJleHAiOjE1OTAzMDE4MTMsIm5iZiI6MTU4OTY5NzAxMywianRpIjoiOGNQbVFYbHRLQlFmNGdwbyIsInN1YiI6MSwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.QenlYFCgWB_RTp7_iAlA5XGIXszV-xGy_18TmOeM54c', '970879206', '1', '1', 'VtqfpUixvrpuK28ECXcfz1HFHy3n9Q7kG6nTHVyL.jpeg', 1, '2020-05-17 01:30:13', '2020-06-06 23:47:17', NULL, NULL, NULL, NULL),
(2, 'INVERSIONES TURISTICO LA CASA VIKINGO SRL', 'cesar.cardenaschauca@gmail.com', '$2y$10$1urrpSsRqj/PhgWcj47lyu3ZWm160abxwVSqGcg0xLl6unxLphgsK', '0', '0', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlhcHAucGVcL2VtcHJlc2FzIiwiaWF0IjoxNTg5NzUwMTE5LCJleHAiOjE1OTAzNTQ5MTksIm5iZiI6MTU4OTc1MDExOSwianRpIjoiU2ZiaG9vekpIR282T1hjRiIsInN1YiI6MiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.9nNJ4vViQtIWRzVejfB7k3HdIx4q8S6_rSga3cth0CA', NULL, '1', '1', 'profile.jpg', 2, '2020-05-17 16:15:19', '2020-05-17 16:15:19', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `idsede` int(11) NOT NULL,
  `iddocumentofiscal` int(11) NOT NULL,
  `serie` varchar(5) NOT NULL,
  `numero` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `fechaemision` date DEFAULT NULL,
  `idestadodocumento` int(11) DEFAULT NULL COMMENT '26: Borrador 27:Emitido 28:Anulado ',
  `exonerada` decimal(8,2) DEFAULT NULL,
  `inafecta` decimal(8,2) DEFAULT NULL,
  `gratuita` decimal(8,2) DEFAULT NULL,
  `gravada` decimal(8,2) DEFAULT NULL,
  `descuentoporcentaje` decimal(8,2) DEFAULT NULL,
  `descuentoglobal` decimal(8,2) DEFAULT NULL,
  `descuentoitem` decimal(8,2) DEFAULT NULL COMMENT 'Sumatoría de descuento por ítem',
  `descuentototal` decimal(8,2) DEFAULT NULL,
  `valorimpuesto` decimal(8,2) DEFAULT NULL,
  `cargo` decimal(8,2) DEFAULT NULL,
  `totalimpuestobolsa` decimal(8,2) DEFAULT NULL,
  `total` decimal(8,2) DEFAULT NULL,
  `totalletra` varchar(200) DEFAULT NULL,
  `pagado` decimal(8,2) DEFAULT NULL COMMENT 'Monto del cliente',
  `vuelto` decimal(8,2) DEFAULT NULL COMMENT 'Vuelto al cliente',
  `descripcion` varchar(250) DEFAULT NULL COMMENT 'Es obligatorio siempre y cuando el atributo ''tipoDocRelacionado'' = (01 o 03)',
  `clientenombre` varchar(250) DEFAULT NULL,
  `clientedoc` varchar(10) DEFAULT NULL,
  `clientenumerodoc` varchar(11) DEFAULT NULL,
  `clientedireccion` varchar(200) DEFAULT NULL,
  `cuentadetraccion` varchar(20) DEFAULT NULL,
  `motivoanulacion` varchar(100) DEFAULT NULL,
  `idpersonalanula` int(11) DEFAULT NULL COMMENT 'Personal que anula cpe',
  `tiponc` int(1) DEFAULT NULL COMMENT '1:AnulaciónOperacion 2:DevolucionTotal 3:DevolucionPorItem',
  `documentonc` int(11) DEFAULT NULL COMMENT '1:Factura 2:Boleta',
  `serienc` varchar(4) DEFAULT NULL COMMENT 'Documento relacionado para NC	',
  `numeronc` int(11) DEFAULT NULL COMMENT 'Documento relacionado para NC	',
  `operacion` int(11) DEFAULT NULL COMMENT '1=Venta interna 2=Exportación 3=No domiciliado 4=Venta interna–anticipos...',
  `moneda` char(3) DEFAULT NULL,
  `tipocambio` decimal(8,3) DEFAULT NULL,
  `fechavencimiento` date DEFAULT NULL,
  `detraccion` char(1) DEFAULT NULL,
  `selvaproducto` char(1) DEFAULT NULL,
  `selvaservicio` char(1) DEFAULT NULL,
  `ordencompra` varchar(100) DEFAULT NULL,
  `guiaremitente` varchar(100) DEFAULT NULL,
  `guiatransportista` varchar(100) DEFAULT NULL,
  `placavehiculo` varchar(100) DEFAULT NULL,
  `condicionpago` varchar(200) DEFAULT NULL,
  `observacion` varchar(200) DEFAULT NULL,
  `pdfformato` varchar(6) DEFAULT NULL COMMENT 'A4, A5, TICKET',
  `cpecorreo` varchar(100) DEFAULT NULL COMMENT 'Correo de envío para cpe	',
  `sendcorreo` char(1) DEFAULT NULL COMMENT '0:Por enviar 1: Enviado',
  `sunat_aceptado` varchar(10) DEFAULT NULL,
  `sunat_nota` varchar(250) DEFAULT NULL COMMENT 'Cuando hay errores en la SUNAT se describirá el error	',
  `qr` varchar(250) DEFAULT NULL COMMENT 'Código QR',
  `hash` varchar(250) DEFAULT NULL COMMENT 'Código HASH',
  `pdf` varchar(250) DEFAULT NULL,
  `xml` varchar(250) DEFAULT NULL,
  `cdr` varchar(250) DEFAULT NULL,
  `errors` text,
  `sunat_anulado_ticket` varchar(100) DEFAULT NULL,
  `sunat_anulado_aceptado` varchar(10) DEFAULT NULL,
  `sunat_anulado_key` varchar(250) DEFAULT NULL,
  `sunat_anulado_nota` varchar(250) DEFAULT NULL COMMENT 'Cuando hay errores en la SUNAT se describirá el error',
  `enlace` varchar(250) DEFAULT NULL,
  `idmasivo` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_created_at` int(11) NOT NULL,
  `id_updated_at` int(11) DEFAULT NULL,
  `id_deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`idventa`, `idempresa`, `idsede`, `iddocumentofiscal`, `serie`, `numero`, `idcliente`, `fechaemision`, `idestadodocumento`, `exonerada`, `inafecta`, `gratuita`, `gravada`, `descuentoporcentaje`, `descuentoglobal`, `descuentoitem`, `descuentototal`, `valorimpuesto`, `cargo`, `totalimpuestobolsa`, `total`, `totalletra`, `pagado`, `vuelto`, `descripcion`, `clientenombre`, `clientedoc`, `clientenumerodoc`, `clientedireccion`, `cuentadetraccion`, `motivoanulacion`, `idpersonalanula`, `tiponc`, `documentonc`, `serienc`, `numeronc`, `operacion`, `moneda`, `tipocambio`, `fechavencimiento`, `detraccion`, `selvaproducto`, `selvaservicio`, `ordencompra`, `guiaremitente`, `guiatransportista`, `placavehiculo`, `condicionpago`, `observacion`, `pdfformato`, `cpecorreo`, `sendcorreo`, `sunat_aceptado`, `sunat_nota`, `qr`, `hash`, `pdf`, `xml`, `cdr`, `errors`, `sunat_anulado_ticket`, `sunat_anulado_aceptado`, `sunat_anulado_key`, `sunat_anulado_nota`, `enlace`, `idmasivo`, `created_at`, `updated_at`, `deleted_at`, `id_created_at`, `id_updated_at`, `id_deleted_at`) VALUES
(1, 1, 1, 2, 'B001', 1, 3, '2020-05-17', 27, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'LOSTAUNAU BLASS, GILMER VLADIMIR', '1', '44120025', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-05-17', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-1.png', NULL, '10441200264-03-B001-1.pdf', '10441200264-03-B001-1.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-17 01:30:57', '2020-05-17 01:31:01', NULL, 1, NULL, NULL),
(2, 1, 1, 2, 'B001', 2, 5, '2020-05-17', 27, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ, YOLANDA', '1', '46833730', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-05-17', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-2.png', NULL, '10441200264-03-B001-2.pdf', '10441200264-03-B001-2.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-17 15:45:58', '2020-05-17 15:46:01', NULL, 1, NULL, NULL),
(3, 1, 1, 2, 'B001', 3, 5, '2020-05-17', 27, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ, YOLANDA', '1', '46833730', 'Av. León velarde S/N - Puerto Maldonado', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-05-17', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', 'chaucayolanda@gmail.com', NULL, NULL, NULL, '10441200264-03-B001-3.png', NULL, '10441200264-03-B001-3.pdf', '10441200264-03-B001-3.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-17 15:50:44', '2020-05-17 15:50:44', NULL, 1, NULL, NULL),
(4, 1, 1, 2, 'B001', 4, 5, '2020-05-17', 27, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ, YOLANDA', '1', '46833730', 'Av. León velarde S/N - Puerto Maldonado', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-05-17', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', 'chaucayolanda@gmail.com', NULL, NULL, NULL, '10441200264-03-B001-4.png', NULL, '10441200264-03-B001-4.pdf', '10441200264-03-B001-4.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-17 15:55:00', '2020-05-17 15:55:00', NULL, 1, NULL, NULL),
(5, 1, 1, 2, 'B001', 5, 5, '2020-05-17', 27, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ, YOLANDA', '1', '46833730', 'Av. León velarde S/N - Puerto Maldonado', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-05-17', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', 'chaucayolanda@gmail.com', NULL, NULL, NULL, '10441200264-03-B001-5.png', NULL, '10441200264-03-B001-5.pdf', '10441200264-03-B001-5.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-17 15:59:10', '2020-05-17 15:59:11', NULL, 1, NULL, NULL),
(6, 1, 1, 2, 'B001', 6, 5, '2020-05-17', 27, '0.00', '0.00', '0.00', '169.50', NULL, '0.00', '0.00', '0.00', '30.50', NULL, '0.00', '200.00', 'DOSCIENTOS CON 00/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ, YOLANDA', '1', '46833730', 'Av. León velarde S/N - Puerto Maldonado', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-05-17', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', 'chaucayolanda@gmail.com', NULL, NULL, NULL, '10441200264-03-B001-6.png', NULL, '10441200264-03-B001-6.pdf', '10441200264-03-B001-6.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-17 16:00:55', '2020-05-17 16:00:55', NULL, 1, NULL, NULL),
(7, 1, 1, 2, 'B001', 7, 5, '2020-05-17', 27, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ, YOLANDA', '1', '46833730', 'Av. León velarde S/N - Puerto Maldonado', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-05-17', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', 'chaucayolanda@gmail.com', NULL, NULL, NULL, '10441200264-03-B001-7.png', NULL, '10441200264-03-B001-7.pdf', '10441200264-03-B001-7.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-17 16:02:40', '2020-05-17 16:02:41', NULL, 1, NULL, NULL),
(8, 1, 1, 2, 'B001', 8, 5, '2020-05-17', 27, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ, YOLANDA', '1', '46833730', 'Av. León velarde S/N - Puerto Maldonado', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-05-17', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', 'chaucayolanda@gmail.com', NULL, NULL, NULL, '10441200264-03-B001-8.png', NULL, '10441200264-03-B001-8.pdf', '10441200264-03-B001-8.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-17 16:04:02', '2020-05-17 16:04:02', NULL, 1, NULL, NULL),
(9, 1, 1, 2, 'B001', 9, 5, '2020-05-17', 27, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ, YOLANDA', '1', '46833730', 'Av. León velarde S/N - Puerto Maldonado', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-05-17', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', 'chaucayolanda@gmail.com', NULL, NULL, NULL, '10441200264-03-B001-9.png', NULL, '10441200264-03-B001-9.pdf', '10441200264-03-B001-9.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-17 16:04:43', '2020-05-17 16:04:43', NULL, 1, NULL, NULL),
(10, 1, 1, 2, 'B001', 10, 356, '2020-05-18', 28, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, '10441200264-03-B001-10.png', NULL, NULL, '10441200264-03-B001-10.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2020-05-18 19:08:09', '2020-05-18 19:09:43', NULL, 1, 1, NULL),
(11, 1, 1, 2, 'B001', 11, 356, '2020-05-18', 28, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2020-05-18 19:08:09', '2020-05-18 19:09:43', NULL, 1, 1, NULL),
(12, 1, 1, 2, 'B001', 12, 356, '2020-05-18', 28, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2020-05-18 19:08:09', '2020-05-18 19:09:43', NULL, 1, 1, NULL),
(13, 1, 1, 2, 'B001', 13, 356, '2020-05-18', 28, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2020-05-18 19:08:09', '2020-05-18 19:09:43', NULL, 1, 1, NULL),
(14, 1, 1, 2, 'B001', 14, 356, '2020-05-18', 28, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2020-05-18 19:08:09', '2020-05-18 19:09:43', NULL, 1, 1, NULL),
(15, 1, 1, 2, 'B001', 15, 1, '2020-05-18', 27, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ JULIO CESAR', '2', '10441200264', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-05-18', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', 'chaucachavez@gmail.com', NULL, NULL, NULL, '10441200264-03-B001-15.png', NULL, '10441200264-03-B001-15.pdf', '10441200264-03-B001-15.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-18 19:31:24', '2020-05-18 19:31:26', NULL, 1, NULL, NULL),
(16, 1, 1, 2, 'B001', 16, 6, '2020-05-18', 27, '90.00', '90.00', '0.00', '76.27', '10.00', '28.48', '0.00', '28.48', '13.73', '50.00', '0.20', '320.20', 'TRESCIENTOS VEINTE CON 2/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ, JULIO CESAR', '1', '44120026', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-05-18', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-16.png', NULL, '10441200264-03-B001-16.pdf', '10441200264-03-B001-16.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-18 19:32:45', '2020-05-18 19:32:45', NULL, 1, NULL, NULL),
(17, 1, 1, 2, 'B001', 17, 3, '2020-05-25', 27, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'LOSTAUNAU BLASS, GILMER VLADIMIR', '1', '44120025', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-05-25', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-17.png', NULL, '10441200264-03-B001-17.pdf', '10441200264-03-B001-17.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-25 12:31:46', '2020-05-25 12:31:50', NULL, 1, NULL, NULL),
(18, 1, 1, 2, 'B001', 18, 5, '2020-05-28', 27, '0.00', '0.00', '0.00', '169.50', NULL, '0.00', '0.00', '0.00', '30.50', NULL, '0.00', '200.00', 'DOSCIENTOS CON 00/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ, YOLANDA', '1', '46833730', 'Av. León velarde S/N - Puerto Maldonado', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-05-28', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', 'chaucayolanda@gmail.com', NULL, NULL, NULL, '10441200264-03-B001-18.png', NULL, '10441200264-03-B001-18.pdf', '10441200264-03-B001-18.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-28 13:11:51', '2020-05-28 13:11:56', NULL, 1, NULL, NULL),
(21, 1, 1, 13, 'B001', 1, 5, '2020-05-28', 27, '0.00', '0.00', '0.00', '127.12', NULL, '0.00', '0.00', '0.00', '22.88', NULL, '0.00', '150.00', 'CIENTO CINCUENTA CON 00/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ, YOLANDA', '1', '46833730', 'Av. León velarde S/N - Puerto Maldonado', NULL, NULL, NULL, 1, 2, 'B001', 18, 1, 'PEN', NULL, '2020-05-28', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', 'chaucayolanda@gmail.com', NULL, NULL, NULL, '10441200264-07-B001-1.png', NULL, '10441200264-07-B001-1.pdf', '10441200264-07-B001-1.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-28 13:26:41', '2020-05-28 13:26:41', NULL, 1, NULL, NULL),
(22, 1, 1, 1, 'F001', 1, 4, '2020-05-28', 27, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'EMPRESA ADMINISTRADORA DE SALUD LA UNION S.A.C.', '2', '20603080603', 'AV. JAVIER PRADO OESTE NRO. 757 DPTO. 905 - LIMA LIMA  MAGDALENA DEL MAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-05-28', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-01-F001-1.png', NULL, '10441200264-01-F001-1.pdf', '10441200264-01-F001-1.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-28 18:52:34', '2020-05-28 18:52:40', NULL, 1, NULL, NULL),
(25, 1, 1, 2, 'B001', 19, 2, '2020-05-31', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', 'LIMA - PERU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-05-31', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-19.png', NULL, '10441200264-03-B001-19.pdf', '10441200264-03-B001-19.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-31 20:22:29', '2020-05-31 20:22:33', NULL, 1, NULL, NULL),
(26, 1, 1, 13, 'B001', 2, 2, '2020-05-31', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', 'LIMA - PERU', NULL, NULL, NULL, 1, 2, 'x001', 19, 1, 'PEN', NULL, '2020-05-31', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-07-B001-2.png', NULL, '10441200264-07-B001-2.pdf', '10441200264-07-B001-2.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-31 20:27:10', '2020-05-31 20:27:11', NULL, 1, NULL, NULL),
(27, 1, 1, 2, 'B001', 20, 1, '2020-05-31', 27, '0.00', '0.00', '0.00', '12.29', NULL, '0.00', '0.00', '0.00', '2.21', NULL, '0.00', '14.50', 'CATORCE CON 5/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ JULIO CESAR', '2', '10441200264', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-05-31', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', 'chaucachavez@gmail.com', NULL, NULL, NULL, '10441200264-03-B001-20.png', NULL, '10441200264-03-B001-20.pdf', '10441200264-03-B001-20.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-31 20:54:36', '2020-05-31 20:54:36', NULL, 1, NULL, NULL),
(28, 1, 1, 13, 'F001', 1, 1, '2020-05-31', 27, '0.00', '0.00', '0.00', '12.29', NULL, '0.00', '0.00', '0.00', '2.21', NULL, '0.00', '14.50', 'CATORCE CON 5/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ JULIO CESAR', '2', '10441200264', '-', NULL, NULL, NULL, 1, 1, '002', 1, 1, 'PEN', NULL, '2020-05-31', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', 'chaucachavez@gmail.com', NULL, NULL, NULL, '10441200264-07-F001-1.png', NULL, '10441200264-07-F001-1.pdf', '10441200264-07-F001-1.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-31 21:17:55', '2020-05-31 21:17:56', NULL, 1, NULL, NULL),
(29, 1, 1, 13, 'B001', 3, 1, '2020-05-31', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ JULIO CESAR', '2', '10441200264', '-', NULL, NULL, NULL, 1, 2, 'B001', 20, 1, 'PEN', NULL, '2020-05-31', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', 'chaucachavez@gmail.com', NULL, NULL, NULL, '10441200264-07-B001-3.png', NULL, '10441200264-07-B001-3.pdf', '10441200264-07-B001-3.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-31 21:18:30', '2020-05-31 21:18:30', NULL, 1, NULL, NULL),
(30, 1, 1, 10, 'F001', 1, 1, '2020-05-31', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ JULIO CESAR', '2', '10441200264', '-', NULL, NULL, NULL, 2, 1, 'F001', 1, 1, 'PEN', NULL, '2020-05-31', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', 'chaucachavez@gmail.com', '1', NULL, NULL, '10441200264-08-F001-1.png', NULL, '10441200264-08-F001-1.pdf', '10441200264-08-F001-1.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-31 23:54:03', '2020-06-06 11:36:16', NULL, 1, NULL, NULL),
(31, 1, 1, 10, 'B001', 1, 2, '2020-05-31', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', 'LIMA - PERU', NULL, NULL, NULL, 1, 2, 'B001', 19, 1, 'PEN', NULL, '2020-05-31', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-08-B001-1.png', NULL, '10441200264-08-B001-1.pdf', '10441200264-08-B001-1.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-31 23:58:15', '2020-05-31 23:58:15', NULL, 1, NULL, NULL),
(32, 1, 1, 10, 'B001', 2, 1, '2020-05-31', 27, '0.00', '0.00', '0.00', '84.75', NULL, '0.00', '0.00', '0.00', '15.25', NULL, '0.00', '100.00', 'CIENTO CON 00/100 SOLES', NULL, NULL, NULL, 'CHAUCA CHAVEZ JULIO CESAR', '2', '10441200264', '-', NULL, NULL, NULL, 1, 2, 'B001', 15, 1, 'PEN', NULL, '2020-05-31', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', 'chaucachavez@gmail.com', NULL, NULL, NULL, '10441200264-08-B001-2.png', NULL, '10441200264-08-B001-2.pdf', '10441200264-08-B001-2.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-31 23:58:58', '2020-05-31 23:58:59', NULL, 1, NULL, NULL),
(33, 1, 1, 2, 'B001', 21, 16, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'CARLOS COLQUI, GUSTAVO', '1', '44120015', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-06-08', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-21.png', NULL, '10441200264-03-B001-21.pdf', '10441200264-03-B001-21.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-06-07 00:12:39', '2020-06-07 00:12:45', NULL, 1, NULL, NULL),
(34, 1, 1, 2, 'B001', 22, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, '10441200264-03-B001-22.png', NULL, NULL, '10441200264-03-B001-22.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2020-06-07 00:40:58', '2020-06-07 00:41:00', NULL, 1, NULL, NULL),
(35, 1, 1, 2, 'B001', 23, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2020-06-07 00:40:58', '2020-06-07 00:40:58', NULL, 1, NULL, NULL),
(36, 1, 1, 2, 'B001', 24, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2020-06-07 00:40:58', '2020-06-07 00:40:58', NULL, 1, NULL, NULL),
(37, 1, 1, 2, 'B001', 25, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2020-06-07 00:40:58', '2020-06-07 00:40:58', NULL, 1, NULL, NULL),
(38, 1, 1, 2, 'B001', 26, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2020-06-07 00:40:58', '2020-06-07 00:40:58', NULL, 1, NULL, NULL),
(39, 1, 1, 2, 'B001', 27, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2020-06-07 00:40:58', '2020-06-07 00:40:58', NULL, 1, NULL, NULL),
(40, 1, 1, 2, 'B001', 28, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2020-06-07 00:40:59', '2020-06-07 00:40:59', NULL, 1, NULL, NULL),
(41, 1, 1, 2, 'B001', 29, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2020-06-07 00:40:59', '2020-06-07 00:40:59', NULL, 1, NULL, NULL),
(42, 1, 1, 2, 'B001', 30, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2020-06-07 00:40:59', '2020-06-07 00:40:59', NULL, 1, NULL, NULL),
(43, 1, 1, 2, 'B001', 31, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2020-06-07 00:40:59', '2020-06-07 00:40:59', NULL, 1, NULL, NULL),
(44, 1, 1, 2, 'B001', 32, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, '10441200264-03-B001-32.png', NULL, NULL, '10441200264-03-B001-32.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2020-06-07 00:42:53', '2020-06-07 00:42:54', NULL, 1, NULL, NULL),
(45, 1, 1, 2, 'B001', 33, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2020-06-07 00:42:53', '2020-06-07 00:42:53', NULL, 1, NULL, NULL),
(46, 1, 1, 2, 'B001', 34, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2020-06-07 00:42:53', '2020-06-07 00:42:53', NULL, 1, NULL, NULL),
(47, 1, 1, 2, 'B001', 35, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2020-06-07 00:42:53', '2020-06-07 00:42:53', NULL, 1, NULL, NULL),
(48, 1, 1, 2, 'B001', 36, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2020-06-07 00:42:53', '2020-06-07 00:42:53', NULL, 1, NULL, NULL),
(49, 1, 1, 2, 'B001', 37, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-37.png', NULL, '10441200264-03-B001-37.pdf', '10441200264-03-B001-37.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, '2020-06-07 00:43:35', '2020-06-07 00:43:36', NULL, 1, NULL, NULL),
(50, 1, 1, 2, 'B001', 38, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-38.png', NULL, '10441200264-03-B001-38.pdf', '10441200264-03-B001-38.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, '2020-06-07 00:43:35', '2020-06-07 00:43:36', NULL, 1, NULL, NULL),
(51, 1, 1, 2, 'B001', 39, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-39.png', NULL, '10441200264-03-B001-39.pdf', '10441200264-03-B001-39.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, '2020-06-07 00:43:35', '2020-06-07 00:43:36', NULL, 1, NULL, NULL),
(52, 1, 1, 2, 'B001', 40, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-40.png', NULL, '10441200264-03-B001-40.pdf', '10441200264-03-B001-40.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, '2020-06-07 00:43:35', '2020-06-07 00:43:37', NULL, 1, NULL, NULL),
(53, 1, 1, 2, 'B001', 41, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-41.png', NULL, '10441200264-03-B001-41.pdf', '10441200264-03-B001-41.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, '2020-06-07 00:43:35', '2020-06-07 00:43:37', NULL, 1, NULL, NULL),
(54, 1, 1, 2, 'B001', 42, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-42.png', NULL, '10441200264-03-B001-42.pdf', '10441200264-03-B001-42.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, '2020-06-07 00:45:29', '2020-06-07 00:45:30', NULL, 1, NULL, NULL),
(55, 1, 1, 2, 'B001', 43, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-43.png', NULL, '10441200264-03-B001-43.pdf', '10441200264-03-B001-43.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, '2020-06-07 00:45:29', '2020-06-07 00:45:30', NULL, 1, NULL, NULL),
(56, 1, 1, 2, 'B001', 44, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-44.png', NULL, '10441200264-03-B001-44.pdf', '10441200264-03-B001-44.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, '2020-06-07 00:45:29', '2020-06-07 00:45:30', NULL, 1, NULL, NULL),
(57, 1, 1, 2, 'B001', 45, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-45.png', NULL, '10441200264-03-B001-45.pdf', '10441200264-03-B001-45.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, '2020-06-07 00:45:29', '2020-06-07 00:45:30', NULL, 1, NULL, NULL),
(58, 1, 1, 2, 'B001', 46, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-46.png', NULL, '10441200264-03-B001-46.pdf', '10441200264-03-B001-46.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, '2020-06-07 00:45:29', '2020-06-07 00:45:31', NULL, 1, NULL, NULL),
(59, 1, 1, 2, 'B001', 47, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-47.png', NULL, '10441200264-03-B001-47.pdf', '10441200264-03-B001-47.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, '2020-06-07 00:47:42', '2020-06-07 00:47:46', NULL, 1, NULL, NULL),
(60, 1, 1, 2, 'B001', 48, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-48.png', NULL, '10441200264-03-B001-48.pdf', '10441200264-03-B001-48.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, '2020-06-07 00:47:43', '2020-06-07 00:47:48', NULL, 1, NULL, NULL),
(61, 1, 1, 2, 'B001', 49, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-49.png', NULL, '10441200264-03-B001-49.pdf', '10441200264-03-B001-49.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, '2020-06-07 00:47:44', '2020-06-07 00:47:49', NULL, 1, NULL, NULL),
(62, 1, 1, 2, 'B001', 50, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-50.png', NULL, '10441200264-03-B001-50.pdf', '10441200264-03-B001-50.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, '2020-06-07 00:47:44', '2020-06-07 00:47:49', NULL, 1, NULL, NULL),
(63, 1, 1, 2, 'B001', 51, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-51.png', NULL, '10441200264-03-B001-51.pdf', '10441200264-03-B001-51.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, '2020-06-07 00:47:44', '2020-06-07 00:47:50', NULL, 1, NULL, NULL),
(64, 1, 1, 2, 'B001', 52, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-52.png', NULL, '10441200264-03-B001-52.pdf', '10441200264-03-B001-52.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, '2020-06-07 00:49:11', '2020-06-07 00:49:12', NULL, 1, NULL, NULL),
(65, 1, 1, 2, 'B001', 53, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-53.png', NULL, '10441200264-03-B001-53.pdf', '10441200264-03-B001-53.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, '2020-06-07 00:49:11', '2020-06-07 00:49:12', NULL, 1, NULL, NULL),
(66, 1, 1, 2, 'B001', 54, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-54.png', NULL, '10441200264-03-B001-54.pdf', '10441200264-03-B001-54.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, '2020-06-07 00:49:11', '2020-06-07 00:49:12', NULL, 1, NULL, NULL),
(67, 1, 1, 2, 'B001', 55, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-55.png', NULL, '10441200264-03-B001-55.pdf', '10441200264-03-B001-55.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, '2020-06-07 00:49:11', '2020-06-07 00:49:13', NULL, 1, NULL, NULL),
(68, 1, 1, 2, 'B001', 56, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-56.png', NULL, '10441200264-03-B001-56.pdf', '10441200264-03-B001-56.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, '2020-06-07 00:49:11', '2020-06-07 00:49:13', NULL, 1, NULL, NULL),
(69, 1, 1, 2, 'B001', 57, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-57.png', NULL, '10441200264-03-B001-57.pdf', '10441200264-03-B001-57.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, '2020-06-07 00:50:22', '2020-06-07 00:50:23', NULL, 1, NULL, NULL),
(70, 1, 1, 2, 'B001', 58, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-58.png', NULL, '10441200264-03-B001-58.pdf', '10441200264-03-B001-58.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, '2020-06-07 00:50:22', '2020-06-07 00:50:23', NULL, 1, NULL, NULL),
(71, 1, 3, 2, 'B002', 1, 16, '2020-06-07', 27, '0.00', '0.00', '0.00', '2.97', NULL, '0.00', '0.00', '0.00', '0.53', NULL, '0.00', '3.50', 'TRES CON 5/100 SOLES', NULL, NULL, NULL, 'CARLOS COLQUI, GUSTAVO', '1', '44120015', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, '2020-06-07', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B002-1.png', NULL, '10441200264-03-B002-1.pdf', '10441200264-03-B002-1.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-06-07 00:53:43', '2020-06-07 00:53:44', NULL, 1, NULL, NULL),
(72, 1, 1, 2, 'B001', 59, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-59.png', NULL, '10441200264-03-B001-59.pdf', '10441200264-03-B001-59.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, '2020-06-07 00:54:38', '2020-06-07 00:54:41', NULL, 1, NULL, NULL),
(73, 1, 1, 2, 'B001', 60, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-60.png', NULL, '10441200264-03-B001-60.pdf', '10441200264-03-B001-60.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, '2020-06-07 00:54:38', '2020-06-07 00:54:41', NULL, 1, NULL, NULL),
(74, 1, 1, 2, 'B001', 61, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-61.png', NULL, '10441200264-03-B001-61.pdf', '10441200264-03-B001-61.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, '2020-06-07 01:10:00', '2020-06-07 01:10:02', NULL, 1, NULL, NULL),
(75, 1, 1, 2, 'B001', 62, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '9.32', NULL, '0.00', '0.00', '0.00', '1.68', NULL, '0.00', '11.00', 'ONCE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-62.png', NULL, '10441200264-03-B001-62.pdf', '10441200264-03-B001-62.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, '2020-06-07 01:10:00', '2020-06-07 01:10:02', NULL, 1, NULL, NULL),
(76, 1, 1, 2, 'B001', 63, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '423.73', NULL, '0.00', '0.00', '0.00', '76.27', NULL, '0.00', '500.00', 'QUINIENTOS CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, '10441200264-03-B001-63.png', NULL, NULL, '10441200264-03-B001-63.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, '2020-06-07 01:10:48', '2020-06-07 01:10:49', NULL, 1, NULL, NULL),
(77, 1, 1, 2, 'B001', 64, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '423.73', NULL, '0.00', '0.00', '0.00', '76.27', NULL, '0.00', '500.00', 'QUINIENTOS CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, '2020-06-07 01:10:48', '2020-06-07 01:10:48', NULL, 1, NULL, NULL),
(78, 1, 1, 2, 'B001', 65, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '423.73', NULL, '0.00', '0.00', '0.00', '76.27', NULL, '0.00', '500.00', 'QUINIENTOS CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, '2020-06-07 01:10:48', '2020-06-07 01:10:48', NULL, 1, NULL, NULL),
(79, 1, 1, 2, 'B001', 66, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '423.73', NULL, '0.00', '0.00', '0.00', '76.27', NULL, '0.00', '500.00', 'QUINIENTOS CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, '2020-06-07 01:10:48', '2020-06-07 01:10:48', NULL, 1, NULL, NULL),
(80, 1, 1, 2, 'B001', 67, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '423.73', NULL, '0.00', '0.00', '0.00', '76.27', NULL, '0.00', '500.00', 'QUINIENTOS CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, '2020-06-07 01:10:48', '2020-06-07 01:10:48', NULL, 1, NULL, NULL),
(81, 1, 1, 2, 'B001', 68, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '423.73', NULL, '0.00', '0.00', '0.00', '76.27', NULL, '0.00', '500.00', 'QUINIENTOS CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, '2020-06-07 01:10:48', '2020-06-07 01:10:48', NULL, 1, NULL, NULL),
(82, 1, 1, 2, 'B001', 69, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '423.73', NULL, '0.00', '0.00', '0.00', '76.27', NULL, '0.00', '500.00', 'QUINIENTOS CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, '2020-06-07 01:10:48', '2020-06-07 01:10:48', NULL, 1, NULL, NULL),
(83, 1, 1, 2, 'B001', 70, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '423.73', NULL, '0.00', '0.00', '0.00', '76.27', NULL, '0.00', '500.00', 'QUINIENTOS CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-70.png', NULL, '10441200264-03-B001-70.pdf', '10441200264-03-B001-70.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, '2020-06-07 01:10:58', '2020-06-07 01:10:59', NULL, 1, NULL, NULL),
(84, 1, 1, 2, 'B001', 71, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '423.73', NULL, '0.00', '0.00', '0.00', '76.27', NULL, '0.00', '500.00', 'QUINIENTOS CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-71.png', NULL, '10441200264-03-B001-71.pdf', '10441200264-03-B001-71.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, '2020-06-07 01:10:58', '2020-06-07 01:10:59', NULL, 1, NULL, NULL),
(85, 1, 1, 2, 'B001', 72, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '423.73', NULL, '0.00', '0.00', '0.00', '76.27', NULL, '0.00', '500.00', 'QUINIENTOS CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-72.png', NULL, '10441200264-03-B001-72.pdf', '10441200264-03-B001-72.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, '2020-06-07 01:10:58', '2020-06-07 01:10:59', NULL, 1, NULL, NULL),
(86, 1, 1, 2, 'B001', 73, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '423.73', NULL, '0.00', '0.00', '0.00', '76.27', NULL, '0.00', '500.00', 'QUINIENTOS CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-73.png', NULL, '10441200264-03-B001-73.pdf', '10441200264-03-B001-73.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, '2020-06-07 01:10:58', '2020-06-07 01:10:59', NULL, 1, NULL, NULL),
(87, 1, 1, 2, 'B001', 74, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '423.73', NULL, '0.00', '0.00', '0.00', '76.27', NULL, '0.00', '500.00', 'QUINIENTOS CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-74.png', NULL, '10441200264-03-B001-74.pdf', '10441200264-03-B001-74.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, '2020-06-07 01:10:58', '2020-06-07 01:11:00', NULL, 1, NULL, NULL),
(88, 1, 1, 2, 'B001', 75, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '423.73', NULL, '0.00', '0.00', '0.00', '76.27', NULL, '0.00', '500.00', 'QUINIENTOS CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-75.png', NULL, '10441200264-03-B001-75.pdf', '10441200264-03-B001-75.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, '2020-06-07 01:10:58', '2020-06-07 01:11:00', NULL, 1, NULL, NULL),
(89, 1, 1, 2, 'B001', 76, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '423.73', NULL, '0.00', '0.00', '0.00', '76.27', NULL, '0.00', '500.00', 'QUINIENTOS CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-76.png', NULL, '10441200264-03-B001-76.pdf', '10441200264-03-B001-76.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, '2020-06-07 01:10:58', '2020-06-07 01:11:00', NULL, 1, NULL, NULL),
(90, 1, 1, 2, 'B001', 77, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, '10441200264-03-B001-77.png', NULL, NULL, '10441200264-03-B001-77.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, '2020-06-07 01:11:51', '2020-06-07 01:11:52', NULL, 1, NULL, NULL);
INSERT INTO `venta` (`idventa`, `idempresa`, `idsede`, `iddocumentofiscal`, `serie`, `numero`, `idcliente`, `fechaemision`, `idestadodocumento`, `exonerada`, `inafecta`, `gratuita`, `gravada`, `descuentoporcentaje`, `descuentoglobal`, `descuentoitem`, `descuentototal`, `valorimpuesto`, `cargo`, `totalimpuestobolsa`, `total`, `totalletra`, `pagado`, `vuelto`, `descripcion`, `clientenombre`, `clientedoc`, `clientenumerodoc`, `clientedireccion`, `cuentadetraccion`, `motivoanulacion`, `idpersonalanula`, `tiponc`, `documentonc`, `serienc`, `numeronc`, `operacion`, `moneda`, `tipocambio`, `fechavencimiento`, `detraccion`, `selvaproducto`, `selvaservicio`, `ordencompra`, `guiaremitente`, `guiatransportista`, `placavehiculo`, `condicionpago`, `observacion`, `pdfformato`, `cpecorreo`, `sendcorreo`, `sunat_aceptado`, `sunat_nota`, `qr`, `hash`, `pdf`, `xml`, `cdr`, `errors`, `sunat_anulado_ticket`, `sunat_anulado_aceptado`, `sunat_anulado_key`, `sunat_anulado_nota`, `enlace`, `idmasivo`, `created_at`, `updated_at`, `deleted_at`, `id_created_at`, `id_updated_at`, `id_deleted_at`) VALUES
(91, 1, 1, 2, 'B001', 78, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, '2020-06-07 01:11:51', '2020-06-07 01:11:51', NULL, 1, NULL, NULL),
(92, 1, 1, 2, 'B001', 79, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, '2020-06-07 01:11:51', '2020-06-07 01:11:51', NULL, 1, NULL, NULL),
(93, 1, 1, 2, 'B001', 80, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, '2020-06-07 01:11:51', '2020-06-07 01:11:51', NULL, 1, NULL, NULL),
(94, 1, 1, 2, 'B001', 81, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, '2020-06-07 01:11:51', '2020-06-07 01:11:51', NULL, 1, NULL, NULL),
(95, 1, 1, 2, 'B001', 82, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, '2020-06-07 01:11:52', '2020-06-07 01:11:52', NULL, 1, NULL, NULL),
(96, 1, 1, 2, 'B001', 83, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, '2020-06-07 01:11:52', '2020-06-07 01:11:52', NULL, 1, NULL, NULL),
(97, 1, 1, 2, 'B001', 84, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'TICKET', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, '2020-06-07 01:11:52', '2020-06-07 01:11:52', NULL, 1, NULL, NULL),
(98, 1, 1, 2, 'B001', 85, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-85.png', NULL, '10441200264-03-B001-85.pdf', '10441200264-03-B001-85.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, '2020-06-07 01:12:07', '2020-06-07 01:12:08', NULL, 1, NULL, NULL),
(99, 1, 1, 2, 'B001', 86, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-86.png', NULL, '10441200264-03-B001-86.pdf', '10441200264-03-B001-86.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, '2020-06-07 01:12:07', '2020-06-07 01:12:08', NULL, 1, NULL, NULL),
(100, 1, 1, 2, 'B001', 87, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-87.png', NULL, '10441200264-03-B001-87.pdf', '10441200264-03-B001-87.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, '2020-06-07 01:12:07', '2020-06-07 01:12:08', NULL, 1, NULL, NULL),
(101, 1, 1, 2, 'B001', 88, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-88.png', NULL, '10441200264-03-B001-88.pdf', '10441200264-03-B001-88.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, '2020-06-07 01:12:07', '2020-06-07 01:12:08', NULL, 1, NULL, NULL),
(102, 1, 1, 2, 'B001', 89, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-89.png', NULL, '10441200264-03-B001-89.pdf', '10441200264-03-B001-89.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, '2020-06-07 01:12:07', '2020-06-07 01:12:08', NULL, 1, NULL, NULL),
(103, 1, 1, 2, 'B001', 90, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-90.png', NULL, '10441200264-03-B001-90.pdf', '10441200264-03-B001-90.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, '2020-06-07 01:12:07', '2020-06-07 01:12:09', NULL, 1, NULL, NULL),
(104, 1, 1, 2, 'B001', 91, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-91.png', NULL, '10441200264-03-B001-91.pdf', '10441200264-03-B001-91.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, '2020-06-07 01:12:07', '2020-06-07 01:12:09', NULL, 1, NULL, NULL),
(105, 1, 1, 2, 'B001', 92, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '2541.53', NULL, '0.00', '0.00', '0.00', '457.47', NULL, '0.00', '2999.00', 'DOS MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-92.png', NULL, '10441200264-03-B001-92.pdf', '10441200264-03-B001-92.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, '2020-06-07 01:12:08', '2020-06-07 01:12:09', NULL, 1, NULL, NULL),
(106, 1, 1, 2, 'B001', 93, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-93.png', NULL, '10441200264-03-B001-93.pdf', '10441200264-03-B001-93.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, '2020-06-07 01:12:42', '2020-06-07 01:12:43', NULL, 1, NULL, NULL),
(107, 1, 1, 2, 'B001', 94, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-94.png', NULL, '10441200264-03-B001-94.pdf', '10441200264-03-B001-94.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, '2020-06-07 01:12:42', '2020-06-07 01:12:44', NULL, 1, NULL, NULL),
(108, 1, 1, 2, 'B001', 95, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-95.png', NULL, '10441200264-03-B001-95.pdf', '10441200264-03-B001-95.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, '2020-06-07 01:12:42', '2020-06-07 01:12:44', NULL, 1, NULL, NULL),
(109, 1, 1, 2, 'B001', 96, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-96.png', NULL, '10441200264-03-B001-96.pdf', '10441200264-03-B001-96.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, '2020-06-07 01:12:43', '2020-06-07 01:12:44', NULL, 1, NULL, NULL),
(110, 1, 1, 2, 'B001', 97, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-97.png', NULL, '10441200264-03-B001-97.pdf', '10441200264-03-B001-97.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, '2020-06-07 01:12:43', '2020-06-07 01:12:44', NULL, 1, NULL, NULL),
(111, 1, 1, 2, 'B001', 98, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-98.png', NULL, '10441200264-03-B001-98.pdf', '10441200264-03-B001-98.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, '2020-06-07 01:12:43', '2020-06-07 01:12:45', NULL, 1, NULL, NULL),
(112, 1, 1, 2, 'B001', 99, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-99.png', NULL, '10441200264-03-B001-99.pdf', '10441200264-03-B001-99.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, '2020-06-07 01:12:43', '2020-06-07 01:12:45', NULL, 1, NULL, NULL),
(113, 1, 1, 2, 'B001', 100, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-100.png', NULL, '10441200264-03-B001-100.pdf', '10441200264-03-B001-100.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, '2020-06-07 01:12:43', '2020-06-07 01:12:45', NULL, 1, NULL, NULL),
(114, 1, 1, 2, 'B001', 101, 356, '2020-06-07', 27, '0.00', '0.00', '0.00', '1694.07', NULL, '0.00', '0.00', '0.00', '304.93', NULL, '0.00', '1999.00', 'MIL NOVECIENTOS NOVENTA Y NUEVE CON 00/100 SOLES', NULL, NULL, NULL, 'VARIOS', '5', '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'PEN', NULL, NULL, '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, 'A4', NULL, NULL, NULL, NULL, '10441200264-03-B001-101.png', NULL, '10441200264-03-B001-101.pdf', '10441200264-03-B001-101.xml', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, '2020-06-07 01:12:43', '2020-06-07 01:12:46', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventadet`
--

CREATE TABLE `ventadet` (
  `idventadet` int(11) NOT NULL,
  `idventa` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` decimal(8,3) NOT NULL,
  `unidadmedida` varchar(5) DEFAULT NULL,
  `idimpuesto` int(11) DEFAULT NULL,
  `valorunit` decimal(8,3) DEFAULT NULL COMMENT 'Se consignará el importe correspondiente al valor o monto unitario del bien vendido, cedido o servicio prestado, indicado en una línea o ítem de la factura. Este importe no incluye los tributos (IGV, ISC y otros Tributos) ni los cargos globales.',
  `valorventa` decimal(8,2) DEFAULT NULL COMMENT 'Es el producto de la cantidad por el valor unitario (Q x Valor Unitario) y la deducción de los descuentos aplicados a dicho ítem (de existir). Este importe no incluye los tributos (IGV, ISC y otros Tributos), los descuentos globales o cargos.',
  `impuestobolsa` decimal(8,2) DEFAULT NULL,
  `montototalimpuestos` decimal(8,2) DEFAULT NULL COMMENT 'Monto total de impuestos por linea (Suma de IGV + ISC + OTROS)',
  `preciounit` decimal(8,3) NOT NULL,
  `descuento` decimal(8,3) DEFAULT NULL COMMENT 'Descuento por ítem aplicado a valorventa	',
  `total` decimal(8,2) NOT NULL,
  `codigo` varchar(16) DEFAULT NULL,
  `codigosunat` varchar(8) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_created_at` int(11) NOT NULL,
  `id_updated_at` int(11) DEFAULT NULL,
  `id_deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ventadet`
--

INSERT INTO `ventadet` (`idventadet`, `idventa`, `idproducto`, `cantidad`, `unidadmedida`, `idimpuesto`, `valorunit`, `valorventa`, `impuestobolsa`, `montototalimpuestos`, `preciounit`, `descuento`, `total`, `codigo`, `codigosunat`, `nombre`, `descripcion`, `created_at`, `updated_at`, `deleted_at`, `id_created_at`, `id_updated_at`, `id_deleted_at`) VALUES
(1, 1, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', NULL, 'Producto', NULL, '2020-05-17 01:30:57', NULL, NULL, 1, NULL, NULL),
(2, 2, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', NULL, 'Producto', NULL, '2020-05-17 15:45:58', NULL, NULL, 1, NULL, NULL),
(3, 3, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', NULL, 'Producto', NULL, '2020-05-17 15:50:44', NULL, NULL, 1, NULL, NULL),
(4, 4, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', NULL, 'Producto', NULL, '2020-05-17 15:55:00', NULL, NULL, 1, NULL, NULL),
(5, 5, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', NULL, 'Producto', NULL, '2020-05-17 15:59:10', NULL, NULL, 1, NULL, NULL),
(6, 6, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', NULL, 'Producto', NULL, '2020-05-17 16:00:55', NULL, NULL, 1, NULL, NULL),
(7, 6, 2, '1.000', 'ZZ', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'SER0001', NULL, 'Servicio', NULL, '2020-05-17 16:00:55', NULL, NULL, 1, NULL, NULL),
(8, 7, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', NULL, 'Producto', NULL, '2020-05-17 16:02:40', NULL, NULL, 1, NULL, NULL),
(9, 8, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', NULL, 'Producto', NULL, '2020-05-17 16:04:02', NULL, NULL, 1, NULL, NULL),
(10, 9, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', NULL, 'Producto', NULL, '2020-05-17 16:04:43', NULL, NULL, 1, NULL, NULL),
(11, 10, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', NULL, 'Producto', NULL, '2020-05-18 19:08:09', NULL, NULL, 1, NULL, NULL),
(12, 11, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', NULL, 'Producto', NULL, '2020-05-18 19:08:09', NULL, NULL, 1, NULL, NULL),
(13, 12, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', NULL, 'Producto', NULL, '2020-05-18 19:08:09', NULL, NULL, 1, NULL, NULL),
(14, 13, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', NULL, 'Producto', NULL, '2020-05-18 19:08:09', NULL, NULL, 1, NULL, NULL),
(15, 14, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', NULL, 'Producto', NULL, '2020-05-18 19:08:09', NULL, NULL, 1, NULL, NULL),
(16, 15, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', '10101508', 'Producto', NULL, '2020-05-18 19:31:24', NULL, NULL, 1, NULL, NULL),
(17, 16, 1, '1.000', 'NIU', 1, '84.746', '84.75', '0.20', '15.25', '100.000', '0.000', '100.00', 'PRO0001', '10101508', 'Producto', NULL, '2020-05-18 19:32:45', NULL, NULL, 1, NULL, NULL),
(18, 16, 2, '1.000', 'ZZ', 8, '100.000', '100.00', NULL, '0.00', '100.000', '0.000', '100.00', 'SER0001', NULL, 'Servicio', NULL, '2020-05-18 19:32:45', NULL, NULL, 1, NULL, NULL),
(19, 16, 1, '1.000', 'NIU', 9, '100.000', '100.00', NULL, '0.00', '100.000', '0.000', '100.00', 'PRO0001', '10101508', 'Producto', NULL, '2020-05-18 19:32:45', NULL, NULL, 1, NULL, NULL),
(20, 17, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', '10101508', 'Producto', NULL, '2020-05-25 12:31:46', NULL, NULL, 1, NULL, NULL),
(21, 18, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', '10101508', 'Producto', NULL, '2020-05-28 13:11:51', NULL, NULL, 1, NULL, NULL),
(22, 18, 2, '1.000', 'ZZ', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'SER0001', NULL, 'Servicio', NULL, '2020-05-28 13:11:51', NULL, NULL, 1, NULL, NULL),
(23, 21, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', '10101508', 'Producto', NULL, '2020-05-28 13:26:41', NULL, NULL, 1, NULL, NULL),
(24, 21, 2, '1.000', 'ZZ', 1, '42.373', '42.37', NULL, '7.63', '50.000', '0.000', '50.00', 'SER0001', NULL, 'Servicio', NULL, '2020-05-28 13:26:41', NULL, NULL, 1, NULL, NULL),
(25, 22, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', '10101508', 'Producto', NULL, '2020-05-28 18:52:35', NULL, NULL, 1, NULL, NULL),
(26, 25, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III', NULL, '2020-05-31 20:22:29', NULL, NULL, 1, NULL, NULL),
(27, 26, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III', NULL, '2020-05-31 20:27:10', NULL, NULL, 1, NULL, NULL),
(28, 27, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III', NULL, '2020-05-31 20:54:36', NULL, NULL, 1, NULL, NULL),
(29, 27, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-05-31 20:54:36', NULL, NULL, 1, NULL, NULL),
(30, 28, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III', NULL, '2020-05-31 21:17:55', NULL, NULL, 1, NULL, NULL),
(31, 28, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-05-31 21:17:55', NULL, NULL, 1, NULL, NULL),
(32, 29, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III', NULL, '2020-05-31 21:18:30', NULL, NULL, 1, NULL, NULL),
(33, 30, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III', NULL, '2020-05-31 23:54:03', NULL, NULL, 1, NULL, NULL),
(34, 31, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III', NULL, '2020-05-31 23:58:15', NULL, NULL, 1, NULL, NULL),
(35, 32, 1, '1.000', 'NIU', 1, '84.746', '84.75', NULL, '15.25', '100.000', '0.000', '100.00', 'PRO0001', '10101508', 'Producto', NULL, '2020-05-31 23:58:58', NULL, NULL, 1, NULL, NULL),
(36, 33, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 00:12:40', NULL, NULL, 1, NULL, NULL),
(37, 34, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 00:40:58', NULL, NULL, 1, NULL, NULL),
(38, 35, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 00:40:58', NULL, NULL, 1, NULL, NULL),
(39, 36, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 00:40:58', NULL, NULL, 1, NULL, NULL),
(40, 37, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 00:40:58', NULL, NULL, 1, NULL, NULL),
(41, 38, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 00:40:58', NULL, NULL, 1, NULL, NULL),
(42, 39, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 00:40:58', NULL, NULL, 1, NULL, NULL),
(43, 40, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 00:40:59', NULL, NULL, 1, NULL, NULL),
(44, 41, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 00:40:59', NULL, NULL, 1, NULL, NULL),
(45, 42, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 00:40:59', NULL, NULL, 1, NULL, NULL),
(46, 43, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 00:40:59', NULL, NULL, 1, NULL, NULL),
(47, 44, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:42:53', NULL, NULL, 1, NULL, NULL),
(48, 45, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:42:53', NULL, NULL, 1, NULL, NULL),
(49, 46, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:42:53', NULL, NULL, 1, NULL, NULL),
(50, 47, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:42:53', NULL, NULL, 1, NULL, NULL),
(51, 48, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:42:53', NULL, NULL, 1, NULL, NULL),
(52, 49, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:43:35', NULL, NULL, 1, NULL, NULL),
(53, 50, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:43:35', NULL, NULL, 1, NULL, NULL),
(54, 51, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:43:35', NULL, NULL, 1, NULL, NULL),
(55, 52, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:43:35', NULL, NULL, 1, NULL, NULL),
(56, 53, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:43:35', NULL, NULL, 1, NULL, NULL),
(57, 54, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:45:29', NULL, NULL, 1, NULL, NULL),
(58, 55, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:45:29', NULL, NULL, 1, NULL, NULL),
(59, 56, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:45:29', NULL, NULL, 1, NULL, NULL),
(60, 57, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:45:29', NULL, NULL, 1, NULL, NULL),
(61, 58, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:45:29', NULL, NULL, 1, NULL, NULL),
(62, 59, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:47:42', NULL, NULL, 1, NULL, NULL),
(63, 60, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:47:43', NULL, NULL, 1, NULL, NULL),
(64, 61, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:47:44', NULL, NULL, 1, NULL, NULL),
(65, 62, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:47:44', NULL, NULL, 1, NULL, NULL),
(66, 63, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:47:44', NULL, NULL, 1, NULL, NULL),
(67, 64, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:49:11', NULL, NULL, 1, NULL, NULL),
(68, 65, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:49:11', NULL, NULL, 1, NULL, NULL),
(69, 66, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:49:11', NULL, NULL, 1, NULL, NULL),
(70, 67, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:49:11', NULL, NULL, 1, NULL, NULL),
(71, 68, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:49:11', NULL, NULL, 1, NULL, NULL),
(72, 69, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:50:22', NULL, NULL, 1, NULL, NULL),
(73, 70, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:50:22', NULL, NULL, 1, NULL, NULL),
(74, 71, 9, '1.000', 'NIU', 1, '2.966', '2.97', NULL, '0.53', '3.500', '0.000', '3.50', 'GUI001', '10101508', 'Afeitador Sick III Doble hoja', NULL, '2020-06-07 00:53:43', NULL, NULL, 1, NULL, NULL),
(75, 72, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:54:38', NULL, NULL, 1, NULL, NULL),
(76, 73, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 00:54:38', NULL, NULL, 1, NULL, NULL),
(77, 74, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 01:10:00', NULL, NULL, 1, NULL, NULL),
(78, 75, 12, '1.000', 'NIU', 1, '9.322', '9.32', NULL, '1.68', '11.000', '0.000', '11.00', 'camote01', NULL, 'Camote frito', NULL, '2020-06-07 01:10:00', NULL, NULL, 1, NULL, NULL),
(79, 76, 16, '1.000', 'NIU', 1, '423.729', '423.73', NULL, '76.27', '500.000', '0.000', '500.00', 'Celular01', NULL, 'Celular Huawei', NULL, '2020-06-07 01:10:48', NULL, NULL, 1, NULL, NULL),
(80, 77, 16, '1.000', 'NIU', 1, '423.729', '423.73', NULL, '76.27', '500.000', '0.000', '500.00', 'Celular01', NULL, 'Celular Huawei', NULL, '2020-06-07 01:10:48', NULL, NULL, 1, NULL, NULL),
(81, 78, 16, '1.000', 'NIU', 1, '423.729', '423.73', NULL, '76.27', '500.000', '0.000', '500.00', 'Celular01', NULL, 'Celular Huawei', NULL, '2020-06-07 01:10:48', NULL, NULL, 1, NULL, NULL),
(82, 79, 16, '1.000', 'NIU', 1, '423.729', '423.73', NULL, '76.27', '500.000', '0.000', '500.00', 'Celular01', NULL, 'Celular Huawei', NULL, '2020-06-07 01:10:48', NULL, NULL, 1, NULL, NULL),
(83, 80, 16, '1.000', 'NIU', 1, '423.729', '423.73', NULL, '76.27', '500.000', '0.000', '500.00', 'Celular01', NULL, 'Celular Huawei', NULL, '2020-06-07 01:10:48', NULL, NULL, 1, NULL, NULL),
(84, 81, 16, '1.000', 'NIU', 1, '423.729', '423.73', NULL, '76.27', '500.000', '0.000', '500.00', 'Celular01', NULL, 'Celular Huawei', NULL, '2020-06-07 01:10:48', NULL, NULL, 1, NULL, NULL),
(85, 82, 16, '1.000', 'NIU', 1, '423.729', '423.73', NULL, '76.27', '500.000', '0.000', '500.00', 'Celular01', NULL, 'Celular Huawei', NULL, '2020-06-07 01:10:48', NULL, NULL, 1, NULL, NULL),
(86, 83, 16, '1.000', 'NIU', 1, '423.729', '423.73', NULL, '76.27', '500.000', '0.000', '500.00', 'Celular01', NULL, 'Celular Huawei', NULL, '2020-06-07 01:10:58', NULL, NULL, 1, NULL, NULL),
(87, 84, 16, '1.000', 'NIU', 1, '423.729', '423.73', NULL, '76.27', '500.000', '0.000', '500.00', 'Celular01', NULL, 'Celular Huawei', NULL, '2020-06-07 01:10:58', NULL, NULL, 1, NULL, NULL),
(88, 85, 16, '1.000', 'NIU', 1, '423.729', '423.73', NULL, '76.27', '500.000', '0.000', '500.00', 'Celular01', NULL, 'Celular Huawei', NULL, '2020-06-07 01:10:58', NULL, NULL, 1, NULL, NULL),
(89, 86, 16, '1.000', 'NIU', 1, '423.729', '423.73', NULL, '76.27', '500.000', '0.000', '500.00', 'Celular01', NULL, 'Celular Huawei', NULL, '2020-06-07 01:10:58', NULL, NULL, 1, NULL, NULL),
(90, 87, 16, '1.000', 'NIU', 1, '423.729', '423.73', NULL, '76.27', '500.000', '0.000', '500.00', 'Celular01', NULL, 'Celular Huawei', NULL, '2020-06-07 01:10:58', NULL, NULL, 1, NULL, NULL),
(91, 88, 16, '1.000', 'NIU', 1, '423.729', '423.73', NULL, '76.27', '500.000', '0.000', '500.00', 'Celular01', NULL, 'Celular Huawei', NULL, '2020-06-07 01:10:58', NULL, NULL, 1, NULL, NULL),
(92, 89, 16, '1.000', 'NIU', 1, '423.729', '423.73', NULL, '76.27', '500.000', '0.000', '500.00', 'Celular01', NULL, 'Celular Huawei', NULL, '2020-06-07 01:10:58', NULL, NULL, 1, NULL, NULL),
(93, 90, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:11:51', NULL, NULL, 1, NULL, NULL),
(94, 91, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:11:51', NULL, NULL, 1, NULL, NULL),
(95, 92, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:11:51', NULL, NULL, 1, NULL, NULL),
(96, 93, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:11:51', NULL, NULL, 1, NULL, NULL),
(97, 94, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:11:51', NULL, NULL, 1, NULL, NULL),
(98, 95, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:11:52', NULL, NULL, 1, NULL, NULL),
(99, 96, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:11:52', NULL, NULL, 1, NULL, NULL),
(100, 97, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:11:52', NULL, NULL, 1, NULL, NULL),
(101, 98, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:12:07', NULL, NULL, 1, NULL, NULL),
(102, 99, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:12:07', NULL, NULL, 1, NULL, NULL),
(103, 100, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:12:07', NULL, NULL, 1, NULL, NULL),
(104, 101, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:12:07', NULL, NULL, 1, NULL, NULL),
(105, 102, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:12:07', NULL, NULL, 1, NULL, NULL),
(106, 103, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:12:07', NULL, NULL, 1, NULL, NULL),
(107, 104, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:12:08', NULL, NULL, 1, NULL, NULL),
(108, 105, 17, '1.000', 'NIU', 1, '2541.525', '2541.53', NULL, '457.47', '2999.000', '0.000', '2999.00', 'celular02', NULL, 'Celular Iphone', NULL, '2020-06-07 01:12:08', NULL, NULL, 1, NULL, NULL),
(109, 106, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 01:12:42', NULL, NULL, 1, NULL, NULL),
(110, 107, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 01:12:42', NULL, NULL, 1, NULL, NULL),
(111, 108, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 01:12:43', NULL, NULL, 1, NULL, NULL),
(112, 109, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 01:12:43', NULL, NULL, 1, NULL, NULL),
(113, 110, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 01:12:43', NULL, NULL, 1, NULL, NULL),
(114, 111, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 01:12:43', NULL, NULL, 1, NULL, NULL),
(115, 112, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 01:12:43', NULL, NULL, 1, NULL, NULL),
(116, 113, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 01:12:43', NULL, NULL, 1, NULL, NULL),
(117, 114, 19, '1.000', 'NIU', 1, '1694.068', '1694.07', NULL, '304.93', '1999.000', '0.000', '1999.00', 'Celular04', NULL, 'Celular HTC One', NULL, '2020-06-07 01:12:43', NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventapago`
--

CREATE TABLE `ventapago` (
  `idventapago` int(11) NOT NULL,
  `idventa` int(11) NOT NULL,
  `idmediopago` int(11) NOT NULL,
  `importe` decimal(8,2) NOT NULL,
  `nota` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_created_at` int(11) DEFAULT NULL,
  `id_updated_at` int(11) DEFAULT NULL,
  `id_deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `catalogo`
--
ALTER TABLE `catalogo`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `distrito`
--
ALTER TABLE `distrito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`iddocumento`);

--
-- Indices de la tabla `documentofiscal`
--
ALTER TABLE `documentofiscal`
  ADD PRIMARY KEY (`iddocumentofiscal`);

--
-- Indices de la tabla `documentoserie`
--
ALTER TABLE `documentoserie`
  ADD PRIMARY KEY (`iddocumentoserie`),
  ADD KEY `documentoserie_fk_3` (`iddocumentofiscal`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idempresa`);

--
-- Indices de la tabla `entidad`
--
ALTER TABLE `entidad`
  ADD PRIMARY KEY (`identidad`),
  ADD KEY `entidad_fk_2` (`iddocumento`);

--
-- Indices de la tabla `logacceso`
--
ALTER TABLE `logacceso`
  ADD PRIMARY KEY (`idlogacceso`),
  ADD KEY `logacceso_fk_1` (`identidad`);

--
-- Indices de la tabla `masivo`
--
ALTER TABLE `masivo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `masivodet`
--
ALTER TABLE `masivodet`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`idmodulo`),
  ADD KEY `modulo_fk_1` (`parent`);

--
-- Indices de la tabla `moduloempresa`
--
ALTER TABLE `moduloempresa`
  ADD PRIMARY KEY (`idmodulo`,`idempresa`);

--
-- Indices de la tabla `modulo_users`
--
ALTER TABLE `modulo_users`
  ADD PRIMARY KEY (`iduser`,`idmodulo`);

--
-- Indices de la tabla `moneda`
--
ALTER TABLE `moneda`
  ADD PRIMARY KEY (`idmoneda`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD UNIQUE KEY `codigo_UNIQUE` (`idempresa`,`codigo`) USING BTREE;

--
-- Indices de la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sede`
--
ALTER TABLE `sede`
  ADD PRIMARY KEY (`idsede`),
  ADD KEY `sede_fk_1` (`idempresa`);

--
-- Indices de la tabla `sede_users`
--
ALTER TABLE `sede_users`
  ADD PRIMARY KEY (`idsede`,`iduser`);

--
-- Indices de la tabla `ubigeo`
--
ALTER TABLE `ubigeo`
  ADD PRIMARY KEY (`idubigeo`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `unidadempresa`
--
ALTER TABLE `unidadempresa`
  ADD PRIMARY KEY (`codigo`,`idempresa`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`),
  ADD UNIQUE KEY `SerieNumero` (`idempresa`,`serie`,`numero`,`iddocumentofiscal`) USING BTREE,
  ADD KEY `serie` (`serie`,`numero`),
  ADD KEY `venta_fk_3` (`iddocumentofiscal`),
  ADD KEY `venta_fk_4` (`idcliente`),
  ADD KEY `venta_fk_11` (`idsede`);

--
-- Indices de la tabla `ventadet`
--
ALTER TABLE `ventadet`
  ADD PRIMARY KEY (`idventadet`),
  ADD KEY `ventadet_fk_1` (`idventa`),
  ADD KEY `ventadet_fk_2` (`idproducto`),
  ADD KEY `ventadet_fk_5` (`unidadmedida`);

--
-- Indices de la tabla `ventapago`
--
ALTER TABLE `ventapago`
  ADD PRIMARY KEY (`idventapago`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `iddocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `documentofiscal`
--
ALTER TABLE `documentofiscal`
  MODIFY `iddocumentofiscal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `documentoserie`
--
ALTER TABLE `documentoserie`
  MODIFY `iddocumentoserie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idempresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `entidad`
--
ALTER TABLE `entidad`
  MODIFY `identidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `logacceso`
--
ALTER TABLE `logacceso`
  MODIFY `idlogacceso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT de la tabla `masivo`
--
ALTER TABLE `masivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `masivodet`
--
ALTER TABLE `masivodet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `idmodulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `sede`
--
ALTER TABLE `sede`
  MODIFY `idsede` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de la tabla `ventadet`
--
ALTER TABLE `ventadet`
  MODIFY `idventadet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT de la tabla `ventapago`
--
ALTER TABLE `ventapago`
  MODIFY `idventapago` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
