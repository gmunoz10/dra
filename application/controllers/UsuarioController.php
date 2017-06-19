<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UsuarioController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array("mod_usuario", "mod_permiso"));
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_CUENTA)) {
            $this->styles[] = '<link href="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">';
            $this->styles[] = '<link href="'.asset_url().'css/usuario.css" rel="stylesheet">';
            
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/jquery.dataTables.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.datatable/dataTables.bootstrap.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/jquery.validate.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/additional-methods.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/jquery.validate/localization/messages_es_PE.js"></script>';
            $this->scripts[] = '<script src="'.asset_url().'plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>';

            $this->scripts[] = '<script src="'.asset_url().'js/usuario.js"></script>';

            $data["roles"] = $this->mod_usuario->get_roles();

            // Imprimir vista con datos
            $data["styles"] = $this->styles;
            $data["scripts"] = $this->scripts;
            $component["content"] = $this->load->view("usuario/search", $data, true);
            $this->load->view("template/body_main", $component);
        } else {
            header("Location: " . base_url());
        }
    }

    public function paginate() {
        if ($this->session->userdata("usuario") && check_permission(BUSCAR_CUENTA)) {
            $nTotal = $this->mod_usuario->count_all($_POST['sSearch']);

            $data = $this->mod_usuario->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

            $aaData = array();

            foreach ($data as $row) {

                $estado = "";
                $opciones = "";
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_CUENTA)) {
                    $opciones .= '<button type="button" class="btn btn-primary btn-modificar" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($row->esta_usu == "1") {
                    $estado = '<span class="label label-success">Habilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(DESHABILITAR_CUENTA)) {
                        $opciones.= '<form method="post" class="deshabilitar_cuenta" action="'.base_url('usuario/deshabilitar').'" style="display: inline-block;"><input type="hidden" name="codi_usu" value="'.$row->codi_usu.'"><button type="submit" class="btn btn-warning btn-deshabilitar" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-ban" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                } else if ($row->esta_usu == "0") {
                    $estado = '<span class="label label-danger">Deshabilitado</span>';
                    if ($this->session->userdata("usuario") && check_permission(HABILITAR_CUENTA)) {
                        $opciones.= '<form method="post" class="habilitar_cuenta" action="'.base_url('usuario/habilitar').'" style="display: inline-block;"><input type="hidden" name="codi_usu" value="'.$row->codi_usu.'"><button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar"><i class="fa fa-check" aria-hidden="true"></i></button></form>&nbsp;';
                    }
                }
                if ($this->session->userdata("usuario") && check_permission(MODIFICAR_PERMISO_USUARIO)) {
                        $opciones .= '<button type="button" class="btn btn-info btn-permiso" data-toggle="tooltip" data-placement="top" title="Modificar permisos"><i class="fa fa-key" aria-hidden="true"></i></button>&nbsp;';
                }
                if ($this->session->userdata("usuario") && check_permission(ELIMINAR_CUENTA)) {
                        $opciones.= '<form method="post" class="eliminar_cuenta" action="'.base_url('usuario/eliminar').'" style="display: inline-block;"><input type="hidden" name="codi_usu" value="'.$row->codi_usu.'"><button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                }
                $opciones .= "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";

                $aaData[] = array(
                    "codi_usu" => $row->codi_usu,
                    "nomb_usu" => $row->nomb_usu,
                    "desc_rol" => $row->desc_rol,
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

    public function check_nomb_usu() {
        echo $this->mod_usuario->check_nomb_usu($this->input->post('nomb_usu'));
    }

    public function check_nomb_usu_actualizar() {
        echo $this->mod_usuario->check_nomb_usu_actualizar($this->input->post('codi_usu'), $this->input->post('nomb_usu'));
    }

    public function check_cont_usu() {
        echo $this->mod_usuario->check_cont_usu($this->session->userdata("usuario")->codi_usu, md5($this->input->post('acon_usu')));
    }

    public function save() {
        $codi_rol = $this->input->post('codi_rol');
        $nomb_usu = $this->input->post('nomb_usu');
        $cont_usu = md5($this->input->post('cont_usu'));

        $data = array(
            'codi_rol' => $codi_rol,
            'nomb_usu' => $nomb_usu,
            'cont_usu' => $cont_usu,
            'esta_usu' => '1'
        );
        
        if ($this->mod_usuario->check_nomb_usu($nomb_usu) == "true") {
            $this->mod_usuario->save($data);

            $type_system = "success";
            $message_system = "El usuario $nomb_usu ha sido registrado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El nombre de usuario $nomb_usu ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('usuario'));
    }

    public function update() {
        $codi_usu = $this->input->post('codi_usu');
        $codi_rol = $this->input->post('codi_rol');
        $nomb_usu = $this->input->post('nomb_usu');

        $usuario = $this->mod_usuario->get_usuario_row(array("codi_usu" => $codi_usu));

        if ($codi_rol != $usuario->codi_rol) {
            $this->mod_permiso->clear_permisos_usuario(array("codi_usu" => $codi_usu));
        }

        $data = array(
            'codi_rol' => $codi_rol,
            'nomb_usu' => $nomb_usu
        );

        if ($this->input->post('cont_usu') != "") {
            $data["cont_usu"] = md5($this->input->post('cont_usu'));
        }
        
        if ($this->mod_usuario->check_nomb_usu_actualizar($codi_usu, $nomb_usu) == "true") {
            $this->mod_usuario->update($codi_usu, $data);

            if ($this->session->userdata("usuario")->codi_usu == $codi_usu) {
                $usuario = $this->mod_usuario->get_usuario_row(array("codi_usu" => $codi_usu));
                $this->session->set_userdata("usuario", $usuario);
            }

            $type_system = "success";
            $message_system = "El usuario $nomb_usu ha sido actualizado con éxito";
        } else {
            $type_system = "error";
            $message_system = "El nombre de usuario $nomb_usu ya existe";
        }

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('usuario'));
    }

    public function update_cont() {
        if ($this->session->userdata("usuario")) {
            $codi_usu = $this->session->userdata("usuario")->codi_usu;
            $cont_usu = md5($this->input->post('cont_usu'));

            $this->mod_usuario->update($codi_usu, array("cont_usu" => $cont_usu));

            $usuario = $this->mod_usuario->get_usuario_row(array("codi_usu" => $codi_usu));
            $this->session->set_userdata("usuario", $usuario);

            $type_system = "success";
            $message_system = "Contraseña actualizada con éxito";

            set_message_system($type_system, $message_system);
            
            header('Location: ' . base_url('cambiar_clave'));
        } else {
            header("Location: " . base_url());
        }
    }

    public function habilitar() {
        $codi_usu = $this->input->post('codi_usu');
        $data = array(
            'esta_usu' => '1'
        );
        $this->mod_usuario->update($codi_usu, $data);

        $type_system = "success";
        $message_system = "Cuenta de acceso habilitada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('usuario'));
    }

    public function deshabilitar() {
        $codi_usu = $this->input->post('codi_usu');
        $data = array(
            'esta_usu' => '0'
        );
        $this->mod_usuario->update($codi_usu, $data);

        $type_system = "success";
        $message_system = "Cuenta de acceso deshabilitado con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('usuario'));
    }

    public function eliminar() {
        $codi_usu = $this->input->post('codi_usu');
        $data = array(
            'esta_usu' => '-1'
        );
        $this->mod_usuario->update($codi_usu, $data);

        $type_system = "success";
        $message_system = "Cuenta de acceso eliminada con éxito";

        set_message_system($type_system, $message_system);

        header('Location: ' . base_url('usuario'));
    }



}
