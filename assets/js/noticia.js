$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "noticia/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_not" },
            { "data": "nume_not" },
            { "data": "titu_not" },
            { "data": "fech_not_d" },
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


    $('#cont_not').summernote({
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
            url: base_url+"noticia/uploadImage",
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                var data = $.parseJSON(response);
                if (data.status == "error") {
                    show_toast("error", data.result);
                } else {    
                    var image = base_url + "/assets/noticia/imagenes_noticia/" + data.result;
                    $('#cont_not').summernote('insertImage', image);
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

    $('input[name="fech_not"]').parent().datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        locale: 'es'
    });

    var $form_noticia = $('#form_noticia');

    var isDestroyable = false;

    $(document).on('click', '#btn_noticia', function () {
        $("#modal_noticia_lbl").html('Nueva noticia');
        
        $form_noticia.get(0).reset();

        $('#form_noticia :input[name="fech_not"]').val(moment().format("YYYY-MM-DD HH:mm"));  

        $('.note-editable.panel-body').html("");  

        imagen_default = "";

        $form_noticia.attr("action", base_url+"noticia/save");

        $form_noticia.submit(function(e) {
                if (!validator_noticia.form()) {
                    $("#submit_noticia").html('Guardar');
                    $("#submit_noticia").prop('disabled', false);
                    return;
                }
        });

        if (isDestroyable) {
            validator_noticia.destroy();
        }
        
        validator_noticia = $form_noticia.validate({
            rules: {
                nume_not: {
                    required: true,
                    remote: {
                        url: base_url+"noticia/check_nume_not",
                        type: "post",
                        data:
                        {
                            nume_not: function()
                            {
                                return $('#form_noticia :input[name="nume_not"]').val();
                            }
                        }
                    }         
                },
                fech_not: {
                    required: true,
                    validDate: true
                },
                titu_not: {
                    required: true,
                },
                cont_not: {
                    required: true,
                },
                imag_not: {
                    required: true,
                    accept: "image/*",
                    check200: true
                },
            },
            messages: {
                nume_not: { 
                    remote: "El número de noticia ya existe"
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

        $("#modal_noticia").modal();
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_noticia.get(0).reset();


        if (isDestroyable) {
            $.removeData($form_noticia.get(0),'validator');
        }

        $('#form_noticia :input[name="codi_not"]').val(data.codi_not);  
        $('#form_noticia :input[name="nume_not"]').val(data.nume_not);  
        $('#form_noticia :input[name="titu_not"]').val(data.titu_not);  
        $('#form_noticia :input[name="fech_not"]').val(data.fech_not);  
        $('.note-editable.panel-body').html(data.cont_not); 
        imagen_default = data.imag_not;

        printPreview($("#file_img"), $('#preview'), imagen_default);

        $("#modal_noticia_lbl").html("Modificar noticia");

        $form_noticia.attr("action", base_url+"noticia/update");

        $form_noticia.submit(function(e) {
            if (!validator_noticia.form()) {
                return;
            } else {
                $("#submit_noticia").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_noticia").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_noticia.destroy();
        }
        
        validator_noticia = $form_noticia.validate({
            rules: {
                nume_not: {
                    required: true,
                    remote: {
                        url: base_url+"noticia/check_nume_not_actualizar",
                        type: "post",
                        data:
                        {
                            codi_not: function()
                            {
                                return $('#form_noticia :input[name="codi_not"]').val();
                            },
                            nume_not: function()
                            {
                                return $('#form_noticia :input[name="nume_not"]').val();
                            }
                        }
                    }         
                },
                fech_not: {
                    required: true,
                    validDate: true
                },
                titu_not: {
                    required: true,
                },
                cont_not: {
                    required: true,
                },
                imag_not: {
                    accept: "image/*",
                    check200: true
                },
            },
            messages: {
                nume_not: { 
                    remote: "El número de noticia ya existe"
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

        $("#modal_noticia").modal();
    });

    $(document).on('submit', '.habilitar_noticia', function () {
        return confirm("¿Está seguro de que desea habilitar la noticia?");
    });

    $(document).on('submit', '.deshabilitar_noticia', function () {
        return confirm("¿Está seguro de que desea deshabilitar la noticia?");
    });

    $(document).on('submit', '.eliminar_noticia', function () {
        return confirm("¿Está seguro de que desea eliminar la noticia?");
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
