<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DirectivaController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_directiva"));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_DIRECTIVA)) {
            $data["grupos_directiva"] = $this->mod_directiva->get_grupos_directiva();
            if (count($data["grupos_directiva"]) == 0) {
                $data["styles"] = $this->styles;
                $data["scripts"] = $this->scripts;
                $component["content"] = $this->load->view("directiva/empty_gdi", $data, true);
            } else {
                $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-fileinput/css/fileinput.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-fileinput/themes/explorer/theme.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'css/directiva.css" rel="stylesheet">';
                
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

                $this->scripts[] = '<script src="'.asset_url().'js/directiva.js"></script>';


                // Imprimir vista con datos
                $data["styles"] = $this->styles;
                $data["scripts"] = $this->scripts;
                $component["content"] = $this->load->view("directiva/search", $data, true);
            }

            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_DIRECTIVA)) {
            $nTotal = $this->mod_directiva->count_all($_POST['sSearch']);

            $data = $this->mod_directiva->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_DIRECTIVA)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_dir == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_DIRECTIVA)) {
                        $opciones.= '<form method="post" class="deshabilitar_directiva" action="'.base_url('directiva/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_dir" value="'.$row->codi_dir.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_dir == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_DIRECTIVA)) {
                        $opciones.= '<form method="post" class="habilitar_directiva" action="'.base_url('directiva/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_dir" value="'.$row->codi_dir.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                $opciones .= '<a href="'.asset_url().'directivas/'.$row->docu_dir.'" target="_blank" class="btn btn-info btn-download" data-toggle="tooltip" data-placement="top" title="Descargar documento"><i class="fa fa-download" aria-hidden="true"></i></a>&nbsp;';
                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_DIRECTIVA)) {
                        $opciones.= '<form method="post" class="eliminar_directiva" action="'.base_url('directiva/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_dir" value="'.$row->codi_dir.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_dir" => $row->codi_dir,
                    "codi_gdi" => $row->codi_gdi,
                    "nomb_gdi" => $row->nomb_gdi,
                    "nume_dir" => $row->nume_dir,
                    "fech_dir" => $row->fech_dir,
                    "fech_dir_d" => date("d/m/Y", strtotime($row->fech_dir)),
                    "desc_dir" => $row->desc_dir,
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

    public function check_nume_dir() {
        echo $this->mod_directiva->check_nume_dir($this->input->post('nume_dir'), date("Y", strtotime($this->input->post('fech_dir'))));
    }

    public function check_nume_dir_actualizar() {
        echo $this->mod_directiva->check_nume_dir_actualizar($this->input->post('codi_dir'), $this->input->post('nume_dir'), date("Y", strtotime($this->input->post('fech_dir'))));
    }

    public function save() {

        $nume_dir = $this->input->post('nume_dir');
        $fech_dir = $this->input->post('fech_dir');
        if ($this->mod_directiva->check_nume_dir($nume_dir, date("Y", strtotime($fech_dir))) == "true") {
            $config['upload_path'] = './assets/directivas/';
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['overwrite'] = true;
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['max_size'] = 20000;
            $config['file_name'] = date("Y", strtotime($fech_dir)) . "_" . urlencode($nume_dir);

            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('docu_dir')) {
                $type_system = "error";
                $message_system = $this->upload->display_errors();
            } else {
                $desc_dir = $this->input->post('desc_dir');
                $codi_gdi = $this->input->post('codi_gdi');

                $data = array(
                    'nume_dir' => $nume_dir,
                    'fech_dir' => $fech_dir,
                    'desc_dir' => $desc_dir,
                    'docu_dir' => $this->upload->data()["file_name"],
                    'exte_dir' => $this->upload->data()["file_ext"],
                    'codi_gdi' => $codi_gdi,
                    'esta_dir' => '1'
                );
                $codi_dir = $this->mod_directiva->save($data);

                $type_system = "success";
                $message_system = "La directiva $nume_dir ha sido registrado con éxito";
            }
        } else {
            $type_system = "error";
            $message_system = "El número de directiva $nume_dir ya existe";
        }
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('directiva'));
    }

    public function save_multi() {
        $count_rows = $this->input->post('count_rows');

        $count_success = 0;
        $count_error = 0;

        for ($i=0; $i < (int) $count_rows; $i++) { 
            $codi_gdi = $this->input->post('codi_gdi_'.$i);
            $nume_dir = $this->input->post('nume_dir_'.$i);
            $fech_dir = $this->input->post('fech_dir_'.$i);
            $desc_dir = $this->input->post('desc_dir_'.$i);
            $docu_dir = 'docu_dir_'.$i;
            if ($nume_dir != "" && $fech_dir != "" && $desc_dir != "" 
                && isset($_FILES[$docu_dir]['name']) && !empty($_FILES[$docu_dir]['name'])) {

                if ($this->mod_directiva->check_nume_dir($nume_dir, date("Y", strtotime($fech_dir))) == "true") {
                    $config['upload_path'] = './assets/directivas/';
                    $config['allowed_types'] = 'pdf|doc|docx';
                    $config['overwrite'] = true;
                    $config['max_width'] = 0;
                    $config['max_height'] = 0;
                    $config['max_size'] = 20000;
            		$config['file_name'] = date("Y", strtotime($fech_dir)) . "_" . urlencode($nume_dir);

                    $this->load->library('upload', $config);
                    if ( ! $this->upload->do_upload($docu_dir)) {
                        $count_error++;
                    } else {
                        $data = array(
                            'nume_dir' => $nume_dir,
                            'fech_dir' => $fech_dir,
                            'desc_dir' => $desc_dir,
                            'docu_dir' => $this->upload->data()["file_name"],
                            'exte_dir' => $this->upload->data()["file_ext"],
                            'codi_gdi' => $codi_gdi,
                            'esta_dir' => '1'
                        );
                        $codi_dir = $this->mod_directiva->save($data);

                        $count_success++;
                    }
                } else {
                    $count_error++;
                }

            }
        }

        $type_system = "info";
        if ($count_error != 0 && $count_success != 0) {
            $message_system = $count_success. " directiva(s) registradas con éxito y " . $count_error . " directiva(s) con error(es).";
        } else if ($count_error == 0 && $count_success != 0) {
            $message_system = $count_success. " directiva(s) registradas con éxito.";
        } else if ($count_error != 0 && $count_success == 0) {
            $message_system = $count_error . " directiva(s) con error(es).";
        }
        
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('directiva'));
    }

    public function update() {
        $codi_dir = $this->input->post('codi_dir');
        $nume_dir = $this->input->post('nume_dir');
        $fech_dir = $this->input->post('fech_dir');
        if ($this->mod_directiva->check_nume_dir_actualizar($codi_dir, $nume_dir, date("Y", strtotime($fech_dir))) == "true") {
            $directiva = $this->mod_directiva->get_directiva_row(array("codi_dir" => $codi_dir));

            $desc_dir = $this->input->post('desc_dir');
            $codi_gdi = $this->input->post('codi_gdi');

            $data = array(
                'nume_dir' => $nume_dir,
                'fech_dir' => $fech_dir,
                'desc_dir' => $desc_dir,
                'codi_gdi' => $codi_gdi
            );

            if ($directiva->nume_dir != $nume_dir) {
                $new_url = urlencode($nume_dir.$directiva->exte_dir);
                rename("./assets/directivas/".$directiva->docu_dir, "./assets/directivas/".$new_url);
                $data["docu_dir"] = $new_url;
            }

            $type_system = "success";
            $message_system = "La directiva $nume_dir ha sido actualizado con éxito";

            if (file_exists($_FILES['docu_dir']['tmp_name']) && is_uploaded_file($_FILES['docu_dir']['tmp_name'])) {
                $config['upload_path'] = './assets/directivas/';
                $config['allowed_types'] = 'pdf|doc|docx';
                $config['overwrite'] = true;
                $config['max_width'] = 0;
                $config['max_height'] = 0;
                $config['max_size'] = 20000;
            	$config['file_name'] = date("Y", strtotime($fech_dir)) . "_" . urlencode($nume_dir);

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('docu_dir')) {
                    $type_system = "error";
                    $message_system = $this->upload->display_errors();
                } else {
                    $data["docu_dir"] = $this->upload->data()["file_name"];
                }
            }

            $this->mod_directiva->update($codi_dir, $data);
        } else {
            $type_system = "error";
            $message_system = "El número de directiva $nume_dir ya existe";
        }
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('directiva'));
    }

    public function habilitar() {
        $codi_dir = $this->input->post('codi_dir');
        $data = array(
            'esta_dir' => '1'
        );
        $this->mod_directiva->update($codi_dir, $data);

        $type_system = "success";
        $message_system = "Directiva habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('directiva'));
    }

    public function deshabilitar() {
        $codi_dir = $this->input->post('codi_dir');
        $data = array(
            'esta_dir' => '0'
        );
        $this->mod_directiva->update($codi_dir, $data);

        $type_system = "success";
        $message_system = "Directiva deshabilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('directiva'));
    }

    public function eliminar() {
        $codi_dir = $this->input->post('codi_dir');
        $data = array(
            'esta_dir' => '-1'
        );
        $this->mod_directiva->update($codi_dir, $data);

        $type_system = "success";
        $message_system = "Directiva eliminado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('directiva'));
    }


    // GRUPO DE RESOLUCIONES

    public function grupo() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_GRUPO_DIRECTIVA)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/directiva.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/clipboard/clipboard.min.js"></script>';

            $this->scripts[] = '<script src="'.asset_url().'js/grupo_directiva.js"></script>';

            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("directiva/search_grupo", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate_grupo() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_GRUPO_DIRECTIVA)) {
            $nTotal = $this->mod_directiva->count_all_grupo();

            $data = $this->mod_directiva->get_paginate_grupo($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_GRUPO_DIRECTIVA)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_gdi == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_GRUPO_DIRECTIVA)) {
                        $opciones.= '<form method="post" class="deshabilitar_grupo_directiva" action="'.base_url('grupo_directiva/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_gdi" value="'.$row->codi_gdi.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_gdi == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_GRUPO_DIRECTIVA)) {
                        $opciones.= '<form method="post" class="habilitar_grupo_directiva" action="'.base_url('grupo_directiva/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_gdi" value="'.$row->codi_gdi.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                $opciones .= '<button type="button" class="btn btn-info btn-preview" data-toggle="tooltip" data-placement="top" title="Enlace a portal"><i class="fa fa-link" aria-hidden="true"></i></button>&nbsp;';

                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_GRUPO_DIRECTIVA)) {
                        $opciones.= '<form method="post" class="eliminar_grupo_directiva" action="'.base_url('grupo_directiva/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_gdi" value="'.$row->codi_gdi.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_gdi" => $row->codi_gdi,
                    "nomb_gdi" => $row->nomb_gdi,
                    "link_dir" => base_url().'directiva/'.$row->codi_gdi,
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

    public function check_nomb_gdi() {
        echo $this->mod_directiva->check_nomb_gdi($this->input->post('nomb_gdi'));
    }

    public function check_nomb_gdi_actualizar() {
        echo $this->mod_directiva->check_nomb_gdi_actualizar($this->input->post('codi_gdi'), $this->input->post('nomb_gdi'));
    }

    public function save_grupo() {
        $nomb_gdi = $this->input->post('nomb_gdi');

        $data = array(
            'nomb_gdi' => $nomb_gdi,
            'esta_gdi' => '1'
        );
        
        if ($this->mod_directiva->check_nomb_gdi($nomb_gdi) == "true") {
            $codi_gdi = $this->mod_directiva->save_grupo($data);

            $type_system = "success";
            $message_system = "El grupo de directiva $nomb_gdi ha sido registrado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El nombre de grupo $nomb_gdi ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_directiva'));
    }

    public function update_grupo() {
        $codi_gdi = $this->input->post('codi_gdi');
        $nomb_gdi = $this->input->post('nomb_gdi');

        $data = array(
            'nomb_gdi' => $nomb_gdi
        );

        if ($this->mod_directiva->check_nomb_gdi_actualizar($codi_gdi, $nomb_gdi) == "true") {
            $this->mod_directiva->update_grupo($codi_gdi, $data);

            $type_system = "success";
            $message_system = "El grupo de directiva $nomb_gdi ha sido actualizado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El nombre de grupo $nomb_gdi ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_directiva'));
    }

    public function habilitar_grupo() {
        $codi_gdi = $this->input->post('codi_gdi');
        $data = array(
            'esta_gdi' => '1'
        );
        $this->mod_directiva->update_grupo($codi_gdi, $data);

        $type_system = "success";
        $message_system = "Grupo de directiva habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_directiva'));
    }

    public function deshabilitar_grupo() {
        $codi_gdi = $this->input->post('codi_gdi');
        $data = array(
            'esta_gdi' => '0'
        );
        $this->mod_directiva->update_grupo($codi_gdi, $data);

        $type_system = "success";
        $message_system = "Grupo de directiva deshabilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_directiva'));
    }

    public function eliminar_grupo() {
        $codi_gdi = $this->input->post('codi_gdi');
        $data = array(
            'esta_gdi' => '-1'
        );
        $this->mod_directiva->update_grupo($codi_gdi, $data);

        $type_system = "success";
        $message_system = "Grupo de directiva eliminado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_directiva'));
    }

    // PUBLICO

    public function directiva($codi_gdi) {
        $directiva = $this->mod_directiva->get_grupo_directiva_row(array("codi_gdi" => $codi_gdi, "esta_gdi" => "1"));
        if ($directiva) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/directiva_portal.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'js/directiva_portal.js"></script>';

            // Imprimir vista con datos
            $data["codi_gdi"] = $codi_gdi;
            $data["nomb_gdi"] = $directiva->nomb_gdi;
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("portal/directiva", $data, true);
            $this->load->view("template/body_portal", $component);
        } else {
            echo "Página no encontrada";
        }
    }

    public function paginate_portal() {

        $codi_gdi = $_POST['codi_gdi'];
        $year_dir = $_POST['year_dir'];

        $nTotal = $this->mod_directiva->count_all_portal($_POST['sSearch'], $codi_gdi, $year_dir);

        $data = $this->mod_directiva->get_paginate_portal($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch'], $codi_gdi, $year_dir, $_POST);

        $aaData = array();

        foreach ($data as $row) {


            $docu_dir = '<a href="'.asset_url().'directivas/'.$row->docu_dir.'" target="_blank" class="btn btn-info btn-download" data-toggle="tooltip" data-placement="top" title="Descargar documento"><i class="fa fa-download" aria-hidden="true"></i></a>&nbsp;';


            $aaData[] = array(
                "nume_dir" => $row->nume_dir,
                "fech_dir_d" => date("d/m/Y", strtotime($row->fech_dir)),
                "desc_dir" => '<div style="text-align: left; font-size: 11px; height: 50px; overflow-y: scroll;">'.$row->desc_dir."</div>",
                "docu_dir" => $docu_dir
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
