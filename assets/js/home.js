window.fbAsyncInit = function() {
FB.init({
  appId      : '1327135627399921',
  xfbml      : true,
  version    : 'v2.8'
});
FB.AppEvents.logPageView();
};

(function(d, s, id){
 var js, fjs = d.getElementsByTagName(s)[0];
 if (d.getElementById(id)) {return;}
 js = d.createElement(s); js.id = id;
 js.src = "//connect.facebook.net/es_LA/sdk.js";
 fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

$(function() {


	var checked_google = false;
    function checkGoogle(){
    	if (!checked_google && $(".gsc-search-button").length > 0) {
    		checked_google = true;
    		$(".gsc-search-button input").removeAttr("src");
    		$(".gsc-search-button input").attr("type", "button");
    		$(".gsc-search-button input").attr("value", "Buscar");
    		$(".gsc-search-button input").attr("class","btn btn-secondary btn-orange btn-lg");
    		$(".gsc-search-button input").css("position", "relative");
    		$(".gsc-search-button input").css("border-radius", "6px");
    		$(".gsc-search-button input").css("border-top-left-radius", "0px");
    		$(".gsc-search-button input").css("border-bottom-left-radius", "0px");

    	}
	}
	setInterval(checkGoogle, 1);



	$('.carousel').carousel({
 		interval: 2000
 	});

 	$("#noticia_link").click(function() {
 		var codi_not = $("#carousel-noticias .carousel-inner .item.active").data("codi");
 		window.location.href = base_url+"noticia/"+codi_not;
 	});

 	$('#carousel-noticias .btn-facebook').click(function (e) {
		FB.ui({
		    method: 'share',
		    display: 'popup',
		    href: base_url+"noticia/"+$("#carousel-noticias .carousel-inner .item.active").data("codi"),
		  }, function(response){});
	});

 	$('#carousel-noticias .btn-twitter').click(function (e) {
        window.open('https://twitter.com/intent/tweet?&url='+encodeURI(base_url+"noticia/"+$("#carousel-noticias .carousel-inner .item.active").data("codi")), "Publica un Tweet en Twitter", "width=500,height=500");
  	});

	$("#evento_link").click(function() {
 		var codi_eve = $("#carousel-eventos .carousel-inner .item.active").data("codi");
 		window.location.href = base_url+"evento/"+codi_eve;
 	});

 	$('#carousel-eventos .btn-facebook').click(function (e) {
		FB.ui({
		    method: 'share',
		    display: 'popup',
		    href: base_url+"evento/"+$("#carousel-eventos .carousel-inner .item.active").data("codi"),
		  }, function(response){});
	});

 	$('#carousel-eventos .btn-twitter').click(function (e) {
        window.open('https://twitter.com/intent/tweet?&url='+encodeURI(base_url+"evento/"+$("#carousel-eventos .carousel-inner .item.active").data("codi")), "Publica un Tweet en Twitter", "width=500,height=500");
  	});

 	$("#modal_aviso").modal("show");
});
