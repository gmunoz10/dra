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