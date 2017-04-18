$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "grupo_declaracion_jurada/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_gdj" },
            { "data": "nomb_gdj" },
            { "data": "estado" },
            { "data": "opciones" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "displayLength": 10
    });

    var $form_grupo_declaracion_jurada = $('#form_grupo_declaracion_jurada');

    var isDestroyable = false;

    $("#btn_grupo_declaracion_jurada").click(function() {
        $("#modal_grupo_declaracion_jurada_lbl").html("Nuevo grupo de declaración jurada");

        $form_grupo_declaracion_jurada.get(0).reset();

        $form_grupo_declaracion_jurada.attr("action", base_url+"grupo_declaracion_jurada/save");

        $form_grupo_declaracion_jurada.submit(function(e) {
            if (!validator_grupo_declaracion_jurada.form()) {
                return;
            } else {
                $("#submit_grupo_declaracion_jurada").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_grupo_declaracion_jurada").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_grupo_declaracion_jurada.destroy();
        }
        
        validator_grupo_declaracion_jurada = $form_grupo_declaracion_jurada.validate({
            rules: {
                nomb_gdj: {
                    required: true,
                    remote: {
                        url: base_url+"grupo_declaracion_jurada/check_nomb_gdj",
                        type: "post",
                        data:
                        {
                            nomb_gdj: function()
                            {
                                return $('#form_grupo_declaracion_jurada :input[name="nomb_gdj"]').val();
                            }
                        }
                    }         
                },
            },
            messages: {
                nomb_gdj: { 
                    remote: "El nombre de grupo ya existe"
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

        $("#modal_grupo_declaracion_jurada").modal();
    });

    $(document).on('click', '#table_search button.btn-preview', function () {
        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $("#modal_link_lbl").html(data.nomb_gdj);
        $('[name="link"]').val(data.link_dju);
        $("#reso_label").html("Enlace de "+data.nomb_gdj+" para portal de transparencia: ");

        var clipboard = new Clipboard('.btn-copiar');


        $("#modal_link").modal();
    });

    $(document).on('click', '.btn-enlace', function () {
        window.open($(this).parent().parent().find('[name="link"]').val(), "Declaración Jurada DRAL", "width=490,height=500");
    });

    /*
    $(document).on('click', '.btn-copiar', function () {
        window.prompt("Copy to clipboard: Ctrl+C, Enter", $(this).parent().parent().find('[name="link"]').val());
    });
    */


    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_grupo_declaracion_jurada.get(0).reset();

        $('#form_grupo_declaracion_jurada :input[name="codi_gdj"]').val(data.codi_gdj);  
        $('#form_grupo_declaracion_jurada :input[name="nomb_gdj"]').val(data.nomb_gdj);  

        $("#modal_grupo_declaracion_jurada_lbl").html("Modificar grupo");

        $.removeData($form_grupo_declaracion_jurada.get(0),'validator');

        $form_grupo_declaracion_jurada.attr("action", base_url+"grupo_declaracion_jurada/update");

        $form_grupo_declaracion_jurada.submit(function(e) {
            if (!validator_grupo_declaracion_jurada.form()) {
                return;
            } else {
                $("#submit_grupo_declaracion_jurada").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_grupo_declaracion_jurada").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_grupo_declaracion_jurada.destroy();
        }
        
        validator_grupo_declaracion_jurada = $form_grupo_declaracion_jurada.validate({
            rules: {
                nomb_gdj: {
                    required: true,
                    remote: {
                        url: base_url+"grupo_declaracion_jurada/check_nomb_gdj_actualizar",
                        type: "post",
                        data:
                        {
                            codi_gdj: function()
                            {
                                return $('#form_grupo_declaracion_jurada :input[name="codi_gdj"]').val();
                            },
                            nomb_gdj: function()
                            {
                                return $('#form_grupo_declaracion_jurada :input[name="nomb_gdj"]').val();
                            }
                        }
                    }         
                },
            },
            messages: {
                nomb_gdj: { 
                    remote: "El nombre de grupo ya existe"
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

        $("#modal_grupo_declaracion_jurada").modal();
    });

    $(document).on('submit', '.habilitar_grupo_declaracion_jurada', function () {
        return confirm("¿Está seguro de que desea habilitar el grupo de declaración jurada?");
    });

    $(document).on('submit', '.deshabilitar_grupo_declaracion_jurada', function () {
        return confirm("¿Está seguro de que desea deshabilitar el grupo de declaración jurada?");
    });

    $(document).on('submit', '.eliminar_grupo_declaracion_jurada', function () {
        return confirm("¿Está seguro de que desea eliminar el grupo de declaración jurada?");
    });

});
