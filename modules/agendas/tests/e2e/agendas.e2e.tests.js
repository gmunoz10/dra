'use strict';

describe('Agendas E2E Tests:', function () {
  describe('Test Agendas page', function () {
    it('Should report missing credentials', function () {
      browser.get('http://localhost:3001/agendas');
      expect(element.all(by.repeater('agenda in agendas')).count()).toEqual(0);
    });
  });
});
