$(function() {
    var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "visita/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_vis" },
            { "data": "fech_vis_d" },
            { "data": "visi_vis" },
            { "data": "tipo_vis" },
            { "data": "docu_vis" },
            { "data": "enti_vis" },
            { "data": "moti_vis" },
            { "data": "sede_vis" },
            { "data": "empl_vis" },
            { "data": "ofic_vis" },
            { "data": "ingr_vis_d" },
            { "data": "sali_vis_d" },
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

    $('input[name="fech_vis"]').parent().datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD'
    });

    $('input[name="ingr_vis"]').parent().datetimepicker({
        locale: 'es',
        format: 'hh:mm A'
    });

    $('input[name="sali_vis"]').parent().datetimepicker({
        locale: 'es',
        format: 'hh:mm A'
    });

    $('#form_vis :input[name="apel_vis"]').keyup(function() {
        $(this).val($(this).val().toUpperCase());
    });

    $('#form_vis :input[name="nomb_vis"]').keyup(function() {
        $(this).val($(this).val().toUpperCase());
    });

    var $form_vis = $('#form_vis');


    var isDestroyable = false;

    $(document).on('click', '#btn_visita', function () {
        $("#modal_vis_lbl").html('Nueva visita');
        
        $form_vis.get(0).reset();

        $('#form_vis :input[name="tipo_vis"]').val("D.N.I.");  
        $('#form_vis :input[name="fech_vis"]').val(moment().format('YYYY-MM-DD'));  
        $('#form_vis :input[name="ingr_vis"]').val(moment().format('hh:mm A'));  

        $form_vis.attr("action", base_url+"visita/save");

        $form_vis.submit(function(e) {
                $("#submit_vis").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_vis").prop('disabled', true);
                if (!validator_vis.form()) {
                    $("#submit_vis").html('Guardar');
                    $("#submit_vis").prop('disabled', false);
                    return;
                }
        });

        if (isDestroyable) {
            validator_vis.destroy();
        }
        
        validator_vis = $form_vis.validate({
            rules: {
                fech_vis: {
                    required: true,
                    validDate: true
                },
                apel_vis: {
                    required: true,
                },
                nomb_vis: {
                    required: true,
                },
                tipo_vis: {
                    required: true,
                },
                docu_vis: {
                    required: true,
                },
                enti_vis: {
                    required: true,
                },
                moti_vis: {
                    required: true,
                },
                sede_vis: {
                    required: true,
                },
                empl_vis: {
                    required: true,
                },
                ofic_vis: {
                    required: true,
                },
                ingr_vis: {
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

        $("#modal_vis").modal();
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_vis.get(0).reset();

        //$('#form_vis select[name="codi_gpa"] option[value="'+data.codi_gpa+'"]').prop("selected", true);  
        $('#form_vis :input[name="codi_vis"]').val(data.codi_vis);  
        $('#form_vis :input[name="fech_vis"]').val(data.fech_vis);  
        $('#form_vis :input[name="apel_vis"]').val(data.apel_vis);  
        $('#form_vis :input[name="nomb_vis"]').val(data.nomb_vis);  
        $('#form_vis :input[name="tipo_vis"]').val(data.tipo_vis);  
        $('#form_vis :input[name="docu_vis"]').val(data.docu_vis);  
        $('#form_vis :input[name="enti_vis"]').val(data.enti_vis);  
        $('#form_vis :input[name="moti_vis"]').val(data.moti_vis);  
        $('#form_vis select[name="sede_vis"] option[value="'+data.sede_vis+'"]').prop("selected", true);  
        $('#form_vis select[name="empl_vis"] option[value="'+data.empl_vis+'"]').prop("selected", true);  
        $('#form_vis select[name="ofic_vis"] option[value="'+data.ofic_vis+'"]').prop("selected", true);  
        $('#form_vis :input[name="ingr_vis"]').val(moment(data.ingr_vis, 'HH:mm').format('hh:mm A'));  
        $('#form_vis :input[name="sali_vis"]').val((data.sali_vis_d != "-") ? moment(data.sali_vis, 'HH:mm').format('hh:mm A') : "");  

        $("#modal_vis_lbl").html("Modificar Visita");

        $.removeData($form_vis.get(0),'validator');

        $form_vis.attr("action", base_url+"visita/update");

        $form_vis.submit(function(e) {
            if (!validator_vis.form()) {
                return;
            } else {
                $("#submit_vis").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_vis").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_vis.destroy();
        }
        
        validator_vis = $form_vis.validate({
            rules: {
                fech_vis: {
                    required: true,
                    validDate: true
                },
                apel_vis: {
                    required: true,
                },
                nomb_vis: {
                    required: true,
                },
                tipo_vis: {
                    required: true,
                },
                docu_vis: {
                    required: true,
                },
                enti_vis: {
                    required: true,
                },
                moti_vis: {
                    required: true,
                },
                sede_vis: {
                    required: true,
                },
                empl_vis: {
                    required: true,
                },
                ofic_vis: {
                    required: true,
                },
                ingr_vis: {
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

        $("#modal_vis").modal();
    });

    $(document).on('submit', '.habilitar_vis', function () {
        return confirm("¿Está seguro de que desea habilitar Visita?");
    });

    $(document).on('submit', '.deshabilitar_vis', function () {
        return confirm("¿Está seguro de que desea deshabilitar Visita?");
    });

    $(document).on('submit', '.eliminar_vis', function () {
        return confirm("¿Está seguro de que desea eliminar Visita?");
    });

    $(document).on('click', '#btn_link', function () {
        var clipboard = new Clipboard('.btn-copiar');
        $("#modal_link").modal();
    });

    $(document).on('click', '.btn-enlace', function () {
        window.open($(this).parent().parent().find('[name="link"]').val(), "VISITAS DRAL", "width=490,height=500");
    });
});
