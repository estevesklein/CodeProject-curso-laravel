angular.module('app.services')
.service('Project', ['$resource', '$filter', '$httpParamSerializer', 'appConfig',
	function($resource, $filter, $httpParamSerializer, appConfig){


		// 14/09/2015
		function transformData(data){
			if(angular.isObject(data) && data.hasOwnProperty('due_date')){

				// espelhar objeto
				var o = angular.copy(data);
				//console.log(data.due_date);

				o.due_date = $filter('date')(data.due_date,'yyyy-MM-dd');

				//console.log(data.due_date);
				//"name=nome do projeto&progress=0&qualquerCoisa=xxx"
				//console.log($httpParamSerializer(data));

				//return $httpParamSerializer(o);
				return appConfig.utils.transformRequest(o);

			}
			return data;
		};



		//console.log(appConfig.baseUrl);
		//return [];
		return $resource(appConfig.baseUrl + '/project/:id', {
				id: '@id'
			}, {
				save: {
					method: 'POST',
					transformRequest: transformData
				},
				get: {
					method: 'GET',
					transformResponse: function(data, headers){
						var o = appConfig.utils.transformResponse(data, headers);
						if(angular.isObject(o) && o.hasOwnProperty('due_date')){
							
							var arrayDate = o.due_date.split('-'),
								month = parseInt(arrayDate[1])-1;

							o.due_date = new Date(arrayDate[0],month,arrayDate[2]);
						}
						return o;
					}
				},

				query:{
					isArray: false
				},

				update: {
					method: 'PUT',
					transformRequest: transformData
				}
			});
	}]);