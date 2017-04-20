$(function() {

    $('input[name="imag_ial[]"]').fileinput({
        language: "dral",
        showUpload: false
    });

    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        console.log($(this).attr("class"));
            $(this).ekkoLightbox();
    });

    $(document).on('click', '.btn-delete-imagen', function(event) {
        event.preventDefault();
        if (confirm("¿Está seguro de que desea eliminar la imagen?")) {
            $('#form_imagen_delete input[name="codi_ial"]').val($(this).data("codi"));
            $('#form_imagen_delete').submit();
        }
    });

    var $form_galeria = $('#form_galeria');

    var isDestroyable = false;

    $("#btn_nuevo_album").click(function() {
        $("#modal_galeria_lbl").html("Nuevo álbum de imágenes");

        $form_galeria.get(0).reset();

        $form_galeria.attr("action", base_url+"galeria/save_album");

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

});
