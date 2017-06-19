$(function() {

    $(document).on("click", ".show_content", function () {
    	$("#box_content").html($(this).data("content"));
    });

    $(document).on("mouseover", ".direccion tr td:nth-child(2) span, .direccion tr td:nth-child(2) a", function () {
        $(this).parent().parent().parent().find("td:nth-child(1) img").show();
    });

    $(document).on("mouseout", ".direccion tr td:nth-child(2) span, .direccion tr td:nth-child(2) a", function () {
        $(this).parent().parent().parent().find("td:nth-child(1) img").hide(100);
    });

});
