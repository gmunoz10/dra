'use strict';

/**
 * Module dependencies.
 */
var path = require('path'),
  mongoose = require('mongoose'),
  Somo = mongoose.model('Somo'),
  errorHandler = require(path.resolve('./modules/core/server/controllers/errors.server.controller')),
  _ = require('lodash');

/**
 * Create a Somo
 */
exports.create = function(req, res) {
  var somo = new Somo(req.body);
  somo.user = req.user;

  somo.save(function(err) {
    if (err) {
      return res.status(400).send({
        message: errorHandler.getErrorMessage(err)
      });
    } else {
      res.jsonp(somo);
    }
  });
};

/**
 * Show the current Somo
 */
exports.read = function(req, res) {
  // convert mongoose document to JSON
  var somo = req.somo ? req.somo.toJSON() : {};

  // Add a custom field to the Article, for determining if the current User is the "owner".
  // NOTE: This field is NOT persisted to the database, since it doesn't exist in the Article model.
  somo.isCurrentUserOwner = req.user && somo.user && somo.user._id.toString() === req.user._id.toString();

  res.jsonp(somo);
};

/**
 * Update a Somo
 */
exports.update = function(req, res) {
  var somo = req.somo;

  somo = _.extend(somo, req.body);

  somo.save(function(err) {
    if (err) {
      return res.status(400).send({
        message: errorHandler.getErrorMessage(err)
      });
    } else {
      res.jsonp(somo);
    }
  });
};

/**
 * Delete an Somo
 */
exports.delete = function(req, res) {
  var somo = req.somo;

  somo.remove(function(err) {
    if (err) {
      return res.status(400).send({
        message: errorHandler.getErrorMessage(err)
      });
    } else {
      res.jsonp(somo);
    }
  });
};

/**
 * List of Somos
 */
exports.list = function(req, res) {
  Somo.find().sort('-created').populate('user', 'displayName').exec(function(err, somos) {
    if (err) {
      return res.status(400).send({
        message: errorHandler.getErrorMessage(err)
      });
    } else {
      res.jsonp(somos);
    }
  });
};

/**
 * Somo middleware
 */
exports.somoByID = function(req, res, next, id) {

  if (!mongoose.Types.ObjectId.isValid(id)) {
    return res.status(400).send({
      message: 'Somo is invalid'
    });
  }

  Somo.findById(id).populate('user', 'displayName').exec(function (err, somo) {
    if (err) {
      return next(err);
    } else if (!somo) {
      return res.status(404).send({
        message: 'No Somo with that identifier has been found'
      });
    }
    req.somo = somo;
    next();
  });
};
