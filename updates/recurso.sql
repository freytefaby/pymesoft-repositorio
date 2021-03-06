-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2017 a las 04:55:42
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hhfarm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE `recurso` (
  `idrecurso` int(11) NOT NULL,
  `descrecurso` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `recurso`
--

INSERT INTO `recurso` (`idrecurso`, `descrecurso`) VALUES
(1, 'Modulo de ventas permisos para crear ventas y ver reportes'),
(2, 'Modulo de base, permisos para crear y actualizar el valor de la base de las cajas.'),
(3, 'Modulo de Categorias, permisos para crear, eliminar, modificar, leer categorias'),
(4, 'Modulo de cierres contables diarios, permisos para leer, crear cierres diarios'),
(5, 'Modulo de clientes, permisos para leer, crear, actualizar clientes'),
(6, 'Modulo de compras permisos para crear compras y ver reportes'),
(7, 'Modulo de convenios, permisos para crear convenios, cupos y abonos a convenios'),
(8, 'Modulo cupos, permisos para crear cupos y editar cupos a clientes.'),
(9, 'Modulo devoluciones a compras, permisos para crear y leer devoluciones a compras.'),
(10, 'Modulo devoluciones a clientes, permisos para crear y leer devoluciones a clientes.'),
(11, 'Modulo notas a crédito, permisos para crear y leer notas a créditos.'),
(12, 'Modulo gastos, permisos para crear y leer y modificar gastos del sistema.'),
(13, 'Modulo de gráficos , permisos para leer la estructura de gráficos de la empresa. '),
(14, 'Modulo de información de empresa, permisos para leer y modificar la información de la empresa.'),
(15, 'Modulo ingresos, permisos para crear y leer y modificar otros ingresos del sistema.'),
(16, 'Modulo inventario laboratorio, permisos para ver inventarios por laboratorio'),
(17, 'Modulo iva , permisos para ver información del iva del sistema.'),
(18, 'Modulo movimientos , permisos para ver información sobre movimientos del sistema.'),
(19, 'Modulo reportes mensuales , permisos para ver reportes mensuales del sistema.'),
(20, 'Modulo sugeridos , permisos para ver pedidos sugeridos del sistema'),
(21, 'Modulo permisos , permisos para agregar restricciones a usuarios del sistema.'),
(22, 'Modulo productos, permisos para crear, actualizar, eliminar y ver productos.'),
(23, 'Modulo Proveedores, permisos para crear, actualizar y ver proveedores.'),
(24, 'Modulo usuarios, permisos para crear, editar y eliminar usuarios del sistema.');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`idrecurso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `recurso`
--
ALTER TABLE `recurso`
  MODIFY `idrecurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
