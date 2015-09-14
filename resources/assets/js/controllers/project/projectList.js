angular.module('app.controllers')
	.controller('ProjectListController', [
		'$scope', '$routeParams', 'Project', function($scope, $routeParams, Project){
			$scope.projects = Project.query();

			//console.log($scope.projectNotes);
		}]);