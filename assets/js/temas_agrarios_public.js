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
 		interval: 2000
 	});

	$("#tema_agrario_link").click(function() {
 		var codi_eve = $("#carousel-temas_agrarios .carousel-inner .item.active").data("codi");
 		window.location.href = base_url+"tema_agrario/"+codi_eve;
 	});

 	$('#carousel-temas_agrarios .btn-facebook').click(function (e) {
		FB.ui({
		    method: 'share',
		    display: 'popup',
		    href: base_url+"tema_agrario/"+$("#carousel-temas_agrarios .carousel-inner .item.active").data("codi"),
		  }, function(response){});
	});

});
