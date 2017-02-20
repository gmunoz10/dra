'use strict';

/**
 * Module dependencies
 */
var somosPolicy = require('../policies/somos.server.policy'),
  somos = require('../controllers/somos.server.controller');

module.exports = function(app) {
  // Somos Routes
  app.route('/api/somos').all(somosPolicy.isAllowed)
    .get(somos.list)
    .post(somos.create);

  app.route('/api/somos/:somoId').all(somosPolicy.isAllowed)
    .get(somos.read)
    .put(somos.update)
    .delete(somos.delete);

  // Finish by binding the Somo middleware
  app.param('somoId', somos.somoByID);
};
