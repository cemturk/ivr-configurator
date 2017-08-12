angular.module('ConfigService', []).factory('Config', ['$resource',
  function($resource) {
    return $resource('/api/config/:confid', {
      confid: '@id'
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);
