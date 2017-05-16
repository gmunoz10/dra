<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MainController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_galeria'));
        $this->load->library('email');
        //$this->load->helper('cookie');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.postmarkapp.com';
        $config['smtp_user'] = '2d77b1e0-2839-48f9-b6f6-99a3fb110bf0';
        $config['smtp_pass'] = '2d77b1e0-2839-48f9-b6f6-99a3fb110bf0';
        $config['smtp_port'] = '587';
        $config['wordwrap'] = TRUE;
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
    }

    public function index() {
        $this->styles[] = '<link href="'.asset_url().'css/home.css" rel="stylesheet">';
        $this->scripts[] = '<script src="'.asset_url().'js/home.js"></script>';

        $this->load->model("mod_prensa");
        $this->load->model("mod_evento");

        $data["noticias"] = $this->mod_prensa->get_noticias();
        $data["eventos"] = $this->mod_evento->get_eventos();

        // Imprimir vista con datos
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
   
    public function direccion_oficina() {
        $this->styles[] = '<link href="'.asset_url().'css/direccion_oficinas.css" rel="stylesheet">';
        $this->scripts[] = '<script src="'.asset_url().'js/direccion_oficinas.js"></script>';
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/direccion_oficina", $data, true);
        $this->load->view("template/body_main", $component);
    }
   
    public function agencias_agrarias() {
        $this->styles[] = '<link href="'.asset_url().'css/agencias_agrarias.css" rel="stylesheet">';
        $this->scripts[] = '<script src="'.asset_url().'js/agencias_agrarias.js"></script>';
        $this->scripts[] = '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCn7DuplyahzwHTAxc0EHQJ_Wd8a0FQpvk&language=es&callback=initMap"></script>';
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/agencias_agrarias", $data, true);
        $this->load->view("template/body_main", $component);
    }

    public function temas_agrarios() {
        $this->styles[] = '<link href="'.asset_url().'css/temas_agrarios.css" rel="stylesheet">';
        $this->scripts[] = '<script src="'.asset_url().'js/temas_agrarios_public.js"></script>';

        $this->load->model("mod_tema_agrario");

        $data["temas_agrarios"] = $this->mod_tema_agrario->get_tema_agrarios();

        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/temas_agrarios", $data, true);
        $this->load->view("template/body_main", $component);
    }

    public function institucional() {
        $this->scripts[] = '<script src="'.asset_url().'js/institucional.js"></script>';
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/institucional", $data, true);
        $this->load->view("template/body_main", $component);
    }

    public function informacion_agraria() {
        $this->styles[] = '<link href="'.asset_url().'css/informacion_agraria.css" rel="stylesheet">';
        $this->scripts[] = '<script src="'.asset_url().'js/informacion_agraria.js"></script>';
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/informacion_agraria", $data, true);
        $this->load->view("template/body_main", $component);
    }

    public function competitividad_negocios() {
        $this->styles[] = '<link href="'.asset_url().'css/competitividad_negocios.css" rel="stylesheet">';
        $this->scripts[] = '<script src="'.asset_url().'js/competitividad_negocios.js"></script>';
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/competitividad_negocios", $data, true);
        $this->load->view("template/body_main", $component);
    }

    public function contacto() {
        $this->scripts[] = '<script src="'.asset_url().'js/contacto.js"></script>';
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/contacto", $data, true);
        $this->load->view("template/body_main", $component);
    }

    public function enviar_mensaje() {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $asunto = $this->input->post('asunto');
        $mensaje = $this->input->post('mensaje');

        $this->email->from("webmaster@dral.gob.pe", $name);
        $this->email->to("info_publica@dral.gob.pe");
        $this->email->subject($asunto);
        $this->email->message($mensaje . "<br><br><i>Enviado por ". $name. " (" . $email . ") desde <a href=\"http://dral.gob.pe/contacto\" target=\"_blank\">Formulario de contacto - Sitio Web DRAL</a><br>".date("d/m/Y h:i A") . "</i><br>");
        $this->email->send();

        $type_system = "success";
        $message_system = "El mensaje ha sido enviado con éxito";
        set_message_system($type_system, $message_system);
        header('Location: ' . base_url('contacto'));
    }

    public function galeria($page = 1) {
        $size = 3;
        $start = (int) $page * $size - $size;

        if (isset($_GET["search"]) && $_GET["search"] != "") {
            $data['search'] = $_GET["search"];
        } else {
            $data['search'] = "";
        }

        $data["count"] = $this->mod_galeria->count_album($data['search']);
        $data["albumes"] = $this->mod_galeria->get_list_album($data['search'], $start, $size);
        foreach ($data["albumes"] as $key => $album) {
            $data["albumes"][$key]->imagenes = $this->mod_galeria->get_imagenes_album($album->codi_alb);
        }
        $data["page"] = $page;
        $data["pages"] = ceil($data["count"]/$size);

        $this->styles[] = '<link href="'.asset_url().'plugins/lightbox/dist/ekko-lightbox.css" rel="stylesheet">';
        $this->styles[] = '<link href="'.asset_url().'css/galeria.css" rel="stylesheet">';
        
        $this->scripts[] = '<script src="'.asset_url().'plugins/lightbox/dist/ekko-lightbox.js"></script>';

        $this->scripts[] = '<script src="'.asset_url().'js/galeria.js"></script>';

        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("public/galeria", $data, true);
        $this->load->view("template/body_main", $component);
    }

    public function agenda() {
        $this->styles[] = '<link href="'.asset_url().'css/agenda_publico.css" rel="stylesheet">';
        $this->scripts[] = '<script src="'.asset_url().'js/agenda_public.js"></script>';

        $this->load->model("mod_agenda");

        $data["dependencias"] = $this->mod_agenda->get_dependencias();
        $data["years"] = $this->mod_agenda->get_years_agenda();

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

    public function login() {
        if (!$this->session->userdata("usuario")) {
            $data["username_login"] = $this->session->userdata("username_login");
            $data["label_login"] = $this->session->userdata("label_login");
            $data["mensaje_login"] = $this->session->userdata("mensaje_login");
            $this->session->unset_userdata("username_login");
            $this->session->unset_userdata("label_login");
            $this->session->unset_userdata("mensaje_login");
            
            $this->styles[] = '<link href="'.asset_url().'css/login.css" rel="stylesheet">';
            //$this->scripts[] = '<script src="'.asset_url().'js/transparencia.js"></script>';
            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("public/login", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }
}
