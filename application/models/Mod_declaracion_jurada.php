<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_declaracion_jurada extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function get_declaracion_jurada_row($where) {
        $this->db->where($where);
        $declaracion_jurada = $this->db->get("declaracion_jurada")->first_row();
        if (!empty($declaracion_jurada)) {
            return $declaracion_jurada;
        } else {
            return false;
        }
    }

    function count_all($string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_dju >", "-1");
        $this->db->where("esta_gdj", "1");
        $this->db->where("(`codi_dju` LIKE '%$search%' OR 
                            `codi_gdj` LIKE '%$search%' OR
                            `nomb_gdj` LIKE '%$search%' OR
                            `nume_dju` LIKE '%$search%' OR
                            `fech_dju` LIKE '%$search%' OR
                            `desc_dju` LIKE '%$search%'
                            )");
        return $this->db->count_all_results('v_declaracion_jurada');
    }

    function get_paginate($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_dju >", "-1");
        $this->db->where("esta_gdj", "1");
        $this->db->where("(`codi_dju` LIKE '%$search%' OR 
                            `codi_gdj` LIKE '%$search%' OR
                            `nomb_gdj` LIKE '%$search%' OR
                            `nume_dju` LIKE '%$search%' OR
                            `fech_dju` LIKE '%$search%' OR
                            `desc_dju` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $query = $this->db->get('v_declaracion_jurada');
        return $query->result();
    }

    function check_nume_dju($nume_dju, $year_dju) {
        $this->db->where("esta_dju >", "-1");
        $this->db->where('nume_dju', $nume_dju);
        $this->db->where("EXTRACT(YEAR FROM `fech_dju`) = '" . $year_dju."'");
        $row = $this->db->get("declaracion_jurada")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function check_nume_dju_actualizar($codi_dju, $nume_dju, $year_dju) {
        $this->db->where("esta_dju >", "-1");
        $this->db->where('codi_dju !=', $codi_dju);
        $this->db->where('nume_dju', $nume_dju);
        $this->db->where("EXTRACT(YEAR FROM `fech_dju`) = '" . $year_dju."'");
        $row = $this->db->get("declaracion_jurada")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function save($data) {
        $this->db->insert('declaracion_jurada', $data); 
        return $this->db->insert_id();
    }

    function update($codi_dju, $data) {
        $this->db->where('codi_dju', $codi_dju);
        $this->db->update('declaracion_jurada', $data);
    }

    function get_grupos_declaracion_jurada() {
        $this->db->where("esta_gdj", "1");
        $this->db->order_by("nomb_gdj", "asc");
        $query = $this->db->get('grupo_declaracion_jurada');
        return $query->result();
    }

    function get_grupo_declaracion_jurada_row($where) {
        $this->db->where($where);
        $grupo_declaracion_jurada = $this->db->get("grupo_declaracion_jurada")->first_row();
        if (!empty($grupo_declaracion_jurada)) {
            return $grupo_declaracion_jurada;
        } else {
            return false;
        }
    }

    function count_all_grupo() {
        $this->db->where("esta_gdj >", "-1");
        return $this->db->count_all_results('grupo_declaracion_jurada');
    }

    function get_paginate_grupo($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_gdj >", "-1");
        $this->db->where("(`codi_gdj` LIKE '%$search%' OR 
                            `nomb_gdj` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $query = $this->db->get('grupo_declaracion_jurada');
        return $query->result();
    }

    function check_nomb_gdj($nomb_gdj) {
        $this->db->where("esta_gdj >", "-1");
        $this->db->where('nomb_gdj', $nomb_gdj);
        $row = $this->db->get("grupo_declaracion_jurada")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function check_nomb_gdj_actualizar($codi_gdj, $nomb_gdj) {
        $this->db->where("esta_gdj >", "-1");
        $this->db->where('codi_gdj !=', $codi_gdj);
        $this->db->where('nomb_gdj', $nomb_gdj);
        $row = $this->db->get("grupo_declaracion_jurada")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function save_grupo($data) {
        $this->db->insert('grupo_declaracion_jurada', $data); 
        return $this->db->insert_id();
    }

    function update_grupo($codi_gdj, $data) {
        $this->db->where('codi_gdj', $codi_gdj);
        $this->db->update('grupo_declaracion_jurada', $data);
    }

    function count_all_portal($string = "", $codi_gdj, $year_dju) {
        $search = $this->db->escape_like_str($string);
        $this->db->where("codi_gdj", $codi_gdj);
        $this->db->where("EXTRACT(YEAR FROM `fech_dju`) = " . $year_dju);
        $this->db->where("esta_dju", "1");
        $this->db->where("esta_gdj", "1");
        $this->db->where("(`nume_dju` LIKE '%$search%' OR
                            `fech_dju` LIKE '%$search%' OR
                            `desc_dju` LIKE '%$search%'
                            )");
        return $this->db->count_all_results('v_declaracion_jurada');
    }

    function get_paginate_portal($limit, $start, $string = "", $codi_gdj, $year_dju, $data) {
        $search = $this->db->escape_like_str($string);
        $this->db->where("codi_gdj", $codi_gdj);
        $this->db->where("EXTRACT(YEAR FROM `fech_dju`) = " . $year_dju);
        $this->db->where("esta_dju", "1");
        $this->db->where("esta_gdj", "1");
        $this->db->where("(`nume_dju` LIKE '%$search%' OR
                            `fech_dju` LIKE '%$search%' OR
                            `desc_dju` LIKE '%$search%'
                            )");

        if (isset($data["iSortingCols"])) {
            for ($i=0; $i < (int) $data["iSortingCols"]; $i++) {
                switch ((int) $data["iSortCol_".$i]) {
                    case 0:
                        $this->db->order_by("CAST(`nume_dju` AS INT)", $data["sSortDir_".$i]);
                        break;
                    case 2:
                        $this->db->order_by("fech_dju", $data["sSortDir_".$i]);
                        break;
                    case 3:
                        $this->db->order_by("desc_dju", $data["sSortDir_".$i]);
                        break;
                    case 4:
                        $this->db->order_by("docu_dju", $data["sSortDir_".$i]);
                        break;
                }
            }
        } else {
            $this->db->order_by("CAST(`nume_dju` AS INT)", "asc");
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get('v_declaracion_jurada');
        return $query->result();
    }

}
