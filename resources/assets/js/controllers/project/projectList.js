angular.module('app.controllers')
	.controller('ProjectListController', [
		'$scope', '$routeParams', 'Project', function($scope, $routeParams, Project){
			//$scope.projects = Project.query();

			//console.log($scope.projectNotes);

			$scope.projects = [];
			$scope.totalProjects = 0;
			$scope.projectsPerPage = 4;
			$scope.orderBy = 'id';
			$scope.sortedBy = 'asc';
			//$scope.with = '';

			$scope.pagination = {
				current: 1
			};

			$scope.pageChanged = function(newPage) {
				getResultsPage(newPage);
			};

			$scope.sort = function(keyname){
				//console.log(keyname);
				reverseSortedBy(keyname);
				$scope.orderBy = keyname;
				//$scope.with = 'client';
				//$scope.with = with;

				getResultsPage(1);
			}

			function reverseSortedBy(keyname){
				if($scope.orderBy===keyname){
					if($scope.sortedBy=='asc')
						$scope.sortedBy = 'desc';
					else
						$scope.sortedBy = 'asc';
				}
			}


			function getResultsPage(pageNumber) {
				Project.query({
					page: pageNumber,
					limit: $scope.projectsPerPage,
					orderBy: $scope.orderBy,
					sortedBy: $scope.sortedBy
					//with: $scope.with
				},function(data){
					$scope.projects = data.data;
					$scope.totalProjects = data.meta.pagination.total;
				});
			}


			getResultsPage(1);
		}]);