var app = angular.module('app',[
	'ngRoute', 'angular-oauth2', 'app.controllers', 'app.services', 'app.filters', 'app.directives',
	'ui.bootstrap.typeahead', 'ui.bootstrap.datepicker', 'ui.bootstrap.tpls', 'ui.bootstrap.modal',
	'ngFileUpload', 'http-auth-interceptor', 'angularUtils.directives.dirPagination',
	'mgcrea.ngStrap.navbar', 'ui.bootstrap.dropdown'
]);
//var app = angular.module('app',['ngRoute', 'angular-oauth2', 'app.controllers', 'ngCookies']);

angular.module('app.controllers',['ngMessages', 'angular-oauth2']);

angular.module('app.services',['ngResource']);

// módulo de filters
angular.module('app.filters',[]);

// 09/10/2015 - módulo de directives
angular.module('app.directives',[]);


// 31/08/2015 - Criando um Provider
app.provider('appConfig', ['$httpParamSerializerProvider', function($httpParamSerializerProvider){
	var config = {
		baseUrl: 'http://localhost:8000',
		project:{
			status: [
				{value: 1, label: 'Não iniciado'},
				{value: 2, label: 'Iniciado'},
				{value: 3, label: 'Concluído'}
			]
		},
		projectTask:{
			status: [
				{value: 1, label: 'Incompleta'},
				{value: 2, label: 'Completa'}
			]
		},
		urls: {
			projectFile: '/project/{{id}}/file/{{idFile}}'
		},
		utils:{
			transformRequest: function(data){
				if(angular.isObject(data)){
					return $httpParamSerializerProvider.$get()(data);
				}
				return data;
			},
			transformResponse: function(data, headers){
				var headersGetter = headers();
				//console.log(data);
				//console.log(headers);

				if(headersGetter['content-type'] == 'application/json' || 
					headersGetter['content-type'] == 'text/json'){

					var dataJson = JSON.parse(data);
					// se tiver a propriedade 'data' e somente uma propriedade dentro do objeto
					if(dataJson.hasOwnProperty('data') && Object.keys(dataJson).length==1){
						dataJson = dataJson.data;
					}
					return dataJson;
				}
				
				return data;
			}
		}
	};

	return {
		config: config,
		$get: function(){
			return config;
		}
	}
}]);

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


	// 14/09/2015
	$httpProvider.defaults.transformRequest = appConfigProvider.config.utils.transformRequest;

	// 10/09/2015 - transformResponse Global
	$httpProvider.defaults.transformResponse = appConfigProvider.config.utils.transformResponse;

	// 07.01.2016 - interceptor
	$httpProvider.interceptors.splice(0,1); // remover na posição 0, somente 1
	$httpProvider.interceptors.splice(0,1); // remover na posição 0, somente 1
	$httpProvider.interceptors.push('oauthFixInterceptor');

	$routeProvider
		.when('/login',{
			templateUrl: 'build/views/login.html',
			controller: 'LoginController'
		})
		.when('/logout',{
			resolve: {
				logout: ['$location', 'OAuthToken', function($location,OAuthToken){
					OAuthToken.removeToken();
					return $location.path('/login');
				}]
			}
		})
		.when('/home',{
			templateUrl: 'build/views/home.html',
			controller: 'HomeController'
		})

		// Clients
		.when('/clients',{
			templateUrl: 'build/views/client/list.html',
			controller: 'ClientListController',
			title: 'Clientes'
		})
		.when('/clients/new',{
			templateUrl: 'build/views/client/new.html',
			controller: 'ClientNewController',
			title: 'Clientes'
		})
		.when('/clients/:id/edit',{
			templateUrl: 'build/views/client/edit.html',
			controller: 'ClientEditController',
			title: 'Clientes'
		})
		.when('/clients/:id/remove',{
			templateUrl: 'build/views/client/remove.html',
			controller: 'ClientRemoveController',
			title: 'Clientes'
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


		// Project File
		.when('/project/:id/files',{
			templateUrl: 'build/views/project-file/list.html',
			controller: 'ProjectFileListController'
		})
		.when('/project/:id/files/new',{
			templateUrl: 'build/views/project-file/new.html',
			controller: 'ProjectFileNewController'
		})
		.when('/project/:id/files/:idFile/edit',{
			templateUrl: 'build/views/project-file/edit.html',
			controller: 'ProjectFileEditController'
		})
		.when('/project/:id/files/:idFile/remove',{
			templateUrl: 'build/views/project-file/remove.html',
			controller: 'ProjectFileRemoveController'
		})

		// Project tasks
		.when('/project/:id/tasks',{
			templateUrl: 'build/views/project-task/list.html',
			controller: 'ProjectTaskListController'
		})
		.when('/project/:id/task/:idTask/show',{
			templateUrl: 'build/views/project-task/show.html',
			controller: 'ProjectTaskShowController'
		})
		.when('/project/:id/task/new',{
			templateUrl: 'build/views/project-task/new.html',
			controller: 'ProjectTaskNewController'
		})
		.when('/project/:id/task/:idTask/edit',{
			templateUrl: 'build/views/project-task/edit.html',
			controller: 'ProjectTaskEditController'
		})
		.when('/project/:id/task/:idTask/remove',{
			templateUrl: 'build/views/project-task/remove.html',
			controller: 'ProjectTaskRemoveController'
		})

		// Project members
		.when('/project/:id/members',{
			templateUrl: 'build/views/project-member/list.html',
			controller: 'ProjectMemberListController'
		})
		.when('/project/:id/member/:idProjectMember/remove',{
			templateUrl: 'build/views/project-member/remove.html',
			controller: 'ProjectMemberRemoveController'
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
app.run(['$rootScope', '$location', '$http', '$modal', 'httpBuffer', 'authService', 'OAuth',
	function($rootScope, $location, $http, $modal, httpBuffer, authService, OAuth) {


	// 06.01.2015 - autorização
	$rootScope.$on('$routeChangeStart', function(event,next,current){
		if(next.$$route.originalPath != '/login'){
			if(!OAuth.isAuthenticated()){
				$location.path('login');
			}
		}
	});

	// acontece depois que Angular encontrou a rota, conseguiu a view e vai mostrar o template
	$rootScope.$on('$routeChangeSuccess', function(event, current, previous){
		//console.log(current.$$route.title);
		$rootScope.pageTitle = current.$$route.title;
	});



	// adicionando um evento
	// verificando o tipo de erro
    $rootScope.$on('oauth:error', function(event, data) {

    	//console.log(data.rejection.data.error);

    	// Ignore `invalid_grant` error - should be catched on `LoginController`.
    	if ('invalid_grant' === data.rejection.data.error) {
    		return;
    	}

    	//if ('invalid_token' === data.rejection.data.error) {
    	//	console.log('REFRESH TOKEN');
    	//	console.log(data.rejection.data.error);
		//
    	//	setTimeout(function(){
    	//		return OAuth.getRefreshToken();
    	//	}, 3000);
    	//}

    	// Refresh token when a `invalid_token` error occurs.
    	if ('access_denied' === data.rejection.data.error) {

    		// armazena em buffer as requisições com access_denied
    		httpBuffer.append(data.rejection.config, data.deferred);

    		//if(!$rootScope.loginModalOpened){
    		//	var modalInstance = $modal.open({
    		//		templateUrl: 'build/views/templates/loginModal.html',
    		//		controller: 'LoginModalController'
    		//	});
    		//	$rootScope.loginModalOpened = true;
    		//}
    		
    		
    		OAuth.getRefreshToken().then(function(){
    			console.log('* Refresh Token: ' + Date());
    			authService.loginConfirmed();
    		});

    		return;
    	}

    	// Redirect to `/login` with the `error_reason`.
    	//return $window.location.href = '/login?error_reason=' + rejection.data.error;
    	return $location.path('login');
    });
}]);