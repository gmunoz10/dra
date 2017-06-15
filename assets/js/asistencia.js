$(function() {
    var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "asistencia/paginate",
        "sServerMethod": "POST",
        "fnServerParams": function(aoData) {
            aoData.push({"name": "fech_asi", "value": $("#fech_asi_search").val()});
        },
        "columns": [
            { "data": "codi_asi" },
            { "data": "fech_asi_d" },
            { "data": "full_asi" },
            { "data": "docu_emp" },
            { "data": "ofic_emp" },
            { "data": "obsv_emp" },
            { "data": "ingr_asi_d" },
            { "data": "sare_asi_d" },
            { "data": "inre_asi_d" },
            { "data": "sali_asi_d" },
            { "data": "estado" },
            { "data": "opciones" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "displayLength": 10
    });

    jQuery.validator.addMethod("validDate", function(value, element) {
        return this.optional(element) || moment(value,"YYYY-MM-DD").isValid();
    }, "Por favor, ingrese una fecha válida en el formato YYYY-MM-DD");

    $('input[name="fech_asi"]').parent().datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD'
    });

    $('input[name="ingr_asi"]').parent().datetimepicker({
        locale: 'es',
        format: 'hh:mm A'
    });

    $('input[name="sali_asi"]').parent().datetimepicker({
        locale: 'es',
        format: 'hh:mm A'
    });

    $('input[name="inre_asi"]').parent().datetimepicker({
        locale: 'es',
        format: 'hh:mm A'
    });

    $('input[name="sare_asi"]').parent().datetimepicker({
        locale: 'es',
        format: 'hh:mm A'
    });

    $('#form_asi :input[name="obsv_emp"]').keyup(function() {
        $(this).val($(this).val().toUpperCase());
    });

    $('#fech_asi_search').datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD'
    });

    $('#btn_search').on('click', function() {
        table_search.ajax.reload();
    });

    var $form_asi = $('#form_asi');


    var isDestroyable = false;

    $(document).on('click', '#btn_asistencia', function () {
        $("#modal_asi_lbl").html('Nueva asistencia');
        
        $form_asi.get(0).reset();

        $('[name="ofic_emp"]').val($('[name="codi_emp"] option:selected').data("ofic"));
        $('[name="docu_emp"]').val($('[name="codi_emp"] option:selected').data("docu"));

        $('#form_asi :input[name="fech_asi"]').val(moment().format('YYYY-MM-DD'));  
        $('#form_asi :input[name="ingr_asi"]').val(moment().format('hh:mm A'));  

        $form_asi.attr("action", base_url+"asistencia/save");

        $form_asi.submit(function(e) {
                $("#submit_asi").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_asi").prop('disabled', true);
                if (!validator_asi.form()) {
                    $("#submit_asi").html('Guardar');
                    $("#submit_asi").prop('disabled', false);
                    return;
                }
        });

        if (isDestroyable) {
            validator_asi.destroy();
        }
        
        validator_asi = $form_asi.validate({
            rules: {
                fech_asi: {
                    required: true,
                    validDate: true
                },
                codi_emp: {
                    required: true,
                },
                ingr_asi: {
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

        $("#modal_asi").modal();
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_asi.get(0).reset();

        //$('#form_asi select[name="codi_gpa"] option[value="'+data.codi_gpa+'"]').prop("selected", true);  
        $('#form_asi :input[name="codi_asi"]').val(data.codi_asi);  
        $('#form_asi :input[name="fech_asi"]').val(data.fech_asi);  
        $('#form_asi select[name="codi_emp"] option[value="'+data.codi_emp+'"]').prop("selected", true);  
        $('#form_asi :input[name="docu_emp"]').val(data.docu_emp);  
        $('#form_asi :input[name="ofic_emp"]').val(data.ofic_emp);  
        $('#form_asi :input[name="obsv_emp"]').val(data.obsv_emp);  
        $('#form_asi :input[name="ingr_asi"]').val(moment(data.ingr_asi, 'HH:mm').format('hh:mm A'));  
        $('#form_asi :input[name="sali_asi"]').val((data.sali_asi_d != "-") ? moment(data.sali_asi, 'HH:mm').format('hh:mm A') : "");  
        $('#form_asi :input[name="inre_asi"]').val((data.inre_asi_d != "-") ? moment(data.inre_asi, 'HH:mm').format('hh:mm A') : "");  
        $('#form_asi :input[name="sare_asi"]').val((data.sare_asi_d != "-") ? moment(data.sare_asi, 'HH:mm').format('hh:mm A') : "");  

        $("#modal_asi_lbl").html("Modificar Asistencia");

        $.removeData($form_asi.get(0),'validator');

        $form_asi.attr("action", base_url+"asistencia/update");

        $form_asi.submit(function(e) {
            if (!validator_asi.form()) {
                return;
            } else {
                $("#submit_asi").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_asi").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_asi.destroy();
        }
        
        validator_asi = $form_asi.validate({
            rules: {
                fech_asi: {
                    required: true,
                    validDate: true
                },
                codi_emp: {
                    required: true,
                },
                ingr_asi: {
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

        $("#modal_asi").modal();
    });

    $(document).on('submit', '.habilitar_asi', function () {
        return confirm("¿Está seguro de que desea habilitar Asistencia?");
    });

    $(document).on('submit', '.deshabilitar_asi', function () {
        return confirm("¿Está seguro de que desea deshabilitar Asistencia?");
    });

    $(document).on('submit', '.eliminar_asi', function () {
        return confirm("¿Está seguro de que desea eliminar Asistencia?");
    });

    $('[name="codi_emp"]').on('change', function () {
        $('[name="ofic_emp"]').val($('[name="codi_emp"] option:selected').data("ofic"));
        $('[name="docu_emp"]').val($('[name="codi_emp"] option:selected').data("docu"));
    });
});
