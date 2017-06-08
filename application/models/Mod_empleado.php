<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_empleado extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function get_empleado_row($where) {
        $this->db->where($where);
        $empleado = $this->db->get("empleado")->first_row();
        if (!empty($empleado)) {
            return $empleado;
        } else {
            return false;
        }
    }

    function get_empleado() {
        $this->db->where("esta_emp", "1");
        $query = $this->db->get('empleado');
        return $query->result();
    }

    function get_terceros() {
        $this->db->where("esta_emp", "1");
        $this->db->where("tipo_emp", "TERCERO");
        $this->db->order_by("apel_emp", "asc");
        $query = $this->db->get('empleado');
        return $query->result();
    }

    function count_all() {
        $this->db->where("esta_emp >", "-1");
        return $this->db->count_all_results('empleado');
    }

    function get_paginate($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_emp >", "-1");
        $this->db->where("(`codi_emp` LIKE '%$search%' OR 
                            `nomb_emp` LIKE '%$search%' OR
                            `apel_emp` LIKE '%$search%' OR
                            `carg_emp` LIKE '%$search%' OR
                            `docu_emp` LIKE '%$search%' OR
                            `ofic_emp` LIKE '%$search%' OR
                            `tipo_emp` LIKE '%$search%'
                            )");
        $this->db->order_by("apel_emp", "asc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('empleado');
        return $query->result();
    }

    function save($data) {
        $this->db->insert('empleado', $data); 
        return $this->db->insert_id();
    }

    function update($codi_emp, $data) {
        $this->db->where('codi_emp', $codi_emp);
        $this->db->update('empleado', $data);
    }

}
