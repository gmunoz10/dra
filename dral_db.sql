-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2017 at 12:58 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dral_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `codi_age` int(11) NOT NULL,
  `fech_age` datetime NOT NULL,
  `luga_age` text NOT NULL,
  `desc_age` text NOT NULL,
  `codi_dpe` int(11) NOT NULL,
  `esta_age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`codi_age`, `fech_age`, `luga_age`, `desc_age`, `codi_dpe`, `esta_age`) VALUES
(1, '2017-04-07 14:47:00', 'Usp', 'Visita al rector', 1, -1),
(2, '2016-04-07 14:47:00', 'USP', 'Visita al rector', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `codi_alb` int(11) NOT NULL,
  `titu_alb` text NOT NULL,
  `fech_alb` datetime NOT NULL,
  `codi_usu` int(11) NOT NULL,
  `esta_alb` int(11) NOT NULL,
  `desc_alb` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `declaracion_jurada`
--

CREATE TABLE `declaracion_jurada` (
  `codi_dju` int(11) NOT NULL,
  `codi_usu` int(11) NOT NULL,
  `codi_gdj` int(11) NOT NULL,
  `nume_dju` text NOT NULL,
  `fech_dju` date NOT NULL,
  `desc_dju` text NOT NULL,
  `docu_dju` text NOT NULL,
  `exte_dju` text NOT NULL,
  `esta_dju` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `declaracion_jurada`
--

INSERT INTO `declaracion_jurada` (`codi_dju`, `codi_usu`, `codi_gdj`, `nume_dju`, `fech_dju`, `desc_dju`, `docu_dju`, `exte_dju`, `esta_dju`) VALUES
(1, 0, 1, '001', '0001-01-01', '123', '1970_001.pdf', '.pdf', -1);

-- --------------------------------------------------------

--
-- Table structure for table `dependencia`
--

CREATE TABLE `dependencia` (
  `codi_dpe` int(11) NOT NULL,
  `nomb_dpe` text NOT NULL,
  `esta_dpe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dependencia`
--

INSERT INTO `dependencia` (`codi_dpe`, `nomb_dpe`, `esta_dpe`) VALUES
(1, 'Dirección regional', 1);

-- --------------------------------------------------------

--
-- Table structure for table `directiva`
--

CREATE TABLE `directiva` (
  `codi_dir` int(11) NOT NULL,
  `codi_usu` int(11) NOT NULL,
  `codi_gdi` int(11) NOT NULL,
  `nume_dir` text NOT NULL,
  `fech_dir` date NOT NULL,
  `desc_dir` text NOT NULL,
  `docu_dir` text NOT NULL,
  `exte_dir` text NOT NULL,
  `esta_dir` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evento`
--

CREATE TABLE `evento` (
  `codi_eve` int(11) NOT NULL,
  `titu_eve` text NOT NULL,
  `nume_eve` text NOT NULL,
  `fech_eve` datetime NOT NULL,
  `codi_usu` int(11) NOT NULL,
  `cont_eve` text NOT NULL,
  `imag_eve` text NOT NULL,
  `exte_eve` text NOT NULL,
  `esta_eve` int(11) NOT NULL,
  `id_fb` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grupo_declaracion_jurada`
--

CREATE TABLE `grupo_declaracion_jurada` (
  `codi_gdj` int(11) NOT NULL,
  `nomb_gdj` text NOT NULL,
  `esta_gdj` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grupo_declaracion_jurada`
--

INSERT INTO `grupo_declaracion_jurada` (`codi_gdj`, `nomb_gdj`, `esta_gdj`) VALUES
(1, 'Declaración jurada ejecutiva', 1);

-- --------------------------------------------------------

--
-- Table structure for table `grupo_directiva`
--

CREATE TABLE `grupo_directiva` (
  `codi_gdi` int(11) NOT NULL,
  `nomb_gdi` text NOT NULL,
  `esta_gdi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grupo_directiva`
--

INSERT INTO `grupo_directiva` (`codi_gdi`, `nomb_gdi`, `esta_gdi`) VALUES
(1, 'Directiva ejecutiva', 1);

-- --------------------------------------------------------

--
-- Table structure for table `grupo_pac`
--

CREATE TABLE `grupo_pac` (
  `codi_gpa` int(11) NOT NULL,
  `nomb_gpa` text NOT NULL,
  `esta_gpa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grupo_pac`
--

INSERT INTO `grupo_pac` (`codi_gpa`, `nomb_gpa`, `esta_gpa`) VALUES
(1, '123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `grupo_permiso`
--

CREATE TABLE `grupo_permiso` (
  `codi_gpr` int(11) NOT NULL,
  `desc_gpr` text NOT NULL,
  `esta_gpr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grupo_permiso`
--

INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES
(1, 'Cuentas de acceso', 1),
(2, 'Permisos por rol', 1),
(3, 'Resoluciones', 1),
(4, 'Grupos de resolución', 1),
(5, 'Dependencias', 1),
(6, 'Agenda', 1),
(7, 'Noticias', 1),
(8, 'Grupos de directiva', 1),
(9, 'Directiva', 1),
(10, 'Grupos de declaración jurada', 1),
(11, 'Declaración jurada', 1),
(12, 'Galería', 1),
(13, 'Eventos', 1),
(14, 'Grupos de PAC', 1),
(15, 'PAC', 1);

-- --------------------------------------------------------

--
-- Table structure for table `grupo_resolucion`
--

CREATE TABLE `grupo_resolucion` (
  `codi_gre` int(11) NOT NULL,
  `nomb_gre` text NOT NULL,
  `esta_gre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grupo_resolucion`
--

INSERT INTO `grupo_resolucion` (`codi_gre`, `nomb_gre`, `esta_gre`) VALUES
(1, 'Resolución ejecutiva', 1);

-- --------------------------------------------------------

--
-- Table structure for table `imagen_album`
--

CREATE TABLE `imagen_album` (
  `codi_ial` int(11) NOT NULL,
  `desc_ial` text NOT NULL,
  `imag_ial` text NOT NULL,
  `esta_ial` int(11) NOT NULL,
  `codi_usu` int(11) NOT NULL,
  `codi_alb` int(11) NOT NULL,
  `fech_ial` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `noticia`
--

CREATE TABLE `noticia` (
  `codi_not` int(11) NOT NULL,
  `titu_not` text NOT NULL,
  `nume_not` text NOT NULL,
  `fech_not` datetime NOT NULL,
  `codi_usu` int(11) NOT NULL,
  `cont_not` text NOT NULL,
  `imag_not` text NOT NULL,
  `exte_not` text NOT NULL,
  `esta_not` int(11) NOT NULL,
  `id_fb` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `noticia`
--

INSERT INTO `noticia` (`codi_not`, `titu_not`, `nume_not`, `fech_not`, `codi_usu`, `cont_not`, `imag_not`, `exte_not`, `esta_not`, `id_fb`) VALUES
(1, '123', '123', '2017-04-11 16:57:00', 1, '123', '123.jpg', '.jpg', 1, ''),
(2, '1234', '1234', '2017-04-11 17:02:00', 1, '<p><img src="http://localhost/dra//assets/noticia/imagenes_noticia/11.png" style="width: 715.391px;"><br></p>', '1234.jpg', '.jpg', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `pac`
--

CREATE TABLE `pac` (
  `codi_pac` int(11) NOT NULL,
  `codi_usu` int(11) NOT NULL,
  `codi_gpa` int(11) NOT NULL,
  `nume_pac` text NOT NULL,
  `fech_pac` date NOT NULL,
  `desc_pac` text NOT NULL,
  `docu_pac` text NOT NULL,
  `exte_pac` text NOT NULL,
  `esta_pac` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permiso`
--

CREATE TABLE `permiso` (
  `codi_per` int(11) NOT NULL,
  `desc_per` text NOT NULL,
  `codi_gpr` int(11) NOT NULL,
  `esta_per` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permiso`
--

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES
(1, 'Buscar cuenta de acceso', 1, 1),
(2, 'Leer cuenta de acceso', 1, 1),
(3, 'Registrar nueva cuenta de acceso', 1, 1),
(4, 'Modificar cuenta de acceso', 1, 1),
(5, 'Habilitar cuenta de acceso', 1, 1),
(6, 'Deshabilitar cuenta de acceso', 1, 1),
(7, 'Eliminar cuenta de acceso', 1, 1),
(8, 'Modificar permiso por usuario', 1, 1),
(9, 'Buscar rol', 2, 1),
(10, 'Leer rol', 2, 1),
(11, 'Registrar rol', 2, 1),
(12, 'Modificar rol', 2, 1),
(13, 'Habilitar rol', 2, 1),
(14, 'Deshabilitar rol', 2, 1),
(15, 'Eliminar rol', 2, 1),
(16, 'Modificar permiso por rol', 2, 1),
(17, 'Buscar resolución', 3, 1),
(18, 'Leer resolución', 3, 1),
(19, 'Registrar resolución', 3, 1),
(20, 'Modificar resolución', 3, 1),
(21, 'Habilitar resolución', 3, 1),
(22, 'Deshabilitar resolución', 3, 1),
(23, 'Eliminar resolución', 3, 1),
(24, 'Descargar documento', 3, 1),
(25, 'Buscar grupo de resolución', 4, 1),
(26, 'Leer grupo de resolución', 4, 1),
(27, 'Registrar grupo de resolución', 4, 1),
(28, 'Modificar grupo de resolución', 4, 1),
(29, 'Habilitar grupo de resolución', 4, 1),
(30, 'Deshabilitar grupo de resolución', 4, 1),
(31, 'Eliminar grupo de resolución', 4, 1),
(32, 'Buscar dependencia', 5, 1),
(33, 'Leer dependencia', 5, 1),
(34, 'Registrar dependencia', 5, 1),
(35, 'Modificar dependencia', 5, 1),
(36, 'Habilitar dependencia', 5, 1),
(37, 'Deshabilitar dependencia', 5, 1),
(38, 'Eliminar dependencia', 5, 1),
(39, 'Buscar agenda', 6, 1),
(40, 'Leer agenda', 6, 1),
(41, 'Registrar agenda', 6, 1),
(42, 'Modificar agenda', 6, 1),
(43, 'Habilitar agenda', 6, 1),
(44, 'Deshabilitar agenda', 6, 1),
(45, 'Eliminar agenda', 6, 1),
(46, 'Buscar noticia', 7, 1),
(47, 'Leer noticia', 7, 1),
(48, 'Registrar noticia', 7, 1),
(49, 'Modificar noticia', 7, 1),
(50, 'Habilitar noticia', 7, 1),
(51, 'Deshabilitar noticia', 7, 1),
(52, 'Eliminar noticia', 7, 1),
(53, 'Buscar grupos de directiva', 8, 1),
(54, 'Leer grupo de directiva', 8, 1),
(55, 'Registrar grupo de directiva', 8, 1),
(56, 'Modificar grupo de directiva', 8, 1),
(57, 'Habilitar grupo de directiva', 8, 1),
(58, 'Deshabilitar grupo de directiva', 8, 1),
(59, 'Eliminar grupo de directiva', 8, 1),
(60, 'Buscar directiva', 9, 1),
(61, 'Leer directiva', 9, 1),
(62, 'Registrar directiva', 9, 1),
(63, 'Modificar directiva', 9, 1),
(64, 'Habilitar directiva', 9, 1),
(65, 'Deshabilitar directiva', 9, 1),
(66, 'Eliminar directiva', 9, 1),
(67, 'Descargar directiva', 9, 1),
(68, 'Buscar grupos de declaración jurada', 10, 1),
(69, 'Leer grupo de declaración jurada', 10, 1),
(70, 'Registrar grupo de declaración jurada', 10, 1),
(71, 'Modificar grupo de declaración jurada', 10, 1),
(72, 'Habilitar grupo de declaración jurada', 10, 1),
(73, 'Deshabilitar grupo de declaración jurada', 10, 1),
(74, 'Eliminar grupo de declaración jurada', 10, 1),
(75, 'Buscar declaración jurada', 11, 1),
(76, 'Leer declaración jurada', 11, 1),
(77, 'Registrar declaración jurada', 11, 1),
(78, 'Modificar declaración jurada', 11, 1),
(79, 'Habilitar declaración jurada', 11, 1),
(80, 'Deshabilitar declaración jurada', 11, 1),
(81, 'Eliminar declaración jurada', 11, 1),
(82, 'Descargar declaración jurada', 11, 1),
(83, 'Buscar álbum de imágenes', 12, 1),
(84, 'Ver imágenes de album', 12, 1),
(85, 'Crear álbum de imágenes', 12, 1),
(86, 'Modificar álbum de imágenes', 12, 1),
(87, 'Quitar imagen de álbum', 12, 1),
(88, 'Habilitar álbum de imágenes', 12, 1),
(89, 'Deshabilitar álbum de imágenes', 12, 1),
(90, 'Eliminar álbum de imágenes', 12, 1),
(91, 'Buscar evento', 13, 1),
(92, 'Leer evento', 13, 1),
(93, 'Registrar evento', 13, 1),
(94, 'Modificar evento', 13, 1),
(95, 'Habilitar evento', 13, 1),
(96, 'Deshabilitar evento', 13, 1),
(97, 'Eliminar evento', 13, 1),
(98, 'Buscar grupos de PAC', 14, 1),
(99, 'Leer grupo de PAC', 14, 1),
(100, 'Registrar grupo de PAC', 14, 1),
(101, 'Modificar grupo de PAC', 14, 1),
(102, 'Habilitar grupo de PAC', 14, 1),
(103, 'Deshabilitar grupo de PAC', 14, 1),
(104, 'Eliminar grupo de PAC', 14, 1),
(105, 'Buscar PAC', 15, 1),
(106, 'Leer PAC', 15, 1),
(107, 'Registrar PAC', 15, 1),
(108, 'Modificar PAC', 15, 1),
(109, 'Habilitar PAC', 15, 1),
(110, 'Deshabilitar PAC', 15, 1),
(111, 'Eliminar PAC', 15, 1),
(112, 'Descargar PAC', 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `permiso_rol`
--

CREATE TABLE `permiso_rol` (
  `codi_pro` int(11) NOT NULL,
  `codi_rol` int(11) NOT NULL,
  `codi_per` int(11) NOT NULL,
  `valo_pro` text NOT NULL,
  `esta_pro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permiso_rol`
--

INSERT INTO `permiso_rol` (`codi_pro`, `codi_rol`, `codi_per`, `valo_pro`, `esta_pro`) VALUES
(1, 2, 9, '0', 1),
(2, 2, 10, '0', 1),
(3, 2, 11, '1', 1),
(4, 2, 12, '0', 1),
(5, 2, 13, '1', 1),
(6, 2, 14, '1', 1),
(7, 2, 15, '0', 1),
(8, 2, 16, '0', 1),
(9, 2, 1, '0', 1),
(10, 2, 2, '1', 1),
(11, 2, 3, '0', 1),
(12, 2, 4, '0', 1),
(13, 2, 5, '0', 1),
(14, 2, 6, '1', 1),
(15, 2, 7, '0', 1),
(16, 2, 8, '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `permiso_usuario`
--

CREATE TABLE `permiso_usuario` (
  `codi_pus` int(11) NOT NULL,
  `codi_usu` int(11) NOT NULL,
  `codi_pro` int(11) NOT NULL,
  `valo_pus` text NOT NULL,
  `esta_pus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `resolucion`
--

CREATE TABLE `resolucion` (
  `codi_res` int(11) NOT NULL,
  `codi_usu` int(11) NOT NULL,
  `codi_gre` int(11) NOT NULL,
  `nume_res` text NOT NULL,
  `fech_res` date NOT NULL,
  `desc_res` text NOT NULL,
  `docu_res` text NOT NULL,
  `exte_res` text NOT NULL,
  `esta_res` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resolucion`
--

INSERT INTO `resolucion` (`codi_res`, `codi_usu`, `codi_gre`, `nume_res`, `fech_res`, `desc_res`, `docu_res`, `exte_res`, `esta_res`) VALUES
(1, 0, 1, '123123', '2009-02-27', '12312313 123 41234 123412 41234 12341 23 1234 123412 341234 12341 23412 341234 1234 1234 12341234 12341 2341 2341234 134 1234 1234 1234', '123123.pdf', '.pdf', 1),
(2, 0, 1, '123123', '2009-02-27', '123123', '123123.pdf', '.pdf', -1),
(3, 0, 1, '123123', '2018-07-13', 'aasdad', '123123.pdf', '.pdf', -1);

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `codi_rol` int(11) NOT NULL,
  `desc_rol` text NOT NULL,
  `esta_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`codi_rol`, `desc_rol`, `esta_rol`) VALUES
(1, 'Administrador', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `codi_usu` int(11) NOT NULL,
  `nomb_usu` text NOT NULL,
  `cont_usu` text NOT NULL,
  `esta_usu` int(11) NOT NULL,
  `codi_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`codi_usu`, `nomb_usu`, `cont_usu`, `esta_usu`, `codi_rol`) VALUES
(1, 'gmunoz', '9e13ba9e28cd86b0a87eb941c32de7ce', 1, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_agenda`
--
CREATE TABLE `v_agenda` (
`codi_age` int(11)
,`fech_age` datetime
,`luga_age` text
,`desc_age` text
,`codi_dpe` int(11)
,`esta_age` int(11)
,`nomb_dpe` text
,`esta_dpe` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_album`
--
CREATE TABLE `v_album` (
`codi_alb` int(11)
,`titu_alb` text
,`fech_alb` datetime
,`codi_usu` int(11)
,`esta_alb` int(11)
,`desc_alb` text
,`nomb_usu` text
,`esta_usu` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_declaracion_jurada`
--
CREATE TABLE `v_declaracion_jurada` (
`codi_dju` int(11)
,`codi_usu` int(11)
,`codi_gdj` int(11)
,`nume_dju` text
,`fech_dju` date
,`desc_dju` text
,`docu_dju` text
,`exte_dju` text
,`esta_dju` int(11)
,`nomb_gdj` text
,`esta_gdj` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_directiva`
--
CREATE TABLE `v_directiva` (
`codi_dir` int(11)
,`codi_usu` int(11)
,`codi_gdi` int(11)
,`nume_dir` text
,`fech_dir` date
,`desc_dir` text
,`docu_dir` text
,`exte_dir` text
,`esta_dir` int(11)
,`nomb_gdi` text
,`esta_gdi` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_evento`
--
CREATE TABLE `v_evento` (
`codi_eve` int(11)
,`titu_eve` text
,`nume_eve` text
,`fech_eve` datetime
,`codi_usu` int(11)
,`cont_eve` text
,`imag_eve` text
,`exte_eve` text
,`esta_eve` int(11)
,`id_fb` text
,`nomb_usu` text
,`esta_usu` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_imagen_album`
--
CREATE TABLE `v_imagen_album` (
`codi_ial` int(11)
,`desc_ial` text
,`imag_ial` text
,`esta_ial` int(11)
,`codi_usu` int(11)
,`codi_alb` int(11)
,`fech_ial` datetime
,`desc_alb` text
,`esta_alb` int(11)
,`fech_alb` datetime
,`titu_alb` text
,`nomb_usu` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_noticia`
--
CREATE TABLE `v_noticia` (
`codi_not` int(11)
,`titu_not` text
,`nume_not` text
,`fech_not` datetime
,`codi_usu` int(11)
,`cont_not` text
,`imag_not` text
,`exte_not` text
,`esta_not` int(11)
,`id_fb` text
,`nomb_usu` text
,`esta_usu` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pac`
--
CREATE TABLE `v_pac` (
`codi_pac` int(11)
,`codi_usu` int(11)
,`codi_gpa` int(11)
,`nume_pac` text
,`fech_pac` date
,`desc_pac` text
,`docu_pac` text
,`exte_pac` text
,`esta_pac` int(11)
,`nomb_gpa` text
,`esta_gpa` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_permiso_rol`
--
CREATE TABLE `v_permiso_rol` (
`codi_pro` int(11)
,`codi_rol` int(11)
,`codi_per` int(11)
,`valo_pro` text
,`esta_pro` int(11)
,`esta_per` int(11)
,`codi_gpr` int(11)
,`desc_gpr` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_permiso_usuario`
--
CREATE TABLE `v_permiso_usuario` (
`codi_pus` int(11)
,`codi_usu` int(11)
,`codi_pro` int(11)
,`valo_pus` text
,`esta_pus` int(11)
,`codi_per` int(11)
,`esta_per` int(11)
,`desc_gpr` text
,`esta_pro` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_resolucion`
--
CREATE TABLE `v_resolucion` (
`codi_res` int(11)
,`codi_gre` int(11)
,`nume_res` text
,`fech_res` date
,`desc_res` text
,`docu_res` text
,`exte_res` text
,`esta_res` int(11)
,`nomb_gre` text
,`esta_gre` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_usuario`
--
CREATE TABLE `v_usuario` (
`codi_usu` int(11)
,`nomb_usu` text
,`cont_usu` text
,`esta_usu` int(11)
,`codi_rol` int(11)
,`desc_rol` text
,`esta_rol` int(11)
);

-- --------------------------------------------------------

--
-- Structure for view `v_agenda`
--
DROP TABLE IF EXISTS `v_agenda`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_agenda`  AS  select `a`.`codi_age` AS `codi_age`,`a`.`fech_age` AS `fech_age`,`a`.`luga_age` AS `luga_age`,`a`.`desc_age` AS `desc_age`,`a`.`codi_dpe` AS `codi_dpe`,`a`.`esta_age` AS `esta_age`,`d`.`nomb_dpe` AS `nomb_dpe`,`d`.`esta_dpe` AS `esta_dpe` from (`agenda` `a` join `dependencia` `d`) where (`a`.`codi_dpe` = `d`.`codi_dpe`) ;

-- --------------------------------------------------------

--
-- Structure for view `v_album`
--
DROP TABLE IF EXISTS `v_album`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_album`  AS  select `a`.`codi_alb` AS `codi_alb`,`a`.`titu_alb` AS `titu_alb`,`a`.`fech_alb` AS `fech_alb`,`a`.`codi_usu` AS `codi_usu`,`a`.`esta_alb` AS `esta_alb`,`a`.`desc_alb` AS `desc_alb`,`u`.`nomb_usu` AS `nomb_usu`,`u`.`esta_usu` AS `esta_usu` from (`album` `a` join `usuario` `u`) where (`a`.`codi_usu` = `u`.`codi_usu`) ;

-- --------------------------------------------------------

--
-- Structure for view `v_declaracion_jurada`
--
DROP TABLE IF EXISTS `v_declaracion_jurada`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_declaracion_jurada`  AS  select `d`.`codi_dju` AS `codi_dju`,`d`.`codi_usu` AS `codi_usu`,`d`.`codi_gdj` AS `codi_gdj`,`d`.`nume_dju` AS `nume_dju`,`d`.`fech_dju` AS `fech_dju`,`d`.`desc_dju` AS `desc_dju`,`d`.`docu_dju` AS `docu_dju`,`d`.`exte_dju` AS `exte_dju`,`d`.`esta_dju` AS `esta_dju`,`g`.`nomb_gdj` AS `nomb_gdj`,`g`.`esta_gdj` AS `esta_gdj` from (`declaracion_jurada` `d` join `grupo_declaracion_jurada` `g`) where (`d`.`codi_gdj` = `g`.`codi_gdj`) ;

-- --------------------------------------------------------

--
-- Structure for view `v_directiva`
--
DROP TABLE IF EXISTS `v_directiva`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_directiva`  AS  select `d`.`codi_dir` AS `codi_dir`,`d`.`codi_usu` AS `codi_usu`,`d`.`codi_gdi` AS `codi_gdi`,`d`.`nume_dir` AS `nume_dir`,`d`.`fech_dir` AS `fech_dir`,`d`.`desc_dir` AS `desc_dir`,`d`.`docu_dir` AS `docu_dir`,`d`.`exte_dir` AS `exte_dir`,`d`.`esta_dir` AS `esta_dir`,`g`.`nomb_gdi` AS `nomb_gdi`,`g`.`esta_gdi` AS `esta_gdi` from (`directiva` `d` join `grupo_directiva` `g`) where (`d`.`codi_gdi` = `g`.`codi_gdi`) ;

-- --------------------------------------------------------

--
-- Structure for view `v_evento`
--
DROP TABLE IF EXISTS `v_evento`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_evento`  AS  select `e`.`codi_eve` AS `codi_eve`,`e`.`titu_eve` AS `titu_eve`,`e`.`nume_eve` AS `nume_eve`,`e`.`fech_eve` AS `fech_eve`,`e`.`codi_usu` AS `codi_usu`,`e`.`cont_eve` AS `cont_eve`,`e`.`imag_eve` AS `imag_eve`,`e`.`exte_eve` AS `exte_eve`,`e`.`esta_eve` AS `esta_eve`,`e`.`id_fb` AS `id_fb`,`u`.`nomb_usu` AS `nomb_usu`,`u`.`esta_usu` AS `esta_usu` from (`evento` `e` join `usuario` `u`) where (`e`.`codi_usu` = `u`.`codi_usu`) ;

-- --------------------------------------------------------

--
-- Structure for view `v_imagen_album`
--
DROP TABLE IF EXISTS `v_imagen_album`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_imagen_album`  AS  select `i`.`codi_ial` AS `codi_ial`,`i`.`desc_ial` AS `desc_ial`,`i`.`imag_ial` AS `imag_ial`,`i`.`esta_ial` AS `esta_ial`,`i`.`codi_usu` AS `codi_usu`,`i`.`codi_alb` AS `codi_alb`,`i`.`fech_ial` AS `fech_ial`,`a`.`desc_alb` AS `desc_alb`,`a`.`esta_alb` AS `esta_alb`,`a`.`fech_alb` AS `fech_alb`,`a`.`titu_alb` AS `titu_alb`,`u`.`nomb_usu` AS `nomb_usu` from ((`imagen_album` `i` join `album` `a`) join `usuario` `u`) where ((`i`.`codi_alb` = `a`.`codi_alb`) and (`i`.`codi_usu` = `u`.`codi_usu`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_noticia`
--
DROP TABLE IF EXISTS `v_noticia`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_noticia`  AS  select `n`.`codi_not` AS `codi_not`,`n`.`titu_not` AS `titu_not`,`n`.`nume_not` AS `nume_not`,`n`.`fech_not` AS `fech_not`,`n`.`codi_usu` AS `codi_usu`,`n`.`cont_not` AS `cont_not`,`n`.`imag_not` AS `imag_not`,`n`.`exte_not` AS `exte_not`,`n`.`esta_not` AS `esta_not`,`n`.`id_fb` AS `id_fb`,`u`.`nomb_usu` AS `nomb_usu`,`u`.`esta_usu` AS `esta_usu` from (`noticia` `n` join `usuario` `u`) where (`n`.`codi_usu` = `u`.`codi_usu`) ;

-- --------------------------------------------------------

--
-- Structure for view `v_pac`
--
DROP TABLE IF EXISTS `v_pac`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pac`  AS  select `p`.`codi_pac` AS `codi_pac`,`p`.`codi_usu` AS `codi_usu`,`p`.`codi_gpa` AS `codi_gpa`,`p`.`nume_pac` AS `nume_pac`,`p`.`fech_pac` AS `fech_pac`,`p`.`desc_pac` AS `desc_pac`,`p`.`docu_pac` AS `docu_pac`,`p`.`exte_pac` AS `exte_pac`,`p`.`esta_pac` AS `esta_pac`,`g`.`nomb_gpa` AS `nomb_gpa`,`g`.`esta_gpa` AS `esta_gpa` from (`pac` `p` join `grupo_pac` `g`) where (`p`.`codi_gpa` = `g`.`codi_gpa`) ;

-- --------------------------------------------------------

--
-- Structure for view `v_permiso_rol`
--
DROP TABLE IF EXISTS `v_permiso_rol`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_permiso_rol`  AS  select `pr`.`codi_pro` AS `codi_pro`,`pr`.`codi_rol` AS `codi_rol`,`pr`.`codi_per` AS `codi_per`,`pr`.`valo_pro` AS `valo_pro`,`pr`.`esta_pro` AS `esta_pro`,`p`.`esta_per` AS `esta_per`,`g`.`codi_gpr` AS `codi_gpr`,`g`.`desc_gpr` AS `desc_gpr` from ((`permiso_rol` `pr` join `permiso` `p`) join `grupo_permiso` `g`) where ((`pr`.`codi_per` = `p`.`codi_per`) and (`g`.`codi_gpr` = `p`.`codi_gpr`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_permiso_usuario`
--
DROP TABLE IF EXISTS `v_permiso_usuario`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_permiso_usuario`  AS  select `pu`.`codi_pus` AS `codi_pus`,`pu`.`codi_usu` AS `codi_usu`,`pu`.`codi_pro` AS `codi_pro`,`pu`.`valo_pus` AS `valo_pus`,`pu`.`esta_pus` AS `esta_pus`,`p`.`codi_per` AS `codi_per`,`p`.`esta_per` AS `esta_per`,`g`.`desc_gpr` AS `desc_gpr`,`pr`.`esta_pro` AS `esta_pro` from (((`permiso_usuario` `pu` join `permiso_rol` `pr`) join `permiso` `p`) join `grupo_permiso` `g`) where ((`pu`.`codi_pro` = `pr`.`codi_pro`) and (`pr`.`codi_per` = `p`.`codi_per`) and (`p`.`codi_gpr` = `g`.`codi_gpr`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_resolucion`
--
DROP TABLE IF EXISTS `v_resolucion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_resolucion`  AS  select `r`.`codi_res` AS `codi_res`,`r`.`codi_gre` AS `codi_gre`,`r`.`nume_res` AS `nume_res`,`r`.`fech_res` AS `fech_res`,`r`.`desc_res` AS `desc_res`,`r`.`docu_res` AS `docu_res`,`r`.`exte_res` AS `exte_res`,`r`.`esta_res` AS `esta_res`,`g`.`nomb_gre` AS `nomb_gre`,`g`.`esta_gre` AS `esta_gre` from (`resolucion` `r` join `grupo_resolucion` `g`) where (`r`.`codi_gre` = `g`.`codi_gre`) ;

-- --------------------------------------------------------

--
-- Structure for view `v_usuario`
--
DROP TABLE IF EXISTS `v_usuario`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_usuario`  AS  select `u`.`codi_usu` AS `codi_usu`,`u`.`nomb_usu` AS `nomb_usu`,`u`.`cont_usu` AS `cont_usu`,`u`.`esta_usu` AS `esta_usu`,`u`.`codi_rol` AS `codi_rol`,`r`.`desc_rol` AS `desc_rol`,`r`.`esta_rol` AS `esta_rol` from (`usuario` `u` join `rol` `r`) where (`u`.`codi_rol` = `r`.`codi_rol`) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`codi_age`);

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`codi_alb`);

--
-- Indexes for table `declaracion_jurada`
--
ALTER TABLE `declaracion_jurada`
  ADD PRIMARY KEY (`codi_dju`);

--
-- Indexes for table `dependencia`
--
ALTER TABLE `dependencia`
  ADD PRIMARY KEY (`codi_dpe`);

--
-- Indexes for table `directiva`
--
ALTER TABLE `directiva`
  ADD PRIMARY KEY (`codi_dir`);

--
-- Indexes for table `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`codi_eve`);

--
-- Indexes for table `grupo_declaracion_jurada`
--
ALTER TABLE `grupo_declaracion_jurada`
  ADD PRIMARY KEY (`codi_gdj`);

--
-- Indexes for table `grupo_directiva`
--
ALTER TABLE `grupo_directiva`
  ADD PRIMARY KEY (`codi_gdi`);

--
-- Indexes for table `grupo_pac`
--
ALTER TABLE `grupo_pac`
  ADD PRIMARY KEY (`codi_gpa`);

--
-- Indexes for table `grupo_permiso`
--
ALTER TABLE `grupo_permiso`
  ADD PRIMARY KEY (`codi_gpr`);

--
-- Indexes for table `grupo_resolucion`
--
ALTER TABLE `grupo_resolucion`
  ADD PRIMARY KEY (`codi_gre`);

--
-- Indexes for table `imagen_album`
--
ALTER TABLE `imagen_album`
  ADD PRIMARY KEY (`codi_ial`);

--
-- Indexes for table `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`codi_not`);

--
-- Indexes for table `pac`
--
ALTER TABLE `pac`
  ADD PRIMARY KEY (`codi_pac`);

--
-- Indexes for table `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`codi_per`);

--
-- Indexes for table `permiso_rol`
--
ALTER TABLE `permiso_rol`
  ADD PRIMARY KEY (`codi_pro`);

--
-- Indexes for table `permiso_usuario`
--
ALTER TABLE `permiso_usuario`
  ADD PRIMARY KEY (`codi_pus`);

--
-- Indexes for table `resolucion`
--
ALTER TABLE `resolucion`
  ADD PRIMARY KEY (`codi_res`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`codi_rol`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`codi_usu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `codi_age` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `codi_alb` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `declaracion_jurada`
--
ALTER TABLE `declaracion_jurada`
  MODIFY `codi_dju` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `dependencia`
--
ALTER TABLE `dependencia`
  MODIFY `codi_dpe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `directiva`
--
ALTER TABLE `directiva`
  MODIFY `codi_dir` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `evento`
--
ALTER TABLE `evento`
  MODIFY `codi_eve` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `grupo_declaracion_jurada`
--
ALTER TABLE `grupo_declaracion_jurada`
  MODIFY `codi_gdj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `grupo_directiva`
--
ALTER TABLE `grupo_directiva`
  MODIFY `codi_gdi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `grupo_pac`
--
ALTER TABLE `grupo_pac`
  MODIFY `codi_gpa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `grupo_permiso`
--
ALTER TABLE `grupo_permiso`
  MODIFY `codi_gpr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `grupo_resolucion`
--
ALTER TABLE `grupo_resolucion`
  MODIFY `codi_gre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `imagen_album`
--
ALTER TABLE `imagen_album`
  MODIFY `codi_ial` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `noticia`
--
ALTER TABLE `noticia`
  MODIFY `codi_not` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pac`
--
ALTER TABLE `pac`
  MODIFY `codi_pac` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permiso`
--
ALTER TABLE `permiso`
  MODIFY `codi_per` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;
--
-- AUTO_INCREMENT for table `permiso_rol`
--
ALTER TABLE `permiso_rol`
  MODIFY `codi_pro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `permiso_usuario`
--
ALTER TABLE `permiso_usuario`
  MODIFY `codi_pus` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resolucion`
--
ALTER TABLE `resolucion`
  MODIFY `codi_res` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `codi_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codi_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
