<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hooks_base {

    private $ci;

    public function __construct() {
       $this->ci = & get_instance();
        !$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
        !$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
    }

    public function check_counter() {
    	if (!$this->ci->mod_counter->check_ip($this->ci->input->ip_address())) {
    		$this->ci->mod_counter->save($this->ci->input->ip_address());
    	}
        date_default_timezone_set('America/Lima');
    }


}
