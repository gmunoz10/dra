<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_visita extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function get_visita_row($where) {
        $this->db->where($where);
        $visita = $this->db->get("visita")->first_row();
        if (!empty($visita)) {
            return $visita;
        } else {
            return false;
        }
    }

    function count_all() {
        $this->db->where("esta_vis >", "-1");
        return $this->db->count_all_results('visita');
    }

    function get_paginate($limit, $start, $string = "") {
        $search = $this->db->escape_like_str($string);
        $this->db->where("esta_vis >", "-1");
        $this->db->where("(`codi_vis` LIKE '%$search%' OR 
                            `fech_vis` LIKE '%$search%' OR
                            `nomb_vis` LIKE '%$search%' OR
                            `apel_vis` LIKE '%$search%' OR
                            `tipo_vis` LIKE '%$search%' OR
                            `docu_vis` LIKE '%$search%' OR
                            `enti_vis` LIKE '%$search%' OR
                            `moti_vis` LIKE '%$search%' OR
                            `sede_vis` LIKE '%$search%' OR
                            `empl_vis` LIKE '%$search%' OR
                            `ofic_vis` LIKE '%$search%' OR
                            `ingr_vis` LIKE '%$search%' OR
                            `sali_vis` LIKE '%$search%'
                            )");
        $this->db->order_by("codi_vis", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('visita');
        return $query->result();
    }

    function save($data) {
        $this->db->insert('visita', $data); 
        return $this->db->insert_id();
    }

    function update($codi_vis, $data) {
        $this->db->where('codi_vis', $codi_vis);
        $this->db->update('visita', $data);
    }

    function count_all_portal($fech_vis) {
        $this->db->where("fech_vis", $fech_vis);
        $this->db->where("esta_vis", "1");
        return $this->db->count_all_results('visita');
    }

    function get_paginate_portal($limit, $start, $string = "", $fech_vis, $data) {
        $search = $this->db->escape_like_str($string);
        $this->db->where("fech_vis", $fech_vis);
        $this->db->where("esta_vis", "1");
        $this->db->where("(`tipo_emp` = 'LEY 276' OR `tipo_emp` = 'CAS' OR `tipo_emp` = 'CARGO DE CONFIANZA')");
        $this->db->where("(`codi_vis` LIKE '%$search%' OR 
                            `apel_vis` LIKE '%$search%' OR
                            `nomb_vis` LIKE '%$search%' OR
                            `tipo_vis` LIKE '%$search%' OR
                            `docu_vis` LIKE '%$search%' OR
                            `enti_vis` LIKE '%$search%' OR
                            `moti_vis` LIKE '%$search%' OR
                            `sede_vis` LIKE '%$search%' OR
                            `empl_vis` LIKE '%$search%' OR
                            `ofic_vis` LIKE '%$search%' OR
                            `ingr_vis` LIKE '%$search%' OR
                            `sali_vis` LIKE '%$search%'
                            )");

        if (isset($data["iSortingCols"])) {
            for ($i=0; $i < (int) $data["iSortingCols"]; $i++) {
                switch ((int) $data["iSortCol_".$i]) {
                    case 0:
                        $this->db->order_by("fech_vis", $data["sSortDir_".$i]);
                        break;
                    case 1:
                        $this->db->order_by("apel_vis", $data["sSortDir_".$i]);
                        break;
                    case 2:
                        $this->db->order_by("tipo_vis", $data["sSortDir_".$i]);
                        break;
                    case 3:
                        $this->db->order_by("docu_vis", $data["sSortDir_".$i]);
                        break;
                    case 4:
                        $this->db->order_by("enti_vis", $data["sSortDir_".$i]);
                        break;
                    case 5:
                        $this->db->order_by("moti_vis", $data["sSortDir_".$i]);
                        break;
                    case 6:
                        $this->db->order_by("sede_vis", $data["sSortDir_".$i]);
                        break;
                    case 7:
                        $this->db->order_by("empl_vis", $data["sSortDir_".$i]);
                        break;
                    case 8:
                        $this->db->order_by("ofic_vis", $data["sSortDir_".$i]);
                        break;
                    case 9:
                        $this->db->order_by("ingr_vis", $data["sSortDir_".$i]);
                        break;
                    case 10:
                        $this->db->order_by("sali_vis", $data["sSortDir_".$i]);
                        break;
                }
            }
        } else {
            $this->db->order_by("CAST(`codi_vis` AS INT)", "asc");
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get('v_visita');
        return $query->result();
    }

}
