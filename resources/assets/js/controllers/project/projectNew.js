angular.module('app.controllers')
	.controller('ProjectNewController',
	['$scope', '$location', '$cookies', 'Project', 'Client', 'appConfig',
	function($scope, $location, $cookies, Project, Client, appConfig){

		$scope.project = new Project();
		//$scope.clients = Client.query();
		$scope.status = appConfig.project.status;

		$scope.due_date = {
			status: {
				opened: false
			}
		};

		$scope.open = function($event){
			$scope.due_date.status.opened = true;
		}

		//console.log($scope.project);
		
		$scope.save = function(){

			if($scope.form.$valid){
				$scope.project.owner_id = $cookies.getObject('user').id;
				$scope.project.$save().then(function(){
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