angular.module('app.services')
.service('Url', ['$interpolate', function($interpolate){
	//console.log(appConfig.baseUrl);
	return {
		getUrlFromUrlSymbol: function(url,params){
			//'/project/{{id}}/file/{{idFile}}'
			//id = 1, idFile = 2
			var urlMod = $interpolate(url)(params);

			// contornar resultado: /project//file/
			// substitui '//'' por '/'
			return urlMod.replace(/\/\//g,'/')
				.replace(/\/$/,'');
		},
		getUrlResource: function(url){
			//'/project/{{id}}/file/{{idFile}}'
			///project/:id/file/:idFile'

			return url.replace(new RegExp('{{','g'),':')
				.replace(new RegExp('}}','g'),'');
		}
	};
}]);