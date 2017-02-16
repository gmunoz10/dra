'use strict';

angular.module('core').controller('HomeController', ['$scope', 'Authentication',
  function ($scope, Authentication) {

  	$('.carousel').carousel({
	  interval: 2000 // in milliseconds
	});
    // This provides Authentication context.
    $scope.authentication = Authentication;
    $scope.label = "Lorem ipsum dolor sit amet, at alii delectus cum, te possim elaboraret assueverit ius, ea oratio delicata has. An labore facilisis eum, recusabo nominati id mel. Brute dolorem ei sit, pro no prompta deleniti. Per quod erroribus temporibus ea, ei cum rebum ornatus voluptaria. Eam ad timeam propriae. Vis nisl esse ullum ei, sed te erroribus repudiare, usu nullam volumus dignissim at. Has amet putent ea.";

  }
]);

