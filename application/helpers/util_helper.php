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

