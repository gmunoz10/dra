(function () {
  'use strict';

  describe('Somos Route Tests', function () {
    // Initialize global variables
    var $scope,
      SomosService;

    // We can start by loading the main application module
    beforeEach(module(ApplicationConfiguration.applicationModuleName));

    // The injector ignores leading and trailing underscores here (i.e. _$httpBackend_).
    // This allows us to inject a service but then attach it to a variable
    // with the same name as the service.
    beforeEach(inject(function ($rootScope, _SomosService_) {
      // Set a new global scope
      $scope = $rootScope.$new();
      SomosService = _SomosService_;
    }));

    describe('Route Config', function () {
      describe('Main Route', function () {
        var mainstate;
        beforeEach(inject(function ($state) {
          mainstate = $state.get('somos');
        }));

        it('Should have the correct URL', function () {
          expect(mainstate.url).toEqual('/somos');
        });

        it('Should be abstract', function () {
          expect(mainstate.abstract).toBe(true);
        });

        it('Should have template', function () {
          expect(mainstate.template).toBe('<ui-view/>');
        });
      });

      describe('View Route', function () {
        var viewstate,
          SomosController,
          mockSomo;

        beforeEach(inject(function ($controller, $state, $templateCache) {
          viewstate = $state.get('somos.view');
          $templateCache.put('modules/somos/client/views/view-somo.client.view.html', '');

          // create mock Somo
          mockSomo = new SomosService({
            _id: '525a8422f6d0f87f0e407a33',
            name: 'Somo Name'
          });

          // Initialize Controller
          SomosController = $controller('SomosController as vm', {
            $scope: $scope,
            somoResolve: mockSomo
          });
        }));

        it('Should have the correct URL', function () {
          expect(viewstate.url).toEqual('/:somoId');
        });

        it('Should have a resolve function', function () {
          expect(typeof viewstate.resolve).toEqual('object');
          expect(typeof viewstate.resolve.somoResolve).toEqual('function');
        });

        it('should respond to URL', inject(function ($state) {
          expect($state.href(viewstate, {
            somoId: 1
          })).toEqual('/somos/1');
        }));

        it('should attach an Somo to the controller scope', function () {
          expect($scope.vm.somo._id).toBe(mockSomo._id);
        });

        it('Should not be abstract', function () {
          expect(viewstate.abstract).toBe(undefined);
        });

        it('Should have templateUrl', function () {
          expect(viewstate.templateUrl).toBe('modules/somos/client/views/view-somo.client.view.html');
        });
      });

      describe('Create Route', function () {
        var createstate,
          SomosController,
          mockSomo;

        beforeEach(inject(function ($controller, $state, $templateCache) {
          createstate = $state.get('somos.create');
          $templateCache.put('modules/somos/client/views/form-somo.client.view.html', '');

          // create mock Somo
          mockSomo = new SomosService();

          // Initialize Controller
          SomosController = $controller('SomosController as vm', {
            $scope: $scope,
            somoResolve: mockSomo
          });
        }));

        it('Should have the correct URL', function () {
          expect(createstate.url).toEqual('/create');
        });

        it('Should have a resolve function', function () {
          expect(typeof createstate.resolve).toEqual('object');
          expect(typeof createstate.resolve.somoResolve).toEqual('function');
        });

        it('should respond to URL', inject(function ($state) {
          expect($state.href(createstate)).toEqual('/somos/create');
        }));

        it('should attach an Somo to the controller scope', function () {
          expect($scope.vm.somo._id).toBe(mockSomo._id);
          expect($scope.vm.somo._id).toBe(undefined);
        });

        it('Should not be abstract', function () {
          expect(createstate.abstract).toBe(undefined);
        });

        it('Should have templateUrl', function () {
          expect(createstate.templateUrl).toBe('modules/somos/client/views/form-somo.client.view.html');
        });
      });

      describe('Edit Route', function () {
        var editstate,
          SomosController,
          mockSomo;

        beforeEach(inject(function ($controller, $state, $templateCache) {
          editstate = $state.get('somos.edit');
          $templateCache.put('modules/somos/client/views/form-somo.client.view.html', '');

          // create mock Somo
          mockSomo = new SomosService({
            _id: '525a8422f6d0f87f0e407a33',
            name: 'Somo Name'
          });

          // Initialize Controller
          SomosController = $controller('SomosController as vm', {
            $scope: $scope,
            somoResolve: mockSomo
          });
        }));

        it('Should have the correct URL', function () {
          expect(editstate.url).toEqual('/:somoId/edit');
        });

        it('Should have a resolve function', function () {
          expect(typeof editstate.resolve).toEqual('object');
          expect(typeof editstate.resolve.somoResolve).toEqual('function');
        });

        it('should respond to URL', inject(function ($state) {
          expect($state.href(editstate, {
            somoId: 1
          })).toEqual('/somos/1/edit');
        }));

        it('should attach an Somo to the controller scope', function () {
          expect($scope.vm.somo._id).toBe(mockSomo._id);
        });

        it('Should not be abstract', function () {
          expect(editstate.abstract).toBe(undefined);
        });

        it('Should have templateUrl', function () {
          expect(editstate.templateUrl).toBe('modules/somos/client/views/form-somo.client.view.html');
        });

        xit('Should go to unauthorized route', function () {

        });
      });

    });
  });
}());
