INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'Dependencias', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar dependencia', '5', '1'), 
(NULL, 'Leer dependencia', '5', '1'), 
(NULL, 'Registrar dependencia', '5', '1'), 
(NULL, 'Modificar dependencia', '5', '1'), 
(NULL, 'Habilitar dependencia', '5', '1'), 
(NULL, 'Deshabilitar dependencia', '5', '1'), 
(NULL, 'Eliminar dependencia', '5', '1');

INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'Agenda', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar agenda', '6', '1'), 
(NULL, 'Leer agenda', '6', '1'), 
(NULL, 'Registrar agenda', '6', '1'), 
(NULL, 'Modificar agenda', '6', '1'), 
(NULL, 'Habilitar agenda', '6', '1'), 
(NULL, 'Deshabilitar agenda', '6', '1'), 
(NULL, 'Eliminar agenda', '6', '1');

CREATE TABLE `dependencia` (
  `codi_dpe` int(11) NOT NULL,
  `nomb_dpe` text NOT NULL,
  `esta_dpe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ADD PRIMARY KEY (`codi_dpe`);

ALTER TABLE `dependencia`
  MODIFY `codi_dpe` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE `agenda` (
  `codi_age` int(11) NOT NULL,
  `fech_age` datetime NOT NULL,
  `luga_age` text NOT NULL,
  `desc_age` text NOT NULL,
  `codi_dpe` int(11) NOT NULL,
  `esta_age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `agenda`
  ADD PRIMARY KEY (`codi_age`);

ALTER TABLE `agenda`
  MODIFY `codi_age` int(11) NOT NULL AUTO_INCREMENT;


CREATE VIEW v_agenda
AS
SELECT a.*, d.nomb_dpe, d.esta_dpe
FROM agenda a, dependencia d
WHERE a.codi_dpe = d.codi_dpe

====================================================================================================================

INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'Noticias', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar noticia', '7', '1'), 
(NULL, 'Leer noticia', '7', '1'), 
(NULL, 'Registrar noticia', '7', '1'), 
(NULL, 'Modificar noticia', '7', '1'), 
(NULL, 'Habilitar noticia', '7', '1'), 
(NULL, 'Deshabilitar noticia', '7', '1'), 
(NULL, 'Eliminar noticia', '7', '1');

CREATE VIEW v_noticia
AS
SELECT n.*, u.nomb_usu, u.esta_usu
FROM noticia n, usuario u
WHERE n.codi_usu = u.codi_usu

====================================================================================================================

INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'Grupos de directiva', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar grupos de directiva', '8', '1'), 
(NULL, 'Leer grupo de directiva', '8', '1'), 
(NULL, 'Registrar grupo de directiva', '8', '1'), 
(NULL, 'Modificar grupo de directiva', '8', '1'), 
(NULL, 'Habilitar grupo de directiva', '8', '1'), 
(NULL, 'Deshabilitar grupo de directiva', '8', '1'), 
(NULL, 'Eliminar grupo de directiva', '8', '1');

INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'Directiva', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar directiva', '9', '1'), 
(NULL, 'Leer directiva', '9', '1'), 
(NULL, 'Registrar directiva', '9', '1'), 
(NULL, 'Modificar directiva', '9', '1'), 
(NULL, 'Habilitar directiva', '9', '1'), 
(NULL, 'Deshabilitar directiva', '9', '1'), 
(NULL, 'Eliminar directiva', '9', '1'),
(NULL, 'Descargar directiva', '9', '1');

====================================================================================================================

INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'Grupos de declaración jurada', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar grupos de declaración jurada', '10', '1'), 
(NULL, 'Leer grupo de declaración jurada', '10', '1'), 
(NULL, 'Registrar grupo de declaración jurada', '10', '1'), 
(NULL, 'Modificar grupo de declaración jurada', '10', '1'), 
(NULL, 'Habilitar grupo de declaración jurada', '10', '1'), 
(NULL, 'Deshabilitar grupo de declaración jurada', '10', '1'), 
(NULL, 'Eliminar grupo de declaración jurada', '10', '1');

INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'Declaración jurada', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar declaración jurada', '11', '1'), 
(NULL, 'Leer declaración jurada', '11', '1'), 
(NULL, 'Registrar declaración jurada', '11', '1'), 
(NULL, 'Modificar declaración jurada', '11', '1'), 
(NULL, 'Habilitar declaración jurada', '11', '1'), 
(NULL, 'Deshabilitar declaración jurada', '11', '1'), 
(NULL, 'Eliminar declaración jurada', '11', '1'),
(NULL, 'Descargar declaración jurada', '11', '1');


====================================================================================================================

INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'Galería', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar álbum de imágenes', '12', '1'), 
(NULL, 'Ver imágenes de album', '12', '1'), 
(NULL, 'Crear álbum de imágenes', '12', '1'), 
(NULL, 'Modificar álbum de imágenes', '12', '1'), 
(NULL, 'Quitar imagen de álbum', '12', '1'), 
(NULL, 'Habilitar álbum de imágenes', '12', '1'), 
(NULL, 'Deshabilitar álbum de imágenes', '12', '1'), 
(NULL, 'Eliminar álbum de imágenes', '12', '1');


====================================================================================================================

INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'Eventos', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar evento', '13', '1'), 
(NULL, 'Leer evento', '13', '1'), 
(NULL, 'Registrar evento', '13', '1'), 
(NULL, 'Modificar evento', '13', '1'), 
(NULL, 'Habilitar evento', '13', '1'), 
(NULL, 'Deshabilitar evento', '13', '1'), 
(NULL, 'Eliminar evento', '13', '1');

====================================================================================================================

INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'Grupos de PAC', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar grupos de PAC', '14', '1'), 
(NULL, 'Leer grupo de PAC', '14', '1'), 
(NULL, 'Registrar grupo de PAC', '14', '1'), 
(NULL, 'Modificar grupo de PAC', '14', '1'), 
(NULL, 'Habilitar grupo de PAC', '14', '1'), 
(NULL, 'Deshabilitar grupo de PAC', '14', '1'), 
(NULL, 'Eliminar grupo de PAC', '14', '1');

INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'PAC', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar PAC', '15', '1'), 
(NULL, 'Leer PAC', '15', '1'), 
(NULL, 'Registrar PAC', '15', '1'), 
(NULL, 'Modificar PAC', '15', '1'), 
(NULL, 'Habilitar PAC', '15', '1'), 
(NULL, 'Deshabilitar PAC', '15', '1'), 
(NULL, 'Eliminar PAC', '15', '1'),
(NULL, 'Descargar PAC', '15', '1');

====================================================================================================================

INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'Temas agrarios', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar tema agrario', '16', '1'), 
(NULL, 'Leer tema agrario', '16', '1'), 
(NULL, 'Registrar tema agrario', '16', '1'), 
(NULL, 'Modificar tema agrario', '16', '1'), 
(NULL, 'Habilitar tema agrario', '16', '1'), 
(NULL, 'Deshabilitar tema agrario', '16', '1'), 
(NULL, 'Eliminar tema agrario', '16', '1');

====================================================================================================================

INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'Visitas', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar visita', '17', '1'), 
(NULL, 'Leer visita', '17', '1'), 
(NULL, 'Registrar visita', '17', '1'), 
(NULL, 'Modificar visita', '17', '1'), 
(NULL, 'Habilitar visita', '17', '1'), 
(NULL, 'Deshabilitar visita', '17', '1'), 
(NULL, 'Eliminar visita', '17', '1');

====================================================================================================================


CREATE TABLE `empleado` (
  `codi_emp` int(11) NOT NULL,
  `nomb_emp` text NOT NULL,
  `apel_emp` text NOT NULL,
  `carg_emp` text NOT NULL,
  `tipo_emp` text NOT NULL,
  `ofic_emp` text NOT NULL,
  `docu_emp` text NOT NULL,
  `esta_emp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `empleado` (`codi_emp`, `nomb_emp`, `apel_emp`, `carg_emp`, `tipo_emp`, `ofic_emp`, `docu_emp`, `esta_emp`) VALUES
(1, 'GERARDO', 'MUÑOZ', 'ASISTENTE DE INFORMATICA', 'TERCERO', 'UNIDAD DE INFORMÁTICA', '72676182', 1);

ALTER TABLE `empleado`
  ADD PRIMARY KEY (`codi_emp`);

ALTER TABLE `empleado`
  MODIFY `codi_emp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `visita` CHANGE `visi_vis` `nomb_vis` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `visita` ADD `apel_vis` TEXT NOT NULL AFTER `nomb_vis`;

====================================================================================================================

INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'Empleados', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar empleado', '18', '1'), 
(NULL, 'Leer empleado', '18', '1'), 
(NULL, 'Registrar empleado', '18', '1'), 
(NULL, 'Modificar empleado', '18', '1'), 
(NULL, 'Habilitar empleado', '18', '1'), 
(NULL, 'Deshabilitar empleado', '18', '1'), 
(NULL, 'Eliminar empleado', '18', '1');


ALTER TABLE `visita` ADD `tipo_vis` TEXT NOT NULL AFTER `apel_vis`;

UPDATE visita set tipo_vis = 'D.N.I.';

====================================================================================================================

CREATE TABLE `asistencia` (
  `codi_asi` int(11) NOT NULL,
  `fech_asi` date NOT NULL,
  `ingr_asi` text NOT NULL,
  `sali_asi` text NOT NULL,
  `codi_emp` int(11) NOT NULL,
  `obsv_emp` text NOT NULL,
  `esta_asi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`codi_asi`);

ALTER TABLE `asistencia`
  MODIFY `codi_asi` int(11) NOT NULL AUTO_INCREMENT;

CREATE VIEW v_asistencia
AS
SELECT a.*, CONCAT(e.apel_emp, ', ', e.nomb_emp) as full_asi, e.ofic_emp, e.docu_emp, e.nomb_emp, e.apel_emp
FROM empleado e, asistencia a
WHERE e.codi_emp = a.codi_emp


INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'Asistencia', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar asistencia', '19', '1'), 
(NULL, 'Leer asistencia', '19', '1'), 
(NULL, 'Registrar asistencia', '19', '1'), 
(NULL, 'Modificar asistencia', '19', '1'), 
(NULL, 'Habilitar asistencia', '19', '1'), 
(NULL, 'Deshabilitar asistencia', '19', '1'), 
(NULL, 'Eliminar asistencia', '19', '1');

====================================================================================================================

INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'Comisión', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar comisión', '20', '1'), 
(NULL, 'Leer comisión', '20', '1'), 
(NULL, 'Registrar comisión', '20', '1'), 
(NULL, 'Modificar comisión', '20', '1'), 
(NULL, 'Habilitar comisión', '20', '1'), 
(NULL, 'Deshabilitar comisión', '20', '1'), 
(NULL, 'Eliminar comisión', '20', '1');

CREATE VIEW v_comision
AS
SELECT c.*, CONCAT(e.apel_emp, ', ', e.nomb_emp) as full_asi, e.tipo_emp, e.ofic_emp, e.docu_emp, e.nomb_emp, e.apel_emp
FROM empleado e, comision c
WHERE e.codi_emp = c.codi_emp

CREATE VIEW v_detalle_comision
AS
SELECT c.*, d.num_dco, d.ingr_dco, d.sali_dco, d.obsv_dco
FROM v_comision c, detalle_comision d
WHERE c.codi_com = d.codi_com