'use strict';

// Articles controller
angular.module('somos').controller('SomosController', ['$scope', '$stateParams', '$location', 'Authentication', 'Somos',
  function ($scope, $stateParams, $location, Authentication, Articles) {
    $scope.authentication = Authentication;

  }
]);

