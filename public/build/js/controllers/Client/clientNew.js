angular.module('app.controllers')
	.controller('ClientNewController',
	['$scope', '$location', 'Client',
	function($scope, $location, Client){
		$scope.client = new Client();

		//console.log($scope.client);
		
		$scope.save = function(){

			if($scope.form.$valid){
				$scope.client.$save().then(function(){
					$location.path('/clients');
				});
			}
		}
}]);