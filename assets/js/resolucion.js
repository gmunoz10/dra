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

    jQuery.validator.addMethod("validDate", function(value, element) {
        return this.optional(element) || moment(value,"YYYY-MM-DD").isValid();
    }, "Por favor, ingrese una fecha válida en el formato YYYY-MM-DD");

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
        var create = false;

        if ($("#table_multi tbody tr").length == 0) {
            create = true;
        } else {
            $("#table_multi tbody tr").each(function(e, v) {
                if ($(this).find('[name="nume_res"]').val() == "") {
                    console.log("nume_res: SI");
                } else {
                    console.log("nume_res: NO");
                }
                if ($(this).find('[name="desc_res"]').html() == "") {
                    console.log("desc_res: SI");
                } else {
                    console.log("desc_res: NO");
                }
                if ($(this).find('[name="fech_res"]').val() == "") {
                    console.log("fech_res: SI");
                } else {
                    console.log("fech_res: NO");
                }
                if ($(this).find('[name="docu_res"]').get(0).files.length === 0) {
                    console.log("docu_res: SI");
                } else {
                    console.log("docu_res: NO");
                }
                if ($(this).find('[name="nume_res"]').val() == "" && $(this).find('[name="desc_res"]').html() == "" && $(this).find('[name="fech_res"]').val() == "" && $(this).find('[name="docu_res"]').get(0).files.length === 0) {
                    create = true;
                    return;
                }
            });
        }

        if (create) {
            $("#table_multi tbody").append('<tr> <td> ' + $("#select_view").html() + ' </td> <td> <input class="form-control" name="nume_res"> </td> <td> <div class="input-group date box-date"> <input type="text" class="form-control" name="fech_res" /> <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"> </span> </span> </div> </td> <td> <textarea class="form-control" rows="1" id="desc_res" name="desc_res"></textarea> </td> <td> <input name="docu_res" type="file" class="file-loading" data-allowed-file-extensions=\'["pdf", "doc", "docx"]\' data-show-preview="false"> </td> </tr>');

            $('input[name="docu_res"]').fileinput({
                language: "dral",
                showUpload: false
            });

            $('input[name="fech_res"]').parent().datetimepicker({
                viewMode: 'years',
                locale: 'es',
                format: 'YYYY-MM-DD'
            });
        }
    }

    agregar_fila();

    $(document).on('click', '#btn_resolucion', function () {
        $("#table_multi tbody").html("");
        agregar_fila();
        $("#modal_resolucion").modal();
    });

    $(document).on('change, keyup', '[name="codi_gre"], [name="nume_res"], [name="fech_res"], [name="desc_res"], [name="docu_res"]', function () {
        var fila = $(this).closest("tr");

        if (fila.find('[name="nume_res"]').val() != "") {
            agregar_fila();
        }
    });

    /*

    $("#btn_resolucion").click(function() {
        $("#modal_resolucion_lbl").html("Subir resoluciones");

        $form_resolucion.get(0).reset();

        $form_resolucion.attr("action", base_url+"resolucion/save");

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
                    remote: {
                        url: base_url+"resolucion/check_nume_res",
                        type: "post",
                        data:
                        {
                            nume_res: function()
                            {
                                return $('#form_resolucion :input[name="nume_res"]').val();
                            }
                        }
                    }         
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

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_resolucion.get(0).reset();

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
                    remote: {
                        url: base_url+"resolucion/check_nume_res_actualizar",
                        type: "post",
                        data:
                        {
                            codi_res: function()
                            {
                                return $('#form_resolucion :input[name="codi_res"]').val();
                            },
                            nume_res: function()
                            {
                                return $('#form_resolucion :input[name="nume_res"]').val();
                            }
                        }
                    }         
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

    */

});
