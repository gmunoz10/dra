<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_asistencia extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function get_asistencia_row($where) {
        $this->db->where($where);
        $asistencia = $this->db->get("asistencia")->first_row();
        if (!empty($asistencia)) {
            return $asistencia;
        } else {
            return false;
        }
    }

    function count_all() {
        $this->db->where("esta_asi >", "-1");
        return $this->db->count_all_results('v_asistencia');
    }

    function get_paginate($limit, $start, $string = "", $fech_asi) {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_asi >", "-1");
        $this->db->where("fech_asi", $fech_asi);
        $this->db->where("(`codi_asi` LIKE '%$search%' OR 
                            `nomb_emp` LIKE '%$search%' OR
                            `apel_emp` LIKE '%$search%' OR
                            `docu_emp` LIKE '%$search%' OR
                            `obsv_emp` LIKE '%$search%' OR
                            `ofic_emp` LIKE '%$search%' OR
                            `ingr_asi` LIKE '%$search%' OR
                            `sali_asi` LIKE '%$search%' OR
                            `inre_asi` LIKE '%$search%' OR
                            `sare_asi` LIKE '%$search%'
                            )");
        $this->db->order_by("codi_asi", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('v_asistencia');
        return $query->result();
    }

    function save($data) {
        $this->db->insert('asistencia', $data); 
        return $this->db->insert_id();
    }

    function update($codi_asi, $data) {
        $this->db->where('codi_asi', $codi_asi);
        $this->db->update('asistencia', $data);
    }

}
