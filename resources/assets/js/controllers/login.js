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

					// tradução da mensagem de erro "invalid_credentials"
					if('invalid_credentials' === data.data.error){
						data.data.error_description = 'Por favor, verifique seu login e senha.';
					}

					$scope.error.message = data.data.error_description;
					
				});
			}

		};

	}]);