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

 	$('.btn-facebook').click(function (e) {
		FB.ui({
		    method: 'share',
		    display: 'popup',
		    href: $('.btn-facebook').data("href"),
		  }, function(response){});
	});

});
