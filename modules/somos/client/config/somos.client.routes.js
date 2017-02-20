(function () {
  'use strict';

  angular
    .module('somos')
    .config(routeConfig);

  routeConfig.$inject = ['$stateProvider'];

  function routeConfig($stateProvider) {
    $stateProvider
      .state('somos', {
        url: '',
        templateUrl: 'modules/somos/views/list-somos.client.view.html',
        controller: 'SomosController',
        data: {
          pageTitle: '¿Quiénes somos?'
        }
      });
  }

  /*
  getSomo.$inject = ['$stateParams', 'SomosService'];

  function getSomo($stateParams, SomosService) {
    return SomosService.get({
      somoId: $stateParams.somoId
    }).$promise;
  }

  newSomo.$inject = ['SomosService'];

  function newSomo(SomosService) {
    return new SomosService();
  }
  */
}());
