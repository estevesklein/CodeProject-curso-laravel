angular.module('app.controllers')
	.controller('ProjectNoteEditController',
	['$scope', '$location', '$routeParams', 'ProjectNote',
		function($scope, $location, $routeParams, ProjectNote){

			$scope.projectNote = ProjectNote.get({
				id: $routeParams.id,
				idNote: $routeParams.idNote
			});

			//console.log($scope.projectNote);
			//console.log($scope.projectNote);
			//console.log($routeParams.idNote);
			//console.log($routeParams.id);
			//console.log($scope.projectNote.id);
			
			$scope.save = function(){

				if($scope.form.$valid){
					ProjectNote.update({
						id: null, idNote: $scope.projectNote.id
					}, $scope.projectNote, function(){
						$location.path('/project/' + $routeParams.id + '/notes');
					});
				}
			}
}]);