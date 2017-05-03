<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PacController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_pac"));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_PAC)) {
            $data["grupos_pac"] = $this->mod_pac->get_grupos_pac();
            if (count($data["grupos_pac"]) == 0) {
                $data["styles"] = $this->styles;
                $data["scripts"] = $this->scripts;
                $component["content"] = $this->load->view("pac/empty_gpa", $data, true);
            } else {
                $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-fileinput/css/fileinput.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-fileinput/themes/explorer/theme.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'css/pac.css" rel="stylesheet">';
                
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

                $this->scripts[] = '<script src="'.asset_url().'js/pac.js"></script>';


                // Imprimir vista con datos
                $data["styles"] = $this->styles;
                $data["scripts"] = $this->scripts;
                $component["content"] = $this->load->view("pac/search", $data, true);
            }

            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_PAC)) {
            $nTotal = $this->mod_pac->count_all();

            $data = $this->mod_pac->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_PAC)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_pac == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_PAC)) {
                        $opciones.= '<form method="post" class="deshabilitar_pac" action="'.base_url('pac/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_pac" value="'.$row->codi_pac.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_pac == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_PAC)) {
                        $opciones.= '<form method="post" class="habilitar_pac" action="'.base_url('pac/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_pac" value="'.$row->codi_pac.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                $opciones .= '<a href="'.asset_url().'pacs/'.$row->docu_pac.'" target="_blank" class="btn btn-info btn-download" data-toggle="tooltip" data-placement="top" title="Descargar documento"><i class="fa fa-download" aria-hidden="true"></i></a>&nbsp;';
                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_PAC)) {
                        $opciones.= '<form method="post" class="eliminar_pac" action="'.base_url('pac/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_pac" value="'.$row->codi_pac.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_pac" => $row->codi_pac,
                    "codi_gpa" => $row->codi_gpa,
                    "nomb_gpa" => $row->nomb_gpa,
                    "fech_pac" => $row->fech_pac,
                    "fech_pac_d" => date("d/m/Y", strtotime($row->fech_pac)),
                    "desc_pac" => $row->desc_pac,
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

        $fech_pac = $this->input->post('fech_pac');
        $config['upload_path'] = './assets/pacs/';
        $config['allowed_types'] = 'pdf|doc|docx';
        $config['overwrite'] = FALSE;
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['max_size'] = 20000;
        $config['file_name'] = $fech_pac;

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('docu_pac')) {
            $type_system = "error";
            $message_system = $this->upload->display_errors();
        } else {
            $desc_pac = $this->input->post('desc_pac');
            $codi_gpa = $this->input->post('codi_gpa');

            $data = array(
                'fech_pac' => $fech_pac,
                'desc_pac' => $desc_pac,
                'docu_pac' => $this->upload->data()["file_name"],
                'exte_pac' => $this->upload->data()["file_ext"],
                'codi_gpa' => $codi_gpa,
                'esta_pac' => '1'
            );
            $codi_pac = $this->mod_pac->save($data);

            $type_system = "success";
            $message_system = "PAC ha sido registrado con éxito";
        }
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('pac'));
    }

    public function save_multi() {
        $count_rows = $this->input->post('count_rows');

        $count_success = 0;
        $count_error = 0;

        for ($i=0; $i < (int) $count_rows; $i++) { 
            $codi_gpa = $this->input->post('codi_gpa_'.$i);
            $fech_pac = $this->input->post('fech_pac_'.$i);
            $desc_pac = $this->input->post('desc_pac_'.$i);
            $docu_pac = 'docu_pac_'.$i;
            if ($fech_pac != "" && $desc_pac != "" 
                && isset($_FILES[$docu_pac]['name']) && !empty($_FILES[$docu_pac]['name'])) {

                $config['upload_path'] = './assets/pacs/';
                $config['allowed_types'] = 'pdf|doc|docx';
                $config['overwrite'] = FALSE;
                $config['max_width'] = 0;
                $config['max_height'] = 0;
                $config['max_size'] = 20000;
        		$config['file_name'] = $fech_pac;

                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload($docu_pac)) {
                    $count_error++;
                } else {
                    $data = array(
                        'fech_pac' => $fech_pac,
                        'desc_pac' => $desc_pac,
                        'docu_pac' => $this->upload->data()["file_name"],
                        'exte_pac' => $this->upload->data()["file_ext"],
                        'codi_gpa' => $codi_gpa,
                        'esta_pac' => '1'
                    );
                    $codi_pac = $this->mod_pac->save($data);

                    $count_success++;
                }

            }
        }

        $type_system = "info";
        if ($count_error != 0 && $count_success != 0) {
            $message_system = $count_success. " PAC(s) registradas con éxito y " . $count_error . " PAC(s) con error(es).";
        } else if ($count_error == 0 && $count_success != 0) {
            $message_system = $count_success. " PAC(s) registradas con éxito.";
        } else if ($count_error != 0 && $count_success == 0) {
            $message_system = $count_error . " PAC(s) con error(es).";
        }
        
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('pac'));
    }

    public function update() {
        $codi_pac = $this->input->post('codi_pac');
        $fech_pac = $this->input->post('fech_pac');

        $pac = $this->mod_pac->get_pac_row(array("codi_pac" => $codi_pac));

        $desc_pac = $this->input->post('desc_pac');
        $codi_gpa = $this->input->post('codi_gpa');

        $data = array(
            'fech_pac' => $fech_pac,
            'desc_pac' => $desc_pac,
            'codi_gpa' => $codi_gpa
        );

        $type_system = "success";
        $message_system = "PAC ha sido actualizado con éxito";

        if (file_exists($_FILES['docu_pac']['tmp_name']) && is_uploaded_file($_FILES['docu_pac']['tmp_name'])) {
            $config['upload_path'] = './assets/pacs/';
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['overwrite'] = FALSE;
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['max_size'] = 20000;
        	$config['file_name'] = $fech_pac;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('docu_pac')) {
                $type_system = "error";
                $message_system = $this->upload->display_errors();
            } else {
                $data["docu_pac"] = $this->upload->data()["file_name"];
            }
        }

        $this->mod_pac->update($codi_pac, $data);

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('pac'));
    }

    public function habilitar() {
        $codi_pac = $this->input->post('codi_pac');
        $data = array(
            'esta_pac' => '1'
        );
        $this->mod_pac->update($codi_pac, $data);

        $type_system = "success";
        $message_system = "PAC habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('pac'));
    }

    public function deshabilitar() {
        $codi_pac = $this->input->post('codi_pac');
        $data = array(
            'esta_pac' => '0'
        );
        $this->mod_pac->update($codi_pac, $data);

        $type_system = "success";
        $message_system = "PAC deshabilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('pac'));
    }

    public function eliminar() {
        $codi_pac = $this->input->post('codi_pac');
        $data = array(
            'esta_pac' => '-1'
        );
        $this->mod_pac->update($codi_pac, $data);

        $type_system = "success";
        $message_system = "PAC eliminado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('pac'));
    }


    // GRUPO DE RESOLUCIONES

    public function grupo() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_GRUPO_PAC)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/pac.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/clipboard/clipboard.min.js"></script>';

            $this->scripts[] = '<script src="'.asset_url().'js/grupo_pac.js"></script>';

            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("pac/search_grupo", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate_grupo() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_GRUPO_PAC)) {
            $nTotal = $this->mod_pac->count_all_grupo();

            $data = $this->mod_pac->get_paginate_grupo($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_GRUPO_PAC)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_gpa == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_GRUPO_PAC)) {
                        $opciones.= '<form method="post" class="deshabilitar_grupo_pac" action="'.base_url('grupo_pac/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_gpa" value="'.$row->codi_gpa.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_gpa == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_GRUPO_PAC)) {
                        $opciones.= '<form method="post" class="habilitar_grupo_pac" action="'.base_url('grupo_pac/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_gpa" value="'.$row->codi_gpa.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                $opciones .= '<button type="button" class="btn btn-info btn-preview" data-toggle="tooltip" data-placement="top" title="Enlace a portal"><i class="fa fa-link" aria-hidden="true"></i></button>&nbsp;';

                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_GRUPO_PAC)) {
                        $opciones.= '<form method="post" class="eliminar_grupo_pac" action="'.base_url('grupo_pac/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_gpa" value="'.$row->codi_gpa.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_gpa" => $row->codi_gpa,
                    "nomb_gpa" => $row->nomb_gpa,
                    "link_pac" => base_url().'pac/'.$row->codi_gpa,
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
        echo $this->mod_pac->check_nomb_gpa($this->input->post('nomb_gpa'));
    }

    public function check_nomb_gpa_actualizar() {
        echo $this->mod_pac->check_nomb_gpa_actualizar($this->input->post('codi_gpa'), $this->input->post('nomb_gpa'));
    }

    public function save_grupo() {
        $nomb_gpa = $this->input->post('nomb_gpa');

        $data = array(
            'nomb_gpa' => $nomb_gpa,
            'esta_gpa' => '1'
        );
        
        if ($this->mod_pac->check_nomb_gpa($nomb_gpa) == "true") {
            $codi_gpa = $this->mod_pac->save_grupo($data);

            $type_system = "success";
            $message_system = "El grupo de PAC $nomb_gpa ha sido registrado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El nombre de grupo $nomb_gpa ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_pac'));
    }

    public function update_grupo() {
        $codi_gpa = $this->input->post('codi_gpa');
        $nomb_gpa = $this->input->post('nomb_gpa');

        $data = array(
            'nomb_gpa' => $nomb_gpa
        );

        if ($this->mod_pac->check_nomb_gpa_actualizar($codi_gpa, $nomb_gpa) == "true") {
            $this->mod_pac->update_grupo($codi_gpa, $data);

            $type_system = "success";
            $message_system = "El grupo de PAC $nomb_gpa ha sido actualizado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El nombre de grupo $nomb_gpa ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_pac'));
    }

    public function habilitar_grupo() {
        $codi_gpa = $this->input->post('codi_gpa');
        $data = array(
            'esta_gpa' => '1'
        );
        $this->mod_pac->update_grupo($codi_gpa, $data);

        $type_system = "success";
        $message_system = "Grupo de PAC habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_pac'));
    }

    public function deshabilitar_grupo() {
        $codi_gpa = $this->input->post('codi_gpa');
        $data = array(
            'esta_gpa' => '0'
        );
        $this->mod_pac->update_grupo($codi_gpa, $data);

        $type_system = "success";
        $message_system = "Grupo de PAC deshabilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_pac'));
    }

    public function eliminar_grupo() {
        $codi_gpa = $this->input->post('codi_gpa');
        $data = array(
            'esta_gpa' => '-1'
        );
        $this->mod_pac->update_grupo($codi_gpa, $data);

        $type_system = "success";
        $message_system = "Grupo de PAC eliminado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_pac'));
    }

    // PUBLICO

    public function pac($codi_gpa) {
        $pac = $this->mod_pac->get_grupo_pac_row(array("codi_gpa" => $codi_gpa, "esta_gpa" => "1"));
        if ($pac) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/pac_portal.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'js/pac_portal.js"></script>';

            $data["years"] = $this->mod_pac->get_years();

            // Imprimir vista con datos
            $data["codi_gpa"] = $codi_gpa;
            $data["nomb_gpa"] = $pac->nomb_gpa;
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("portal/pac", $data, true);
            $this->load->view("template/body_portal", $component);
        } else {
            echo "Página no encontrada";
        }
    }

    public function paginate_portal() {

        $codi_gpa = $_POST['codi_gpa'];
        $year_pac = $_POST['year_pac'];

        $nTotal = $this->mod_pac->count_all_portal($codi_gpa);

        $data = $this->mod_pac->get_paginate_portal($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch'], $codi_gpa, $year_pac, $_POST);

        $aaData = array();

        foreach ($data as $row) {


            $docu_pac = '<a href="'.asset_url().'pacs/'.$row->docu_pac.'" target="_blank" class="btn btn-info btn-download" data-toggle="tooltip" data-placement="top" title="Descargar documento"><i class="fa fa-download" aria-hidden="true"></i></a>&nbsp;';


            $aaData[] = array(
                "fech_pac_d" => date("d/m/Y", strtotime($row->fech_pac)),
                "desc_pac" => '<div style="text-align: left; font-size: 11px; height: 50px; overflow-y: scroll;">'.$row->desc_pac."</div>",
                "docu_pac" => $docu_pac
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
