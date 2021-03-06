<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SessionController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_usuario"));
        $this->load->helper('cookie');
    }

    public function validar_login() {
        $username = $this->input->post("username");
        $password = md5($this->input->post("password"));

        $usuario = $this->mod_usuario->check_login($username, $password);
        if ($usuario) {

            if ($usuario->esta_usu == "1") {

                if ($usuario->esta_rol == "1") {
                    $this->session->set_userdata("usuario", $usuario);
                    header("Location: " . base_url());
                } else {
                    $this->session->set_userdata("username_login", $username);
                    $this->session->set_userdata("label_login", "danger");
                    $this->session->set_userdata("mensaje_login", "El rol de tu cuenta se encuentra bloqueada");

                    header("Location: " . base_url() . "login");
                }
                
            } else {
                $this->session->set_userdata("username_login", $username);
                $this->session->set_userdata("label_login", "danger");
                $this->session->set_userdata("mensaje_login", "Tu cuenta se encuentra bloqueada");

                header("Location: " . base_url() . "login");
            }
        } else {
            $this->session->set_userdata("username_login", $username);
            $this->session->set_userdata("label_login", "danger");
            $this->session->set_userdata("mensaje_login", "Usuario y contraseña incorrecta");

            header("Location: " . base_url() . "login");
        }
    }

    public function logout() {
        if ($this->session->userdata("usuario")) {
            $this->session->unset_userdata("usuario");

            $this->session->set_userdata("label_login", "success");
            $this->session->set_userdata("mensaje_login", "Gracias por su visita");
        }

        header("Location: " . base_url() . "login");
    }

    public function cambiar_clave() {
        if ($this->session->userdata("usuario")) {
            $this->styles[] = '<link href="'.asset_url().'css/usuario.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';

            $this->scripts[] = '<script src="'.asset_url().'js/cambiar_clave.js"></script>';

            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("usuario/cambiar_clave", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

}
