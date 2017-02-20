// Somos service used to communicate Somos REST endpoints
(function () {
  'use strict';

  angular
    .module('somos')
    .factory('SomosService', SomosService);

  SomosService.$inject = ['$resource'];

  function SomosService($resource) {
    return $resource('api/somos/:somoId', {
      somoId: '@_id'
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
}());
