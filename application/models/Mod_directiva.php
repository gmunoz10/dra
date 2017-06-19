<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_directiva extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function get_directiva_row($where) {
        $this->db->where($where);
        $directiva = $this->db->get("directiva")->first_row();
        if (!empty($directiva)) {
            return $directiva;
        } else {
            return false;
        }
    }

    function count_all($string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_dir >", "-1");
        $this->db->where("esta_gdi", "1");
        $this->db->where("(`codi_dir` LIKE '%$search%' OR 
                            `codi_gdi` LIKE '%$search%' OR
                            `nomb_gdi` LIKE '%$search%' OR
                            `nume_dir` LIKE '%$search%' OR
                            `fech_dir` LIKE '%$search%' OR
                            `desc_dir` LIKE '%$search%'
                            )");
        return $this->db->count_all_results('v_directiva');
    }

    function get_paginate($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_dir >", "-1");
        $this->db->where("esta_gdi", "1");
        $this->db->where("(`codi_dir` LIKE '%$search%' OR 
                            `codi_gdi` LIKE '%$search%' OR
                            `nomb_gdi` LIKE '%$search%' OR
                            `nume_dir` LIKE '%$search%' OR
                            `fech_dir` LIKE '%$search%' OR
                            `desc_dir` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $query = $this->db->get('v_directiva');
        return $query->result();
    }

    function check_nume_dir($nume_dir, $year_dir) {
        $this->db->where("esta_dir >", "-1");
        $this->db->where('nume_dir', $nume_dir);
        $this->db->where("EXTRACT(YEAR FROM `fech_dir`) = '" . $year_dir."'");
        $row = $this->db->get("directiva")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function check_nume_dir_actualizar($codi_dir, $nume_dir, $year_dir) {
        $this->db->where("esta_dir >", "-1");
        $this->db->where('codi_dir !=', $codi_dir);
        $this->db->where('nume_dir', $nume_dir);
        $this->db->where("EXTRACT(YEAR FROM `fech_dir`) = '" . $year_dir."'");
        $row = $this->db->get("directiva")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function save($data) {
        $this->db->insert('directiva', $data); 
        return $this->db->insert_id();
    }

    function update($codi_dir, $data) {
        $this->db->where('codi_dir', $codi_dir);
        $this->db->update('directiva', $data);
    }

    function get_grupos_directiva() {
        $this->db->where("esta_gdi", "1");
        $this->db->order_by("nomb_gdi", "asc");
        $query = $this->db->get('grupo_directiva');
        return $query->result();
    }

    function get_grupo_directiva_row($where) {
        $this->db->where($where);
        $grupo_directiva = $this->db->get("grupo_directiva")->first_row();
        if (!empty($grupo_directiva)) {
            return $grupo_directiva;
        } else {
            return false;
        }
    }

    function count_all_grupo() {
        $this->db->where("esta_gdi >", "-1");
        return $this->db->count_all_results('grupo_directiva');
    }

    function get_paginate_grupo($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_gdi >", "-1");
        $this->db->where("(`codi_gdi` LIKE '%$search%' OR 
                            `nomb_gdi` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $query = $this->db->get('grupo_directiva');
        return $query->result();
    }

    function check_nomb_gdi($nomb_gdi) {
        $this->db->where("esta_gdi >", "-1");
        $this->db->where('nomb_gdi', $nomb_gdi);
        $row = $this->db->get("grupo_directiva")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function check_nomb_gdi_actualizar($codi_gdi, $nomb_gdi) {
        $this->db->where("esta_gdi >", "-1");
        $this->db->where('codi_gdi !=', $codi_gdi);
        $this->db->where('nomb_gdi', $nomb_gdi);
        $row = $this->db->get("grupo_directiva")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function save_grupo($data) {
        $this->db->insert('grupo_directiva', $data); 
        return $this->db->insert_id();
    }

    function update_grupo($codi_gdi, $data) {
        $this->db->where('codi_gdi', $codi_gdi);
        $this->db->update('grupo_directiva', $data);
    }

    function count_all_portal($string = "", $codi_gdi, $year_dir) {
        $search = $this->db->escape_like_str($string);
        $this->db->where("codi_gdi", $codi_gdi);
        $this->db->where("EXTRACT(YEAR FROM `fech_dir`) = " . $year_dir);
        $this->db->where("esta_dir", "1");
        $this->db->where("esta_gdi", "1");
        $this->db->where("(`nume_dir` LIKE '%$search%' OR
                            `fech_dir` LIKE '%$search%' OR
                            `desc_dir` LIKE '%$search%'
                            )");
        return $this->db->count_all_results('v_directiva');
    }

    function get_paginate_portal($limit, $start, $string = "", $codi_gdi, $year_dir, $data) {
        $search = $this->db->escape_like_str($string);
        $this->db->where("codi_gdi", $codi_gdi);
        $this->db->where("EXTRACT(YEAR FROM `fech_dir`) = " . $year_dir);
        $this->db->where("esta_dir", "1");
        $this->db->where("esta_gdi", "1");
        $this->db->where("(`nume_dir` LIKE '%$search%' OR
                            `fech_dir` LIKE '%$search%' OR
                            `desc_dir` LIKE '%$search%'
                            )");

        if (isset($data["iSortingCols"])) {
            for ($i=0; $i < (int) $data["iSortingCols"]; $i++) {
                switch ((int) $data["iSortCol_".$i]) {
                    case 0:
                        $this->db->order_by("CAST(`nume_dir` AS INT)", $data["sSortDir_".$i]);
                        break;
                    case 2:
                        $this->db->order_by("fech_dir", $data["sSortDir_".$i]);
                        break;
                    case 3:
                        $this->db->order_by("desc_dir", $data["sSortDir_".$i]);
                        break;
                    case 4:
                        $this->db->order_by("docu_dir", $data["sSortDir_".$i]);
                        break;
                }
            }
        } else {
            $this->db->order_by("CAST(`nume_dir` AS INT)", "asc");
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get('v_directiva');
        return $query->result();
    }

}
