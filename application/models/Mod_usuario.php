<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_usuario extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

        if (! isset($_SESSION)) {
            session_start();
        }
    }

}
