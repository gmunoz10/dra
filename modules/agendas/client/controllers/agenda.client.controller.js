'use strict';

// Articles controller
angular.module('agenda').controller('AgendaController', ['$scope', '$stateParams', '$location', 'Authentication', 'Agenda',
  function ($scope, $stateParams, $location, Authentication, Agenda) {
    $scope.authentication = Authentication;
    $scope.dependencies = ["Presidencia Regional" , "Director Regional", "Jefe"];
    $scope.selected_dependency = ["Presidencia Regional" , "Director Regional", "Jefe"];

  }
]);
