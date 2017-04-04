<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_rol extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function get_rol_row($where) {
        $this->db->where($where);
        $rol = $this->db->get("rol")->first_row();
        if (!empty($rol)) {
            return $rol;
        } else {
            return false;
        }
    }

    function count_all() {
        $this->db->where("esta_rol >", "-1");
        return $this->db->count_all_results('rol');
    }

    function get_paginate($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_rol >", "-1");
        $this->db->where("(`codi_rol` LIKE '%$search%' OR 
                            `desc_rol` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $query = $this->db->get('rol');
        return $query->result();
    }

    function check_desc_rol($desc_rol) {
        $this->db->where("esta_rol >", "-1");
        $this->db->where('desc_rol', $desc_rol);
        $row = $this->db->get("rol")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function check_desc_rol_actualizar($codi_rol, $desc_rol) {
        $this->db->where("esta_rol >", "-1");
        $this->db->where('codi_rol !=', $codi_rol);
        $this->db->where('desc_rol', $desc_rol);
        $row = $this->db->get("rol")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function save($data) {
        $this->db->insert('rol', $data); 
        return $this->db->insert_id();
    }

    function update($codi_rol, $data) {
        $this->db->where('codi_rol', $codi_rol);
        $this->db->update('rol', $data);
    }

}
