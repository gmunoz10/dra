$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "aLengthMenu": [10, 25, 50],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "tema_agrario/paginate",
        "sServerMethod": "POST",
        "columns": [
            { "data": "codi_tea" },
            { "data": "nume_tea" },
            { "data": "titu_tea" },
            { "data": "fech_tea_d" },
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


    $('#cont_tea').summernote({
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
            url: base_url+"tema_agrario/uploadImage",
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                var data = $.parseJSON(response);
                if (data.status == "error") {
                    show_toast("error", data.result);
                } else {    
                    var image = base_url + "/assets/tema_agrario/" + data.result;
                    $('#cont_tea').summernote('insertImage', image);
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

    $('input[name="fech_tea"]').parent().datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        locale: 'es'
    });

    var $form_tema_agrario = $('#form_tema_agrario');

    var isDestroyable = false;

    $(document).on('click', '#btn_tema_agrario', function () {
        $("#modal_tema_agrario_lbl").html('Nuevo tema agrario');
        
        $form_tema_agrario.get(0).reset();

        $('#form_tema_agrario :input[name="fech_tea"]').val(moment().format("YYYY-MM-DD HH:mm"));  

        $('.note-editable.panel-body').html("");  

        imagen_default = "";

        $form_tema_agrario.attr("action", base_url+"tema_agrario/save");

        $form_tema_agrario.submit(function(e) {
                if (!validator_tema_agrario.form()) {
                    $("#submit_tema_agrario").html('Guardar');
                    $("#submit_tema_agrario").prop('disabled', false);
                    return;
                }
        });

        if (isDestroyable) {
            validator_tema_agrario.destroy();
        }
        
        validator_tema_agrario = $form_tema_agrario.validate({
            rules: {
                nume_tea: {
                    required: true,
                    remote: {
                        url: base_url+"tema_agrario/check_nume_tea",
                        type: "post",
                        data:
                        {
                            nume_tea: function()
                            {
                                return $('#form_tema_agrario :input[name="nume_tea"]').val();
                            }
                        }
                    }         
                },
                fech_tea: {
                    required: true,
                    validDate: true
                },
                titu_tea: {
                    required: true,
                },
                cont_tea: {
                    required: true,
                },
                imag_tea: {
                    required: true,
                    accept: "image/*",
                    check200: true
                },
            },
            messages: {
                nume_tea: { 
                    remote: "El número de tema agrario ya existe"
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

        $("#modal_tema_agrario").modal();
    });

    $(document).on('click', '#table_search button.btn-modificar', function () {

        var tr = $(this).parent().closest('tr');
        var row = table_search.row(tr);
        var data = row.data();

        $form_tema_agrario.get(0).reset();


        if (isDestroyable) {
            $.removeData($form_tema_agrario.get(0),'validator');
        }

        $('#form_tema_agrario :input[name="codi_tea"]').val(data.codi_tea);  
        $('#form_tema_agrario :input[name="nume_tea"]').val(data.nume_tea);  
        $('#form_tema_agrario :input[name="titu_tea"]').val(data.titu_tea);  
        $('#form_tema_agrario :input[name="fech_tea"]').val(data.fech_tea);  
        $('.note-editable.panel-body').html(data.cont_tea); 
        imagen_default = data.imag_tea;

        printPreview($("#file_img"), $('#preview'), imagen_default);

        $("#modal_tema_agrario_lbl").html("Modificar tema agrario");

        $form_tema_agrario.attr("action", base_url+"tema_agrario/update");

        $form_tema_agrario.submit(function(e) {
            if (!validator_tema_agrario.form()) {
                return;
            } else {
                $("#submit_tema_agrario").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Verificando...');
                $("#submit_tema_agrario").prop('disabled', true);
            }
        });

        if (isDestroyable) {
            validator_tema_agrario.destroy();
        }
        
        validator_tema_agrario = $form_tema_agrario.validate({
            rules: {
                nume_tea: {
                    required: true,
                    remote: {
                        url: base_url+"tema_agrario/check_nume_tea_actualizar",
                        type: "post",
                        data:
                        {
                            codi_tea: function()
                            {
                                return $('#form_tema_agrario :input[name="codi_tea"]').val();
                            },
                            nume_tea: function()
                            {
                                return $('#form_tema_agrario :input[name="nume_tea"]').val();
                            }
                        }
                    }         
                },
                fech_tea: {
                    required: true,
                    validDate: true
                },
                titu_tea: {
                    required: true,
                },
                cont_tea: {
                    required: true,
                },
                imag_tea: {
                    accept: "image/*",
                    check200: true
                },
            },
            messages: {
                nume_tea: { 
                    remote: "El número de tema agrario ya existe"
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

        $("#modal_tema_agrario").modal();
    });

    $(document).on('submit', '.habilitar_tema_agrario', function () {
        return confirm("¿Está seguro de que desea habilitar el tema agrario?");
    });

    $(document).on('submit', '.deshabilitar_tema_agrario', function () {
        return confirm("¿Está seguro de que desea deshabilitar el tema agrario?");
    });

    $(document).on('submit', '.eliminar_tema_agrario', function () {
        return confirm("¿Está seguro de que desea eliminar el tema agrario?");
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
