<!doctype html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8">
    <title>CeM Telecom IVR Configurator</title>

  <!-- Sets the basepath for the library if not in same directory -->
  <script type="text/javascript">
  mxBasePath = 'js/mxgraph';
  </script>
    <script type="application/javascript" src="{{ elixir('js/all.js') }}"></script>
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}"/>
    <link rel="stylesheet" href="{{ elixir('css/all.css') }}"/>
</head>
<body ng-app="cemApp" ng-controller="MainController" ng-init="getAuthenticatedUser()">
<nav class="navbar  navbar-fixed-top cem-nav">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a id="cm-logo" href="/"> <img class="cm-logo-img"
                                                                   src="/images/cem-logo.png"
                                                                   width="135" height="40"
                                                                   alt="CeM Telecom Logo"> </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse pull-right"  >
            <ul class="nav navbar-nav">
                <li ng-if="authenticatedUser != null" ng-class="{active:isActive(config)}">
                    <a href="/config">
                        <i class="glyphicon glyphicon-wrench"></i>
                        IVR Configurator
                    </a>
                </li>
                <li ng-if="authenticatedUser != null" ng-class="{active:isActive('/call-logs')}">
                    <a href="/call-logs">
                        <i class="glyphicon glyphicon-list-alt"></i>
                        Call Logs
                    </a>
                </li>
                <li  ng-if="authenticatedUser == null" ng-class="{active:isActive('/auth/login')}">
                    <a href="/auth/login">
                        <i class="glyphicon glyphicon-log-in"></i>
                        Log in
                    </a>
                </li>
                <li ng-if="authenticatedUser != null" ng-class="{active:isActive('/users/view/' + authenticatedUser.id)}">
                    <a ng-href="/users/view/@{{authenticatedUser.id}}">
                        <i class="glyphicon glyphicon-user"></i>
                        @{{authenticatedUser.username}}
                    </a>
                </li>
                <li ng-if="authenticatedUser != null" ng-click="logout()">
                    <a ng-href="#">
                        <i class="glyphicon glyphicon-log-out"></i>
                        Log out
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div ng-view>
    </div>
    <div id="particles"></div>
</div>

</body>
</html>
