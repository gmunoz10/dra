<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_evento extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function get_evento_row($where) {
        $this->db->where($where);
        $evento = $this->db->get("v_evento")->first_row();
        if (!empty($evento)) {
            return $evento;
        } else {
            return false;
        }
    }

    function count_all() {
        $this->db->where("esta_eve >", "-1");
        return $this->db->count_all_results('evento');
    }

    function get_paginate($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_eve >", "-1");
        $this->db->where("(`codi_eve` LIKE '%$search%' OR 
                            `titu_eve` LIKE '%$search%' OR
                            `cont_eve` LIKE '%$search%' OR
                            `fech_eve` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $this->db->order_by("fech_eve", "desc");
        $query = $this->db->get('v_evento');
        return $query->result();
    }

    function count_eventos() {
        $this->db->where("esta_eve", "1");
        return $this->db->count_all_results('evento');
    }

    function get_list_eventos($start, $limit) {
        $this->db->where("esta_eve", "1");
        $this->db->limit($limit, $start);
        $this->db->order_by("fech_eve", "desc");
        $query = $this->db->get('v_evento');
        return $query->result();
    }

    function get_eventos() {
        $this->db->where("esta_eve", "1");
        $this->db->limit(5, 0);
        $this->db->order_by("fech_eve", "desc");
        $query = $this->db->get('v_evento');
        return $query->result();
    }

    function check_nume_eve($nume_eve) {
        $this->db->where("esta_eve >", "-1");
        $this->db->where('nume_eve', $nume_eve);
        $row = $this->db->get("evento")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function check_nume_eve_actualizar($codi_eve, $nume_eve) {
        $this->db->where("esta_eve >", "-1");
        $this->db->where('codi_eve !=', $codi_eve);
        $this->db->where('nume_eve', $nume_eve);
        $row = $this->db->get("evento")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function save($data) {
        $this->db->insert('evento', $data); 
        return $this->db->insert_id();
    }

    function update($codi_eve, $data) {
        $this->db->where('codi_eve', $codi_eve);
        $this->db->update('evento', $data);
    }


}
