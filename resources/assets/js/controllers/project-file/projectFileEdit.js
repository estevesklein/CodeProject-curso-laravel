angular.module('app.controllers')
	.controller('ProjectFileEditController',
	['$scope', '$location', '$routeParams', 'ProjectFile',
		function($scope, $location, $routeParams, ProjectFile){

			$scope.projectFile = ProjectFile.get({
				id: null,
				idFile: $routeParams.idFile
			});

			//console.log($scope.projectFile);
			//console.log($scope.projectFile);
			//console.log($routeParams.idFile);
			//console.log($routeParams.id);
			//console.log($scope.projectFile.id);
			
			$scope.save = function(){

				if($scope.form.$valid){
					ProjectFile.update({
						id: null, idFile: $scope.projectFile.id
					}, $scope.projectFile, function(){
						$location.path('/project/' + $routeParams.id + '/files');
					});
				}
			}
}]);