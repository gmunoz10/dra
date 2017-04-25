$(function() {

    $('[data-toggle="tooltip"]').tooltip();

    $('input[name="imag_ial[]"]').fileinput({
        language: "dral",
        showUpload: false
    });

    $('input[name="fech_alb"]').parent().datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        locale: 'es'
    });

    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

    $(document).on('click', '.btn-delete-imagen', function(event) {
        event.preventDefault();
        if (confirm("¿Está seguro de que desea eliminar la imagen?")) {
            $('#form_custom').attr("action", base_url+'galeria/eliminar_imagen');
            $('#form_custom input[name="codigo"]').val($(this).data("codi"));
            $('#form_custom').submit();
        }
    });

    var $form_galeria = $('#form_galeria');

    var isDestroyable = false;

    $("#btn_nuevo_album").click(function() {
        $("#modal_galeria_lbl").html("Nuevo álbum de imágenes");

        $('.box-titulo-album').show();
        $('.box-fecha-album').show();
        $('.box-imagen-upload').show();

        $form_galeria.get(0).reset();

        $form_galeria.attr("action", base_url+"galeria/save_album");

        $('#form_galeria :input[name="fech_alb"]').val(moment().format("YYYY-MM-DD HH:mm"));  

        $form_galeria.submit(function(e) {
            if (!validator_galeria.form()) {
                return;
            } else {
                $("#submit_galeria").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_galeria").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_galeria.destroy();
        }
        
        validator_galeria = $form_galeria.validate({
            rules: {
                titu_alb: {
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

        $("#modal_galeria").modal();
    });

    $(document).on('click', '.btn-change-album', function(event) {
        $("#modal_galeria_lbl").html("Cambiar título");

        $('.box-titulo-album').show();
        $('.box-fecha-album').hide();
        $('.box-imagen-upload').hide();

        $form_galeria.get(0).reset();

        $form_galeria.find('[name="codi_alb"]').val($(this).data("codi"));
        $form_galeria.find('[name="titu_alb"]').val($(this).data("titu"));

        $form_galeria.attr("action", base_url+"galeria/update_title_album");

        $form_galeria.submit(function(e) {
            if (!validator_galeria.form()) {
                return;
            } else {
                $("#submit_galeria").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_galeria").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_galeria.destroy();
        }
        
        validator_galeria = $form_galeria.validate({
            rules: {
                titu_alb: {
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

        $("#modal_galeria").modal();

    });

    $(document).on('click', '.btn-fecha-album', function(event) {
        $("#modal_galeria_lbl").html("Cambiar fecha de publicación");

        $('.box-titulo-album').hide();
        $('.box-fecha-album').show();
        $('.box-imagen-upload').hide();

        $form_galeria.get(0).reset();

        $form_galeria.find('[name="codi_alb"]').val($(this).data("codi"));
        $form_galeria.find('[name="fech_alb"]').val($(this).data("fech"));

        $form_galeria.attr("action", base_url+"galeria/upload_fecha");

        $form_galeria.submit(function(e) {
            if (!validator_galeria.form()) {
                return;
            } else {
                $("#submit_galeria").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_galeria").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_galeria.destroy();
        }
        
        $("label.error").hide();
        $(".error").removeClass("error");
        $("label.success").hide();
        $(".success").removeClass("success");

        $("#modal_galeria").modal();

    });

    $(document).on('click', '.btn-upload-album', function(event) {
        $("#modal_galeria_lbl").html("Subir imágenes");

        $('.box-titulo-album').hide();
        $('.box-fecha-album').hide();
        $('.box-imagen-upload').show();

        $form_galeria.get(0).reset();

        $form_galeria.find('[name="codi_alb"]').val($(this).data("codi"));

        $form_galeria.attr("action", base_url+"galeria/upload_album");

        $form_galeria.submit(function(e) {
            if (!validator_galeria.form()) {
                return;
            } else {
                $("#submit_galeria").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_galeria").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_galeria.destroy();
        }
        
        $("label.error").hide();
        $(".error").removeClass("error");
        $("label.success").hide();
        $(".success").removeClass("success");

        $("#modal_galeria").modal();

    });

    $(document).on('click', '.btn-habilitar-album', function(event) {
        if (confirm("¿Está seguro de que desea habilitar el álbum?")) {
            $('#form_custom').attr("action", base_url+'galeria/habilitar');
            $('#form_custom input[name="codigo"]').val($(this).data("codi"));
            $('#form_custom').submit();
        }
    });

    $(document).on('click', '.btn-deshabilitar-album', function(event) {
        if (confirm("¿Está seguro de que desea deshabilitar el álbum?")) {
            $('#form_custom').attr("action", base_url+'galeria/deshabilitar');
            $('#form_custom input[name="codigo"]').val($(this).data("codi"));
            $('#form_custom').submit();
        }
    });

    $(document).on('click', '.btn-delete-album', function(event) {
        if (confirm("¿Está seguro de que desea eliminar el álbum?")) {
            $('#form_custom').attr("action", base_url+'galeria/eliminar');
            $('#form_custom input[name="codigo"]').val($(this).data("codi"));
            $('#form_custom').submit();
        }
    });

    $(document).on('click', '#btn_search', function(event) {
        window.location.href = base_url+"galeria/admin?search="+encodeURI($("#txt_search").val());
    });

});
