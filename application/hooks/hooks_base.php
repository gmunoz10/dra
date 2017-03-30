<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hooks_base {

    private $ci;

    public function __construct() {
       $this->ci = & get_instance();
        !$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
        !$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
    }

    public function check_login()
    {   

    }


}
