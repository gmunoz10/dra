<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_resolucion extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function get_resolucion_row($where) {
        $this->db->where($where);
        $resolucion = $this->db->get("resolucion")->first_row();
        if (!empty($resolucion)) {
            return $resolucion;
        } else {
            return false;
        }
    }

    function count_all() {
        $this->db->where("esta_res >", "-1");
        $this->db->where("esta_gre", "1");
        return $this->db->count_all_results('v_resolucion');
    }

    function get_paginate($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_res >", "-1");
        $this->db->where("esta_gre", "1");
        $this->db->where("(`codi_res` LIKE '%$search%' OR 
                            `codi_gre` LIKE '%$search%' OR
                            `nomb_gre` LIKE '%$search%' OR
                            `nume_res` LIKE '%$search%' OR
                            `fech_res` LIKE '%$search%' OR
                            `desc_res` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $query = $this->db->get('v_resolucion');
        return $query->result();
    }

    function check_nume_res($nume_res, $year_res) {
        $this->db->where("esta_res >", "-1");
        $this->db->where('nume_res', $nume_res);
        $this->db->where("EXTRACT(YEAR FROM `fech_res`) = '" . $year_res."'");
        $row = $this->db->get("resolucion")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function check_nume_res_actualizar($codi_res, $nume_res, $year_res) {
        $this->db->where("esta_res >", "-1");
        $this->db->where('codi_res !=', $codi_res);
        $this->db->where('nume_res', $nume_res);
        $this->db->where("EXTRACT(YEAR FROM `fech_res`) = '" . $year_res."'");
        $row = $this->db->get("resolucion")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function save($data) {
        $this->db->insert('resolucion', $data); 
        return $this->db->insert_id();
    }

    function update($codi_res, $data) {
        $this->db->where('codi_res', $codi_res);
        $this->db->update('resolucion', $data);
    }

    function get_grupos_resolucion() {
        $this->db->where("esta_gre", "1");
        $this->db->order_by("nomb_gre", "asc");
        $query = $this->db->get('grupo_resolucion');
        return $query->result();
    }

    function get_grupo_resolucion_row($where) {
        $this->db->where($where);
        $grupo_resolucion = $this->db->get("grupo_resolucion")->first_row();
        if (!empty($grupo_resolucion)) {
            return $grupo_resolucion;
        } else {
            return false;
        }
    }

    function count_all_grupo() {
        $this->db->where("esta_gre >", "-1");
        return $this->db->count_all_results('grupo_resolucion');
    }

    function get_paginate_grupo($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_gre >", "-1");
        $this->db->where("(`codi_gre` LIKE '%$search%' OR 
                            `nomb_gre` LIKE '%$search%'
                            )");
        $this->db->limit($limit, $start);
        $query = $this->db->get('grupo_resolucion');
        return $query->result();
    }

    function check_nomb_gre($nomb_gre) {
        $this->db->where("esta_gre >", "-1");
        $this->db->where('nomb_gre', $nomb_gre);
        $row = $this->db->get("grupo_resolucion")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function check_nomb_gre_actualizar($codi_gre, $nomb_gre) {
        $this->db->where("esta_gre >", "-1");
        $this->db->where('codi_gre !=', $codi_gre);
        $this->db->where('nomb_gre', $nomb_gre);
        $row = $this->db->get("grupo_resolucion")->first_row();
        if (!empty($row)) {
            return 'false';
        } else {
            return 'true';
        }
    }

    function save_grupo($data) {
        $this->db->insert('grupo_resolucion', $data); 
        return $this->db->insert_id();
    }

    function update_grupo($codi_gre, $data) {
        $this->db->where('codi_gre', $codi_gre);
        $this->db->update('grupo_resolucion', $data);
    }

    function count_all_portal($codi_gre) {
        $this->db->where("codi_gre", $codi_gre);
        $this->db->where("esta_res", "1");
        $this->db->where("esta_gre", "1");
        return $this->db->count_all_results('v_resolucion');
    }

    function get_paginate_portal($limit, $start, $string = "", $codi_gre, $year_res, $data) {
        $search = $this->db->escape_like_str($string);
        $this->db->where("codi_gre", $codi_gre);
        $this->db->where("EXTRACT(YEAR FROM `fech_res`) = " . $year_res);
        $this->db->where("esta_res", "1");
        $this->db->where("esta_gre", "1");
        $this->db->where("(`nume_res` LIKE '%$search%' OR
                            `fech_res` LIKE '%$search%' OR
                            `desc_res` LIKE '%$search%'
                            )");

        if (isset($data["iSortingCols"])) {
            for ($i=0; $i < (int) $data["iSortingCols"]; $i++) {
                switch ((int) $data["iSortCol_".$i]) {
                    case 0:
                        $this->db->order_by("CAST(`nume_res` AS INT)", $data["sSortDir_".$i]);
                        break;
                    case 2:
                        $this->db->order_by("fech_res", $data["sSortDir_".$i]);
                        break;
                    case 3:
                        $this->db->order_by("desc_res", $data["sSortDir_".$i]);
                        break;
                    case 4:
                        $this->db->order_by("docu_res", $data["sSortDir_".$i]);
                        break;
                }
            }
        } else {
            $this->db->order_by("CAST(`nume_res` AS INT)", "asc");
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get('v_resolucion');
        return $query->result();
    }

}
