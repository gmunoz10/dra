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

    $("#btn_usuario").click(function() {
        $("#modal_usuario_lbl").html("Nueva cuenta de acceso");

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

        $("#modal_usuario").modal();
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

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

        $("#modal_usuario").modal();
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
