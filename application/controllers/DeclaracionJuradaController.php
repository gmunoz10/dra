<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DeclaracionjuradaController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_declaracion_jurada"));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_DECLARACION_JURADA)) {
            $data["grupos_declaracion_jurada"] = $this->mod_declaracion_jurada->get_grupos_declaracion_jurada();
            if (count($data["grupos_declaracion_jurada"]) == 0) {
                $data["styles"] = $this->styles;
                $data["scripts"] = $this->scripts;
                $component["content"] = $this->load->view("declaracion_jurada/empty_gdj", $data, true);
            } else {
                $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-fileinput/css/fileinput.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-fileinput/themes/explorer/theme.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'css/declaracion_jurada.css" rel="stylesheet">';
                
                $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-fileinput/js/fileinput.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-fileinput/js/locales/dral.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-fileinput/themes/explorer/theme.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>';
                $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>';

                $this->scripts[] = '<script src="'.asset_url().'js/declaracion_jurada.js"></script>';


                // Imprimir vista con datos
                $data["styles"] = $this->styles;
                $data["scripts"] = $this->scripts;
                $component["content"] = $this->load->view("declaracion_jurada/search", $data, true);
            }

            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_DECLARACION_JURADA)) {
            $nTotal = $this->mod_declaracion_jurada->count_all($_POST['sSearch']);

            $data = $this->mod_declaracion_jurada->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_DECLARACION_JURADA)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_dju == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_DECLARACION_JURADA)) {
                        $opciones.= '<form method="post" class="deshabilitar_declaracion_jurada" action="'.base_url('declaracion_jurada/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_dju" value="'.$row->codi_dju.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_dju == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_DECLARACION_JURADA)) {
                        $opciones.= '<form method="post" class="habilitar_declaracion_jurada" action="'.base_url('declaracion_jurada/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_dju" value="'.$row->codi_dju.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                $opciones .= '<a href="'.asset_url().'declaraciones_juradas/'.$row->docu_dju.'" target="_blank" class="btn btn-info btn-download" data-toggle="tooltip" data-placement="top" title="Descargar documento"><i class="fa fa-download" aria-hidden="true"></i></a>&nbsp;';
                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_DECLARACION_JURADA)) {
                        $opciones.= '<form method="post" class="eliminar_declaracion_jurada" action="'.base_url('declaracion_jurada/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_dju" value="'.$row->codi_dju.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_dju" => $row->codi_dju,
                    "codi_gdj" => $row->codi_gdj,
                    "nomb_gdj" => $row->nomb_gdj,
                    "nume_dju" => $row->nume_dju,
                    "fech_dju" => $row->fech_dju,
                    "fech_dju_d" => date("d/m/Y", strtotime($row->fech_dju)),
                    "desc_dju" => $row->desc_dju,
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

    public function check_nume_dju() {
        echo $this->mod_declaracion_jurada->check_nume_dju($this->input->post('nume_dju'), date("Y", strtotime($this->input->post('fech_dju'))));
    }

    public function check_nume_dju_actualizar() {
        echo $this->mod_declaracion_jurada->check_nume_dju_actualizar($this->input->post('codi_dju'), $this->input->post('nume_dju'), date("Y", strtotime($this->input->post('fech_dju'))));
    }

    public function save() {

        $nume_dju = $this->input->post('nume_dju');
        $fech_dju = $this->input->post('fech_dju');
        if ($this->mod_declaracion_jurada->check_nume_dju($nume_dju, date("Y", strtotime($fech_dju))) == "true") {
            $config['upload_path'] = './assets/declaraciones_juradas/';
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['overwrite'] = true;
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['max_size'] = 20000;
            $config['file_name'] = date("Y", strtotime($fech_dju)) . "_" . urlencode($nume_dju);

            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('docu_dju')) {
                $type_system = "error";
                $message_system = $this->upload->display_errors();
            } else {
                $desc_dju = $this->input->post('desc_dju');
                $codi_gdj = $this->input->post('codi_gdj');

                $data = array(
                    'nume_dju' => $nume_dju,
                    'fech_dju' => $fech_dju,
                    'desc_dju' => $desc_dju,
                    'docu_dju' => $this->upload->data()["file_name"],
                    'exte_dju' => $this->upload->data()["file_ext"],
                    'codi_gdj' => $codi_gdj,
                    'esta_dju' => '1'
                );
                $codi_dju = $this->mod_declaracion_jurada->save($data);

                $type_system = "success";
                $message_system = "La declaración jurada $nume_dju ha sido registrado con éxito";
            }
        } else {
            $type_system = "error";
            $message_system = "El número de declaración jurada $nume_dju ya existe";
        }
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('declaracion_jurada'));
    }

    public function save_multi() {
        $count_rows = $this->input->post('count_rows');

        $count_success = 0;
        $count_error = 0;

        for ($i=0; $i < (int) $count_rows; $i++) { 
            $codi_gdj = $this->input->post('codi_gdj_'.$i);
            $nume_dju = $this->input->post('nume_dju_'.$i);
            $fech_dju = $this->input->post('fech_dju_'.$i);
            $desc_dju = $this->input->post('desc_dju_'.$i);
            $docu_dju = 'docu_dju_'.$i;
            if ($nume_dju != "" && $fech_dju != "" && $desc_dju != "" 
                && isset($_FILES[$docu_dju]['name']) && !empty($_FILES[$docu_dju]['name'])) {

                if ($this->mod_declaracion_jurada->check_nume_dju($nume_dju, date("Y", strtotime($fech_dju))) == "true") {
                    $config['upload_path'] = './assets/declaraciones_juradas/';
                    $config['allowed_types'] = 'pdf|doc|docx';
                    $config['overwrite'] = true;
                    $config['max_width'] = 0;
                    $config['max_height'] = 0;
                    $config['max_size'] = 20000;
            		$config['file_name'] = date("Y", strtotime($fech_dju)) . "_" . urlencode($nume_dju);

                    $this->load->library('upload', $config);
                    if ( ! $this->upload->do_upload($docu_dju)) {
                        $count_error++;
                    } else {
                        $data = array(
                            'nume_dju' => $nume_dju,
                            'fech_dju' => $fech_dju,
                            'desc_dju' => $desc_dju,
                            'docu_dju' => $this->upload->data()["file_name"],
                            'exte_dju' => $this->upload->data()["file_ext"],
                            'codi_gdj' => $codi_gdj,
                            'esta_dju' => '1'
                        );
                        $codi_dju = $this->mod_declaracion_jurada->save($data);

                        $count_success++;
                    }
                } else {
                    $count_error++;
                }

            }
        }

        $type_system = "info";
        if ($count_error != 0 && $count_success != 0) {
            $message_system = $count_success. " declaración(es) jurada(s) registradas con éxito y " . $count_error . " declaración(es) jurada(s) con error(es).";
        } else if ($count_error == 0 && $count_success != 0) {
            $message_system = $count_success. " declaración(es) jurada(s) registradas con éxito.";
        } else if ($count_error != 0 && $count_success == 0) {
            $message_system = $count_error . " declaración(es) jurada(s) con error(es).";
        }
        
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('declaracion_jurada'));
    }

    public function update() {
        $codi_dju = $this->input->post('codi_dju');
        $nume_dju = $this->input->post('nume_dju');
        $fech_dju = $this->input->post('fech_dju');
        if ($this->mod_declaracion_jurada->check_nume_dju_actualizar($codi_dju, $nume_dju, date("Y", strtotime($fech_dju))) == "true") {
            $declaracion_jurada = $this->mod_declaracion_jurada->get_declaracion_jurada_row(array("codi_dju" => $codi_dju));

            $desc_dju = $this->input->post('desc_dju');
            $codi_gdj = $this->input->post('codi_gdj');

            $data = array(
                'nume_dju' => $nume_dju,
                'fech_dju' => $fech_dju,
                'desc_dju' => $desc_dju,
                'codi_gdj' => $codi_gdj
            );

            if ($declaracion_jurada->nume_dju != $nume_dju) {
                $new_url = urlencode($nume_dju.$declaracion_jurada->exte_dju);
                rename("./assets/declaraciones_juradas/".$declaracion_jurada->docu_dju, "./assets/declaraciones_juradas/".$new_url);
                $data["docu_dju"] = $new_url;
            }

            $type_system = "success";
            $message_system = "La declaración jurada $nume_dju ha sido actualizado con éxito";

            if (file_exists($_FILES['docu_dju']['tmp_name']) && is_uploaded_file($_FILES['docu_dju']['tmp_name'])) {
                $config['upload_path'] = './assets/declaraciones_juradas/';
                $config['allowed_types'] = 'pdf|doc|docx';
                $config['overwrite'] = true;
                $config['max_width'] = 0;
                $config['max_height'] = 0;
                $config['max_size'] = 20000;
            	$config['file_name'] = date("Y", strtotime($fech_dju)) . "_" . urlencode($nume_dju);

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('docu_dju')) {
                    $type_system = "error";
                    $message_system = $this->upload->display_errors();
                } else {
                    $data["docu_dju"] = $this->upload->data()["file_name"];
                }
            }

            $this->mod_declaracion_jurada->update($codi_dju, $data);
        } else {
            $type_system = "error";
            $message_system = "El número de declaración jurada $nume_dju ya existe";
        }
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('declaracion_jurada'));
    }

    public function habilitar() {
        $codi_dju = $this->input->post('codi_dju');
        $data = array(
            'esta_dju' => '1'
        );
        $this->mod_declaracion_jurada->update($codi_dju, $data);

        $type_system = "success";
        $message_system = "Declaración jurada habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('declaracion_jurada'));
    }

    public function deshabilitar() {
        $codi_dju = $this->input->post('codi_dju');
        $data = array(
            'esta_dju' => '0'
        );
        $this->mod_declaracion_jurada->update($codi_dju, $data);

        $type_system = "success";
        $message_system = "Declaración jurada deshabilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('declaracion_jurada'));
    }

    public function eliminar() {
        $codi_dju = $this->input->post('codi_dju');
        $data = array(
            'esta_dju' => '-1'
        );
        $this->mod_declaracion_jurada->update($codi_dju, $data);

        $type_system = "success";
        $message_system = "Declaración jurada eliminado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('declaracion_jurada'));
    }


    // GRUPO DE RESOLUCIONES

    public function grupo() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_GRUPO_DECLARACION_JURADA)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/declaracion_jurada.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/clipboard/clipboard.min.js"></script>';

            $this->scripts[] = '<script src="'.asset_url().'js/grupo_declaracion_jurada.js"></script>';

            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("declaracion_jurada/search_grupo", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate_grupo() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_GRUPO_DECLARACION_JURADA)) {
            $nTotal = $this->mod_declaracion_jurada->count_all_grupo();

            $data = $this->mod_declaracion_jurada->get_paginate_grupo($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_GRUPO_DECLARACION_JURADA)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_gdj == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_GRUPO_DECLARACION_JURADA)) {
                        $opciones.= '<form method="post" class="deshabilitar_grupo_declaracion_jurada" action="'.base_url('grupo_declaracion_jurada/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_gdj" value="'.$row->codi_gdj.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_gdj == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_GRUPO_DECLARACION_JURADA)) {
                        $opciones.= '<form method="post" class="habilitar_grupo_declaracion_jurada" action="'.base_url('grupo_declaracion_jurada/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_gdj" value="'.$row->codi_gdj.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                $opciones .= '<button type="button" class="btn btn-info btn-preview" data-toggle="tooltip" data-placement="top" title="Enlace a portal"><i class="fa fa-link" aria-hidden="true"></i></button>&nbsp;';

                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_GRUPO_DECLARACION_JURADA)) {
                        $opciones.= '<form method="post" class="eliminar_grupo_declaracion_jurada" action="'.base_url('grupo_declaracion_jurada/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_gdj" value="'.$row->codi_gdj.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_gdj" => $row->codi_gdj,
                    "nomb_gdj" => $row->nomb_gdj,
                    "link_dju" => base_url().'declaracion_jurada/'.$row->codi_gdj,
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

    public function check_nomb_gdj() {
        echo $this->mod_declaracion_jurada->check_nomb_gdj($this->input->post('nomb_gdj'));
    }

    public function check_nomb_gdj_actualizar() {
        echo $this->mod_declaracion_jurada->check_nomb_gdj_actualizar($this->input->post('codi_gdj'), $this->input->post('nomb_gdj'));
    }

    public function save_grupo() {
        $nomb_gdj = $this->input->post('nomb_gdj');

        $data = array(
            'nomb_gdj' => $nomb_gdj,
            'esta_gdj' => '1'
        );
        
        if ($this->mod_declaracion_jurada->check_nomb_gdj($nomb_gdj) == "true") {
            $codi_gdj = $this->mod_declaracion_jurada->save_grupo($data);

            $type_system = "success";
            $message_system = "El grupo de declaración jurada $nomb_gdj ha sido registrado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El nombre de grupo $nomb_gdj ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_declaracion_jurada'));
    }

    public function update_grupo() {
        $codi_gdj = $this->input->post('codi_gdj');
        $nomb_gdj = $this->input->post('nomb_gdj');

        $data = array(
            'nomb_gdj' => $nomb_gdj
        );

        if ($this->mod_declaracion_jurada->check_nomb_gdj_actualizar($codi_gdj, $nomb_gdj) == "true") {
            $this->mod_declaracion_jurada->update_grupo($codi_gdj, $data);

            $type_system = "success";
            $message_system = "El grupo de declaración jurada $nomb_gdj ha sido actualizado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El nombre de grupo $nomb_gdj ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_declaracion_jurada'));
    }

    public function habilitar_grupo() {
        $codi_gdj = $this->input->post('codi_gdj');
        $data = array(
            'esta_gdj' => '1'
        );
        $this->mod_declaracion_jurada->update_grupo($codi_gdj, $data);

        $type_system = "success";
        $message_system = "Grupo de declaración jurada habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_declaracion_jurada'));
    }

    public function deshabilitar_grupo() {
        $codi_gdj = $this->input->post('codi_gdj');
        $data = array(
            'esta_gdj' => '0'
        );
        $this->mod_declaracion_jurada->update_grupo($codi_gdj, $data);

        $type_system = "success";
        $message_system = "Grupo de declaración jurada deshabilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_declaracion_jurada'));
    }

    public function eliminar_grupo() {
        $codi_gdj = $this->input->post('codi_gdj');
        $data = array(
            'esta_gdj' => '-1'
        );
        $this->mod_declaracion_jurada->update_grupo($codi_gdj, $data);

        $type_system = "success";
        $message_system = "Grupo de declaración jurada eliminado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_declaracion_jurada'));
    }

    // PUBLICO

    public function declaracion_jurada($codi_gdj) {
        $declaracion_jurada = $this->mod_declaracion_jurada->get_grupo_declaracion_jurada_row(array("codi_gdj" => $codi_gdj, "esta_gdj" => "1"));
        if ($declaracion_jurada) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/declaracion_jurada_portal.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'js/declaracion_jurada_portal.js"></script>';

            // Imprimir vista con datos
            $data["codi_gdj"] = $codi_gdj;
            $data["nomb_gdj"] = $declaracion_jurada->nomb_gdj;
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("portal/declaracion_jurada", $data, true);
            $this->load->view("template/body_portal", $component);
        } else {
            echo "Página no encontrada";
        }
    }

    public function paginate_portal() {

        $codi_gdj = $_POST['codi_gdj'];
        $year_dju = $_POST['year_dju'];

        $nTotal = $this->mod_declaracion_jurada->count_all_portal($_POST['sSearch'], $codi_gdj, $year_dju);

        $data = $this->mod_declaracion_jurada->get_paginate_portal($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch'], $codi_gdj, $year_dju, $_POST);

        $aaData = array();

        foreach ($data as $row) {


            $docu_dju = '<a href="'.asset_url().'declaraciones_juradas/'.$row->docu_dju.'" target="_blank" class="btn btn-info btn-download" data-toggle="tooltip" data-placement="top" title="Descargar documento"><i class="fa fa-download" aria-hidden="true"></i></a>&nbsp;';


            $aaData[] = array(
                "nume_dju" => $row->nume_dju,
                "fech_dju_d" => date("d/m/Y", strtotime($row->fech_dju)),
                "desc_dju" => '<div style="text-align: left; font-size: 11px; height: 50px; overflow-y: scroll;">'.$row->desc_dju."</div>",
                "docu_dju" => $docu_dju
            );
        }

        $aa = array(
            'sEcho' => $_POST['sEcho'],
            'iTotalRecords' => $nTotal,
            'iTotalDisplayRecords' => $nTotal,
            'aaData' => $aaData);

        print_r(json_encode($aa));
    }

    

}
