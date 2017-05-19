<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_counter extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

    function check_ip($ip) {
        $this->db->where("ip_address", $ip);
        $contador = $this->db->get("contador")->first_row();
        if (!empty($contador)) {
            return true;
        } else {
            return false;
        }
    }

    function get_count() {
        return $this->db->count_all_results('contador');
    }

    function save($ip) {
        $this->db->insert('contador', ["ip_address" => $ip]); 
        return $this->db->insert_id();
    }

}
