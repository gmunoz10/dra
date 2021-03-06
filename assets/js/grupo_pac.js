$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "grupo_pac/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_gpa" },
            { "data": "nomb_gpa" },
            { "data": "estado" },
            { "data": "opciones" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "displayLength": 10
    });

    var $form_grupo_pac = $('#form_grupo_pac');

    var isDestroyable = false;

    $("#btn_grupo_pac").click(function() {
        $("#modal_grupo_pac_lbl").html("Nuevo grupo de PAC");

        $form_grupo_pac.get(0).reset();

        $form_grupo_pac.attr("action", base_url+"grupo_pac/save");

        $form_grupo_pac.submit(function(e) {
            if (!validator_grupo_pac.form()) {
                return;
            } else {
                $("#submit_grupo_pac").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_grupo_pac").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_grupo_pac.destroy();
        }
        
        validator_grupo_pac = $form_grupo_pac.validate({
            rules: {
                nomb_gpa: {
                    required: true,
                    remote: {
                        url: base_url+"grupo_pac/check_nomb_gpa",
                        type: "post",
                        data:
                        {
                            nomb_gpa: function()
                            {
                                return $('#form_grupo_pac :input[name="nomb_gpa"]').val();
                            }
                        }
                    }         
                },
            },
            messages: {
                nomb_gpa: { 
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

        $("#modal_grupo_pac").modal();
    });

    $(document).on('click', '#table_search button.btn-preview', function () {
        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $("#modal_link_lbl").html(data.nomb_gpa);
        $('[name="link"]').val(data.link_pac);
        $("#reso_label").html("Enlace de "+data.nomb_gpa+" para portal de transparencia: ");

        var clipboard = new Clipboard('.btn-copiar');


        $("#modal_link").modal();
    });

    $(document).on('click', '.btn-enlace', function () {
        window.open($(this).parent().parent().find('[name="link"]').val(), "PAC DRAL", "width=490,height=500");
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

        $form_grupo_pac.get(0).reset();

        $('#form_grupo_pac :input[name="codi_gpa"]').val(data.codi_gpa);  
        $('#form_grupo_pac :input[name="nomb_gpa"]').val(data.nomb_gpa);  

        $("#modal_grupo_pac_lbl").html("Modificar grupo");

        $.removeData($form_grupo_pac.get(0),'validator');

        $form_grupo_pac.attr("action", base_url+"grupo_pac/update");

        $form_grupo_pac.submit(function(e) {
            if (!validator_grupo_pac.form()) {
                return;
            } else {
                $("#submit_grupo_pac").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_grupo_pac").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_grupo_pac.destroy();
        }
        
        validator_grupo_pac = $form_grupo_pac.validate({
            rules: {
                nomb_gpa: {
                    required: true,
                    remote: {
                        url: base_url+"grupo_pac/check_nomb_gpa_actualizar",
                        type: "post",
                        data:
                        {
                            codi_gpa: function()
                            {
                                return $('#form_grupo_pac :input[name="codi_gpa"]').val();
                            },
                            nomb_gpa: function()
                            {
                                return $('#form_grupo_pac :input[name="nomb_gpa"]').val();
                            }
                        }
                    }         
                },
            },
            messages: {
                nomb_gpa: { 
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

        $("#modal_grupo_pac").modal();
    });

    $(document).on('submit', '.habilitar_grupo_pac', function () {
        return confirm("¿Está seguro de que desea habilitar el grupo de PAC?");
    });

    $(document).on('submit', '.deshabilitar_grupo_pac', function () {
        return confirm("¿Está seguro de que desea deshabilitar el grupo de PAC?");
    });

    $(document).on('submit', '.eliminar_grupo_pac', function () {
        return confirm("¿Está seguro de que desea eliminar el grupo de PAC?");
    });

});
