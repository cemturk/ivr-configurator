<div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">

    <div class="panel panel-default" >
        <div class="panel-heading">
            <div class="panel-title text-center"><img class="cm-logo-img"
                                                      src="/images/cem-logo.png"
                                                      width="135" height="40"
                                                      alt="CeM Telecom Logo"> </a></div>
        </div>

        <div class="panel-body" >

            <form name="form" id="form" class="form-horizontal" name="loginForm" ng-controller="UserController" ng-submit="login()">

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="user" type="text" id="username" ng-model="username"
                           class="form-control" placeholder="E-mail">
                </div>

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" id="password" ng-model="password"
                           class="form-control" placeholder="Password">
                </div>

                <div class="form-group">
                    <!-- Button -->
                    <div class="col-sm-12 controls">
                        <button type="submit" href="#" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-log-in"></i> Log in</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>


