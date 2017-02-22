(function () {
  'use strict';

  describe('Agendas List Controller Tests', function () {
    // Initialize global variables
    var AgendasListController,
      $scope,
      $httpBackend,
      $state,
      Authentication,
      AgendasService,
      mockAgenda;

    // The $resource service augments the response object with methods for updating and deleting the resource.
    // If we were to use the standard toEqual matcher, our tests would fail because the test values would not match
    // the responses exactly. To solve the problem, we define a new toEqualData Jasmine matcher.
    // When the toEqualData matcher compares two objects, it takes only object properties into
    // account and ignores methods.
    beforeEach(function () {
      jasmine.addMatchers({
        toEqualData: function (util, customEqualityTesters) {
          return {
            compare: function (actual, expected) {
              return {
                pass: angular.equals(actual, expected)
              };
            }
          };
        }
      });
    });

    // Then we can start by loading the main application module
    beforeEach(module(ApplicationConfiguration.applicationModuleName));

    // The injector ignores leading and trailing underscores here (i.e. _$httpBackend_).
    // This allows us to inject a service but then attach it to a variable
    // with the same name as the service.
    beforeEach(inject(function ($controller, $rootScope, _$state_, _$httpBackend_, _Authentication_, _AgendasService_) {
      // Set a new global scope
      $scope = $rootScope.$new();

      // Point global variables to injected services
      $httpBackend = _$httpBackend_;
      $state = _$state_;
      Authentication = _Authentication_;
      AgendasService = _AgendasService_;

      // create mock article
      mockAgenda = new AgendasService({
        _id: '525a8422f6d0f87f0e407a33',
        name: 'Agenda Name'
      });

      // Mock logged in user
      Authentication.user = {
        roles: ['user']
      };

      // Initialize the Agendas List controller.
      AgendasListController = $controller('AgendasListController as vm', {
        $scope: $scope
      });

      // Spy on state go
      spyOn($state, 'go');
    }));

    describe('Instantiate', function () {
      var mockAgendaList;

      beforeEach(function () {
        mockAgendaList = [mockAgenda, mockAgenda];
      });

      it('should send a GET request and return all Agendas', inject(function (AgendasService) {
        // Set POST response
        $httpBackend.expectGET('api/agendas').respond(mockAgendaList);


        $httpBackend.flush();

        // Test form inputs are reset
        expect($scope.vm.agendas.length).toEqual(2);
        expect($scope.vm.agendas[0]).toEqual(mockAgenda);
        expect($scope.vm.agendas[1]).toEqual(mockAgenda);

      }));
    });
  });
}());
