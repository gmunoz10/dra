'use strict';

/**
 * Module dependencies
 */
var agendasPolicy = require('../policies/agendas.server.policy'),
  agendas = require('../controllers/agendas.server.controller');

module.exports = function(app) {
  // Agendas Routes
  app.route('/api/agendas').all(agendasPolicy.isAllowed)
    .get(agendas.list)
    .post(agendas.create);

  app.route('/api/agendas/:agendaId').all(agendasPolicy.isAllowed)
    .get(agendas.read)
    .put(agendas.update)
    .delete(agendas.delete);

  // Finish by binding the Agenda middleware
  app.param('agendaId', agendas.agendaByID);
};
