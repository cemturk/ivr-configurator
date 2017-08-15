angular.module('CallLogsService', []).factory('CallLogs', ['$resource',
    function ($resource) {
        return $resource('/api/call-logs/:callid', {
            callid: '@id'
        }, {
            update: {
                method: 'PUT'
            }
        });
    }
]);
