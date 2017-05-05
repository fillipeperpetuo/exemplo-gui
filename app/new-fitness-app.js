angular.module('NewFitnessModule', []);
angular.module('NewFitnessService', []);

var app = angular.module('NewFitness', [
    'ngRoute',
    'ngSanitize',
    'ngCookies',
    'NewFitnessModule',
    'NewFitnessService'
]);

app.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
    $routeProvider

        .when('/', {
            templateUrl: 'view/home.html',
            controller: 'HomeCtrl'
        })

        .when('/home', {
            templateUrl: 'view/home.html',
            controller: 'HomeCtrl'
        })

        .when('/login', {})

        .otherwise({
            templateUrl: 'view/page-404.html'
        });

    $locationProvider.html5Mode(true);
}]);

app.run(['$rootScope', '$location', '$cookies', '$http', function ($rootScope, $location, $cookies, $http) {
    // // keep user logged in after page refresh
    // $rootScope.globals = $cookies.getObject('globals') || {};
    // console.log($rootScope.globals);
    // if ($rootScope.globals.currentUser) {
    //     $http.defaults.headers.common['Authorization'] = 'Basic ' + $rootScope.globals.currentUser.authdata; // jshint ignore:line
    // }
    //
    // $rootScope.$on('$locationChangeStart', function (event, next, current) {
    //     //redirect to login page if not logged in
    //     if ($location.path() !== '/login' && !$rootScope.globals.currentUser) {
    //         window.location = 'login';
    //     }
    // });
}]);

app.controller('MainCtrl', ['$scope', 'AuthenticationService', function($scope, AuthenticationService) {
    $scope.logout = function() {
        AuthenticationService.ClearCredentials();
        window.location = 'login';
    }
}]);