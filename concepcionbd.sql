-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 12-12-2024 a las 13:42:12
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `concepcionbd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion`
--

DROP TABLE IF EXISTS `asignacion`;
CREATE TABLE IF NOT EXISTS `asignacion` (
  `id_asignacion` bigint NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint NOT NULL,
  `id_curso` bigint NOT NULL,
  `id_grado` bigint NOT NULL,
  `id_aula` bigint NOT NULL,
  `id_periodo` bigint NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modificated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_asignacion`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_curso` (`id_curso`),
  KEY `id_grado` (`id_grado`),
  KEY `id_aula` (`id_aula`),
  KEY `id_periodo` (`id_periodo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignacion`
--

INSERT INTO `asignacion` (`id_asignacion`, `id_usuario`, `id_curso`, `id_grado`, `id_aula`, `id_periodo`, `date_created`, `date_modificated`, `status`) VALUES
(1, 3, 1, 1, 1, 1, '2024-12-08 17:14:55', '2024-12-08 17:14:55', 1),
(2, 4, 1, 1, 1, 1, '2024-12-08 17:15:07', '2024-12-08 17:15:07', 1),
(3, 5, 1, 1, 1, 1, '2024-12-08 17:15:14', '2024-12-08 17:15:14', 1),
(4, 70, 1, 1, 1, 1, '2024-12-08 17:30:49', '2024-12-08 17:30:49', 1),
(5, 29, 2, 1, 1, 1, '2024-12-10 01:08:26', '2024-12-10 01:08:26', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

DROP TABLE IF EXISTS `asistencia`;
CREATE TABLE IF NOT EXISTS `asistencia` (
  `id_asistencia` bigint NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint NOT NULL,
  `fecha_hora` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado_asistencia` enum('Puntual','Tardanza','Justificado') COLLATE utf8mb4_general_ci NOT NULL,
  `observaciones` varchar(400) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_asistencia`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula`
--

DROP TABLE IF EXISTS `aula`;
CREATE TABLE IF NOT EXISTS `aula` (
  `id_aula` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_aula`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aula`
--

INSERT INTO `aula` (`id_aula`, `nombre`, `descripcion`, `status`) VALUES
(1, 'A', '.', 1),
(2, 'B', '.', 1),
(3, 'C', '.', 1),
(4, 'D', '.', 1),
(5, 'E', '.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `competencia`
--

DROP TABLE IF EXISTS `competencia`;
CREATE TABLE IF NOT EXISTS `competencia` (
  `id_competencia` bigint NOT NULL AUTO_INCREMENT,
  `id_curso` bigint NOT NULL,
  `nombre_competencias` varchar(200) COLLATE utf8mb3_spanish2_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_competencia`),
  KEY `id_curso` (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `competencia`
--

INSERT INTO `competencia` (`id_competencia`, `id_curso`, `nombre_competencias`, `fecha_creacion`) VALUES
(1, 1, 'competencia mate 1', '2024-12-08 15:26:38'),
(2, 1, 'competencia mate 2', '2024-12-08 15:26:38'),
(3, 2, 'competencia letras 1', '2024-12-08 15:26:38'),
(4, 2, 'competencia letras 2', '2024-12-08 15:26:38'),
(5, 2, 'competencia letras 3', '2024-12-08 15:26:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto_pago`
--

DROP TABLE IF EXISTS `concepto_pago`;
CREATE TABLE IF NOT EXISTS `concepto_pago` (
  `id_concepto_pago` bigint NOT NULL AUTO_INCREMENT,
  `nombre_concepto` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `monto` float(6,2) NOT NULL,
  `tipo_concepto` enum('Matricula','Mensualidad','Material escolar','Extracurricular') COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_concepto_pago`),
  KEY `id_tipo_concepto` (`tipo_concepto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `concepto_pago`
--

INSERT INTO `concepto_pago` (`id_concepto_pago`, `nombre_concepto`, `descripcion`, `monto`, `tipo_concepto`, `status`) VALUES
(1, 'Matricula 2024', 'Matricula para el año 2024', 250.00, 'Matricula', 1),
(2, 'Mensualidad 2024', 'Mensualidad para los estudiantes en el 2024', 300.00, 'Mensualidad', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

DROP TABLE IF EXISTS `curso`;
CREATE TABLE IF NOT EXISTS `curso` (
  `id_curso` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`id_curso`, `nombre`, `descripcion`, `status`) VALUES
(1, 'Matematicas', 'Se realiza lógica para el', 1),
(2, 'Comunicacion', 'letras', 1),
(3, 'Ciencia y Tecnologia', 'ciencia', 1),
(4, 'Desarrollo Personal Ciudadano y Cívico', 'civil', 1),
(5, 'Arte y Cultura', 'arte', 1),
(6, 'Ingles', 'ingles', 1),
(7, 'Educación Fisica', 'ejercicios fisicos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_notas`
--

DROP TABLE IF EXISTS `estado_notas`;
CREATE TABLE IF NOT EXISTS `estado_notas` (
  `id_estado_notas` int NOT NULL AUTO_INCREMENT,
  `nota_1` tinyint(1) NOT NULL DEFAULT '0',
  `nota_2` tinyint(1) NOT NULL DEFAULT '0',
  `nota_3` tinyint(1) NOT NULL DEFAULT '0',
  `nota_4` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_estado_notas`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_notas`
--

INSERT INTO `estado_notas` (`id_estado_notas`, `nota_1`, `nota_2`, `nota_3`, `nota_4`) VALUES
(1, 1, 0, 0, 0),
(2, 0, 1, 0, 0),
(3, 0, 0, 1, 0),
(4, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

DROP TABLE IF EXISTS `estudiante`;
CREATE TABLE IF NOT EXISTS `estudiante` (
  `id_estudiante` bigint NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint NOT NULL,
  `nombre_apoderado` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `numero_whatsapp` int NOT NULL,
  `matriculado` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_estudiante`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`id_estudiante`, `id_usuario`, `nombre_apoderado`, `numero_whatsapp`, `matriculado`, `status`) VALUES
(1, 3, 'Janeth Milagros Acuña Leandro', 928322860, 1, 1),
(2, 4, 'Gabriela Hualpa Lopez', 928420010, 1, 1),
(3, 5, 'Brindelia Reyna', 912965155, 1, 1),
(4, 6, 'Luis Martín Narvarte Mendoza', 999441524, 1, 1),
(5, 7, 'Carlos Gustavo Ascona Orellana', 967462262, 1, 1),
(6, 8, 'Jessica Marleny Mocheco González', 920362724, 1, 1),
(7, 9, 'Gregoria Yataco De La Cruz', 931508611, 1, 1),
(8, 10, 'Jhosemy Rebeca Caceres Gonzaga', 941775338, 1, 1),
(9, 11, 'Jobina Huacahuasi Ore', 912644689, 1, 1),
(10, 12, 'Jennifer Juana Lazo Charun', 990375846, 1, 1),
(11, 13, 'Lizardo Waldir Lliuya Chipana', 979047464, 1, 1),
(12, 14, 'Karen Bonifacio Mamani', 917673769, 1, 1),
(13, 15, 'Elvira Cahuana Sulca', 948980335, 1, 1),
(14, 16, 'Sandra Vila Meza', 960125901, 1, 1),
(15, 17, 'Janet Estefany Saravia Arias', 932551394, 1, 1),
(16, 18, 'Ethel Tarcila Canales Camposano', 944466539, 1, 1),
(17, 19, 'Luna Atavar Maria Ines', 927683983, 1, 1),
(18, 20, 'Claudia Mercedes Chamorro Quispe', 945221092, 1, 1),
(19, 21, 'Jelle De La Cruz Cuzcano', 975835587, 1, 1),
(20, 22, 'Liliana Yataco De La Cruz', 928369990, 1, 1),
(21, 23, 'Amparo Lucia Barillas Manrique', 949280890, 1, 1),
(22, 24, 'Roy Charles Bustinza Nolazco', 958762074, 1, 1),
(23, 25, 'Janet Vicente Villalva', 981327581, 1, 1),
(24, 26, 'Farid Javier Berrocal Atuncar', 942567018, 1, 1),
(25, 27, 'Laura Elvira Avila De Castañeda', 949622377, 1, 1),
(26, 28, 'Pamela Rocio Flores Gonzales', 987777483, 1, 1),
(27, 29, 'Mercedes Sofía Reyes Panduro', 991242877, 1, 1),
(28, 30, 'América Crisóstomo Palomino', 971728117, 1, 1),
(29, 31, 'Miriyam Mirtha Santiago Valerio', 997538409, 1, 1),
(30, 32, 'Sahari Arenas Gutiérrez', 954784281, 1, 1),
(31, 33, 'Ada Amelia Alcalá Egui', 951706321, 1, 1),
(32, 34, 'Jhon Quilca Martinez', 981073204, 1, 1),
(33, 35, 'Patricia Natalia De La Cruz Berrocal', 904081299, 1, 1),
(34, 36, 'Enilda Hinojo Rojas', 982765239, 1, 1),
(35, 37, 'Susy Ismaela Valderrama Arizaga', 994979735, 1, 1),
(36, 38, 'Pilar Loayza Marcha', 940793159, 1, 1),
(37, 39, 'Ana María Aucahuaqui', 994484723, 1, 1),
(38, 40, 'Margarita De La Cruz Aguado', 949925256, 1, 1),
(39, 41, 'ROSA MARGARITA ECHEANDIA FIESTAS', 920372891, 1, 1),
(40, 42, 'Maria Del Rosario Fernández Franco', 925774221, 1, 1),
(41, 43, 'María Isabel Castillo Meneses', 942352025, 1, 1),
(42, 44, 'María Angélica Ipanaque Mendoza', 945711928, 1, 1),
(43, 45, 'Magdalena Rosas Gutierrez', 980679419, 1, 1),
(44, 46, 'Elvira Cahuana Sulca', 948980335, 1, 1),
(45, 47, 'Miriyam Mirtha Santiago Valerio', 997538409, 1, 1),
(46, 48, 'Ana Cecilia Garcia Romero', 966493868, 1, 1),
(47, 49, 'Enilda Hinojo Rojas', 982765239, 1, 1),
(48, 50, 'Melisa Maribel Castillon Chipana', 931527597, 1, 1),
(49, 51, 'Baleriano Idwen Santos Fernandez', 999168376, 1, 1),
(50, 52, 'Elizabeth Acuña Huaranga', 931163637, 1, 1),
(51, 53, 'Rosas Yumpiri Melisa', 947078951, 1, 1),
(52, 54, 'María Teresa Fernández Franco', 937661353, 1, 1),
(53, 55, 'Gladys Elizabeth Pichihua Ayala', 945543091, 1, 1),
(54, 56, 'Yenny Jessica Machacuay Roman', 967270472, 1, 1),
(55, 57, 'Mónica Eda Ninasque Flores', 992250439, 1, 1),
(56, 58, 'Richard Paul Quispe Ramírez', 998447571, 1, 1),
(57, 59, 'Medalith Quijandria Reyna', 921816770, 1, 1),
(58, 60, 'Dionisio Aguilar Cucho', 924397820, 1, 1),
(59, 61, 'Edith Del Rocio Cajahuanca Alarcon', 924834996, 1, 1),
(60, 62, 'Dina Haydee Llamocca Huaraca', 982721088, 1, 1),
(61, 63, 'Isabel Haydee Chamorro Quispe', 996842997, 1, 1),
(62, 64, 'Massiel Milagros Berrocal Saravia', 990709995, 1, 1),
(63, 65, 'Fredy Manuel Palacios Sevilla', 931929455, 1, 1),
(64, 66, 'Patricia Inés Sánchez Alvarado', 973287206, 1, 1),
(65, 67, 'Olivia Karin Leon Martinez', 910901380, 1, 1),
(66, 68, 'Carlos Miguel Wong Flores', 944223007, 1, 1),
(67, 69, 'Katherine Juliana Arenas Pacasi', 950382865, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grado`
--

DROP TABLE IF EXISTS `grado`;
CREATE TABLE IF NOT EXISTS `grado` (
  `id_grado` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_grado`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grado`
--

INSERT INTO `grado` (`id_grado`, `nombre`, `descripcion`, `status`) VALUES
(1, '1° secundaria', 'Primer nivel de secundaria', 1),
(2, '2° secundaria', 'Segundo nivel de secundaria', 1),
(3, '3° secundaria', 'tercer nivel de secundaria', 1),
(4, '4° Secundaria', 'Cuarto nivel de secundaria', 1),
(5, '5° Secundaria', 'Quinto nivel de secundaria', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

DROP TABLE IF EXISTS `modulo`;
CREATE TABLE IF NOT EXISTS `modulo` (
  `id_modulo` bigint NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(400) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`id_modulo`, `titulo`, `descripcion`, `status`) VALUES
(1, 'Dashboard', '', 1),
(2, 'Usuarios', '', 1),
(3, 'Alumnos', '', 1),
(4, 'Cursos', '', 1),
(5, 'Grados', '', 1),
(6, 'Aulas', '', 1),
(7, 'Configuracion', '', 1),
(8, 'Notas', '', 1),
(9, 'Asistencia', '', 1),
(10, 'Controlasistencia', '', 1),
(11, 'pagos', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_comunicacion`
--

DROP TABLE IF EXISTS `nota_comunicacion`;
CREATE TABLE IF NOT EXISTS `nota_comunicacion` (
  `id_nota` bigint NOT NULL AUTO_INCREMENT,
  `id_asignacion` bigint NOT NULL,
  `id_docente` bigint NOT NULL,
  `nota` tinyint DEFAULT NULL,
  `tema` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_competencia` bigint NOT NULL,
  `bimestre` enum('primerbimestre','segundobimestre','tercerbimestre','cuartobimestre') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_periodo` bigint NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modificated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_nota`),
  KEY `id_alumno` (`id_asignacion`),
  KEY `id_docente` (`id_docente`),
  KEY `id_periodo` (`id_periodo`),
  KEY `id_competencia` (`id_competencia`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_matematica`
--

DROP TABLE IF EXISTS `nota_matematica`;
CREATE TABLE IF NOT EXISTS `nota_matematica` (
  `id_nota` bigint NOT NULL AUTO_INCREMENT,
  `id_asignacion` bigint NOT NULL,
  `id_docente` bigint NOT NULL,
  `nota` tinyint DEFAULT NULL,
  `tema` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `id_competencia` bigint NOT NULL,
  `bimestre` enum('primerbimestre','segundobimestre','tercerbimestre','cuartobimestre') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_periodo` bigint NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modificated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_nota`),
  KEY `id_alumno` (`id_asignacion`),
  KEY `id_docente` (`id_docente`),
  KEY `id_periodo` (`id_periodo`),
  KEY `id_competencia` (`id_competencia`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nota_matematica`
--

INSERT INTO `nota_matematica` (`id_nota`, `id_asignacion`, `id_docente`, `nota`, `tema`, `id_competencia`, `bimestre`, `id_periodo`, `fecha`, `date_modificated`, `status`) VALUES
(17, 1, 70, 12, 'productos notables', 1, 'primerbimestre', 1, '2024-12-08 19:07:36', '2024-12-08 19:07:36', 1),
(18, 1, 70, 14, 'productos notables', 1, 'primerbimestre', 1, '2024-12-08 19:08:30', '2024-12-08 19:08:30', 1),
(19, 1, 70, 12, 'productos notables', 1, 'primerbimestre', 1, '2024-12-08 19:09:08', '2024-12-08 19:09:08', 1),
(20, 2, 70, 12, 'productos notables', 2, 'primerbimestre', 1, '2024-12-08 19:10:46', '2024-12-08 19:10:46', 1),
(21, 2, 70, 15, 'productos notables', 2, 'primerbimestre', 1, '2024-12-10 00:26:00', '2024-12-10 00:26:00', 1),
(22, 3, 70, 6, 'productos notables', 1, 'primerbimestre', 1, '2024-12-10 01:17:08', '2024-12-10 01:17:08', 1),
(23, 3, 70, 10, 'productos notables', 1, 'primerbimestre', 1, '2024-12-10 01:17:20', '2024-12-10 01:17:20', 1),
(24, 1, 70, 20, 'productos notables', 2, 'primerbimestre', 1, '2024-12-10 01:18:54', '2024-12-10 01:18:54', 1),
(25, 1, 70, 10, 'productos notables', 2, 'primerbimestre', 1, '2024-12-10 01:19:04', '2024-12-10 01:19:04', 1),
(26, 1, 70, 15, 'productos notables', 2, 'primerbimestre', 1, '2024-12-10 01:19:18', '2024-12-10 01:19:18', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

DROP TABLE IF EXISTS `pago`;
CREATE TABLE IF NOT EXISTS `pago` (
  `id_pago` bigint NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint NOT NULL,
  `id_concepto_pago` bigint NOT NULL,
  `fecha_pago` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `monto_pagado` float(6,2) NOT NULL,
  `tipo_pago` enum('Efectivo','Transferencia','Deposito') COLLATE utf8mb4_general_ci NOT NULL,
  `estado_pago` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `observaciones` text COLLATE utf8mb4_general_ci,
  `id_periodo` bigint NOT NULL,
  `mes` int DEFAULT NULL,
  PRIMARY KEY (`id_pago`),
  KEY `id_estudiante` (`id_usuario`),
  KEY `id_concepto_pago` (`id_concepto_pago`),
  KEY `id_tipo_pago` (`tipo_pago`),
  KEY `id_periodo` (`id_periodo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id_pago`, `id_usuario`, `id_concepto_pago`, `fecha_pago`, `monto_pagado`, `tipo_pago`, `estado_pago`, `observaciones`, `id_periodo`, `mes`) VALUES
(1, 3, 2, '2024-10-27 23:51:13', 300.00, 'Efectivo', 'Completo', 'Esto es una prueba de funcionalidad', 1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo`
--

DROP TABLE IF EXISTS `periodo`;
CREATE TABLE IF NOT EXISTS `periodo` (
  `id_periodo` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_periodo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `periodo`
--

INSERT INTO `periodo` (`id_periodo`, `nombre`) VALUES
(1, '2024'),
(2, '2025'),
(3, '2026'),
(4, '2027'),
(5, '2028');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

DROP TABLE IF EXISTS `permisos`;
CREATE TABLE IF NOT EXISTS `permisos` (
  `id_permiso` bigint NOT NULL AUTO_INCREMENT,
  `id_rol` bigint NOT NULL,
  `id_modulo` bigint NOT NULL,
  `r` tinyint NOT NULL,
  `w` tinyint NOT NULL,
  `u` tinyint NOT NULL,
  `d` tinyint NOT NULL,
  PRIMARY KEY (`id_permiso`),
  KEY `id_rol` (`id_rol`),
  KEY `id_modulo` (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=167 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `id_rol`, `id_modulo`, `r`, `w`, `u`, `d`) VALUES
(110, 2, 1, 1, 0, 0, 0),
(111, 2, 2, 0, 0, 0, 0),
(112, 2, 3, 0, 0, 0, 0),
(113, 2, 4, 0, 0, 0, 0),
(114, 2, 5, 0, 0, 0, 0),
(115, 2, 6, 0, 0, 0, 0),
(116, 2, 7, 0, 0, 0, 0),
(117, 2, 8, 1, 1, 0, 0),
(145, 1, 1, 1, 1, 1, 1),
(146, 1, 2, 1, 1, 1, 1),
(147, 1, 3, 1, 1, 1, 1),
(148, 1, 4, 1, 1, 1, 1),
(149, 1, 5, 1, 1, 1, 1),
(150, 1, 6, 1, 1, 1, 1),
(151, 1, 7, 1, 1, 1, 1),
(152, 1, 8, 1, 1, 1, 1),
(153, 1, 9, 1, 1, 1, 1),
(154, 1, 10, 1, 1, 1, 1),
(155, 1, 11, 1, 1, 1, 1),
(156, 3, 1, 1, 0, 0, 0),
(157, 3, 2, 0, 0, 0, 0),
(158, 3, 3, 0, 0, 0, 0),
(159, 3, 4, 0, 0, 0, 0),
(160, 3, 5, 0, 0, 0, 0),
(161, 3, 6, 0, 0, 0, 0),
(162, 3, 7, 0, 0, 0, 0),
(163, 3, 8, 0, 0, 0, 0),
(164, 3, 9, 0, 0, 0, 0),
(165, 3, 10, 0, 0, 0, 0),
(166, 3, 11, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `id_rol` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`, `descripcion`, `status`) VALUES
(1, 'Administrador', 'Gestor de todo el sistema', 1),
(2, 'Docente', 'Profesores del colegio unimat', 1),
(3, 'Alumno', 'Estudiante del colegio unimat', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` bigint NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `nombres` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(9) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `contrasena` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_rol` bigint NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `identificacion` (`identificacion`),
  KEY `id_rol` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `identificacion`, `nombres`, `apellidos`, `telefono`, `email`, `contrasena`, `token`, `id_rol`, `date_created`, `status`) VALUES
(1, '76068237', 'Wilber David', 'Durand Gonzales', '931824098', 'los.pc.13@gmail.com', '$2y$10$1jEaqwYJcAZFL0RhpDNenOODdKjtm9tNzTnVbVFaCjzayTYEybHBe', '', 1, '2024-02-03 00:31:13', 1),
(2, '11111111', 'Victor', 'Rojas Camposano', '998589309', 'victoradm@gmail.com', '$2y$10$fNN//vqwLBg1ozPAaoCz7OCNwO4.pkcAZGGxPkTRBOWB4LNRgpCQC', '', 1, '2024-02-03 00:46:11', 1),
(3, '62836552', 'Sumiko Zayuri', 'Flores Acuña', '934076747', 'janethal_0824@hotmail.com', '$2y$10$9jR.a.xSlq0yDM2I5taIveu4dRvAvlWE4YiKoUb./dDAQPFYL129K', NULL, 3, '2024-07-29 10:08:06', 1),
(4, '62962585', 'Sebastian Xavier', 'Leon Hualpa', '928420010', 'sebastianxlh@gmail.com', '$2y$10$43NtNwdo1/1xqSLSPFbrveoOYNoVKdw6S4ur7vGytiAysKEsKcBLq', NULL, 3, '2024-07-29 10:08:06', 1),
(5, '62837329', 'Cielo Yamile', 'Aagos Aviles', '912965155', 'brindeliaavileschoque@gmail.com', '$2y$10$jFaldY7T2Qvmd/18ZnVqjOXozooLmnMeJKeVwxniWIKeRpJzJp2dK', NULL, 3, '2024-07-29 10:08:06', 1),
(6, '63694701', 'Belén Alessandra', 'Narvarte Rodriguez', '999441524', 'l.martin81@hotmail.com', '$2y$10$qN2XEkf0FTK9IKG6iocgRucnU2VLgkVXW9do.M6zXZ3idCLIiEN3S', NULL, 3, '2024-07-29 10:08:06', 1),
(7, '77460533', 'Mathias Valentino', 'Ascona Vasquez', '982925643', 'mathicar1984@gmail.com', '$2y$10$yveIhhvgbLhs285qWxbpkeethMMiV9e5wEpBm94WRe7uIZ/rmwZqu', NULL, 3, '2024-07-29 10:08:06', 1),
(8, '63694940', 'Javier Alexander', 'Luyo Mocheco', '907715729', 'javierluyo18@gmail.com', '$2y$10$abyfZ0jfhZ3qVPNDqsfRKuAP3VgqSFPpeCfPKhAE23lOBzsYeA.7O', NULL, 3, '2024-07-29 10:08:06', 1),
(9, '63694638', 'Alejandro Sebastian', 'Avila Yataco', '931508611', 'gregoriayataco73@gmail.com', '$2y$10$e8Z.SqDAA9IQlhslLbBpQ.hstmm1Eh7uXX6dcQxXhDTfBGSN36J2G', NULL, 3, '2024-07-29 10:08:06', 1),
(10, '62576544', 'Dhanna Isabella', 'Nuñez Caceres', '941775338', 'idem.jc.1@gmail.com', '$2y$10$HzND1EWQ5tJk0B0dxN9xROqwEAhypYSQPpRwmEBkGLLMcJ4ETlmVm', NULL, 3, '2024-07-29 10:08:06', 1),
(11, '62576581', 'Joiner Gonzalo', 'Ayala Huacahuasi', '935649492', 'huacahuasiorejobina@gmail.com', '$2y$10$lOGVN4K.F24OX1HP0hmMEuCxKP0mWoUZGsiRe62qCOtNo0e8ITaOC', NULL, 3, '2024-07-29 10:08:06', 1),
(12, '62576522', 'John Francesco', 'Sanchez Lazo', '952027791', 'sanchezjohnfjhjg@gmail.com', '$2y$10$DfVHwSbN06boT6a0HkeIneVeP3nGV0nk1BtQZXEDcXacgBSR.Y10u', NULL, 3, '2024-07-29 10:08:06', 1),
(13, '62492173', 'Fernando Josue', 'Lliuya Saldaña', '979047464', 'fernandolliuya202@gmail.com', '$2y$10$S8iLke45E1CW5Ls5GSmZeO122frwZVeTWV17CEeakcZ1HgPvX8nta', NULL, 3, '2024-07-29 10:08:06', 1),
(14, '62576600', 'Sandy Graciela', 'De La Cruz Bonifacio', '917673768', 'karenbonifaciosj@gmail.com', '$2y$10$4zYRY8XHqqhGR0WukTtBJOhzyA7c8ybHSlPI.UczkKGkuXfmPJ2JK', NULL, 3, '2024-07-29 10:08:06', 1),
(15, '62492272', 'Josue Smith', 'Uscata Cahuana', '968600493', 'smithuscata@gmail.com', '$2y$10$i199TAO8YuEQBo1X2suT.O/4GpSa9u/YTEsQAQjOwpnX4.0v/vR7S', NULL, 3, '2024-07-29 10:08:06', 1),
(16, '62492060', 'Ailin Dayana', 'Chipana Vila', '960125901', 'vilamezasandra@gmail.com', '$2y$10$2gZ8pNAc1SmciyxQsnP7t.7hT0q25rgRi/ZB6unJQe1YJBR6y6R3u', NULL, 3, '2024-07-29 10:08:06', 1),
(17, '62734567', 'José Fernando', 'Remuzgo Saravia', '973704727', 'remuzgosaraviaj@gmail.com', '$2y$10$kMmrRdmKAEw/hDY3O6rRlOE7luK/MqsUbxSI11XmnT0uqDYYo8tTO', NULL, 3, '2024-07-29 10:08:06', 1),
(18, '62655551', 'Miguel Angel', 'Flores Canales', '993969050', 'miguelcanalescamposano@gmail.com', '$2y$10$RMbbgxHIAV1gNQHTGxNhxOTZCMxntXjOwIWA2n1Uw7X0qPb.Jtsi.', NULL, 3, '2024-07-29 10:08:06', 1),
(19, '62655683', 'Leonardo Manuel', 'Palacios Luna', '919762612', 'leonmanuelpalaciosluna@gmail.com', '$2y$10$fh2m0e8riA.WN14DuYpvneroTsCCHGHqElZziw4akCO3t7y0YIDMS', NULL, 3, '2024-07-29 10:08:07', 1),
(20, '62492127', 'Angeli Kassandra', 'Mayhua Chamorro', '945221092', 'cmcq2009@gmail.com', '$2y$10$ZvgAa25.lKoN.N1BbfYGaeAIYInf9JiQGPTXpv./i9bwtBXhMAS5i', NULL, 3, '2024-07-29 10:08:07', 1),
(21, '62655842', 'Snayder Jhanpieer', 'De La Cruz Quispe', '975835587', 'quispealvitesjacky@gmail.com', '$2y$10$ul.ua2K5I6vkaj.iXehGiuWj2fvJVIBgr.gY.OOBJa8nlrB8YXcsK', NULL, 3, '2024-07-29 10:08:07', 1),
(22, '62733962', 'Eliana Valentina', 'Alzamora Yataco', '900457917', 'yatacoeliana.21@gmail.com', '$2y$10$AwzfKiGRIprGSiVtUXe4u.pIQLJr9NNvcFCypiCtdq9.1Ob9MiFwG', NULL, 3, '2024-07-29 10:08:07', 1),
(23, '62734012', 'Thiago Dereck', 'Pumallanqui Barillas', '949280890', 'amparobarilla@gmail.com', '$2y$10$p7Spb19ttZ.b40JLTrA1e.gCwxsxQ6S5FoZ2QKiDzT1YSR/Eteoly', NULL, 3, '2024-07-29 10:08:07', 1),
(24, '62733920', 'Ashly Stephanie', 'Bustinza Fernández', '975673278', 'amemaless@gmail.com', '$2y$10$OvH7GDjAWGnLpv9vTZXdWuaHgw0gCdtGBJVACCWXA.ZIA06IGsP.u', NULL, 3, '2024-07-29 10:08:07', 1),
(25, '62962796', 'Adana Jushiel', 'Bustamante Vicente', '926546389', 'adanabustamante@hotmail.com.pe', '$2y$10$LtfhfDnPFpEczh4jAWs.TOOAQG1VrlIws7Yo02TCmPcK2AZ/Vx/ca', NULL, 3, '2024-07-29 10:08:07', 1),
(26, '73838725', 'Farid Javier', 'Berrocal Atuncar', '942567018', 'faridberrocal21@gmail.com', '$2y$10$8FBvdLKpk5Ki5dynl5O0yeUjvHZJs1TQRb.xPFHtzvn9JI.ZoSuwW', NULL, 3, '2024-07-29 10:08:07', 1),
(27, '62528759', 'Kevin Daniel', 'Castañeda Avila', '949622377', 'sakura1.3pc@gmail.com', '$2y$10$gjQ6kSx4tapAS3Kx1UcHfuRxWoCfQaj6XP/qrfkfyWk4Y5vunZvfq', NULL, 3, '2024-07-29 10:08:07', 1),
(28, '61992140', 'Alison Fernanda', 'Zamudio Flores', '993889958', 'alisonzamudio667@gmail.com', '$2y$10$jc4Xztz3nst655WvhMzK4O03sCcBAnsPJcnf1SzXEWi9YTOeB30ru', NULL, 3, '2024-07-29 10:08:07', 1),
(29, '61779991', 'Andersson Enrique', 'Gonzáles Reyes', '991217327', 'anderssongonzales8509@gmail.com', '$2y$10$9YNkoCtoOdONppgBb/hhhuBwCWndiC9ZlbrWEDrngz2nL7ZU2YsFO', NULL, 3, '2024-07-29 10:08:07', 1),
(30, '62836862', 'Leonel Cristaldo', 'Rocca Crisóstomo', '998171986', 'roccaleonel13@gmail.com', '$2y$10$6b5OHIofy7h3qY5VofcZy.dj1mLC5pqiJzrbzGtJcCuCA7m.QvN9O', NULL, 3, '2024-07-29 10:08:07', 1),
(31, '62492388', 'Anthony Fabricio', 'Flores Santiago', '957742170', 'afloresmzb2020@gmail.com', '$2y$10$fpbOVGCx69W3eu8xh74J4O3YABLRHPNPQwE9y7YPhif/O3NJ9YJ3m', NULL, 3, '2024-07-29 10:08:07', 1),
(32, '61229961', 'Yasumi Brizet', 'Centeno Arenas', '939895999', 'yasumicentenoarenas@gmail.com', '$2y$10$3GCk2gAt31nCXuvhBNKGpu1EoR1NrLyGWpVcgn9oflR4bkRwloPv6', NULL, 3, '2024-07-29 10:08:07', 1),
(33, '61964831', 'Yumi Alahis', 'Benavides Alcalá', '951706321', 'adaalcala175@gmail.com', '$2y$10$xSC0l.KRcx1zSA6AwUiltu9BhqiqoK70jY75kg4II6g4X7sgrn9DK', NULL, 3, '2024-07-29 10:08:07', 1),
(34, '62576109', 'Steven Abel', 'Quilca Mancha', '981073204', 'stevenquilcamancha@gmail.com', '$2y$10$ZZCUmTmaJrc65bKwjzLNI.WFXZvtbDbG5zN0bi0cLxOueNeqTg/.e', NULL, 3, '2024-07-29 10:08:07', 1),
(35, '43357177', 'Luana Yasuri', 'Yactayo De La Cruz', '933113529', 'yactayoluana83@gmail.com', '$2y$10$5ICTCL.GqAqs9Jt.TuCiKOAQeJTUb1bO.6R.TdI2XF7K7wbK.Mk9u', NULL, 3, '2024-07-29 10:08:07', 1),
(36, '62588819', 'Jose Carlos', 'Rodriguez Hinojo', '982765239', 'josecarlosrh.45@gmail.com', '$2y$10$MGNHuS3O6Ah.WS9qvEhwQ.cf3j4RuTyIIi.y1qnbAwgSCA2F/KyTS', NULL, 3, '2024-07-29 10:08:07', 1),
(37, '61992198', 'Benjamin Diego', 'Moscol Valderrama', '972141397', 'fannymoscol72@gmail.com', '$2y$10$fRsdIy2NGK7sNFKI33GQOOP6DcUWFP1lsRDjUwsJw66PnvAOJraD2', NULL, 3, '2024-07-29 10:08:08', 1),
(38, '61991962', 'Jesús Adrián Angel', 'Mendoza Loayza', '940793159', 'loayzaerika57@gmail.com', '$2y$10$3rz/aBk/cax1C4.q.s8HxOVedUBFiu803JE/ebndL64SsvMuLBJ0K', NULL, 3, '2024-07-29 10:08:08', 1),
(39, '61648449', 'Sergio Rafael', 'Ccarhuas Aucahuaqui', '994484723', 'sergioccarhuas@gmail.com', '$2y$10$Wj/DMprX/ZsfGrND.LZ7COB2djZr0FQ0HDZyUXxS2wUwdR1JdVBTS', NULL, 3, '2024-07-29 10:08:08', 1),
(40, '61964844', 'Mireya Lizeth', 'Machacuay De La Cruz', '949925256', 'mireyaliz0521@gmail.com', '$2y$10$7knImoYOREmiseoQuQw6gelpHoFoONCzeovVGxqwgWfh4nRaiVkEO', NULL, 3, '2024-07-29 10:08:08', 1),
(41, '73715587', 'Fernanda Del Carmen', 'Cueva Echeandia', '920372891', 'rmargaritaef18@gmail.com', '$2y$10$Ql0nbwEnb12x.PmKWd801O.GCNJl0MUI0VwXK7n17ENScc4mW/weq', NULL, 3, '2024-07-29 10:08:08', 1),
(42, '43306273', 'Mattias Sebastian', 'Suica Fernández', '925774221', 'suicamattias@gmail.com', '$2y$10$QJXrRmUqTaPDc5XQKRnUd./Ocmzf2fZFGxwFmnrGCj.d5NYvbtd8.', NULL, 3, '2024-07-29 10:08:08', 1),
(43, '61389522', 'Sebastiani Del Piero', 'Quispe Castillo', '942352025', 'castillomenesesmariaisabel@gmail.com', '$2y$10$fCQ5rnbrig9LpwvsuyGiXeI58QwUuRfdb466NQ0cVq5EkGKh9WvXy', NULL, 3, '2024-07-29 10:08:08', 1),
(44, '61428720', 'Angela Sorely', 'Merzthal Ipanaque', '920561428', 'merzthalangela@gmail.com', '$2y$10$s5Gm/fYAbyj8tBUvcsDXHOXgSc8G9HgiTLhajIhsvZXMi786U6sgK', NULL, 3, '2024-07-29 10:08:08', 1),
(45, '61389683', 'Jhon JairoAntony', 'Maldonado Trillo', '944300122', 'jhoncito0525@gmail.com', '$2y$10$1wpuN6gVeh5pd5lDbKcVJ.Talp4L4gYUetDlMqsKeBAwXsigOQeq2', NULL, 3, '2024-07-29 10:08:08', 1),
(46, '62051728', 'Leonel Wilder', 'Uscata Cahuana', '981757296', 'leonelwilderuscata2020@gmail.com', '$2y$10$t3k2tagEfMlafXu0Ev1qv.X9K2xB.ds6RQxJ.RxV7x8NIXChR/K.q', NULL, 3, '2024-07-29 10:08:08', 1),
(47, '61525773', 'Piero Alessandro', 'Flores Santiago', '953253515', 'pfloresmzb2020@gmail.com', '$2y$10$ehP5FevZn8uCIKhjNqeM6ueRdKxhhuwlK.CC/EgNfaEajY5LufYoW', NULL, 3, '2024-07-29 10:08:08', 1),
(48, '61389326', 'Mariana Cristina', 'Basilio Garcia', '966493868', 'ana.garcia.15.02.1968@gmail.com', '$2y$10$zpTwlU6XHdsP9LFob.6BteA/LjVEO7mHdLugJo8gvxn60IDmVqka6', NULL, 3, '2024-07-29 10:08:08', 1),
(49, '61428694', 'Andrea Luana', 'Rodriguez Hinojo', '982765239', 'andrearodriguezhinojo.386@gmail.com', '$2y$10$CYcJqAHlHjrdyVuPb1etyuDYJp3Ws2z/q5aatQBuJd0LgFlEugej2', NULL, 3, '2024-07-29 10:08:08', 1),
(50, '72598194', 'Jair Roger', 'Tirado Castillon', '947630850', 'tiradocastillojairroger@gmail.com', '$2y$10$sa9L7tpJka1NMP6r90Cp6erVdoZHJM2VwtL5xMIHVYWst.nTYguTi', NULL, 3, '2024-07-29 10:08:08', 1),
(51, '61514363', 'Estrella Jhomayra', 'Santas Rivera', '987446235', 'baleriano2020@gmail.com', '$2y$10$biLUKjKxuF32F.7tMyazVO/1iQr8LuFnClQHMJZOVtdraZ/R92Qbu', NULL, 3, '2024-07-29 10:08:08', 1),
(52, '62051820', 'Abraham German', 'Aroni Acuña', '900539969', 'abramaro1986@gmail.com', '$2y$10$8yHujIGGbgZf5YJN3qyOjecDLTyctdMifrxIrPSMVc1dqWqV1Ke16', NULL, 3, '2024-07-29 10:08:08', 1),
(53, '6144382', 'Mariana', 'Hurtado Rosas', '947078951', 'hurtadorosasmariana@gmail.com', '$2y$10$K6DpsoFrSXoZ02CsRwB4uukNQ2A2rPAL3CCEp7h2ppm0yMco9ozae', NULL, 3, '2024-07-29 10:08:08', 1),
(54, '72063505', 'Patrick Andrei', 'Bustinza Fernández', '910572452', 'mariteff@hotmail.com', '$2y$10$G8etEAkKInDOkIyfOj.vdejbKo/0VmvPHNalXgjEy.vbT06Y1BGtu', NULL, 3, '2024-07-29 10:08:09', 1),
(55, '62051692', 'Luis Enrique', 'Chipa Pichihua', '984080878', 'luischipapichihua@gmail.com', '$2y$10$S5Gbubkjwu.NTJz0BwbxJeq/3WGLvNnhNUPDo001Q7eytVUrOmUSi', NULL, 3, '2024-07-29 10:08:09', 1),
(56, '61426904', 'Sebastián Nicolás', 'Ramón Machacuay', '991337109', 'nicolasmachacuay847@gmail.com', '$2y$10$I1LzCBxyEq1ze5iW4wiP0OuQ58lPUz86pUDE/ZeJEhFCp.J3aag76', NULL, 3, '2024-07-29 10:08:09', 1),
(57, '60571940', 'Kevin Eduardo', 'Huaman Flores', '912456019', 'kevineduardozzzzz@gmail.com', '$2y$10$3Sg1x5A0eSNs3o2v/qvdOemjoENAtk7EzLHL0LdjuqIsLRzxd6yTS', NULL, 3, '2024-07-29 10:08:09', 1),
(58, '61248967', 'Diego Alonzo', 'Quispe Huamán', '976267591', 'diegoquispehuaman0@gmail.com', '$2y$10$6fa6D9VeY/vw3LnyeTVK8egZd5AdwpkEuCyteYtUVSEYD8jADRSYW', NULL, 3, '2024-07-29 10:08:09', 1),
(59, '61249316', 'Luciana', 'Marquez Quijandria', '921816770', 'lucianamarquezquijandria@gmail.com', '$2y$10$Do/rSkZjUL8WzJb40FDPH.C.NBTrz14YoMlUEq.IP.sdKcBce5ZGG', NULL, 3, '2024-07-29 10:08:09', 1),
(60, '61309648', 'Lizbeth Araceli', 'Aguilar Benites', '903434116', 'lizbethaguilar023@gmail.com', '$2y$10$4pXL9lDMXBnSarw4roeCKuwoPN8LSVruvxe7AOxp2r0jEgRVFmiNK', NULL, 3, '2024-07-29 10:08:09', 1),
(61, '71151128', 'Ariana Naomi', 'Ore Cajahuanca', '924834996', 'claudiaore086@gmail.com', '$2y$10$6.zbsrvN1u2eCTQe6iwNJ.yvuTYIGKZPou3swNtCLAGAZbjQs3V/G', NULL, 3, '2024-07-29 10:08:09', 1),
(62, '61347544', 'Marisol Jarumi', 'Chávez Llamocca', '918944639', 'marisolchavezllamocca@gmail.com', '$2y$10$4k7AbufNAEKZkqywXl9oP.Yx0/mfx3tzOXGnwYxLGo5pWA214NvyS', NULL, 3, '2024-07-29 10:08:09', 1),
(63, '61120470', 'Joe Michael', 'García Chamorro', '954831023', 'garciachamorrojoemichael@gmail.com', '$2y$10$LGO/8DAfgq7kLoOSTQ2JfOuH97/GA4jOQg3vxJ8hU1tuivayvSK0q', NULL, 3, '2024-07-29 10:08:09', 1),
(64, '61315513', 'Maria Fernanda', 'Quispe Berrocal', '990709995', 'mberrocalsaravia@gmail.com', '$2y$10$CS215MBgS9ImOieEnoWTbuDrfl4QagSVs/5nxHBJi1jw1UKvdxxDe', NULL, 3, '2024-07-29 10:08:09', 1),
(65, '61347312', 'Nicoas Fret', 'Palacios Luna', '930190706', 'fretpalaciosluna@gmail.com', '$2y$10$.Xn6trcoiC58VdWzbKuHPOKBUno8uveMCHd5tXJ3iD5jlEKANCnmC', NULL, 3, '2024-07-29 10:08:09', 1),
(66, '61389431', 'Alexa Palmira', 'Saboya Sánchez', '940377542', 'alexapalmirass@gmail.com', '$2y$10$/v2uXEsm1w7zjDtsRITNfu7sC7DVGJBDXJ6ZfMOt9lKuM73gq8WQC', NULL, 3, '2024-07-29 10:08:09', 1),
(67, '61199958', 'Eder Josue', 'Laura Leon', '912718176', 'olivialeonm.02@gmail.com', '$2y$10$93TdjnbzaJVjMU6.JWTwXeFBM8n5KD9t0vow7v7B/y6I5ORInLdeC', NULL, 3, '2024-07-29 10:08:09', 1),
(68, '61249240', 'Carlo André', 'Wong Ravina', '944223007', 'luzmariaravinaaburto@gmail.com', '$2y$10$/hnmpf7JgX7xeGnR.7xWP.3485GNqkLhOM4pZgnOGfUTEeXaPsfES', NULL, 3, '2024-07-29 10:08:09', 1),
(69, '61347543', 'Gianella Salome', 'Berrocal Arenas', '914375110', 'katherinearenas090@gmail.com', '$2y$10$41A6o9kPU8pCPu3G1P6MIeLoOox3O/uXsX9g8Oyif.DcYWNRSnqGu', NULL, 3, '2024-07-29 10:08:09', 1),
(70, '31178756', 'Michael Jander', 'Cardenas Gonzales', '789564522', 'prueba@prueba', '$2y$10$.ikUkeevcoAd9.pf3kQDXet78gXjT3j.Wg0nnB5vOydNPJC0JfeEW', NULL, 2, '2024-12-08 17:30:24', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignacion`
--
ALTER TABLE `asignacion`
  ADD CONSTRAINT `asignacion_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asignacion_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asignacion_ibfk_3` FOREIGN KEY (`id_grado`) REFERENCES `grado` (`id_grado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asignacion_ibfk_4` FOREIGN KEY (`id_aula`) REFERENCES `aula` (`id_aula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asignacion_ibfk_5` FOREIGN KEY (`id_periodo`) REFERENCES `periodo` (`id_periodo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `competencia`
--
ALTER TABLE `competencia`
  ADD CONSTRAINT `competencia_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `estudiante_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `nota_matematica`
--
ALTER TABLE `nota_matematica`
  ADD CONSTRAINT `nota_comunicacion_ibfk_2` FOREIGN KEY (`id_docente`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_comunicacion_ibfk_4` FOREIGN KEY (`id_periodo`) REFERENCES `periodo` (`id_periodo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_comunicacion_ibfk_5` FOREIGN KEY (`id_asignacion`) REFERENCES `asignacion` (`id_asignacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_comunicacion_ibfk_6` FOREIGN KEY (`id_competencia`) REFERENCES `competencia` (`id_competencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_matematica_ibfk_2` FOREIGN KEY (`id_docente`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_matematica_ibfk_4` FOREIGN KEY (`id_periodo`) REFERENCES `periodo` (`id_periodo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_matematica_ibfk_5` FOREIGN KEY (`id_asignacion`) REFERENCES `asignacion` (`id_asignacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_matematica_ibfk_6` FOREIGN KEY (`id_competencia`) REFERENCES `competencia` (`id_competencia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_2` FOREIGN KEY (`id_concepto_pago`) REFERENCES `concepto_pago` (`id_concepto_pago`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pago_ibfk_4` FOREIGN KEY (`id_periodo`) REFERENCES `periodo` (`id_periodo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pago_ibfk_5` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`id_modulo`) REFERENCES `modulo` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
