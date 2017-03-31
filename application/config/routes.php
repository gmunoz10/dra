<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = "MainController";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['vision-mision'] = "MainController/vision_mision";
$route['temas-agrarios'] = "MainController/temas_agrarios";
$route['direccion-oficina'] = "MainController/direccion_oficina";
$route['agencias-agrarias'] = "MainController/agencias_agrarias";
$route['contacto'] = "MainController/contacto";
$route['galeria'] = "MainController/galeria";
$route['agenda'] = "MainController/agenda";
$route['transparencia'] = "MainController/transparencia";

$route['login'] = "MainController/login";
$route['validar_login'] = "SessionController/validar_login";
$route['logout'] = "SessionController/logout";

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
