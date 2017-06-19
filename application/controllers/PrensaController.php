<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PrensaController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_prensa"));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_NOTICIA)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/summernote/dist/summernote.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/noticia.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/summernote/dist/summernote.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/summernote/dist/lang/summernote-es-ES.js"></script>';

            $this->scripts[] = '<script src="'.asset_url().'js/noticia.js"></script>';


            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("noticia/search", $data, true);
            
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_NOTICIA)) {
            $nTotal = $this->mod_prensa->count_all($_POST['sSearch']);

            $data = $this->mod_prensa->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_NOTICIA)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_not == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_NOTICIA)) {
                        $opciones.= '<form method="post" class="deshabilitar_noticia" action="'.base_url('noticia/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_not" value="'.$row->codi_not.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_not == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_NOTICIA)) {
                        $opciones.= '<form method="post" class="habilitar_noticia" action="'.base_url('noticia/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_not" value="'.$row->codi_not.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                $opciones .= '<a href="'.base_url().'noticia/'.$row->codi_not.'" class="btn btn-info btn-preview" data-toggle="tooltip" data-placement="top" title="Ver noticia"><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp;';
                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_NOTICIA)) {
                        $opciones.= '<form method="post" class="eliminar_noticia" action="'.base_url('noticia/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_not" value="'.$row->codi_not.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_not" => $row->codi_not,
                    "nomb_usu" => $row->nomb_usu,
                    "titu_not" => $row->titu_not,
                    "imag_not" => asset_url()."noticia/".$row->imag_not,
                    "nume_not" => $row->nume_not,
                    "fech_not" => $row->fech_not,
                    "fech_not_d" => date("d/m/Y h:i A", strtotime($row->fech_not)),
                    "cont_not" => $row->cont_not,
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

    public function check_nume_not() {
        echo $this->mod_prensa->check_nume_not($this->input->post('nume_not'));
    }

    public function check_nume_not_actualizar() {
        echo $this->mod_prensa->check_nume_not_actualizar($this->input->post('codi_not'), $this->input->post('nume_not'));
    }

    public function uploadImage() {
        $config['upload_path'] = './assets/noticia/imagenes_noticia/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['overwrite'] = false;
        $config['max_width'] = 20000;
        $config['max_height'] = 0;
        $config['max_size'] = 0;

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('image')) {
            echo json_encode(array("status" => "error", "result" => $this->upload->display_errors()));
        } else {
            echo json_encode(array("status" => "success", "result" => $this->upload->data()["file_name"]));
        }
    }

    public function lista_noticia($page = 1) { 
        $size = 5;
        $start = (int) $page * $size - $size;

        $data["count"] = $this->mod_prensa->count_noticias();
        $data["noticias"] = $this->mod_prensa->get_list_noticias($start, $size);
        $data["page"] = $page;
        $data["pages"] = ceil($data["count"]/$size);
        

        $this->scripts[] = '<script src="'.asset_url().'js/noticia_page.js"></script>';
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("noticia/page", $data, true);
        $this->load->view("template/body_main", $component, $data);

        /*
        echo "<pre>";
        print_r($noticias);
        echo "</pre>";
        */
    }

    public function save() {
        $codi_usu = $this->session->userdata("usuario")->codi_usu;
        $fech_not = $this->input->post('fech_not');
        $nume_not = $this->input->post('nume_not');
        $titu_not = $this->input->post('titu_not');
        $cont_not = $this->input->post('cont_not');

        if ($this->mod_prensa->check_nume_not($nume_not) == "true") {
            $config['upload_path'] = './assets/noticia/';
            $config['allowed_types'] = 'jpg|png';
            $config['overwrite'] = true;
            $config['max_width'] = 20000;
            $config['max_height'] = 0;
            $config['max_size'] = 0;
            $config['file_name'] = urlencode($nume_not);

            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('imag_not')) {
                $type_system = "error";
                $message_system = $this->upload->display_errors();
            } else {
                $data = array(
                    'codi_usu' => $codi_usu,
                    'fech_not' => $fech_not,
                    'titu_not' => $titu_not,
                    'nume_not' => $nume_not,
                    'cont_not' => $cont_not,
                    'imag_not' => $this->upload->data()["file_name"],
                    'exte_not' => $this->upload->data()["file_ext"],
                    'esta_not' => '1'
                );
                
                $codi_not = $this->mod_prensa->save($data);

                $type_system = "success";
                $message_system = "La noticia ha sido registrado con éxito";

                $fb = new Facebook\Facebook([
                  'app_id' => APP_ID_FB,
                  'app_secret' => APP_SECRET_FB,
                  'default_graph_version' => 'v2.2',
                  ]);

                $linkData = [
                  'link' => base_url().'noticia/'.$codi_not,
                  'message' => $titu_not,
                  ];

                try {
                  $response = $fb->post('/182498662244220/feed', $linkData, ACCESS_TOKEN_FB);
                  $graphNode = $response->getGraphNode();

                  $this->mod_prensa->update($codi_not, array('id_fb' => $graphNode['id']));
                  $message_system = "La noticia ha sido registrado y publicado en página de Facebook DRAL con éxito";
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                   $message_system = "La noticia ha sido registrado con éxito pero no se pudo publicar en Facebook";
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                   $message_system = "La noticia ha sido registrado con éxito pero no se pudo publicar en Facebook";
                }
            }
        } else {
            $type_system = "error";
            $message_system = "La noticia $nume_not ya existe";
        }
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('noticia'));
    }

    public function update() {
        $codi_not = $this->input->post('codi_not');
        $fech_not = $this->input->post('fech_not');
        $titu_not = $this->input->post('titu_not');
        $nume_not = $this->input->post('nume_not');
        $cont_not = $this->input->post('cont_not');

        if ($this->mod_prensa->check_nume_not_actualizar($codi_not, $nume_not) == "true") {
            $noticia = $this->mod_prensa->get_noticia_row(array("codi_not" => $codi_not));

            $data = array(
                'nume_not' => $nume_not,
                'titu_not' => $titu_not,
                'fech_not' => $fech_not,
                'cont_not' => $cont_not
            );

            if ($noticia->nume_not != $nume_not) {
                $new_url = urlencode($nume_not.$noticia->exte_not);
                rename("./assets/noticia/".$noticia->imag_not, "./assets/noticia/".$new_url);
                $data["imag_not"] = $new_url;
            }

            $type_system = "success";
            $message_system = "La noticia ha sido actualizada con éxito";

            if (file_exists($_FILES['imag_not']['tmp_name']) && is_uploaded_file($_FILES['imag_not']['tmp_name'])) {
                $config['upload_path'] = './assets/noticia/';
                $config['allowed_types'] = 'jpg|png';
                $config['overwrite'] = true;
                $config['max_width'] = 0;
                $config['max_height'] = 0;
                $config['max_size'] = 20000;
                $config['file_name'] = $nume_not;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('imag_not')) {
                    $type_system = "error";
                    $message_system = $this->upload->display_errors();
                } else {
                    $data["imag_not"] = $this->upload->data()["file_name"];
                    $data["exte_not"] = $this->upload->data()["file_ext"];
                }
            }

            $this->mod_prensa->update($codi_not, $data);
        } else {
            $type_system = "error";
            $message_system = "La noticia $nume_not ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('noticia'));
    }

    public function habilitar() {
        $codi_not = $this->input->post('codi_not');
        $data = array(
            'esta_not' => '1'
        );
        $this->mod_prensa->update($codi_not, $data);

        $type_system = "success";
        $message_system = "Noticia habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('noticia'));
    }

    public function deshabilitar() {
        $codi_not = $this->input->post('codi_not');
        $data = array(
            'esta_not' => '0'
        );
        $this->mod_prensa->update($codi_not, $data);

        $type_system = "success";
        $message_system = "Noticia deshabilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('noticia'));
    }

    public function eliminar() {
        $codi_not = $this->input->post('codi_not');
        $data = array(
            'esta_not' => '-1'
        );
        $this->mod_prensa->update($codi_not, $data);

        $type_system = "success";
        $message_system = "Noticia eliminada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('noticia'));
    }

    public function noticia($codi_not) {
        $noticia = $this->mod_prensa->get_noticia_row(array("codi_not" => $codi_not, "esta_not" => "1"));
        if ($noticia) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'js/noticia_public.js"></script>';


            $data["pageId"] = "182498662244220";
            $data["title"] = $noticia->titu_not;
            $data["description"] = strip_tags($noticia->cont_not);
            $data["img"] = asset_url() . "noticia/" . $noticia->imag_not;

            // Imprimir vista con datos
            $data["noticia"] = $noticia;
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("noticia/single", $data, true);
            $this->load->view("template/body_main", $component, $data);
        } else {
            echo "Página no encontrada";
        }
    }

}
