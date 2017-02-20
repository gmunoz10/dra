'use strict';

var should = require('should'),
  request = require('supertest'),
  path = require('path'),
  mongoose = require('mongoose'),
  User = mongoose.model('User'),
  Somo = mongoose.model('Somo'),
  express = require(path.resolve('./config/lib/express'));

/**
 * Globals
 */
var app,
  agent,
  credentials,
  user,
  somo;

/**
 * Somo routes tests
 */
describe('Somo CRUD tests', function () {

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

    // Save a user to the test db and create new Somo
    user.save(function () {
      somo = {
        name: 'Somo name'
      };

      done();
    });
  });

  it('should be able to save a Somo if logged in', function (done) {
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

        // Save a new Somo
        agent.post('/api/somos')
          .send(somo)
          .expect(200)
          .end(function (somoSaveErr, somoSaveRes) {
            // Handle Somo save error
            if (somoSaveErr) {
              return done(somoSaveErr);
            }

            // Get a list of Somos
            agent.get('/api/somos')
              .end(function (somosGetErr, somosGetRes) {
                // Handle Somos save error
                if (somosGetErr) {
                  return done(somosGetErr);
                }

                // Get Somos list
                var somos = somosGetRes.body;

                // Set assertions
                (somos[0].user._id).should.equal(userId);
                (somos[0].name).should.match('Somo name');

                // Call the assertion callback
                done();
              });
          });
      });
  });

  it('should not be able to save an Somo if not logged in', function (done) {
    agent.post('/api/somos')
      .send(somo)
      .expect(403)
      .end(function (somoSaveErr, somoSaveRes) {
        // Call the assertion callback
        done(somoSaveErr);
      });
  });

  it('should not be able to save an Somo if no name is provided', function (done) {
    // Invalidate name field
    somo.name = '';

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

        // Save a new Somo
        agent.post('/api/somos')
          .send(somo)
          .expect(400)
          .end(function (somoSaveErr, somoSaveRes) {
            // Set message assertion
            (somoSaveRes.body.message).should.match('Please fill Somo name');

            // Handle Somo save error
            done(somoSaveErr);
          });
      });
  });

  it('should be able to update an Somo if signed in', function (done) {
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

        // Save a new Somo
        agent.post('/api/somos')
          .send(somo)
          .expect(200)
          .end(function (somoSaveErr, somoSaveRes) {
            // Handle Somo save error
            if (somoSaveErr) {
              return done(somoSaveErr);
            }

            // Update Somo name
            somo.name = 'WHY YOU GOTTA BE SO MEAN?';

            // Update an existing Somo
            agent.put('/api/somos/' + somoSaveRes.body._id)
              .send(somo)
              .expect(200)
              .end(function (somoUpdateErr, somoUpdateRes) {
                // Handle Somo update error
                if (somoUpdateErr) {
                  return done(somoUpdateErr);
                }

                // Set assertions
                (somoUpdateRes.body._id).should.equal(somoSaveRes.body._id);
                (somoUpdateRes.body.name).should.match('WHY YOU GOTTA BE SO MEAN?');

                // Call the assertion callback
                done();
              });
          });
      });
  });

  it('should be able to get a list of Somos if not signed in', function (done) {
    // Create new Somo model instance
    var somoObj = new Somo(somo);

    // Save the somo
    somoObj.save(function () {
      // Request Somos
      request(app).get('/api/somos')
        .end(function (req, res) {
          // Set assertion
          res.body.should.be.instanceof(Array).and.have.lengthOf(1);

          // Call the assertion callback
          done();
        });

    });
  });

  it('should be able to get a single Somo if not signed in', function (done) {
    // Create new Somo model instance
    var somoObj = new Somo(somo);

    // Save the Somo
    somoObj.save(function () {
      request(app).get('/api/somos/' + somoObj._id)
        .end(function (req, res) {
          // Set assertion
          res.body.should.be.instanceof(Object).and.have.property('name', somo.name);

          // Call the assertion callback
          done();
        });
    });
  });

  it('should return proper error for single Somo with an invalid Id, if not signed in', function (done) {
    // test is not a valid mongoose Id
    request(app).get('/api/somos/test')
      .end(function (req, res) {
        // Set assertion
        res.body.should.be.instanceof(Object).and.have.property('message', 'Somo is invalid');

        // Call the assertion callback
        done();
      });
  });

  it('should return proper error for single Somo which doesnt exist, if not signed in', function (done) {
    // This is a valid mongoose Id but a non-existent Somo
    request(app).get('/api/somos/559e9cd815f80b4c256a8f41')
      .end(function (req, res) {
        // Set assertion
        res.body.should.be.instanceof(Object).and.have.property('message', 'No Somo with that identifier has been found');

        // Call the assertion callback
        done();
      });
  });

  it('should be able to delete an Somo if signed in', function (done) {
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

        // Save a new Somo
        agent.post('/api/somos')
          .send(somo)
          .expect(200)
          .end(function (somoSaveErr, somoSaveRes) {
            // Handle Somo save error
            if (somoSaveErr) {
              return done(somoSaveErr);
            }

            // Delete an existing Somo
            agent.delete('/api/somos/' + somoSaveRes.body._id)
              .send(somo)
              .expect(200)
              .end(function (somoDeleteErr, somoDeleteRes) {
                // Handle somo error error
                if (somoDeleteErr) {
                  return done(somoDeleteErr);
                }

                // Set assertions
                (somoDeleteRes.body._id).should.equal(somoSaveRes.body._id);

                // Call the assertion callback
                done();
              });
          });
      });
  });

  it('should not be able to delete an Somo if not signed in', function (done) {
    // Set Somo user
    somo.user = user;

    // Create new Somo model instance
    var somoObj = new Somo(somo);

    // Save the Somo
    somoObj.save(function () {
      // Try deleting Somo
      request(app).delete('/api/somos/' + somoObj._id)
        .expect(403)
        .end(function (somoDeleteErr, somoDeleteRes) {
          // Set message assertion
          (somoDeleteRes.body.message).should.match('User is not authorized');

          // Handle Somo error error
          done(somoDeleteErr);
        });

    });
  });

  it('should be able to get a single Somo that has an orphaned user reference', function (done) {
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

          // Save a new Somo
          agent.post('/api/somos')
            .send(somo)
            .expect(200)
            .end(function (somoSaveErr, somoSaveRes) {
              // Handle Somo save error
              if (somoSaveErr) {
                return done(somoSaveErr);
              }

              // Set assertions on new Somo
              (somoSaveRes.body.name).should.equal(somo.name);
              should.exist(somoSaveRes.body.user);
              should.equal(somoSaveRes.body.user._id, orphanId);

              // force the Somo to have an orphaned user reference
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

                    // Get the Somo
                    agent.get('/api/somos/' + somoSaveRes.body._id)
                      .expect(200)
                      .end(function (somoInfoErr, somoInfoRes) {
                        // Handle Somo error
                        if (somoInfoErr) {
                          return done(somoInfoErr);
                        }

                        // Set assertions
                        (somoInfoRes.body._id).should.equal(somoSaveRes.body._id);
                        (somoInfoRes.body.name).should.equal(somo.name);
                        should.equal(somoInfoRes.body.user, undefined);

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
      Somo.remove().exec(done);
    });
  });
});
