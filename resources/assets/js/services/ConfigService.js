angular.module('ConfigService', []).factory('Config', ['$resource',
  function($resource) {
    return $resource('/api/config/:smsId', {
      smsId: '@id'
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);
