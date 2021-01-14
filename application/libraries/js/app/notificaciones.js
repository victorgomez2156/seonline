
app.controller('ControllerNotificaciones', ['$http', '$scope','$cookies','$route','$filter','$cookieStore','netTesting','$interval', Controlador]);
function Controlador($http , $scope ,$cookies, $route,$filter,$cookieStore,netTesting,$interval)
{
	var scope = this;	
	scope.ApiKey = $cookies.get('ApiKey'); 
	scope.nivel_users = $cookies.get('nivel');
	scope.id = $cookies.get('id');	
	scope.filtro=0;
	scope.TNotificacionesPendientes=null;
	//console.log(scope.nivel_users);

	scope.notificaciones_pendientes=function()
	{

		var url = base_urlHome()+"api/Notificaciones/get_notificaciones/";
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				scope.TNotificacionesPendientes=[];

				angular.forEach(result.data, function(notificaciones)
				{
					var fecha= (notificaciones.fecha).split("-");
					var h1=new Date();			
					var convertida = fecha[2]+"/"+fecha[1]+"/"+fecha[0];
					var horario_entrada= (notificaciones.horario_entrada).split(" ");
					var h1=new Date();
					var horario_salida= (notificaciones.horario_salida).split(" ");
					var h1=new Date();				
					$scope.predicate = 'id';  
					$scope.reverse = true;						
					$scope.currentPage = 1;  
					$scope.order = function (predicate) 
					{  
						$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
						$scope.predicate = predicate;  
					};
					$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" ); 
					scope.TNotificacionesPendientes.push({id:notificaciones.id,nombres:notificaciones.nombres,apellidos:notificaciones.apellidos,fecha:convertida,type:notificaciones.type,horario_entrada:horario_entrada[1],horario_salida:horario_salida[1],hora_entrada_sin_convertir:notificaciones.horario_entrada,hora_salida_sin_convertir:notificaciones.horario_salida,estatus:notificaciones.estatus,total_jornada:notificaciones.total_jornada });					
					$scope.totalItems = scope.TNotificacionesPendientes.length; 
					$scope.numPerPage = 50;  
					$scope.paginate = function (value) 
					{  
						var begin, end, index;  
						begin = ($scope.currentPage - 1) * $scope.numPerPage;  
						end = begin + $scope.numPerPage;  
						index = scope.TNotificacionesPendientes.indexOf(value);  
						return (begin <= index && index < end);  
					}; 




					});	
				
			}
			else
			{
				scope.TNotificacionesPendientes=null;				
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
	scope.validar_asistencia=function(index,data)
	{
		//console.log(index);
		//console.log(data);
		scope.validar_tipo=0;
		scope.nombres=data.nombres;
		scope.apellidos	=data.apellidos;
		scope.tdatamodal={};
		scope.tdatamodal.horario_entrada=data.horario_entrada;
		scope.tdatamodal.horario_salida=data.horario_salida;
		scope.tdatamodal.fecha=data.fecha;		
		scope.tdatamodal.id=data.id;
		scope.tdatamodal.index=index;
		scope.tdatamodal.type=data.type;
		scope.tdatamodal.estatus=data.estatus;
		scope.horario_entrada=data.horario_entrada;
		scope.horario_salida=data.horario_salida;
		
		var x = document.getElementsByClassName("label-floating");
		var i;
		$('#is-empty').val('disabled');
		for (i = 0; i < x.length; i++) 
		{
		    $(x[i]).removeClass('is-empty');
		}
		if(scope.tdatamodal.type==3)
		{
			scope.validar_tipo=3;
			var fecha_hora_entrada= (data.hora_salida_sin_convertir).split(" ");
			var h1=new Date();
			var hora_entrada= (fecha_hora_entrada[1]).split(":");
			var h2 = new Date();								
			var fecha_hora_salida= (data.hora_entrada_sin_convertir).split(" ");
			var h3=new Date();
			var hora_salida= (fecha_hora_salida[1]).split(":");
			var h4 = new Date();
			var date_1 = new Date(fecha_hora_entrada[0]);
			var date_2 = new Date(fecha_hora_salida[0]);
			var day_as_milliseconds = 86400000;
			var diff_in_millisenconds = date_2 - date_1;
			var diff_in_days = diff_in_millisenconds / day_as_milliseconds;								
			if(diff_in_days==1)
			{
				diff_in_days = diff_in_days + " Dia ";
			}
			else
			{
				diff_in_days = diff_in_days + " Dias ";
			}
			var hora1 = (fecha_hora_entrada[1]).split(":"),
				hora2 = (fecha_hora_salida[1]).split(":"),
				t1 = new Date(),
				t2 = new Date();
				t1.setHours(hora2[0], hora2[1], hora2[2]);
				t2.setHours(hora1[0], hora1[1], hora1[2]);
				t1.setHours(t1.getHours() - t2.getHours(), t1.getMinutes() - t2.getMinutes(), t1.getSeconds() - t2.getSeconds());
				scope.total_horas = (t1.getHours() ? t1.getHours() + (t1.getHours() > 1 ? " horas" : " hora") : "") + (t1.getMinutes() ? " " + t1.getMinutes() + (t1.getMinutes() > 1 ? " minutos" : " minuto") : "") + (t1.getSeconds() ? (t1.getHours() || t1.getMinutes() ? " y " : "") + t1.getSeconds() + (t1.getSeconds() > 1 ? " segundos" : " segundo") : "");
				if(diff_in_days>="1 Dia")
				{
					scope.jornada_final=diff_in_days+scope.total_horas;
				}
				else
				{
					scope.jornada_final=scope.total_horas;
				}
				scope.tdatamodal.fecha_entrada_break_sin_transformar=fecha_hora_entrada[0];

		}
		if(scope.tdatamodal.type==4)
		{
			scope.validar_tipo=4;
			var fecha_hora_entrada= (data.hora_entrada_sin_convertir).split(" ");
			var h1=new Date();
			var hora_entrada= (fecha_hora_entrada[1]).split(":");
			var h2 = new Date();								
			var fecha_hora_salida= (data.hora_salida_sin_convertir).split(" ");
			var h3=new Date();
			var hora_salida= (fecha_hora_salida[1]).split(":");
			var h4 = new Date();
			var date_1 = new Date(fecha_hora_entrada[0]);
			var date_2 = new Date(fecha_hora_salida[0]);
			var day_as_milliseconds = 86400000;
			var diff_in_millisenconds = date_2 - date_1;
			var diff_in_days = diff_in_millisenconds / day_as_milliseconds;								
			if(diff_in_days==1)
			{
				diff_in_days = diff_in_days + " Dia ";
			}
			else
			{
				diff_in_days = diff_in_days + " Dias ";
			}
			var hora1 = (fecha_hora_entrada[1]).split(":"),
				hora2 = (fecha_hora_salida[1]).split(":"),
				t1 = new Date(),
				t2 = new Date();
				t1.setHours(hora2[0], hora2[1], hora2[2]);
				t2.setHours(hora1[0], hora1[1], hora1[2]);
				t1.setHours(t1.getHours() - t2.getHours(), t1.getMinutes() - t2.getMinutes(), t1.getSeconds() - t2.getSeconds());
				scope.total_horas = (t1.getHours() ? t1.getHours() + (t1.getHours() > 1 ? " horas" : " hora") : "") + (t1.getMinutes() ? " " + t1.getMinutes() + (t1.getMinutes() > 1 ? " minutos" : " minuto") : "") + (t1.getSeconds() ? (t1.getHours() || t1.getMinutes() ? " y " : "") + t1.getSeconds() + (t1.getSeconds() > 1 ? " segundos" : " segundo") : "");
				if(diff_in_days>="1 Dia")
				{
					scope.jornada_final=diff_in_days+scope.total_horas;
				}
				else
				{
					scope.jornada_final=scope.total_horas;
				}
				scope.tdatamodal.fecha_salida_asistencia_sin_transformar=fecha_hora_salida[0]; 
		}
		if(scope.tdatamodal.type==6)
		{
			scope.validar_tipo=6;
			var fecha_hora_entrada= (data.hora_salida_sin_convertir).split(" ");
			var h1=new Date();
			var hora_entrada= (fecha_hora_entrada[1]).split(":");
			var h2 = new Date();								
			var fecha_hora_salida= (data.hora_entrada_sin_convertir).split(" ");
			var h3=new Date();
			var hora_salida= (fecha_hora_salida[1]).split(":");
			var h4 = new Date();
			var date_1 = new Date(fecha_hora_entrada[0]);
			var date_2 = new Date(fecha_hora_salida[0]);
			var day_as_milliseconds = 86400000;
			var diff_in_millisenconds = date_2 - date_1;
			var diff_in_days = diff_in_millisenconds / day_as_milliseconds;								
			if(diff_in_days==1)
			{
				diff_in_days = diff_in_days + " Dia ";
			}
			else
			{
				diff_in_days = diff_in_days + " Dias ";
			}
			var hora1 = (fecha_hora_entrada[1]).split(":"),
				hora2 = (fecha_hora_salida[1]).split(":"),
				t1 = new Date(),
				t2 = new Date();
				t1.setHours(hora2[0], hora2[1], hora2[2]);
				t2.setHours(hora1[0], hora1[1], hora1[2]);
				t1.setHours(t1.getHours() - t2.getHours(), t1.getMinutes() - t2.getMinutes(), t1.getSeconds() - t2.getSeconds());
				scope.total_horas = (t1.getHours() ? t1.getHours() + (t1.getHours() > 1 ? " horas" : " hora") : "") + (t1.getMinutes() ? " " + t1.getMinutes() + (t1.getMinutes() > 1 ? " minutos" : " minuto") : "") + (t1.getSeconds() ? (t1.getHours() || t1.getMinutes() ? " y " : "") + t1.getSeconds() + (t1.getSeconds() > 1 ? " segundos" : " segundo") : "");
				if(diff_in_days>="1 Dia")
				{
					scope.jornada_final=diff_in_days+scope.total_horas;
				}
				else
				{
					scope.jornada_final=scope.total_horas;
				}
				scope.tdatamodal.fecha_entrada_reunion_sin_transformar=fecha_hora_salida[0]; 
		}
		$("#modal_admin_aprueba").modal('show');
	}
	$scope.SubmitForm = function(event) 
	{      
	 	bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro que desea confirmar esta operación?",
	    buttons: {
	    cancel: {
	    label: '<i class="fa fa-times"></i> Cancelar'
	    },
	    confirm: {
		label: '<i class="fa fa-check"></i> Confirmar'
		}
		},
		callback: function (result) 
		{
			if (result==false) 
			{ 
				event.preventDefault();
			}     
			else
			{
				var url = base_urlHome()+"api/Notificaciones/validar_asistencia_anterior";
				$http.post(url,scope.tdatamodal).then(function(result)
				{
					if(result.data!=false)
					{						
						bootbox.alert({
						message: "Datos guardados correctamente.",
						size: 'middle'});
						scope.TNotificacionesPendientes.splice(scope.tdatamodal.index,1);
						$("#modal_admin_aprueba").modal('hide');						
					}
					else
					{						
						bootbox.alert({
						message: "Ha ocurrido un error al intentar guardar los datos.",
						size: 'middle'});
						$("#modal_admin_aprueba").modal('hide');
					}
				},function(error)
				{
					console.log(error);
					if(error.status==404 && error.statusText=="Not Found")
					{
						//$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
						bootbox.alert({
						message: "El método que esté intentando usar no puede ser localizado",
						size: 'middle'});
						$("#modal_admin_aprueba").modal('hide');
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						//$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
						bootbox.alert({
						message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
						size: 'middle'});
						$("#modal_admin_aprueba").modal('hide');
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						//$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
						bootbox.alert({
						message: "Está intentando usar un APIKEY inválido",
						size: 'middle'});
						$("#modal_admin_aprueba").modal('hide');
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						//$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
						bootbox.alert({
						message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde",
						size: 'middle'});
						$("#modal_admin_aprueba").modal('hide');
					}
				});				
			}
		}});					
	}; 		
};