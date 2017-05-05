var app = angular.module('NewFitnessModule')

    .controller('LoginCtrl', ['$scope', '$rootScope', '$location', 'AuthenticationService', function ($scope, $rootScope, $location, AuthenticationService){
        $scope.page = "Login";

        $scope.login = function () {
            AuthenticationService.ClearCredentials();

            $scope.loading = true;
            AuthenticationService.Login($scope.username, $scope.password, function(response) {
                var result = response.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                if(!result.hasError) {
                    AuthenticationService.SetCredentials($scope.username, $scope.password);
                    window.location = 'home';
                }
            });
            $scope.loading = false;
        };
    }])

    .controller('HomeCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.page = "Home";
    }]);