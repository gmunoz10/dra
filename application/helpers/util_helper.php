<?php

defined('BASEPATH') OR exit('No direct script access allowed');


if (!function_exists('asset_url')) {

    function asset_url() {
        return base_url().'assets/';
    }

}

if (!function_exists('limit_to')) {

    function limit_to($text, $number) {
        return substr($text, 0, $number);
    }

}

if (!function_exists('randomColorGenerator')) {

    function randomColorGenerator() {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

}

if (!function_exists('number_up')) {

    function number_up($valor, $caracteres) {
        for ($i = 0; $i < ($caracteres - strlen($valor)); $i++) {
            $valor = "0" . $valor;
        }
        return $valor;
    }

}

if (!function_exists('days_month')) {

    function days_month($date) {
        return (int) date("t", strtotime($date));
    }

}

if (!function_exists('check_permission')) {

    function check_permission($codi_per) {
        $CI = & get_instance();
        
        if (!$CI->session->userdata("usuario")) {
            return false;
        }
        
        if ($CI->session->userdata("usuario")->codi_rol == "1") {
            return true;
        }
        
        $CI->load->model("mod_permiso");

        $permiso_usuario = $CI->mod_permiso->get_permiso_usuario_row(array(
            "codi_usu" => $CI->session->userdata("usuario")->codi_usu, 
            "codi_per" => $codi_per,
            "esta_per" => "1"));
        if ($permiso_usuario) {
            if ($permiso_usuario->valo_pus == "1") {
                return true;
            } else if ($permiso_usuario->valo_pus == "0") {
                return false;
            }
        } else {
            $permiso_rol = $CI->mod_permiso->get_permiso_rol_row(array(
                "codi_rol" => $CI->session->userdata("usuario")->codi_rol, 
                "codi_per" => $codi_per,
                "esta_per" => "1"));

            if ($permiso_rol) {
                if ($permiso_rol->valo_pro == "1") {
                    return true;
                } else if ($permiso_rol->valo_pro == "0") {
                    return false;
                }
            } else {
                return false;
            }
        }

        return true;
    }

}

if (!function_exists('set_message_system')) {

    function set_message_system($type, $message) {
        $CI = & get_instance();
        $CI->session->set_userdata('ci_message_system', array('type' => $type, "message" => $message));
    }

}


