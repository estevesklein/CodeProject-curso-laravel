var app = angular.module('app',[
	'ngRoute', 'angular-oauth2', 'app.controllers', 'app.services', 'app.filters'
]);
//var app = angular.module('app',['ngRoute', 'angular-oauth2', 'app.controllers', 'ngCookies']);

angular.module('app.controllers',['ngMessages', 'angular-oauth2']);

angular.module('app.services',['ngResource']);

// módulo de filters
angular.module('app.filters',[]);


// 31/08/2015 - Criando um Provider
app.provider('appConfig', function(){
	var config = {
		baseUrl: 'http://localhost:8000',
		project:{
			status: [
				{value: 1, label: 'Não iniciado'},
				{value: 2, label: 'Iniciado'},
				{value: 3, label: 'Concluído'}
			]
		}
	};

	return {
		config: config,
		$get: function(){
			return config;
		}
	}
});

//app.config(['$routeProvider', 'OAuthProvider',function($routeProvider, OAuthProvider){
//app.config(['$routeProvider', 'OAuthProvider', 'OAuthTokenProvider',function($routeProvider, OAuthProvider, OAuthTokenProvider){
app.config([
	'$routeProvider', '$httpProvider', 'OAuthProvider',
	'OAuthTokenProvider', 'appConfigProvider',
	function(
		$routeProvider, $httpProvider, OAuthProvider,
		OAuthTokenProvider, appConfigProvider){

		// 11/09/2015 - poderá enviar o header desta forma, com POST e PUT
		$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
		$httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

	// 10/09/2015 - transforResponse Global
	$httpProvider.defaults.transformResponse = function(data,headers){
		var headersGetter = headers();
		//console.log(data);
		//console.log(headers);

		if(headersGetter['content-type'] == 'application/json' || 
			headersGetter['content-type'] == 'text/json'){

			var dataJson = JSON.parse(data);
			if(dataJson.hasOwnProperty('data')){
				dataJson = dataJson.data;
			}
			return dataJson;
		}
		
		return data;
	}

	$routeProvider
		.when('/login',{
			templateUrl: 'build/views/login.html',
			controller: 'LoginController'
		})
		.when('/home',{
			templateUrl: 'build/views/home.html',
			controller: 'HomeController'
		})

		// Clients
		.when('/clients',{
			templateUrl: 'build/views/client/list.html',
			controller: 'ClientListController'
		})
		.when('/clients/new',{
			templateUrl: 'build/views/client/new.html',
			controller: 'ClientNewController'
		})
		.when('/clients/:id/edit',{
			templateUrl: 'build/views/client/edit.html',
			controller: 'ClientEditController'
		})
		.when('/clients/:id/remove',{
			templateUrl: 'build/views/client/remove.html',
			controller: 'ClientRemoveController'
		})

		// Projects
		.when('/projects',{
			templateUrl: 'build/views/project/list.html',
			controller: 'ProjectListController'
		})
		.when('/projects/new',{
			templateUrl: 'build/views/project/new.html',
			controller: 'ProjectNewController'
		})
		.when('/projects/:id',{
			templateUrl: 'build/views/project/show.html',
			controller: 'ProjectShowController'
		})
		.when('/projects/:id/edit',{
			templateUrl: 'build/views/project/edit.html',
			controller: 'ProjectEditController'
		})
		.when('/projects/:id/remove',{
			templateUrl: 'build/views/project/remove.html',
			controller: 'ProjectRemoveController'
		})

		// Project notes
		.when('/project/:id/notes',{
			templateUrl: 'build/views/project-note/list.html',
			controller: 'ProjectNoteListController'
		})
		.when('/project/:id/notes/:idNote/show',{
			templateUrl: 'build/views/project-note/show.html',
			controller: 'ProjectNoteShowController'
		})
		.when('/project/:id/notes/new',{
			templateUrl: 'build/views/project-note/new.html',
			controller: 'ProjectNoteNewController'
		})
		.when('/project/:id/notes/:idNote/edit',{
			templateUrl: 'build/views/project-note/edit.html',
			controller: 'ProjectNoteEditController'
		})
		.when('/project/:id/notes/:idNote/remove',{
			templateUrl: 'build/views/project-note/remove.html',
			controller: 'ProjectNoteRemoveController'
		})
		;

	OAuthProvider.configure({
		//baseUrl: 'http://localhost:8000',
		baseUrl: appConfigProvider.config.baseUrl,
		clientId: 'appid1',
		clientSecret: 'secret', // optional
		grantPath: 'oauth/access_token' // URL para pegar o Token
	});

	OAuthTokenProvider.configure({
      name: 'token',
      options: {
        secure: false
      }
    });
}]);

// 27.08.2015 - Metodo para executar as funções após o angular ser carregado
app.run(['$rootScope', '$window', 'OAuth', function($rootScope, $window, OAuth) {
	// adicionando um evento
    $rootScope.$on('oauth:error', function(event, rejection) {
      // Ignore `invalid_grant` error - should be catched on `LoginController`.
      if ('invalid_grant' === rejection.data.error) {
        return;
      }

      // Refresh token when a `invalid_token` error occurs.
      if ('invalid_token' === rejection.data.error) {
        return OAuth.getRefreshToken();
      }

      // Redirect to `/login` with the `error_reason`.
      return $window.location.href = '/login?error_reason=' + rejection.data.error;
    });
  }]);