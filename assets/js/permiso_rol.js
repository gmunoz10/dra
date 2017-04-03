$(function() {

    var grupos_permiso;
    var codi_rol;

    function cargar_permisos2() {
        $("#btn_cargar").html('<i class="fa fa-refresh fa-spin" aria-hidden="true"></i> Cargar permisos');     
        $(".box_permisos").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>')
        $("#btn_cargar").prop('disabled', true);   
        return;  
    }

    function cargar_permisos() {
        $("#btn_cargar").html('<i class="fa fa-refresh fa-spin" aria-hidden="true"></i> Cargar permisos');     
        $(".box_permisos").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>')
        $("#btn_cargar").prop('disabled', true);     
        $.ajax({
            type: 'post',
            url: base_url + 'permiso/get_permisos_rol',
            data: {
                codi_rol: $("#codi_rol").val()
            },
            success: function(result) {
                $("#btn_cargar").html('<i class="fa fa-refresh" aria-hidden="true"></i> Cargar permisos');        
                $("#btn_cargar").prop('disabled', false);     
                var d = $.parseJSON(result);
                grupos_permiso = d.data;
                codi_rol = $("#codi_rol").val();
                $(".box-resultado").html('<hr><h3 class="title-sisgedo">'+$("#codi_rol option:selected").html()+'</h3>')
                $(".box-resultado").append('<div class="box_permisos row">'+d.view+'</div>');
                $('[data-toggle="toggle"]').bootstrapToggle();
            }
        });
    }

    cargar_permisos();

    $("#btn_cargar").click(function() {
        cargar_permisos2();
    });

    $(document).on("click", ".btn_save_permiso", function() {
        var header = $(this).parent();

        tbody = $(this).parent().find(".table-permiso tbody");
        codi_gpr = tbody.data("gpr");

        var target_grupo;

        tbody.find("tr").each(function(index, value) {
            codi_per = $(this).data("per");
            codi_pro = $(this).data("pro");
            valo_pro = ($(this).find(".check_permiso").prop("checked")) ? "1" : "0";

            for (var i = 0; i < grupos_permiso.length; i++) {
                if (grupos_permiso[i].codi_gpr == codi_gpr) {
                    target_grupo = i;
                    for (var j = 0; j < grupos_permiso[i].permisos.length; j++) {
                        if (grupos_permiso[i].permisos[j].codi_per == codi_per) {
                            grupos_permiso[i].permisos[j].valo_pro = valo_pro;
                            break;
                        }
                    }
                    break;
                }
            }
        });  

        header.append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');

        $.ajax({
            type: 'post',
            url: base_url + 'permiso/save_permiso_rol',
            data: {
                codi_rol: codi_rol,
                permisos: JSON.stringify(grupos_permiso[target_grupo])
            },
            success: function(result) {
                cargar_permisos();
                header.find(".overlay").remove();
            }
        });
    });



});
