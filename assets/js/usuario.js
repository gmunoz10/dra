$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "usuario/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_usu" },
            { "data": "nomb_usu" },
            { "data": "desc_rol" },
            { "data": "estado" },
            { "data": "opciones" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "displayLength": 10
    });

    var $form_usuario = $('#form_usuario');

    var isDestroyable = false;

    $("#btn_usuario").click(function() {
        $("#modal_usuario_lbl").html("Nueva cuenta de acceso");

        $form_usuario.get(0).reset();

        $form_usuario.find(':input[name="acon_usu"]').parent().hide();
        $form_usuario.find(':input[name="cont_usu"]').parent().find("label").html("Contraseña");
        $form_usuario.find(':input[name="cont_usu"]').parent().show();
        $form_usuario.find(':input[name="ccon_usu"]').parent().show();

        $form_usuario.attr("action", base_url+"usuario/save");

        $form_usuario.submit(function(e) {
            if (!validator_usuario.form()) {
                return;
            } else {
                $("#submit_usuario").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_usuario").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_usuario.destroy();
        }
        
        validator_usuario = $form_usuario.validate({
            rules: {
                codi_rol: {
                    required: true,           
                },
                nomb_usu: {
                    minlength: 4, 
                    required: true,
                    remote: {
                        url: base_url+"usuario/check_nomb_usu",
                        type: "post",
                        data:
                        {
                            nomb_usu: function()
                            {
                                return $('#form_usuario :input[name="nomb_usu"]').val();
                            }
                        }
                    }         
                },
                cont_usu: {
                    minlength: 6, 
                    required: true,           
                },
                ccon_usu: {
                    minlength: 6, 
                    required: true,           
                    equalTo: '#form_usuario :input[name="cont_usu"]',
                },
            },
            messages: {
                nomb_usu: { 
                    remote: "El nombre de usuario ya existe"
                },
            },
            highlight: function(element) {
                $(element).closest('.form-control').parent().removeClass('has-success').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-control').parent().removeClass('has-error').addClass('has-success');
            },
            errorPlacement: function(error, element) {
                $(element).closest('.form-group').append(error);
            }
        });

        $("label.error").hide();
        $(".error").removeClass("error");
        $("label.success").hide();
        $(".success").removeClass("success");
        isDestroyable = true;

        $("#modal_usuario").modal();
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_usuario.get(0).reset();

        $('#form_usuario select[name="codi_rol"] option[value="'+data.codi_rol+'"]').prop("selected", true);  
        $('#form_usuario :input[name="codi_usu"]').val(data.codi_usu);  
        $('#form_usuario :input[name="nomb_usu"]').val(data.nomb_usu);  

        $("#modal_usuario_lbl").html("Modificar cuenta de acceso");

        $form_usuario.find(':input[name="acon_usu"]').parent().show();
        $form_usuario.find(':input[name="cont_usu"]').parent().find("label").html("Nueva contraseña");
        $form_usuario.find(':input[name="cont_usu"]').parent().show();
        $form_usuario.find(':input[name="ccon_usu"]').parent().show();

        $.removeData($form_usuario.get(0),'validator');

        $form_usuario.attr("action", base_url+"usuario/update");

        $form_usuario.submit(function(e) {
            if (!validator_usuario.form()) {
                return;
            } else {
                $("#submit_usuario").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_usuario").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_usuario.destroy();
        }
        
        validator_usuario = $form_usuario.validate({
            rules: {
                codi_rol: {
                    required: true,           
                },
                nomb_usu: {
                    minlength: 4, 
                    required: true,
                    remote: {
                        url: base_url+"usuario/check_nomb_usu_actualizar",
                        type: "post",
                        data:
                        {
                            codi_usu: function()
                            {
                                return $('#form_usuario :input[name="codi_usu"]').val();
                            },
                            nomb_usu: function()
                            {
                                return $('#form_usuario :input[name="nomb_usu"]').val();
                            }
                        }
                    }         
                },
                acon_usu: {
                    remote: {
                        url: base_url+"usuario/check_cont_usu",
                        type: "post",
                        data:
                        {
                            codi_usu: function()
                            {
                                return $('#form_usuario :input[name="codi_usu"]').val();
                            },
                            acon_usu: function()
                            {
                                return $('#form_usuario :input[name="acon_usu"]').val();
                            }
                        }
                    }         
                },
                cont_usu: {
                    minlength: 6, 
                },
                ccon_usu: {
                    minlength: 6, 
                    equalTo: '#form_usuario :input[name="cont_usu"]',
                },
            },
            messages: {
                nomb_usu: { 
                    remote: "El nombre de usuario ya existe"
                },
                acon_usu: { 
                    remote: "Contraseña incorrecta"
                },
            },
            highlight: function(element) {
                $(element).closest('.form-control').parent().removeClass('has-success').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-control').parent().removeClass('has-error').addClass('has-success');
            },
            errorPlacement: function(error, element) {
                $(element).closest('.form-group').append(error);
            }
        });

        $(".has-error").removeClass("has-error");
        $(".has-success").removeClass("has-success");
        isDestroyable = true;

        $("#modal_usuario").modal();
    });

    var grupos_permiso;
    var codi_usu;

    $(document).on('click', '#table_search button.btn-permiso', function () {
        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        var btn = $(this);
        btn.html('<i class="fa fa-refresh fa-spin" aria-hidden="true"></i>');     
        btn.prop('disabled', true);     
        $.ajax({
            type: 'post',
            url: base_url + 'permiso/get_permisos_usuario',
            data: {
                codi_usu: data.codi_usu
            },
            success: function(result) {
                btn.html('<i class="fa fa-key" aria-hidden="true"></i>');        
                btn.prop('disabled', false);     
                var d = $.parseJSON(result);
                grupos_permiso = d.data;
                codi_usu = data.codi_usu;
                $("#modal_permiso .modal-body").html('<div class="box_permisos row no-margin" style="position: relative;">'+d.view+'</div>');
                $("#modal_permiso .modal-title").html("Permisos de "+data.nomb_usu);
                $('[data-toggle="toggle"]').bootstrapToggle();
                $("#modal_permiso").modal("show");
            }
        });
    });

    $(document).on("click", ".btn_save_permiso", function() {
        var header = $("#modal_permiso .modal-body");

        tbody = $(this).parent().find(".table-permiso tbody");
        codi_gpr = tbody.data("gpr");

        var target_grupo;

        tbody.find("tr").each(function(index, value) {
            codi_pro = $(this).data("pro");
            codi_pus = $(this).data("pus");
            valo_pus = ($(this).find(".check_permiso").prop("checked")) ? "1" : "0";

            for (var i = 0; i < grupos_permiso.length; i++) {
                if (grupos_permiso[i].codi_gpr == codi_gpr) {
                    target_grupo = i;
                    for (var j = 0; j < grupos_permiso[i].permisos.length; j++) {
                        if (grupos_permiso[i].permisos[j].codi_pro == codi_pro) {
                            grupos_permiso[i].permisos[j].valo_pus = valo_pus;
                            break;
                        }
                    }
                    break;
                }
            }
        });  

        header.append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');

        $.ajax({
            type: 'post',
            url: base_url + 'permiso/save_permiso_usuario',
            data: {
                codi_usu: codi_usu,
                permisos: JSON.stringify(grupos_permiso[target_grupo])
            },
            success: function(result) {
                var data = $.parseJSON(result);
                show_toast(data.type, data.message);
                header.find(".overlay").remove();
            }
        });
    });

    $(document).on('submit', '.habilitar_cuenta', function () {
        return confirm("¿Está seguro de que desea habilitar la cuenta?");
    });

    $(document).on('submit', '.deshabilitar_cuenta', function () {
        return confirm("¿Está seguro de que desea deshabilitar la cuenta?");
    });

    $(document).on('submit', '.eliminar_cuenta', function () {
        return confirm("¿Está seguro de que desea eliminar la cuenta?");
    });

});
