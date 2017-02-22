'use strict';

// Setting up route
angular.module('somos').config(['$stateProvider',
  function ($stateProvider) {
    // Articles state routing
    $stateProvider
      .state('somos', {
        url: '/quienes-somos',
        templateUrl: 'modules/somos/views/quienes-somos.client.view.html',
      })
  }
]);

