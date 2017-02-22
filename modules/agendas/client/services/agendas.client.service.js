// Agendas service used to communicate Agendas REST endpoints
(function () {
  'use strict';

  angular
    .module('agenda')
    .factory('AgendaService', AgendasService);

  AgendasService.$inject = ['$resource'];

  function AgendasService($resource) {
    return $resource('api/agenda/:agendaId', {
      agendaId: '@_id'
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
}());
