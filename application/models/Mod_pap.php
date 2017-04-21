<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_pap extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function get_pap_row($where) {
        $this->db->where($where);
        $pap = $this->db->get("pap")->first_row();
        if (!empty($pap)) {
            return $pap;
        } else {
            return false;
        }
    }

    function count_all() {
        $this->db->where("esta_pap >", "-1");
        $this->db->where("esta_gpa", "1");
        return $this->db->count_all_results('v_pap');
    }

    function get_paginate($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_pap >", "-1");
        $this->db->where("esta_gpa", "1");
        $this->db->where("(`codi_pap` LIKE '%$search%' OR 
                            `codi_gpa` LIKE '%$search%' OR
                            `nomb_gpa` LIKE '%$search%' OR
                            `nume_pap` LIKE '%$search%' OR
                            `fech_pap` LIKE '%$search%' OR
                            `desc_pap` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $query = $this->db->get('v_pap');
        return $query->result();
    }

    function check_nume_pap($nume_pap, $year_pap) {
        $this->db->where("esta_pap >", "-1");
        $this->db->where('nume_pap', $nume_pap);
        $this->db->where("EXTRACT(YEAR FROM `fech_pap`) = '" . $year_pap."'");
        $row = $this->db->get("pap")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function check_nume_pap_actualizar($codi_pap, $nume_pap, $year_pap) {
        $this->db->where("esta_pap >", "-1");
        $this->db->where('codi_pap !=', $codi_pap);
        $this->db->where('nume_pap', $nume_pap);
        $this->db->where("EXTRACT(YEAR FROM `fech_pap`) = '" . $year_pap."'");
        $row = $this->db->get("pap")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function save($data) {
        $this->db->insert('pap', $data); 
        return $this->db->insert_id();
    }

    function update($codi_pap, $data) {
        $this->db->where('codi_pap', $codi_pap);
        $this->db->update('pap', $data);
    }

    function get_grupos_pap() {
        $this->db->where("esta_gpa", "1");
        $this->db->order_by("nomb_gpa", "asc");
        $query = $this->db->get('grupo_pap');
        return $query->result();
    }

    function get_grupo_pap_row($where) {
        $this->db->where($where);
        $grupo_pap = $this->db->get("grupo_pap")->first_row();
        if (!empty($grupo_pap)) {
            return $grupo_pap;
        } else {
            return false;
        }
    }

    function count_all_grupo() {
        $this->db->where("esta_gpa >", "-1");
        return $this->db->count_all_results('grupo_pap');
    }

    function get_paginate_grupo($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_gpa >", "-1");
        $this->db->where("(`codi_gpa` LIKE '%$search%' OR 
                            `nomb_gpa` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $query = $this->db->get('grupo_pap');
        return $query->result();
    }

    function check_nomb_gpa($nomb_gpa) {
        $this->db->where("esta_gpa >", "-1");
        $this->db->where('nomb_gpa', $nomb_gpa);
        $row = $this->db->get("grupo_pap")->first_row();
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
        $row = $this->db->get("grupo_pap")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function save_grupo($data) {
        $this->db->insert('grupo_pap', $data); 
        return $this->db->insert_id();
    }

    function update_grupo($codi_gpa, $data) {
        $this->db->where('codi_gpa', $codi_gpa);
        $this->db->update('grupo_pap', $data);
    }

    function count_all_portal($codi_gpa) {
        $this->db->where("codi_gpa", $codi_gpa);
        $this->db->where("esta_pap", "1");
        $this->db->where("esta_gpa", "1");
        return $this->db->count_all_results('v_pap');
    }

    function get_paginate_portal($limit, $start, $string = "", $codi_gpa, $year_pap, $data) {
        $search = $this->db->escape_like_str($string);
        $this->db->where("codi_gpa", $codi_gpa);
        $this->db->where("EXTRACT(YEAR FROM `fech_pap`) = " . $year_pap);
        $this->db->where("esta_pap", "1");
        $this->db->where("esta_gpa", "1");
        $this->db->where("(`nume_pap` LIKE '%$search%' OR
                            `fech_pap` LIKE '%$search%' OR
                            `desc_pap` LIKE '%$search%'
                            )");

        if (isset($data["iSortingCols"])) {
            for ($i=0; $i < (int) $data["iSortingCols"]; $i++) {
                switch ((int) $data["iSortCol_".$i]) {
                    case 0:
                        $this->db->order_by("CAST(`nume_pap` AS INT)", $data["sSortDir_".$i]);
                        break;
                    case 2:
                        $this->db->order_by("fech_pap", $data["sSortDir_".$i]);
                        break;
                    case 3:
                        $this->db->order_by("desc_pap", $data["sSortDir_".$i]);
                        break;
                    case 4:
                        $this->db->order_by("docu_pap", $data["sSortDir_".$i]);
                        break;
                }
            }
        } else {
            $this->db->order_by("CAST(`nume_pap` AS INT)", "asc");
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get('v_pap');
        return $query->result();
    }

}
