angular.module('CallLogsController', []).controller('CallLogsController', ['$scope', '$location', '$localStorage', 'CallLogs',
    function ($scope, $location, $localStorage, CallLogs) {
        //get all messages
        $scope.findAll = function () {
            $scope.calls = CallLogs.query();
        };
        $scope.show = function (call) {
            console.log(call);
            $scope.the_call = call;
            $scope.call_logs = CallLogs.query({callid: call['call-id']});
        };
    }
]);
