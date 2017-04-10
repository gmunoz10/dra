$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "resolucion/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_res" },
            { "data": "nomb_gre" },
            { "data": "nume_res" },
            { "data": "fech_res_d" },
            { "data": "estado" },
            { "data": "opciones" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "displayLength": 10
    });

    function validar_fecha(value, element) {
        return moment(value,"YYYY-MM-DD").isValid();
    }

    function check_nume_res(value, element, fech_res) {
        valid = true;
        if (fech_res != "") {
            $.ajax({
                type: 'post',
                url: base_url + 'resolucion/check_nume_res',
                async: false,
                data: {
                    nume_res: value,
                    fech_res: fech_res,
                },
                success: function(result) {
                    if (result == "false") {
                        valid = false;
                    }
                }
            });
        }
        return valid;
    }

    jQuery.validator.addMethod("validDate", function(value, element) {
        return this.optional(element) || moment(value,"YYYY-MM-DD").isValid();
    }, "Por favor, ingrese una fecha válida en el formato YYYY-MM-DD");

    jQuery.validator.addMethod("check_nume_res", function(value, element) {
            valid = true;
            if ($('#form_resolucion :input[name="fech_res"]').val() != "") {
                $.ajax({
                    type: 'post',
                    url: base_url + 'resolucion/check_nume_res',
                    async: false,
                    data: {
                        nume_res: value,
                        fech_res: $('#form_resolucion :input[name="fech_res"]').val(),
                    },
                    success: function(result) {
                        if (result == "false") {
                            valid = false;
                        }
                    }
                });
            }
            return valid;
    }, "El número de resolución ya existe.");

    jQuery.validator.addMethod("check_nume_res_actualizar", function(value, element) {
            valid = true;
            if ($('#form_resolucion :input[name="fech_res"]').val() != "") {
                $.ajax({
                    type: 'post',
                    url: base_url + 'resolucion/check_nume_res_actualizar',
                    async: false,
                    data: {
                        codi_res: $('#form_resolucion :input[name="codi_res"]').val(),
                        nume_res: value,
                        fech_res: $('#form_resolucion :input[name="fech_res"]').val(),
                    },
                    success: function(result) {
                        if (result == "false") {
                            valid = false;
                        }
                    }
                });
            }
            return valid;
    }, "El número de resolución ya existe.");

    $('input[name="docu_res"]').fileinput({
        language: "dral",
        showUpload: false
    });

    $('input[name="fech_res"]').parent().datetimepicker({
        viewMode: 'years',
        locale: 'es',
        format: 'YYYY-MM-DD'
    });

    var $form_resolucion = $('#form_resolucion');

    var isDestroyable = false;

    function agregar_fila() {
        var create = true;

        $("#table_multi tbody tr").each(function(e, v) {
            if ($(this).find('.nume_res').val() == "" && $(this).find('.desc_res').val() == "" && $(this).find('.fech_res').val() == "" && $(this).find('.docu_res').get(0).files.length === 0) {
                create = false;
                return;
            }
        });

        if (create) {
            var num = $("#table_multi tbody tr").length;
            select_view = $("<div>"+$("#select_view").html()+"</div>");
            select_view.find(".codi_gre").attr("name", "codi_gre_"+num);
            $("#table_multi tbody").append('<tr> <td> ' + select_view.html() + ' </td> <td> <input class="form-control nume_res" name="nume_res_'+num+'"> </td> <td> <div class="input-group date box-date"> <input type="text" class="form-control fech_res" name="fech_res_'+num+'" /> <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"> </span> </span> </div> </td> <td> <textarea class="form-control desc_res" rows="1" name="desc_res_'+num+'"></textarea> </td> <td> <input name="docu_res_'+num+'" type="file" class="file-loading docu_res" data-allowed-file-extensions=\'["pdf", "doc", "docx"]\' data-show-preview="false"> </td> </tr>');
            $('#form_resolucion_multi [name="count_rows"]').val($("#table_multi tbody tr").length);

            $('.docu_res').fileinput({
                language: "dral",
                showUpload: false
            });

            $('.fech_res').parent().datetimepicker({
                viewMode: 'years',
                locale: 'es',
                format: 'YYYY-MM-DD'
            });
        }
    }

    agregar_fila();

    var valid_nume_res = true;

    $(document).on('click', '#btn_resolucion', function () {
        $("#table_multi tbody").html("");
        agregar_fila();

        $("#modal_resolucion_lbl").html('<input type="checkbox" data-width="150" checked data-toggle="toggle" data-onstyle="primary" data-offstyle="info" data-on=\'<i class="fa fa-cube" aria-hidden="true"></i> Modo normal\' data-off=\'<i class="fa fa-cubes" aria-hidden="true"></i> Modo múltiple\' class="check_mode"> Nueva resolución');
        
        $('[data-toggle="toggle"]').bootstrapToggle();

        $form_resolucion.get(0).reset();

        $form_resolucion.attr("action", base_url+"resolucion/save");

        $form_resolucion.submit(function(e) {
            if ($form_resolucion.attr("action") == base_url+"resolucion/save" && $('.check_mode').is(':checked')) {
                $("#submit_resolucion").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_resolucion").prop('disabled', true);
                if (!validator_resolucion.form()) {
                    $("#submit_resolucion").html('Guardar');
                    $("#submit_resolucion").prop('disabled', false);
                    return;
                }
            }
        });

        if (isDestroyable) {
            validator_resolucion.destroy();
        }
        
        validator_resolucion = $form_resolucion.validate({
            rules: {
                nume_res: {
                    required: true,
                    check_nume_res: true
                },
                fech_res: {
                    required: true,
                    validDate: true
                },
                desc_res: {
                    required: true,
                },
                docu_res: {
                    required: true,
                    accept: "application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                }
            },
            messages: {
                nume_res: { 
                    remote: "El número de resolución ya existe"
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

        $("#modal_resolucion").modal();
    });

    $(document).on('change', '.check_mode', function () {
        if ($(this).is(':checked')) {
            $form_resolucion.attr("action", base_url+"resolucion/save");

            $("#modal_resolucion .modal-dialog").animate({width:'60%'}, 250);

            $(".resolucion-uno").show(250);
            $(".resolucion-multi").hide(250);

            $("#submit_resolucion").show();
            $("#submit_multi_resolucion").hide();
        } else {
            $form_resolucion.attr("action", base_url+"resolucion/save_multi");

            $("#modal_resolucion .modal-dialog").animate({width:'80%'}, 250);
            
            $(".resolucion-uno").hide(250);
            $(".resolucion-multi").show(250);

            $("#submit_resolucion").hide();
            $("#submit_multi_resolucion").show();
        }
    });

    $(document).on('change, keyup', '.codi_gre, .nume_res, .fech_res, .desc_res, .docu_res', function () {
        var fila = $(this).closest("tr");

        if (fila.find('.nume_res').val() != "") {
            agregar_fila();
        }
    });

    $("#submit_multi_resolucion").click(function() {
        valid = true;
        count_valid = 0;
        var history_nume = [];
        $("#table_multi tbody tr").each(function(e, v) {
            tr = $(this);
            valid_row = true;
            if (tr.find('.nume_res').val() == "" && tr.find('.desc_res').val() == "" && tr.find('.fech_res').val() == "" && tr.find('.docu_res').get(0).files.length === 0) {
                return true;
            }
            codi_gre = tr.find('.codi_gre').val();
            nume_res = tr.find('.nume_res').val();
            fech_res = tr.find('.fech_res').val();
            desc_res = tr.find('.desc_res').val();
            docu_res = tr.find('.docu_res').get(0).files.length;

            if (codi_gre === "") {
                tr.find('.codi_gre').parent().removeClass('has-success').addClass('has-error');
                tr.find('.codi_gre').parent().find('.error').remove();
                tr.find('.codi_gre').parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                tr.find('.codi_gre').parent().removeClass('has-error').addClass('has-success');
                tr.find('.codi_gre').parent().find('.error').remove();
            }

            if (nume_res === "") {
                tr.find('.nume_res').parent().removeClass('has-success').addClass('has-error');
                tr.find('.nume_res').parent().find(".error").remove();
                tr.find('.nume_res').parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                $.ajax({
                    type: 'post',
                    url: base_url + 'resolucion/check_nume_res',
                    async: false,
                    data: {
                        nume_res: nume_res
                    },
                    success: function(result) {
                        if (result == "false") {
                            tr.find('.nume_res').parent().removeClass('has-success').addClass('has-error');
                            tr.find('.nume_res').parent().find(".error").remove();
                            tr.find('.nume_res').parent().append('<label class="error">El número de resolución ya existe.</label>');
                            valid = false;
                            valid_row = false;
                        } else {
                            check = false;
                            for (var i = 0; i < history_nume.length; i++) {
                                if (history_nume[i] == nume_res) {
                                    check = true;
                                    break;
                                }
                            }
                            if (check) {
                                tr.find('.nume_res').parent().removeClass('has-success').addClass('has-error');
                                tr.find('.nume_res').parent().find(".error").remove();
                                tr.find('.nume_res').parent().append('<label class="error">Ya has agregado el mismo número de resolución.</label>');
                                valid = false;
                                valid_row = false;
                            } else {
                                tr.find('.nume_res').parent().removeClass('has-error').addClass('has-success');
                                tr.find('.nume_res').parent().find('.error').remove();
                                history_nume.push(nume_res);
                            }
                        }
                    }
                });
            }

            if (fech_res === "") {
                tr.find('.fech_res').parent().removeClass('has-success').addClass('has-error');
                tr.find('.fech_res').parent().parent().find('.error').remove();
                tr.find('.fech_res').parent().parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                if (!validar_fecha(fech_res, tr.find('.fech_res'))) {
                    tr.find('.fech_res').parent().removeClass('has-success').addClass('has-error');
                    tr.find('.fech_res').parent().parent().find('.error').remove();
                    tr.find('.fech_res').parent().parent().append('<label class="error">Por favor, ingrese una fecha válida en el formato YYYY-MM-DD.</label>');
                    valid = false;
                    valid_row = false;
                } else {
                    tr.find('.fech_res').parent().removeClass('has-error').addClass('has-success');
                    tr.find('.fech_res').parent().parent().find('.error').remove();
                }
            }

            if (desc_res === "") {
                tr.find('.desc_res').parent().removeClass('has-success').addClass('has-error');
                tr.find('.desc_res').parent().find('.error').remove();
                tr.find('.desc_res').parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                tr.find('.desc_res').parent().removeClass('has-error').addClass('has-success');
                tr.find('.desc_res').parent().find('.error').remove();
            }
            
            if (docu_res === 0) {
                tr.find('.docu_res').parent().parent().parent().removeClass('has-success').addClass('has-error');
                tr.find('.docu_res').parent().parent().parent().parent().parent().find('.error').remove();
                tr.find('.docu_res').parent().parent().parent().parent().parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                tr.find('.docu_res').parent().parent().parent().removeClass('has-error').addClass('has-success');
                tr.find('.docu_res').parent().parent().parent().parent().parent().find('.error').remove();
            }

            if (valid_row) {

                if (!check_nume_res(nume_res, tr.find('.nume_res'), fech_res)) {
                    tr.find('.nume_res').parent().removeClass('has-success').addClass('has-error');
                    tr.find('.nume_res').parent().find('.error').remove();
                    tr.find('.nume_res').parent().append('<label class="error">El número de resolución ya existe.</label>');
                    valid = false;
                    valid_row = false;
                } else {
                    tr.find('.nume_res').parent().removeClass('has-error').addClass('has-success');
                    tr.find('.nume_res').parent().find('.error').remove();
                }

                count_valid++;
            }
        });
            
        if (count_valid == 0) {
            show_toast("error", "Por favor, complete al menos una resolución");
        } else if (valid) {
            $('#form_resolucion [name="count_rows"]').val($("#table_multi tbody tr").length);
            $('#form_resolucion').submit();
        }
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_resolucion.get(0).reset();

        $("#modal_resolucion .modal-dialog").animate({width:'60%'}, 250);

        $(".resolucion-uno").show(250);
        $(".resolucion-multi").hide(250);

        $("#submit_resolucion").show();
        $("#submit_multi_resolucion").hide();

        $('#form_resolucion select[name="codi_gre"] option[value="'+data.codi_gre+'"]').prop("selected", true);  
        $('#form_resolucion :input[name="codi_res"]').val(data.codi_res);  
        $('#form_resolucion :input[name="nume_res"]').val(data.nume_res);  
        $('#form_resolucion :input[name="fech_res"]').val(data.fech_res);  
        $('#form_resolucion :input[name="desc_res"]').val(data.desc_res);  

        $("#modal_resolucion_lbl").html("Modificar resolución");

        $.removeData($form_resolucion.get(0),'validator');

        $form_resolucion.attr("action", base_url+"resolucion/update");

        $form_resolucion.submit(function(e) {
            if (!validator_resolucion.form()) {
                return;
            } else {
                $("#submit_resolucion").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_resolucion").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_resolucion.destroy();
        }
        
        validator_resolucion = $form_resolucion.validate({
            rules: {
                nume_res: {
                    required: true,
                    check_nume_res_actualizar: true
                },
                fech_res: {
                    required: true,
                    validDate: true
                },
                desc_res: {
                    required: true,
                },
                docu_res: {
                    accept: "application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                }
            },
            messages: {
                nume_res: { 
                    remote: "El número de resolución ya existe"
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

        $("#modal_resolucion").modal();
    });

    $(document).on('submit', '.habilitar_resolucion', function () {
        return confirm("¿Está seguro de que desea habilitar la resolucion?");
    });

    $(document).on('submit', '.deshabilitar_resolucion', function () {
        return confirm("¿Está seguro de que desea deshabilitar la resolucion?");
    });

    $(document).on('submit', '.eliminar_resolucion', function () {
        return confirm("¿Está seguro de que desea eliminar la resolucion?");
    });

});
