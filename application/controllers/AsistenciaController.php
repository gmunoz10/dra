<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AsistenciaController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_asistencia", "mod_empleado"));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_ASISTENCIA)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/asistencia.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/clipboard/clipboard.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'js/asistencia.js"></script>';

            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $data["empleados"] = $this->mod_empleado->get_empleado_asistencia();
            $component["content"] = $this->load->view("asistencia/search", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_ASISTENCIA)) {
            $nTotal = $this->mod_asistencia->count_all();

            $data = $this->mod_asistencia->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch'], $_POST['fech_asi']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_ASISTENCIA)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_asi == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_ASISTENCIA)) {
                        $opciones.= '<form method="post" class="deshabilitar_asi" action="'.base_url('asistencia/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_asi" value="'.$row->codi_asi.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_asi == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_ASISTENCIA)) {
                        $opciones.= '<form method="post" class="habilitar_asi" action="'.base_url('asistencia/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_asi" value="'.$row->codi_asi.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_ASISTENCIA)) {
                        $opciones.= '<form method="post" class="eliminar_asi" action="'.base_url('asistencia/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_asi" value="'.$row->codi_asi.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_asi" => $row->codi_asi,
                    "fech_asi" => $row->fech_asi,
                    "fech_asi_d" => date("d/m/Y", strtotime($row->fech_asi)),
                    "full_asi" => $row->apel_emp . (($row->apel_emp != "") ? ', ' : "") . $row->nomb_emp,
                    "apel_emp" => $row->apel_emp,
                    "nomb_emp" => $row->nomb_emp,
                    "docu_emp" => $row->docu_emp,
                    "ofic_emp" => $row->ofic_emp,
                    "ingr_asi_d" => date('g:i A', strtotime($row->ingr_asi)),
                    "sali_asi_d" => ($row->sali_asi != "") ? date('g:i A', strtotime($row->sali_asi)) : "-",
                    "ingr_asi" => $row->ingr_asi,
                    "sali_asi" => $row->sali_asi,
                    "inre_asi_d" => ($row->inre_asi != "") ? date('g:i A', strtotime($row->inre_asi)) : "-",
                    "sare_asi_d" => ($row->sare_asi != "") ? date('g:i A', strtotime($row->sare_asi)) : "-",
                    "inre_asi" => $row->inre_asi,
                    "sare_asi" => $row->sare_asi,
                    "obsv_emp" => $row->obsv_emp,
                    "codi_emp" => $row->codi_emp,
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

    public function save() {

        $fech_asi = $this->input->post('fech_asi');
        $codi_emp = $this->input->post('codi_emp');
        $obsv_emp = $this->input->post('obsv_emp');
        $ingr_asi = date("H:i", strtotime($this->input->post('ingr_asi')));
        $sali_asi = ($this->input->post('sali_asi') != "") ? date("H:i", strtotime($this->input->post('sali_asi'))) : "";
        $sare_asi = ($this->input->post('sare_asi') != "") ? date("H:i", strtotime($this->input->post('sare_asi'))) : "";
        $inre_asi = ($this->input->post('inre_asi') != "") ? date("H:i", strtotime($this->input->post('inre_asi'))) : "";

        $data = array(
            'fech_asi' => $fech_asi,
            'codi_emp' => $codi_emp,
            'obsv_emp' => $obsv_emp,
            'ingr_asi' => $ingr_asi,
            'sali_asi' => $sali_asi,
            'inre_asi' => $inre_asi,
            'sare_asi' => $sare_asi,
            'esta_asi' => '1'
        );
        $codi_asi = $this->mod_asistencia->save($data);

        $type_system = "success";
        $message_system = "La asistencia ha sido registrado con éxito";
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('asistencia'));
    }

    public function update() {

        $codi_asi = $this->input->post('codi_asi');
        $fech_asi = $this->input->post('fech_asi');
        $codi_emp = $this->input->post('codi_emp');
        $obsv_emp = $this->input->post('obsv_emp');
        $ingr_asi = date("H:i", strtotime($this->input->post('ingr_asi')));
        $sali_asi = ($this->input->post('sali_asi') != "") ? date("H:i", strtotime($this->input->post('sali_asi'))) : "";
        $sare_asi = ($this->input->post('sare_asi') != "") ? date("H:i", strtotime($this->input->post('sare_asi'))) : "";
        $inre_asi = ($this->input->post('inre_asi') != "") ? date("H:i", strtotime($this->input->post('inre_asi'))) : "";

        $data = array(
            'fech_asi' => $fech_asi,
            'codi_emp' => $codi_emp,
            'obsv_emp' => $obsv_emp,
            'ingr_asi' => $ingr_asi,
            'sali_asi' => $sali_asi,
            'inre_asi' => $inre_asi,
            'sare_asi' => $sare_asi
        );

        $type_system = "success";
        $message_system = "La asistencia ha sido actualizado con éxito";

        $this->mod_asistencia->update($codi_asi, $data);

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('asistencia'));
    }

    public function habilitar() {
        $codi_asi = $this->input->post('codi_asi');
        $data = array(
            'esta_asi' => '1'
        );
        $this->mod_asistencia->update($codi_asi, $data);

        $type_system = "success";
        $message_system = "La asistencia ha sido habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('asistencia'));
    }

    public function deshabilitar() {
        $codi_asi = $this->input->post('codi_asi');
        $data = array(
            'esta_asi' => '0'
        );
        $this->mod_asistencia->update($codi_asi, $data);

        $type_system = "success";
        $message_system = "La asistencia ha sido deshabilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('asistencia'));
    }

    public function eliminar() {
        $codi_asi = $this->input->post('codi_asi');
        $data = array(
            'esta_asi' => '-1'
        );
        $this->mod_asistencia->update($codi_asi, $data);

        $type_system = "success";
        $message_system = "La asistencia ha sido eliminado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('asistencia'));
    }


    

}
