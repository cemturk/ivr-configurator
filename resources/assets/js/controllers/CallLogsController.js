angular.module('CallLogsController', []).controller('CallLogsController', ['$scope', '$location', '$localStorage', 'CallLogs',
  function($scope, $location, $localStorage, Outbox) {
    //get all messages
    $scope.findAll = function() {
      $scope.messages = Outbox.query();
    }
  }
]);
