<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_usuario extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function check_login($username, $password) {
		$this->db->where("nomb_usu", $username);
		$this->db->where("cont_usu", $password);
		$this->db->where("esta_usu", 1);
        $usuario = $this->db->get("usuario")->first_row();
        if (!empty($usuario)) {
        	return $usuario;
        } else {
        	return false;
        }
    }

    function get_permiso_usuario_row($where) {
        $this->db->where($where);
        $permiso_usuario = $this->db->get("v_permiso_usuario")->first_row();
        if (!empty($permiso_usuario)) {
            return $permiso_usuario;
        } else {
            return false;
        }
    }

    function get_permiso_rol_row($where) {
        $this->db->where($where);
        $permiso_rol = $this->db->get("v_permiso_rol")->first_row();
        if (!empty($permiso_rol)) {
            return $permiso_rol;
        } else {
            return false;
        }
    }

    public function count_all() {
        return $this->db->count_all_results('usuario');
    }

    public function get_paginate($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("(`codi_usu` LIKE '%$search%' OR 
                            `nomb_usu` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $query = $this->db->get('usuario');
        return $query->result();
    }

}
