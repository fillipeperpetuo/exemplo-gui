var app = angular.module('NewFitness', ['ngRoute', 'ngSanitize']);

app.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
    $routeProvider

        .when('/', {
            templateUrl: 'view/home.html',
            controller: 'MainCtrl'
        })

        .when('/help', {
            templateUrl: 'view/help.html',
            controller: 'MainCtrl'
        })

        .otherwise({
            redirectTo: '/'
        });

    $locationProvider.html5Mode(true);
}]);

app.controller('MainCtrl', ['$scope', '$http', function($scope, $http) {
    $scope.usuarios;

    $http({ url: 'back/usuario/list', method: "GET" }).then(function(response) {
        var result = response.data;

        if (result.error) {
            alert("Falha ao carregar usuarios");
        }
        $scope.usuarios = result.data;

    }, function(response){
        alert(response);
    });

}]);