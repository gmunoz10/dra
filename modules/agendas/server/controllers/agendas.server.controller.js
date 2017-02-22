'use strict';

/**
 * Module dependencies.
 */
var path = require('path'),
  mongoose = require('mongoose'),
  Agenda = mongoose.model('Agenda'),
  errorHandler = require(path.resolve('./modules/core/server/controllers/errors.server.controller')),
  _ = require('lodash');

/**
 * Create a Agenda
 */
exports.create = function(req, res) {
  var agenda = new Agenda(req.body);
  agenda.user = req.user;

  agenda.save(function(err) {
    if (err) {
      return res.status(400).send({
        message: errorHandler.getErrorMessage(err)
      });
    } else {
      res.jsonp(agenda);
    }
  });
};

/**
 * Show the current Agenda
 */
exports.read = function(req, res) {
  // convert mongoose document to JSON
  var agenda = req.agenda ? req.agenda.toJSON() : {};

  // Add a custom field to the Article, for determining if the current User is the "owner".
  // NOTE: This field is NOT persisted to the database, since it doesn't exist in the Article model.
  agenda.isCurrentUserOwner = req.user && agenda.user && agenda.user._id.toString() === req.user._id.toString();

  res.jsonp(agenda);
};

/**
 * Update a Agenda
 */
exports.update = function(req, res) {
  var agenda = req.agenda;

  agenda = _.extend(agenda, req.body);

  agenda.save(function(err) {
    if (err) {
      return res.status(400).send({
        message: errorHandler.getErrorMessage(err)
      });
    } else {
      res.jsonp(agenda);
    }
  });
};

/**
 * Delete an Agenda
 */
exports.delete = function(req, res) {
  var agenda = req.agenda;

  agenda.remove(function(err) {
    if (err) {
      return res.status(400).send({
        message: errorHandler.getErrorMessage(err)
      });
    } else {
      res.jsonp(agenda);
    }
  });
};

/**
 * List of Agendas
 */
exports.list = function(req, res) {
  Agenda.find().sort('-created').populate('user', 'displayName').exec(function(err, agendas) {
    if (err) {
      return res.status(400).send({
        message: errorHandler.getErrorMessage(err)
      });
    } else {
      res.jsonp(agendas);
    }
  });
};

/**
 * Agenda middleware
 */
exports.agendaByID = function(req, res, next, id) {

  if (!mongoose.Types.ObjectId.isValid(id)) {
    return res.status(400).send({
      message: 'Agenda is invalid'
    });
  }

  Agenda.findById(id).populate('user', 'displayName').exec(function (err, agenda) {
    if (err) {
      return next(err);
    } else if (!agenda) {
      return res.status(404).send({
        message: 'No Agenda with that identifier has been found'
      });
    }
    req.agenda = agenda;
    next();
  });
};
