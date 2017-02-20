'use strict';

/**
 * Module dependencies.
 */
var mongoose = require('mongoose'),
  Schema = mongoose.Schema;

/**
 * Somo Schema
 */
var SomoSchema = new Schema({
  name: {
    type: String,
    default: '',
    required: 'Please fill Somo name',
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

mongoose.model('Somo', SomoSchema);
