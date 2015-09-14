angular.module('app.services')
.service('Project', ['$resource', '$filter', '$httpParamSerializer', 'appConfig',
	function($resource, $filter, $httpParamSerializer, appConfig){
	//console.log(appConfig.baseUrl);
	//return [];
	return $resource(appConfig.baseUrl + '/project/:id', {
			id: '@id'
		}, {
			save: {
				method: 'POST',
				transformRequest: function(data){
					if(angular.isObject(data) && data.hasOwnProperty('due_date')){

						//console.log(data.due_date);

						data.due_date = $filter('date')(data.due_date,'yyyy-MM-dd');
						//data.due_date = new Date(data.due_date);

						//console.log(data.due_date);
						//"name=nome do projeto&progress=0&qualquerCoisa=xxx"
						//console.log($httpParamSerializer(data));

						return $httpParamSerializer(data);

					}
					return data;
				}
			},
			update: {
				method: 'PUT'
			}
		});
}]);