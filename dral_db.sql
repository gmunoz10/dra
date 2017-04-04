-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2017 at 01:33 AM
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
(3, 'Resoluciones', 1);

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
(1, 'Resolución ejecutiva', 1),
(2, 'Resolución administrativa', 1),
(3, 'Resolución gerencial', 1);

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
(24, 'Descargar documento', 3, 1);

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

INSERT INTO `resolucion` (`codi_res`, `codi_gre`, `nume_res`, `fech_res`, `desc_res`, `docu_res`, `exte_res`, `esta_res`) VALUES
(1, 2, '004', '2016-05-10', 'Resolucion 001', '004.pdf', '.pdf', 1),
(2, 1, '011', '2018-07-06', '123123', '011.pdf', '.pdf', -1),
(3, 3, '022', '2013-01-31', '123123', '022.pdf', '.pdf', 1);

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
(1, 'Administrador', 1),
(2, 'Administrador de cuentas', 1);

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
-- AUTO_INCREMENT for table `grupo_permiso`
--
ALTER TABLE `grupo_permiso`
  MODIFY `codi_gpr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `grupo_resolucion`
--
ALTER TABLE `grupo_resolucion`
  MODIFY `codi_gre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `permiso`
--
ALTER TABLE `permiso`
  MODIFY `codi_per` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
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
  MODIFY `codi_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codi_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
