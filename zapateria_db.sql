-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-08-2025 a las 01:19:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `zapateria_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `correo` varchar(128) NOT NULL,
  `cedula` varchar(16) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=activo, 0=inactivo',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nombre`, `correo`, `cedula`, `estado`, `fecha_creacion`) VALUES
(1, 'Daniela Perez Salas', 'dperez23@gmail.com', '114300396', 1, '2025-07-13 02:44:33'),
(6, 'STEPHANIE ARIAS ARAYA', 'sarias17@outlook.com', '206790810', 1, '2025-08-19 16:47:54'),
(7, 'VIVIAN PATRICIA BARRANTES ALVARADO', 'vbarrantes32@gmail.com', '207080741', 1, '2025-08-19 16:49:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `id_detalle` int(11) NOT NULL,
  `id_factura` int(10) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `descuento` decimal(5,2) UNSIGNED NOT NULL COMMENT '5%',
  `impuesto` decimal(5,2) NOT NULL COMMENT 'iva=13%, ivae=1%',
  `subtotal` decimal(10,0) NOT NULL COMMENT 'Precio * cantidad *(1- descuento%)',
  `total_impuestos` decimal(10,0) NOT NULL COMMENT 'Subtotal *(impuesto%)',
  `total_general` decimal(10,0) NOT NULL COMMENT 'subtotal + total impuestos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `correo` varchar(128) NOT NULL,
  `telefono` int(32) NOT NULL,
  `cedula` varchar(16) NOT NULL,
  `contrasena` varchar(64) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=activo, 0= inactivo',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `id_rol` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `nombre`, `correo`, `telefono`, `cedula`, `contrasena`, `estado`, `fecha_creacion`, `id_rol`) VALUES
(1, 'Daniel Sequeira Gaitan', 'daniel@gmail.com', 60577713, '503720273', '$2y$10$X6jxn1THHdt5CekeMU2iauAZHPeeTH4yDd/Pp9PoBsXy.Knrq8WY2', 1, '2025-07-06 13:06:18', 1),
(3, 'Pedro Castro Esquivel', 'pedro@gmail.com', 60577814, '205430321', '$2y$10$X6jxn1THHdt5CekeMU2iauAZHPeeTH4yDd/Pp9PoBsXy.Knrq8WY2', 1, '2025-07-13 02:18:21', 2),
(4, 'Evelyn Torres Centeno', 'etorres@gmail.com', 26941213, '102580456', '$2y$10$wq.Iuge5EB5mHQlC/gmFsuE982guKT9qKD/uotLEIGzNW2Beukdwy', 1, '2025-07-20 01:50:40', 1),
(5, 'LETICIA DEL SOCORRO SEQUEIRA MORALES', 'sequeira30@gmail.com', 83103945, '206170777', '$2y$10$GsfGxnMKSujeDV/fCvu/.OIm46aEoQbi9AqoxyJlgRnuzwp9xfA4e', 0, '2025-08-16 14:12:06', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(10) NOT NULL,
  `fecha_emision` datetime NOT NULL DEFAULT current_timestamp(),
  `id_cliente` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `estado` enum('Pagada','Pendiente','Anulada','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL,
  `marca` varchar(64) NOT NULL,
  `descripcion` varchar(128) NOT NULL,
  `talla` varchar(2) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `cantidad` int(11) NOT NULL COMMENT 'stock inventario',
  `estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = disponible, 0 = no disponible',
  `fecha_registro` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idProducto`, `marca`, `descripcion`, `talla`, `precio`, `cantidad`, `estado`, `fecha_registro`) VALUES
(1, 'Nike', 'Zapatilla deportiva Air', '42', 75000, 15, 1, '2025-07-06'),
(3, 'Nike', 'Air Max 270, deportiva para correr, tejido transpirable.', '41', 60000, 8, 1, '2025-07-21'),
(4, 'Nike', 'Air Max 270, deportiva para correr, tejido transpirable.', '36', 60000, 8, 1, '2025-07-21'),
(5, 'Adidas', 'Superstar Classic, zapatilla casual de cuero blanco', '42', 35000, 15, 1, '2025-07-21'),
(6, 'Puma', 'RS-X Bold, estilo retro running, malla y sintético', '44', 55000, 2, 1, '2025-07-21'),
(7, 'Puma', 'RS-X Bold, estilo retro running, malla y sintético', '44', 55000, 2, 1, '2025-07-21'),
(8, 'Puma', 'RS-X Bold, estilo retro running, malla y sintético', '40', 55000, 2, 1, '2025-07-21'),
(9, 'Reebok', 'Classic Leather, sneaker retro de piel, suela de goma', '44', 45000, 12, 1, '2025-07-21'),
(10, 'Vans', 'Old Skool Black/White, zapatilla skate, lona y gamuza', '38', 57000, 6, 1, '2025-07-21'),
(11, 'Nike', 'Air Max 300', '41', 60000, 1, 1, '2025-08-18'),
(12, 'Nike', 'Nike Air Max 270, deportiva para correr, tejido transpirable.', '41', 60000, 3, 1, '2025-08-18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` tinyint(1) UNSIGNED NOT NULL COMMENT '1=administrador, 2= ventas',
  `nombre_rol` varchar(16) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=activo, 0= inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre_rol`, `estado`) VALUES
(1, 'Administrador', 1),
(2, 'Vendedor', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `cedula` (`cedula`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `id_producto` (`idProducto`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD CONSTRAINT `detalle_factura_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_factura_ibfk_3` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
