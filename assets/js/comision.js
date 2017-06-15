$(function() {

    var detalle = [];

    function validarRetornos() {
        var size = $('select[name="retornos"]').val();
        var bool = true;
        for (var i = 0; i < size; i++) {
            if ($('input[name="ingr_com_'+i+'"]').val()=="" || $('input[name="sali_com_'+i+'"]').val()=="") {
                if ($('input[name="ingr_com_'+i+'"]').val()=="") {
                    $('input[name="ingr_com_'+i+'"]').parent().removeClass('has-success').addClass('has-error');
                    $('input[name="ingr_com_'+i+'"]').focus();
                } else if ($('input[name="sali_com_'+i+'"]').val()=="") {
                    $('input[name="sali_com_'+i+'"]').parent().removeClass('has-success').addClass('has-error');
                    $('input[name="sali_com_'+i+'"]').focus();
                }
                bool = false;
                break;
            }
        }

        return bool;
    }

    function add_row_detalle() {
        var name = "_" + $('#tbl_comision tbody tr').length;

        var row = '<tr> <td> <div class="input-group date box-date"> <input type="text" class="form-control" name="ingr_com'+name+'" /> <span class="input-group-addon"> <span class="glyphicon glyphicon-time"> </span> </span> </div> </td> <td> <div class="input-group date box-date"> <input type="text" class="form-control" name="sali_com'+name+'" /> <span class="input-group-addon"> <span class="glyphicon glyphicon-time"> </span> </span> </div> </td> <td> <input class="form-control" name="obsv_com'+name+'"> </td> </tr>';

        $('#tbl_comision tbody').append(row);

        $('input[name="ingr_com'+name+'"]').parent().datetimepicker({
            locale: 'es',
            format: 'hh:mm A'
        });

        $('input[name="sali_com'+name+'"]').parent().datetimepicker({
            locale: 'es',
            format: 'hh:mm A'
        });
    }

    function put_row_detalle(index, ingreso, salida, observacion) {
        var name = "_" + index;

        var row = '<tr> <td> <div class="input-group date box-date"> <input type="text" class="form-control" name="ingr_com'+name+'" value="'+ingreso+'" /> <span class="input-group-addon"> <span class="glyphicon glyphicon-time"> </span> </span> </div> </td> <td> <div class="input-group date box-date"> <input type="text" class="form-control" name="sali_com'+name+'" value="'+salida+'" /> <span class="input-group-addon"> <span class="glyphicon glyphicon-time"> </span> </span> </div> </td> <td> <input class="form-control" name="obsv_com'+name+'"  value="'+observacion+'"> </td> </tr>';

        $('#tbl_comision tbody').append(row);

        $('input[name="ingr_com'+name+'"]').parent().datetimepicker({
            locale: 'es',
            format: 'hh:mm A'
        });

        $('input[name="sali_com'+name+'"]').parent().datetimepicker({
            locale: 'es',
            format: 'hh:mm A'
        });
    }

    function updateRows(number) {
        // CLEAR
        if ($('#tbl_comision tbody tr').length > number) {
            for (var i = $('#tbl_comision tbody tr').length; i > number; i--) {
                $('#tbl_comision tbody tr:nth-child('+i+')').remove();
            }
        } else if ($('#tbl_comision tbody tr').length < number) {
            for (var i = $('#tbl_comision tbody tr').length; i < number; i++) {
                add_row_detalle();
            }
        }
    }

    $(document).on('change', 'select[name="retornos"]', function() {
        updateRows($(this).val());
    });

    function check_tipo() {
        if ($('[name="tipo_com"]').val() == "0") {
            $("#box_retorno").hide();
        } else if ($('[name="tipo_com"]').val() == "1") {
            $("#box_retorno").show();

            $('#form_com select[name="retornos"] option[value="1"]').prop("selected", true);  
            $('#tbl_comision tbody').html("");
                
            updateRows($('select[name="retornos"]').val());
        }
    }

    $('[name="tipo_com"]').change(function() {
        check_tipo(); 
    });

    var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "comision/paginate",
        "sServerMethod": "POST",
        "fnServerParams": function(aoData) {
            aoData.push({"name": "fech_com", "value": $("#fech_com_search").val()});
        },
        "columns": [
            { "data": "codi_com" },
            { "data": "fech_com_d" },
            { "data": "full_com" },
            { "data": "docu_emp" },
            { "data": "ofic_emp" },
            { "data": "tipo_com_d" },
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

    $('input[name="fech_com"]').parent().datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD'
    });

    $(document).on('keyup', '[name="obsv_com"]', function () {
        $(this).val($(this).val().toUpperCase());
    });

    $('#fech_com_search').datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD'
    });

    $('#btn_search').on('click', function() {
        table_search.ajax.reload();
    });

    var $form_com = $('#form_com');


    var isDestroyable = false;

    $(document).on('click', '#btn_comision', function () {
        $("#modal_com_lbl").html('Nueva comisión');
        
        $form_com.get(0).reset();

        $('[name="ofic_emp"]').val($('[name="codi_emp"] option:selected').data("ofic"));
        $('[name="docu_emp"]').val($('[name="codi_emp"] option:selected').data("docu"));

        $('#form_com :input[name="fech_com"]').val(moment().format('YYYY-MM-DD'));  

        check_tipo(); 

        $form_com.attr("action", base_url+"comision/save");

        $form_com.submit(function(e) {
                $("#submit_com").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_com").prop('disabled', true);
                if (!validator_com.form()) {
                    $("#submit_com").html('Guardar');
                    $("#submit_com").prop('disabled', false);
                    return false;
                } else {
                    if ($('[name="tipo_com"]').val() == "1") {
                        if (!validarRetornos()) {
                            $("#submit_com").html('Guardar');
                            $("#submit_com").prop('disabled', false);
                            return false;
                        }
                    } else {
                        $("#submit_com").html('Guardar');
                        $("#submit_com").prop('disabled', false);
                        return false;
                    }
                }
        });

        if (isDestroyable) {
            validator_com.destroy();
        }
        
        validator_com = $form_com.validate({
            rules: {
                fech_com: {
                    required: true,
                    validDate: true
                },
                codi_emp: {
                    required: true,
                },
                tipo_com: {
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

        $("#modal_com").modal();
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_com.get(0).reset();

        //$('#form_com select[name="codi_gpa"] option[value="'+data.codi_gpa+'"]').prop("selected", true);  
        $('#form_com :input[name="codi_com"]').val(data.codi_com);  
        $('#form_com :input[name="fech_com"]').val(data.fech_com);  
        $('#form_com select[name="codi_emp"] option[value="'+data.codi_emp+'"]').prop("selected", true);  
        $('#form_com :input[name="docu_emp"]').val(data.docu_emp);  
        $('#form_com :input[name="ofic_emp"]').val(data.ofic_emp);  
        $('#form_com select[name="tipo_com"] option[value="'+data.tipo_com+'"]').prop("selected", true);  

        check_tipo(); 

        if (data.tipo_com == "1") {
            if (data.detalle.length > 0) {
                $('#form_com select[name="retornos"] option[value="'+data.detalle.length+'"]').prop("selected", true);  
                $('#tbl_comision tbody').html("");
                for (var i = 0; i < data.detalle.length; i++) {
                    put_row_detalle(i, data.detalle[i].ingr_dco, data.detalle[i].sali_dco, data.detalle[i].obsv_dco);
                }
            }
        }

        $("#modal_com_lbl").html("Modificar Comisión");

        $.removeData($form_com.get(0),'validator');

        $form_com.attr("action", base_url+"comision/update");

        $form_com.submit(function(e) {
            $("#submit_com").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
            $("#submit_com").prop('disabled', true);
            if (!validator_com.form()) {
                $("#submit_com").html('Guardar');
                $("#submit_com").prop('disabled', false);
                return false;
            } else {
                if ($('[name="tipo_com"]').val() == "1") {
                    if (!validarRetornos()) {
                        $("#submit_com").html('Guardar');
                        $("#submit_com").prop('disabled', false);
                        return false;
                    }
                } else {
                    $("#submit_com").html('Guardar');
                    $("#submit_com").prop('disabled', false);
                    return false;
                }
            }
        });

        if (isDestroyable) {
            validator_com.destroy();
        }
        
        validator_com = $form_com.validate({
            rules: {
                fech_com: {
                    required: true,
                    validDate: true
                },
                codi_emp: {
                    required: true,
                },
                tipo_com: {
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

        $("#modal_com").modal();
    });

    $(document).on('submit', '.habilitar_com', function () {
        return confirm("¿Está seguro de que desea habilitar Comisión?");
    });

    $(document).on('submit', '.deshabilitar_com', function () {
        return confirm("¿Está seguro de que desea deshabilitar Comisión?");
    });

    $(document).on('submit', '.eliminar_com', function () {
        return confirm("¿Está seguro de que desea eliminar Comisión?");
    });

    $('[name="codi_emp"]').on('change', function () {
        $('[name="ofic_emp"]').val($('[name="codi_emp"] option:selected').data("ofic"));
        $('[name="docu_emp"]').val($('[name="codi_emp"] option:selected').data("docu"));
    });
});
