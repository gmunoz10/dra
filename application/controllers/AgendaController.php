<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AgendaController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_agenda"));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_AGENDA)) {
            $data["dependencias"] = $this->mod_agenda->get_dependencias();
            if (count($data["dependencias"]) == 0) {
                $data["styles"] = $this->styles;
                $data["scripts"] = $this->scripts;
                $component["content"] = $this->load->view("agenda/empty_dpe", $data, true);
            } else {
                $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'css/agenda.css" rel="stylesheet">';
                
                $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>';

                $this->scripts[] = '<script src="'.asset_url().'js/agenda.js"></script>';


                // Imprimir vista con datos
                $data["styles"] = $this->styles;
                $data["scripts"] = $this->scripts;
                $component["content"] = $this->load->view("agenda/search", $data, true);
            }
            
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_AGENDA)) {
            $nTotal = $this->mod_agenda->count_all();

            $data = $this->mod_agenda->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_AGENDA)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_age == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_AGENDA)) {
                        $opciones.= '<form method="post" class="deshabilitar_agenda" action="'.base_url('agenda/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_age" value="'.$row->codi_age.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_age == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_AGENDA)) {
                        $opciones.= '<form method="post" class="habilitar_agenda" action="'.base_url('agenda/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_age" value="'.$row->codi_age.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_AGENDA)) {
                        $opciones.= '<form method="post" class="eliminar_agenda" action="'.base_url('agenda/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_age" value="'.$row->codi_age.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_age" => $row->codi_age,
                    "codi_dpe" => $row->codi_dpe,
                    "nomb_dpe" => $row->nomb_dpe,
                    "fech_age" => date("Y-m-d H:i", strtotime($row->fech_age)),
                    "fech_age_d" => date("d/m/Y h:i A", strtotime($row->fech_age)),
                    "luga_age" => $row->luga_age,
                    "desc_age" => $row->desc_age,
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
        $codi_dpe = $this->input->post('codi_dpe');
        $luga_age = $this->input->post('luga_age');
        $fech_age = $this->input->post('fech_age');
        $desc_age = $this->input->post('desc_age');

        $data = array(
            'codi_dpe' => $codi_dpe,
            'luga_age' => $luga_age,
            'fech_age' => $fech_age,
            'desc_age' => $desc_age,
            'esta_age' => '1'
        );
        
        $codi_age = $this->mod_agenda->save($data);

        $type_system = "success";
        $message_system = "La agenda ha sido registrado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('agenda'));
    }

    public function update() {
        $codi_age = $this->input->post('codi_age');
        $codi_dpe = $this->input->post('codi_dpe');
        $luga_age = $this->input->post('luga_age');
        $fech_age = $this->input->post('fech_age');
        $desc_age = $this->input->post('desc_age');

        $data = array(
            'codi_dpe' => $codi_dpe,
            'luga_age' => $luga_age,
            'fech_age' => $fech_age,
            'desc_age' => $desc_age
        );

        $this->mod_agenda->update($codi_age, $data);

        $type_system = "success";
        $message_system = "La agenda ha sido actualizada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('agenda'));
    }

    public function habilitar() {
        $codi_age = $this->input->post('codi_age');
        $data = array(
            'esta_age' => '1'
        );
        $this->mod_agenda->update($codi_age, $data);

        $type_system = "success";
        $message_system = "Agenda habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('agenda'));
    }

    public function deshabilitar() {
        $codi_age = $this->input->post('codi_age');
        $data = array(
            'esta_age' => '0'
        );
        $this->mod_agenda->update($codi_age, $data);

        $type_system = "success";
        $message_system = "Agenda deshabilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('agenda'));
    }

    public function eliminar() {
        $codi_age = $this->input->post('codi_age');
        $data = array(
            'esta_age' => '-1'
        );
        $this->mod_agenda->update($codi_age, $data);

        $type_system = "success";
        $message_system = "Agenda eliminada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('agenda'));
    }

    // DEPENDENCIAS

    public function dependencia() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_DEPENDENCIA)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/dependencia.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/clipboard/clipboard.min.js"></script>';

            $this->scripts[] = '<script src="'.asset_url().'js/dependencia.js"></script>';

            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("agenda/search_dependencia", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate_dependencia() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_DEPENDENCIA)) {
            $nTotal = $this->mod_agenda->count_all_dependencia();

            $data = $this->mod_agenda->get_paginate_dependencia($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_DEPENDENCIA)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_dpe == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_DEPENDENCIA)) {
                        $opciones.= '<form method="post" class="deshabilitar_dependencia" action="'.base_url('dependencia/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_dpe" value="'.$row->codi_dpe.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_dpe == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_DEPENDENCIA)) {
                        $opciones.= '<form method="post" class="habilitar_dependencia" action="'.base_url('dependencia/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_dpe" value="'.$row->codi_dpe.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                //$opciones .= '<button type="button" class="btn btn-info btn-preview" data-toggle="tooltip" data-placement="top" title="Enlace a portal"><i class="fa fa-link" aria-hidden="true"></i></button>&nbsp;';

                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_DEPENDENCIA)) {
                        $opciones.= '<form method="post" class="eliminar_dependencia" action="'.base_url('dependencia/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_dpe" value="'.$row->codi_dpe.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_dpe" => $row->codi_dpe,
                    "nomb_dpe" => $row->nomb_dpe,
                    //"link_res" => base_url().'resolucion/'.$row->codi_dpe,
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

    public function check_nomb_dpe() {
        echo $this->mod_agenda->check_nomb_dpe($this->input->post('nomb_dpe'));
    }

    public function check_nomb_dpe_actualizar() {
        echo $this->mod_agenda->check_nomb_dpe_actualizar($this->input->post('codi_dpe'), $this->input->post('nomb_dpe'));
    }

    public function save_dependencia() {
        $nomb_dpe = $this->input->post('nomb_dpe');

        $data = array(
            'nomb_dpe' => $nomb_dpe,
            'esta_dpe' => '1'
        );
        
        if ($this->mod_agenda->check_nomb_dpe($nomb_dpe) == "true") {
            $codi_dpe = $this->mod_agenda->save_dependencia($data);

            $type_system = "success";
            $message_system = "La dependencia $nomb_dpe ha sido registrado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El nombre de dependencia $nomb_dpe ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('dependencia'));
    }

    public function update_dependencia() {
        $codi_dpe = $this->input->post('codi_dpe');
        $nomb_dpe = $this->input->post('nomb_dpe');

        $data = array(
            'nomb_dpe' => $nomb_dpe
        );

        if ($this->mod_agenda->check_nomb_dpe_actualizar($codi_dpe, $nomb_dpe) == "true") {
            $this->mod_agenda->update_dependencia($codi_dpe, $data);

            $type_system = "success";
            $message_system = "La dependencia $nomb_dpe ha sido actualizado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El nombre de dependencia $nomb_dpe ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('dependencia'));
    }

    public function habilitar_dependencia() {
        $codi_dpe = $this->input->post('codi_dpe');
        $data = array(
            'esta_dpe' => '1'
        );
        $this->mod_agenda->update_dependencia($codi_dpe, $data);

        $type_system = "success";
        $message_system = "Dependencia habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('dependencia'));
    }

    public function deshabilitar_dependencia() {
        $codi_dpe = $this->input->post('codi_dpe');
        $data = array(
            'esta_dpe' => '0'
        );
        $this->mod_agenda->update_dependencia($codi_dpe, $data);

        $type_system = "success";
        $message_system = "Dependencia deshabilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('dependencia'));
    }

    public function eliminar_dependencia() {
        $codi_dpe = $this->input->post('codi_dpe');
        $data = array(
            'esta_dpe' => '-1'
        );
        $this->mod_agenda->update_dependencia($codi_dpe, $data);

        $type_system = "success";
        $message_system = "Dependencia eliminada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('dependencia'));
    }

    // PUBLICO
    public function paginate_public() {
        $codi_dpe = $this->input->post('codi_dpe');
        $mes = $this->input->post('mes');
        $year = $this->input->post('year');

        $data = $this->mod_agenda->paginate_public($codi_dpe, $mes, $year);

        $aaData = array();

        foreach ($data as $row) {
            $aaData[] = array(
                "nomb_dpe" => $row->nomb_dpe,
                "luga_age" => $row->luga_age,
                "desc_age" => $row->desc_age,
                "dia" => date("d", strtotime($row->fech_age)),
                "mes" => date("m", strtotime($row->fech_age)),
                "ano" => date("Y", strtotime($row->fech_age)),
                "hora" => date("h:i A", strtotime($row->fech_age))
            );
        }

        print_r(json_encode($aaData));
    }

    

}
