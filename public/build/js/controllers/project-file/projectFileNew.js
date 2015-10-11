angular.module('app.controllers')
	.controller('ProjectFileNewController',
	['$scope', '$location', '$routeParams', 'appConfig', 'Url', 'Upload',
	function($scope, $location, $routeParams, appConfig, Url, Upload){

		//$scope.projectFile = new ProjectFile();
		//$scope.projectFile = {
		//	project_id: $routeParams.id
		//};

		// testar getUrlResource e getUrlFromUrlSymbol
		//console.log(Url.getUrlResource('/project/{{id}}/file/{{idFile}}'));
		//console.log(Url.getUrlFromUrlSymbol('/project/{{id}}/file/{{idFile}}', {id: 1, idFile: 10}));
		//console.log(Url.getUrlFromUrlSymbol('/project/{{id}}/file/{{idFile}}', {id: '', idFile: 10}));
		//console.log(Url.getUrlFromUrlSymbol('/project/{{id}}/file/{{idFile}}', {id: 1, idFile: ''}));

		//console.log($scope.projectFile);
		
		$scope.save = function(){

			if($scope.form.$valid){
				var url = appConfig.baseUrl +
					Url.getUrlFromUrlSymbol(appConfig.urls.projectFile,{
						id: $routeParams.id,
						idFile: ''
					});

				Upload.upload({
		            //url: 'upload/url',
		            url: url,
		            fields: {
		            	name: $scope.projectFile.name,
		            	description: $scope.projectFile.description,
		            	project_id: $routeParams.id
		            },
		            file: $scope.projectFile.file
		            
		        }).success(function (data, status, headers, config) {
		            //console.log('file ' + config.file.name + 'uploaded. Response: ' + data);
		            $location.path('/project/' + $routeParams.id + '/files');
		        });
				/*$scope.projectFile.$save({id: $routeParams.id}).then(function(){
					$location.path('/project/' + $routeParams.id + '/files');
				});*/
			}
		}
}]);