angular.module('CallLogsController', []).controller('CallLogsController', ['$scope', '$location', '$localStorage', 'CallLogs',
    function ($scope, $location, $localStorage, CallLogs) {
        //get all calls
        $scope.findAll = function () {
            $scope.calls = CallLogs.query();
        };
        //show call details
        $scope.show = function (call) {
            $scope.the_call = call;
            $scope.call_logs = CallLogs.query({callid: call['call-id']});
        };
    }
]);
