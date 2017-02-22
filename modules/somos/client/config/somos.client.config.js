(function () {
  'use strict';

  angular
    .module('somos')
    .run(menuConfig);

  menuConfig.$inject = ['Menus'];

  function menuConfig(menuService) {
    // Set top bar menu items
    menuService.addMenuItem('topbar', {
      title: '¿Quiénes somos?',
      state: 'somos',
      type: 'item',
      isPublic: true
    });

  }
}());
