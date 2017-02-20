'use strict';

describe('Somos E2E Tests:', function () {
  describe('Test Somos page', function () {
    it('Should report missing credentials', function () {
      browser.get('http://localhost:3001/somos');
      expect(element.all(by.repeater('somo in somos')).count()).toEqual(0);
    });
  });
});
