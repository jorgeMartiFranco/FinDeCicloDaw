-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-04-2020 a las 19:27:27
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mundo_balonmano`
--

--
-- Volcado de datos para la tabla `clubs`
--
INSERT INTO `continentes` (`Id_Continente`, `Nombre`) VALUES
(1, 'Europa'),
(2, 'Asia'),
(3, 'África'),
(4, 'América'),
(5, 'Oceanía');

INSERT INTO `paises` (`Id_Pais`, `Codigo`, `Nombre`, `Continente`) VALUES
(1, 'ES', 'España', 1),
(2, 'FR', 'Francia', 1);

INSERT INTO `clubs` (`Id_Club`, `Nombre_Completo`, `Nombre_Corto`, `Pais`) VALUES
(1, 'Acanor Atlético Novás', 'Acanor Novás', 1);

--
-- Volcado de datos para la tabla `competiciones`
--
INSERT INTO `tipos_competicion` (`Id_Tipo_Competicion`, `Tipo_Competicion`, `Descripcion`) VALUES
(1, 'Liga Doméstica', NULL),
(2, 'Copa Doméstica', NULL);

INSERT INTO `competiciones` (`Id_Competicion`, `Nombre`, `Nivel`, `Pais`, `Continente`, `Tipo_Competicion`) VALUES
(1, 'División De Honor Plata', 2, 1, NULL, 1),
(2, '1ª Autonómica Galicia', 4, 1, NULL, 1);

--
-- Volcado de datos para la tabla `continentes`
--



--
-- Volcado de datos para la tabla `cuerpo_tecnico`
--
INSERT INTO `puestos_cuerpo_tecnico` (`Id_Puesto_Cuerpo_Tecnico`, `Puesto`, `Descripcion`) VALUES
(1, 'Entrenador', NULL),
(2, 'Preparador', NULL),
(3, 'Preparador Físico', NULL),
(4, 'Entrenador de Porteros', NULL),
(5, 'Ayudante', NULL),
(6, 'Delegado', NULL);


INSERT INTO `tipos_equipo` (`Id_Tipo_Equipo`, `Tipo`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, 'Juvenil');

INSERT INTO `equipos` (`Id_Equipo`, `Club`, `Tipo_Equipo`, `Competicion`, `Genero`) VALUES
(1, 1, 1, 1, 'M'),
(2, 1, 2, 2, 'M');

INSERT INTO `tipos_contrato` (`Id_Tipo_Contrato`, `Tipo_Contrato`, `Descripcion`) VALUES
(1, 'Profesional', 'Contrato a tiempo completo'),
(2, 'Semiprofesional', 'Contrato a tiempo parcial'),
(3, 'Amateur', 'Sin contrato');

INSERT INTO `cuerpo_tecnico` (`Id_Cuerpo_Tecnico`, `Nombre`, `Apellido1`, `Apellido2`, `Apodo`, `Fecha_Nacimiento`, `Ultimo_Cambio_Equipo`, `Pais`, `Puesto`, `Tipo_Contrato`, `Equipo_Actual`) VALUES
(1, 'César', 'Armán', 'Dorado', 'César Armán', '1992-08-12', '2020-04-10 20:57:12', 1, 1, 2, 2);

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `temporadas` (`Id_Temporada`, `Temporada`) VALUES
(1, '2019/2020'),
(2, '2018/2019');

--
-- Volcado de datos para la tabla `estadisticas_jugadores`
--


--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`Id_Jugador`, `Nombre`, `Apellido1`, `Apellido2`, `Apodo`, `Fecha_Nacimiento`, `Genero`, `Inicio_Contrato`, `Fin_Contrato`, `Ultimo_Cambio_Equipo`, `Pais`, `Tipo_Contrato`, `Equipo_Actual`) VALUES
(1, 'Jorge', 'Martínez', 'Franco', NULL, '2020-08-12', 'M', NULL, NULL, '2020-04-10 20:57:12', 1, 3, 2);

INSERT INTO `puestos` (`Id_Puesto_Jugador`, `Puesto`, `Puesto_Corto`, `Descripcion`) VALUES
(1, 'Extremo Derecho', 'ED', NULL),
(2, 'Extremo Izquierdo', 'EI', NULL),
(3, 'Lateral derecho', 'LD', NULL),
(4, 'Lateral Izquierdo', 'LI', NULL),
(5, 'Central', 'CEN', NULL),
(6, 'Pivote', 'PIV', NULL),
(7, 'Portero', 'POR', NULL);
--
-- Volcado de datos para la tabla `jugadores_puestos`
--

INSERT INTO `estadisticas_jugadores` (`Id_Estadistica_Jugador`, `Goles`, `Perdidas`, `Recuperaciones`, `Temporada`, `Jugador`, `Competicion`) VALUES
(1, 1, 0, 0, 1, 1, 2);
INSERT INTO `jugadores_puestos` (`Jugador`, `Puesto`) VALUES
(1, 7);

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`Id_Noticia`, `Titular`,`Fecha`, `Noticia`, `Competicion`) VALUES
(2, 'Sterbik: \"Hay que ser mentalista si quieres parar lanzamientos a 120 kilómetros por hora\"','2020-04-11', 'Esta temporada va a ser la última de Arpad Sterbik. Uno de los mejores porteros de la historia del balonmano, que en la actualidad milita en el Veszprem, siente que ha llegado el momento de dar un paso al lado a sus 40 años. Con la competición húngara suspendida ayer de manera oficial por la pandemia, Arpad repasa su decisión de dejarlo y su carrera en MARCA.', 1),
(3, 'Arpad Sterbik, el guardameta \'comecocos\' del siglo XXI','2020-04-11', '', 1),
(4, 'Blaz Janc avisa de que si la \'Final Four\' de la Champions es en agosto, la jugará con el Kielce','2020-04-11', '', 1),
(5, 'La Federación Brasileña cesa a Dani Gordo como seleccionador','2020-04-11', '', 1),
(6, 'El brasileño Thiago Alves, otro pilar que seguirá en el Cuenca','2020-04-11', '', 1),
(7, 'Arpad Sterbik, el adiós de un \'gigante\' de las porterías','2020-04-12', '', 1),
(8, 'Finalizadas las competiciones en Dinamarca con el Aalborg y el Esbjerg como campeones','2020-04-12', '', 1),
(9, 'La pandemia del coronavirus precipita la retirada de Sterbik a los 40 años','2020-04-12', '', 1),
(10, 'El Cangas llevará a la Federación ante la justicia ordinaria si hay descensos','2020-04-12', '', 1),
(11, 'Pérez de Vargas: \"Hago cosas que antes no podía hacer por falta de tiempo\"','2020-04-12', '', 1);

--
-- Volcado de datos para la tabla `paises`
--



--
-- Volcado de datos para la tabla `puestos`
--



--
-- Volcado de datos para la tabla `puestos_cuerpo_tecnico`
--



--
-- Volcado de datos para la tabla `temporadas`
--



--
-- Volcado de datos para la tabla `tipos_competicion`
--



--
-- Volcado de datos para la tabla `tipos_contrato`
--



--
-- Volcado de datos para la tabla `tipos_equipo`
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
