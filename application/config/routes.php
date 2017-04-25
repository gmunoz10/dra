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
$route['enviar_mensaje'] = "MainController/enviar_mensaje";
$route['galeria'] = "MainController/galeria";
$route['galeria/(:num)'] = "MainController/galeria/$1";
$route['agenda/publico'] = "MainController/agenda";
$route['transparencia'] = "MainController/transparencia";
$route['resolucion/(:num)'] = "ResolucionController/resolucion/$1";
$route['resolucion/paginate_portal'] = "ResolucionController/paginate_portal";
$route['directiva/(:num)'] = "DirectivaController/directiva/$1";
$route['directiva/paginate_portal'] = "DirectivaController/paginate_portal";
$route['pac/(:num)'] = "PacController/pac/$1";
$route['pac/paginate_portal'] = "PacController/paginate_portal";
$route['declaracion_jurada/(:num)'] = "DeclaracionJuradaController/declaracion_jurada/$1";
$route['declaracion_jurada/paginate_portal'] = "DeclaracionJuradaController/paginate_portal";
$route['noticia/(:num)'] = "PrensaController/noticia/$1";
$route['noticia/page'] = "PrensaController/lista_noticia";
$route['noticia/page/(:num)'] = "PrensaController/lista_noticia/$1";
$route['evento/(:num)'] = "EventoController/evento/$1";
$route['evento/page'] = "EventoController/lista_evento";
$route['evento/page/(:num)'] = "EventoController/lista_evento/$1";

$route['login'] = "MainController/login";
$route['validar_login'] = "SessionController/validar_login";
$route['cambiar_clave'] = "SessionController/cambiar_clave";
$route['update_cont'] = "UsuarioController/update_cont";
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
$route['resolucion/check_nume_dir'] = "ResolucionController/check_nume_dir";
$route['resolucion/check_nume_dir_actualizar'] = "ResolucionController/check_nume_dir_actualizar";
$route['resolucion/save'] = "ResolucionController/save";
$route['resolucion/save_multi'] = "ResolucionController/save_multi";
$route['resolucion/update'] = "ResolucionController/update";
$route['resolucion/habilitar'] = "ResolucionController/habilitar";
$route['resolucion/deshabilitar'] = "ResolucionController/deshabilitar";
$route['resolucion/eliminar'] = "ResolucionController/eliminar";

$route['grupo_dirolucion'] = "ResolucionController/grupo";
$route['grupo_dirolucion/paginate'] = "ResolucionController/paginate_grupo";
$route['grupo_dirolucion/check_nomb_gre'] = "ResolucionController/check_nomb_gre";
$route['grupo_dirolucion/check_nomb_gre_actualizar'] = "ResolucionController/check_nomb_gre_actualizar";
$route['grupo_dirolucion/save'] = "ResolucionController/save_grupo";
$route['grupo_dirolucion/update'] = "ResolucionController/update_grupo";
$route['grupo_dirolucion/habilitar'] = "ResolucionController/habilitar_grupo";
$route['grupo_dirolucion/deshabilitar'] = "ResolucionController/deshabilitar_grupo";
$route['grupo_dirolucion/eliminar'] = "ResolucionController/eliminar_grupo";

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
$route['noticia/uploadImage'] = "PrensaController/uploadImage";

$route['directiva'] = "DirectivaController/index";
$route['directiva/paginate'] = "DirectivaController/paginate";
$route['directiva/check_nume_dir'] = "DirectivaController/check_nume_dir";
$route['directiva/check_nume_dir_actualizar'] = "DirectivaController/check_nume_dir_actualizar";
$route['directiva/save'] = "DirectivaController/save";
$route['directiva/save_multi'] = "DirectivaController/save_multi";
$route['directiva/update'] = "DirectivaController/update";
$route['directiva/habilitar'] = "DirectivaController/habilitar";
$route['directiva/deshabilitar'] = "DirectivaController/deshabilitar";
$route['directiva/eliminar'] = "DirectivaController/eliminar";

$route['grupo_directiva'] = "DirectivaController/grupo";
$route['grupo_directiva/paginate'] = "DirectivaController/paginate_grupo";
$route['grupo_directiva/check_nomb_gdi'] = "DirectivaController/check_nomb_gdi";
$route['grupo_directiva/check_nomb_gdi_actualizar'] = "DirectivaController/check_nomb_gdi_actualizar";
$route['grupo_directiva/save'] = "DirectivaController/save_grupo";
$route['grupo_directiva/update'] = "DirectivaController/update_grupo";
$route['grupo_directiva/habilitar'] = "DirectivaController/habilitar_grupo";
$route['grupo_directiva/deshabilitar'] = "DirectivaController/deshabilitar_grupo";
$route['grupo_directiva/eliminar'] = "DirectivaController/eliminar_grupo";

$route['declaracion_jurada'] = "DeclaracionJuradaController/index";
$route['declaracion_jurada/paginate'] = "DeclaracionJuradaController/paginate";
$route['declaracion_jurada/check_nume_dju'] = "DeclaracionJuradaController/check_nume_dju";
$route['declaracion_jurada/check_nume_dju_actualizar'] = "DeclaracionJuradaController/check_nume_dju_actualizar";
$route['declaracion_jurada/save'] = "DeclaracionJuradaController/save";
$route['declaracion_jurada/save_multi'] = "DeclaracionJuradaController/save_multi";
$route['declaracion_jurada/update'] = "DeclaracionJuradaController/update";
$route['declaracion_jurada/habilitar'] = "DeclaracionJuradaController/habilitar";
$route['declaracion_jurada/deshabilitar'] = "DeclaracionJuradaController/deshabilitar";
$route['declaracion_jurada/eliminar'] = "DeclaracionJuradaController/eliminar";

$route['grupo_declaracion_jurada'] = "DeclaracionJuradaController/grupo";
$route['grupo_declaracion_jurada/paginate'] = "DeclaracionJuradaController/paginate_grupo";
$route['grupo_declaracion_jurada/check_nomb_gdj'] = "DeclaracionJuradaController/check_nomb_gdj";
$route['grupo_declaracion_jurada/check_nomb_gdj_actualizar'] = "DeclaracionJuradaController/check_nomb_gdj_actualizar";
$route['grupo_declaracion_jurada/save'] = "DeclaracionJuradaController/save_grupo";
$route['grupo_declaracion_jurada/update'] = "DeclaracionJuradaController/update_grupo";
$route['grupo_declaracion_jurada/habilitar'] = "DeclaracionJuradaController/habilitar_grupo";
$route['grupo_declaracion_jurada/deshabilitar'] = "DeclaracionJuradaController/deshabilitar_grupo";
$route['grupo_declaracion_jurada/eliminar'] = "DeclaracionJuradaController/eliminar_grupo";

$route['galeria/admin'] = "GaleriaController/admin";
$route['galeria/admin/(:num)'] = "GaleriaController/admin/$1";
$route['galeria/save_album'] = "GaleriaController/save_album";
$route['galeria/eliminar_imagen'] = "GaleriaController/eliminar_imagen";
$route['galeria/update_title_album'] = "GaleriaController/update_title_album";
$route['galeria/upload_album'] = "GaleriaController/upload_album";
$route['galeria/upload_fecha'] = "GaleriaController/upload_fecha";
$route['galeria/deshabilitar'] = "GaleriaController/deshabilitar";
$route['galeria/habilitar'] = "GaleriaController/habilitar";
$route['galeria/eliminar'] = "GaleriaController/eliminar";

$route['evento'] = "EventoController/index";
$route['evento/paginate'] = "EventoController/paginate";
$route['evento/check_nume_eve'] = "EventoController/check_nume_eve";
$route['evento/check_nume_eve_actualizar'] = "EventoController/check_nume_eve_actualizar";
$route['evento/save'] = "EventoController/save";
$route['evento/update'] = "EventoController/update";
$route['evento/habilitar'] = "EventoController/habilitar";
$route['evento/deshabilitar'] = "EventoController/deshabilitar";
$route['evento/eliminar'] = "EventoController/eliminar";
$route['evento/uploadImage'] = "EventoController/uploadImage";

$route['pac'] = "PacController/index";
$route['pac/paginate'] = "PacController/paginate";
$route['pac/check_nume_pac'] = "PacController/check_nume_pac";
$route['pac/check_nume_pac_actualizar'] = "PacController/check_nume_pac_actualizar";
$route['pac/save'] = "PacController/save";
$route['pac/save_multi'] = "PacController/save_multi";
$route['pac/update'] = "PacController/update";
$route['pac/habilitar'] = "PacController/habilitar";
$route['pac/deshabilitar'] = "PacController/deshabilitar";
$route['pac/eliminar'] = "PacController/eliminar";

$route['grupo_pac'] = "PacController/grupo";
$route['grupo_pac/paginate'] = "PacController/paginate_grupo";
$route['grupo_pac/check_nomb_gpa'] = "PacController/check_nomb_gpa";
$route['grupo_pac/check_nomb_gpa_actualizar'] = "PacController/check_nomb_gpa_actualizar";
$route['grupo_pac/save'] = "PacController/save_grupo";
$route['grupo_pac/update'] = "PacController/update_grupo";
$route['grupo_pac/habilitar'] = "PacController/habilitar_grupo";
$route['grupo_pac/deshabilitar'] = "PacController/deshabilitar_grupo";
$route['grupo_pac/eliminar'] = "PacController/eliminar_grupo";