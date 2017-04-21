<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EventoController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_evento"));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_EVENTO)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/summernote/dist/summernote.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/evento.css" rel="stylesheet">';
            
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
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';

            $this->scripts[] = '<script src="'.asset_url().'js/evento.js"></script>';


            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("evento/search", $data, true);
            
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_EVENTO)) {
            $nTotal = $this->mod_evento->count_all();

            $data = $this->mod_evento->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_EVENTO)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_eve == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_EVENTO)) {
                        $opciones.= '<form method="post" class="deshabilitar_evento" action="'.base_url('evento/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_eve" value="'.$row->codi_eve.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_eve == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_EVENTO)) {
                        $opciones.= '<form method="post" class="habilitar_evento" action="'.base_url('evento/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_eve" value="'.$row->codi_eve.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                $opciones .= '<a href="'.base_url().'evento/'.$row->codi_eve.'" class="btn btn-info btn-preview" data-toggle="tooltip" data-placement="top" title="Ver evento"><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp;';
                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_EVENTO)) {
                        $opciones.= '<form method="post" class="eliminar_evento" action="'.base_url('evento/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_eve" value="'.$row->codi_eve.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_eve" => $row->codi_eve,
                    "nomb_usu" => $row->nomb_usu,
                    "titu_eve" => $row->titu_eve,
                    "imag_eve" => asset_url()."evento/".$row->imag_eve,
                    "nume_eve" => $row->nume_eve,
                    "fech_eve" => $row->fech_eve,
                    "fech_eve_d" => date("d/m/Y h:i A", strtotime($row->fech_eve)),
                    "cont_eve" => $row->cont_eve,
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

    public function check_nume_eve() {
        echo $this->mod_evento->check_nume_eve($this->input->post('nume_eve'));
    }

    public function check_nume_eve_actualizar() {
        echo $this->mod_evento->check_nume_eve_actualizar($this->input->post('codi_eve'), $this->input->post('nume_eve'));
    }

    public function uploadImage() {
        $config['upload_path'] = './assets/evento/imagenes_evento/';
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

    public function lista_evento($page = 1) { 
        $size = 5;
        $start = (int) $page * $size - $size;

        $data["count"] = $this->mod_evento->count_eventos();
        $data["eventos"] = $this->mod_evento->get_list_eventos($start, $size);
        $data["page"] = $page;
        $data["pages"] = ceil($data["count"]/$size);
        

        $this->scripts[] = '<script src="'.asset_url().'js/evento_page.js"></script>';
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("evento/page", $data, true);
        $this->load->view("template/body_main", $component, $data);

        /*
        echo "<pre>";
        print_r($eventos);
        echo "</pre>";
        */
    }

    public function save() {
        $codi_usu = $this->session->userdata("usuario")->codi_usu;
        $fech_eve = $this->input->post('fech_eve');
        $nume_eve = $this->input->post('nume_eve');
        $titu_eve = $this->input->post('titu_eve');
        $cont_eve = $this->input->post('cont_eve');

        if ($this->mod_evento->check_nume_eve($nume_eve) == "true") {
            $config['upload_path'] = './assets/evento/';
            $config['allowed_types'] = 'jpg|png';
            $config['overwrite'] = true;
            $config['max_width'] = 20000;
            $config['max_height'] = 0;
            $config['max_size'] = 0;
            $config['file_name'] = urlencode($nume_eve);

            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('imag_eve')) {
                $type_system = "error";
                $message_system = $this->upload->display_errors();
            } else {
                $data = array(
                    'codi_usu' => $codi_usu,
                    'fech_eve' => $fech_eve,
                    'titu_eve' => $titu_eve,
                    'nume_eve' => $nume_eve,
                    'cont_eve' => $cont_eve,
                    'imag_eve' => $this->upload->data()["file_name"],
                    'exte_eve' => $this->upload->data()["file_ext"],
                    'esta_eve' => '1'
                );
                
                $codi_eve = $this->mod_evento->save($data);

                $type_system = "success";
                $message_system = "El evento ha sido registrado con éxito";

                $fb = new Facebook\Facebook([
                  'app_id' => APP_ID_FB,
                  'app_secret' => APP_SECRET_FB,
                  'default_graph_version' => 'v2.2',
                  ]);

                $linkData = [
                  'link' => base_url().'evento/'.$codi_eve,
                  'message' => $titu_eve,
                  ];

                try {
                  $response = $fb->post('/182498662244220/feed', $linkData, ACCESS_TOKEN_FB);
                  $graphNode = $response->getGraphNode();

                  $this->mod_evento->update($codi_eve, array('id_fb' => $graphNode['id']));
                  $message_system = "El evento ha sido registrado y publicado en página de Facebook DRAL con éxito";
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                   $message_system = "El evento ha sido registrado con éxito pero no se pudo publicar en Facebook";
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                   $message_system = "El evento ha sido registrado con éxito pero no se pudo publicar en Facebook";
                }
            }
        } else {
            $type_system = "error";
            $message_system = "El evento $nume_eve ya existe";
        }
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('evento'));
    }

    public function update() {
        $codi_eve = $this->input->post('codi_eve');
        $fech_eve = $this->input->post('fech_eve');
        $titu_eve = $this->input->post('titu_eve');
        $nume_eve = $this->input->post('nume_eve');
        $cont_eve = $this->input->post('cont_eve');

        if ($this->mod_evento->check_nume_eve_actualizar($codi_eve, $nume_eve) == "true") {
            $evento = $this->mod_evento->get_evento_row(array("codi_eve" => $codi_eve));

            $data = array(
                'nume_eve' => $nume_eve,
                'titu_eve' => $titu_eve,
                'fech_eve' => $fech_eve,
                'cont_eve' => $cont_eve
            );

            if ($evento->nume_eve != $nume_eve) {
                $new_url = urlencode($nume_eve.$evento->exte_eve);
                rename("./assets/evento/".$evento->imag_eve, "./assets/evento/".$new_url);
                $data["imag_eve"] = $new_url;
            }

            $type_system = "success";
            $message_system = "El evento ha sido actualizada con éxito";

            if (file_exists($_FILES['imag_eve']['tmp_name']) && is_uploaded_file($_FILES['imag_eve']['tmp_name'])) {
                $config['upload_path'] = './assets/evento/';
                $config['allowed_types'] = 'jpg|png';
                $config['overwrite'] = true;
                $config['max_width'] = 0;
                $config['max_height'] = 0;
                $config['max_size'] = 20000;
                $config['file_name'] = $nume_eve;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('imag_eve')) {
                    $type_system = "error";
                    $message_system = $this->upload->display_errors();
                } else {
                    $data["imag_eve"] = $this->upload->data()["file_name"];
                    $data["exte_eve"] = $this->upload->data()["file_ext"];
                }
            }

            $this->mod_evento->update($codi_eve, $data);
        } else {
            $type_system = "error";
            $message_system = "El evento $nume_eve ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('evento'));
    }

    public function habilitar() {
        $codi_eve = $this->input->post('codi_eve');
        $data = array(
            'esta_eve' => '1'
        );
        $this->mod_evento->update($codi_eve, $data);

        $type_system = "success";
        $message_system = "Evento habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('evento'));
    }

    public function deshabilitar() {
        $codi_eve = $this->input->post('codi_eve');
        $data = array(
            'esta_eve' => '0'
        );
        $this->mod_evento->update($codi_eve, $data);

        $type_system = "success";
        $message_system = "Evento deshabilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('evento'));
    }

    public function eliminar() {
        $codi_eve = $this->input->post('codi_eve');
        $data = array(
            'esta_eve' => '-1'
        );
        $this->mod_evento->update($codi_eve, $data);

        $type_system = "success";
        $message_system = "Evento eliminada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('evento'));
    }

    public function evento($codi_eve) {
        $evento = $this->mod_evento->get_evento_row(array("codi_eve" => $codi_eve, "esta_eve" => "1"));
        if ($evento) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'js/evento_public.js"></script>';


            $data["pageId"] = "182498662244220";
            $data["title"] = $evento->titu_eve;
            $data["description"] = strip_tags($evento->cont_eve);
            $data["img"] = asset_url() . "evento/" . $evento->imag_eve;

            // Imprimir vista con datos
            $data["evento"] = $evento;
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("evento/single", $data, true);
            $this->load->view("template/body_main", $component, $data);
        } else {
            echo "Página no encontrada";
        }
    }

}
