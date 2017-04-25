$(function() {

    var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "pac/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_pac" },
            { "data": "nomb_gpa" },
            { "data": "nume_pac" },
            { "data": "fech_pac_d" },
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

    function check_nume_pac(value, element, fech_pac) {
        valid = true;
        if (fech_pac != "") {
            $.ajax({
                type: 'post',
                url: base_url + 'pac/check_nume_pac',
                async: false,
                data: {
                    nume_pac: value,
                    fech_pac: fech_pac,
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

    jQuery.validator.addMethod("check_nume_pac", function(value, element) {
            valid = true;
            if ($('#form_pac :input[name="fech_pac"]').val() != "") {
                $.ajax({
                    type: 'post',
                    url: base_url + 'pac/check_nume_pac',
                    async: false,
                    data: {
                        nume_pac: value,
                        fech_pac: $('#form_pac :input[name="fech_pac"]').val(),
                    },
                    success: function(result) {
                        if (result == "false") {
                            valid = false;
                        }
                    }
                });
            }
            return valid;
    }, "El número de PAC ya existe.");

    jQuery.validator.addMethod("check_nume_pac_actualizar", function(value, element) {
            valid = true;
            if ($('#form_pac :input[name="fech_pac"]').val() != "") {
                $.ajax({
                    type: 'post',
                    url: base_url + 'pac/check_nume_pac_actualizar',
                    async: false,
                    data: {
                        codi_pac: $('#form_pac :input[name="codi_pac"]').val(),
                        nume_pac: value,
                        fech_pac: $('#form_pac :input[name="fech_pac"]').val(),
                    },
                    success: function(result) {
                        if (result == "false") {
                            valid = false;
                        }
                    }
                });
            }
            return valid;
    }, "El número de PAC ya existe.");

    $('input[name="docu_pac"]').fileinput({
        language: "dral",
        showUpload: false
    });

    $('input[name="fech_pac"]').parent().datetimepicker({
        viewMode: 'years',
        locale: 'es',
        format: 'YYYY-MM-DD'
    });

    var $form_pac = $('#form_pac');

    var isDestroyable = false;

    function agregar_fila() {
        var create = true;

        $("#table_multi tbody tr").each(function(e, v) {
            if ($(this).find('.nume_pac').val() == "" && $(this).find('.desc_pac').val() == "" && $(this).find('.fech_pac').val() == "" && $(this).find('.docu_pac').get(0).files.length === 0) {
                create = false;
                return;
            }
        });

        if (create) {
            var num = $("#table_multi tbody tr").length;
            select_view = $("<div>"+$("#select_view").html()+"</div>");
            select_view.find(".codi_gpa").attr("name", "codi_gpa_"+num);
            $("#table_multi tbody").append('<tr> <td> ' + select_view.html() + ' </td> <td> <input class="form-control nume_pac" name="nume_pac_'+num+'"> </td> <td> <div class="input-group date box-date"> <input type="text" class="form-control fech_pac" name="fech_pac_'+num+'" /> <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"> </span> </span> </div> </td> <td> <textarea class="form-control desc_pac" rows="1" name="desc_pac_'+num+'"></textarea> </td> <td> <input name="docu_pac_'+num+'" type="file" class="file-loading docu_pac" data-allowed-file-extensions=\'["pdf", "doc", "docx"]\' data-show-preview="false"> </td> </tr>');
            $('#form_pac_multi [name="count_rows"]').val($("#table_multi tbody tr").length);

            $('.docu_pac').fileinput({
                language: "dral",
                showUpload: false
            });

            $('.fech_pac').parent().datetimepicker({
                viewMode: 'years',
                locale: 'es',
                format: 'YYYY-MM-DD'
            });
        }
    }

    agregar_fila();

    var valid_nume_pac = true;

    $(document).on('click', '#btn_pac', function () {
        $("#table_multi tbody").html("");
        agregar_fila();

        $("#modal_pac_lbl").html('<input type="checkbox" data-width="150" checked data-toggle="toggle" data-onstyle="primary" data-offstyle="info" data-on=\'<i class="fa fa-cube" aria-hidden="true"></i> Modo normal\' data-off=\'<i class="fa fa-cubes" aria-hidden="true"></i> Modo múltiple\' class="check_mode"> Nuevo PAC');
        
        $('[data-toggle="toggle"]').bootstrapToggle();

        $form_pac.get(0).reset();

        $form_pac.attr("action", base_url+"pac/save");

        $form_pac.submit(function(e) {
            if ($form_pac.attr("action") == base_url+"pac/save" && $('.check_mode').is(':checked')) {
                $("#submit_pac").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_pac").prop('disabled', true);
                if (!validator_pac.form()) {
                    $("#submit_pac").html('Guardar');
                    $("#submit_pac").prop('disabled', false);
                    return;
                }
            }
        });

        if (isDestroyable) {
            validator_pac.destroy();
        }
        
        validator_pac = $form_pac.validate({
            rules: {
                nume_pac: {
                    required: true,
                    check_nume_pac: true
                },
                fech_pac: {
                    required: true,
                    validDate: true
                },
                desc_pac: {
                    required: true,
                },
                docu_pac: {
                    required: true,
                    accept: "application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                }
            },
            messages: {
                nume_pac: { 
                    remote: "El número de PAC ya existe"
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

        $("#modal_pac").modal();
    });

    $(document).on('change', '.check_mode', function () {
        if ($(this).is(':checked')) {
            $form_pac.attr("action", base_url+"pac/save");

            $("#modal_pac .modal-dialog").animate({width:'60%'}, 250);

            $(".pac-uno").show(250);
            $(".pac-multi").hide(250);

            $("#submit_pac").show();
            $("#submit_multi_pac").hide();
        } else {
            $form_pac.attr("action", base_url+"pac/save_multi");

            $("#modal_pac .modal-dialog").animate({width:'80%'}, 250);
            
            $(".pac-uno").hide(250);
            $(".pac-multi").show(250);

            $("#submit_pac").hide();
            $("#submit_multi_pac").show();
        }
    });

    $(document).on('change, keyup', '.codi_gpa, .nume_pac, .fech_pac, .desc_pac, .docu_pac', function () {
        var fila = $(this).closest("tr");

        if (fila.find('.nume_pac').val() != "") {
            agregar_fila();
        }
    });

    $("#submit_multi_pac").click(function() {
        valid = true;
        count_valid = 0;
        var history_nume = [];
        $("#table_multi tbody tr").each(function(e, v) {
            tr = $(this);
            valid_row = true;
            if (tr.find('.nume_pac').val() == "" && tr.find('.desc_pac').val() == "" && tr.find('.fech_pac').val() == "" && tr.find('.docu_pac').get(0).files.length === 0) {
                return true;
            }
            codi_gpa = tr.find('.codi_gpa').val();
            nume_pac = tr.find('.nume_pac').val();
            fech_pac = tr.find('.fech_pac').val();
            desc_pac = tr.find('.desc_pac').val();
            docu_pac = tr.find('.docu_pac').get(0).files.length;

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

            if (nume_pac === "") {
                tr.find('.nume_pac').parent().removeClass('has-success').addClass('has-error');
                tr.find('.nume_pac').parent().find(".error").remove();
                tr.find('.nume_pac').parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                $.ajax({
                    type: 'post',
                    url: base_url + 'pac/check_nume_pac',
                    async: false,
                    data: {
                        nume_pac: nume_pac
                    },
                    success: function(result) {
                        if (result == "false") {
                            tr.find('.nume_pac').parent().removeClass('has-success').addClass('has-error');
                            tr.find('.nume_pac').parent().find(".error").remove();
                            tr.find('.nume_pac').parent().append('<label class="error">El número de PAC ya existe.</label>');
                            valid = false;
                            valid_row = false;
                        } else {
                            check = false;
                            for (var i = 0; i < history_nume.length; i++) {
                                if (history_nume[i] == nume_pac) {
                                    check = true;
                                    break;
                                }
                            }
                            if (check) {
                                tr.find('.nume_pac').parent().removeClass('has-success').addClass('has-error');
                                tr.find('.nume_pac').parent().find(".error").remove();
                                tr.find('.nume_pac').parent().append('<label class="error">Ya has agregado el mismo número de PAC.</label>');
                                valid = false;
                                valid_row = false;
                            } else {
                                tr.find('.nume_pac').parent().removeClass('has-error').addClass('has-success');
                                tr.find('.nume_pac').parent().find('.error').remove();
                                history_nume.push(nume_pac);
                            }
                        }
                    }
                });
            }

            if (fech_pac === "") {
                tr.find('.fech_pac').parent().removeClass('has-success').addClass('has-error');
                tr.find('.fech_pac').parent().parent().find('.error').remove();
                tr.find('.fech_pac').parent().parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                if (!validar_fecha(fech_pac, tr.find('.fech_pac'))) {
                    tr.find('.fech_pac').parent().removeClass('has-success').addClass('has-error');
                    tr.find('.fech_pac').parent().parent().find('.error').remove();
                    tr.find('.fech_pac').parent().parent().append('<label class="error">Por favor, ingrese una fecha válida en el formato YYYY-MM-DD.</label>');
                    valid = false;
                    valid_row = false;
                } else {
                    tr.find('.fech_pac').parent().removeClass('has-error').addClass('has-success');
                    tr.find('.fech_pac').parent().parent().find('.error').remove();
                }
            }

            if (desc_pac === "") {
                tr.find('.desc_pac').parent().removeClass('has-success').addClass('has-error');
                tr.find('.desc_pac').parent().find('.error').remove();
                tr.find('.desc_pac').parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                tr.find('.desc_pac').parent().removeClass('has-error').addClass('has-success');
                tr.find('.desc_pac').parent().find('.error').remove();
            }
            
            if (docu_pac === 0) {
                tr.find('.docu_pac').parent().parent().parent().removeClass('has-success').addClass('has-error');
                tr.find('.docu_pac').parent().parent().parent().parent().parent().find('.error').remove();
                tr.find('.docu_pac').parent().parent().parent().parent().parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                tr.find('.docu_pac').parent().parent().parent().removeClass('has-error').addClass('has-success');
                tr.find('.docu_pac').parent().parent().parent().parent().parent().find('.error').remove();
            }

            if (valid_row) {

                if (!check_nume_pac(nume_pac, tr.find('.nume_pac'), fech_pac)) {
                    tr.find('.nume_pac').parent().removeClass('has-success').addClass('has-error');
                    tr.find('.nume_pac').parent().find('.error').remove();
                    tr.find('.nume_pac').parent().append('<label class="error">El número de PAC ya existe.</label>');
                    valid = false;
                    valid_row = false;
                } else {
                    tr.find('.nume_pac').parent().removeClass('has-error').addClass('has-success');
                    tr.find('.nume_pac').parent().find('.error').remove();
                }

                count_valid++;
            }
        });
            
        if (count_valid == 0) {
            show_toast("error", "Por favor, complete al menos un formulario de PAC");
        } else if (valid) {
            $('#form_pac [name="count_rows"]').val($("#table_multi tbody tr").length);
            $('#form_pac').submit();
        }
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_pac.get(0).reset();

        $("#modal_pac .modal-dialog").animate({width:'60%'}, 250);

        $(".pac-uno").show(250);
        $(".pac-multi").hide(250);

        $("#submit_pac").show();
        $("#submit_multi_pac").hide();

        $('#form_pac select[name="codi_gpa"] option[value="'+data.codi_gpa+'"]').prop("selected", true);  
        $('#form_pac :input[name="codi_pac"]').val(data.codi_pac);  
        $('#form_pac :input[name="nume_pac"]').val(data.nume_pac);  
        $('#form_pac :input[name="fech_pac"]').val(data.fech_pac);  
        $('#form_pac :input[name="desc_pac"]').val(data.desc_pac);  

        $("#modal_pac_lbl").html("Modificar PAC");

        $.removeData($form_pac.get(0),'validator');

        $form_pac.attr("action", base_url+"pac/update");

        $form_pac.submit(function(e) {
            if (!validator_pac.form()) {
                return;
            } else {
                $("#submit_pac").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_pac").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_pac.destroy();
        }
        
        validator_pac = $form_pac.validate({
            rules: {
                nume_pac: {
                    required: true,
                    check_nume_pac_actualizar: true
                },
                fech_pac: {
                    required: true,
                    validDate: true
                },
                desc_pac: {
                    required: true,
                },
                docu_pac: {
                    accept: "application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                }
            },
            messages: {
                nume_pac: { 
                    remote: "El número de PAC ya existe"
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

        $("#modal_pac").modal();
    });

    $(document).on('submit', '.habilitar_pac', function () {
        return confirm("¿Está seguro de que desea habilitar PAC?");
    });

    $(document).on('submit', '.deshabilitar_pac', function () {
        return confirm("¿Está seguro de que desea deshabilitar PAC?");
    });

    $(document).on('submit', '.eliminar_pac', function () {
        return confirm("¿Está seguro de que desea eliminar PAC?");
    });

});
