<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PapController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_pap"));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_PAP)) {
            $data["grupos_pap"] = $this->mod_pap->get_grupos_pap();
            if (count($data["grupos_pap"]) == 0) {
                $data["styles"] = $this->styles;
                $data["scripts"] = $this->scripts;
                $component["content"] = $this->load->view("pap/empty_gpa", $data, true);
            } else {
                $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-fileinput/css/fileinput.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-fileinput/themes/explorer/theme.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'css/pap.css" rel="stylesheet">';
                
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

                $this->scripts[] = '<script src="'.asset_url().'js/pap.js"></script>';


                // Imprimir vista con datos
                $data["styles"] = $this->styles;
                $data["scripts"] = $this->scripts;
                $component["content"] = $this->load->view("pap/search", $data, true);
            }

            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_PAP)) {
            $nTotal = $this->mod_pap->count_all();

            $data = $this->mod_pap->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_PAP)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_pap == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_PAP)) {
                        $opciones.= '<form method="post" class="deshabilitar_pap" action="'.base_url('pap/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_pap" value="'.$row->codi_pap.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_pap == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_PAP)) {
                        $opciones.= '<form method="post" class="habilitar_pap" action="'.base_url('pap/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_pap" value="'.$row->codi_pap.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                $opciones .= '<a href="'.asset_url().'paps/'.$row->docu_pap.'" target="_blank" class="btn btn-info btn-download" data-toggle="tooltip" data-placement="top" title="Descargar documento"><i class="fa fa-download" aria-hidden="true"></i></a>&nbsp;';
                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_PAP)) {
                        $opciones.= '<form method="post" class="eliminar_pap" action="'.base_url('pap/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_pap" value="'.$row->codi_pap.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_pap" => $row->codi_pap,
                    "codi_gpa" => $row->codi_gpa,
                    "nomb_gpa" => $row->nomb_gpa,
                    "nume_pap" => $row->nume_pap,
                    "fech_pap" => $row->fech_pap,
                    "fech_pap_d" => date("d/m/Y", strtotime($row->fech_pap)),
                    "desc_pap" => $row->desc_pap,
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

    public function check_nume_pap() {
        echo $this->mod_pap->check_nume_pap($this->input->post('nume_pap'), date("Y", strtotime($this->input->post('fech_pap'))));
    }

    public function check_nume_pap_actualizar() {
        echo $this->mod_pap->check_nume_pap_actualizar($this->input->post('codi_pap'), $this->input->post('nume_pap'), date("Y", strtotime($this->input->post('fech_pap'))));
    }

    public function save() {

        $nume_pap = $this->input->post('nume_pap');
        $fech_pap = $this->input->post('fech_pap');
        if ($this->mod_pap->check_nume_pap($nume_pap, date("Y", strtotime($fech_pap))) == "true") {
            $config['upload_path'] = './assets/paps/';
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['overwrite'] = true;
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['max_size'] = 20000;
            $config['file_name'] = date("Y", strtotime($fech_pap)) . "_" . urlencode($nume_pap);

            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('docu_pap')) {
                $type_system = "error";
                $message_system = $this->upload->display_errors();
            } else {
                $desc_pap = $this->input->post('desc_pap');
                $codi_gpa = $this->input->post('codi_gpa');

                $data = array(
                    'nume_pap' => $nume_pap,
                    'fech_pap' => $fech_pap,
                    'desc_pap' => $desc_pap,
                    'docu_pap' => $this->upload->data()["file_name"],
                    'exte_pap' => $this->upload->data()["file_ext"],
                    'codi_gpa' => $codi_gpa,
                    'esta_pap' => '1'
                );
                $codi_pap = $this->mod_pap->save($data);

                $type_system = "success";
                $message_system = "PAP $nume_pap ha sido registrado con éxito";
            }
        } else {
            $type_system = "error";
            $message_system = "El número de PAP $nume_pap ya existe";
        }
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('pap'));
    }

    public function save_multi() {
        $count_rows = $this->input->post('count_rows');

        $count_success = 0;
        $count_error = 0;

        for ($i=0; $i < (int) $count_rows; $i++) { 
            $codi_gpa = $this->input->post('codi_gpa_'.$i);
            $nume_pap = $this->input->post('nume_pap_'.$i);
            $fech_pap = $this->input->post('fech_pap_'.$i);
            $desc_pap = $this->input->post('desc_pap_'.$i);
            $docu_pap = 'docu_pap_'.$i;
            if ($nume_pap != "" && $fech_pap != "" && $desc_pap != "" 
                && isset($_FILES[$docu_pap]['name']) && !empty($_FILES[$docu_pap]['name'])) {

                if ($this->mod_pap->check_nume_pap($nume_pap, date("Y", strtotime($fech_pap))) == "true") {
                    $config['upload_path'] = './assets/paps/';
                    $config['allowed_types'] = 'pdf|doc|docx';
                    $config['overwrite'] = true;
                    $config['max_width'] = 0;
                    $config['max_height'] = 0;
                    $config['max_size'] = 20000;
            		$config['file_name'] = date("Y", strtotime($fech_pap)) . "_" . urlencode($nume_pap);

                    $this->load->library('upload', $config);
                    if ( ! $this->upload->do_upload($docu_pap)) {
                        $count_error++;
                    } else {
                        $data = array(
                            'nume_pap' => $nume_pap,
                            'fech_pap' => $fech_pap,
                            'desc_pap' => $desc_pap,
                            'docu_pap' => $this->upload->data()["file_name"],
                            'exte_pap' => $this->upload->data()["file_ext"],
                            'codi_gpa' => $codi_gpa,
                            'esta_pap' => '1'
                        );
                        $codi_pap = $this->mod_pap->save($data);

                        $count_success++;
                    }
                } else {
                    $count_error++;
                }

            }
        }

        $type_system = "info";
        if ($count_error != 0 && $count_success != 0) {
            $message_system = $count_success. " PAP(s) registradas con éxito y " . $count_error . " PAP(s) con error(es).";
        } else if ($count_error == 0 && $count_success != 0) {
            $message_system = $count_success. " PAP(s) registradas con éxito.";
        } else if ($count_error != 0 && $count_success == 0) {
            $message_system = $count_error . " PAP(s) con error(es).";
        }
        
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('pap'));
    }

    public function update() {
        $codi_pap = $this->input->post('codi_pap');
        $nume_pap = $this->input->post('nume_pap');
        $fech_pap = $this->input->post('fech_pap');
        if ($this->mod_pap->check_nume_pap_actualizar($codi_pap, $nume_pap, date("Y", strtotime($fech_pap))) == "true") {
            $pap = $this->mod_pap->get_pap_row(array("codi_pap" => $codi_pap));

            $desc_pap = $this->input->post('desc_pap');
            $codi_gpa = $this->input->post('codi_gpa');

            $data = array(
                'nume_pap' => $nume_pap,
                'fech_pap' => $fech_pap,
                'desc_pap' => $desc_pap,
                'codi_gpa' => $codi_gpa
            );

            if ($pap->nume_pap != $nume_pap) {
                $new_url = urlencode($nume_pap.$pap->exte_pap);
                rename("./assets/paps/".$pap->docu_pap, "./assets/paps/".$new_url);
                $data["docu_pap"] = $new_url;
            }

            $type_system = "success";
            $message_system = "PAP $nume_pap ha sido actualizado con éxito";

            if (file_exists($_FILES['docu_pap']['tmp_name']) && is_uploaded_file($_FILES['docu_pap']['tmp_name'])) {
                $config['upload_path'] = './assets/paps/';
                $config['allowed_types'] = 'pdf|doc|docx';
                $config['overwrite'] = true;
                $config['max_width'] = 0;
                $config['max_height'] = 0;
                $config['max_size'] = 20000;
            	$config['file_name'] = date("Y", strtotime($fech_pap)) . "_" . urlencode($nume_pap);

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('docu_pap')) {
                    $type_system = "error";
                    $message_system = $this->upload->display_errors();
                } else {
                    $data["docu_pap"] = $this->upload->data()["file_name"];
                }
            }

            $this->mod_pap->update($codi_pap, $data);
        } else {
            $type_system = "error";
            $message_system = "El número de PAP $nume_pap ya existe";
        }
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('pap'));
    }

    public function habilitar() {
        $codi_pap = $this->input->post('codi_pap');
        $data = array(
            'esta_pap' => '1'
        );
        $this->mod_pap->update($codi_pap, $data);

        $type_system = "success";
        $message_system = "PAP habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('pap'));
    }

    public function deshabilitar() {
        $codi_pap = $this->input->post('codi_pap');
        $data = array(
            'esta_pap' => '0'
        );
        $this->mod_pap->update($codi_pap, $data);

        $type_system = "success";
        $message_system = "PAP deshabilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('pap'));
    }

    public function eliminar() {
        $codi_pap = $this->input->post('codi_pap');
        $data = array(
            'esta_pap' => '-1'
        );
        $this->mod_pap->update($codi_pap, $data);

        $type_system = "success";
        $message_system = "PAP eliminado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('pap'));
    }


    // GRUPO DE RESOLUCIONES

    public function grupo() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_GRUPO_PAP)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/pap.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/clipboard/clipboard.min.js"></script>';

            $this->scripts[] = '<script src="'.asset_url().'js/grupo_pap.js"></script>';

            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("pap/search_grupo", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate_grupo() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_GRUPO_PAP)) {
            $nTotal = $this->mod_pap->count_all_grupo();

            $data = $this->mod_pap->get_paginate_grupo($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_GRUPO_PAP)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_gpa == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_GRUPO_PAP)) {
                        $opciones.= '<form method="post" class="deshabilitar_grupo_pap" action="'.base_url('grupo_pap/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_gpa" value="'.$row->codi_gpa.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_gpa == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_GRUPO_PAP)) {
                        $opciones.= '<form method="post" class="habilitar_grupo_pap" action="'.base_url('grupo_pap/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_gpa" value="'.$row->codi_gpa.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                $opciones .= '<button type="button" class="btn btn-info btn-preview" data-toggle="tooltip" data-placement="top" title="Enlace a portal"><i class="fa fa-link" aria-hidden="true"></i></button>&nbsp;';

                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_GRUPO_PAP)) {
                        $opciones.= '<form method="post" class="eliminar_grupo_pap" action="'.base_url('grupo_pap/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_gpa" value="'.$row->codi_gpa.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_gpa" => $row->codi_gpa,
                    "nomb_gpa" => $row->nomb_gpa,
                    "link_pap" => base_url().'pap/'.$row->codi_gpa,
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

    public function check_nomb_gpa() {
        echo $this->mod_pap->check_nomb_gpa($this->input->post('nomb_gpa'));
    }

    public function check_nomb_gpa_actualizar() {
        echo $this->mod_pap->check_nomb_gpa_actualizar($this->input->post('codi_gpa'), $this->input->post('nomb_gpa'));
    }

    public function save_grupo() {
        $nomb_gpa = $this->input->post('nomb_gpa');

        $data = array(
            'nomb_gpa' => $nomb_gpa,
            'esta_gpa' => '1'
        );
        
        if ($this->mod_pap->check_nomb_gpa($nomb_gpa) == "true") {
            $codi_gpa = $this->mod_pap->save_grupo($data);

            $type_system = "success";
            $message_system = "El grupo de PAP $nomb_gpa ha sido registrado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El nombre de grupo $nomb_gpa ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_pap'));
    }

    public function update_grupo() {
        $codi_gpa = $this->input->post('codi_gpa');
        $nomb_gpa = $this->input->post('nomb_gpa');

        $data = array(
            'nomb_gpa' => $nomb_gpa
        );

        if ($this->mod_pap->check_nomb_gpa_actualizar($codi_gpa, $nomb_gpa) == "true") {
            $this->mod_pap->update_grupo($codi_gpa, $data);

            $type_system = "success";
            $message_system = "El grupo de PAP $nomb_gpa ha sido actualizado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El nombre de grupo $nomb_gpa ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_pap'));
    }

    public function habilitar_grupo() {
        $codi_gpa = $this->input->post('codi_gpa');
        $data = array(
            'esta_gpa' => '1'
        );
        $this->mod_pap->update_grupo($codi_gpa, $data);

        $type_system = "success";
        $message_system = "Grupo de PAP habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_pap'));
    }

    public function deshabilitar_grupo() {
        $codi_gpa = $this->input->post('codi_gpa');
        $data = array(
            'esta_gpa' => '0'
        );
        $this->mod_pap->update_grupo($codi_gpa, $data);

        $type_system = "success";
        $message_system = "Grupo de PAP deshabilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_pap'));
    }

    public function eliminar_grupo() {
        $codi_gpa = $this->input->post('codi_gpa');
        $data = array(
            'esta_gpa' => '-1'
        );
        $this->mod_pap->update_grupo($codi_gpa, $data);

        $type_system = "success";
        $message_system = "Grupo de PAP eliminado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_pap'));
    }

    // PUBLICO

    public function pap($codi_gpa) {
        $pap = $this->mod_pap->get_grupo_pap_row(array("codi_gpa" => $codi_gpa, "esta_gpa" => "1"));
        if ($pap) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/pap_portal.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'js/pap_portal.js"></script>';

            // Imprimir vista con datos
            $data["codi_gpa"] = $codi_gpa;
            $data["nomb_gpa"] = $pap->nomb_gpa;
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("portal/pap", $data, true);
            $this->load->view("template/body_portal", $component);
        } else {
            echo "Página no encontrada";
        }
    }

    public function paginate_portal() {

        $codi_gpa = $_POST['codi_gpa'];
        $year_pap = $_POST['year_pap'];

        $nTotal = $this->mod_pap->count_all_portal($codi_gpa);

        $data = $this->mod_pap->get_paginate_portal($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch'], $codi_gpa, $year_pap, $_POST);

        $aaData = array();

        foreach ($data as $row) {


            $docu_pap = '<a href="'.asset_url().'paps/'.$row->docu_pap.'" target="_blank" class="btn btn-info btn-download" data-toggle="tooltip" data-placement="top" title="Descargar documento"><i class="fa fa-download" aria-hidden="true"></i></a>&nbsp;';


            $aaData[] = array(
                "nume_pap" => $row->nume_pap,
                "fech_pap_d" => date("d/m/Y", strtotime($row->fech_pap)),
                "desc_pap" => '<div style="text-align: left; font-size: 11px; height: 50px; overflow-y: scroll;">'.$row->desc_pap."</div>",
                "docu_pap" => $docu_pap
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
