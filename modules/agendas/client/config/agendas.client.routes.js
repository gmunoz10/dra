'use strict';

// Setting up route
angular.module('agenda').config(['$stateProvider',
  function ($stateProvider) {
    // Articles state routing
    $stateProvider
      .state('agenda', {
        url: '/agenda',
        templateUrl: 'modules/agendas/views/agenda.client.view.html',
      })
  }
]);

