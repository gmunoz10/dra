$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "rol/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_rol" },
            { "data": "desc_rol" },
            { "data": "estado" },
            { "data": "opciones" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "displayLength": 10
    });

    var $form_rol = $('#form_rol');

    var isDestroyable = false;

    $("#btn_rol").click(function() {
        $("#modal_rol_lbl").html("Nuevo rol");

        $form_rol.get(0).reset();

        $form_rol.attr("action", base_url+"rol/save");

        $form_rol.submit(function(e) {
            if (!validator_rol.form()) {
                return;
            } else {
                $("#submit_rol").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_rol").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_rol.destroy();
        }
        
        validator_rol = $form_rol.validate({
            rules: {
                desc_rol: {
                    minlength: 4, 
                    required: true,
                    remote: {
                        url: base_url+"rol/check_desc_rol",
                        type: "post",
                        data:
                        {
                            desc_rol: function()
                            {
                                return $('#form_rol :input[name="desc_rol"]').val();
                            }
                        }
                    }         
                },
            },
            messages: {
                desc_rol: { 
                    remote: "El nombre de rol ya existe"
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

        $("#modal_rol").modal();
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_rol.get(0).reset();

        $('#form_rol :input[name="codi_rol"]').val(data.codi_rol);  
        $('#form_rol :input[name="desc_rol"]').val(data.desc_rol);  

        $("#modal_rol_lbl").html("Modificar rol");

        $.removeData($form_rol.get(0),'validator');

        $form_rol.attr("action", base_url+"rol/update");

        $form_rol.submit(function(e) {
            if (!validator_rol.form()) {
                return;
            } else {
                $("#submit_rol").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_rol").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_rol.destroy();
        }
        
        validator_rol = $form_rol.validate({
            rules: {
                desc_rol: {
                    minlength: 4, 
                    required: true,
                    remote: {
                        url: base_url+"rol/check_desc_rol_actualizar",
                        type: "post",
                        data:
                        {
                            codi_rol: function()
                            {
                                return $('#form_rol :input[name="codi_rol"]').val();
                            },
                            desc_rol: function()
                            {
                                return $('#form_rol :input[name="desc_rol"]').val();
                            }
                        }
                    }         
                },
            },
            messages: {
                desc_rol: { 
                    remote: "El nombre de rol ya existe"
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

        $("#modal_rol").modal();
    });

    var grupos_permiso;
    var codi_rol;

    $(document).on('click', '#table_search button.btn-permiso', function () {
        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        var btn = $(this);
        btn.html('<i class="fa fa-refresh fa-spin" aria-hidden="true"></i>');     
        btn.prop('disabled', true);     
        $.ajax({
            type: 'post',
            url: base_url + 'permiso/get_permisos_rol',
            data: {
                codi_rol: data.codi_rol
            },
            success: function(result) {
                btn.html('<i class="fa fa-key" aria-hidden="true"></i>');        
                btn.prop('disabled', false);     
                var d = $.parseJSON(result);
                grupos_permiso = d.data;
                codi_rol = data.codi_rol;
                $("#modal_permiso .modal-body").html('<div class="box_permisos row no-margin" style="position: relative;">'+d.view+'</div>');
                $("#modal_permiso .modal-title").html(data.desc_rol);
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
            codi_per = $(this).data("per");
            codi_pro = $(this).data("pro");
            valo_pro = ($(this).find(".check_permiso").prop("checked")) ? "1" : "0";

            for (var i = 0; i < grupos_permiso.length; i++) {
                if (grupos_permiso[i].codi_gpr == codi_gpr) {
                    target_grupo = i;
                    for (var j = 0; j < grupos_permiso[i].permisos.length; j++) {
                        if (grupos_permiso[i].permisos[j].codi_per == codi_per) {
                            grupos_permiso[i].permisos[j].valo_pro = valo_pro;
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
            url: base_url + 'permiso/save_permiso_rol',
            data: {
                codi_rol: codi_rol,
                permisos: JSON.stringify(grupos_permiso[target_grupo])
            },
            success: function(result) {
                var data = $.parseJSON(result);
                show_toast(data.type, data.message);
                header.find(".overlay").remove();
            }
        });
    });

    $(document).on('submit', '.habilitar_rol', function () {
        return confirm("¿Está seguro de que desea habilitar la cuenta?");
    });

    $(document).on('submit', '.deshabilitar_rol', function () {
        return confirm("¿Está seguro de que desea deshabilitar la cuenta?");
    });

    $(document).on('submit', '.eliminar_rol', function () {
        return confirm("¿Está seguro de que desea eliminar la cuenta?");
    });

});
