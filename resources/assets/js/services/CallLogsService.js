angular.module('CallLogsService', []).factory('CallLogs', ['$resource',
  function($resource) {
    return $resource('/api/calllogs/:callid', {
      callid: '@id'
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);
