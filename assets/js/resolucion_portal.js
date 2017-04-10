$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "bLengthChange": false,
        "bInfo": false,
        "sPaginationType": "numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "resolucion/paginate_portal",
        "sServerMethod": "POST",
        "fnServerParams": function(aoData) {
            aoData.push({"name": "codi_gre", "value": $("#codi_gre").val()});
            aoData.push({"name": "year_res", "value": $("#year_res").val()});
        },
        "columns": [
            { "data": "nume_res" },
            { "data": "fech_res_d" },
            { "data": "desc_res" },
            { "data": "docu_res" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": true,
        "displayLength": 10,
        "order": [[ 0, "asc" ]]
    });

    $('#year_res').datetimepicker({
        viewMode: 'years',
        format: 'YYYY'
    });


    $(document).on('click', '#btn_search_year', function () {
        table_search.ajax.reload();
    });
    
});
