$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "agenda/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_age" },
            { "data": "nomb_dpe" },
            { "data": "fech_age_d" },
            { "data": "luga_age" },
            { "data": "desc_age" },
            { "data": "estado" },
            { "data": "opciones" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "displayLength": 10
    });

    $('input[name="fech_age"]').parent().datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD HH:mm'
    });

    var $form_agenda = $('#form_agenda');

    var isDestroyable = false;

    $("#btn_agenda").click(function() {
        $("#modal_agenda_lbl").html("Nueva agenda");

        $form_agenda.get(0).reset();

        $form_agenda.attr("action", base_url+"agenda/save");

        $form_agenda.submit(function(e) {
            if (!validator_agenda.form()) {
                return;
            } else {
                $("#submit_agenda").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_agenda").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_agenda.destroy();
        }
        
        validator_agenda = $form_agenda.validate({
            rules: {
                fech_age: {
                    required: true,
                },
                luga_age: {
                    required: true,
                },
                desc_age: {
                    required: true,
                },
                codi_dpe: {
                    required: true,
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

        $("#modal_agenda").modal();
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_agenda.get(0).reset();

        $('#form_agenda select[name="codi_dpe"] option[value="'+data.codi_dpe+'"]').prop("selected", true);  
        $('#form_agenda :input[name="codi_age"]').val(data.codi_age);  
        $('#form_agenda :input[name="fech_age"]').val(data.fech_age);  
        $('#form_agenda :input[name="desc_age"]').val(data.desc_age);  
        $('#form_agenda :input[name="luga_age"]').val(data.luga_age);  

        $("#modal_agenda_lbl").html("Modificar agenda");

        $.removeData($form_agenda.get(0),'validator');

        $form_agenda.attr("action", base_url+"agenda/update");

        $form_agenda.submit(function(e) {
            if (!validator_agenda.form()) {
                return;
            } else {
                $("#submit_agenda").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_agenda").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_agenda.destroy();
        }
        
        validator_agenda = $form_agenda.validate({
            rules: {
                fech_age: {
                    required: true,
                },
                luga_age: {
                    required: true,
                },
                desc_age: {
                    required: true,
                },
                codi_dpe: {
                    required: true,
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

        $("#modal_agenda").modal();
    });

    $(document).on('submit', '.habilitar_agenda', function () {
        return confirm("¿Está seguro de que desea habilitar la agenda?");
    });

    $(document).on('submit', '.deshabilitar_agenda', function () {
        return confirm("¿Está seguro de que desea deshabilitar la agenda?");
    });

    $(document).on('submit', '.eliminar_agenda', function () {
        return confirm("¿Está seguro de que desea eliminar la agenda?");
    });

});
