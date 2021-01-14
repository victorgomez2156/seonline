app.controller('Validador', ['$http', '$scope','$cookies','$route','$filter','$cookieStore','netTesting','$interval', Controlador]);
function Controlador($http , $scope ,$cookies, $route,$filter,$cookieStore,netTesting,$interval)
{
	var scope = this;	
	scope.ApiKey = $cookies.get('ApiKey'); 
	scope.nivel_users = $cookies.get('nivel');
	scope.id = $cookies.get('id');	
	scope.total_notificaciones=0;
	scope.filtro=0;
	//console.log(scope.nivel_users);

	scope.count_notificaciones=function()
	{

		var url = base_urlHome()+"api/Notificaciones/get_notificaciones_count/";
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				//console.log(result.data);
				//console.log('hay notificaciones pendientes ');
				//scope.total_notificaciones=result.data.totales_notificaciones;
				//scope.filtro=0;
				scope.total_notificaciones=result.data.total_notificaciones;
					//console.log(scope.total_notificaciones);
			}
			else
			{
				//scope.filtro=0;
				scope.total_notificaciones=0;
				console.log('No hay Datos pendientes');
			}

		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				//$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
				bootbox.alert({
				message: "El método que esté intentando usar no puede ser localizado",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				//$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
				bootbox.alert({
				message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				//$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				//$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
				bootbox.alert({
				message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde",
				size: 'middle'});
			}
		});
		//console.log('Si');
	}

	if(scope.nivel_users==1 ||scope.nivel_users==2)
	{
		var promise = $interval(function() 
		{ 				
			scope.count_notificaciones();
					//scope.verificar_sesion_open();
		},10000);	
		$scope.$on('$destroy', function () 
		{ 
			$interval.cancel(promise); 
		});	

	}		
}


