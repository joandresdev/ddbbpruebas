-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2019 a las 17:35:01
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

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addAlumno` (IN `matri` INT, IN `pas` LONGTEXT, IN `ema` VARCHAR(100), IN `inde` INT)  BEGIN
       INSERT INTO users(matricula,pass,email,type,indexx)VALUES(matri,pas,ema,'alumno',-1);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUser` (IN `matri` INT)  BEGIN
    SELECT * FROM users where matricula = matri;
END$$

DELIMITER ;

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
(2, '¿Donde hago mis pruebas?', 'Las pruebas puedes hacerlas en el Framework de pruebas, y después pasarlas al bueno cuando se te indique'),
(44, 'Una intruccion mas', 'hazlo bien'),
(45, 'MI NUEVO TITULO', 'texto de prueba'),
(46, 'hola', 'amigos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `matricula` int(11) NOT NULL,
  `pass` longtext NOT NULL,
  `email` varchar(150) NOT NULL,
  `email_pass` varchar(150) DEFAULT NULL,
  `carrera` varchar(100) DEFAULT NULL,
  `type` enum('alumno','admin','superadmin') DEFAULT NULL,
  `indexx` int(11) DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`matricula`, `pass`, `email`, `email_pass`, `carrera`, `type`, `indexx`) VALUES
(2, 'secret', '2@upqroo.alumnos.com', NULL, NULL, 'alumno', -1),
(201600077, 'secret', '201600077@edu.com', 'secret2', NULL, 'admin', -1),
(201600111, 'secret', '201600111@upqroo.alumnos.com', NULL, NULL, 'alumno', -1),
(201600112, 'secret', '201600112@gmail.com', 'secret2', NULL, 'superadmin', -1),
(201600113, 'secret', '201600113', 'secret2', 'software', 'alumno', -1),
(201800377, 'secret', '201800377@upqroo.alumnos.com', NULL, NULL, 'alumno', -1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `instrucciones`
--
ALTER TABLE `instrucciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`matricula`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `instrucciones`
--
ALTER TABLE `instrucciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
