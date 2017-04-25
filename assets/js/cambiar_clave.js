$(function() {

    var $form_usuario = $('#form_usuario');

    $form_usuario.submit(function(e) {
        if (!validator_usuario.form()) {
            return;
        } else {
            $("#submit_usuario").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
            $("#submit_usuario").prop('disabled', true);
        }
    });

    validator_usuario = $form_usuario.validate({
        rules: {
            acon_usu: {
                required: true,           
                remote: {
                    url: base_url+"usuario/check_cont_usu",
                    type: "post",
                    data:
                    {
                        acon_usu: function()
                        {
                            return $('#form_usuario :input[name="acon_usu"]').val();
                        }
                    }
                }         
            },
            cont_usu: {
                minlength: 6, 
                required: true,           
            },
            ccon_usu: {
                minlength: 6, 
                required: true,           
                equalTo: '#form_usuario :input[name="cont_usu"]',
            },
        },
        messages: {
            acon_usu: { 
                remote: "Contraseña incorrecta"
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

});
