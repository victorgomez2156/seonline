app.controller('Controlador_Consultas', ['$http', '$scope','$cookies','$route','$filter','$cookieStore','netTesting','ServiceCarpetas','ServiceUsuarios','ServiceDepartamentosConsulta', Controlador]);
function Controlador($http , $scope ,$cookies, $route,$filter,$cookieStore,netTesting,ServiceCarpetas,ServiceUsuarios,ServiceDepartamentosConsulta)
{
	var scope = this;
	scope.fdatos={};
	scope.consulta_datos={};
	scope.fdatos_carpetas={};	
	scope.fdatos_departamentos={};
	scope.fdatos_asistencia={};
	scope.index=0;
	scope.fdatos.usuario=false;
	scope.fdatos.carpeta=false;
	scope.fdatos.departamento=false;
	//scope.consulta_datos.departamentos=[];
	scope.consulta_carpetas={};	
	scope.verificar=0;
	scope.verificar2=0;
	scope.verificar3=0;
	scope.vista_consulta=0;
	scope.spinner_correo=0;
	scope.email_comprobar=0;
	
	scope.total_horas_trabajadas=0;	
	scope.total_minutos_trabajas=0;	
	scope.total_segundos_trabajas=0;
	scope.total_horas_acumuladas=0;
	scope.total_minutos_acumulados=0;
	scope.total_segundos_acumulados=0;

	scope.horas=0;
	scope.minutos=0;
	scope.segundos=0;
	scope.final_total=0;
	scope.tdetallesbreaks	=[];
	scope.tdetallesreuniones=[];
	scope.ApiKey = $cookies.get('ApiKey'); 
	scope.nivel_users = $cookies.get('nivel');
	scope.id = $cookies.get('id');

	scope.excel=false;
	scope.excel_detallado=false;
	
	ServiceUsuarios.getAll().then(function(dato) 
	{
		scope.usuarios = dato;
		//console.log(scope.empresas);
	}).catch(function(err) 
	{
		console.log(err); //Tratar el error
		if(err.status==false && err.error=="This API key does not have access to the requested controller.")
			{
				//$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" ); 
				bootbox.alert({
				message: "Está intentando acceder a un módulo al cual no tiene acceso",
				size: 'middle'});
				return false;
			}
			if(err.status==false && err.error=="Invalid API Key.")
			{
				//$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" ); 
				bootbox.alert({
				message: "Error de Seguridad, está intentando ingresar al sistema con un <b>ApiKey</b> inválido",
				size: 'middle'});
				return false;
			}
	});
	scope.realizar_consulta=function(metodo,datos)
	{
		//console.log(metodo);
		//console.log(datos);
		if(metodo==1 && datos==true)
		{
			//alert('paso por aqui con verdadero metodo Usuario');
			scope.verificar=1;
			scope.vista_consulta=1;
			scope.consulta_datos.departamentos=false;
			scope.consulta_datos.carpetas=false;
			scope.consulta_datos.sistemas=false;
		}
		if(metodo==1 && datos==false)
		{
			//alert('paso en modo false metodo Usuario');
			scope.verificar=0;
			scope.vista_consulta=0;
			scope.spinner_correo=0;
			scope.email_comprobar=0;
			scope.consulta_datos={};			
			scope.consulta_datos.departamentos=undefined;
			scope.consulta_datos.carpetas=undefined;
			scope.consulta_datos.sistemas=undefined;
			scope.fdatos.huser=undefined;

		}
		if(metodo==2 && datos==true)
		{
			//alert('paso por aqui con verdadero metodo Carpetas');
			scope.verificar2=1;
			scope.vista_consulta=2;
			scope.consulta_carpetas.carpetas_obtenidas=false;
			scope.consulta_carpetas.departamentos_pertenecen=false;

		}
		if(metodo==2 && datos==false)
		{
			//alert('paso en modo false metodo Carpetas');
			scope.vista_consulta=0;
			scope.verificar2=0;
			scope.consulta_carpetas={};
			scope.fdatos_carpeta.carpetas=undefined;
			scope.spinner_carpetas=0;
			scope.resultado_busqueda=0;
		}
		if(metodo==3 && datos==true)
		{
			//alert('paso por aqui con verdadero metodo Departamentos');
			scope.verificar3=1;
			scope.vista_consulta=3;
			scope.fdatos_departamentos.departamentos_usuarios1=false;
			scope.fdatos_departamentos.carpetas_pertenecen=false;
		}
		if(metodo==3 && datos==false)
		{
			//alert('paso en modo false metodo Departamentos');
			//scope.limpiar();
			scope.vista_consulta=0;
			scope.verificar3=0;
			scope.fdatos_departamentos={};
			scope.spinner_perfiles=0;
			scope.perfil_Resultado=0;			
		}

	}
	scope.fecha_server=function()
	{
		var url = base_urlHome()+"api/Consulta_Datos/fecha_server/";
		$http.post(url).then(function(result)
		{
			if(result.data!=false)
			{
				//console.log(result);
				scope.desde=result.data.desde;
				scope.hasta=result.data.fecha;

			}

		},function(error)
		{

		})
	}
	scope.comprobar_datos=function()
	{
		if(scope.fdatos.huser!=null)
		{
			scope.spinner_correo=1;
			scope.email_comprobar=0;
			//console.log(scope.fdatos.correo_electronico);
			var url = base_urlHome()+"api/Consulta_Datos/buscar_datos_usuarios/";
			$http.post(url,scope.fdatos).success(function(data)
			{
				if(data!=false)
				{
					
					
					//scope.consulta_datos={};
					scope.consulta_datos=data;
					scope.email_comprobar=1;
					scope.spinner_correo=0;					
					$scope.predicate = 'id';  
					$scope.reverse = true;						
					$scope.currentPage = 1;  
					$scope.order = function (predicate) 
					{  
						$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
						$scope.predicate = predicate;  
					}; 						
					scope.consulta_datos.departamentos = data.departamentos;					
					$scope.totalItems = scope.consulta_datos.departamentos.length; 
					$scope.numPerPage = 50;  
					$scope.paginate = function (value) 
					{  
						var begin, end, index;  
						begin = ($scope.currentPage - 1) * $scope.numPerPage;  
						end = begin + $scope.numPerPage;  
						index = scope.consulta_datos.departamentos.indexOf(value);  
						return (begin <= index && index < end);  
					};
					$scope.predicate1 = 'id';  
					$scope.reverse1 = true;						
					$scope.currentPage1 = 1;  
					$scope.order1 = function (predicate1) 
					{  
						$scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;  
						$scope.predicate1 = predicate1;  
					}; 						
					scope.consulta_datos.carpetas = data.carpetas; 
					
					$scope.totalItems1 = scope.consulta_datos.carpetas.length; 
					$scope.numPerPage1 = 50;  
					$scope.paginate1 = function (value) 
					{  
						var begin1, end1, index1;  
						begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;  
						end1 = begin1 + $scope.numPerPage1;  
						index1 = scope.consulta_datos.carpetas.indexOf(value);  
						return (begin1 <= index1 && index1 < end1);  
					};
					$scope.predicate2 = 'id';  
					$scope.reverse2 = true;						
					$scope.currentPage2 = 1;  
					$scope.order2 = function (predicate2) 
					{  
						$scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;  
						$scope.predicate2 = predicate2;  
					}; 						
					scope.consulta_datos.sistemas = data.sistemas;					
					$scope.totalItems2 = scope.consulta_datos.sistemas.length; 
					$scope.numPerPage2 = 50;  
					$scope.paginate2 = function (value) 
					{  
						var begin2, end2, index2;  
						begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;  
						end2 = begin2 + $scope.numPerPage2;  
						index2 = scope.consulta_datos.sistemas.indexOf(value);  
						return (begin2 <= index2 && index2 < end2);  
					};
					if(data.departamentos==false)
					{
						scope.consulta_datos.departamentos=[];
					}					
					if(data.carpetas==false)
					{
						scope.consulta_datos.carpetas=[];
					}
					if(data.sistemas==false)
					{
						scope.consulta_datos.sistemas=[];
					}
				}
				else
				{
					scope.consulta_datos={};
					scope.email_comprobar=0;
					scope.spinner_correo=0;
				}
			});
		}
		else
		{
			scope.email_comprobar=0;
			scope.spinner_correo=0;
			scope.consulta_datos={};
			
			//console.log(scope.fdatos.correo_electronico);
		}
		
	}
	scope.limpiar=function()
	{
	
		scope.index=0;
		scope.fdatos.usuario=false;
		scope.fdatos.carpeta=false;
		scope.fdatos.departamento=false;	
		scope.verificar=0;
		scope.verificar2=0;
		scope.verificar3=0;
		scope.vista_consulta=0;
		scope.spinner_correo=0;
		scope.email_comprobar=0;	
	}
	scope.buscar_datos_carpetas=function()
	{
		scope.spinner_carpetas=0;
		scope.resultado_busqueda=0;
		console.log(scope.fdatos_carpeta.carpetas);
		hcarpeta=scope.fdatos_carpeta.carpetas;		
		scope.spinner_carpetas=1;
		var url = base_urlHome()+"api/Consulta_Datos/buscar_usuarios_carpetas/";
		$http.post(url,scope.fdatos_carpeta).success(function(data)
		{
			if(data!=false)
			{
				console.log('hay datos');

					scope.spinner_carpetas=0;
					scope.resultado_busqueda=1;
					scope.consulta_carpetas=data;
					$scope.predicate3 = 'id';  
					$scope.reverse3 = true;						
					$scope.currentPage3 = 1;  
					$scope.order3 = function (predicate3) 
					{  
						$scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;  
						$scope.predicate3 = predicate3;  
					}; 						
					scope.consulta_carpetas.carpetas_obtenidas = data.carpetas_obtenidas; 
					
					$scope.totalItems3 = scope.consulta_carpetas.carpetas_obtenidas.length; 
					$scope.numPerPage3 = 50;  
					$scope.paginate3 = function (value) 
					{  
						var begin3, end3, index3;  
						begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;  
						end3 = begin3 + $scope.numPerPage3;  
						index3 = scope.consulta_carpetas.carpetas_obtenidas.indexOf(value);  
						return (begin3 <= index3 && index3 < end3);  
					};
					$scope.predicate4 = 'id';  
					$scope.reverse4 = true;						
					$scope.currentPage4 = 1;  
					$scope.order4 = function (predicate1) 
					{  
						$scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;  
						$scope.predicate4 = predicate4;  
					}; 						
					scope.consulta_carpetas.departamentos_pertenecen = data.departamentos_pertenecen; 
					
					$scope.totalItems4 = scope.consulta_carpetas.departamentos_pertenecen.length; 
					$scope.numPerPage4 = 50;  
					$scope.paginate4 = function (value) 
					{  
						var begin4, end4, index4;  
						begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;  
						end4 = begin4 + $scope.numPerPage4;  
						index4 = scope.consulta_carpetas.departamentos_pertenecen.indexOf(value);  
						return (begin4 <= index4 && index4 < end4);  
					};
			}
			else
			{
				console.log('no hay datos');
				
				scope.fdatos_carpeta={};
				scope.spinner_carpetas=0;
				scope.resultado_busqueda=2;
				scope.fdatos_carpeta.carpetas=hcarpeta;				
				scope.consulta_carpetas.carpetas_obtenidas=[];
				scope.consulta_carpetas.departamentos_pertenecen=[];
			}
		});
	}
	scope.buscar_departamentos=function()
	{
		scope.spinner_perfiles=0;
		scope.perfil_Resultado=0;
		console.log(scope.fdatos_departamentos.hdepartamento);
		hdepartamento=scope.fdatos_departamentos.hdepartamento;
		var url = base_urlHome()+"api/Consulta_Datos/buscar_usuarios_departamentos/";
		scope.spinner_perfiles=1;
		$http.post(url,scope.fdatos_departamentos).success(function(data)
		{
			if(data!=false)
			{
					console.log('hay datos');
					scope.spinner_perfiles=0;
					scope.perfil_Resultado=1;
					scope.fdatos_departamentos=data;
					console.log(scope.fdatos_departamentos);
					if(data.departamentos_usuarios1==false)
					{
						scope.fdatos_departamentos.departamentos_usuarios1=[];
					}
					if(data.carpetas_pertenecen==false)
					{
						scope.fdatos_departamentos.carpetas_pertenecen=[];
					}
					$scope.predicate5 = 'id';  
					$scope.reverse5 = true;						
					$scope.currentPage5 = 1;  
					$scope.order5 = function (predicate5) 
					{  
						$scope.reverse5 = ($scope.predicate5 === predicate5) ? !$scope.reverse5 : false;  
						$scope.predicate5 = predicate5;  
					}; 						
					scope.fdatos_departamentos.departamentos_usuarios1 = data.departamentos_usuarios1; 
					
					$scope.totalItems5 = scope.fdatos_departamentos.departamentos_usuarios1.length; 
					$scope.numPerPage5 = 50;  
					$scope.paginate5 = function (value) 
					{  
						var begin5, end5, index5;  
						begin5 = ($scope.currentPage5 - 1) * $scope.numPerPage5;  
						end5 = begin5 + $scope.numPerPage5;  
						index5 = scope.fdatos_departamentos.departamentos_usuarios1.indexOf(value);  
						return (begin5 <= index5 && index5 < end5);  
					};
					$scope.predicate6 = 'id';  
					$scope.reverse6 = true;						
					$scope.currentPage6 = 1;  
					$scope.order6 = function (predicate1) 
					{  
						$scope.reverse6 = ($scope.predicate6=== predicate6) ? !$scope.reverse6 : false;  
						$scope.predicate6 = predicate6;  
					}; 						
					scope.fdatos_departamentos.carpetas_pertenecen = data.carpetas_pertenecen; 
					
					$scope.totalItems6 = scope.fdatos_departamentos.carpetas_pertenecen.length; 
					$scope.numPerPage6 = 50;  
					$scope.paginate6 = function (value) 
					{  
						var begin6, end6, index6;  
						begin6 = ($scope.currentPage6 - 1) * $scope.numPerPage6;  
						end6 = begin6 + $scope.numPerPage6;  
						index6 = scope.fdatos_departamentos.carpetas_pertenecen.indexOf(value);  
						return (begin6 <= index6 && index6 < end6);  
					};
			}
			else
			{
				console.log('no hay datos');
				scope.spinner_perfiles=0;
				scope.perfil_Resultado=2;				
				scope.fdatos_departamentos={};
				scope.fdatos_departamentos.hdepartamento=hdepartamento;
				scope.fdatos_departamentos.departamentos_usuarios1=[];
				scope.fdatos_departamentos.carpetas_pertenecen=[];

			}
		});
	}




	/////////////////////// PARA CONSULTAR ASISTENCIAS POR EMPLEADOS ////////////////////////////

scope.buscar_asistencias=function()
	{
		scope.consulta_datos={};
		scope.tAsistencia=null;
		//$("#guardando").removeClass("loader loader-default").addClass("loader loader-default is-active");
		var url = base_urlHome()+"api/Consulta_Datos/buscar_asistencias_empleados";
		$http.post(url,scope.fdatos).then(function(result)
		{
			//console.log(result);
			if(result.data!=false)
			{
				//$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
				scope.consulta_datos.id=result.data.id;
				scope.consulta_datos.nombres=result.data.nombres;
				scope.consulta_datos.apellidos=result.data.apellidos;
				scope.tAsistencia=result.data.asistencia_empleado;
				//console.log(scope.tAsistencia);
			}
			else
			{
				//$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
				bootbox.alert({
				title:"Error!",
				message: "Hubo un error al intentar realizar esta acción, por favor intente nuevamente.",
				size: 'middle'});
			}

		},function(error)
		{
			//console.log(error);
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
	}
	
	$scope.submitFormReporteGeneal = function(event) 
	{		
		scope.resultado=0;
		scope.tResultado=undefined;	
		scope.reporte_general={};
		scope.spinner=0;
		scope.excel_pdf=0;
		bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro que desea realizar la operación?",
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
				console.log('Cancelando Ando...');
			}     
			else
			{		 			 	
			 	scope.spinner=1;
			 	var fecha_desde =(scope.desde).split("-"),
		   		fecha_hasta =(scope.hasta).split("-"),
		   		t3 = new Date(),
		    	t4 = new Date();		    		
		    	var fecha_desde_convertida=fecha_desde[2]+"-"+fecha_desde[1]+"-"+fecha_desde[0];	    		
	    		var fecha_hasta_convertida=fecha_hasta[2]+"-"+fecha_hasta[1]+"-"+fecha_hasta[0];	    		
	    		scope.reporte_general.fecha_desde=fecha_desde_convertida;
				scope.reporte_general.fecha_hasta=fecha_hasta_convertida;
				console.log(scope.reporte_general);
				//$("#guardando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
				var url = base_urlHome()+"api/Consulta_Datos/reporte_general_all_empleados/";
				$http.post(url,scope.reporte_general).then(function(result)
				{
					if(result.data!=false)
					{
						scope.spinner=0;
						scope.resultado=1;
						scope.excel_pdf=1;						
						$scope.predicate35 = 'id';  
						$scope.reverse35 = true;						
						$scope.currentPage35 = 1;  
						$scope.order35 = function (predicate35) 
						{  
							$scope.reverse35 = ($scope.predicate35 === predicate35) ? !$scope.reverse35 : false;  
							$scope.predicate35 = predicate35;  
						};
						//scope.tResultado=result.data;
						angular.forEach(result.data, function(Asistencia_General_Empleados)
						{
							var horas_minutos_decimales= (Asistencia_General_Empleados.total_con_descuento).split(":");					
							var total_minutos_decimales,suma_decimales;							
							total_minutos_decimales=horas_minutos_decimales[1]/60;							
							suma_decimales= ((parseFloat(horas_minutos_decimales[0]))+parseFloat(total_minutos_decimales)).toFixed(2);
							console.log(suma_decimales);
							var ObjAsistenciaGeneral = new Object();
							if (scope.tResultado==undefined || scope.tResultado==false)
							{
								scope.tResultado = []; 
							}		
							scope.tResultado.push({nombres:Asistencia_General_Empleados.nombres,apellidos:Asistencia_General_Empleados.apellidos,total_con_descuento:Asistencia_General_Empleados.total_con_descuento,decimales:suma_decimales});
							console.log(scope.tResultado);	

						});





						$scope.totalItems35 = scope.tResultado.length; 
						$scope.numPerPage35 = 50;  
						$scope.paginate35 = function (value35) 
						{  
							var begin35, end35, index35;  
							begin35 = ($scope.currentPage35 - 1) * $scope.numPerPage35;  
							end35 = begin35 + $scope.numPerPage35;  
							index35 = scope.tResultado.indexOf(value35);  
							return (begin35 <= index35 && index35 < end35);  
						};
					}
					else
					{
						//$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
						scope.excel_pdf=0;
						scope.resultado=2;
						scope.spinner=0;
						scope.tResultado=undefined;
						bootbox.alert({
						message: "No hemos encontrado datos relacionados en el rango de consulta.",
						size: 'middle'});
					}

				},function(error)
				{
					//console.log(error);
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
			}
		} 
		});
	}

	$scope.submitFormAsistencias = function(event) 
	{	
		
		scope.resultado=0;
		scope.tResultado=null;	
		scope.vista=0;

		bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro que desea realizar la operación?",
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
				console.log('Cancelando Ando...');
			}     
			else
			{		 			 	
			 	var fecha_desde =(scope.desde).split("-"),
		   		fecha_hasta =(scope.hasta).split("-"),
		   		t3 = new Date(),
		    	t4 = new Date();		    		
		    	var fecha_desde_convertida=fecha_desde[2]+"-"+fecha_desde[1]+"-"+fecha_desde[0];	    		
	    		var fecha_hasta_convertida=fecha_hasta[2]+"-"+fecha_hasta[1]+"-"+fecha_hasta[0];
	    		scope.consulta_datos.desde=fecha_desde_convertida;
				scope.consulta_datos.hasta=fecha_hasta_convertida;
				scope.consulta_datos.tipo_consulta=scope.selec_consulta;
							
				if(scope.consulta_datos.tipo_consulta==1)
				{

					scope.tResultado=[];					
					$("#Cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
					var url = base_urlHome()+"api/Consulta_Datos/buscar_reportes_asistencia/";
					$http.post(url,scope.consulta_datos).then(function(result)
					{
					if(result.data!=false)
					{
						$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						
						
						scope.spinner=0;
						scope.resultado=1;
						scope.vista=1;
						scope.total_horas_trabajadas=0;	
						scope.total_minutos_trabajas=0;	
						scope.total_segundos_trabajas=0;
						scope.total_horas_acumuladas=0;
						scope.total_minutos_acumulados=0;
						scope.total_segundos_acumulados=0;
						scope.horas=0;
						scope.minutos=0;
						scope.segundos=0;						
						$scope.predicate = 'id';  
						$scope.reverse = true;						
						$scope.currentPage = 1;  
						$scope.order = function (predicate) 
						{  
							$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
							$scope.predicate = predicate;  
						};		
						scope.tResultado=result.data.asistencia;
						scope.total_laborado=result.data.sum_asistencia.total_empleado;
						//console.log(scope.total_laborado);
						//console.log(scope.tResultado);		
						$scope.totalItems = scope.tResultado.length; 
						$scope.numPerPage = 50;  
						$scope.paginate = function (value) 
						{  
							var begin, end, index;  
							begin = ($scope.currentPage - 1) * $scope.numPerPage;  
							end = begin + $scope.numPerPage;  
							index = scope.tResultado.indexOf(value);  
							return (begin <= index && index < end);  
						};



					}
					else
					{
						$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						scope.spinner=0;
						scope.resultado=2;
						scope.tResultado=null;
						bootbox.alert({
						message: "No hemos encontrado datos con el usuario seleccionado.",
						size: 'middle'});
					}				},function(error)
				{
					if(error.status==404 && error.statusText=="Not Found")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "El método que esté intentando usar no puede ser localizado",
							size: 'middle'});
						}
						if(error.status==401 && error.statusText=="Unauthorized")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
							size: 'middle'});
						}
						if(error.status==403 && error.statusText=="Forbidden")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Está intentando usar un APIKEY inválido",
							size: 'middle'});
						}
						if(error.status==500 && error.statusText=="Internal Server Error")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde",
							size: 'middle'});
						}
					});
				}//FINAL IF TIPO CONSULTA..
				else
				{
					scope.tpruebaresulta=[];
					scope.tReporteDetallado=[];
					//scope.tResultado=[];
					$("#Cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
					var url = base_urlHome()+"api/Consulta_Datos/buscar_reportes_asistencia/";
					$http.post(url,scope.consulta_datos).then(function(result)
					{
						if(result.data!=false)
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							scope.spinner=0;
							scope.resultado=1;
							scope.vista=2;
							scope.total_horas_trabajadas=0;	
							scope.total_minutos_trabajas=0;	
							scope.total_segundos_trabajas=0;
							scope.total_horas_acumuladas=0;
							scope.total_minutos_acumulados=0;
							scope.total_segundos_acumulados=0;
							scope.horas=0;
							scope.minutos=0;
							scope.segundos=0;
							
							$scope.predicate = 'id';  
							$scope.reverse = true;						
							$scope.currentPage = 1;  
							$scope.order = function (predicate) 
							{  
								$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
								$scope.predicate = predicate;  
							}; 					
							scope.tReporteDetallado=result.data.asistencia;
							scope.total_laborado=result.data.sum_asistencia.total_empleado;					
							$scope.totalItems = scope.tReporteDetallado.length; 
							$scope.numPerPage = 50;  
							$scope.paginate = function (value) 
							{  
								var begin, end, index;  
								begin = ($scope.currentPage - 1) * $scope.numPerPage;  
								end = begin + $scope.numPerPage;  
								index = scope.tReporteDetallado.indexOf(value);  
								return (begin <= index && index < end);  
							};														
						}
						else
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							scope.spinner=0;
							scope.resultado=2;
							bootbox.alert({
							message: "No hemos encontrado datos con el usuario seleccionado.",
							size: 'middle'});
						}
					},function(error)
					{
						if(error.status==404 && error.statusText=="Not Found")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "El método que esté intentando usar no puede ser localizado",
							size: 'middle'});
						}
						if(error.status==401 && error.statusText=="Unauthorized")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
							size: 'middle'});
						}
						if(error.status==403 && error.statusText=="Forbidden")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Está intentando usar un APIKEY inválido",
							size: 'middle'});
						}
						if(error.status==500 && error.statusText=="Internal Server Error")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde",
							size: 'middle'});
						}
					});
				}//FINAL DEL ELSE DEL TIPO DE CONSULTA QUE SI NO ES 1 ENTONCES ES 2			
			}//FINAL ELSE EVENTO DEL FORMLUARIO DE CONSULTA..
		}//FINAL DEL CALLBACK DE LA FUNCIION.. 
		});//FINAL DEL BOOTBOX.CONFIRM..					
	}//FINAL DE LA FUNCION DE CONSULTA..

	scope.Breaks_Reuniones_Empleado=function(index,hasistencia,huser,tipo,fecha)
	{		
		scope.busqueda_detalle={};
		scope.busqueda_detalle.hasistencia=hasistencia;
		scope.busqueda_detalle.huser=huser;
		scope.busqueda_detalle.fecha=fecha;
		//scope.busqueda_detalle.tipo=tipo;
		if(tipo==1)
		{
			//console.log('Tipo: '+tipo);
			scope.tdetallesbreaks=[];
			var url = base_urlHome()+"api/Consulta_Datos/buscar_detalles_breaks";
			$http.post(url,scope.busqueda_detalle).then(function(result)
			{
				if(result.data!=false)
				{
					angular.forEach(result.data, function(calcular_horas)
					{
							//console.log(calcular_horas);
							if(calcular_horas.type==3)
							{
								var fecha_hora_salida= (calcular_horas.break_salida).split(" ");
								var h1=new Date();
								var hora_entrada= (fecha_hora_salida[1]).split(":");
								var h2 = new Date();								
								var fecha_hora_entrada= (calcular_horas.break_entrada).split(" ");
								var h3=new Date();
								var hora_salida= (fecha_hora_entrada[1]).split(":");
								var h4 = new Date();
								var date_1 = new Date(fecha_hora_salida[0]);
								var date_2 = new Date(fecha_hora_entrada[0]);
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
								var hora1 = (fecha_hora_salida[1]).split(":"),
								    hora2 = (fecha_hora_entrada[1]).split(":"),
								    t1 = new Date(),
								    t2 = new Date();
								t1.setHours(hora2[0], hora2[1], hora2[2]);
								t2.setHours(hora1[0], hora1[1], hora1[2]);								
								t1.setHours(t1.getHours() - t2.getHours(), t1.getMinutes() - t2.getMinutes(), t1.getSeconds() - t2.getSeconds());
								
								scope.hora=(t1.getHours() ? t1.getHours(): "");
								scope.minutos=(t1.getMinutes() ? t1.getMinutes() : "");
								scope.segundos=(t1.getSeconds() ? t1.getSeconds(): "");
								if(scope.hora==0)
								{
									scope.hora="0"+scope.hora;
								}
								if(scope.hora<10)
								{
									scope.hora="0"+scope.hora;
								}
								if(scope.minutos==0)
								{
									scope.minutos="0"+scope.minutos;
								}
								if(scope.minutos<10)
								{
									scope.minutos="0"+scope.minutos;
								}
								if(scope.segundos==0)
								{
									scope.segundos="0"+scope.segundos;
								}
								if(scope.segundos<10)
								{
									scope.segundos="0"+scope.segundos;
								}							
								scope.final_horas=scope.hora+":"+scope.minutos+":"+scope.segundos;
								
								scope.total_horas = (t1.getHours() ? t1.getHours() + (t1.getHours() > 1 ? " horas" : " hora") : "") + (t1.getMinutes() ? " " + t1.getMinutes() + (t1.getMinutes() > 1 ? " minutos" : " minuto") : "") + (t1.getSeconds() ? (t1.getHours() || t1.getMinutes() ? " y " : "") + t1.getSeconds() + (t1.getSeconds() > 1 ? " segundos" : " segundo") : "");
								if(diff_in_days>="1 Dia")
								{
									scope.jornada_final=diff_in_days+scope.final_horas;
								}
								else
								{
									scope.jornada_final=scope.final_horas;
								}
								scope.hora_entrada=fecha_hora_entrada[1];
								scope.hora_salida=fecha_hora_salida[1];															
							}
							else
							{
								scope.jornada_final = 'No ha Culminado el Break.';								
								if(calcular_horas.break_entrada!=null)
								{
									var fecha_hora_entrada= (calcular_horas.break_entrada).split(" ");
									var h1=new Date();
									var hora_entrada= (fecha_hora_entrada[1]).split(":");
									scope.hora_entrada=fecha_hora_entrada[1]; 
								}
								else
								{
									scope.hora_entrada='Sin Marcar Hora Regreso';
								}
							}
								scope.tdetallesbreaks.push({id:calcular_horas.id,fecha:calcular_horas.fecha,break_entrada:scope.hora_entrada,break_salida:scope.hora_salida,total_break:scope.jornada_final,tipo:calcular_horas.type});
								$scope.predicate2 = 'id';  
								$scope.reverse2 = true;						
								$scope.currentPage2 = 1;  
								$scope.order2 = function (predicate2) 
								{  
									$scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;  
									$scope.predicate2 = predicate2;  
								}; 					
													
								$scope.totalItems2 = scope.tdetallesbreaks.length; 
								$scope.numPerPage2 = 50;  
								$scope.paginate2 = function (value2) 
								{  
									var begin2, end2, index2;  
									begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;  
									end2 = begin2 + $scope.numPerPage2;  
									index2 = scope.tdetallesbreaks.indexOf(value2);  
									return (begin2 <= index2 && index2 < end2);  
								};
								scope.horas=0;
								scope.minutos=0;
								scope.segundos=0;
								for(var i=0; i<scope.tdetallesbreaks.length; i++) 
								{								
									var break_partida = (scope.tdetallesbreaks[i].total_break.split(":"));
									var h4 = new Date();
									console.log(break_partida);
									//scope.total_final= (scope.total_final+scope.tdetallesbreaks[i].total_break);
									if(break_partida[0]!="No ha Culminado el Break.")
									{
										scope.horas = Math.max(parseFloat(scope.horas),0) + Math.max(parseFloat(break_partida[0]),0);
										scope.minutos = Math.max(parseFloat(scope.minutos),0) + Math.max(parseFloat(break_partida[1]),0);
										scope.segundos = Math.max(parseFloat(scope.segundos),0) + Math.max(parseFloat(break_partida[2]),0);
										if(scope.horas<10)
										{
											scope.horas="0"+scope.horas;
										}
										if(scope.minutos<10)
										{
											scope.minutos="0"+scope.minutos;
										}
										if(scope.segundos<10)
										{
											scope.segundos="0"+scope.segundos;
										}
										if(scope.minutos>=60)
										{
											scope.horas = Math.max(parseFloat(scope.horas),0) + 1;
											if(scope.horas<10)
											{
												scope.horas="0"+scope.horas;
											}
											scope.minutos = Math.max(parseFloat(scope.minutos),0) - 60;
											if(scope.minutos<10)
											{
												scope.minutos="0"+scope.minutos;
											}
										}

										if(scope.segundos>=60)
										{
											scope.minutos = Math.max(parseFloat(scope.minutos),0) + 1;
											if(scope.minutos<10)
											{
												scope.minutos="0"+scope.minutos;
											}
											scope.segundos = Math.max(parseFloat(scope.segundos),0) - 60;
											if(scope.segundos<10)
											{
												scope.segundos="0"+scope.segundos;
											}
										}
									}									
								}									
										
						});
					$("#modal_detalles_breaks").modal('show');
				}
				else
				{
					scope.tdetallesbreaks=null;
					bootbox.alert({
					message: "Este empleado no realizó ningún break en esta entrada.",
					size: 'middle'});
					console.log('No hay datos');
				}
			},function(error)
			{
				console.log(error);
				if(error.status==404 && error.statusText=="Not Found")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "El método que esté intentando usar no puede ser localizado",
							size: 'middle'});
						}
						if(error.status==401 && error.statusText=="Unauthorized")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
							size: 'middle'});
						}
						if(error.status==403 && error.statusText=="Forbidden")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Está intentando usar un APIKEY inválido",
							size: 'middle'});
						}
						if(error.status==500 && error.statusText=="Internal Server Error")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde",
							size: 'middle'});
						}

			});
		}
		if(tipo==2)
		{
			//console.log('Tipo: '+tipo);
			var url = base_urlHome()+"api/Consulta_Datos/buscar_detalles_reuniones";
			$http.post(url,scope.busqueda_detalle).then(function(result)
			{
				if(result.data!=false)
				{
					scope.tdetallesreuniones=[];					
					angular.forEach(result.data, function(calcular_horas)
					{
						if(calcular_horas.type==6)
						{
							var fecha_hora_salida= (calcular_horas.reuniones_salida).split(" ");
							var h1=new Date();
							var hora_entrada= (fecha_hora_salida[1]).split(":");
							var h2 = new Date();								
							var fecha_hora_entrada= (calcular_horas.reuniones_entrada).split(" ");
							var h3=new Date();
							var hora_salida= (fecha_hora_entrada[1]).split(":");
							var h4 = new Date();
							var date_1 = new Date(fecha_hora_salida[0]);
							var date_2 = new Date(fecha_hora_entrada[0]);
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
							var hora1 = (fecha_hora_salida[1]).split(":"),
						    hora2 = (fecha_hora_entrada[1]).split(":"),
						    t1 = new Date(),
						    t2 = new Date();
							t1.setHours(hora2[0], hora2[1], hora2[2]);
							t2.setHours(hora1[0], hora1[1], hora1[2]);
							t1.setHours(t1.getHours() - t2.getHours(), t1.getMinutes() - t2.getMinutes(), t1.getSeconds() - t2.getSeconds());
							
								scope.hora_reunion=(t1.getHours() ? t1.getHours(): "");
								scope.minutos_reunion=(t1.getMinutes() ? t1.getMinutes() : "");
								scope.segundos_reunion=(t1.getSeconds() ? t1.getSeconds(): "");
								if(scope.hora_reunion==0)
								{
									scope.hora_reunion="0"+scope.hora_reunion;
								}
								if(scope.hora_reunion<10)
								{
									scope.hora_reunion="0"+scope.hora_reunion;
								}
								if(scope.minutos_reunion==0)
								{
									scope.minutos_reunion="0"+scope.minutos_reunion;
								}
								if(scope.minutos_reunion<10)
								{
									scope.minutos_reunion="0"+scope.minutos_reunion;
								}
								if(scope.segundos_reunion==0)
								{
									scope.segundos_reunion="0"+scope.segundos_reunion;
								}
								if(scope.segundos_reunion<10)
								{
									scope.segundos_reunion="0"+scope.segundos_reunion;
								}							
								scope.final_horas=scope.hora_reunion+":"+scope.minutos_reunion+":"+scope.segundos_reunion;

							scope.total_horas = (t1.getHours() ? t1.getHours() + (t1.getHours() > 1 ? " horas" : " hora") : "") + (t1.getMinutes() ? " " + t1.getMinutes() + (t1.getMinutes() > 1 ? " minutos" : " minuto") : "") + (t1.getSeconds() ? (t1.getHours() || t1.getMinutes() ? " y " : "") + t1.getSeconds() + (t1.getSeconds() > 1 ? " segundos" : " segundo") : "");
							if(diff_in_days>="1 Dia")
							{
								scope.jornada_final=diff_in_days+scope.final_horas;
							}
							else
							{
								scope.jornada_final=scope.final_horas;
							}
							scope.hora_entrada=fecha_hora_entrada[1];
							scope.hora_salida=fecha_hora_salida[1];
							//console.log(scope.jornada_final);
						}
						else
							{
								scope.jornada_final = 'No ha Culminado la reunión.';
								if(calcular_horas.reuniones_salida!=null)
								{
									var fecha_hora_salida= (calcular_horas.reuniones_salida).split(" ");
									var h3=new Date();
									var hora_salida= (fecha_hora_salida[1]).split(":");
									var h4 = new Date();
									scope.hora_salida=fecha_hora_salida[1];
								}
								else
								{
									scope.hora_salida='Sin Marcar Salida a Reunión';
								}	
								if(calcular_horas.reuniones_entrada!=null)
								{
									var fecha_hora_entrada= (calcular_horas.reuniones_entrada).split(" ");
									var h1=new Date();
									var hora_entrada= (fecha_hora_entrada[1]).split(":");
									scope.hora_entrada=fecha_hora_entrada[1]; 
								}
								else
								{
									scope.hora_entrada='Sin Marcar Regreso de Reunión';
								}
							}
							for(var i=0; i<scope.tdetallesreuniones.length; i++) 
							{
								var reunion_partida = (scope.tdetallesreuniones[i].total_reunion.split(":"));
								var h4 = new Date();
								console.log(reunion_partida);
								//scope.total_final= (scope.total_final+scope.tdetallesbreaks[i].total_break);
								if(reunion_partida[0]!="No ha Culminado la reunión.")
								{
									scope.hora_reunion = Math.max(parseFloat(scope.hora_reunion),0) + Math.max(parseFloat(reunion_partida[0]),0);
									scope.minutos_reunion = Math.max(parseFloat(scope.minutos_reunion),0) + Math.max(parseFloat(reunion_partida[1]),0);
									scope.segundos_reunion = Math.max(parseFloat(scope.segundos_reunion),0) + Math.max(parseFloat(reunion_partida[2]),0);
									if(scope.hora_reunion<10)
									{
										scope.hora_reunion="0"+scope.hora_reunion;
									}
									if(scope.minutos_reunion<10)
									{
										scope.minutos_reunion="0"+scope.minutos_reunion;
									}
									if(scope.segundos_reunion<10)
									{
										scope.segundos_reunion="0"+scope.segundos_reunion;
									}
									if(scope.minutos_reunion>=60)
									{
										scope.hora_reunion = Math.max(parseFloat(scope.hora_reunion),0) + 1;
										if(scope.hora_reunion<10)
										{
											scope.hora_reunion="0"+scope.hora_reunion;
										}
										scope.minutos_reunion = Math.max(parseFloat(scope.minutos_reunion),0) - 60;
										if(scope.minutos_reunion<10)
										{
											scope.minutos_reunion="0"+scope.minutos_reunion;
										}
									}
									if(scope.segundos_reunion>=60)
									{
										scope.minutos_reunion = Math.max(parseFloat(scope.minutos_reunion),0) + 1;
										if(scope.minutos_reunion<10)
										{
											scope.minutos_reunion="0"+scope.minutos_reunion;
										}
										scope.segundos_reunion = Math.max(parseFloat(scope.segundos_reunion),0) - 60;
										if(scope.segundos_reunion<10)
										{
											scope.segundos_reunion="0"+scope.segundos_reunion;
										}
									}
								}
									console.log(scope.hora_reunion);
									console.log(scope.minutos_reunion);
									console.log(scope.segundos_reunion);
								}	

							scope.tdetallesreuniones.push({id:calcular_horas.id,fecha:calcular_horas.fecha,reuniones_salida:scope.hora_salida,reuniones_entrada:scope.hora_entrada,total_reunion:scope.jornada_final,tipo:calcular_horas.type,estatus_reuniones:calcular_horas.estatus_reuniones});
							$scope.predicate3 = 'id';  
							$scope.reverse3 = true;						
							$scope.currentPage3 = 1;  
							$scope.order3 = function (predicate3) 
							{  
								$scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;  
								$scope.predicate3 = predicate3;  
							}; 					
													
							$scope.totalItems3 = scope.tdetallesreuniones.length; 
							$scope.numPerPage3 = 50;  
							$scope.paginate3 = function (value3) 
							{  
								var begin3, end3, index3;  
								begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;  
								end3 = begin3 + $scope.numPerPage3;  
								index3 = scope.tdetallesreuniones.indexOf(value3);  
								return (begin3 <= index3 && index3 < end3);  
							};	
					});
					$("#modal_detalles_reuniones").modal('show');
					console.log(scope.tdetallesreuniones);
				}
				else
				{
					scope.tdetallesreuniones=null;
					bootbox.alert({
					message: "Este empleado no asistió a ninguna reunión en esta entrada.",
					size: 'middle'});
					console.log('No hay datos');
				}
			},function(error)
			{
				console.log(error);
				if(error.status==404 && error.statusText=="Not Found")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "El método que esté intentando usar no puede ser localizado",
							size: 'middle'});
						}
						if(error.status==401 && error.statusText=="Unauthorized")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
							size: 'middle'});
						}
						if(error.status==403 && error.statusText=="Forbidden")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Está intentando usar un APIKEY inválido",
							size: 'middle'});
						}
						if(error.status==500 && error.statusText=="Internal Server Error")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde",
							size: 'middle'});
						}

			});	
		}
		if(tipo==3)
		{
			//alert('Por Aqui');
			scope.total_segundos=0;
			scope.tdetalleinactividades=null;
			var url = base_urlHome()+"api/Consulta_Datos/buscar_inactividades_users";
			$http.post(url,scope.busqueda_detalle).then(function(result)
			{
				if(result.data!=false)
				{
					scope.tdetalleinactividades=result.data;
					$scope.predicate4 = 'id';  
					$scope.reverse4 = true;						
					$scope.currentPage4 = 1;  
					$scope.order4= function (predicate4) 
					{  
						$scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;  
						$scope.predicate4 = predicate4;  
					}; 					
					$scope.totalItems4 = scope.tdetalleinactividades.length; 
					$scope.numPerPage4 = 50;  
					$scope.paginate4 = function (value4) 
					{  
						var begin4, end4, index4;  
						begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;  
						end4 = begin4 + $scope.numPerPage4;  
						index4 = scope.tdetalleinactividades.indexOf(value4);  
						return (begin4 <= index4 && index4 < end4);  
					};	
					$("#modal_detalle_inactividades").modal('show');
					for(var i=0; i<scope.tdetalleinactividades.length; i++) 
					{								
						console.log(scope.tdetalleinactividades[i].tiempo_inactivo);
						//scope.total_final= (scope.total_final+scope.tdetallesbreaks[i].total_break);
						scope.total_segundos = Math.max(parseFloat(scope.total_segundos),0) + Math.max(parseFloat(scope.tdetalleinactividades[i].tiempo_inactivo),0);
						console.log(scope.total_segundos);
						//scope.minutos = Math.max(parseFloat(scope.minutos),0) + Math.max(parseFloat(break_partida[1]),0);
						//scope.segundos = Math.max(parseFloat(scope.segundos),0) + Math.max(parseFloat(break_partida[2]),0);
					
						var hours = Math.floor(scope.total_segundos/(60 * 60)); 
						var divisor_for_minutes = scope.total_segundos % (60 * 60); 
						var minutes = Math.floor(divisor_for_minutes/60); 
					    var divisor_for_seconds = divisor_for_minutes % 60; 
					    var seconds = Math.ceil(divisor_for_seconds); 
					    if(hours<10 || hours==0)
					    {
					    	hours="0"+hours;
					    }
					    if(minutes<10 || minutes==0)
					    {
					    	minutes="0"+minutes;
					    }
					    if(seconds<10 || seconds==0)
					    {
					    	seconds="0"+seconds;
					    }

					    scope.hora_inactivo =hours;
					    scope.minutos_inactivos=minutes;
					    scope.segundos_inactivos=seconds;
						console.log(hours);
						console.log(minutes);
						console.log(seconds);
					}
				}
				else
				{
					scope.tdetalleinactividades=null;
					bootbox.alert({
					message: "No hemos detectado inactividad en esta entrada.",
					size: 'middle'});
				}

			},function(error)
			{
				console.log(error);
				if(error.status==404 && error.statusText=="Not Found")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "El método que esté intentando usar no puede ser localizado",
							size: 'middle'});
						}
						if(error.status==401 && error.statusText=="Unauthorized")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
							size: 'middle'});
						}
						if(error.status==403 && error.statusText=="Forbidden")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Está intentando usar un APIKEY inválido",
							size: 'middle'});
						}
						if(error.status==500 && error.statusText=="Internal Server Error")
						{
							$("#Cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde",
							size: 'middle'});
						}
			});
		}


	}
	scope.exportar_excel=function()
	{
       	scope.excel=false;
       	scope.datos_excel={};
        var fecha_desde =(scope.desde).split("-"),
			fecha_hasta =(scope.hasta).split("-"),
		   	t3 = new Date(),
		    t4 = new Date();		    		
		    var fecha_desde_convertida=fecha_desde[2]+"-"+fecha_desde[1]+"-"+fecha_desde[0];	    		
	    	var fecha_hasta_convertida=fecha_hasta[2]+"-"+fecha_hasta[1]+"-"+fecha_hasta[0];
	    scope.datos_excel.fecha_desde=fecha_desde_convertida;
	    scope.datos_excel.fecha_hasta=fecha_hasta_convertida;
	    scope.datos_excel.huser=scope.fdatos.huser;
        $("#excel").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
        var url = base_urlHome()+"api/Consulta_Datos/Exportar_Excel/";
        $http.post(url,scope.datos_excel).then(function(result)
        {
        	if(result.data!=false)
        	{
        		$("#excel").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
        		bootbox.alert({
				message: "El Reporte se ha generado correctamente. Pulse el Boton Descargar para bajar el reporte.",
				size: 'middle'});
        		scope.excel=true;
        		scope.nombre_reporte=result.data.nombre_reporte;        		
        	}
        	else
        	{
				scope.excel=false;
				$("#excel").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
        		bootbox.alert({
				message: "No se pudo crear el reporte en excel",
				size: 'middle'});
        	}

        },function(error)
        {
        	if(error.status==404 && error.statusText=="Not Found")
			{
				$("#excel").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "El método que esté intentando usar no puede ser localizado",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#excel").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
				bootbox.alert({
				message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#excel").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#excel").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
				bootbox.alert({
				message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde",
				size: 'middle'});
			}
        });
	}
	scope.exportar_excel_detallado=function()
	{
       	scope.excel_detallado=false;
       	scope.datos_excel={};
        var fecha_desde =(scope.desde).split("-"),
			fecha_hasta =(scope.hasta).split("-"),
		   	t3 = new Date(),
		    t4 = new Date();		    		
		    var fecha_desde_convertida=fecha_desde[2]+"-"+fecha_desde[1]+"-"+fecha_desde[0];	    		
	    	var fecha_hasta_convertida=fecha_hasta[2]+"-"+fecha_hasta[1]+"-"+fecha_hasta[0];
	    scope.datos_excel.fecha_desde=fecha_desde_convertida;
	    scope.datos_excel.fecha_hasta=fecha_hasta_convertida;
	    scope.datos_excel.huser=scope.fdatos.huser;
        $("#excel").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
        var url = base_urlHome()+"api/Consulta_Datos/Exportar_Excel_Detallado/";
        $http.post(url,scope.datos_excel).then(function(result)
        {
        	if(result.data!=false)
        	{
        		$("#excel").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
        		bootbox.alert({
				message: "El Reporte se ha generado correctamente. Pulse el Boton Descargar para bajar el reporte.",
				size: 'middle'});
        		scope.excel_detallado=true;
        		scope.nombre_reporte=result.data.nombre_reporte;        		
        	}
        	else
        	{
				scope.excel_detallado=false;
				$("#excel").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
        		bootbox.alert({
				message: "No se pudo crear el reporte en excel",
				size: 'middle'});
        	}

        },function(error)
        {
        	if(error.status==404 && error.statusText=="Not Found")
			{
				$("#excel").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "El método que esté intentando usar no puede ser localizado",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#excel").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
				bootbox.alert({
				message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#excel").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#excel").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
				bootbox.alert({
				message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde",
				size: 'middle'});
			}
        });
	}					
};
