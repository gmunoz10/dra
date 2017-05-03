<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GaleriaController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_galeria", "mod_permiso"));
        $this->load->helper('cookie');
        $this->load->library('image_lib');
    }

    public function admin($page = 1) {
        $size = 3;
        $start = (int) $page * $size - $size;

        if (isset($_GET["search"]) && $_GET["search"] != "") {
            $data['search'] = $_GET["search"];
        } else {
            $data['search'] = "";
        }

        $data["count"] = $this->mod_galeria->count_album($data['search']);
        $data["albumes"] = $this->mod_galeria->get_list_album($data['search'], $start, $size);
        foreach ($data["albumes"] as $key => $album) {
            $data["albumes"][$key]->imagenes = $this->mod_galeria->get_imagenes_album($album->codi_alb);
        }
        $data["page"] = $page;
        $data["pages"] = ceil($data["count"]/$size);

        if ($this->session->userdata("usuario") && check_permission(BUSCAR_ALBUM_IMAGEN)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/lightbox/dist/ekko-lightbox.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-fileinput/css/fileinput.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-fileinput/themes/explorer/theme.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/galeria_admin.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-fileinput/js/fileinput.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-fileinput/js/locales/dral.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-fileinput/themes/explorer/theme.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/lightbox/dist/ekko-lightbox.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/moment/moment-with-locales.min.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>';

            $this->scripts[] = '<script src="'.asset_url().'js/galeria_admin.js"></script>';

            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("galeria/search", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function save_album() {
        if ($this->session->userdata("usuario") && check_permission(REGISTRAR_ALBUM_IMAGEN)) {
            $titu_alb = $this->input->post('titu_alb');
            $fech_alb = $this->input->post('fech_alb');
            $codi_usu = $this->session->userdata("usuario")->codi_usu;

            $data = array(
                'titu_alb' => $titu_alb,
                'codi_usu' => $codi_usu,
                'fech_alb' => $fech_alb,
                'esta_alb' => "1"
            );
            $codi_alb = $this->mod_galeria->save_album($data);

            $config['upload_path'] = './assets/galeria/';
            $config['allowed_types'] = 'png|jpg';
            $config['max_size'] = 20000;
            $config['overwrite'] = false;

            $this->load->library('upload', $config);

            $filesCount = count($_FILES['imag_ial']['name']);
            $images_posted = [];
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['imagen']['name'] = $_FILES['imag_ial']['name'][$i];
                $_FILES['imagen']['type'] = $_FILES['imag_ial']['type'][$i];
                $_FILES['imagen']['tmp_name'] = $_FILES['imag_ial']['tmp_name'][$i];
                $_FILES['imagen']['error'] = $_FILES['imag_ial']['error'][$i];
                $_FILES['imagen']['size'] = $_FILES['imag_ial']['size'][$i];

                if($this->upload->do_upload('imagen')){
                    $fileData = $this->upload->data();

                    $configer =  array(
                      'image_library'   => 'gd2',
                      'source_image'    =>  $fileData['full_path'],
                      'maintain_ratio'  =>  TRUE,
                      'width'           =>  400,
                      'height'          =>  400,
                    );
                    $this->image_lib->clear();
                    $this->image_lib->initialize($configer);
                    $this->image_lib->resize();

                    $data_img = array(
                        'imag_ial' => $fileData['file_name'],
                        'codi_usu' => $codi_usu,
                        'codi_alb' => $codi_alb,
                        'fech_ial' => date("Y-m-d H:i"),
                        'esta_ial' => "1"
                    );
                    $this->mod_galeria->save($data_img);

                    $fb = new Facebook\Facebook([
                      'app_id' => APP_ID_FB,
                      'app_secret' => APP_SECRET_FB,
                      'default_graph_version' => 'v2.2',
                      ]);

                    try {
                        $response = $fb->post('/182498662244220/photos', ['published' => 'false', 'url' => asset_url() . 'galeria/'. $fileData['file_name']], ACCESS_TOKEN_FB);
                        $images_posted[] = $response->getGraphNode()->asArray()['id'];
                    } catch(Facebook\Exceptions\FacebookResponseException $e) {
                    } catch(Facebook\Exceptions\FacebookSDKException $e) {
                    }
                }
            }

            if (count($images_posted) > 0) {
                $linkData = [];

                foreach ($images_posted as $key => $val) {
                    $linkData['attached_media['.$key.']'] = '{"media_fbid":"'.$val.'"}';
                }
                $linkData['message'] = $titu_alb;

                try {
                    $response = $fb->post('/182498662244220/feed', $linkData, ACCESS_TOKEN_FB);
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                }
            }

            $type_system = "success";
            $message_system = "Álbum registrado con éxito";
            
            set_message_system($type_system, $message_system);

            header('Location: ' . base_url('galeria/admin'));
        } else {
            header("Location: " . base_url());
        }
    }

    public function eliminar_imagen() {
        if ($this->session->userdata("usuario") && check_permission(QUITAR_IMAGEN_ALBUM)) {
            $codi_ial = $this->input->post('codigo');
            $this->mod_galeria->update($codi_ial, array("esta_ial" => "0"));

            $type_system = "success";
            $message_system = "Imagen eliminado con éxito";
            
            set_message_system($type_system, $message_system);

            header('Location: ' . base_url('galeria/admin'));
        } else {
            header("Location: " . base_url());
        }
    }

    public function upload_fecha() {
        if ($this->session->userdata("usuario") && check_permission(MODIFICAR_ALBUM_IMAGEN)) {
            $codi_alb = $this->input->post('codi_alb');
            $fech_alb = $this->input->post('fech_alb');
            $this->mod_galeria->update_album($codi_alb, array("fech_alb" => $fech_alb));

            $type_system = "success";
            $message_system = "Fecha de publicación actualizada con éxito";
            
            set_message_system($type_system, $message_system);

            header('Location: ' . base_url('galeria/admin'));
        } else {
            header("Location: " . base_url());
        }
    }

    public function update_title_album() {
        if ($this->session->userdata("usuario") && check_permission(MODIFICAR_ALBUM_IMAGEN)) {
            $codi_alb = $this->input->post('codi_alb');
            $titu_alb = $this->input->post('titu_alb');
            $this->mod_galeria->update_album($codi_alb, array("titu_alb" => $titu_alb));

            $type_system = "success";
            $message_system = "Título de álbum actualizado con éxito";
            
            set_message_system($type_system, $message_system);

            header('Location: ' . base_url('galeria/admin'));
        } else {
            header("Location: " . base_url());
        }
    }

    public function upload_album() {
        if ($this->session->userdata("usuario") && check_permission(MODIFICAR_ALBUM_IMAGEN)) {
            $codi_alb = $this->input->post('codi_alb');
            $codi_usu = $this->session->userdata("usuario")->codi_usu;

            $config['upload_path'] = './assets/galeria/';
            $config['allowed_types'] = 'png|jpg';
            $config['max_size'] = 20000;
            $config['overwrite'] = false;

            $this->load->library('upload', $config);

            $filesCount = count($_FILES['imag_ial']['name']);
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['imagen']['name'] = $_FILES['imag_ial']['name'][$i];
                $_FILES['imagen']['type'] = $_FILES['imag_ial']['type'][$i];
                $_FILES['imagen']['tmp_name'] = $_FILES['imag_ial']['tmp_name'][$i];
                $_FILES['imagen']['error'] = $_FILES['imag_ial']['error'][$i];
                $_FILES['imagen']['size'] = $_FILES['imag_ial']['size'][$i];

                if($this->upload->do_upload('imagen')){
                    $fileData = $this->upload->data();

                    $configer =  array(
                      'image_library'   => 'gd2',
                      'source_image'    =>  $fileData['full_path'],
                      'maintain_ratio'  =>  TRUE,
                      'width'           =>  800,
                      'height'          =>  800,
                    );
                    $this->image_lib->clear();
                    $this->image_lib->initialize($configer);
                    $this->image_lib->resize();

                    $data_img = array(
                        'imag_ial' => $fileData['file_name'],
                        'codi_usu' => $codi_usu,
                        'codi_alb' => $codi_alb,
                        'fech_ial' => date("Y-m-d H:i"),
                        'esta_ial' => "1"
                    );
                    $this->mod_galeria->save($data_img);
                }
            }

            $type_system = "success";
            $message_system = "Imágenes subidas con éxito";
            
            set_message_system($type_system, $message_system);

            header('Location: ' . base_url('galeria/admin'));
        } else {
            header("Location: " . base_url());
        }
    }

    public function habilitar() {
        if ($this->session->userdata("usuario") && check_permission(HABILITAR_ALBUM_IMAGEN)) {
            $codi_alb = $this->input->post('codigo');
            $this->mod_galeria->update_album($codi_alb, array("esta_alb" => "1"));

            $type_system = "success";
            $message_system = "Álbum habilitado con éxito";
            
            set_message_system($type_system, $message_system);

            header('Location: ' . base_url('galeria/admin'));
        } else {
            header("Location: " . base_url());
        }
    }

    public function deshabilitar() {
        if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_ALBUM_IMAGEN)) {
            $codi_alb = $this->input->post('codigo');
            $this->mod_galeria->update_album($codi_alb, array("esta_alb" => "0"));

            $type_system = "success";
            $message_system = "Álbum deshabilitado con éxito";
            
            set_message_system($type_system, $message_system);

            header('Location: ' . base_url('galeria/admin'));
        } else {
            header("Location: " . base_url());
        }
    }

    public function eliminar() {
        if ($this->session->userdata("usuario") && check_permission(ELIMINAR_ALBUM_IMAGEN)) {
            $codi_alb = $this->input->post('codigo');
            $this->mod_galeria->update_album($codi_alb, array("esta_alb" => "-1"));

            $type_system = "success";
            $message_system = "Álbum eliminado con éxito";
            
            set_message_system($type_system, $message_system);

            header('Location: ' . base_url('galeria/admin'));
        } else {
            header("Location: " . base_url());
        }
    }
}
