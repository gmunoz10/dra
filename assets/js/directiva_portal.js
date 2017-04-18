$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "bLengthChange": false,
        "bInfo": false,
        "sPaginationType": "numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "directiva/paginate_portal",
        "sServerMethod": "POST",
        "fnServerParams": function(aoData) {
            aoData.push({"name": "codi_gdi", "value": $("#codi_gdi").val()});
            aoData.push({"name": "year_dir", "value": $("#year_dir").val()});
        },
        "columns": [
            { "data": "nume_dir" },
            { "data": "fech_dir_d" },
            { "data": "desc_dir" },
            { "data": "docu_dir" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": true,
        "displayLength": 10,
        "order": [[ 0, "asc" ]]
    });

    $('#year_dir').datetimepicker({
        viewMode: 'years',
        format: 'YYYY'
    });


    $(document).on('click', '#btn_search_year', function () {
        table_search.ajax.reload();
    });
    
});
