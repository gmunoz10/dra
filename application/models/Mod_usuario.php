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

    function get_usuario_row($where) {
        $this->db->where($where);
        $usuario = $this->db->get("v_usuario")->first_row();
        if (!empty($usuario)) {
            return $usuario;
        } else {
            return false;
        }
    }

    function check_login($username, $password) {
		$this->db->where("nomb_usu", $username);
        $this->db->where("cont_usu", $password);
		$this->db->where("esta_usu >", "-1");
        $usuario = $this->db->get("v_usuario")->first_row();
        if (!empty($usuario)) {
        	return $usuario;
        } else {
        	return false;
        }
    }

    function count_all() {
        $this->db->where("esta_usu >", "-1");
        return $this->db->count_all_results('v_usuario');
    }

    function get_paginate($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_usu >", "-1");
        $this->db->where("(`codi_usu` LIKE '%$search%' OR 
                            `nomb_usu` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $query = $this->db->get('v_usuario');
        return $query->result();
    }

    function get_roles() {
        $this->db->where("esta_rol", "1");
        $this->db->order_by("desc_rol", "asc");
        $query = $this->db->get('rol');
        return $query->result();
    }

    function check_nomb_usu($nomb_usu) {
        $this->db->where("esta_usu >", "-1");
        $this->db->where('nomb_usu', $nomb_usu);
        $row = $this->db->get("usuario")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function check_nomb_usu_actualizar($codi_usu, $nomb_usu) {
        $this->db->where("esta_usu >", "-1");
        $this->db->where('codi_usu !=', $codi_usu);
        $this->db->where('nomb_usu', $nomb_usu);
        $row = $this->db->get("usuario")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function check_cont_usu($codi_usu, $cont_usu) {
        $this->db->where("esta_usu >", "-1");
        $this->db->where('codi_usu', $codi_usu);
        $this->db->where('cont_usu', $cont_usu);
        $row = $this->db->get("usuario")->first_row();
        if (empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function save($data) {
        $this->db->insert('usuario', $data); 
        return $this->db->insert_id();
    }

    function update($codi_usu, $data) {
        $this->db->where('codi_usu', $codi_usu);
        $this->db->update('usuario', $data);
    }

}
