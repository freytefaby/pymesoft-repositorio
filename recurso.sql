-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2017 a las 05:10:17
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
(12, 'Modulo gastos, permisos para crear y leer y modificar gastos del sistema.');

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
  MODIFY `idrecurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
