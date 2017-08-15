<div class="container theme-showcase" role="main" ng-controller="CallLogsController" ng-init="findAll()">
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Calls</h3>
                </div>
                <div class="panel-body" style="overflow-x:scroll">
                    <label>Click a call to view details.</label>
                    <table id="calllog_table" class="table table-bordered">
                        <tr>
                            <th>Call</th>
                        </tr>
                        <tbody>
                        <tr ng-repeat="call in calls" class="calls-row" ng-click="show(call)">
                            <td>
                                <div class="row">
                                    <div class="col-md-6">From : <strong>{{ call.from }}</strong></div>
                                    <div class="col-md-6">To : {{ call.to }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">Date : {{ call.created_at }}</div>
                                    <div class="col-md-12">ID : {{ call['call-id'] }}</div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="panel panel-primary" ng-if="the_call">
                <div class="panel-heading">
                    <h3 class="panel-title">Call Activity {{the_call.from }}
                        <span class="pull-right">{{ the_call.created_at }}</span></h3>
                </div>
                <div class="panel-body" style="overflow-x:scroll">
                    <label>Call ID :</label> {{ the_call['call-id'] }}
                    <table id="calllog_table" class="table table-bordered">
                        <tr>
                            <th>Event</th>
                            <th>Inst. ID</th>
                            <th>Details</th>
                            <th>Date / Time</th>
                        </tr>
                        <tbody>
                        <tr class="call-row" ng-repeat="call_log in call_logs">
                            <td>{{ call_log.event }}</td>
                            <td>{{ call_log['instruction-id'] }}</td>
                            <td>{{ call_log.details }}</td>
                            <td>{{ call_log.created_at }}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>