'use strict';

/**
 * Module dependencies.
 */
var mongoose = require('mongoose'),
  Schema = mongoose.Schema;

/**
 * Agenda Schema
 */
var AgendaSchema = new Schema({
  name: {
    type: String,
    default: '',
    required: 'Please fill Agenda name',
    trim: true
  },
  created: {
    type: Date,
    default: Date.now
  },
  user: {
    type: Schema.ObjectId,
    ref: 'User'
  }
});

mongoose.model('Agenda', AgendaSchema);
