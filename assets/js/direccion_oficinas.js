$(function() {

    $('[data-toggle="popover"]').popover({
        container: 'body'
    });

    $(document).on("mouseover", ".direccion tr td:nth-child(2) span", function () {
        $(this).parent().parent().parent().find("td:nth-child(1) img").show();
    });

    $(document).on("mouseout", ".direccion tr td:nth-child(2) span", function () {
        $(this).parent().parent().parent().find("td:nth-child(1) img").hide(100);
    });

});
