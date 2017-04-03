<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PermisoController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_permiso", "mod_usuario"));
        $this->load->helper('cookie');
    }

    public function rol() {
        if ($this->session->userdata("usuario") && check_permission(VER_PERMISO_ROL)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/permiso_rol.css" rel="stylesheet">';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'js/permiso_rol.js"></script>';

            $data["roles"] = $this->mod_usuario->get_roles();

            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("permiso/rol", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function get_permisos_rol() {
        $codi_rol = $this->input->post('codi_rol');

        $grupos_permiso = $this->mod_permiso->get_grupos_permiso(array("esta_gpr" => "1"));

        foreach ($grupos_permiso as $key => $grupo_permiso) {
            $permisos = $this->mod_permiso->get_permisos(array("codi_gpr" => $grupo_permiso->codi_gpr, "esta_per" => "1"));

            foreach ($permisos as $permiso) {

                $permiso_rol = $this->mod_permiso->get_permiso_rol_row(array(
                                                                        "codi_rol" => $codi_rol, 
                                                                        "codi_per" => $permiso->codi_per,
                                                                        "esta_pro" => "1"));

                $permiso_row = array(
                    "codi_per" => $permiso->codi_per,
                    "codi_pro" => ($permiso_rol) ? $permiso_rol->codi_pro : -1,
                    "desc_per" => $permiso->desc_per,
                    "valo_pro" => ($permiso_rol) ? $permiso_rol->valo_pro : "0"
                );

                if ($codi_rol == "1") {
                    $permiso_row["valo_pro"] = "1";
                }

                $grupos_permiso[$key]->permisos[] = $permiso_row;
            }
        }

        $data["codi_rol"] = $codi_rol;
        $data["grupos_permiso"] = $grupos_permiso;

        $view = $this->load->view("permiso/grupo_permiso_rol", $data, true);
        echo json_encode(array("data"=>$grupos_permiso, "view"=>$view));
    }

    public function save_permiso_rol() {
        $codi_rol = $this->input->post('codi_rol');
        $permisos = json_decode($this->input->post('permisos'))->permisos;

        foreach ($permisos as $permiso) {
            $data = array(
                'valo_pro' => $permiso->valo_pro
            );

            if ($permiso->codi_pro != "-1") {
                $this->mod_permiso->update_permiso_rol($permiso->codi_pro, $data);
            } else {
                $permiso_rol = $this->mod_permiso->get_permiso_rol_row(array(
                                                                        "codi_rol" => $codi_rol, 
                                                                        "codi_per" => $permiso->codi_per));
                if (!empty($permiso_rol)) {
                    $data["esta_pro"] = "1";
                    $this->mod_permiso->update_permiso_rol($permiso_rol->codi_pro, $data);
                } else {
                    $data["codi_rol"] = $codi_rol;
                    $data["codi_per"] = $permiso->codi_per;
                    $data["esta_pro"] = "1";
                    $this->mod_permiso->save_permiso_rol($data);
                }
                
            }
        }
    }

}
