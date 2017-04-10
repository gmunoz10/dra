$(function() {

    $(document).on('click', '.btn-search-agenda', function () {
        $(".box-resultado-agenda").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        var btn = $(this);

        btn.html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Buscando...');
        btn.prop("disabled", true);

        var codi_dpe = $("#dependencia").val();
        var mes = $("#mes_search").val();
        var year = $("#year_search").val();

        if(!codi_dpe) {
            alert("Por favor, seleccione dependencia");
            btn.html('Buscar');
            btn.prop("disabled", false);
            return;
        }
        if(!mes) {
            alert("Por favor, seleccione mes");
            btn.html('Buscar');
            btn.prop("disabled", false);
            return;
        }
        if(!year) {
            alert("Por favor, seleccione año");
            btn.html('Buscar');
            btn.prop("disabled", false);
            return;
        }

        $.ajax({
            type: 'post',
            url: base_url + 'agenda/paginate_public',
            async: false,
            data: {
                codi_dpe: codi_dpe,
                mes: mes,
                year: year
            },
            success: function(result) {
                var data = $.parseJSON(result);

                var result_html = '<h3 style="color: #555; font-weight: bold;">Actividades del mes de ' + $("#mes_search option:selected").html() + ' del año '+year+'</h3>';

                result_html += '<div class="col-lg-10 col-md-offset-1 no-padding" style="margin-top: 25px; padding-top: 10px;">';
                result_html += '<p class="text-muted">Número de actividades: '+data.length+'</p>';

                if (data.length) {
                    result_html += '<div class="table-responsive"><table class="table table-condensed table-bordered table-striped table-resultado-agenda"><thead><tr><th>Área</th><th>Día</th><th>Mes</th><th>Año</th><th>Hora</th><th>Lugar</th><th>Descripción</th></tr></thead><tbody>';
                    for (var i = 0; i < data.length; i++) {
                        result_html += '<tr><td>'+data[i].nomb_dpe+'</td><td>'+data[i].dia+'</td><td>'+data[i].mes+'</td><td>'+data[i].ano+'</td><td>'+data[i].hora+'</td><td>'+data[i].luga_age+'</td><td>'+data[i].desc_age+'</td></tr>';
                    }
                    result_html += '</tbody></table></div>';
                }
                result_html += '</div>';

                $(".box-resultado-agenda").html(result_html);

                btn.html('Buscar');
                btn.prop("disabled", false);
            }
        });
    });

});
