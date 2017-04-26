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
            aoData.push({"name": "year_pac", "value": ($('[name="year_pac"]').length) ? $('[name="year_pac"]').val() : "false" });
        },
        "columns": [
            { "data": "desc_pac" },
            { "data": "fech_pac_d" },
            { "data": "docu_pac" }
        ],
        "bPaginate": true,
        "bFilter": true,
        "bSort": true,
        "displayLength": 10,
        "order": [[ 0, "asc" ]]
    });

    $(document).on('click', '.btn-year', function () {
        table_search.ajax.reload();
    });
    
});
