'use strict';

var should = require('should'),
  request = require('supertest'),
  path = require('path'),
  mongoose = require('mongoose'),
  User = mongoose.model('User'),
  Agenda = mongoose.model('Agenda'),
  express = require(path.resolve('./config/lib/express'));

/**
 * Globals
 */
var app,
  agent,
  credentials,
  user,
  agenda;

/**
 * Agenda routes tests
 */
describe('Agenda CRUD tests', function () {

  before(function (done) {
    // Get application
    app = express.init(mongoose);
    agent = request.agent(app);

    done();
  });

  beforeEach(function (done) {
    // Create user credentials
    credentials = {
      username: 'username',
      password: 'M3@n.jsI$Aw3$0m3'
    };

    // Create a new user
    user = new User({
      firstName: 'Full',
      lastName: 'Name',
      displayName: 'Full Name',
      email: 'test@test.com',
      username: credentials.username,
      password: credentials.password,
      provider: 'local'
    });

    // Save a user to the test db and create new Agenda
    user.save(function () {
      agenda = {
        name: 'Agenda name'
      };

      done();
    });
  });

  it('should be able to save a Agenda if logged in', function (done) {
    agent.post('/api/auth/signin')
      .send(credentials)
      .expect(200)
      .end(function (signinErr, signinRes) {
        // Handle signin error
        if (signinErr) {
          return done(signinErr);
        }

        // Get the userId
        var userId = user.id;

        // Save a new Agenda
        agent.post('/api/agendas')
          .send(agenda)
          .expect(200)
          .end(function (agendaSaveErr, agendaSaveRes) {
            // Handle Agenda save error
            if (agendaSaveErr) {
              return done(agendaSaveErr);
            }

            // Get a list of Agendas
            agent.get('/api/agendas')
              .end(function (agendasGetErr, agendasGetRes) {
                // Handle Agendas save error
                if (agendasGetErr) {
                  return done(agendasGetErr);
                }

                // Get Agendas list
                var agendas = agendasGetRes.body;

                // Set assertions
                (agendas[0].user._id).should.equal(userId);
                (agendas[0].name).should.match('Agenda name');

                // Call the assertion callback
                done();
              });
          });
      });
  });

  it('should not be able to save an Agenda if not logged in', function (done) {
    agent.post('/api/agendas')
      .send(agenda)
      .expect(403)
      .end(function (agendaSaveErr, agendaSaveRes) {
        // Call the assertion callback
        done(agendaSaveErr);
      });
  });

  it('should not be able to save an Agenda if no name is provided', function (done) {
    // Invalidate name field
    agenda.name = '';

    agent.post('/api/auth/signin')
      .send(credentials)
      .expect(200)
      .end(function (signinErr, signinRes) {
        // Handle signin error
        if (signinErr) {
          return done(signinErr);
        }

        // Get the userId
        var userId = user.id;

        // Save a new Agenda
        agent.post('/api/agendas')
          .send(agenda)
          .expect(400)
          .end(function (agendaSaveErr, agendaSaveRes) {
            // Set message assertion
            (agendaSaveRes.body.message).should.match('Please fill Agenda name');

            // Handle Agenda save error
            done(agendaSaveErr);
          });
      });
  });

  it('should be able to update an Agenda if signed in', function (done) {
    agent.post('/api/auth/signin')
      .send(credentials)
      .expect(200)
      .end(function (signinErr, signinRes) {
        // Handle signin error
        if (signinErr) {
          return done(signinErr);
        }

        // Get the userId
        var userId = user.id;

        // Save a new Agenda
        agent.post('/api/agendas')
          .send(agenda)
          .expect(200)
          .end(function (agendaSaveErr, agendaSaveRes) {
            // Handle Agenda save error
            if (agendaSaveErr) {
              return done(agendaSaveErr);
            }

            // Update Agenda name
            agenda.name = 'WHY YOU GOTTA BE SO MEAN?';

            // Update an existing Agenda
            agent.put('/api/agendas/' + agendaSaveRes.body._id)
              .send(agenda)
              .expect(200)
              .end(function (agendaUpdateErr, agendaUpdateRes) {
                // Handle Agenda update error
                if (agendaUpdateErr) {
                  return done(agendaUpdateErr);
                }

                // Set assertions
                (agendaUpdateRes.body._id).should.equal(agendaSaveRes.body._id);
                (agendaUpdateRes.body.name).should.match('WHY YOU GOTTA BE SO MEAN?');

                // Call the assertion callback
                done();
              });
          });
      });
  });

  it('should be able to get a list of Agendas if not signed in', function (done) {
    // Create new Agenda model instance
    var agendaObj = new Agenda(agenda);

    // Save the agenda
    agendaObj.save(function () {
      // Request Agendas
      request(app).get('/api/agendas')
        .end(function (req, res) {
          // Set assertion
          res.body.should.be.instanceof(Array).and.have.lengthOf(1);

          // Call the assertion callback
          done();
        });

    });
  });

  it('should be able to get a single Agenda if not signed in', function (done) {
    // Create new Agenda model instance
    var agendaObj = new Agenda(agenda);

    // Save the Agenda
    agendaObj.save(function () {
      request(app).get('/api/agendas/' + agendaObj._id)
        .end(function (req, res) {
          // Set assertion
          res.body.should.be.instanceof(Object).and.have.property('name', agenda.name);

          // Call the assertion callback
          done();
        });
    });
  });

  it('should return proper error for single Agenda with an invalid Id, if not signed in', function (done) {
    // test is not a valid mongoose Id
    request(app).get('/api/agendas/test')
      .end(function (req, res) {
        // Set assertion
        res.body.should.be.instanceof(Object).and.have.property('message', 'Agenda is invalid');

        // Call the assertion callback
        done();
      });
  });

  it('should return proper error for single Agenda which doesnt exist, if not signed in', function (done) {
    // This is a valid mongoose Id but a non-existent Agenda
    request(app).get('/api/agendas/559e9cd815f80b4c256a8f41')
      .end(function (req, res) {
        // Set assertion
        res.body.should.be.instanceof(Object).and.have.property('message', 'No Agenda with that identifier has been found');

        // Call the assertion callback
        done();
      });
  });

  it('should be able to delete an Agenda if signed in', function (done) {
    agent.post('/api/auth/signin')
      .send(credentials)
      .expect(200)
      .end(function (signinErr, signinRes) {
        // Handle signin error
        if (signinErr) {
          return done(signinErr);
        }

        // Get the userId
        var userId = user.id;

        // Save a new Agenda
        agent.post('/api/agendas')
          .send(agenda)
          .expect(200)
          .end(function (agendaSaveErr, agendaSaveRes) {
            // Handle Agenda save error
            if (agendaSaveErr) {
              return done(agendaSaveErr);
            }

            // Delete an existing Agenda
            agent.delete('/api/agendas/' + agendaSaveRes.body._id)
              .send(agenda)
              .expect(200)
              .end(function (agendaDeleteErr, agendaDeleteRes) {
                // Handle agenda error error
                if (agendaDeleteErr) {
                  return done(agendaDeleteErr);
                }

                // Set assertions
                (agendaDeleteRes.body._id).should.equal(agendaSaveRes.body._id);

                // Call the assertion callback
                done();
              });
          });
      });
  });

  it('should not be able to delete an Agenda if not signed in', function (done) {
    // Set Agenda user
    agenda.user = user;

    // Create new Agenda model instance
    var agendaObj = new Agenda(agenda);

    // Save the Agenda
    agendaObj.save(function () {
      // Try deleting Agenda
      request(app).delete('/api/agendas/' + agendaObj._id)
        .expect(403)
        .end(function (agendaDeleteErr, agendaDeleteRes) {
          // Set message assertion
          (agendaDeleteRes.body.message).should.match('User is not authorized');

          // Handle Agenda error error
          done(agendaDeleteErr);
        });

    });
  });

  it('should be able to get a single Agenda that has an orphaned user reference', function (done) {
    // Create orphan user creds
    var _creds = {
      username: 'orphan',
      password: 'M3@n.jsI$Aw3$0m3'
    };

    // Create orphan user
    var _orphan = new User({
      firstName: 'Full',
      lastName: 'Name',
      displayName: 'Full Name',
      email: 'orphan@test.com',
      username: _creds.username,
      password: _creds.password,
      provider: 'local'
    });

    _orphan.save(function (err, orphan) {
      // Handle save error
      if (err) {
        return done(err);
      }

      agent.post('/api/auth/signin')
        .send(_creds)
        .expect(200)
        .end(function (signinErr, signinRes) {
          // Handle signin error
          if (signinErr) {
            return done(signinErr);
          }

          // Get the userId
          var orphanId = orphan._id;

          // Save a new Agenda
          agent.post('/api/agendas')
            .send(agenda)
            .expect(200)
            .end(function (agendaSaveErr, agendaSaveRes) {
              // Handle Agenda save error
              if (agendaSaveErr) {
                return done(agendaSaveErr);
              }

              // Set assertions on new Agenda
              (agendaSaveRes.body.name).should.equal(agenda.name);
              should.exist(agendaSaveRes.body.user);
              should.equal(agendaSaveRes.body.user._id, orphanId);

              // force the Agenda to have an orphaned user reference
              orphan.remove(function () {
                // now signin with valid user
                agent.post('/api/auth/signin')
                  .send(credentials)
                  .expect(200)
                  .end(function (err, res) {
                    // Handle signin error
                    if (err) {
                      return done(err);
                    }

                    // Get the Agenda
                    agent.get('/api/agendas/' + agendaSaveRes.body._id)
                      .expect(200)
                      .end(function (agendaInfoErr, agendaInfoRes) {
                        // Handle Agenda error
                        if (agendaInfoErr) {
                          return done(agendaInfoErr);
                        }

                        // Set assertions
                        (agendaInfoRes.body._id).should.equal(agendaSaveRes.body._id);
                        (agendaInfoRes.body.name).should.equal(agenda.name);
                        should.equal(agendaInfoRes.body.user, undefined);

                        // Call the assertion callback
                        done();
                      });
                  });
              });
            });
        });
    });
  });

  afterEach(function (done) {
    User.remove().exec(function () {
      Agenda.remove().exec(done);
    });
  });
});
