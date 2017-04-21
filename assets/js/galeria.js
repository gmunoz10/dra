$(function() {

    $('[data-toggle="tooltip"]').tooltip();

    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

    $(document).on('click', '#btn_search', function(event) {
        window.location.href = base_url+"galeria?search="+encodeURI($("#txt_search").val());
    });

});
