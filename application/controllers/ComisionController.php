<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ComisionController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_comision", "mod_empleado"));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_COMISION)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/comision.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/clipboard/clipboard.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'js/comision.js"></script>';

            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $data["empleados"] = $this->mod_empleado->get_empleado_asistencia();
            $component["content"] = $this->load->view("comision/search", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_COMISION)) {
            $nTotal = $this->mod_comision->count_all($_POST['sSearch'], $_POST['fech_com']);

            $data = $this->mod_comision->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch'], $_POST['fech_com']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_COMISION)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_com == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_COMISION)) {
                        $opciones.= '<form method="post" class="deshabilitar_com" action="'.base_url('comision/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_com" value="'.$row->codi_com.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_com == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_COMISION)) {
                        $opciones.= '<form method="post" class="habilitar_com" action="'.base_url('comision/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_com" value="'.$row->codi_com.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_COMISION)) {
                        $opciones.= '<form method="post" class="eliminar_com" action="'.base_url('comision/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_com" value="'.$row->codi_com.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_com" => $row->codi_com,
                    "fech_com" => $row->fech_com,
                    "fech_com_d" => date("d/m/Y", strtotime($row->fech_com)),
                    "full_com" => $row->apel_emp . (($row->apel_emp != "") ? ', ' : "") . $row->nomb_emp,
                    "apel_emp" => $row->apel_emp,
                    "nomb_emp" => $row->nomb_emp,
                    "docu_emp" => $row->docu_emp,
                    "ofic_emp" => $row->ofic_emp,
                    "tipo_com" => $row->tipo_com,
                    "tipo_com_d" => ($row->tipo_com == 1) ? "CON RETORNO" : "SIN RETORNO",
                    "codi_emp" => $row->codi_emp,
                    "detalle" => $this->mod_comision->get_detalle($row->codi_com),
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

        $fech_com = $this->input->post('fech_com');
        $codi_emp = $this->input->post('codi_emp');
        $tipo_com = $this->input->post('tipo_com');

        $data = array(
            'fech_com' => $fech_com,
            'codi_emp' => $codi_emp,
            'tipo_com' => $tipo_com,
            'esta_com' => '1'
        );
        $codi_com = $this->mod_comision->save($data);

        if ($tipo_com == "1") {
            $retornos = (int) $this->input->post('retornos');
            for ($i=0; $i < $retornos; $i++) {
                $ingreso = date("H:i", strtotime($this->input->post('ingr_com_'.$i)));
                $salida = date("H:i", strtotime($this->input->post('sali_com_'.$i)));
                $observacion = $this->input->post('obsv_com_'.$i);
                $this->mod_comision->save_detalle(array('codi_com' => $codi_com, 'num_dco' => $i, 'ingr_dco' => $ingreso, 'sali_dco' => $salida, 'obsv_dco' => $observacion));
            }
        } else {
            if ($this->input->post('ingr_com') != "" && $this->input->post('sali_com') != "") {
                $ingreso = date("H:i", strtotime($this->input->post('ingr_com')));
                $salida = date("H:i", strtotime($this->input->post('sali_com')));
                $observacion = $this->input->post('obsv_com');
                $this->mod_comision->save_detalle(array('codi_com' => $codi_com, 'num_dco' => '0', 'ingr_dco' => $ingreso, 'sali_dco' => $salida, 'obsv_dco' => $observacion));
            }
        }

        $type_system = "success";
        $message_system = "La comision ha sido registrado con éxito";
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('comision'));
    }

    public function update() {

        $codi_com = $this->input->post('codi_com');
        $fech_com = $this->input->post('fech_com');
        $codi_emp = $this->input->post('codi_emp');
        $tipo_com = $this->input->post('tipo_com');

        $data = array(
            'fech_com' => $fech_com,
            'codi_emp' => $codi_emp,
            'tipo_com' => $tipo_com
        );

        $this->mod_comision->update($codi_com, $data);

        if ($tipo_com == "1") {
            $retornos = (int) $this->input->post('retornos');
            $this->mod_comision->adjust_detalle($codi_com, $retornos);

            for ($i=0; $i < $retornos; $i++) {
                $ingreso = date("H:i", strtotime($this->input->post('ingr_com_'.$i)));
                $salida = date("H:i", strtotime($this->input->post('sali_com_'.$i)));
                $observacion = $this->input->post('obsv_com_'.$i);

                $detalle_comision = $this->mod_comision->get_detalle_ByNum($codi_com, $i);
                if (!empty($detalle_comision)) {
                    $this->mod_comision->update_detalle($detalle_comision->codi_dco, array('codi_com' => $codi_com, 'num_dco' => $i, 'ingr_dco' => $ingreso, 'sali_dco' => $salida, 'obsv_dco' => $observacion));
                } else {
                    $this->mod_comision->save_detalle(array('codi_com' => $codi_com, 'num_dco' => $i, 'ingr_dco' => $ingreso, 'sali_dco' => $salida, 'obsv_dco' => $observacion));
                }
            }
        } else {
            if ($this->input->post('ingr_com') != "" && $this->input->post('sali_com') != "") {
                $ingreso = date("H:i", strtotime($this->input->post('ingr_com')));
                $salida = date("H:i", strtotime($this->input->post('sali_com')));
                $observacion = $this->input->post('obsv_com');
                $detalle_comision = $this->mod_comision->get_detalle_ByNum($codi_com, 0);
                if (!empty($detalle_comision)) {
                    $this->mod_comision->update_detalle($detalle_comision->codi_dco, array('codi_com' => $codi_com, 'num_dco' => 0, 'ingr_dco' => $ingreso, 'sali_dco' => $salida, 'obsv_dco' => $observacion));
                } else {
                    $this->mod_comision->save_detalle(array('codi_com' => $codi_com, 'num_dco' => 0, 'ingr_dco' => $ingreso, 'sali_dco' => $salida, 'obsv_dco' => $observacion));
                }
            }
        }

        $type_system = "success";
        $message_system = "La comision ha sido actualizado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('comision'));
    }

    public function habilitar() {
        $codi_com = $this->input->post('codi_com');
        $data = array(
            'esta_com' => '1'
        );
        $this->mod_comision->update($codi_com, $data);

        $type_system = "success";
        $message_system = "La comision ha sido habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('comision'));
    }

    public function deshabilitar() {
        $codi_com = $this->input->post('codi_com');
        $data = array(
            'esta_com' => '0'
        );
        $this->mod_comision->update($codi_com, $data);

        $type_system = "success";
        $message_system = "La comision ha sido deshabilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('comision'));
    }

    public function eliminar() {
        $codi_com = $this->input->post('codi_com');
        $data = array(
            'esta_com' => '-1'
        );
        $this->mod_comision->update($codi_com, $data);

        $type_system = "success";
        $message_system = "La comision ha sido eliminado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('comision'));
    }

    public function export_pdf() {
        $date = $this->input->post('date');
        $tipo = $this->input->post('tipo');

        $data['date'] = $date;
        $data['tipo'] = $tipo;

        if ($tipo == "TODOS") {
            $comisiones = $this->mod_comision->get_detalle_comision(array('fech_com' => $date));
        } else {
            $comisiones = $this->mod_comision->get_detalle_comision(array('fech_com' => $date, 'tipo_emp' => $tipo));
        }

        $data['comisiones'] = $comisiones;

        $this->load->library('pdf');
        if ($tipo == "TODOS") {
            $this->pdf->load_view('comision/export_all', $data);
        } else {
            $this->pdf->load_view('comision/export', $data);
        }
        $this->pdf->render();
        $this->pdf->stream('COMISION_'.$tipo.'_'.$date.".pdf");
    }

}
