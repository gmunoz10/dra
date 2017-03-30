<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MainController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array());
        //$this->load->helper('cookie');
    }

    public function index() {
        $this->styles[] = '<link href="'.asset_url().'css/home.css" rel="stylesheet">';
        $this->scripts[] = '<script src="'.asset_url().'js/home.js"></script>';

        // Imprimir vista con datos
        $data['label'] = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.';

        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/home", $data, true);
        $this->load->view("template/body_main", $component);
    }
   
    public function vision_mision() {
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/vision_mision", $data, true);
        $this->load->view("template/body_main", $component);
    }

    public function temas_agrarios() {
        $this->styles[] = '<link href="'.asset_url().'css/temas_agrarios.css" rel="stylesheet">';
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/temas_agrarios", $data, true);
        $this->load->view("template/body_main", $component);
    }

    public function direccion_oficina() {
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/direccion_oficina", $data, true);
        $this->load->view("template/body_main", $component);
    }

    public function agencias_agrarias() {
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/agencias_agrarias", $data, true);
        $this->load->view("template/body_main", $component);
    }

    public function contacto() {
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/contacto", $data, true);
        $this->load->view("template/body_main", $component);
    }

    public function galeria() {
        $this->styles[] = '<link href="'.asset_url().'css/galeria.css" rel="stylesheet">';
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/galeria", $data, true);
        $this->load->view("template/body_main", $component);
    }

    public function agenda() {
        $this->styles[] = '<link href="'.asset_url().'css/agenda.css" rel="stylesheet">';
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/agenda", $data, true);
        $this->load->view("template/body_main", $component);
    }

    public function transparencia() {
        $this->scripts[] = '<script src="'.asset_url().'js/transparencia.js"></script>';
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/transparencia", $data, true);
        $this->load->view("template/body_main", $component);
    }
}
