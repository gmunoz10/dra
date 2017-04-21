$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "evento/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_eve" },
            { "data": "nume_eve" },
            { "data": "titu_eve" },
            { "data": "fech_eve_d" },
            { "data": "estado" },
            { "data": "opciones" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": false,
        "displayLength": 10
    });

    var width_file = -1;
    var height_file = -1;


    $('#cont_eve').summernote({
        height: 200,
        lang: 'es-ES',
        callbacks : {
            onImageUpload: function(image) {
                uploadImage(image[0]);
            }
        }
    });

    function uploadImage(image) {
        var data = new FormData();
        data.append("image",image);
        $.ajax ({
            data: data,
            type: "POST",
            url: base_url+"evento/uploadImage",
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                var data = $.parseJSON(response);
                if (data.status == "error") {
                    show_toast("error", data.result);
                } else {    
                    var image = base_url + "/assets/evento/imagenes_evento/" + data.result;
                    $('#cont_eve').summernote('insertImage', image);
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    function printPreview(input, preview, default_img) {
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        if ($.inArray(input.val().split('.').pop().toLowerCase(), fileExtension) != -1) {
            if (input[0].files && input[0].files[0]) {
                if (typeof (FileReader) != "undefined") {
                    var reader_img = new FileReader();
                    reader_img.onload = function (e) {
                        preview.attr('src', e.target.result);

                        var image = new Image();
                        image.src = e.target.result;
                        image.onload = function () {
                            height_file = this.height;
                            width_file = this.width;
                        };
                    };
                    reader_img.readAsDataURL(input[0].files[0]);
                } else {
                    alert("Este navegador no soporta FileReader.");
                }
            }
        } else {
            preview.attr('src', default_img);
            height_file = -1;
            width_file = -1;
        }
    }

    $("#file_img").change(function(){
        $("#file_lbl").val($(this).val());
        printPreview($(this), $('#preview'), imagen_default);
    });

    var imagen_default;

    jQuery.validator.addMethod("validDate", function(value, element) {
        return this.optional(element) || moment(value,"YYYY-MM-DD").isValid();
    }, "Por favor, ingrese una fecha válida en el formato YYYY-MM-DD");

    jQuery.validator.addMethod("check200", function(value, element) {
        if (height_file != -1 && width_file != -1) {
            if (height_file < 200 || width_file < 200) {
                return false;
            }
        }
        return true;
    }, "La imagen debe tener un tamaño mayor a 200 píxeles de altura y 200 píxeles de anchura");

    $('input[name="fech_eve"]').parent().datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        locale: 'es'
    });

    var $form_evento = $('#form_evento');

    var isDestroyable = false;

    $(document).on('click', '#btn_evento', function () {
        $("#modal_evento_lbl").html('Nueva evento');
        
        $form_evento.get(0).reset();

        $('#form_evento :input[name="fech_eve"]').val(moment().format("YYYY-MM-DD HH:mm"));  

        $('.note-editable.panel-body').html("");  

        imagen_default = "";

        $form_evento.attr("action", base_url+"evento/save");

        $form_evento.submit(function(e) {
                if (!validator_evento.form()) {
                    $("#submit_evento").html('Guardar');
                    $("#submit_evento").prop('disabled', false);
                    return;
                }
        });

        if (isDestroyable) {
            validator_evento.destroy();
        }
        
        validator_evento = $form_evento.validate({
            rules: {
                nume_eve: {
                    required: true,
                    remote: {
                        url: base_url+"evento/check_nume_eve",
                        type: "post",
                        data:
                        {
                            nume_eve: function()
                            {
                                return $('#form_evento :input[name="nume_eve"]').val();
                            }
                        }
                    }         
                },
                fech_eve: {
                    required: true,
                    validDate: true
                },
                titu_eve: {
                    required: true,
                },
                cont_eve: {
                    required: true,
                },
                imag_eve: {
                    required: true,
                    accept: "image/*",
                    check200: true
                },
            },
            messages: {
                nume_eve: { 
                    remote: "El número de evento ya existe"
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

        $("#modal_evento").modal();
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_evento.get(0).reset();


        if (isDestroyable) {
            $.removeData($form_evento.get(0),'validator');
        }

        $('#form_evento :input[name="codi_eve"]').val(data.codi_eve);  
        $('#form_evento :input[name="nume_eve"]').val(data.nume_eve);  
        $('#form_evento :input[name="titu_eve"]').val(data.titu_eve);  
        $('#form_evento :input[name="fech_eve"]').val(data.fech_eve);  
        $('.note-editable.panel-body').html(data.cont_eve); 
        imagen_default = data.imag_eve;

        printPreview($("#file_img"), $('#preview'), imagen_default);

        $("#modal_evento_lbl").html("Modificar evento");

        $form_evento.attr("action", base_url+"evento/update");

        $form_evento.submit(function(e) {
            if (!validator_evento.form()) {
                return;
            } else {
                $("#submit_evento").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_evento").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_evento.destroy();
        }
        
        validator_evento = $form_evento.validate({
            rules: {
                nume_eve: {
                    required: true,
                    remote: {
                        url: base_url+"evento/check_nume_eve_actualizar",
                        type: "post",
                        data:
                        {
                            codi_eve: function()
                            {
                                return $('#form_evento :input[name="codi_eve"]').val();
                            },
                            nume_eve: function()
                            {
                                return $('#form_evento :input[name="nume_eve"]').val();
                            }
                        }
                    }         
                },
                fech_eve: {
                    required: true,
                    validDate: true
                },
                titu_eve: {
                    required: true,
                },
                cont_eve: {
                    required: true,
                },
                imag_eve: {
                    accept: "image/*",
                    check200: true
                },
            },
            messages: {
                nume_eve: { 
                    remote: "El número de evento ya existe"
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

        $("#modal_evento").modal();
    });

    $(document).on('submit', '.habilitar_evento', function () {
        return confirm("¿Está seguro de que desea habilitar el evento?");
    });

    $(document).on('submit', '.deshabilitar_evento', function () {
        return confirm("¿Está seguro de que desea deshabilitar el evento?");
    });

    $(document).on('submit', '.eliminar_evento', function () {
        return confirm("¿Está seguro de que desea eliminar el evento?");
    });


    window.fbAsyncInit = function() {
    FB.init({
      appId      : '1327135627399921',
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
  
});
