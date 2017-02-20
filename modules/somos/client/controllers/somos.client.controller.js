(function () {
  'use strict';

  // Somos controller
  angular
    .module('somos')
    .controller('SomosController', SomosController);

  SomosController.$inject = ['$scope', '$state', '$window', 'Authentication', 'somoResolve'];

  function SomosController ($scope, $state, $window, Authentication, somo) {
    var vm = this;

    vm.authentication = Authentication;
    vm.somo = somo;
    vm.error = null;
    vm.form = {};
    vm.remove = remove;
    vm.save = save;

    // Remove existing Somo
    function remove() {
      if ($window.confirm('Are you sure you want to delete?')) {
        vm.somo.$remove($state.go('somos.list'));
      }
    }

    // Save Somo
    function save(isValid) {
      if (!isValid) {
        $scope.$broadcast('show-errors-check-validity', 'vm.form.somoForm');
        return false;
      }

      // TODO: move create/update logic to service
      if (vm.somo._id) {
        vm.somo.$update(successCallback, errorCallback);
      } else {
        vm.somo.$save(successCallback, errorCallback);
      }

      function successCallback(res) {
        $state.go('somos.view', {
          somoId: res._id
        });
      }

      function errorCallback(res) {
        vm.error = res.data.message;
      }
    }
  }
}());
