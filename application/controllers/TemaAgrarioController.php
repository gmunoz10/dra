<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TemaAgrarioController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_tema_agrario"));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_TEMA_AGRARIO)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/summernote/dist/summernote.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/tema_agrario.css" rel="stylesheet">';
            
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

            $this->scripts[] = '<script src="'.asset_url().'js/tema_agrario.js"></script>';


            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("tema_agrario/search", $data, true);
            
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_TEMA_AGRARIO)) {
            $nTotal = $this->mod_tema_agrario->count_all();

            $data = $this->mod_tema_agrario->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_TEMA_AGRARIO)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_tea == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_TEMA_AGRARIO)) {
                        $opciones.= '<form method="post" class="deshabilitar_tema_agrario" action="'.base_url('tema_agrario/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_tea" value="'.$row->codi_tea.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_tea == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_TEMA_AGRARIO)) {
                        $opciones.= '<form method="post" class="habilitar_tema_agrario" action="'.base_url('tema_agrario/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_tea" value="'.$row->codi_tea.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                $opciones .= '<a href="'.base_url().'tema_agrario/'.$row->codi_tea.'" class="btn btn-info btn-preview" data-toggle="tooltip" data-placement="top" title="Ver tema agrario"><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp;';
                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_TEMA_AGRARIO)) {
                        $opciones.= '<form method="post" class="eliminar_tema_agrario" action="'.base_url('tema_agrario/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_tea" value="'.$row->codi_tea.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_tea" => $row->codi_tea,
                    "nomb_usu" => $row->nomb_usu,
                    "titu_tea" => $row->titu_tea,
                    "imag_tea" => asset_url()."tema_agrario/".$row->imag_tea,
                    "nume_tea" => $row->nume_tea,
                    "fech_tea" => $row->fech_tea,
                    "fech_tea_d" => date("d/m/Y h:i A", strtotime($row->fech_tea)),
                    "cont_tea" => $row->cont_tea,
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

    public function check_nume_tea() {
        echo $this->mod_tema_agrario->check_nume_tea($this->input->post('nume_tea'));
    }

    public function check_nume_tea_actualizar() {
        echo $this->mod_tema_agrario->check_nume_tea_actualizar($this->input->post('codi_tea'), $this->input->post('nume_tea'));
    }

    public function uploadImage() {
        $config['upload_path'] = './assets/tema_agrario/';
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

    public function lista_tema_agrario($page = 1) { 
        $size = 5;
        $start = (int) $page * $size - $size;

        $data["count"] = $this->mod_tema_agrario->count_tema_agrarios();
        $data["tema_agrarios"] = $this->mod_tema_agrario->get_list_tema_agrarios($start, $size);
        $data["page"] = $page;
        $data["pages"] = ceil($data["count"]/$size);
        

        $this->scripts[] = '<script src="'.asset_url().'js/tema_agrario_page.js"></script>';
        // Imprimir vista con datos
        $data["styles"] = $this->styles;
        $data["scripts"] = $this->scripts;
        $component["content"] = $this->load->view("tema_agrario/page", $data, true);
        $this->load->view("template/body_main", $component, $data);

        /*
        echo "<pre>";
        print_r($tema_agrarios);
        echo "</pre>";
        */
    }

    public function save() {
        $codi_usu = $this->session->userdata("usuario")->codi_usu;
        $fech_tea = $this->input->post('fech_tea');
        $nume_tea = $this->input->post('nume_tea');
        $titu_tea = $this->input->post('titu_tea');
        $cont_tea = $this->input->post('cont_tea');

        if ($this->mod_tema_agrario->check_nume_tea($nume_tea) == "true") {
            $config['upload_path'] = './assets/tema_agrario/';
            $config['allowed_types'] = 'jpg|png';
            $config['overwrite'] = true;
            $config['max_width'] = 20000;
            $config['max_height'] = 0;
            $config['max_size'] = 0;
            $config['file_name'] = urlencode($nume_tea);

            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('imag_tea')) {
                $type_system = "error";
                $message_system = $this->upload->display_errors();
            } else {
                $data = array(
                    'codi_usu' => $codi_usu,
                    'fech_tea' => $fech_tea,
                    'titu_tea' => $titu_tea,
                    'nume_tea' => $nume_tea,
                    'cont_tea' => $cont_tea,
                    'imag_tea' => $this->upload->data()["file_name"],
                    'exte_tea' => $this->upload->data()["file_ext"],
                    'esta_tea' => '1'
                );
                
                $codi_tea = $this->mod_tema_agrario->save($data);

                $type_system = "success";
                $message_system = "El tema agrario ha sido registrado con éxito";

                $fb = new Facebook\Facebook([
                  'app_id' => APP_ID_FB,
                  'app_secret' => APP_SECRET_FB,
                  'default_graph_version' => 'v2.2',
                  ]);

                $linkData = [
                  'link' => base_url().'tema_agrario/'.$codi_tea,
                  'message' => $titu_tea,
                  ];

                try {
                  $response = $fb->post('/182498662244220/feed', $linkData, ACCESS_TOKEN_FB);
                  $graphNode = $response->getGraphNode();

                  $this->mod_tema_agrario->update($codi_tea, array('id_fb' => $graphNode['id']));
                  $message_system = "El tema agrario ha sido registrado y publicado en página de Facebook DRAL con éxito";
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                   $message_system = "El tema agrario ha sido registrado con éxito pero no se pudo publicar en Facebook";
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                   $message_system = "El tema agrario ha sido registrado con éxito pero no se pudo publicar en Facebook";
                }
            }
        } else {
            $type_system = "error";
            $message_system = "El tema agrario $nume_tea ya existe";
        }
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('tema_agrario'));
    }

    public function update() {
        $codi_tea = $this->input->post('codi_tea');
        $fech_tea = $this->input->post('fech_tea');
        $titu_tea = $this->input->post('titu_tea');
        $nume_tea = $this->input->post('nume_tea');
        $cont_tea = $this->input->post('cont_tea');

        if ($this->mod_tema_agrario->check_nume_tea_actualizar($codi_tea, $nume_tea) == "true") {
            $tema_agrario = $this->mod_tema_agrario->get_tema_agrario_row(array("codi_tea" => $codi_tea));

            $data = array(
                'nume_tea' => $nume_tea,
                'titu_tea' => $titu_tea,
                'fech_tea' => $fech_tea,
                'cont_tea' => $cont_tea
            );

            if ($tema_agrario->nume_tea != $nume_tea) {
                $new_url = urlencode($nume_tea.$tema_agrario->exte_tea);
                rename("./assets/tema_agrario/".$tema_agrario->imag_tea, "./assets/tema_agrario/".$new_url);
                $data["imag_tea"] = $new_url;
            }

            $type_system = "success";
            $message_system = "El tema agrario ha sido actualizada con éxito";

            if (file_exists($_FILES['imag_tea']['tmp_name']) && is_uploaded_file($_FILES['imag_tea']['tmp_name'])) {
                $config['upload_path'] = './assets/tema_agrario/';
                $config['allowed_types'] = 'jpg|png';
                $config['overwrite'] = true;
                $config['max_width'] = 0;
                $config['max_height'] = 0;
                $config['max_size'] = 20000;
                $config['file_name'] = $nume_tea;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('imag_tea')) {
                    $type_system = "error";
                    $message_system = $this->upload->display_errors();
                } else {
                    $data["imag_tea"] = $this->upload->data()["file_name"];
                    $data["exte_tea"] = $this->upload->data()["file_ext"];
                }
            }

            $this->mod_tema_agrario->update($codi_tea, $data);
        } else {
            $type_system = "error";
            $message_system = "El tema agrario $nume_tea ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('tema_agrario'));
    }

    public function habilitar() {
        $codi_tea = $this->input->post('codi_tea');
        $data = array(
            'esta_tea' => '1'
        );
        $this->mod_tema_agrario->update($codi_tea, $data);

        $type_system = "success";
        $message_system = "Evento habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('tema_agrario'));
    }

    public function deshabilitar() {
        $codi_tea = $this->input->post('codi_tea');
        $data = array(
            'esta_tea' => '0'
        );
        $this->mod_tema_agrario->update($codi_tea, $data);

        $type_system = "success";
        $message_system = "Evento deshabilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('tema_agrario'));
    }

    public function eliminar() {
        $codi_tea = $this->input->post('codi_tea');
        $data = array(
            'esta_tea' => '-1'
        );
        $this->mod_tema_agrario->update($codi_tea, $data);

        $type_system = "success";
        $message_system = "Evento eliminada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('tema_agrario'));
    }

    public function tema_agrario($codi_tea) {
        $tema_agrario = $this->mod_tema_agrario->get_tema_agrario_row(array("codi_tea" => $codi_tea, "esta_tea" => "1"));
        if ($tema_agrario) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'js/tema_agrario_public.js"></script>';


            $data["pageId"] = "182498662244220";
            $data["title"] = $tema_agrario->titu_tea;
            $data["description"] = strip_tags($tema_agrario->cont_tea);
            $data["img"] = asset_url() . "tema_agrario/" . $tema_agrario->imag_tea;

            // Imprimir vista con datos
            $data["tema_agrario"] = $tema_agrario;
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("tema_agrario/single", $data, true);
            $this->load->view("template/body_main", $component, $data);
        } else {
            echo "Página no encontrada";
        }
    }

}
