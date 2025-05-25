-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-02-2022 a las 18:49:32
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `notas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

CREATE TABLE `asignaturas` (
  `codigo` int(4) UNSIGNED NOT NULL,
  `nombre` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `horas_semana` int(2) UNSIGNED NOT NULL,
  `profesor` varchar(40) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `asignaturas`
--

INSERT INTO `asignaturas` (`codigo`, `nombre`, `horas_semana`, `profesor`) VALUES
(374, 'Administración de sistemas operativos', 6, 'Susana Oviedo Bocanegra'),
(375, 'Servicios de red e Internet', 6, 'Rafael Montero González'),
(376, 'Implantación de aplicaciones web.', 4, 'Raúl Gil Sarmiento'),
(377, 'Administración de sistemas gestores de BB.DD.', 3, 'Raúl Gil Sarmiento'),
(378, 'Seguridad y alta disponibilidad.', 4, 'Patricia Vegas Gómez'),
(380, 'Empresa e iniciativa emprendedora.', 4, 'MªCarmen Castaños Berlín');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instrumentos`
--

CREATE TABLE `instrumentos` (
  `clave` int(10) UNSIGNED NOT NULL,
  `unidad` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `peso` int(2) UNSIGNED NOT NULL,
  `calificacion` decimal(10,2) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `instrumentos`
--

INSERT INTO `instrumentos` (`clave`, `unidad`, `nombre`, `peso`, `calificacion`) VALUES
(1, 1, 'Examen Teórico', 45, '8.50'),
(2, 1, 'Examen Práctico', 35, '6.30'),
(3, 1, 'Actividades de Aula', 20, NULL),
(5, 2, 'Examen Teórico', 45, '8.50'),
(6, 2, 'Examen Práctico', 35, '6.30'),
(7, 2, 'Actividades de Aula', 20, NULL),
(8, 3, 'Examen Teórico', 45, '8.50'),
(9, 3, 'Examen Práctico', 35, '6.30'),
(10, 3, 'Actividades de Aula', 20, NULL),
(11, 4, 'Examen Teórico', 45, '8.50'),
(12, 4, 'Examen Práctico', 35, '6.30'),
(13, 4, 'Actividades de Aula', 20, NULL),
(14, 5, 'Examen Teórico', 45, '8.50'),
(15, 5, 'Examen Práctico', 35, '6.30'),
(16, 5, 'Actividades de Aula', 20, NULL),
(32, 6, 'Examen Teórico', 45, '8.50'),
(33, 6, 'Examen Práctico', 35, '6.30'),
(34, 6, 'Actividades de Aula', 20, NULL),
(35, 7, 'Examen Teórico', 45, '8.50'),
(36, 7, 'Examen Práctico', 35, '6.30'),
(37, 7, 'Actividades de Aula', 20, NULL),
(38, 8, 'Examen Teórico', 45, '8.50'),
(39, 8, 'Examen Práctico', 35, '6.30'),
(40, 8, 'Actividades de Aula', 20, NULL),
(41, 9, 'Examen Teórico', 45, '8.50'),
(42, 9, 'Examen Práctico', 35, '6.30'),
(43, 9, 'Actividades de Aula', 20, NULL),
(44, 10, 'Examen Teórico', 45, '8.50'),
(45, 10, 'Examen Práctico', 35, '6.30'),
(46, 10, 'Actividades de Aula', 20, NULL),
(47, 11, 'Examen Teórico', 45, '8.50'),
(48, 11, 'Examen Práctico', 35, '6.30'),
(49, 11, 'Actividades de Aula', 20, NULL),
(50, 12, 'Examen Teórico', 45, '8.50'),
(51, 12, 'Examen Práctico', 35, '6.30'),
(52, 12, 'Actividades de Aula', 20, NULL),
(53, 13, 'Examen Teórico', 45, '8.50'),
(54, 13, 'Examen Práctico', 35, '6.30'),
(55, 13, 'Actividades de Aula', 20, NULL),
(56, 14, 'Examen Teórico', 45, '8.50'),
(57, 14, 'Examen Práctico', 35, '6.30'),
(58, 14, 'Actividades de Aula', 20, NULL),
(59, 15, 'Examen Teórico', 45, '8.50'),
(60, 15, 'Examen Práctico', 35, '6.30'),
(61, 15, 'Actividades de Aula', 20, NULL),
(62, 16, 'Examen Teórico', 45, '8.50'),
(63, 16, 'Examen Práctico', 35, '6.30'),
(64, 16, 'Actividades de Aula', 20, NULL),
(65, 17, 'Examen Teórico', 45, '8.50'),
(66, 17, 'Examen Práctico', 35, '6.30'),
(67, 17, 'Actividades de Aula', 20, NULL),
(68, 18, 'Examen Teórico', 45, '8.50'),
(69, 18, 'Examen Práctico', 35, '6.30'),
(70, 18, 'Actividades de Aula', 20, NULL),
(71, 19, 'Examen Teórico', 45, '8.50'),
(72, 19, 'Examen Práctico', 35, '6.30'),
(73, 19, 'Actividades de Aula', 20, NULL),
(74, 20, 'Examen Teórico', 45, '8.50'),
(75, 20, 'Examen Práctico', 35, '6.30'),
(76, 20, 'Actividades de Aula', 20, NULL),
(77, 21, 'Examen Teórico', 45, '8.50'),
(78, 21, 'Examen Práctico', 35, '6.30'),
(79, 21, 'Actividades de Aula', 20, NULL),
(80, 22, 'Examen Teórico', 45, '8.50'),
(81, 22, 'Examen Práctico', 35, '6.30'),
(82, 22, 'Actividades de Aula', 20, NULL),
(83, 23, 'Examen Teórico', 45, '8.50'),
(84, 23, 'Examen Práctico', 35, '6.30'),
(85, 23, 'Actividades de Aula', 20, NULL),
(86, 24, 'Examen Teórico', 45, '8.50'),
(87, 24, 'Examen Práctico', 35, '6.30'),
(88, 24, 'Actividades de Aula', 20, NULL),
(89, 25, 'Examen Teórico', 45, '8.50'),
(90, 25, 'Examen Práctico', 35, '6.30'),
(91, 25, 'Actividades de Aula', 20, NULL),
(92, 26, 'Examen Teórico', 45, '8.50'),
(93, 26, 'Examen Práctico', 35, '6.30'),
(94, 26, 'Actividades de Aula', 20, NULL),
(95, 27, 'Examen Teórico', 45, '8.50'),
(96, 27, 'Examen Práctico', 35, '6.30'),
(97, 27, 'Actividades de Aula', 20, NULL),
(98, 28, 'Examen Teórico', 45, '8.50'),
(99, 28, 'Examen Práctico', 35, '6.30'),
(100, 28, 'Actividades de Aula', 20, NULL),
(101, 29, 'Examen Teórico', 45, '8.50'),
(102, 29, 'Examen Práctico', 35, '6.30'),
(103, 29, 'Actividades de Aula', 20, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `clave` int(11) NOT NULL,
  `asignatura` int(4) NOT NULL,
  `numero` int(2) NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `porcentaje` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`clave`, `asignatura`, `numero`, `nombre`, `porcentaje`) VALUES
(1, 374, 1, 'Gestión de procesos', 20),
(2, 374, 2, 'Active directory', 20),
(3, 374, 3, 'Crontab', 20),
(4, 374, 4, 'Sistemas de impresión', 20),
(5, 374, 5, 'Elaboración de Scripts', 20),
(6, 375, 1, 'Servicio DHCP', 20),
(7, 375, 2, 'Servicio de DNS', 20),
(8, 375, 3, 'Servicio HTTP', 20),
(9, 375, 4, 'Servicio FTP', 20),
(10, 375, 5, 'Servicio de correo electronico', 20),
(11, 376, 1, 'Conceptos sobre aplicaciones web', 20),
(12, 376, 2, 'Introducción a PHP', 20),
(13, 376, 3, 'Acceso a datos con PHP', 20),
(14, 376, 4, 'Gestión de aplicaciones ofimaticas Web', 20),
(15, 376, 5, 'Funcionalidades y personalización de un CMS', 20),
(16, 377, 1, 'Introducción a la Administración de un SGBD', 20),
(17, 377, 2, 'Arquitectura de Oracle Database', 20),
(18, 377, 3, 'Instalación de Oracle Database', 20),
(19, 377, 4, 'Administración de usuarios de Oracle Database', 20),
(20, 377, 5, 'Automatizacion de tareas de Administración', 20),
(21, 378, 1, 'Seguridad y Alta Disponibilidad', 20),
(22, 378, 2, 'Seguridad Lógica', 20),
(23, 378, 3, 'Seguridad Activa', 20),
(24, 378, 4, 'Criptografía', 20),
(25, 378, 5, 'Seguridad Perimetral', 20),
(26, 380, 1, 'Iniciativa emprendedora', 25),
(27, 380, 2, 'La empresa y su entorno', 25),
(28, 380, 3, 'Forma jurídica de la empresa', 25),
(29, 380, 4, 'Fuentes de financiación', 25);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `instrumentos`
--
ALTER TABLE `instrumentos`
  ADD PRIMARY KEY (`clave`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`clave`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `instrumentos`
--
ALTER TABLE `instrumentos`
  MODIFY `clave` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `clave` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;