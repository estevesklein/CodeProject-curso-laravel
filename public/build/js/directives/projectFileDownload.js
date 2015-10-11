angular.module('app.directives')
	.directive('projectFileDownload',
	['$timeout', 'appConfig', 'ProjectFile', function($timeout, appConfig, ProjectFile){
	return {
		restrict: 'E', // 'EA' Elemento e Atributo
		templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
		link: function(scope, element, attr){
			var anchor = element.children()[0];
			// 10/10/2015 - definindo o evento
			scope.$on('salvar-arquivo', function(event, data){
				$(anchor).removeClass('disabled');
				$(anchor).text('Save File');

				//console.log(data);
				
				$(anchor).attr({
					href: 'data:application-octet-stream;base64,' + data.file,
					download: data.name
				});

				$timeout(function(){
					scope.downloadFile = function(){
						//$(anchor).text(saveTextBtn);
					};
					$(anchor)[0].click();
					
				});
			});
		},
		controller: ['$scope', '$element', '$attrs',
			function($scope, $element, $attrs){
				$scope.downloadFile = function(){
					var anchor = $element.children()[0],
						saveTextBtn = $(anchor).text();

					$(anchor).addClass('disabled');
					$(anchor).text('Loading...');
					//console.log($attrs.idFile);
					ProjectFile.download({id: null, idFile: $attrs.idFile}, function(data){
						$scope.$emit('salvar-arquivo', data);
					});
				}
		}]
	};
}]);