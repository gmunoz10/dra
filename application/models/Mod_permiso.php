<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_permiso extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function get_permiso_usuario_row($where) {
        $this->db->where($where);
        $permiso_usuario = $this->db->get("v_permiso_usuario")->first_row();
        if (!empty($permiso_usuario)) {
            return $permiso_usuario;
        } else {
            return false;
        }
    }

    function get_permiso_rol_row($where) {
        $this->db->where($where);
        $permiso_rol = $this->db->get("v_permiso_rol")->first_row();
        if (!empty($permiso_rol)) {
            return $permiso_rol;
        } else {
            return false;
        }
    }

    function get_grupos_permiso($where) {
        $this->db->where($where);
        $query = $this->db->get('grupo_permiso');
        return $query->result();
    }

    function get_permisos($where) {
        $this->db->where($where);
        $query = $this->db->get('permiso');
        return $query->result();
    }

    

    function save_permiso_rol($data) {
        $this->db->insert('permiso_rol', $data); 
        return $this->db->insert_id();
    }

    function update_permiso_rol($codi_pro, $data) {
        $this->db->where('codi_pro', $codi_pro);
        $this->db->update('permiso_rol', $data);
    }

    function save_permiso_usuario($data) {
        $this->db->insert('permiso_usuario', $data); 
        return $this->db->insert_id();
    }

    function update_permiso_usuario($codi_pus, $data) {
        $this->db->where('codi_pus', $codi_pus);
        $this->db->update('permiso_usuario', $data);
    }

    function clear_permisos_usuario($where) {
        $this->db->where($where);
        $this->db->delete('permiso_usuario');
    }
}
