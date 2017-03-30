<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UsuarioController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_usuario"));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_CUENTA)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
            
            $this->scripts[] = '<script src="'.asset_url().'js/usuario.js"></script>';

            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("usuario/search", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_CUENTA)) {
            $nTotal = $this->mod_usuario->count_all();

            $data = $this->mod_usuario->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                if ($row->esta_usu == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    $opciones.= '<form method="post" action="'.base_url('usuario/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_usu" value="'.$row->codi_usu.'"><button type="submit" class="btn btn-danger btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>';
                } else if ($row->esta_usu == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    $opciones.= '<form method="post" action="'.base_url('usuario/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_usu" value="'.$row->codi_usu.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_usu" => $row->codi_usu,
                    "nomb_usu" => $row->nomb_usu,
                    "estado" => $estado,
                    "opciones" => $opciones
                );
            }

            $aa = array(
                'sEcho' => $_POST['sEcho'],
                'iTotalRecords' => $nTotal,
                'iTotalDisplayRecords' => $nTotal,
                'aaData' => $aaData);

            print_r(json_encode($aa));
        } else {
            header("Location: " . base_url());
        }
    }

}
