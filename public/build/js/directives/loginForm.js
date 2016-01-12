angular.module('app.directives')
	.directive('loginForm',
	['appConfig', function(appConfig){
	return {
		restrict: 'E', // 'EA' Elemento e Atributo
		templateUrl: appConfig.baseUrl + '/build/views/templates/form-login.html',
		scope: false // permite compartilhar o escopo da directiva com o controller que usará
	};
}]);