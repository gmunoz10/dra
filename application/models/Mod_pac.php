<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_pac extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function get_pac_row($where) {
        $this->db->where($where);
        $pac = $this->db->get("pac")->first_row();
        if (!empty($pac)) {
            return $pac;
        } else {
            return false;
        }
    }

    function count_all($string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_pac >", "-1");
        $this->db->where("esta_gpa", "1");
        $this->db->where("(`codi_pac` LIKE '%$search%' OR 
                            `codi_gpa` LIKE '%$search%' OR
                            `nomb_gpa` LIKE '%$search%' OR
                            `fech_pac` LIKE '%$search%' OR
                            `desc_pac` LIKE '%$search%'
                            )");
        return $this->db->count_all_results('v_pac');
    }

    function get_paginate($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_pac >", "-1");
        $this->db->where("esta_gpa", "1");
        $this->db->where("(`codi_pac` LIKE '%$search%' OR 
                            `codi_gpa` LIKE '%$search%' OR
                            `nomb_gpa` LIKE '%$search%' OR
                            `fech_pac` LIKE '%$search%' OR
                            `desc_pac` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $query = $this->db->get('v_pac');
        return $query->result();
    }

    function save($data) {
        $this->db->insert('pac', $data); 
        return $this->db->insert_id();
    }

    function update($codi_pac, $data) {
        $this->db->where('codi_pac', $codi_pac);
        $this->db->update('pac', $data);
    }

    function get_grupos_pac() {
        $this->db->where("esta_gpa", "1");
        $this->db->order_by("nomb_gpa", "asc");
        $query = $this->db->get('grupo_pac');
        return $query->result();
    }

    function get_grupo_pac_row($where) {
        $this->db->where($where);
        $grupo_pac = $this->db->get("grupo_pac")->first_row();
        if (!empty($grupo_pac)) {
            return $grupo_pac;
        } else {
            return false;
        }
    }

    function count_all_grupo() {
        $this->db->where("esta_gpa >", "-1");
        return $this->db->count_all_results('grupo_pac');
    }

    function get_paginate_grupo($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_gpa >", "-1");
        $this->db->where("(`codi_gpa` LIKE '%$search%' OR 
                            `nomb_gpa` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $query = $this->db->get('grupo_pac');
        return $query->result();
    }

    function check_nomb_gpa($nomb_gpa) {
        $this->db->where("esta_gpa >", "-1");
        $this->db->where('nomb_gpa', $nomb_gpa);
        $row = $this->db->get("grupo_pac")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function check_nomb_gpa_actualizar($codi_gpa, $nomb_gpa) {
        $this->db->where("esta_gpa >", "-1");
        $this->db->where('codi_gpa !=', $codi_gpa);
        $this->db->where('nomb_gpa', $nomb_gpa);
        $row = $this->db->get("grupo_pac")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function save_grupo($data) {
        $this->db->insert('grupo_pac', $data); 
        return $this->db->insert_id();
    }

    function update_grupo($codi_gpa, $data) {
        $this->db->where('codi_gpa', $codi_gpa);
        $this->db->update('grupo_pac', $data);
    }

    function get_years() {
        $this->db->where("esta_pac", "1");
        $this->db->where("esta_gpa", "1");
        $this->db->select('EXTRACT(YEAR FROM `fech_pac`) AS `year_pac`');
        $this->db->group_by('`year_pac`'); 
        $this->db->order_by("`year_pac`", "desc");
        $query = $this->db->get('v_pac');
        return $query->result();
    }

    function count_all_portal($string = "", $codi_gpa, $year_pac) {
        $search = $this->db->escape_like_str($string);
        $this->db->where("codi_gpa", $codi_gpa);
        $this->db->where("EXTRACT(YEAR FROM `fech_pac`) = " . $year_pac);
        $this->db->where("esta_pac", "1");
        $this->db->where("esta_gpa", "1");
        $this->db->where("(`fech_pac` LIKE '%$search%' OR
                            `desc_pac` LIKE '%$search%'
                            )");
        return $this->db->count_all_results('v_pac');
    }

    function get_paginate_portal($limit, $start, $string = "", $codi_gpa, $year_pac, $data) {
        $search = $this->db->escape_like_str($string);
        $this->db->where("codi_gpa", $codi_gpa);
        $this->db->where("EXTRACT(YEAR FROM `fech_pac`) = " . $year_pac);
        $this->db->where("esta_pac", "1");
        $this->db->where("esta_gpa", "1");
        $this->db->where("(`fech_pac` LIKE '%$search%' OR
                            `desc_pac` LIKE '%$search%'
                            )");

        if (isset($data["iSortingCols"])) {
            for ($i=0; $i < (int) $data["iSortingCols"]; $i++) {
                switch ((int) $data["iSortCol_".$i]) {
                    case 0:
                        $this->db->order_by("desc_pac", $data["sSortDir_".$i]);
                        break;
                    case 1:
                        $this->db->order_by("fech_pac", $data["sSortDir_".$i]);
                        break;
                    case 2:
                        $this->db->order_by("docu_pac", $data["sSortDir_".$i]);
                        break;
                }
            }
        } else {
            $this->db->order_by("CAST(`codi_pac` AS INT)", "asc");
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get('v_pac');
        return $query->result();
    }

}
