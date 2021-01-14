app.controller('Controlador_Horarios', ['$http', '$scope','$cookies','$route','$filter','$cookieStore','netTesting','ServiceUsuarios', Controlador])
.directive('stringToNumber', function() {
  return {
    require: 'ngModel',
    link: function(scope, element, attrs, ngModel) {
      ngModel.$parsers.push(function(value) {
        return '' + value;
      });
      ngModel.$formatters.push(function(value) {
        return parseFloat(value);
      });
    }
  };
})
function Controlador($http , $scope ,$cookies, $route,$filter,$cookieStore,netTesting,ServiceUsuarios){
		
	var scope = this;
	scope.fdatos = {}; // datos del formulario
	scope.fdatos_extras={};
	scope.fdatos.detalle_dia_laborable=null;
	scope.select_dia_laborables=[];
	scope.count_select_dias_laborables=0;
	scope.fdatos.estatus_vacaciones=null;
	scope.fdatos.final_laborable=[];
	scope.ApiKey = $cookies.get('ApiKey'); 
	scope.nivel_users = $cookies.get('nivel');
	scope.id = $cookies.get('id');
	scope.dias_laborables=[{id:1 , nombre:"Lunes"}, {id:2 , nombre:"Martes"}, {id:3 , nombre:"Miercoles"}, {id:4 , nombre:"Jueves"}, {id:5 , nombre:"Viernes"}, {id:6 , nombre:"Sabado"}, {id:7 , nombre:"Domingo"}];	
	scope.estatus_contrato=[{id:1 , estatus:"Activo"}, {id:2 , estatus:"Renuncia"}, {id:3 , estatus:"Finalizado"}, {id:4 , estatus:"Despido"}];
	scope.estatus_vacaciones=[{id:1 , estatus:"Activa"}, {id:2 , estatus:"Pendiente"}, {id:3 , estatus:"Vencidas"}, {id:4 , estatus:"Cumplidas"}, {id:5 , estatus:"Interrumpidas"}];
	scope.index  = 0;	
	scope.resultado=0;
	scope.spinner_usuario=0;
	scope.usuario_comprobar=0;
	ServiceUsuarios.getAll().then(function(dato) 
	{
		scope.usuarios = dato;
		//console.log(scope.empresas);
	}).catch(function(err) 
	{
		console.log(err.message); //Tratar el error
	});

	scope.buscar_usuario=function()
	{	
		scope.spinner_usuario=0;
		scope.resultado=0;
		
		if(scope.fdatos.usuario!=null)
		{
			var url = base_urlHome()+"api/Horarios/buscar_datos_usuarios/";
			huser=scope.fdatos.usuario;
			scope.limpiar();
			scope.spinner_usuario=1;
			scope.fdatos.usuario=huser;
			$http.post(url,scope.fdatos).then(function(result)
			{
				if(result.data!=false)
				{
					scope.spinner_usuario=0;
					scope.resultado=1;
					scope.fdatos=result.data;
					scope.fdatos.usuario=huser;
					var x = document.getElementsByClassName("label-floating");
			        var i;
			        $('#is-empty').val('disabled');
			        for (i = 0; i < x.length; i++) 
			        {
			            $(x[i]).removeClass('is-empty');
			        }
			      	scope.fdatos.final_laborable=result.data.detalle_dia_laborable;
			      	angular.forEach(result.data.detalle_dia_laborable, function(dias_laborables)
					{					
						scope.select_dia_laborables[dias_laborables.id]=dias_laborables;
					});	
					scope.fecha_inicio_contrato=result.data.fecha_inicio_contrato;
					scope.fecha_perioro_prueba=result.data.fecha_perioro_prueba;
					scope.fecha_fin_contrato=result.data.fecha_fin_contrato;
					scope.fecha_vacaciones_desde=result.data.fecha_vacaciones_desde;
					scope.fecha_vacaciones_hasta=result.data.fecha_vacaciones_hasta;

				}
				else
				{
					bootbox.alert({
					message: "Este empleado no tiene contrato asignado por lo que se le debe de asignar para poder cargar los demas datos.",
					size: 'middle'});
					scope.spinner_usuario=0;
					scope.resultado=2;
					scope.fdatos={};
					scope.fdatos.usuario=huser;
					scope.select_dia_laborables=[];
					scope.count_select_dias_laborables=0;
					scope.fecha_inicio_contrato=undefined;
					scope.fecha_perioro_prueba=undefined;
					scope.fecha_fin_contrato=undefined;					
					scope.fdatos.dias_vacaciones=undefined;
					scope.fecha_vacaciones_desde=undefined;
					scope.fecha_vacaciones_hasta=undefined;
				}
				
			},function(error)
			{
				if(error.status==404 && error.statusText=="Not Found")
				{
					bootbox.alert({
					message: "El método que está intentando usar no puede ser localizado",
					size: 'middle'});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					bootbox.alert({
					message: "Usted no tiene acceso a este controlador",
					size: 'middle'});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					bootbox.alert({
					message: "Está intentando usar un APIKEY inválido",
					size: 'middle'});
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					bootbox.alert({
					message: "Actualmente estamos prensentado fallas en el servidor, por favor intente mas tarde",
					size: 'middle'});
				}
			});
		}
		else
		{
			scope.spinner_usuario=0;
			scope.resultado=0;
			scope.fdatos={};
		}
	}
	scope.consultar_dias_laborables=function()
	{
		var url = base_urlHome()+"api/Horarios/all_days_laborables";
		$http.get(url).then(function(result)
		{
			data=result.data;
			if(data!=false)
			{			
				scope.detalle_dia_laborable=data;
			}
			else
			{
				scope.detalle_dia_laborable=null;
			}
		},function(error)
		{
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				bootbox.alert({
				message: "Está intentando acceder a un módulo al cual no tiene acceso",
				size: 'middle'});
				return false;
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				bootbox.alert({
				message: "Error de Seguridad, está intentando ingresar al sistema con un <b>ApiKey</b>. inválido",
				size: 'middle'});
				return false;
			}
		});
	}
	scope.consultar_historico_vacaciones=function()
	{
		var url = base_urlHome()+"api/Horarios/Consultar_Historico_Vacaciones/";
		$http.post(url,scope.fdatos.usuario).then(function(result)
		{
			data=result.data;
			if(data!=false)
			{				
				$scope.predicate201 = 'id';  
				$scope.reverse201 = true;						
				$scope.currentPage201 = 1;  
				$scope.order201 = function (predicate201) 
				{  
					$scope.reverse201 = ($scope.predicate201 === predicate201) ? !$scope.reverse201 : false;  
					$scope.predicate201 = predicate201;  
				}; 						
				scope.tvacaciones=data;					
				$scope.totalItems201 = scope.tvacaciones.length; 
				$scope.numPerPage201 = 50;  
				$scope.paginate201 = function (value) 
				{  
					var begin201, end201, index201;  
					begin201 = ($scope.currentPage201 - 1) * $scope.numPerPage201;  
					end201 = begin201 + $scope.numPerPage201;  
					index201 = scope.tvacaciones.indexOf(value);  
					return (begin201 <= index201 && index201 < end201);  
				};
				$('#modal_historico_vacaciones').modal('show');
			}
			else
			{
				bootbox.alert({
				message: "El usuario no tiene vacaciones asignadas aún.",
				size: 'middle'});
			}

		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				bootbox.alert({
				message: "El método que está intentando usar no puede ser localizado",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				bootbox.alert({
				message: "Usted no tiene acceso a este controlador",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido.",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				bootbox.alert({
				message: "Actualmente estamos prensentado fallas en el servidor, por favor intente mas tarde",
				size: 'middle'});
			}
		});
	}
	scope.contar_dias_vacaciones=function()
	{
		if(scope.fecha_vacaciones_desde!=undefined && scope.fecha_vacaciones_hasta!=undefined)
		{			
			var fecha_desde =(scope.fecha_vacaciones_desde).split("/"),
   			fecha_hasta =(scope.fecha_vacaciones_hasta).split("/"),
   			t3 = new Date(),
    		t4 = new Date();    		
    		var fecha_desde_convertida=new Date(fecha_desde[2]+"/"+fecha_desde[1]+"/"+fecha_desde[0]);
    		var fecha_hasta_convertida=new Date(fecha_hasta[2]+"/"+fecha_hasta[1]+"/"+fecha_hasta[0]);
    		var dias= fecha_hasta_convertida-fecha_desde_convertida;
    		var diff_=dias/(1000*60*60*24);
    		scope.fdatos.fecha_vacaciones_desde=fecha_desde[2]+"/"+fecha_desde[1]+"/"+fecha_desde[0];
 			scope.fdatos.fecha_vacaciones_hasta=fecha_hasta[2]+"/"+fecha_hasta[1]+"/"+fecha_hasta[0];
 			scope.fdatos.dias_vacaciones=diff_;
		}
	}
	scope.agregar_dias=function(index,datos,id,hora_entrada,hora_salida)
	{	
		//console.log(index);
		//console.log(datos);
		//console.log(id);
		//console.log(hora_entrada);
		//console.log(hora_salida);
		if(scope.count_select_dias_laborables>0)
		{			
			scope.count_select_dias_laborables = (Math.max(parseFloat(scope.count_select_dias_laborables),0)+Math.max(parseFloat(1),0));			
		}
		else
		{
			scope.count_select_dias_laborables+=1;
		}

		var objDias = new Object();	
		scope.select_dia_laborables[id]=datos;
		if (scope.fdatos.final_laborable==undefined || scope.fdatos.final_laborable==false)
		{
			scope.fdatos.final_laborable = []; 
		}		
			scope.fdatos.final_laborable.push({id:datos.id,dia_laborable:datos.dia_laborable,orden:datos.orden,hora_entrada:hora_entrada,hora_salida:hora_salida});
			//console.log(scope.fdatos.final_laborable);
	}
	scope.quitardia = function(index,id,datos)
	{
		scope.count_select_dias_laborables-=1;
		scope.select_dia_laborables[id]=false;
		i=0;
		 for (var i = 0; i < scope.fdatos.final_laborable.length; i++) 
	       {
	           	if(scope.fdatos.final_laborable[i].id==id)
	        	{
		       		scope.fdatos.final_laborable.splice(i,1);
		       		scope.fdatos.detalle_dia_laborable.hora_entrada[index]=undefined;
					scope.fdatos.detalle_dia_laborable.hora_salida[index]=undefined;
	           	}   
	           	
				//console.log(scope.fdatos.final_laborable);				

			}
					
	}
	scope.actualizar_historico=function(index,datos)
	{
		console.log(index);
		console.log(datos);
		var url = base_urlHome()+"api/Horarios/actualizar_historico_vacaciones/";
		$http.post(url,datos).then(function(result)
		{
			data=result.data;
			if(data!=false)
			{
				scope.buscar_usuario();
				bootbox.alert({
				message: "Vacaciones actualizadas con éxito",
				size: 'middle'});
			}
			else
			{
				bootbox.alert({
				message: "Un error ha ocurrido mientras se intentaba actualizar las vacaciones",
				size: 'middle'});
			}

		},function(error){
			if(error.status==404 && error.statusText=="Not Found")
			{
				bootbox.alert({
				message: "El método que está intentando usar no puede ser localizado",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				bootbox.alert({
				message: "Usted no tiene acceso a este controlador",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				bootbox.alert({
				message: "Actualmente estamos prensentado fallas en el servidor, por favor intente mas tarde",
				size: 'middle'});
			}
			console.log(error);
		});
	}

	scope.submitFormVaca = function(event) 
	{ 	
	 	bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro de agregar las vacaciones al usuario?",
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
				scope.fdatos_extras.huser=scope.fdatos.usuario;				
				var url = base_urlHome()+"api/Horarios/adicionar_vacaciones/";
				$http.post(url,scope.fdatos_extras).then(function(result)
				{	
					data=result.data;
					if(data!=false)
					{
							$("#modal_agregar_mas_vacaciones").modal('hide');
							scope.fdatos_extras={};
							scope.fecha_desde1=undefined;
							scope.fecha_hasta1=undefined;
							bootbox.alert({
							title:"Confirmación",
						    message: "Las Vacaciones se han agregado correctamente, puede observarlas en el histórico de vacaciones",
						    size: 'middle'});
						    scope.buscar_usuario();
					}
					else
					{
						bootbox.alert({
						title:"Error",
					    message: "Ha ocurrido un error al intentar guardar la vacaciones",
					    size: 'middle'});
					}

				},function(error)
				{
					if(error.status==404 && error.statusText=="Not Found")
					{
						bootbox.alert({
						message: "El método que está intentando usar no puede ser localizado",
						size: 'middle'});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						bootbox.alert({
						message: "Usted no tiene acceso a este controlador",
						size: 'middle'});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						bootbox.alert({
						message: "Está intentando usar un APIKEY inválido",
						size: 'middle'});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						bootbox.alert({
						message: "Actualmente estamos prensentado fallas en el servidor, por favor intente mas tarde",
						size: 'middle'});
					}
				});
			}
		}});
					
	};
	scope.contar_dias_vacaciones1=function()
	{

		if(scope.fecha_vacaciones_desde1!=undefined && scope.fecha_vacaciones_hasta1!=undefined)
		{
			var fecha_desde1 =(scope.fecha_vacaciones_desde1).split("/"),
   			fecha_hasta1 =(scope.fecha_vacaciones_hasta1).split("/"),
   			t3 = new Date(),
    		t4 = new Date();
    		var fecha_desde_convertida1=new Date(fecha_desde1[2]+"/"+fecha_desde1[1]+"/"+fecha_desde1[0]);
    		var fecha_hasta_convertida1=new Date(fecha_hasta1[2]+"/"+fecha_hasta1[1]+"/"+fecha_hasta1[0]);
    		var dias1= fecha_hasta_convertida1-fecha_desde_convertida1;
    		var diff1_=dias1/(1000*60*60*24);
    		scope.fdatos_extras.fecha_vacaciones_desde1=fecha_desde1[2]+"/"+fecha_desde1[1]+"/"+fecha_desde1[0];
 			scope.fdatos_extras.fecha_vacaciones_hasta1=fecha_hasta1[2]+"/"+fecha_hasta1[1]+"/"+fecha_hasta1[0];
 			scope.fdatos_extras.dias_vacaciones1=diff1_;
		}
	}

	$scope.submitForm = function(event) 
	{

		console.log(scope.fdatos);
	 	if(scope.fecha_inicio_contrato!=undefined || scope.fecha_inicio_contrato!=null)
	 	{
	 		var fecha_inicio_contrato =(scope.fecha_inicio_contrato).split("/"),
	   		t1 = new Date();
	   		var fecha_inicio_convertida=new Date(fecha_inicio_contrato[2]+"/"+fecha_inicio_contrato[1]+"/"+fecha_inicio_contrato[0]);
	   		scope.fdatos.fecha_inicio_contrato=fecha_inicio_contrato[2]+"/"+fecha_inicio_contrato[1]+"/"+fecha_inicio_contrato[0];	
	 	}
	 	if(scope.fecha_perioro_prueba!=undefined || scope.fecha_perioro_prueba!=null)
	 	{
	 		var fecha_perioro_prueba =(scope.fecha_perioro_prueba).split("/"),
	   		t2 = new Date();
	   		var fecha_perioro_prueba_convertida=new Date(fecha_perioro_prueba[2]+"/"+fecha_perioro_prueba[1]+"/"+fecha_perioro_prueba[0]);
	   		scope.fdatos.fecha_perioro_prueba=fecha_perioro_prueba[2]+"/"+fecha_perioro_prueba[1]+"/"+fecha_perioro_prueba[0];
	 	}   		
   		if(scope.fecha_fin_contrato!=undefined || scope.fecha_fin_contrato!=null)
	 	{
	 		var fecha_fin_contrato =(scope.fecha_fin_contrato).split("/"),   			
	    	t3 = new Date(); 
	    	var fecha_fin_contrato_convertida=new Date(fecha_fin_contrato[2]+"/"+fecha_fin_contrato[1]+"/"+fecha_fin_contrato[0]);    		
	 		scope.fdatos.fecha_fin_contrato=fecha_fin_contrato[2]+"/"+fecha_fin_contrato[1]+"/"+fecha_fin_contrato[0];
	 	}			
 		scope.contar_dias_vacaciones();
	 	bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro de agregarle este horario al usuario?",
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
			
				scope.guardar();	
			}
		}});
					
	}; 
	scope.guardar=function()
	{
		if(scope.fdatos.final_laborable==null || scope.fdatos.final_laborable==undefined)
		{
			bootbox.alert({
			title:"Días Laborables",
		    message: "Debe asignarle los días laborables al usuario.",
		    size: 'middle'});					
			return false;
		}
		if (!scope.fdatos.final_laborable.length>0)
		{
			bootbox.alert({
				title:"Días Laborables",
		    message: "Debe asignarle los días laborables al usuario.",
		    size: 'middle'});					
			return false;
		}
		$("#guardando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
		var url = base_urlHome()+"api/Horarios/guardar_horarios/";
		$http.post(url,scope.fdatos).then(function(result)
		{
			if(result.data!=false)
			{				
				$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				title:"Confirmación",
				message: "Datos ingresados correctamente",
				size: 'middle'});
				scope.buscar_usuario();
			}
			else
			{
				$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				title:"Error",
				message: "Un error ha ocurrido al intentar guardar los datos",
				size: 'middle'});
			}
		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "El método que está intentando usar no puede ser localizado",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Usted no tiene acceso a este controlador",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Actualmente estamos prensentado fallas en el servidor, por favor intente mas tarde",
				size: 'middle'});
			}
		});
	}
	scope.limpiar=function()
	{
		scope.fdatos={};
		scope.spinner_usuario=0;
		scope.resultado=0;
		scope.select_dia_laborables=[];		
		scope.fecha_inicio_contrato=undefined;
		scope.fecha_perioro_prueba=undefined;
		scope.fecha_fin_contrato=undefined;
		scope.fecha_vacaciones_desde=undefined;
		scope.fecha_vacaciones_hasta=undefined;
		scope.consultar_dias_laborables();
	}
};
