-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-06-2019 a las 06:15:03
-- Versión del servidor: 10.1.40-MariaDB
-- Versión de PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `see`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instrucciones`
--

CREATE TABLE `instrucciones` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `texto` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `instrucciones`
--

INSERT INTO `instrucciones` (`id`, `titulo`, `texto`) VALUES
(1, 'El Framework', 'Lee todas las instrucciones e intenta entender como funciona el framework'),
(2, '¿Donde hago mis pruebas?', 'Las pruebas puedes hacerlas en el Framework de pruebas, y después pasarlas al bueno cuando se te indique');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `instrucciones`
--
ALTER TABLE `instrucciones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `instrucciones`
--
ALTER TABLE `instrucciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
