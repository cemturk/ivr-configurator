<div class="container">
    <div class="row">
        <h3 class="col-md-12 text-center">
            <h2>Welcome to CeM Telecom IVR Configurator</h2>
        </div>
    </div>
    <div class="container" ng-if="authenticatedUser">
        <div class="row">
            <div class="col-md-12">
                <p>Hello {{authenticatedUser.username}}, welcome to your CeM Telecom IVR dashboard.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="/config">
                <div class="panel panel-primary">
                    <!-- Default panel contents -->
                    <div class="panel-heading"><i class="glyphicon glyphicon-wrench"></i> IVR Configurator</div>
                    <div class="panel-body">
                        <p>Configure your IVR workflow</p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="/call-logs">
                <div class="panel panel-primary">
                    <!-- Default panel contents -->
                    <div class="panel-heading"><i class="glyphicon glyphicon-send"></i> View Call Logs</div>
                    <div class="panel-body">
                        <p>View IVR Call Logs</p>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
    <p ng-if="!authenticatedUser">
        Hello guest, please <a href="/auth/login">Log in</a> to start configuring IVR system.
    </p>
</div>