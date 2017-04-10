<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_agenda extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function get_agenda_row($where) {
        $this->db->where($where);
        $agenda = $this->db->get("agenda")->first_row();
        if (!empty($agenda)) {
            return $agenda;
        } else {
            return false;
        }
    }

    function count_all() {
        $this->db->where("esta_age >", "-1");
        $this->db->where("esta_dpe", "1");
        return $this->db->count_all_results('v_agenda');
    }

    function get_paginate($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_age >", "-1");
        $this->db->where("esta_dpe", "1");
        $this->db->where("(`codi_age` LIKE '%$search%' OR 
                            `nomb_dpe` LIKE '%$search%' OR
                            `fech_age` LIKE '%$search%' OR
                            `desc_age` LIKE '%$search%' OR
                            `luga_age` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $query = $this->db->get('v_agenda');
        return $query->result();
    }

    function paginate_public($codi_dpe, $mes, $year) {
        $this->db->where("esta_age", "1");
        $this->db->where("codi_dpe", $codi_dpe);
        $this->db->where("EXTRACT(MONTH FROM `fech_age`) = ". $mes);
        $this->db->where("EXTRACT(YEAR FROM `fech_age`) = ". $year);
        $this->db->order_by('`fech_age`', 'ASC');
        $query = $this->db->get('v_agenda');
        return $query->result();
    }

    function get_years_agenda() {
        $this->db->select('EXTRACT(YEAR FROM `fech_age`) AS `year`');
        $this->db->group_by("`year`");
        $this->db->order_by('`year`', 'DESC');
        $this->db->where("esta_age", "1");
        $query = $this->db->get('v_agenda');
        return $query->result();
    }

    function save($data) {
        $this->db->insert('agenda', $data); 
        return $this->db->insert_id();
    }

    function update($codi_age, $data) {
        $this->db->where('codi_age', $codi_age);
        $this->db->update('agenda', $data);
    }

    function get_dependencias() {
        $this->db->where("esta_dpe", "1");
        $this->db->order_by("nomb_dpe", "asc");
        $query = $this->db->get('dependencia');
        return $query->result();
    }

    function get_dependencia_row($where) {
        $this->db->where($where);
        $dependencia = $this->db->get("dependencia")->first_row();
        if (!empty($dependencia)) {
            return $dependencia;
        } else {
            return false;
        }
    }

    function count_all_dependencia() {
        $this->db->where("esta_dpe >", "-1");
        return $this->db->count_all_results('dependencia');
    }

    function get_paginate_dependencia($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_dpe >", "-1");
        $this->db->where("(`codi_dpe` LIKE '%$search%' OR 
                            `nomb_dpe` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $query = $this->db->get('dependencia');
        return $query->result();
    }

    function check_nomb_dpe($nomb_dpe) {
        $this->db->where("esta_dpe >", "-1");
        $this->db->where('nomb_dpe', $nomb_dpe);
        $row = $this->db->get("dependencia")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function check_nomb_dpe_actualizar($codi_dpe, $nomb_dpe) {
        $this->db->where("esta_dpe >", "-1");
        $this->db->where('codi_dpe !=', $codi_dpe);
        $this->db->where('nomb_dpe', $nomb_dpe);
        $row = $this->db->get("dependencia")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function save_dependencia($data) {
        $this->db->insert('dependencia', $data); 
        return $this->db->insert_id();
    }

    function update_dependencia($codi_dpe, $data) {
        $this->db->where('codi_dpe', $codi_dpe);
        $this->db->update('dependencia', $data);
    }


}
