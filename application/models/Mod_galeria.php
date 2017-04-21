<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_galeria extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function count_album($search) {
        $this->db->where("esta_alb", "1");
        $this->db->where('titu_alb LIKE "%'.$search.'%"');
        return $this->db->count_all_results('album');
    }

    function get_list_album($search, $start, $limit) {
        $this->db->where("esta_alb >", "-1");
        $this->db->where('titu_alb LIKE "%'.$search.'%"');
        $this->db->limit($limit, $start);
        $this->db->order_by("fech_alb", "desc");
        $query = $this->db->get('v_album');
        return $query->result();
    }

    function get_imagenes_album($codi_alb) {
        $this->db->where("codi_alb", $codi_alb);
        $this->db->where("esta_ial", "1");
        $this->db->order_by("codi_ial", "asc");
        $query = $this->db->get('v_imagen_album');
        return $query->result();
    }

    function save_album($data) {
        $this->db->insert('album', $data); 
        return $this->db->insert_id();
    }

    function update_album($codi_alb, $data) {
        $this->db->where('codi_alb', $codi_alb);
        $this->db->update('album', $data);
    }

    function save($data) {
        $this->db->insert('imagen_album', $data); 
        return $this->db->insert_id();
    }

    function update($codi_ial, $data) {
        $this->db->where('codi_ial', $codi_ial);
        $this->db->update('imagen_album', $data);
    }


}
