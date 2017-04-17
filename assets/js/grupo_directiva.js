$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "grupo_directiva/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_gdi" },
            { "data": "nomb_gdi" },
            { "data": "estado" },
            { "data": "opciones" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "displayLength": 10
    });

    var $form_grupo_directiva = $('#form_grupo_directiva');

    var isDestroyable = false;

    $("#btn_grupo_directiva").click(function() {
        $("#modal_grupo_directiva_lbl").html("Nuevo grupo de directiva");

        $form_grupo_directiva.get(0).reset();

        $form_grupo_directiva.attr("action", base_url+"grupo_directiva/save");

        $form_grupo_directiva.submit(function(e) {
            if (!validator_grupo_directiva.form()) {
                return;
            } else {
                $("#submit_grupo_directiva").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_grupo_directiva").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_grupo_directiva.destroy();
        }
        
        validator_grupo_directiva = $form_grupo_directiva.validate({
            rules: {
                nomb_gdi: {
                    required: true,
                    remote: {
                        url: base_url+"grupo_directiva/check_nomb_gdi",
                        type: "post",
                        data:
                        {
                            nomb_gdi: function()
                            {
                                return $('#form_grupo_directiva :input[name="nomb_gdi"]').val();
                            }
                        }
                    }         
                },
            },
            messages: {
                nomb_gdi: { 
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

        $("#modal_grupo_directiva").modal();
    });

    $(document).on('click', '#table_search button.btn-preview', function () {
        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $("#modal_link_lbl").html(data.nomb_gdi);
        $('[name="link"]').val(data.link_dir);
        $("#reso_label").html("Enlace de "+data.nomb_gdi+" para portal de transparencia: ");

        var clipboard = new Clipboard('.btn-copiar');


        $("#modal_link").modal();
    });

    $(document).on('click', '.btn-enlace', function () {
        window.open($(this).parent().parent().find('[name="link"]').val(), "Directiva DRAL", "width=490,height=500");
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

        $form_grupo_directiva.get(0).reset();

        $('#form_grupo_directiva :input[name="codi_gdi"]').val(data.codi_gdi);  
        $('#form_grupo_directiva :input[name="nomb_gdi"]').val(data.nomb_gdi);  

        $("#modal_grupo_directiva_lbl").html("Modificar grupo");

        $.removeData($form_grupo_directiva.get(0),'validator');

        $form_grupo_directiva.attr("action", base_url+"grupo_directiva/update");

        $form_grupo_directiva.submit(function(e) {
            if (!validator_grupo_directiva.form()) {
                return;
            } else {
                $("#submit_grupo_directiva").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_grupo_directiva").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_grupo_directiva.destroy();
        }
        
        validator_grupo_directiva = $form_grupo_directiva.validate({
            rules: {
                nomb_gdi: {
                    required: true,
                    remote: {
                        url: base_url+"grupo_directiva/check_nomb_gdi_actualizar",
                        type: "post",
                        data:
                        {
                            codi_gdi: function()
                            {
                                return $('#form_grupo_directiva :input[name="codi_gdi"]').val();
                            },
                            nomb_gdi: function()
                            {
                                return $('#form_grupo_directiva :input[name="nomb_gdi"]').val();
                            }
                        }
                    }         
                },
            },
            messages: {
                nomb_gdi: { 
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

        $("#modal_grupo_directiva").modal();
    });

    $(document).on('submit', '.habilitar_grupo_directiva', function () {
        return confirm("¿Está seguro de que desea habilitar el grupo de directiva?");
    });

    $(document).on('submit', '.deshabilitar_grupo_directiva', function () {
        return confirm("¿Está seguro de que desea deshabilitar el grupo de directiva?");
    });

    $(document).on('submit', '.eliminar_grupo_directiva', function () {
        return confirm("¿Está seguro de que desea eliminar el grupo de directiva?");
    });

});
