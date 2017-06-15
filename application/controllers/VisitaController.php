<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class VisitaController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_visita", "mod_empleado"));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_VISITA)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/visita.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/clipboard/clipboard.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'js/visita.js"></script>';

            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $data["empleado"] = $this->mod_empleado->get_empleado();
            $component["content"] = $this->load->view("visita/search", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_VISITA)) {
            $nTotal = $this->mod_visita->count_all();

            $data = $this->mod_visita->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_VISITA)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_vis == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_VISITA)) {
                        $opciones.= '<form method="post" class="deshabilitar_vis" action="'.base_url('visita/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_vis" value="'.$row->codi_vis.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_vis == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_VISITA)) {
                        $opciones.= '<form method="post" class="habilitar_vis" action="'.base_url('visita/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_vis" value="'.$row->codi_vis.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_VISITA)) {
                        $opciones.= '<form method="post" class="eliminar_vis" action="'.base_url('visita/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_vis" value="'.$row->codi_vis.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_vis" => $row->codi_vis,
                    "fech_vis" => $row->fech_vis,
                    "fech_vis_d" => date("d/m/Y", strtotime($row->fech_vis)),
                    "visi_vis" => $row->apel_vis . (($row->apel_vis != "") ? ', ' : "") . $row->nomb_vis,
                    "apel_vis" => $row->apel_vis,
                    "nomb_vis" => $row->nomb_vis,
                    "tipo_vis" => $row->tipo_vis,
                    "docu_vis" => $row->docu_vis,
                    "enti_vis" => $row->enti_vis,
                    "moti_vis" => $row->moti_vis,
                    "sede_vis" => $row->sede_vis,
                    "empl_vis" => $row->empl_vis,
                    "ofic_vis" => $row->ofic_vis,
                    "ingr_vis_d" => date('g:i A', strtotime($row->ingr_vis)),
                    "sali_vis_d" => ($row->sali_vis != "") ? date('g:i A', strtotime($row->sali_vis)) : "-",
                    "ingr_vis" => $row->ingr_vis,
                    "sali_vis" => $row->sali_vis,
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

        $fech_vis = $this->input->post('fech_vis');
        $apel_vis = $this->input->post('apel_vis');
        $nomb_vis = $this->input->post('nomb_vis');
        $tipo_vis = $this->input->post('tipo_vis');
        $docu_vis = $this->input->post('docu_vis');
        $enti_vis = $this->input->post('enti_vis');
        $moti_vis = $this->input->post('moti_vis');
        $sede_vis = $this->input->post('sede_vis');
        $empl_vis = $this->input->post('empl_vis');
        $ofic_vis = $this->input->post('ofic_vis');
        $ingr_vis = date("H:i", strtotime($this->input->post('ingr_vis')));
        $sali_vis = date("H:i", strtotime($this->input->post('sali_vis')));

        $data = array(
            'fech_vis' => $fech_vis,
            'apel_vis' => $apel_vis,
            'nomb_vis' => $nomb_vis,
            'tipo_vis' => $tipo_vis,
            'docu_vis' => $docu_vis,
            'enti_vis' => $enti_vis,
            'moti_vis' => $moti_vis,
            'sede_vis' => $sede_vis,
            'empl_vis' => $empl_vis,
            'ofic_vis' => $ofic_vis,
            'ingr_vis' => $ingr_vis,
            'sali_vis' => $sali_vis,
            'codi_usu' => $this->session->userdata("usuario")->codi_usu,
            'esta_vis' => '1'
        );
        $codi_vis = $this->mod_visita->save($data);

        $type_system = "success";
        $message_system = "La visita ha sido registrado con éxito";
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('visita'));
    }

    public function update() {

        $codi_vis = $this->input->post('codi_vis');
        $fech_vis = $this->input->post('fech_vis');
        $apel_vis = $this->input->post('apel_vis');
        $nomb_vis = $this->input->post('nomb_vis');
        $tipo_vis = $this->input->post('tipo_vis');
        $docu_vis = $this->input->post('docu_vis');
        $enti_vis = $this->input->post('enti_vis');
        $moti_vis = $this->input->post('moti_vis');
        $sede_vis = $this->input->post('sede_vis');
        $empl_vis = $this->input->post('empl_vis');
        $ofic_vis = $this->input->post('ofic_vis');
        $ingr_vis = date("H:i", strtotime($this->input->post('ingr_vis')));
        $sali_vis = date("H:i", strtotime($this->input->post('sali_vis')));

        $data = array(
            'fech_vis' => $fech_vis,
            'apel_vis' => $apel_vis,
            'nomb_vis' => $nomb_vis,
            'tipo_vis' => $tipo_vis,
            'docu_vis' => $docu_vis,
            'enti_vis' => $enti_vis,
            'moti_vis' => $moti_vis,
            'sede_vis' => $sede_vis,
            'empl_vis' => $empl_vis,
            'ofic_vis' => $ofic_vis,
            'ingr_vis' => $ingr_vis,
            'sali_vis' => $sali_vis
        );

        $type_system = "success";
        $message_system = "La Visita ha sido actualizado con éxito";

        $this->mod_visita->update($codi_vis, $data);

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('visita'));
    }

    public function habilitar() {
        $codi_vis = $this->input->post('codi_vis');
        $data = array(
            'esta_vis' => '1'
        );
        $this->mod_visita->update($codi_vis, $data);

        $type_system = "success";
        $message_system = "La Visita ha sido habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('visita'));
    }

    public function deshabilitar() {
        $codi_vis = $this->input->post('codi_vis');
        $data = array(
            'esta_vis' => '0'
        );
        $this->mod_visita->update($codi_vis, $data);

        $type_system = "success";
        $message_system = "La Visita ha sido deshabilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('visita'));
    }

    public function eliminar() {
        $codi_vis = $this->input->post('codi_vis');
        $data = array(
            'esta_vis' => '-1'
        );
        $this->mod_visita->update($codi_vis, $data);

        $type_system = "success";
        $message_system = "La Visita ha sido eliminado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('visita'));
    }

    // PUBLICO

    public function visitas() {
        $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
        $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
        $this->styles[] = '<link href="'.asset_url().'css/visita_portal.css" rel="stylesheet">';
        
        $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
        $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
        $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
        $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';
        $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>';
        $this->scripts[] = '<script src="'.asset_url().'js/visita_portal.js"></script>';

        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("portal/visita", $data, true);
        $this->load->view("template/body_portal", $component);
    }

    public function paginate_portal() {

        $fech_vis = $this->input->post('fech_vis');

        $nTotal = $this->mod_visita->count_all_portal($fech_vis);

        $data = $this->mod_visita->get_paginate_portal($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch'], $fech_vis, $_POST);

        //echo $this->db->last_query();

        $aaData = array();

        $i = 1;

        foreach ($data as $row) {

            $aaData[] = array(
                "codi_vis" => (int) $_POST['iDisplayStart']+$i,
                "fech_vis" => $row->fech_vis,
                "fech_vis_d" => date("d/m/Y", strtotime($row->fech_vis)),
                "visi_vis" => $row->apel_vis . (($row->apel_vis != "") ? ', ' : "") . $row->nomb_vis,
                "tipo_vis" => $row->tipo_vis,
                "docu_vis" => $row->docu_vis,
                "enti_vis" => $row->enti_vis,
                "moti_vis" => $row->moti_vis,
                "sede_vis" => $row->sede_vis,
                "empl_vis" => $row->empl_vis,
                "ofic_vis" => $row->ofic_vis,
                "ingr_vis_d" => date('g:i A', strtotime($row->ingr_vis)),
                "sali_vis_d" => ($row->sali_vis != "") ? date('g:i A', strtotime($row->sali_vis)) : "-",
                "ingr_vis" => $row->ingr_vis,
                "sali_vis" => $row->sali_vis,
            );

            $i++;
        }

        $aa = array(
            'sEcho' => $_POST['sEcho'],
            'iTotalRecords' => $nTotal,
            'iTotalDisplayRecords' => $nTotal,
            'aaData' => $aaData);

        print_r(json_encode($aa));
    }

    

}
