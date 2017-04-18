$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "bLengthChange": false,
        "bInfo": false,
        "sPaginationType": "numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "declaracion_jurada/paginate_portal",
        "sServerMethod": "POST",
        "fnServerParams": function(aoData) {
            aoData.push({"name": "codi_gdj", "value": $("#codi_gdj").val()});
            aoData.push({"name": "year_dju", "value": $("#year_dju").val()});
        },
        "columns": [
            { "data": "nume_dju" },
            { "data": "fech_dju_d" },
            { "data": "desc_dju" },
            { "data": "docu_dju" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": true,
        "displayLength": 10,
        "order": [[ 0, "asc" ]]
    });

    $('#year_dju').datetimepicker({
        viewMode: 'years',
        format: 'YYYY'
    });


    $(document).on('click', '#btn_search_year', function () {
        table_search.ajax.reload();
    });
    
});
