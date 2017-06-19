<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RolController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_rol", "mod_permiso"));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_ROL)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/rol.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>';

            $this->scripts[] = '<script src="'.asset_url().'js/rol.js"></script>';

            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("rol/search", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_ROL)) {
            $nTotal = $this->mod_rol->count_all($_POST['sSearch']);

            $data = $this->mod_rol->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($row->codi_rol != "1" && $this->session->userdata("usuario") && check_permission(MODIFICAR_ROL)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_rol == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($row->codi_rol != "1" && $this->session->userdata("usuario") && check_permission(DESHABILITAR_ROL)) {
                        $opciones.= '<form method="post" class="deshabilitar_rol" action="'.base_url('rol/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_rol" value="'.$row->codi_rol.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_rol == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($row->codi_rol != "1" && $this->session->userdata("usuario") && check_permission(HABILITAR_ROL)) {
                        $opciones.= '<form method="post" class="habilitar_rol" action="'.base_url('rol/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_rol" value="'.$row->codi_rol.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                if ($row->codi_rol != "1" && $this->session->userdata("usuario") && check_permission(MODIFICAR_PERMISO_ROL)) {
                        $opciones .= '<button type="button" class="btn btn-info btn-permiso" data-toggle="tooltip" data-placement="top" title="Modificar permisos"><i class="fa fa-key" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->codi_rol != "1" && $this->session->userdata("usuario") && check_permission(ELIMINAR_ROL)) {
                        $opciones.= '<form method="post" class="eliminar_rol" action="'.base_url('rol/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_rol" value="'.$row->codi_rol.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_rol" => $row->codi_rol,
                    "desc_rol" => $row->desc_rol,
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

    public function check_desc_rol() {
        echo $this->mod_rol->check_desc_rol($this->input->post('desc_rol'));
    }

    public function check_desc_rol_actualizar() {
        echo $this->mod_rol->check_desc_rol_actualizar($this->input->post('codi_rol'), $this->input->post('desc_rol'));
    }

    public function save() {
        $desc_rol = $this->input->post('desc_rol');

        $data = array(
            'desc_rol' => $desc_rol,
            'esta_rol' => '1'
        );
        
        if ($this->mod_rol->check_desc_rol($desc_rol) == "true") {
            $codi_rol = $this->mod_rol->save($data);

            $grupos_permiso = $this->mod_permiso->get_grupos_permiso(array("esta_gpr" => "1"));

            foreach ($grupos_permiso as $key => $grupo_permiso) {
                $permisos = $this->mod_permiso->get_permisos(array("codi_gpr" => $grupo_permiso->codi_gpr, "esta_per" => "1"));

                foreach ($permisos as $permiso) {
                    $data = array(
                        'codi_rol' => $codi_rol,
                        'codi_per' => $permiso->codi_per,
                        'valo_pro' => "0",
                        'esta_pro' => "1"
                    );
                    $this->mod_permiso->save_permiso_rol($data);
                }
            }

            $type_system = "success";
            $message_system = "El rol $desc_rol ha sido registrado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El nombre de rol $desc_rol ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('rol'));
    }

    public function update() {
        $codi_rol = $this->input->post('codi_rol');
        $desc_rol = $this->input->post('desc_rol');

        $data = array(
            'desc_rol' => $desc_rol
        );

        if ($this->mod_rol->check_desc_rol_actualizar($codi_rol, $desc_rol) == "true") {
            $this->mod_rol->update($codi_rol, $data);

            $type_system = "success";
            $message_system = "El rol $desc_rol ha sido actualizado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El nombre de rol $desc_rol ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('rol'));
    }

    public function habilitar() {
        $codi_rol = $this->input->post('codi_rol');
        $data = array(
            'esta_rol' => '1'
        );
        $this->mod_rol->update($codi_rol, $data);

        $type_system = "success";
        $message_system = "Rol habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('rol'));
    }

    public function deshabilitar() {
        $codi_rol = $this->input->post('codi_rol');
        $data = array(
            'esta_rol' => '0'
        );
        $this->mod_rol->update($codi_rol, $data);

        $type_system = "success";
        $message_system = "Rol deshabilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('rol'));
    }

    public function eliminar() {
        $codi_rol = $this->input->post('codi_rol');
        $data = array(
            'esta_rol' => '-1'
        );
        $this->mod_rol->update($codi_rol, $data);

        $type_system = "success";
        $message_system = "Rol eliminado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('rol'));
    }

}
