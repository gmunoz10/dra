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
(NULL, 'Grupos de PAP', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar grupos de PAP', '14', '1'), 
(NULL, 'Leer grupo de PAP', '14', '1'), 
(NULL, 'Registrar grupo de PAP', '14', '1'), 
(NULL, 'Modificar grupo de PAP', '14', '1'), 
(NULL, 'Habilitar grupo de PAP', '14', '1'), 
(NULL, 'Deshabilitar grupo de PAP', '14', '1'), 
(NULL, 'Eliminar grupo de PAP', '14', '1');

INSERT INTO `grupo_permiso` (`codi_gpr`, `desc_gpr`, `esta_gpr`) VALUES 
(NULL, 'PAP', '1');

INSERT INTO `permiso` (`codi_per`, `desc_per`, `codi_gpr`, `esta_per`) VALUES 
(NULL, 'Buscar PAP', '15', '1'), 
(NULL, 'Leer PAP', '15', '1'), 
(NULL, 'Registrar PAP', '15', '1'), 
(NULL, 'Modificar PAP', '15', '1'), 
(NULL, 'Habilitar PAP', '15', '1'), 
(NULL, 'Deshabilitar PAP', '15', '1'), 
(NULL, 'Eliminar PAP', '15', '1'),
(NULL, 'Descargar PAP', '15', '1');