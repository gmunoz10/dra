<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ResolucionController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_resolucion"));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_RESOLUCION)) {
            $data["grupos_resolucion"] = $this->mod_resolucion->get_grupos_resolucion();
            if (count($data["grupos_resolucion"]) == 0) {
                $data["styles"] = $this->styles;
                $data["scripts"] = $this->scripts;
                $component["content"] = $this->load->view("resolucion/empty_gre", $data, true);
            } else {
                $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-fileinput/css/fileinput.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-fileinput/themes/explorer/theme.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">';
                $this->styles[] = '<link href="'.asset_url().'css/resolucion.css" rel="stylesheet">';
                
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

                $this->scripts[] = '<script src="'.asset_url().'js/resolucion.js"></script>';


                // Imprimir vista con datos
                $data["styles"] = $this->styles;
                $data["scripts"] = $this->scripts;
                $component["content"] = $this->load->view("resolucion/search", $data, true);
            }

            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_RESOLUCION)) {
            $nTotal = $this->mod_resolucion->count_all();

            $data = $this->mod_resolucion->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_RESOLUCION)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_res == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_RESOLUCION)) {
                        $opciones.= '<form method="post" class="deshabilitar_resolucion" action="'.base_url('resolucion/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_res" value="'.$row->codi_res.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_res == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_RESOLUCION)) {
                        $opciones.= '<form method="post" class="habilitar_resolucion" action="'.base_url('resolucion/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_res" value="'.$row->codi_res.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                $opciones .= '<a href="'.asset_url().'resoluciones/'.$row->docu_res.'" target="_blank" class="btn btn-info btn-download" data-toggle="tooltip" data-placement="top" title="Descargar documento"><i class="fa fa-download" aria-hidden="true"></i></a>&nbsp;';
                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_RESOLUCION)) {
                        $opciones.= '<form method="post" class="eliminar_resolucion" action="'.base_url('resolucion/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_res" value="'.$row->codi_res.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_res" => $row->codi_res,
                    "codi_gre" => $row->codi_gre,
                    "nomb_gre" => $row->nomb_gre,
                    "nume_res" => $row->nume_res,
                    "fech_res" => $row->fech_res,
                    "fech_res_d" => date("d/m/Y", strtotime($row->fech_res)),
                    "desc_res" => $row->desc_res,
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

    public function check_nume_res() {
        echo $this->mod_resolucion->check_nume_res($this->input->post('nume_res'), date("Y", strtotime($this->input->post('fech_res'))));
    }

    public function check_nume_res_actualizar() {
        echo $this->mod_resolucion->check_nume_res_actualizar($this->input->post('codi_res'), $this->input->post('nume_res'), date("Y", strtotime($this->input->post('fech_res'))));
    }

    public function save() {

        $nume_res = $this->input->post('nume_res');
        $fech_res = $this->input->post('fech_res');
        if ($this->mod_resolucion->check_nume_res($nume_res, date("Y", strtotime($fech_res))) == "true") {
            $config['upload_path'] = './assets/resoluciones/';
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['overwrite'] = true;
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['max_size'] = 20000;
            $config['file_name'] = urlencode($nume_res);

            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('docu_res')) {
                $type_system = "error";
                $message_system = $this->upload->display_errors();
            } else {
                $desc_res = $this->input->post('desc_res');
                $codi_gre = $this->input->post('codi_gre');

                $data = array(
                    'nume_res' => $nume_res,
                    'fech_res' => $fech_res,
                    'desc_res' => $desc_res,
                    'docu_res' => $this->upload->data()["file_name"],
                    'exte_res' => $this->upload->data()["file_ext"],
                    'codi_gre' => $codi_gre,
                    'esta_res' => '1'
                );
                $codi_res = $this->mod_resolucion->save($data);

                $type_system = "success";
                $message_system = "La resolución $nume_res ha sido registrado con éxito";
            }
        } else {
            $type_system = "error";
            $message_system = "El número de resolución $nume_res ya existe";
        }
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('resolucion'));
    }

    public function save_multi() {
        $count_rows = $this->input->post('count_rows');

        $count_success = 0;
        $count_error = 0;

        for ($i=0; $i < (int) $count_rows; $i++) { 
            $codi_gre = $this->input->post('codi_gre_'.$i);
            $nume_res = $this->input->post('nume_res_'.$i);
            $fech_res = $this->input->post('fech_res_'.$i);
            $desc_res = $this->input->post('desc_res_'.$i);
            $docu_res = 'docu_res_'.$i;
            if ($nume_res != "" && $fech_res != "" && $desc_res != "" 
                && isset($_FILES[$docu_res]['name']) && !empty($_FILES[$docu_res]['name'])) {

                if ($this->mod_resolucion->check_nume_res($nume_res, date("Y", strtotime($fech_res))) == "true") {
                    $config['upload_path'] = './assets/resoluciones/';
                    $config['allowed_types'] = 'pdf|doc|docx';
                    $config['overwrite'] = true;
                    $config['max_width'] = 0;
                    $config['max_height'] = 0;
                    $config['max_size'] = 20000;
                    $config['file_name'] = urlencode($nume_res);

                    $this->load->library('upload', $config);
                    if ( ! $this->upload->do_upload($docu_res)) {
                        $count_error++;
                    } else {
                        $data = array(
                            'nume_res' => $nume_res,
                            'fech_res' => $fech_res,
                            'desc_res' => $desc_res,
                            'docu_res' => $this->upload->data()["file_name"],
                            'exte_res' => $this->upload->data()["file_ext"],
                            'codi_gre' => $codi_gre,
                            'esta_res' => '1'
                        );
                        $codi_res = $this->mod_resolucion->save($data);

                        $count_success++;
                    }
                } else {
                    $count_error++;
                }

            }
        }

        $type_system = "info";
        if ($count_error != 0 && $count_success != 0) {
            $message_system = $count_success. " resolucion(es) registradas con éxito y " . $count_error . " resolucion(es) con error(es).";
        } else if ($count_error == 0 && $count_success != 0) {
            $message_system = $count_success. " resolucion(es) registradas con éxito.";
        } else if ($count_error != 0 && $count_success == 0) {
            $message_system = $count_error . " resolucion(es) con error(es).";
        }
        
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('resolucion'));
    }

    public function update() {
        $codi_res = $this->input->post('codi_res');
        $nume_res = $this->input->post('nume_res');
        $fech_res = $this->input->post('fech_res');
        if ($this->mod_resolucion->check_nume_res_actualizar($codi_res, $nume_res, date("Y", strtotime($fech_res))) == "true") {
            $resolucion = $this->mod_resolucion->get_resolucion_row(array("codi_res" => $codi_res));

            $desc_res = $this->input->post('desc_res');
            $codi_gre = $this->input->post('codi_gre');

            $data = array(
                'nume_res' => $nume_res,
                'fech_res' => $fech_res,
                'desc_res' => $desc_res,
                'codi_gre' => $codi_gre
            );

            if ($resolucion->nume_res != $nume_res) {
                $new_url = urlencode($nume_res.$resolucion->exte_res);
                rename("./assets/resoluciones/".$resolucion->docu_res, "./assets/resoluciones/".$new_url);
                $data["docu_res"] = $new_url;
            }

            $type_system = "success";
            $message_system = "La resolución $nume_res ha sido actualizado con éxito";

            if (file_exists($_FILES['docu_res']['tmp_name']) && is_uploaded_file($_FILES['docu_res']['tmp_name'])) {
                $config['upload_path'] = './assets/resoluciones/';
                $config['allowed_types'] = 'pdf|doc|docx';
                $config['overwrite'] = true;
                $config['max_width'] = 0;
                $config['max_height'] = 0;
                $config['max_size'] = 20000;
                $config['file_name'] = $nume_res;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('docu_res')) {
                    $type_system = "error";
                    $message_system = $this->upload->display_errors();
                } else {
                    $data["docu_res"] = $this->upload->data()["file_name"];
                }
            }

            $this->mod_resolucion->update($codi_res, $data);
        } else {
            $type_system = "error";
            $message_system = "El número de resolución $nume_res ya existe";
        }
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('resolucion'));
    }

    public function habilitar() {
        $codi_res = $this->input->post('codi_res');
        $data = array(
            'esta_res' => '1'
        );
        $this->mod_resolucion->update($codi_res, $data);

        $type_system = "success";
        $message_system = "Resolución habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('resolucion'));
    }

    public function deshabilitar() {
        $codi_res = $this->input->post('codi_res');
        $data = array(
            'esta_res' => '0'
        );
        $this->mod_resolucion->update($codi_res, $data);

        $type_system = "success";
        $message_system = "Resolución deshabilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('resolucion'));
    }

    public function eliminar() {
        $codi_res = $this->input->post('codi_res');
        $data = array(
            'esta_res' => '-1'
        );
        $this->mod_resolucion->update($codi_res, $data);

        $type_system = "success";
        $message_system = "Resolución eliminado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('resolucion'));
    }


    // GRUPO DE RESOLUCIONES

    public function grupo() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_GRUPO_RESOLUCION)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/resolucion.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/clipboard/clipboard.min.js"></script>';

            $this->scripts[] = '<script src="'.asset_url().'js/grupo_resolucion.js"></script>';

            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("resolucion/search_grupo", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate_grupo() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_GRUPO_RESOLUCION)) {
            $nTotal = $this->mod_resolucion->count_all_grupo();

            $data = $this->mod_resolucion->get_paginate_grupo($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_GRUPO_RESOLUCION)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_gre == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_GRUPO_RESOLUCION)) {
                        $opciones.= '<form method="post" class="deshabilitar_grupo_resolucion" action="'.base_url('grupo_resolucion/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_gre" value="'.$row->codi_gre.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_gre == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_GRUPO_RESOLUCION)) {
                        $opciones.= '<form method="post" class="habilitar_grupo_resolucion" action="'.base_url('grupo_resolucion/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_gre" value="'.$row->codi_gre.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                $opciones .= '<button type="button" class="btn btn-info btn-preview" data-toggle="tooltip" data-placement="top" title="Enlace a portal"><i class="fa fa-link" aria-hidden="true"></i></button>&nbsp;';

                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_GRUPO_RESOLUCION)) {
                        $opciones.= '<form method="post" class="eliminar_grupo_resolucion" action="'.base_url('grupo_resolucion/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_gre" value="'.$row->codi_gre.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_gre" => $row->codi_gre,
                    "nomb_gre" => $row->nomb_gre,
                    "link_res" => base_url().'resolucion/'.$row->codi_gre,
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

    public function check_nomb_gre() {
        echo $this->mod_resolucion->check_nomb_gre($this->input->post('nomb_gre'));
    }

    public function check_nomb_gre_actualizar() {
        echo $this->mod_resolucion->check_nomb_gre_actualizar($this->input->post('codi_gre'), $this->input->post('nomb_gre'));
    }

    public function save_grupo() {
        $nomb_gre = $this->input->post('nomb_gre');

        $data = array(
            'nomb_gre' => $nomb_gre,
            'esta_gre' => '1'
        );
        
        if ($this->mod_resolucion->check_nomb_gre($nomb_gre) == "true") {
            $codi_gre = $this->mod_resolucion->save_grupo($data);

            $type_system = "success";
            $message_system = "El grupo de resolución $nomb_gre ha sido registrado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El nombre de grupo $nomb_gre ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_resolucion'));
    }

    public function update_grupo() {
        $codi_gre = $this->input->post('codi_gre');
        $nomb_gre = $this->input->post('nomb_gre');

        $data = array(
            'nomb_gre' => $nomb_gre
        );

        if ($this->mod_resolucion->check_nomb_gre_actualizar($codi_gre, $nomb_gre) == "true") {
            $this->mod_resolucion->update_grupo($codi_gre, $data);

            $type_system = "success";
            $message_system = "El grupo de resolución $nomb_gre ha sido actualizado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El nombre de grupo $nomb_gre ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_resolucion'));
    }

    public function habilitar_grupo() {
        $codi_gre = $this->input->post('codi_gre');
        $data = array(
            'esta_gre' => '1'
        );
        $this->mod_resolucion->update_grupo($codi_gre, $data);

        $type_system = "success";
        $message_system = "Grupo de resolución habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_resolucion'));
    }

    public function deshabilitar_grupo() {
        $codi_gre = $this->input->post('codi_gre');
        $data = array(
            'esta_gre' => '0'
        );
        $this->mod_resolucion->update_grupo($codi_gre, $data);

        $type_system = "success";
        $message_system = "Grupo de resolución deshabilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_resolucion'));
    }

    public function eliminar_grupo() {
        $codi_gre = $this->input->post('codi_gre');
        $data = array(
            'esta_gre' => '-1'
        );
        $this->mod_resolucion->update_grupo($codi_gre, $data);

        $type_system = "success";
        $message_system = "Grupo de resolución eliminado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('grupo_resolucion'));
    }

    // PUBLICO

    public function resolucion($codi_gre) {
        $resolucion = $this->mod_resolucion->get_grupo_resolucion_row(array("codi_gre" => $codi_gre, "esta_gre" => "1"));
        if ($resolucion) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/resolucion_portal.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'js/resolucion_portal.js"></script>';

            // Imprimir vista con datos
            $data["codi_gre"] = $codi_gre;
            $data["nomb_gre"] = $resolucion->nomb_gre;
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("portal/resolucion", $data, true);
            $this->load->view("template/body_portal", $component);
        } else {
            echo "Página no encontrada";
        }
    }

    public function paginate_portal() {

        $codi_gre = $_POST['codi_gre'];
        $year_res = $_POST['year_res'];

        $nTotal = $this->mod_resolucion->count_all_portal($codi_gre);

        $data = $this->mod_resolucion->get_paginate_portal($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch'], $codi_gre, $year_res, $_POST);

        $aaData = array();

        foreach ($data as $row) {


            $docu_res = '<a href="'.asset_url().'resoluciones/'.$row->docu_res.'" target="_blank" class="btn btn-info btn-download" data-toggle="tooltip" data-placement="top" title="Descargar documento"><i class="fa fa-download" aria-hidden="true"></i></a>&nbsp;';


            $aaData[] = array(
                "nume_res" => $row->nume_res,
                "fech_res_d" => date("d/m/Y", strtotime($row->fech_res)),
                "desc_res" => '<div style="text-align: left; font-size: 11px; height: 50px; overflow-y: scroll;">'.$row->desc_res."</div>",
                "docu_res" => $docu_res
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
