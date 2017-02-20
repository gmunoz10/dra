(function () {
  'use strict';

  angular
    .module('somos')
    .run(menuConfig);

  menuConfig.$inject = ['Menus'];

  function menuConfig(menuService) {
    // Set top bar menu items
    menuService.addMenuItem('topbar', {
      title: 'Somos',
      state: 'somos',
      type: 'dropdown',
      roles: ['*']
    });

    // Add the dropdown list item
    menuService.addSubMenuItem('topbar', 'somos', {
      title: 'List Somos',
      state: 'somos.list'
    });

    // Add the dropdown create item
    menuService.addSubMenuItem('topbar', 'somos', {
      title: 'Create Somo',
      state: 'somos.create',
      roles: ['user']
    });
  }
}());
