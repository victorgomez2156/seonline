var app = angular.module('appPrincipal', ['checklist-model','ngResource','ngCookies','ui.bootstrap','angular.ping','ngRoute'])
.config(function ($httpProvider,$routeProvider) {
		$httpProvider.defaults.useXDomain = true;
		$httpProvider.defaults.headers.common["Access-Control-Allow-Origin"] = "*";
		$httpProvider.defaults.headers.common["Access-Control-Allow-Methods"] = "GET, POST, PUT, DELETE, OPTIONS";
		$httpProvider.defaults.headers.common["Access-Control-Max-Age"] = "86400";
		$httpProvider.defaults.headers.common["Access-Control-Allow-Credentials"] = "true";
		$httpProvider.defaults.headers.common["Accept"] = "application/javascript";
		$httpProvider.defaults.headers.common["content-type"] = "application/json"; 		
		delete $httpProvider.defaults.headers.common['X-Requested-With'];
		$routeProvider	
		//Se debe colocar  para cada uno de los controladores que desea para el acceso todos los formularios
		.when('/Inicio/', {
			templateUrl: 'application/views/view_inicio.php'
		})		
		.otherwise({
			redirectTo: ''
		});
		
}).run(function run( $http, $cookies , netTesting)
{	
	if (!document.getElementById('ApiKey'))
	{
		ApiKey = $cookies.get('ApiKey');
		$http.defaults.headers.common["x-api-key"] = ApiKey;
	} 
	else
	{
		var fecha = new Date();
		var dd = fecha.getDate();
		var mm = fecha.getMonth()+1; 
		var yyyy = fecha.getFullYear();

		if(dd<10){
			dd='0'+dd
		} 
		if(mm<10){
			mm='0'+mm
		} 
		var fecha = dd+'/'+mm+'/'+yyyy;	
		$cookies.put("id", document.getElementById('IdUsers').value);
		$cookies.put("nivel", document.getElementById('NivelUsers').value);
		$cookies.put("ApiKey", document.getElementById('ApiKey').value);			
		ApiKey = $cookies.get('ApiKey');
		$http.defaults.headers.common["x-api-key"] = ApiKey;
		muestra_preguntas=$cookies.get('id');
		/*if(muestra_preguntas==1)
	 	{
			$("#modal-success").modal("hide");
		}
		else
		{
			$("#modal-success").modal("show");
		}*/
	}
	
});
