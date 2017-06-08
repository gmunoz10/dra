$(function() {
    var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "empleado/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_emp" },
            { "data": "full_emp" },
            { "data": "carg_emp" },
            { "data": "docu_emp" },
            { "data": "ofic_emp" },
            { "data": "tipo_emp" },
            { "data": "obsv_emp" },
            { "data": "estado" },
            { "data": "opciones" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "displayLength": 10
    });

    $('#form_emp input').keyup(function() {
        $(this).val($(this).val().toUpperCase());
    });

    var $form_emp = $('#form_emp');


    var isDestroyable = false;

    $(document).on('click', '#btn_empleado', function () {
        $("#modal_emp_lbl").html('Nuevo empleado');
        
        $form_emp.get(0).reset();

        $form_emp.attr("action", base_url+"empleado/save");

        $form_emp.submit(function(e) {
                $("#submit_emp").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_emp").prop('disabled', true);
                if (!validator_emp.form()) {
                    $("#submit_emp").html('Guardar');
                    $("#submit_emp").prop('disabled', false);
                    return;
                }
        });

        if (isDestroyable) {
            validator_emp.destroy();
        }
        
        validator_emp = $form_emp.validate({
            rules: {
                apel_emp: {
                    required: true,
                    remote: {
                        url: base_url+"empleado/check_full_emp",
                        type: "post",
                        data:
                        {
                            full_emp: function()
                            {
                                return $('#form_emp :input[name="apel_emp"]').val() + ', ' + $('#form_emp :input[name="nomb_emp"]').val();
                            }
                        }
                    }
                },
                nomb_emp: {
                    required: true,
                    remote: {
                        url: base_url+"empleado/check_full_emp",
                        type: "post",
                        data:
                        {
                            full_emp: function()
                            {
                                return $('#form_emp :input[name="apel_emp"]').val() + ', ' + $('#form_emp :input[name="nomb_emp"]').val();
                            }
                        }
                    }
                },
                carg_emp: {
                    required: true,
                },
                docu_emp: {
                    required: true,
                },
                ofic_emp: {
                    required: true,
                },
                tipo_emp: {
                    required: true,
                },
            },
            messages: {
                nomb_emp: { 
                    remote: "El empleado ya existe"
                },
                apel_emp: { 
                    remote: "El empleado ya existe"
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

        $("#modal_emp").modal();
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_emp.get(0).reset();

        //$('#form_emp select[name="codi_gpa"] option[value="'+data.codi_gpa+'"]').prop("selected", true);  
        $('#form_emp :input[name="codi_emp"]').val(data.codi_emp);  
        $('#form_emp :input[name="apel_emp"]').val(data.apel_emp);  
        $('#form_emp :input[name="nomb_emp"]').val(data.nomb_emp);  
        $('#form_emp :input[name="carg_emp"]').val(data.carg_emp);  
        $('#form_emp :input[name="docu_emp"]').val(data.docu_emp);  
        $('#form_emp :input[name="obsv_emp"]').val(data.obsv_emp);  
        $('#form_emp select[name="ofic_emp"] option[value="'+data.ofic_emp+'"]').prop("selected", true);  
        $('#form_emp select[name="tipo_emp"] option[value="'+data.tipo_emp+'"]').prop("selected", true);  

        $("#modal_emp_lbl").html("Modificar empleado");

        $.removeData($form_emp.get(0),'validator');

        $form_emp.attr("action", base_url+"empleado/update");

        $form_emp.submit(function(e) {
            if (!validator_emp.form()) {
                return;
            } else {
                $("#submit_emp").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_emp").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_emp.destroy();
        }
        
        validator_emp = $form_emp.validate({
            rules: {
                apel_emp: {
                    required: true,
                },
                nomb_emp: {
                    required: true,
                },
                carg_emp: {
                    required: true,
                },
                docu_emp: {
                    required: true,
                },
                ofic_emp: {
                    required: true,
                },
                tipo_emp: {
                    required: true,
                },
            },
            messages: {
                nomb_emp: { 
                    remote: "El empleado ya existe"
                },
                apel_emp: { 
                    remote: "El empleado ya existe"
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

        $("#modal_emp").modal();
    });

    $(document).on('submit', '.habilitar_emp', function () {
        return confirm("¿Está seguro de que desea habilitar Empleado?");
    });

    $(document).on('submit', '.deshabilitar_emp', function () {
        return confirm("¿Está seguro de que desea deshabilitar Empleado?");
    });

    $(document).on('submit', '.eliminar_emp', function () {
        return confirm("¿Está seguro de que desea eliminar Empleado?");
    });

});
