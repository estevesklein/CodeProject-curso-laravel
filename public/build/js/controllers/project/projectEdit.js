angular.module('app.controllers')
	.controller('ProjectEditController',
	['$scope', '$routeParams', '$location', '$cookies', 'Project', 'Client', 'appConfig',
	function($scope, $routeParams, $location, $cookies, Project, Client, appConfig){

		Project.get({id: $routeParams.id}, function(data){
			$scope.project = data;

			$scope.clientSelected = data.client.data;

			//Client.get({id: data.client_id}, function(data){
			//	$scope.clientSelected = data;
			//});
		});
		//$scope.clients = Client.query();
		$scope.status = appConfig.project.status;

		//console.log($scope.project);
		
		$scope.save = function(){

			if($scope.form.$valid){
				$scope.project.owner_id = $cookies.getObject('user').id;
				Project.update({id: $scope.project.id}, $scope.project, function(){
					$location.path('/projects');
				});
			}
		};

		$scope.formatName = function(model){
			if(model){
				return model.name;
			}
			return '';
		};

		$scope.getClients = function(name){
			return Client.query({
				search: name,
				searcheFields: 'name:like'
			}).$promise; // garante q estamos retornando os dados
		};

		$scope.selectClient = function(item){
			$scope.project.client_id = item.id;
		};
}]);