var map;
var marker_barranca;
var marker_huacho;
var marker_huaral;
var marker_canta;
var marker_santa;
var marker_mala;
var marker_canete;

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 8,
      center: {lat: -11.8603572, lng: -76.9589883}
    });

    marker_barranca = new google.maps.Marker({
      position: {lat: -10.7596695, lng: -77.7573812},
      map: map
    });
    marker_barranca.addListener('click', function() {
      new google.maps.InfoWindow({ content: "<b>Agencia Agraria Barranca</b>" }).open(map, marker_barranca);
    });

    marker_huacho = new google.maps.Marker({
      position: {lat: -11.1064245, lng: -77.6046969},
      map: map
    });
    marker_huacho.addListener('click', function() {
      new google.maps.InfoWindow({ content: "<b>Agencia Agraria Huacho</b>" }).open(map, marker_huacho);
    });

    marker_huaral = new google.maps.Marker({
      position: {lat: -11.5143532, lng: -77.2384831},
      map: map
    });
    marker_huaral.addListener('click', function() {
      new google.maps.InfoWindow({ content: "<b>Agencia Agraria Huaral</b>" }).open(map, marker_huaral);
    });

    marker_canta = new google.maps.Marker({
      position: {lat: -11.4686623, lng: -76.6227712},
      map: map
    });
    marker_canta.addListener('click', function() {
      new google.maps.InfoWindow({ content: "<b>Agencia Agraria Canta</b>" }).open(map, marker_canta);
    });

    marker_santa = new google.maps.Marker({
      position: {lat: -11.9170257, lng: -76.6665355},
      map: map
    });
    marker_santa.addListener('click', function() {
      new google.maps.InfoWindow({ content: "<b>Agencia Agraria Santa Eulalia</b>" }).open(map, marker_santa);
    });

    marker_mala = new google.maps.Marker({
      position: {lat: -12.653046, lng: -76.6468695},
      map: map
    });
    marker_mala.addListener('click', function() {
      new google.maps.InfoWindow({ content: "<b>Agencia Agraria Mala</b>" }).open(map, marker_mala);
    });

    marker_canete = new google.maps.Marker({
      position: {lat: -12.9033565, lng: -76.505583},
      map: map
    });
    marker_canete.addListener('click', function() {
      new google.maps.InfoWindow({ content: "<b>Agencia Agraria Cañete</b>" }).open(map, marker_canete);
    });

}

function moveToMarker( map, marker ) {
    map.panTo( new google.maps.LatLng( 0, 0 ) );

};

$(function() {

    $('[data-toggle="popover"]').popover();

    $(document).on("mouseover", ".agencias tr td:nth-child(2) a", function () {
        $(this).parent().parent().find("td:nth-child(1) img").show();
    });

    $(document).on("mouseout", ".agencias tr td:nth-child(2) a", function () {
        $(this).parent().parent().find("td:nth-child(1) img").hide(100);
    });

    $(document).on("click", "#toBarranca", function () {
        map.setCenter(marker_barranca.position);
        map.setZoom(14);
    });

    $(document).on("click", "#toHuacho", function () {
        map.setCenter(marker_huacho.position);
        map.setZoom(14);
    });

    $(document).on("click", "#toHuaral", function () {
        map.setCenter(marker_huaral.position);
        map.setZoom(14);
    });

    $(document).on("click", "#toCanta", function () {
        map.setCenter(marker_canta.position);
        map.setZoom(14);
    });

    $(document).on("click", "#toSanta", function () {
        map.setCenter(marker_santa.position);
        map.setZoom(14);
    });

    $(document).on("click", "#toMala", function () {
        map.setCenter(marker_mala.position);
        map.setZoom(14);
    });

    $(document).on("click", "#toCanete", function () {
        map.setCenter(marker_canete.position);
        map.setZoom(14);
    });

});
