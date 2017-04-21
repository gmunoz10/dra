$(function() {

    var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "pap/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_pap" },
            { "data": "nomb_gpa" },
            { "data": "nume_pap" },
            { "data": "fech_pap_d" },
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

    function check_nume_pap(value, element, fech_pap) {
        valid = true;
        if (fech_pap != "") {
            $.ajax({
                type: 'post',
                url: base_url + 'pap/check_nume_pap',
                async: false,
                data: {
                    nume_pap: value,
                    fech_pap: fech_pap,
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

    jQuery.validator.addMethod("check_nume_pap", function(value, element) {
            valid = true;
            if ($('#form_pap :input[name="fech_pap"]').val() != "") {
                $.ajax({
                    type: 'post',
                    url: base_url + 'pap/check_nume_pap',
                    async: false,
                    data: {
                        nume_pap: value,
                        fech_pap: $('#form_pap :input[name="fech_pap"]').val(),
                    },
                    success: function(result) {
                        if (result == "false") {
                            valid = false;
                        }
                    }
                });
            }
            return valid;
    }, "El número de PAP ya existe.");

    jQuery.validator.addMethod("check_nume_pap_actualizar", function(value, element) {
            valid = true;
            if ($('#form_pap :input[name="fech_pap"]').val() != "") {
                $.ajax({
                    type: 'post',
                    url: base_url + 'pap/check_nume_pap_actualizar',
                    async: false,
                    data: {
                        codi_pap: $('#form_pap :input[name="codi_pap"]').val(),
                        nume_pap: value,
                        fech_pap: $('#form_pap :input[name="fech_pap"]').val(),
                    },
                    success: function(result) {
                        if (result == "false") {
                            valid = false;
                        }
                    }
                });
            }
            return valid;
    }, "El número de PAP ya existe.");

    $('input[name="docu_pap"]').fileinput({
        language: "dral",
        showUpload: false
    });

    $('input[name="fech_pap"]').parent().datetimepicker({
        viewMode: 'years',
        locale: 'es',
        format: 'YYYY-MM-DD'
    });

    var $form_pap = $('#form_pap');

    var isDestroyable = false;

    function agregar_fila() {
        var create = true;

        $("#table_multi tbody tr").each(function(e, v) {
            if ($(this).find('.nume_pap').val() == "" && $(this).find('.desc_pap').val() == "" && $(this).find('.fech_pap').val() == "" && $(this).find('.docu_pap').get(0).files.length === 0) {
                create = false;
                return;
            }
        });

        if (create) {
            var num = $("#table_multi tbody tr").length;
            select_view = $("<div>"+$("#select_view").html()+"</div>");
            select_view.find(".codi_gpa").attr("name", "codi_gpa_"+num);
            $("#table_multi tbody").append('<tr> <td> ' + select_view.html() + ' </td> <td> <input class="form-control nume_pap" name="nume_pap_'+num+'"> </td> <td> <div class="input-group date box-date"> <input type="text" class="form-control fech_pap" name="fech_pap_'+num+'" /> <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"> </span> </span> </div> </td> <td> <textarea class="form-control desc_pap" rows="1" name="desc_pap_'+num+'"></textarea> </td> <td> <input name="docu_pap_'+num+'" type="file" class="file-loading docu_pap" data-allowed-file-extensions=\'["pdf", "doc", "docx"]\' data-show-preview="false"> </td> </tr>');
            $('#form_pap_multi [name="count_rows"]').val($("#table_multi tbody tr").length);

            $('.docu_pap').fileinput({
                language: "dral",
                showUpload: false
            });

            $('.fech_pap').parent().datetimepicker({
                viewMode: 'years',
                locale: 'es',
                format: 'YYYY-MM-DD'
            });
        }
    }

    agregar_fila();

    var valid_nume_pap = true;

    $(document).on('click', '#btn_pap', function () {
        $("#table_multi tbody").html("");
        agregar_fila();

        $("#modal_pap_lbl").html('<input type="checkbox" data-width="150" checked data-toggle="toggle" data-onstyle="primary" data-offstyle="info" data-on=\'<i class="fa fa-cube" aria-hidden="true"></i> Modo normal\' data-off=\'<i class="fa fa-cubes" aria-hidden="true"></i> Modo múltiple\' class="check_mode"> Nuevo PAP');
        
        $('[data-toggle="toggle"]').bootstrapToggle();

        $form_pap.get(0).reset();

        $form_pap.attr("action", base_url+"pap/save");

        $form_pap.submit(function(e) {
            if ($form_pap.attr("action") == base_url+"pap/save" && $('.check_mode').is(':checked')) {
                $("#submit_pap").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_pap").prop('disabled', true);
                if (!validator_pap.form()) {
                    $("#submit_pap").html('Guardar');
                    $("#submit_pap").prop('disabled', false);
                    return;
                }
            }
        });

        if (isDestroyable) {
            validator_pap.destroy();
        }
        
        validator_pap = $form_pap.validate({
            rules: {
                nume_pap: {
                    required: true,
                    check_nume_pap: true
                },
                fech_pap: {
                    required: true,
                    validDate: true
                },
                desc_pap: {
                    required: true,
                },
                docu_pap: {
                    required: true,
                    accept: "application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                }
            },
            messages: {
                nume_pap: { 
                    remote: "El número de PAP ya existe"
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

        $("#modal_pap").modal();
    });

    $(document).on('change', '.check_mode', function () {
        if ($(this).is(':checked')) {
            $form_pap.attr("action", base_url+"pap/save");

            $("#modal_pap .modal-dialog").animate({width:'60%'}, 250);

            $(".pap-uno").show(250);
            $(".pap-multi").hide(250);

            $("#submit_pap").show();
            $("#submit_multi_pap").hide();
        } else {
            $form_pap.attr("action", base_url+"pap/save_multi");

            $("#modal_pap .modal-dialog").animate({width:'80%'}, 250);
            
            $(".pap-uno").hide(250);
            $(".pap-multi").show(250);

            $("#submit_pap").hide();
            $("#submit_multi_pap").show();
        }
    });

    $(document).on('change, keyup', '.codi_gpa, .nume_pap, .fech_pap, .desc_pap, .docu_pap', function () {
        var fila = $(this).closest("tr");

        if (fila.find('.nume_pap').val() != "") {
            agregar_fila();
        }
    });

    $("#submit_multi_pap").click(function() {
        valid = true;
        count_valid = 0;
        var history_nume = [];
        $("#table_multi tbody tr").each(function(e, v) {
            tr = $(this);
            valid_row = true;
            if (tr.find('.nume_pap').val() == "" && tr.find('.desc_pap').val() == "" && tr.find('.fech_pap').val() == "" && tr.find('.docu_pap').get(0).files.length === 0) {
                return true;
            }
            codi_gpa = tr.find('.codi_gpa').val();
            nume_pap = tr.find('.nume_pap').val();
            fech_pap = tr.find('.fech_pap').val();
            desc_pap = tr.find('.desc_pap').val();
            docu_pap = tr.find('.docu_pap').get(0).files.length;

            if (codi_gpa === "") {
                tr.find('.codi_gpa').parent().removeClass('has-success').addClass('has-error');
                tr.find('.codi_gpa').parent().find('.error').remove();
                tr.find('.codi_gpa').parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                tr.find('.codi_gpa').parent().removeClass('has-error').addClass('has-success');
                tr.find('.codi_gpa').parent().find('.error').remove();
            }

            if (nume_pap === "") {
                tr.find('.nume_pap').parent().removeClass('has-success').addClass('has-error');
                tr.find('.nume_pap').parent().find(".error").remove();
                tr.find('.nume_pap').parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                $.ajax({
                    type: 'post',
                    url: base_url + 'pap/check_nume_pap',
                    async: false,
                    data: {
                        nume_pap: nume_pap
                    },
                    success: function(result) {
                        if (result == "false") {
                            tr.find('.nume_pap').parent().removeClass('has-success').addClass('has-error');
                            tr.find('.nume_pap').parent().find(".error").remove();
                            tr.find('.nume_pap').parent().append('<label class="error">El número de PAP ya existe.</label>');
                            valid = false;
                            valid_row = false;
                        } else {
                            check = false;
                            for (var i = 0; i < history_nume.length; i++) {
                                if (history_nume[i] == nume_pap) {
                                    check = true;
                                    break;
                                }
                            }
                            if (check) {
                                tr.find('.nume_pap').parent().removeClass('has-success').addClass('has-error');
                                tr.find('.nume_pap').parent().find(".error").remove();
                                tr.find('.nume_pap').parent().append('<label class="error">Ya has agregado el mismo número de PAP.</label>');
                                valid = false;
                                valid_row = false;
                            } else {
                                tr.find('.nume_pap').parent().removeClass('has-error').addClass('has-success');
                                tr.find('.nume_pap').parent().find('.error').remove();
                                history_nume.push(nume_pap);
                            }
                        }
                    }
                });
            }

            if (fech_pap === "") {
                tr.find('.fech_pap').parent().removeClass('has-success').addClass('has-error');
                tr.find('.fech_pap').parent().parent().find('.error').remove();
                tr.find('.fech_pap').parent().parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                if (!validar_fecha(fech_pap, tr.find('.fech_pap'))) {
                    tr.find('.fech_pap').parent().removeClass('has-success').addClass('has-error');
                    tr.find('.fech_pap').parent().parent().find('.error').remove();
                    tr.find('.fech_pap').parent().parent().append('<label class="error">Por favor, ingrese una fecha válida en el formato YYYY-MM-DD.</label>');
                    valid = false;
                    valid_row = false;
                } else {
                    tr.find('.fech_pap').parent().removeClass('has-error').addClass('has-success');
                    tr.find('.fech_pap').parent().parent().find('.error').remove();
                }
            }

            if (desc_pap === "") {
                tr.find('.desc_pap').parent().removeClass('has-success').addClass('has-error');
                tr.find('.desc_pap').parent().find('.error').remove();
                tr.find('.desc_pap').parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                tr.find('.desc_pap').parent().removeClass('has-error').addClass('has-success');
                tr.find('.desc_pap').parent().find('.error').remove();
            }
            
            if (docu_pap === 0) {
                tr.find('.docu_pap').parent().parent().parent().removeClass('has-success').addClass('has-error');
                tr.find('.docu_pap').parent().parent().parent().parent().parent().find('.error').remove();
                tr.find('.docu_pap').parent().parent().parent().parent().parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                tr.find('.docu_pap').parent().parent().parent().removeClass('has-error').addClass('has-success');
                tr.find('.docu_pap').parent().parent().parent().parent().parent().find('.error').remove();
            }

            if (valid_row) {

                if (!check_nume_pap(nume_pap, tr.find('.nume_pap'), fech_pap)) {
                    tr.find('.nume_pap').parent().removeClass('has-success').addClass('has-error');
                    tr.find('.nume_pap').parent().find('.error').remove();
                    tr.find('.nume_pap').parent().append('<label class="error">El número de PAP ya existe.</label>');
                    valid = false;
                    valid_row = false;
                } else {
                    tr.find('.nume_pap').parent().removeClass('has-error').addClass('has-success');
                    tr.find('.nume_pap').parent().find('.error').remove();
                }

                count_valid++;
            }
        });
            
        if (count_valid == 0) {
            show_toast("error", "Por favor, complete al menos un formulario de PAP");
        } else if (valid) {
            $('#form_pap [name="count_rows"]').val($("#table_multi tbody tr").length);
            $('#form_pap').submit();
        }
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_pap.get(0).reset();

        $("#modal_pap .modal-dialog").animate({width:'60%'}, 250);

        $(".pap-uno").show(250);
        $(".pap-multi").hide(250);

        $("#submit_pap").show();
        $("#submit_multi_pap").hide();

        $('#form_pap select[name="codi_gpa"] option[value="'+data.codi_gpa+'"]').prop("selected", true);  
        $('#form_pap :input[name="codi_pap"]').val(data.codi_pap);  
        $('#form_pap :input[name="nume_pap"]').val(data.nume_pap);  
        $('#form_pap :input[name="fech_pap"]').val(data.fech_pap);  
        $('#form_pap :input[name="desc_pap"]').val(data.desc_pap);  

        $("#modal_pap_lbl").html("Modificar PAP");

        $.removeData($form_pap.get(0),'validator');

        $form_pap.attr("action", base_url+"pap/update");

        $form_pap.submit(function(e) {
            if (!validator_pap.form()) {
                return;
            } else {
                $("#submit_pap").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_pap").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_pap.destroy();
        }
        
        validator_pap = $form_pap.validate({
            rules: {
                nume_pap: {
                    required: true,
                    check_nume_pap_actualizar: true
                },
                fech_pap: {
                    required: true,
                    validDate: true
                },
                desc_pap: {
                    required: true,
                },
                docu_pap: {
                    accept: "application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                }
            },
            messages: {
                nume_pap: { 
                    remote: "El número de PAP ya existe"
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

        $("#modal_pap").modal();
    });

    $(document).on('submit', '.habilitar_pap', function () {
        return confirm("¿Está seguro de que desea habilitar PAP?");
    });

    $(document).on('submit', '.deshabilitar_pap', function () {
        return confirm("¿Está seguro de que desea deshabilitar PAP?");
    });

    $(document).on('submit', '.eliminar_pap', function () {
        return confirm("¿Está seguro de que desea eliminar PAP?");
    });

});
