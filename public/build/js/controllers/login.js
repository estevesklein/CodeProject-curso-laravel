angular.module('app.controllers')
	.controller('LoginController', ['$scope', '$location', '$cookies', 'User', 'OAuth',
		function($scope, $location, $cookies, User, OAuth){
		$scope.user = {
			username: '',
			password: ''
		};

		$scope.error = {
			message: '',
			error: false
		};

		//console.log(OAuth.isAuthenticated());

		// redireciona se estiver authenticated
		//if(OAuth.isAuthenticated())
		//	$location.path('home');

		$scope.login = function(){

			//console.log($scope.user);

			if($scope.form.$valid){
				OAuth.getAccessToken($scope.user).then(function(){

					User.authenticated({},{},function(data){
						//$cookies.put('nome','valor');

						$cookies.putObject('user', data);

						$location.path('home');
					});
					
				}, function(data){
					$scope.error.error = true;
					$scope.error.message = data.data.error_description;
					
				});
			}

		};

	}]);