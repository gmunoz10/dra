$(function() {

	var table_search = $('#table_search').DataTable({
        "iDisplayLength": 10,
        "bLengthChange": false,
        "bInfo": false,
        "sPaginationType": "numbers",
        "bProcessing": true,
        "bDestroy": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "pac/paginate_portal",
        "sServerMethod": "POST",
        "fnServerParams": function(aoData) {
            aoData.push({"name": "codi_gpa", "value": $("#codi_gpa").val()});
            aoData.push({"name": "year_pac", "value": $("#year_pac").val()});
        },
        "columns": [
            { "data": "nume_pac" },
            { "data": "fech_pac_d" },
            { "data": "desc_pac" },
            { "data": "docu_pac" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": true,
        "displayLength": 10,
        "order": [[ 0, "asc" ]]
    });

    $('#year_pac').datetimepicker({
        viewMode: 'years',
        format: 'YYYY'
    });


    $(document).on('click', '#btn_search_year', function () {
        table_search.ajax.reload();
    });
    
});
