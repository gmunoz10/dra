$(function() {

    var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "declaracion_jurada/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_dju" },
            { "data": "nomb_gdj" },
            { "data": "nume_dju" },
            { "data": "fech_dju_d" },
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

    function check_nume_dju(value, element, fech_dju) {
        valid = true;
        if (fech_dju != "") {
            $.ajax({
                type: 'post',
                url: base_url + 'declaracion_jurada/check_nume_dju',
                async: false,
                data: {
                    nume_dju: value,
                    fech_dju: fech_dju,
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

    jQuery.validator.addMethod("check_nume_dju", function(value, element) {
            valid = true;
            if ($('#form_declaracion_jurada :input[name="fech_dju"]').val() != "") {
                $.ajax({
                    type: 'post',
                    url: base_url + 'declaracion_jurada/check_nume_dju',
                    async: false,
                    data: {
                        nume_dju: value,
                        fech_dju: $('#form_declaracion_jurada :input[name="fech_dju"]').val(),
                    },
                    success: function(result) {
                        if (result == "false") {
                            valid = false;
                        }
                    }
                });
            }
            return valid;
    }, "El número de declaración jurada ya existe.");

    jQuery.validator.addMethod("check_nume_dju_actualizar", function(value, element) {
            valid = true;
            if ($('#form_declaracion_jurada :input[name="fech_dju"]').val() != "") {
                $.ajax({
                    type: 'post',
                    url: base_url + 'declaracion_jurada/check_nume_dju_actualizar',
                    async: false,
                    data: {
                        codi_dju: $('#form_declaracion_jurada :input[name="codi_dju"]').val(),
                        nume_dju: value,
                        fech_dju: $('#form_declaracion_jurada :input[name="fech_dju"]').val(),
                    },
                    success: function(result) {
                        if (result == "false") {
                            valid = false;
                        }
                    }
                });
            }
            return valid;
    }, "El número de declaración jurada ya existe.");

    $('input[name="docu_dju"]').fileinput({
        language: "dral",
        showUpload: false
    });

    $('input[name="fech_dju"]').parent().datetimepicker({
        viewMode: 'years',
        locale: 'es',
        format: 'YYYY-MM-DD'
    });

    var $form_declaracion_jurada = $('#form_declaracion_jurada');

    var isDestroyable = false;

    function agregar_fila() {
        var create = true;

        $("#table_multi tbody tr").each(function(e, v) {
            if ($(this).find('.nume_dju').val() == "" && $(this).find('.desc_dju').val() == "" && $(this).find('.fech_dju').val() == "" && $(this).find('.docu_dju').get(0).files.length === 0) {
                create = false;
                return;
            }
        });

        if (create) {
            var num = $("#table_multi tbody tr").length;
            select_view = $("<div>"+$("#select_view").html()+"</div>");
            select_view.find(".codi_gdj").attr("name", "codi_gdj_"+num);
            $("#table_multi tbody").append('<tr> <td> ' + select_view.html() + ' </td> <td> <input class="form-control nume_dju" name="nume_dju_'+num+'"> </td> <td> <div class="input-group date box-date"> <input type="text" class="form-control fech_dju" name="fech_dju_'+num+'" /> <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"> </span> </span> </div> </td> <td> <textarea class="form-control desc_dju" rows="1" name="desc_dju_'+num+'"></textarea> </td> <td> <input name="docu_dju_'+num+'" type="file" class="file-loading docu_dju" data-allowed-file-extensions=\'["pdf", "doc", "docx"]\' data-show-preview="false"> </td> </tr>');
            $('#form_declaracion_jurada_multi [name="count_rows"]').val($("#table_multi tbody tr").length);

            $('.docu_dju').fileinput({
                language: "dral",
                showUpload: false
            });

            $('.fech_dju').parent().datetimepicker({
                viewMode: 'years',
                locale: 'es',
                format: 'YYYY-MM-DD'
            });
        }
    }

    agregar_fila();

    var valid_nume_dju = true;

    $(document).on('click', '#btn_declaracion_jurada', function () {
        $("#table_multi tbody").html("");
        agregar_fila();

        $("#modal_declaracion_jurada_lbl").html('<input type="checkbox" data-width="150" checked data-toggle="toggle" data-onstyle="primary" data-offstyle="info" data-on=\'<i class="fa fa-cube" aria-hidden="true"></i> Modo normal\' data-off=\'<i class="fa fa-cubes" aria-hidden="true"></i> Modo múltiple\' class="check_mode"> Nueva declaración jurada');
        
        $('[data-toggle="toggle"]').bootstrapToggle();

        $form_declaracion_jurada.get(0).reset();

        $form_declaracion_jurada.attr("action", base_url+"declaracion_jurada/save");

        $form_declaracion_jurada.submit(function(e) {
            if ($form_declaracion_jurada.attr("action") == base_url+"declaracion_jurada/save" && $('.check_mode').is(':checked')) {
                $("#submit_declaracion_jurada").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_declaracion_jurada").prop('disabled', true);
                if (!validator_declaracion_jurada.form()) {
                    $("#submit_declaracion_jurada").html('Guardar');
                    $("#submit_declaracion_jurada").prop('disabled', false);
                    return;
                }
            }
        });

        if (isDestroyable) {
            validator_declaracion_jurada.destroy();
        }
        
        validator_declaracion_jurada = $form_declaracion_jurada.validate({
            rules: {
                nume_dju: {
                    required: true,
                    check_nume_dju: true
                },
                fech_dju: {
                    required: true,
                    validDate: true
                },
                desc_dju: {
                    required: true,
                },
                docu_dju: {
                    required: true,
                    accept: "application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                }
            },
            messages: {
                nume_dju: { 
                    remote: "El número de declaración jurada ya existe"
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

        $("#modal_declaracion_jurada").modal();
    });

    $(document).on('change', '.check_mode', function () {
        if ($(this).is(':checked')) {
            $form_declaracion_jurada.attr("action", base_url+"declaracion_jurada/save");

            $("#modal_declaracion_jurada .modal-dialog").animate({width:'60%'}, 250);

            $(".declaracion_jurada-uno").show(250);
            $(".declaracion_jurada-multi").hide(250);

            $("#submit_declaracion_jurada").show();
            $("#submit_multi_declaracion_jurada").hide();
        } else {
            $form_declaracion_jurada.attr("action", base_url+"declaracion_jurada/save_multi");

            $("#modal_declaracion_jurada .modal-dialog").animate({width:'80%'}, 250);
            
            $(".declaracion_jurada-uno").hide(250);
            $(".declaracion_jurada-multi").show(250);

            $("#submit_declaracion_jurada").hide();
            $("#submit_multi_declaracion_jurada").show();
        }
    });

    $(document).on('change, keyup', '.codi_gdj, .nume_dju, .fech_dju, .desc_dju, .docu_dju', function () {
        var fila = $(this).closest("tr");

        if (fila.find('.nume_dju').val() != "") {
            agregar_fila();
        }
    });

    $("#submit_multi_declaracion_jurada").click(function() {
        valid = true;
        count_valid = 0;
        var history_nume = [];
        $("#table_multi tbody tr").each(function(e, v) {
            tr = $(this);
            valid_row = true;
            if (tr.find('.nume_dju').val() == "" && tr.find('.desc_dju').val() == "" && tr.find('.fech_dju').val() == "" && tr.find('.docu_dju').get(0).files.length === 0) {
                return true;
            }
            codi_gdj = tr.find('.codi_gdj').val();
            nume_dju = tr.find('.nume_dju').val();
            fech_dju = tr.find('.fech_dju').val();
            desc_dju = tr.find('.desc_dju').val();
            docu_dju = tr.find('.docu_dju').get(0).files.length;

            if (codi_gdj === "") {
                tr.find('.codi_gdj').parent().removeClass('has-success').addClass('has-error');
                tr.find('.codi_gdj').parent().find('.error').remove();
                tr.find('.codi_gdj').parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                tr.find('.codi_gdj').parent().removeClass('has-error').addClass('has-success');
                tr.find('.codi_gdj').parent().find('.error').remove();
            }

            if (nume_dju === "") {
                tr.find('.nume_dju').parent().removeClass('has-success').addClass('has-error');
                tr.find('.nume_dju').parent().find(".error").remove();
                tr.find('.nume_dju').parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                $.ajax({
                    type: 'post',
                    url: base_url + 'declaracion_jurada/check_nume_dju',
                    async: false,
                    data: {
                        nume_dju: nume_dju
                    },
                    success: function(result) {
                        if (result == "false") {
                            tr.find('.nume_dju').parent().removeClass('has-success').addClass('has-error');
                            tr.find('.nume_dju').parent().find(".error").remove();
                            tr.find('.nume_dju').parent().append('<label class="error">El número de declaración jurada ya existe.</label>');
                            valid = false;
                            valid_row = false;
                        } else {
                            check = false;
                            for (var i = 0; i < history_nume.length; i++) {
                                if (history_nume[i] == nume_dju) {
                                    check = true;
                                    break;
                                }
                            }
                            if (check) {
                                tr.find('.nume_dju').parent().removeClass('has-success').addClass('has-error');
                                tr.find('.nume_dju').parent().find(".error").remove();
                                tr.find('.nume_dju').parent().append('<label class="error">Ya has agregado el mismo número de declaración jurada.</label>');
                                valid = false;
                                valid_row = false;
                            } else {
                                tr.find('.nume_dju').parent().removeClass('has-error').addClass('has-success');
                                tr.find('.nume_dju').parent().find('.error').remove();
                                history_nume.push(nume_dju);
                            }
                        }
                    }
                });
            }

            if (fech_dju === "") {
                tr.find('.fech_dju').parent().removeClass('has-success').addClass('has-error');
                tr.find('.fech_dju').parent().parent().find('.error').remove();
                tr.find('.fech_dju').parent().parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                if (!validar_fecha(fech_dju, tr.find('.fech_dju'))) {
                    tr.find('.fech_dju').parent().removeClass('has-success').addClass('has-error');
                    tr.find('.fech_dju').parent().parent().find('.error').remove();
                    tr.find('.fech_dju').parent().parent().append('<label class="error">Por favor, ingrese una fecha válida en el formato YYYY-MM-DD.</label>');
                    valid = false;
                    valid_row = false;
                } else {
                    tr.find('.fech_dju').parent().removeClass('has-error').addClass('has-success');
                    tr.find('.fech_dju').parent().parent().find('.error').remove();
                }
            }

            if (desc_dju === "") {
                tr.find('.desc_dju').parent().removeClass('has-success').addClass('has-error');
                tr.find('.desc_dju').parent().find('.error').remove();
                tr.find('.desc_dju').parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                tr.find('.desc_dju').parent().removeClass('has-error').addClass('has-success');
                tr.find('.desc_dju').parent().find('.error').remove();
            }
            
            if (docu_dju === 0) {
                tr.find('.docu_dju').parent().parent().parent().removeClass('has-success').addClass('has-error');
                tr.find('.docu_dju').parent().parent().parent().parent().parent().find('.error').remove();
                tr.find('.docu_dju').parent().parent().parent().parent().parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                tr.find('.docu_dju').parent().parent().parent().removeClass('has-error').addClass('has-success');
                tr.find('.docu_dju').parent().parent().parent().parent().parent().find('.error').remove();
            }

            if (valid_row) {

                if (!check_nume_dju(nume_dju, tr.find('.nume_dju'), fech_dju)) {
                    tr.find('.nume_dju').parent().removeClass('has-success').addClass('has-error');
                    tr.find('.nume_dju').parent().find('.error').remove();
                    tr.find('.nume_dju').parent().append('<label class="error">El número de declaración jurada ya existe.</label>');
                    valid = false;
                    valid_row = false;
                } else {
                    tr.find('.nume_dju').parent().removeClass('has-error').addClass('has-success');
                    tr.find('.nume_dju').parent().find('.error').remove();
                }

                count_valid++;
            }
        });
            
        if (count_valid == 0) {
            show_toast("error", "Por favor, complete al menos una declaración jurada");
        } else if (valid) {
            $('#form_declaracion_jurada [name="count_rows"]').val($("#table_multi tbody tr").length);
            $('#form_declaracion_jurada').submit();
        }
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_declaracion_jurada.get(0).reset();

        $("#modal_declaracion_jurada .modal-dialog").animate({width:'60%'}, 250);

        $(".declaracion_jurada-uno").show(250);
        $(".declaracion_jurada-multi").hide(250);

        $("#submit_declaracion_jurada").show();
        $("#submit_multi_declaracion_jurada").hide();

        $('#form_declaracion_jurada select[name="codi_gdj"] option[value="'+data.codi_gdj+'"]').prop("selected", true);  
        $('#form_declaracion_jurada :input[name="codi_dju"]').val(data.codi_dju);  
        $('#form_declaracion_jurada :input[name="nume_dju"]').val(data.nume_dju);  
        $('#form_declaracion_jurada :input[name="fech_dju"]').val(data.fech_dju);  
        $('#form_declaracion_jurada :input[name="desc_dju"]').val(data.desc_dju);  

        $("#modal_declaracion_jurada_lbl").html("Modificar declaracion_jurada");

        $.removeData($form_declaracion_jurada.get(0),'validator');

        $form_declaracion_jurada.attr("action", base_url+"declaracion_jurada/update");

        $form_declaracion_jurada.submit(function(e) {
            if (!validator_declaracion_jurada.form()) {
                return;
            } else {
                $("#submit_declaracion_jurada").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_declaracion_jurada").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_declaracion_jurada.destroy();
        }
        
        validator_declaracion_jurada = $form_declaracion_jurada.validate({
            rules: {
                nume_dju: {
                    required: true,
                    check_nume_dju_actualizar: true
                },
                fech_dju: {
                    required: true,
                    validDate: true
                },
                desc_dju: {
                    required: true,
                },
                docu_dju: {
                    accept: "application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                }
            },
            messages: {
                nume_dju: { 
                    remote: "El número de declaración jurada ya existe"
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

        $("#modal_declaracion_jurada").modal();
    });

    $(document).on('submit', '.habilitar_declaracion_jurada', function () {
        return confirm("¿Está seguro de que desea habilitar la declaración jurada?");
    });

    $(document).on('submit', '.deshabilitar_declaracion_jurada', function () {
        return confirm("¿Está seguro de que desea deshabilitar la declaración jurada?");
    });

    $(document).on('submit', '.eliminar_declaracion_jurada', function () {
        return confirm("¿Está seguro de que desea eliminar la declaración jurada?");
    });

});
