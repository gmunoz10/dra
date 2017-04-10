$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "dependencia/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_dpe" },
            { "data": "nomb_dpe" },
            { "data": "estado" },
            { "data": "opciones" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "displayLength": 10
    });

    var $form_dependencia = $('#form_dependencia');

    var isDestroyable = false;

    $("#btn_dependencia").click(function() {
        $("#modal_dependencia_lbl").html("Nueva dependencia");

        $form_dependencia.get(0).reset();

        $form_dependencia.attr("action", base_url+"dependencia/save");

        $form_dependencia.submit(function(e) {
            if (!validator_dependencia.form()) {
                return;
            } else {
                $("#submit_dependencia").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_dependencia").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_dependencia.destroy();
        }
        
        validator_dependencia = $form_dependencia.validate({
            rules: {
                nomb_dpe: {
                    required: true,
                    remote: {
                        url: base_url+"dependencia/check_nomb_dpe",
                        type: "post",
                        data:
                        {
                            nomb_dpe: function()
                            {
                                return $('#form_dependencia :input[name="nomb_dpe"]').val();
                            }
                        }
                    }         
                },
            },
            messages: {
                nomb_dpe: { 
                    remote: "El nombre de dependencia ya existe"
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

        $("#modal_dependencia").modal();
    });

    /*
    $(document).on('click', '#table_search button.btn-preview', function () {
        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $("#modal_link_lbl").html(data.nomb_dpe);
        $('[name="link"]').val(data.link_res);
        $("#reso_label").html("Enlace de "+data.nomb_dpe+" para portal de transparencia: ");

        var clipboard = new Clipboard('.btn-copiar');


        $("#modal_link").modal();
    });

    $(document).on('click', '.btn-enlace', function () {
        window.open($(this).parent().parent().find('[name="link"]').val(), "Resolución DRAL", "width=490,height=500");
    });
    */

    /*
    $(document).on('click', '.btn-copiar', function () {
        window.prompt("Copy to clipboard: Ctrl+C, Enter", $(this).parent().parent().find('[name="link"]').val());
    });
    */


    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_dependencia.get(0).reset();

        $('#form_dependencia :input[name="codi_dpe"]').val(data.codi_dpe);  
        $('#form_dependencia :input[name="nomb_dpe"]').val(data.nomb_dpe);  

        $("#modal_dependencia_lbl").html("Modificar dependencia");

        $.removeData($form_dependencia.get(0),'validator');

        $form_dependencia.attr("action", base_url+"dependencia/update");

        $form_dependencia.submit(function(e) {
            if (!validator_dependencia.form()) {
                return;
            } else {
                $("#submit_dependencia").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_dependencia").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_dependencia.destroy();
        }
        
        validator_dependencia = $form_dependencia.validate({
            rules: {
                nomb_dpe: {
                    required: true,
                    remote: {
                        url: base_url+"dependencia/check_nomb_dpe_actualizar",
                        type: "post",
                        data:
                        {
                            codi_dpe: function()
                            {
                                return $('#form_dependencia :input[name="codi_dpe"]').val();
                            },
                            nomb_dpe: function()
                            {
                                return $('#form_dependencia :input[name="nomb_dpe"]').val();
                            }
                        }
                    }         
                },
            },
            messages: {
                nomb_dpe: { 
                    remote: "El nombre de dependencia ya existe"
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

        $("#modal_dependencia").modal();
    });

    $(document).on('submit', '.habilitar_dependencia', function () {
        return confirm("¿Está seguro de que desea habilitar la dependencia?");
    });

    $(document).on('submit', '.deshabilitar_dependencia', function () {
        return confirm("¿Está seguro de que desea deshabilitar la dependencia?");
    });

    $(document).on('submit', '.eliminar_dependencia', function () {
        return confirm("¿Está seguro de que desea eliminar la dependencia?");
    });

});
