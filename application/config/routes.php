<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = "MainController";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['test/index'] = "TestController/index";

$route['vision-mision'] = "MainController/vision_mision";
$route['temas-agrarios'] = "MainController/temas_agrarios";
$route['direccion-oficina'] = "MainController/direccion_oficina";
$route['agencias-agrarias'] = "MainController/agencias_agrarias";
$route['contacto'] = "MainController/contacto";
$route['galeria'] = "MainController/galeria";
$route['agenda/publico'] = "MainController/agenda";
$route['transparencia'] = "MainController/transparencia";
$route['resolucion/(:num)'] = "ResolucionController/resolucion/$1";
$route['resolucion/paginate_portal'] = "ResolucionController/paginate_portal";

$route['login'] = "MainController/login";
$route['validar_login'] = "SessionController/validar_login";
$route['logout'] = "SessionController/logout";

$route['permiso/rol'] = "PermisoController/rol";
$route['permiso/get_permisos_rol'] = "PermisoController/get_permisos_rol";
$route['permiso/save_permiso_rol'] = "PermisoController/save_permiso_rol";
$route['permiso/get_permisos_usuario'] = "PermisoController/get_permisos_usuario";
$route['permiso/save_permiso_usuario'] = "PermisoController/save_permiso_usuario";

$route['usuario'] = "UsuarioController/index";
$route['usuario/paginate'] = "UsuarioController/paginate";
$route['usuario/check_nomb_usu'] = "UsuarioController/check_nomb_usu";
$route['usuario/check_nomb_usu_actualizar'] = "UsuarioController/check_nomb_usu_actualizar";
$route['usuario/check_cont_usu'] = "UsuarioController/check_cont_usu";
$route['usuario/save'] = "UsuarioController/save";
$route['usuario/update'] = "UsuarioController/update";
$route['usuario/habilitar'] = "UsuarioController/habilitar";
$route['usuario/deshabilitar'] = "UsuarioController/deshabilitar";
$route['usuario/eliminar'] = "UsuarioController/eliminar";

$route['rol'] = "RolController/index";
$route['rol/paginate'] = "RolController/paginate";
$route['rol/check_desc_rol'] = "RolController/check_desc_rol";
$route['rol/check_desc_rol_actualizar'] = "RolController/check_desc_rol_actualizar";
$route['rol/save'] = "RolController/save";
$route['rol/update'] = "RolController/update";
$route['rol/habilitar'] = "RolController/habilitar";
$route['rol/deshabilitar'] = "RolController/deshabilitar";
$route['rol/eliminar'] = "RolController/eliminar";

$route['resolucion'] = "ResolucionController/index";
$route['resolucion/paginate'] = "ResolucionController/paginate";
$route['resolucion/check_nume_res'] = "ResolucionController/check_nume_res";
$route['resolucion/check_nume_res_actualizar'] = "ResolucionController/check_nume_res_actualizar";
$route['resolucion/save'] = "ResolucionController/save";
$route['resolucion/save_multi'] = "ResolucionController/save_multi";
$route['resolucion/update'] = "ResolucionController/update";
$route['resolucion/habilitar'] = "ResolucionController/habilitar";
$route['resolucion/deshabilitar'] = "ResolucionController/deshabilitar";
$route['resolucion/eliminar'] = "ResolucionController/eliminar";

$route['grupo_resolucion'] = "ResolucionController/grupo";
$route['grupo_resolucion/paginate'] = "ResolucionController/paginate_grupo";
$route['grupo_resolucion/check_nomb_gre'] = "ResolucionController/check_nomb_gre";
$route['grupo_resolucion/check_nomb_gre_actualizar'] = "ResolucionController/check_nomb_gre_actualizar";
$route['grupo_resolucion/save'] = "ResolucionController/save_grupo";
$route['grupo_resolucion/update'] = "ResolucionController/update_grupo";
$route['grupo_resolucion/habilitar'] = "ResolucionController/habilitar_grupo";
$route['grupo_resolucion/deshabilitar'] = "ResolucionController/deshabilitar_grupo";
$route['grupo_resolucion/eliminar'] = "ResolucionController/eliminar_grupo";

$route['dependencia'] = "AgendaController/dependencia";
$route['dependencia/paginate'] = "AgendaController/paginate_dependencia";
$route['dependencia/check_nomb_dpe'] = "AgendaController/check_nomb_dpe";
$route['dependencia/check_nomb_dpe_actualizar'] = "AgendaController/check_nomb_dpe_actualizar";
$route['dependencia/save'] = "AgendaController/save_dependencia";
$route['dependencia/update'] = "AgendaController/update_dependencia";
$route['dependencia/habilitar'] = "AgendaController/habilitar_dependencia";
$route['dependencia/deshabilitar'] = "AgendaController/deshabilitar_dependencia";
$route['dependencia/eliminar'] = "AgendaController/eliminar_dependencia";

$route['agenda'] = "AgendaController/index";
$route['agenda/paginate'] = "AgendaController/paginate";
$route['agenda/save'] = "AgendaController/save";
$route['agenda/update'] = "AgendaController/update";
$route['agenda/habilitar'] = "AgendaController/habilitar";
$route['agenda/deshabilitar'] = "AgendaController/deshabilitar";
$route['agenda/eliminar'] = "AgendaController/eliminar";
$route['agenda/paginate_public'] = "AgendaController/paginate_public";

$route['noticia'] = "PrensaController/index";
$route['noticia/paginate'] = "PrensaController/paginate";
$route['noticia/check_nume_not'] = "PrensaController/check_nume_not";
$route['noticia/check_nume_not_actualizar'] = "PrensaController/check_nume_not_actualizar";
$route['noticia/save'] = "PrensaController/save";
$route['noticia/update'] = "PrensaController/update";
$route['noticia/habilitar'] = "PrensaController/habilitar";
$route['noticia/deshabilitar'] = "PrensaController/deshabilitar";
$route['noticia/eliminar'] = "PrensaController/eliminar";

