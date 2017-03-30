<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (isset($_SERVER['HTTP_HOST'])) {
    $config['base_url'] = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https' : 'http';
    $config['base_url'] .= '://' . $_SERVER['HTTP_HOST'];
    $config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
} else {
    $config['base_url'] = 'http://localhost/dra5';
}

$config['index_page'] = 'index.php';
$config['uri_protocol'] = 'REQUEST_URI';
$config['url_suffix'] = '';
$config['language'] = 'english';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = TRUE;
$config['subclass_prefix'] = 'MY_';
$config['composer_autoload'] = FALSE;
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

$config['log_threshold'] = 4;
$config['log_path'] = FCPATH . 'application/logs/';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';

$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;
$config['encryption_key'] = 'e0n1c2r3y4p5t6i7o8n9e0n1c2r3y427';

$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 14400;
$config['sess_save_path'] = BASEPATH . 'dra5/cache';
//$config['sess_save_path'] = BASEPATH . 'proveedor.holacamarero/cache';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

$config['cookie_prefix'] = '';
$config['cookie_domain'] = '';
$config['cookie_path'] = '/';
$config['cookie_secure'] = FALSE;
$config['cookie_httponly'] = FALSE;

$config['standardize_newlines'] = FALSE;

//$config['global_xss_filtering'] = FALSE;

$config['csrf_protection'] = FALSE;

// if (isset($_SERVER["REQUEST_URI"])) {
//    if(stripos($_SERVER["REQUEST_URI"],'/server') === FALSE) {
//        $config['csrf_protection'] = TRUE;
//    }
//    else {
//        $config['csrf_protection'] = FALSE;
//    } 
//} else {
//    $config['csrf_protection'] = TRUE;
//} 

$config['csrf_token_name'] = 'csrf_dra_token';
$config['csrf_cookie_name'] = 'csrf_dra';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = FALSE;
$config['csrf_exclude_uris'] = array();

$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';

$config['composer_autoload'] = realpath(APPPATH . '../vendor/autoload.php');

spl_autoload_register(function ($class) {
    if (substr($class, 0, 3) !== 'CI_') {
        if (file_exists($file = APPPATH . 'core/' . $class . EXT)) {
            include $file;
        }
    }
});

/*
  | -------------------------------------------------------------------------
  | Application Settings
  | -------------------------------------------------------------------------
 */

$config['codeigniter_version'] = '3.0.4';
$config['php_version'] = '5.4';
$config['php_old'] = '5.2.4 ';
$config['bootstrap_version'] = '3.3.6';

$config['app_via'] = 1;
$config['app_name'] = 'DRAL';
$config['app_site'] = 'http://www.dral.gob.pe';
$config['time_zone'] = 'America/Lima';

$config['database_id'] = 1;
$config['free_version'] = TRUE;
$config['lincence_run'] = '';
$config['licence_expire'] = '';

$config['language_abbr'] = "es"; // en_US
$config['lang_uri_abbr'] = array(
    'bg' => 'bulgarian', // bg_BG
    'en' => 'english', // en_US
    'fr' => 'french', // fr_FA
    'de' => 'german', // de_DE
    'hu' => 'hungarian', // hu_HU
    'it' => 'italian', // it_IT
    'pl' => 'polish', // pl_PL
    'pt' => 'portuguese', // pt_PT
    'ro' => 'romanian', // ro_RO
    'ru' => 'russian', // ru_RU
    'sl' => 'slovenian', // sl_SI
    'es' => 'spanish', // es_LA
    'sv' => 'swedish', // sv_SE
    'zh' => 'chinese', // zh_HK
    'tr' => 'turkish'); // tr_TR