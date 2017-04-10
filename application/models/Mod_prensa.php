<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_prensa extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function get_noticia_row($where) {
        $this->db->where($where);
        $noticia = $this->db->get("noticia")->first_row();
        if (!empty($noticia)) {
            return $noticia;
        } else {
            return false;
        }
    }

    function count_all() {
        $this->db->where("esta_not >", "-1");
        return $this->db->count_all_results('noticia');
    }

    function get_paginate($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_not >", "-1");
        $this->db->where("(`codi_not` LIKE '%$search%' OR 
                            `titu_not` LIKE '%$search%' OR
                            `cont_not` LIKE '%$search%' OR
                            `fech_not` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $this->db->order_by("fech_not", "desc");
        $query = $this->db->get('v_noticia');
        return $query->result();
    }

    function get_noticias() {
        $this->db->where("esta_not", "1");
        $this->db->limit(5, 0);
        $this->db->order_by("fech_not", "desc");
        $query = $this->db->get('v_noticia');
        return $query->result();
    }

    function check_nume_not($nume_not) {
        $this->db->where("esta_not >", "-1");
        $this->db->where('nume_not', $nume_not);
        $row = $this->db->get("noticia")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function check_nume_not_actualizar($codi_not, $nume_not) {
        $this->db->where("esta_not >", "-1");
        $this->db->where('codi_not !=', $codi_not);
        $this->db->where('nume_not', $nume_not);
        $row = $this->db->get("noticia")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function save($data) {
        $this->db->insert('noticia', $data); 
        return $this->db->insert_id();
    }

    function update($codi_not, $data) {
        $this->db->where('codi_not', $codi_not);
        $this->db->update('noticia', $data);
    }


}
