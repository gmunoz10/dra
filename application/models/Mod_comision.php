<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_comision extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function get_comision_row($where) {
        $this->db->where($where);
        $comision = $this->db->get("comision")->first_row();
        if (!empty($comision)) {
            return $comision;
        } else {
            return false;
        }
    }

    function get_detalle_comision($where) {
        $this->db->where("esta_com", "1");
        $this->db->where($where);
        $this->db->order_by("num_dco", "asc");
        $query = $this->db->get('v_detalle_comision');
        return $query->result();
    }

    function count_all() {
        $this->db->where("esta_com >", "-1");
        return $this->db->count_all_results('v_comision');
    }

    function get_paginate($limit, $start, $string = "", $fech_com) {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_com >", "-1");
        $this->db->where("fech_com", $fech_com);
        $this->db->where("(`codi_com` LIKE '%$search%' OR 
                            `nomb_emp` LIKE '%$search%' OR
                            `apel_emp` LIKE '%$search%' OR
                            `docu_emp` LIKE '%$search%' OR
                            `ofic_emp` LIKE '%$search%' OR
                            `tipo_com` LIKE '%$search%'
                            )");
        $this->db->order_by("codi_com", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('v_comision');
        return $query->result();
    }

    function save($data) {
        $this->db->insert('comision', $data); 
        return $this->db->insert_id();
    }

    function update($codi_com, $data) {
        $this->db->where('codi_com', $codi_com);
        $this->db->update('comision', $data);
    }

    function save_detalle($data) {
        $this->db->insert('detalle_comision', $data); 
        return $this->db->insert_id();
    }

    function update_detalle($codi_dco, $data) {
        $this->db->where('codi_dco', $codi_dco);
        $this->db->update('detalle_comision', $data);
    }

    function adjust_detalle($codi_com, $retornos) {
        $this->db->where('codi_com', $codi_com);
        $this->db->where('num_dco >=', $retornos);
        $this->db->delete('detalle_comision');
    }

    function get_detalle($codi_com) {
        $this->db->where("codi_com", $codi_com);
        $this->db->order_by("num_dco", "asc");
        $query = $this->db->get('detalle_comision');
        return $query->result();
    }

    function get_detalle_ByNum($codi_com, $num_dco) {
        $this->db->where("codi_com", $codi_com);
        $this->db->where("num_dco", $num_dco);
        $query = $this->db->get('detalle_comision');
        return $query->first_row();
    }

}
