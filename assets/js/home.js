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


	$('.carousel').carousel({
 	  interval: 2000 // in milliseconds
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

 	$("#modal_aviso").modal("show");
});
