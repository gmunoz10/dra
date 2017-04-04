$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "grupo_resolucion/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_gre" },
            { "data": "nomb_gre" },
            { "data": "estado" },
            { "data": "opciones" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "displayLength": 10
    });

    var $form_grupo_resolucion = $('#form_grupo_resolucion');

    var isDestroyable = false;

    $("#btn_grupo_resolucion").click(function() {
        $("#modal_grupo_resolucion_lbl").html("Nuevo grupo de resolución");

        $form_grupo_resolucion.get(0).reset();

        $form_grupo_resolucion.attr("action", base_url+"grupo_resolucion/save");

        $form_grupo_resolucion.submit(function(e) {
            if (!validator_grupo_resolucion.form()) {
                return;
            } else {
                $("#submit_grupo_resolucion").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_grupo_resolucion").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_grupo_resolucion.destroy();
        }
        
        validator_grupo_resolucion = $form_grupo_resolucion.validate({
            rules: {
                nomb_gre: {
                    required: true,
                    remote: {
                        url: base_url+"grupo_resolucion/check_nomb_gre",
                        type: "post",
                        data:
                        {
                            nomb_gre: function()
                            {
                                return $('#form_grupo_resolucion :input[name="nomb_gre"]').val();
                            }
                        }
                    }         
                },
            },
            messages: {
                nomb_gre: { 
                    remote: "El nombre de grupo ya existe"
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

        $("#modal_grupo_resolucion").modal();
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_grupo_resolucion.get(0).reset();

        $('#form_grupo_resolucion :input[name="codi_gre"]').val(data.codi_gre);  
        $('#form_grupo_resolucion :input[name="nomb_gre"]').val(data.nomb_gre);  

        $("#modal_grupo_resolucion_lbl").html("Modificar grupo");

        $.removeData($form_grupo_resolucion.get(0),'validator');

        $form_grupo_resolucion.attr("action", base_url+"grupo_resolucion/update");

        $form_grupo_resolucion.submit(function(e) {
            if (!validator_grupo_resolucion.form()) {
                return;
            } else {
                $("#submit_grupo_resolucion").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_grupo_resolucion").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_grupo_resolucion.destroy();
        }
        
        validator_grupo_resolucion = $form_grupo_resolucion.validate({
            rules: {
                nomb_gre: {
                    required: true,
                    remote: {
                        url: base_url+"grupo_resolucion/check_nomb_gre_actualizar",
                        type: "post",
                        data:
                        {
                            codi_gre: function()
                            {
                                return $('#form_grupo_resolucion :input[name="codi_gre"]').val();
                            },
                            nomb_gre: function()
                            {
                                return $('#form_grupo_resolucion :input[name="nomb_gre"]').val();
                            }
                        }
                    }         
                },
            },
            messages: {
                nomb_gre: { 
                    remote: "El nombre de grupo ya existe"
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

        $("#modal_grupo_resolucion").modal();
    });

    $(document).on('submit', '.habilitar_grupo_resolucion', function () {
        return confirm("¿Está seguro de que desea habilitar el grupo de resolución?");
    });

    $(document).on('submit', '.deshabilitar_grupo_resolucion', function () {
        return confirm("¿Está seguro de que desea deshabilitar el grupo de resolución?");
    });

    $(document).on('submit', '.eliminar_grupo_resolucion', function () {
        return confirm("¿Está seguro de que desea eliminar el grupo de resolución?");
    });

});
