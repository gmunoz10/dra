<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GaleriaController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_galeria", "mod_permiso"));
        $this->load->helper('cookie');
    }

    public function admin($page = 1) {
        $size = 5;
        $start = (int) $page * $size - $size;

        $data["count"] = $this->mod_galeria->count_album();
        $data["albumes"] = $this->mod_galeria->get_list_album($start, $size);
        foreach ($data["albumes"] as $key => $album) {
            $data["albumes"][$key]->imagenes = $this->mod_galeria->get_imagenes_album($album->codi_alb);
        }
        $data["page"] = $page;
        $data["pages"] = ceil($data["count"]/$size);

        if ($this->session->userdata("usuario") && check_permission(BUSCAR_ALBUM_IMAGEN)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/lightbox/dist/ekko-lightbox.css" rel="stylesheet">';
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

        $titu_alb = $this->input->post('titu_alb');
        $codi_usu = $this->session->userdata("usuario")->codi_usu;

        $data = array(
            'titu_alb' => $titu_alb,
            'codi_usu' => $codi_usu,
            'fech_alb' => date("Y-m-d H:i"),
            'esta_alb' => "1"
        );
        $codi_alb = $this->mod_galeria->save_album($data);

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
        $message_system = "Álbum registrado con éxito";
        
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('galeria/admin'));
    }

    public function eliminar_imagen() {
        $codi_ial = $this->input->post('codi_ial');
        $this->mod_galeria->update($codi_ial, array("esta_ial" => "0"));

        $type_system = "success";
        $message_system = "Imagen eliminado con éxito";
        
        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('galeria/admin'));
    }
}
