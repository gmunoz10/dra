<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_tema_agrario extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function get_tema_agrario_row($where) {
        $this->db->where($where);
        $tema_agrario = $this->db->get("v_tema_agrario")->first_row();
        if (!empty($tema_agrario)) {
            return $tema_agrario;
        } else {
            return false;
        }
    }

    function count_all() {
        $this->db->where("esta_tea >", "-1");
        return $this->db->count_all_results('tema_agrario');
    }

    function get_paginate($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_tea >", "-1");
        $this->db->where("(`codi_tea` LIKE '%$search%' OR 
                            `titu_tea` LIKE '%$search%' OR
                            `cont_tea` LIKE '%$search%' OR
                            `fech_tea` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $this->db->order_by("fech_tea", "desc");
        $query = $this->db->get('v_tema_agrario');
        return $query->result();
    }

    function count_tema_agrarios() {
        $this->db->where("esta_tea", "1");
        return $this->db->count_all_results('tema_agrario');
    }

    function get_list_tema_agrarios($start, $limit) {
        $this->db->where("esta_tea", "1");
        $this->db->limit($limit, $start);
        $this->db->order_by("fech_tea", "desc");
        $query = $this->db->get('v_tema_agrario');
        return $query->result();
    }

    function get_tema_agrarios() {
        $this->db->where("esta_tea", "1");
        $this->db->limit(5, 0);
        $this->db->order_by("fech_tea", "desc");
        $query = $this->db->get('v_tema_agrario');
        return $query->result();
    }

    function check_nume_tea($nume_tea) {
        $this->db->where("esta_tea >", "-1");
        $this->db->where('nume_tea', $nume_tea);
        $row = $this->db->get("tema_agrario")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function check_nume_tea_actualizar($codi_tea, $nume_tea) {
        $this->db->where("esta_tea >", "-1");
        $this->db->where('codi_tea !=', $codi_tea);
        $this->db->where('nume_tea', $nume_tea);
        $row = $this->db->get("tema_agrario")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function save($data) {
        $this->db->insert('tema_agrario', $data); 
        return $this->db->insert_id();
    }

    function update($codi_tea, $data) {
        $this->db->where('codi_tea', $codi_tea);
        $this->db->update('tema_agrario', $data);
    }


}
