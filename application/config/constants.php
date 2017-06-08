<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESCTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code



/*
|--------------------------------------------------------------------------
| Facebook API
|--------------------------------------------------------------------------
*/
defined('APP_ID_FB')   				OR define('APP_ID_FB', '1327135627399921');
defined('APP_SECRET_FB')   			OR define('APP_SECRET_FB', '7b7732eb917c72e8a51a54dcc8a0dd44');
defined('ACCESS_TOKEN_FB')   		OR define('ACCESS_TOKEN_FB', 'EAAS3Bdej0vEBAIrcalLZChojkOey6DRQNKe3dD2NztSiCANFVaTfLqBAbZBpOWNKaV8r7WEldvz4r590JYvcWP93fgIcUU7lBWVSeR9B3JzaFldK7x2CceQxPQyKHuXeZA6H1bSVQnEtmvlGOUJm3UKu5rucZApxWXBjgauMDwZDZD');


/*
|--------------------------------------------------------------------------
| Permisos
|--------------------------------------------------------------------------
*/
// CUENTAS DE ACCESO
defined('BUSCAR_CUENTA')        		OR define('BUSCAR_CUENTA', 1);
defined('LEER_CUENTA')          		OR define('LEER_CUENTA', 2);
defined('REGISTRAR_CUENTA')     		OR define('REGISTRAR_CUENTA', 3);
defined('MODIFICAR_CUENTA')     		OR define('MODIFICAR_CUENTA', 4);
defined('HABILITAR_CUENTA')     		OR define('HABILITAR_CUENTA', 5);
defined('DESHABILITAR_CUENTA')     		OR define('DESHABILITAR_CUENTA', 6);
defined('ELIMINAR_CUENTA')  	   		OR define('ELIMINAR_CUENTA', 7);
defined('MODIFICAR_PERMISO_USUARIO')    OR define('MODIFICAR_PERMISO_USUARIO', 8);
// ROLES
defined('BUSCAR_ROL')     				OR define('BUSCAR_ROL', 9);
defined('LEER_ROL')          			OR define('LEER_ROL', 10);
defined('REGISTRAR_ROL')     			OR define('REGISTRAR_ROL', 11);
defined('MODIFICAR_ROL')     			OR define('MODIFICAR_ROL', 12);
defined('HABILITAR_ROL')     			OR define('HABILITAR_ROL', 13);
defined('DESHABILITAR_ROL')     		OR define('DESHABILITAR_ROL', 14);
defined('ELIMINAR_ROL')  	   			OR define('ELIMINAR_ROL', 15);
defined('MODIFICAR_PERMISO_ROL')     	OR define('MODIFICAR_PERMISO_ROL', 16);
// RESOLUCIONES
defined('BUSCAR_RESOLUCION')  			OR define('BUSCAR_RESOLUCION', 17);
defined('LEER_RESOLUCION')          	OR define('LEER_RESOLUCION', 18);
defined('REGISTRAR_RESOLUCION')     	OR define('REGISTRAR_RESOLUCION', 19);
defined('MODIFICAR_RESOLUCION')     	OR define('MODIFICAR_RESOLUCION', 20);
defined('HABILITAR_RESOLUCION')     	OR define('HABILITAR_RESOLUCION', 21);
defined('DESHABILITAR_RESOLUCION')     	OR define('DESHABILITAR_RESOLUCION', 22);
defined('ELIMINAR_RESOLUCION')   		OR define('ELIMINAR_RESOLUCION', 23);
defined('DESCARGAR_RESOLUCION')   		OR define('DESCARGAR_RESOLUCION', 24);
// GRUPO DE RESOLUCIONES
defined('BUSCAR_GRUPO_RESOLUCION')  	OR define('BUSCAR_GRUPO_RESOLUCION', 25);
defined('LEER_GRUPO_RESOLUCION')        OR define('LEER_GRUPO_RESOLUCION', 26);
defined('REGISTRAR_GRUPO_RESOLUCION')   OR define('REGISTRAR_GRUPO_RESOLUCION', 27);
defined('MODIFICAR_GRUPO_RESOLUCION')   OR define('MODIFICAR_GRUPO_RESOLUCION', 28);
defined('HABILITAR_GRUPO_RESOLUCION')   OR define('HABILITAR_GRUPO_RESOLUCION', 29);
defined('DESHABILITAR_GRUPO_RESOLUCION')OR define('DESHABILITAR_GRUPO_RESOLUCION', 30);
defined('ELIMINAR_GRUPO_RESOLUCION')   	OR define('ELIMINAR_GRUPO_RESOLUCION', 31);
// DEPENDENCIA
defined('BUSCAR_DEPENDENCIA')			OR define('BUSCAR_DEPENDENCIA', 32);
defined('LEER_DEPENDENCIA')        		OR define('LEER_DEPENDENCIA', 33);
defined('REGISTRAR_DEPENDENCIA')   		OR define('REGISTRAR_DEPENDENCIA', 34);
defined('MODIFICAR_DEPENDENCIA')   		OR define('MODIFICAR_DEPENDENCIA', 35);
defined('HABILITAR_DEPENDENCIA')   		OR define('HABILITAR_DEPENDENCIA', 36);
defined('DESHABILITAR_DEPENDENCIA')		OR define('DESHABILITAR_DEPENDENCIA', 37);
defined('ELIMINAR_DEPENDENCIA')   		OR define('ELIMINAR_DEPENDENCIA', 38);
// AGENDA
defined('BUSCAR_AGENDA')  				OR define('BUSCAR_AGENDA', 39);
defined('LEER_AGENDA')        			OR define('LEER_AGENDA', 40);
defined('REGISTRAR_AGENDA')  			OR define('REGISTRAR_AGENDA', 41);
defined('MODIFICAR_AGENDA')   			OR define('MODIFICAR_AGENDA', 42);
defined('HABILITAR_AGENDA')   			OR define('HABILITAR_AGENDA', 43);
defined('DESHABILITAR_AGENDA')			OR define('DESHABILITAR_AGENDA', 44);
defined('ELIMINAR_AGENDA')   			OR define('ELIMINAR_AGENDA', 45);
// NOTICIA
defined('BUSCAR_NOTICIA')  				OR define('BUSCAR_NOTICIA', 46);
defined('LEER_NOTICIA')        			OR define('LEER_NOTICIA', 47);
defined('REGISTRAR_NOTICIA')   			OR define('REGISTRAR_NOTICIA', 48);
defined('MODIFICAR_NOTICIA')   			OR define('MODIFICAR_NOTICIA', 49);
defined('HABILITAR_NOTICIA')   			OR define('HABILITAR_NOTICIA', 50);
defined('DESHABILITAR_NOTICIA')			OR define('DESHABILITAR_NOTICIA', 51);
defined('ELIMINAR_NOTICIA')   			OR define('ELIMINAR_NOTICIA', 52);
// GRUPO DE DIRECTIVAS
defined('BUSCAR_GRUPO_DIRECTIVA')  		OR define('BUSCAR_GRUPO_DIRECTIVA', 53);
defined('LEER_GRUPO_DIRECTIVA')        	OR define('LEER_GRUPO_DIRECTIVA', 54);
defined('REGISTRAR_GRUPO_DIRECTIVA')   	OR define('REGISTRAR_GRUPO_DIRECTIVA', 55);
defined('MODIFICAR_GRUPO_DIRECTIVA')   	OR define('MODIFICAR_GRUPO_DIRECTIVA', 56);
defined('HABILITAR_GRUPO_DIRECTIVA')   	OR define('HABILITAR_GRUPO_DIRECTIVA', 57);
defined('DESHABILITAR_GRUPO_DIRECTIVA')	OR define('DESHABILITAR_GRUPO_DIRECTIVA', 58);
defined('ELIMINAR_GRUPO_DIRECTIVA')   	OR define('ELIMINAR_GRUPO_DIRECTIVA', 59);
// DIRECTIVA
defined('BUSCAR_DIRECTIVA')  			OR define('BUSCAR_DIRECTIVA', 60);
defined('LEER_DIRECTIVA')        		OR define('LEER_DIRECTIVA', 61);
defined('REGISTRAR_DIRECTIVA')   		OR define('REGISTRAR_DIRECTIVA', 62);
defined('MODIFICAR_DIRECTIVA')   		OR define('MODIFICAR_DIRECTIVA', 63);
defined('HABILITAR_DIRECTIVA')   		OR define('HABILITAR_DIRECTIVA', 64);
defined('DESHABILITAR_DIRECTIVA')		OR define('DESHABILITAR_DIRECTIVA', 65);
defined('ELIMINAR_DIRECTIVA')   		OR define('ELIMINAR_DIRECTIVA', 66);
defined('DESCARGAR_DIRECTIVA')   		OR define('DESCARGAR_DIRECTIVA', 67);
// GRUPO DE DECLARACIÓN JURADA
defined('BUSCAR_GRUPO_DECLARACION_JURADA')  	OR define('BUSCAR_GRUPO_DECLARACION_JURADA', 68);
defined('LEER_GRUPO_DECLARACION_JURADA')        OR define('LEER_GRUPO_DECLARACION_JURADA', 69);
defined('REGISTRAR_GRUPO_DECLARACION_JURADA')   OR define('REGISTRAR_GRUPO_DECLARACION_JURADA', 70);
defined('MODIFICAR_GRUPO_DECLARACION_JURADA')   OR define('MODIFICAR_GRUPO_DECLARACION_JURADA', 71);
defined('HABILITAR_GRUPO_DECLARACION_JURADA')   OR define('HABILITAR_GRUPO_DECLARACION_JURADA', 72);
defined('DESHABILITAR_GRUPO_DECLARACION_JURADA')OR define('DESHABILITAR_GRUPO_DECLARACION_JURADA', 73);
defined('ELIMINAR_GRUPO_DECLARACION_JURADA')   	OR define('ELIMINAR_GRUPO_DECLARACION_JURADA', 74);
// DECLARACIÓN JURADA
defined('BUSCAR_DECLARACION_JURADA')  			OR define('BUSCAR_DECLARACION_JURADA', 75);
defined('LEER_DECLARACION_JURADA')        		OR define('LEER_DECLARACION_JURADA', 76);
defined('REGISTRAR_DECLARACION_JURADA')   		OR define('REGISTRAR_DECLARACION_JURADA', 77);
defined('MODIFICAR_DECLARACION_JURADA')   		OR define('MODIFICAR_DECLARACION_JURADA', 78);
defined('HABILITAR_DECLARACION_JURADA')   		OR define('HABILITAR_DECLARACION_JURADA', 79);
defined('DESHABILITAR_DECLARACION_JURADA')		OR define('DESHABILITAR_DECLARACION_JURADA', 80);
defined('ELIMINAR_DECLARACION_JURADA')   		OR define('ELIMINAR_DECLARACION_JURADA', 81);
defined('DESCARGAR_DECLARACION_JURADA')   		OR define('DESCARGAR_DECLARACION_JURADA', 82);
// GALERÍA
defined('BUSCAR_ALBUM_IMAGEN')  			OR define('BUSCAR_ALBUM_IMAGEN', 83);
defined('LEER_ALBUM_IMAGEN')        		OR define('LEER_ALBUM_IMAGEN', 84);
defined('REGISTRAR_ALBUM_IMAGEN')   		OR define('REGISTRAR_ALBUM_IMAGEN', 85);
defined('MODIFICAR_ALBUM_IMAGEN')   		OR define('MODIFICAR_ALBUM_IMAGEN', 86);
defined('QUITAR_IMAGEN_ALBUM')   			OR define('QUITAR_IMAGEN_ALBUM', 87);
defined('HABILITAR_ALBUM_IMAGEN')   		OR define('HABILITAR_ALBUM_IMAGEN', 88);
defined('DESHABILITAR_ALBUM_IMAGEN')		OR define('DESHABILITAR_ALBUM_IMAGEN', 89);
defined('ELIMINAR_ALBUM_IMAGEN')   			OR define('ELIMINAR_ALBUM_IMAGEN', 90);
// EVENTOS
defined('BUSCAR_EVENTO')  				OR define('BUSCAR_EVENTO', 91);
defined('LEER_EVENTO')        			OR define('LEER_EVENTO', 92);
defined('REGISTRAR_EVENTO')   			OR define('REGISTRAR_EVENTO', 93);
defined('MODIFICAR_EVENTO')   			OR define('MODIFICAR_EVENTO', 94);
defined('HABILITAR_EVENTO')   			OR define('HABILITAR_EVENTO', 95);
defined('DESHABILITAR_EVENTO')			OR define('DESHABILITAR_EVENTO', 96);
defined('ELIMINAR_EVENTO')   			OR define('ELIMINAR_EVENTO', 97);
// GRUPO DE PAC
defined('BUSCAR_GRUPO_PAC')  		OR define('BUSCAR_GRUPO_PAC', 98);
defined('LEER_GRUPO_PAC')        	OR define('LEER_GRUPO_PAC', 99);
defined('REGISTRAR_GRUPO_PAC')   	OR define('REGISTRAR_GRUPO_PAC', 100);
defined('MODIFICAR_GRUPO_PAC')   	OR define('MODIFICAR_GRUPO_PAC', 101);
defined('HABILITAR_GRUPO_PAC')   	OR define('HABILITAR_GRUPO_PAC', 102);
defined('DESHABILITAR_GRUPO_PAC')	OR define('DESHABILITAR_GRUPO_PAC', 103);
defined('ELIMINAR_GRUPO_PAC')   	OR define('ELIMINAR_GRUPO_PAC', 104);
// PAC
defined('BUSCAR_PAC')  			OR define('BUSCAR_PAC', 105);
defined('LEER_PAC')        		OR define('LEER_PAC', 106);
defined('REGISTRAR_PAC')   		OR define('REGISTRAR_PAC', 107);
defined('MODIFICAR_PAC')   		OR define('MODIFICAR_PAC', 108);
defined('HABILITAR_PAC')   		OR define('HABILITAR_PAC', 109);
defined('DESHABILITAR_PAC')		OR define('DESHABILITAR_PAC', 110);
defined('ELIMINAR_PAC')   		OR define('ELIMINAR_PAC', 111);
defined('DESCARGAR_PAC')   		OR define('DESCARGAR_PAC', 112);
// TEMA AGRARIO
defined('BUSCAR_TEMA_AGRARIO')  				OR define('BUSCAR_TEMA_AGRARIO', 113);
defined('LEER_TEMA_AGRARIO')        			OR define('LEER_TEMA_AGRARIO', 114);
defined('REGISTRAR_TEMA_AGRARIO')   			OR define('REGISTRAR_TEMA_AGRARIO', 115);
defined('MODIFICAR_TEMA_AGRARIO')   			OR define('MODIFICAR_TEMA_AGRARIO', 116);
defined('HABILITAR_TEMA_AGRARIO')   			OR define('HABILITAR_TEMA_AGRARIO', 117);
defined('DESHABILITAR_TEMA_AGRARIO')			OR define('DESHABILITAR_TEMA_AGRARIO', 118);
defined('ELIMINAR_TEMA_AGRARIO')   				OR define('ELIMINAR_TEMA_AGRARIO', 119);
// VISITA
defined('BUSCAR_VISITA')  				OR define('BUSCAR_VISITA', 120);
defined('LEER_VISITA')        			OR define('LEER_VISITA', 121);
defined('REGISTRAR_VISITA')   			OR define('REGISTRAR_VISITA', 122);
defined('MODIFICAR_VISITA')   			OR define('MODIFICAR_VISITA', 123);
defined('HABILITAR_VISITA')   			OR define('HABILITAR_VISITA', 124);
defined('DESHABILITAR_VISITA')			OR define('DESHABILITAR_VISITA', 125);
defined('ELIMINAR_VISITA')   			OR define('ELIMINAR_VISITA', 126);
// EMPLEADO
defined('BUSCAR_EMPLEADO')  				OR define('BUSCAR_EMPLEADO', 127);
defined('LEER_EMPLEADO')        			OR define('LEER_EMPLEADO', 128);
defined('REGISTRAR_EMPLEADO')   			OR define('REGISTRAR_EMPLEADO', 129);
defined('MODIFICAR_EMPLEADO')   			OR define('MODIFICAR_EMPLEADO', 130);
defined('HABILITAR_EMPLEADO')   			OR define('HABILITAR_EMPLEADO', 131);
defined('DESHABILITAR_EMPLEADO')			OR define('DESHABILITAR_EMPLEADO', 132);
defined('ELIMINAR_EMPLEADO')   			OR define('ELIMINAR_EMPLEADO', 133);
// ASISTENCIA
defined('BUSCAR_ASISTENCIA')  				OR define('BUSCAR_ASISTENCIA', 134);
defined('LEER_ASISTENCIA')        			OR define('LEER_ASISTENCIA', 135);
defined('REGISTRAR_ASISTENCIA')   			OR define('REGISTRAR_ASISTENCIA', 136);
defined('MODIFICAR_ASISTENCIA')   			OR define('MODIFICAR_ASISTENCIA', 137);
defined('HABILITAR_ASISTENCIA')   			OR define('HABILITAR_ASISTENCIA', 138);
defined('DESHABILITAR_ASISTENCIA')			OR define('DESHABILITAR_ASISTENCIA', 139);
defined('ELIMINAR_ASISTENCIA')   			OR define('ELIMINAR_ASISTENCIA', 140);