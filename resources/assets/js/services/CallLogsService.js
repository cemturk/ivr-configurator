angular.module('CallLogsService', []).factory('CallLogs', ['$resource',
  function($resource) {
    return $resource('/api/calllogs/:smsId', {
      smsId: '@id'
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);
