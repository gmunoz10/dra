(function () {
  'use strict';

  angular
    .module('agenda')
    .run(menuConfig);

  menuConfig.$inject = ['Menus'];

  function menuConfig(menuService) {
    // Set top bar menu items
    menuService.addMenuItem('topbar', {
      title: 'Agenda',
      state: 'agenda',
      type: 'item',
      isPublic: true
    });

  }
}());
