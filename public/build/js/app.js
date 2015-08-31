//var app = angular.module('app',['ngRoute', 'angular-oauth2', 'app.controllers']);
var app = angular.module('app',['ngRoute', 'angular-oauth2', 'app.controllers', 'ngCookies']);

angular.module('app.controllers',['ngMessages', 'angular-oauth2']);

//app.config(['$routeProvider', 'OAuthProvider',function($routeProvider, OAuthProvider){
app.config(['$routeProvider', 'OAuthProvider', 'OAuthTokenProvider',function($routeProvider, OAuthProvider, OAuthTokenProvider){
	$routeProvider
		.when('/login',{
			templateUrl: 'build/views/login.html',
			controller: 'LoginController'
		})
		.when('/home',{
			templateUrl: 'build/views/home.html',
			controller: 'HomeController'
		});

	OAuthProvider.configure({
		baseUrl: 'http://localhost:8000',
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