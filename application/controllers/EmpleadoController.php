<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EmpleadoController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_empleado"));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_EMPLEADO)) {
            $this->styles[] = '<link href="'.asset_url().'css/empleado.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'js/empleado.js"></script>';

            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("empleado/search", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_EMPLEADO)) {
            $nTotal = $this->mod_empleado->count_all();

            $data = $this->mod_empleado->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_EMPLEADO)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_emp == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_EMPLEADO)) {
                        $opciones.= '<form method="post" class="deshabilitar_emp" action="'.base_url('empleado/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_emp" value="'.$row->codi_emp.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_emp == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_EMPLEADO)) {
                        $opciones.= '<form method="post" class="habilitar_emp" action="'.base_url('empleado/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_emp" value="'.$row->codi_emp.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_EMPLEADO)) {
                        $opciones.= '<form method="post" class="eliminar_emp" action="'.base_url('empleado/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_emp" value="'.$row->codi_emp.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_emp" => $row->codi_emp,
                    "full_emp" => $row->apel_emp . (($row->apel_emp != "") ? ', ' : "") . $row->nomb_emp,
                    "apel_emp" => $row->apel_emp,
                    "nomb_emp" => $row->nomb_emp,
                    "carg_emp" => $row->carg_emp,
                    "docu_emp" => $row->docu_emp,
                    "ofic_emp" => $row->ofic_emp,
                    "tipo_emp" => $row->tipo_emp,
                    "obsv_emp" => $row->obsv_emp,
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

    public function check_full_emp() {
        echo $this->mod_empleado->check_full_emp($this->input->post('full_emp'));
    }

    public function check_full_emp_actualizar() {
        echo $this->mod_empleado->check_full_emp_actualizar($this->input->post('codi_emp'), $this->input->post('full_emp'));
    }

    public function save() {

        $apel_emp = $this->input->post('apel_emp');
        $nomb_emp = $this->input->post('nomb_emp');
        $carg_emp = $this->input->post('carg_emp');
        $docu_emp = $this->input->post('docu_emp');
        $ofic_emp = $this->input->post('ofic_emp');
        $tipo_emp = $this->input->post('tipo_emp');
        $obsv_emp = $this->input->post('obsv_emp');

        if ($this->mod_empleado->check_full_emp($apel_emp.', '.$nomb_emp) == "true") {
            $data = array(
                'apel_emp' => $apel_emp,
                'nomb_emp' => $nomb_emp,
                'carg_emp' => $carg_emp,
                'docu_emp' => $docu_emp,
                'ofic_emp' => $ofic_emp,
                'tipo_emp' => $tipo_emp,
                'obsv_emp' => $obsv_emp,
                'esta_emp' => '1'
            );
            $codi_emp = $this->mod_empleado->save($data);

            $type_system = "success";
            $message_system = "El empleado ha sido registrado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El empleado ya existe";
        }
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('empleado'));
    }

    public function update() {

        $codi_emp = $this->input->post('codi_emp');
        $apel_emp = $this->input->post('apel_emp');
        $nomb_emp = $this->input->post('nomb_emp');
        $carg_emp = $this->input->post('carg_emp');
        $docu_emp = $this->input->post('docu_emp');
        $ofic_emp = $this->input->post('ofic_emp');
        $tipo_emp = $this->input->post('tipo_emp');
        $obsv_emp = $this->input->post('obsv_emp');

        if ($this->mod_empleado->check_full_emp_actualizar($codi_emp, $apel_emp.', '.$nomb_emp) == "true") {
            $data = array(
                'apel_emp' => $apel_emp,
                'nomb_emp' => $nomb_emp,
                'carg_emp' => $carg_emp,
                'docu_emp' => $docu_emp,
                'ofic_emp' => $ofic_emp,
                'obsv_emp' => $obsv_emp,
                'tipo_emp' => $tipo_emp
            );

            $type_system = "success";
            $message_system = "El empleado ha sido actualizado con éxito";

            $this->mod_empleado->update($codi_emp, $data);
        
        } else {
            $type_system = "error";
            $message_system = "El empleado ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('empleado'));
    }

    public function habilitar() {
        $codi_emp = $this->input->post('codi_emp');
        $data = array(
            'esta_emp' => '1'
        );
        $this->mod_empleado->update($codi_emp, $data);

        $type_system = "success";
        $message_system = "El empleado ha sido habilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('empleado'));
    }

    public function deshabilitar() {
        $codi_emp = $this->input->post('codi_emp');
        $data = array(
            'esta_emp' => '0'
        );
        $this->mod_empleado->update($codi_emp, $data);

        $type_system = "success";
        $message_system = "El empleado ha sido deshabilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('empleado'));
    }

    public function eliminar() {
        $codi_emp = $this->input->post('codi_emp');
        $data = array(
            'esta_emp' => '-1'
        );
        $this->mod_empleado->update($codi_emp, $data);

        $type_system = "success";
        $message_system = "El empleado ha sido eliminado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('empleado'));
    }

    

}
