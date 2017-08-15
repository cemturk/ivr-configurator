angular.module('CallLogsController', []).controller('CallLogsController', ['$scope', '$location', '$localStorage', 'CallLogs',
    function ($scope, $location, $localStorage, CallLogs) {
        //get all messages
        $scope.findAll = function () {
            $scope.messages = CallLogs.query();
        }
    }
]);
