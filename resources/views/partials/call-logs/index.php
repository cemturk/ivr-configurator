<div ng-controller="CallLogsController" ng-init="findAll()">
    <h2>Outbox</h2>
    <p ng-if="!messages.length">
        There are no sent messages right now, <a href="/sendsms">send one!</a>
    </p>

    <table class="table table-striped table-bordered table-list" ng-if="messages.length">
        <thead>
        <tr>
            <th>From</th>
            <th>To</th>
            <th>Date</th>
            <th>Message</th>
        </tr>
        </thead>
        <tbody>
        <tr ng-repeat="message in messages">
            <td>
                {{ message.from }}
            </td>
            <td>{{ message.to }}</td>
            <td>{{ message.created_at }}</td>
            <td>{{ message.message }}</td>
        </tr>
        </tbody>
    </table>
</div>