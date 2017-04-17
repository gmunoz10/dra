$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "directiva/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_dir" },
            { "data": "nomb_gdi" },
            { "data": "nume_dir" },
            { "data": "fech_dir_d" },
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

    function check_nume_dir(value, element, fech_dir) {
        valid = true;
        if (fech_dir != "") {
            $.ajax({
                type: 'post',
                url: base_url + 'directiva/check_nume_dir',
                async: false,
                data: {
                    nume_dir: value,
                    fech_dir: fech_dir,
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

    jQuery.validator.addMethod("check_nume_dir", function(value, element) {
            valid = true;
            if ($('#form_directiva :input[name="fech_dir"]').val() != "") {
                $.ajax({
                    type: 'post',
                    url: base_url + 'directiva/check_nume_dir',
                    async: false,
                    data: {
                        nume_dir: value,
                        fech_dir: $('#form_directiva :input[name="fech_dir"]').val(),
                    },
                    success: function(result) {
                        if (result == "false") {
                            valid = false;
                        }
                    }
                });
            }
            return valid;
    }, "El número de directiva ya existe.");

    jQuery.validator.addMethod("check_nume_dir_actualizar", function(value, element) {
            valid = true;
            if ($('#form_directiva :input[name="fech_dir"]').val() != "") {
                $.ajax({
                    type: 'post',
                    url: base_url + 'directiva/check_nume_dir_actualizar',
                    async: false,
                    data: {
                        codi_dir: $('#form_directiva :input[name="codi_dir"]').val(),
                        nume_dir: value,
                        fech_dir: $('#form_directiva :input[name="fech_dir"]').val(),
                    },
                    success: function(result) {
                        if (result == "false") {
                            valid = false;
                        }
                    }
                });
            }
            return valid;
    }, "El número de directiva ya existe.");

    $('input[name="docu_dir"]').fileinput({
        language: "dral",
        showUpload: false
    });

    $('input[name="fech_dir"]').parent().datetimepicker({
        viewMode: 'years',
        locale: 'es',
        format: 'YYYY-MM-DD'
    });

    var $form_directiva = $('#form_directiva');

    var isDestroyable = false;

    function agregar_fila() {
        var create = true;

        $("#table_multi tbody tr").each(function(e, v) {
            if ($(this).find('.nume_dir').val() == "" && $(this).find('.desc_dir').val() == "" && $(this).find('.fech_dir').val() == "" && $(this).find('.docu_dir').get(0).files.length === 0) {
                create = false;
                return;
            }
        });

        if (create) {
            var num = $("#table_multi tbody tr").length;
            select_view = $("<div>"+$("#select_view").html()+"</div>");
            select_view.find(".codi_gdi").attr("name", "codi_gdi_"+num);
            $("#table_multi tbody").append('<tr> <td> ' + select_view.html() + ' </td> <td> <input class="form-control nume_dir" name="nume_dir_'+num+'"> </td> <td> <div class="input-group date box-date"> <input type="text" class="form-control fech_dir" name="fech_dir_'+num+'" /> <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"> </span> </span> </div> </td> <td> <textarea class="form-control desc_dir" rows="1" name="desc_dir_'+num+'"></textarea> </td> <td> <input name="docu_dir_'+num+'" type="file" class="file-loading docu_dir" data-allowed-file-extensions=\'["pdf", "doc", "docx"]\' data-show-preview="false"> </td> </tr>');
            $('#form_directiva_multi [name="count_rows"]').val($("#table_multi tbody tr").length);

            $('.docu_dir').fileinput({
                language: "dral",
                showUpload: false
            });

            $('.fech_dir').parent().datetimepicker({
                viewMode: 'years',
                locale: 'es',
                format: 'YYYY-MM-DD'
            });
        }
    }

    agregar_fila();

    var valid_nume_dir = true;

    $(document).on('click', '#btn_directiva', function () {
        $("#table_multi tbody").html("");
        agregar_fila();

        $("#modal_directiva_lbl").html('<input type="checkbox" data-width="150" checked data-toggle="toggle" data-onstyle="primary" data-offstyle="info" data-on=\'<i class="fa fa-cube" aria-hidden="true"></i> Modo normal\' data-off=\'<i class="fa fa-cubes" aria-hidden="true"></i> Modo múltiple\' class="check_mode"> Nueva directiva');
        
        $('[data-toggle="toggle"]').bootstrapToggle();

        $form_directiva.get(0).reset();

        $form_directiva.attr("action", base_url+"directiva/save");

        $form_directiva.submit(function(e) {
            if ($form_directiva.attr("action") == base_url+"directiva/save" && $('.check_mode').is(':checked')) {
                $("#submit_directiva").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_directiva").prop('disabled', true);
                if (!validator_directiva.form()) {
                    $("#submit_directiva").html('Guardar');
                    $("#submit_directiva").prop('disabled', false);
                    return;
                }
            }
        });

        if (isDestroyable) {
            validator_directiva.destroy();
        }
        
        validator_directiva = $form_directiva.validate({
            rules: {
                nume_dir: {
                    required: true,
                    check_nume_dir: true
                },
                fech_dir: {
                    required: true,
                    validDate: true
                },
                desc_dir: {
                    required: true,
                },
                docu_dir: {
                    required: true,
                    accept: "application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                }
            },
            messages: {
                nume_dir: { 
                    remote: "El número de directiva ya existe"
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

        $("#modal_directiva").modal();
    });

    $(document).on('change', '.check_mode', function () {
        if ($(this).is(':checked')) {
            $form_directiva.attr("action", base_url+"directiva/save");

            $("#modal_directiva .modal-dialog").animate({width:'60%'}, 250);

            $(".directiva-uno").show(250);
            $(".directiva-multi").hide(250);

            $("#submit_directiva").show();
            $("#submit_multi_directiva").hide();
        } else {
            $form_directiva.attr("action", base_url+"directiva/save_multi");

            $("#modal_directiva .modal-dialog").animate({width:'80%'}, 250);
            
            $(".directiva-uno").hide(250);
            $(".directiva-multi").show(250);

            $("#submit_directiva").hide();
            $("#submit_multi_directiva").show();
        }
    });

    $(document).on('change, keyup', '.codi_gdi, .nume_dir, .fech_dir, .desc_dir, .docu_dir', function () {
        var fila = $(this).closest("tr");

        if (fila.find('.nume_dir').val() != "") {
            agregar_fila();
        }
    });

    $("#submit_multi_directiva").click(function() {
        valid = true;
        count_valid = 0;
        var history_nume = [];
        $("#table_multi tbody tr").each(function(e, v) {
            tr = $(this);
            valid_row = true;
            if (tr.find('.nume_dir').val() == "" && tr.find('.desc_dir').val() == "" && tr.find('.fech_dir').val() == "" && tr.find('.docu_dir').get(0).files.length === 0) {
                return true;
            }
            codi_gdi = tr.find('.codi_gdi').val();
            nume_dir = tr.find('.nume_dir').val();
            fech_dir = tr.find('.fech_dir').val();
            desc_dir = tr.find('.desc_dir').val();
            docu_dir = tr.find('.docu_dir').get(0).files.length;

            if (codi_gdi === "") {
                tr.find('.codi_gdi').parent().removeClass('has-success').addClass('has-error');
                tr.find('.codi_gdi').parent().find('.error').remove();
                tr.find('.codi_gdi').parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                tr.find('.codi_gdi').parent().removeClass('has-error').addClass('has-success');
                tr.find('.codi_gdi').parent().find('.error').remove();
            }

            if (nume_dir === "") {
                tr.find('.nume_dir').parent().removeClass('has-success').addClass('has-error');
                tr.find('.nume_dir').parent().find(".error").remove();
                tr.find('.nume_dir').parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                $.ajax({
                    type: 'post',
                    url: base_url + 'directiva/check_nume_dir',
                    async: false,
                    data: {
                        nume_dir: nume_dir
                    },
                    success: function(result) {
                        if (result == "false") {
                            tr.find('.nume_dir').parent().removeClass('has-success').addClass('has-error');
                            tr.find('.nume_dir').parent().find(".error").remove();
                            tr.find('.nume_dir').parent().append('<label class="error">El número de directiva ya existe.</label>');
                            valid = false;
                            valid_row = false;
                        } else {
                            check = false;
                            for (var i = 0; i < history_nume.length; i++) {
                                if (history_nume[i] == nume_dir) {
                                    check = true;
                                    break;
                                }
                            }
                            if (check) {
                                tr.find('.nume_dir').parent().removeClass('has-success').addClass('has-error');
                                tr.find('.nume_dir').parent().find(".error").remove();
                                tr.find('.nume_dir').parent().append('<label class="error">Ya has agregado el mismo número de directiva.</label>');
                                valid = false;
                                valid_row = false;
                            } else {
                                tr.find('.nume_dir').parent().removeClass('has-error').addClass('has-success');
                                tr.find('.nume_dir').parent().find('.error').remove();
                                history_nume.push(nume_dir);
                            }
                        }
                    }
                });
            }

            if (fech_dir === "") {
                tr.find('.fech_dir').parent().removeClass('has-success').addClass('has-error');
                tr.find('.fech_dir').parent().parent().find('.error').remove();
                tr.find('.fech_dir').parent().parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                if (!validar_fecha(fech_dir, tr.find('.fech_dir'))) {
                    tr.find('.fech_dir').parent().removeClass('has-success').addClass('has-error');
                    tr.find('.fech_dir').parent().parent().find('.error').remove();
                    tr.find('.fech_dir').parent().parent().append('<label class="error">Por favor, ingrese una fecha válida en el formato YYYY-MM-DD.</label>');
                    valid = false;
                    valid_row = false;
                } else {
                    tr.find('.fech_dir').parent().removeClass('has-error').addClass('has-success');
                    tr.find('.fech_dir').parent().parent().find('.error').remove();
                }
            }

            if (desc_dir === "") {
                tr.find('.desc_dir').parent().removeClass('has-success').addClass('has-error');
                tr.find('.desc_dir').parent().find('.error').remove();
                tr.find('.desc_dir').parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                tr.find('.desc_dir').parent().removeClass('has-error').addClass('has-success');
                tr.find('.desc_dir').parent().find('.error').remove();
            }
            
            if (docu_dir === 0) {
                tr.find('.docu_dir').parent().parent().parent().removeClass('has-success').addClass('has-error');
                tr.find('.docu_dir').parent().parent().parent().parent().parent().find('.error').remove();
                tr.find('.docu_dir').parent().parent().parent().parent().parent().append('<label class="error">Este campo es obligatorio.</label>');
                valid = false;
                valid_row = false;
            } else {
                tr.find('.docu_dir').parent().parent().parent().removeClass('has-error').addClass('has-success');
                tr.find('.docu_dir').parent().parent().parent().parent().parent().find('.error').remove();
            }

            if (valid_row) {

                if (!check_nume_dir(nume_dir, tr.find('.nume_dir'), fech_dir)) {
                    tr.find('.nume_dir').parent().removeClass('has-success').addClass('has-error');
                    tr.find('.nume_dir').parent().find('.error').remove();
                    tr.find('.nume_dir').parent().append('<label class="error">El número de directiva ya existe.</label>');
                    valid = false;
                    valid_row = false;
                } else {
                    tr.find('.nume_dir').parent().removeClass('has-error').addClass('has-success');
                    tr.find('.nume_dir').parent().find('.error').remove();
                }

                count_valid++;
            }
        });
            
        if (count_valid == 0) {
            show_toast("error", "Por favor, complete al menos una directiva");
        } else if (valid) {
            $('#form_directiva [name="count_rows"]').val($("#table_multi tbody tr").length);
            $('#form_directiva').submit();
        }
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_directiva.get(0).reset();

        $("#modal_directiva .modal-dialog").animate({width:'60%'}, 250);

        $(".directiva-uno").show(250);
        $(".directiva-multi").hide(250);

        $("#submit_directiva").show();
        $("#submit_multi_directiva").hide();

        $('#form_directiva select[name="codi_gdi"] option[value="'+data.codi_gdi+'"]').prop("selected", true);  
        $('#form_directiva :input[name="codi_dir"]').val(data.codi_dir);  
        $('#form_directiva :input[name="nume_dir"]').val(data.nume_dir);  
        $('#form_directiva :input[name="fech_dir"]').val(data.fech_dir);  
        $('#form_directiva :input[name="desc_dir"]').val(data.desc_dir);  

        $("#modal_directiva_lbl").html("Modificar directiva");

        $.removeData($form_directiva.get(0),'validator');

        $form_directiva.attr("action", base_url+"directiva/update");

        $form_directiva.submit(function(e) {
            if (!validator_directiva.form()) {
                return;
            } else {
                $("#submit_directiva").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_directiva").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_directiva.destroy();
        }
        
        validator_directiva = $form_directiva.validate({
            rules: {
                nume_dir: {
                    required: true,
                    check_nume_dir_actualizar: true
                },
                fech_dir: {
                    required: true,
                    validDate: true
                },
                desc_dir: {
                    required: true,
                },
                docu_dir: {
                    accept: "application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                }
            },
            messages: {
                nume_dir: { 
                    remote: "El número de directiva ya existe"
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

        $("#modal_directiva").modal();
    });

    $(document).on('submit', '.habilitar_directiva', function () {
        return confirm("¿Está seguro de que desea habilitar la directiva?");
    });

    $(document).on('submit', '.deshabilitar_directiva', function () {
        return confirm("¿Está seguro de que desea deshabilitar la directiva?");
    });

    $(document).on('submit', '.eliminar_directiva', function () {
        return confirm("¿Está seguro de que desea eliminar la directiva?");
    });

});
