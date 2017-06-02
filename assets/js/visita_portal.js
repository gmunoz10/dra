$(function() {
	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "bLengthChange": false,
        "bInfo": false,
        "sPaginationType": "numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "visita/paginate_portal",
        "sServerMethod": "POST",
        "fnServerParams": function(aoData) {
            aoData.push({"name": "fech_vis", "value": $("#fech_vis").val()});
        },
        "columns": [
            { "data": "codi_vis" },
            { "data": "fech_vis_d" },
            { "data": "visi_vis" },
            { "data": "tipo_vis" },
            { "data": "docu_vis" },
            { "data": "enti_vis" },
            { "data": "moti_vis" },
            { "data": "sede_vis" },
            { "data": "empl_vis" },
            { "data": "ofic_vis" },
            { "data": "ingr_vis_d" },
            { "data": "sali_vis_d" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": true,
        "displayLength": 10,
        "order": [[ 0, "asc" ]]
    });

    $('#fech_vis').datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD'
    });


    $(document).on('click', '#btn_search_vis', function () {
        table_search.ajax.reload();
    });
    
});
