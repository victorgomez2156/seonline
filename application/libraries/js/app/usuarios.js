app.controller('CtrlUsuariosController', ['$http', '$scope','$cookies','$route','$filter','ServiceOficinas','ServiceDepartamentos','$cookieStore','netTesting', Controlador]);
function Controlador($http , $scope ,$cookies, $route,$filter,ServiceOficinas,ServiceDepartamentos,$cookieStore,netTesting)
{
	//declaramos una variable llamada scope donde tendremos a vm
	ServiceOficinas.getAll().then(function(dato) 
	{
		scope.Oficinas = dato;
		//console.log(scope.empresas);
	}).catch(function(err) 
	{
		//console.log(err); //Tratar el error
	});		


	var scope = this;
	scope.tEditUSers = {}; // datos del formulario
	scope.tEditUSers.detalle = []; 
	scope.tEditUSers.detalle_departamentos=[];
	scope.tUsers=null; // datos de todos los usuarios activos o desactivos
	scope.tUsersActive=null; // datos de los usuarios activos
	scope.tUsersDisabled=null; // datos de los usuarios desactivados
	scope.ApiKey = $cookies.get('ApiKey'); 
	scope.nivel_users = $cookies.get('nivel');
	scope.id = $cookies.get('id');	
	scope.index  = 0;
	scope.filtro=0;
	scope.bloqueado = [{id: 1, nombre: 'Activo'},{id: 2, nombre: 'Desactivado'}];
	scope.nivel = [{id: 1, nombre: 'Superadmin'},{id: 2, nombre: 'Coordinador'},{id: 3, nombre: 'Usuarios'}];
	scope.tEditUSers.contrasena=undefined;
	scope.tEditUSers.re_contrasena=undefined;	
	scope.tEditUSers.usuario=undefined;
	scope.tEditUSers.dni=undefined;
	scope.tEditUSers.correo_electronico=undefined;
	scope.spinner=0;
	scope.dni_busqueda=0;	
	scope.spinner_usuario=0;	
	scope.usuario_buscar=0;	
	scope.spinner_correo=0;
	scope.email_comprobar=0;
	scope.verificar_contrasena=0;
	resultado = false;
	scope.select_departamentos=[];	
	scope.count_select_departamentos=0;
	scope.count_select_carpetas=0;
	scope.select_carpetas=[];
	scope.select_sistemas=[];
	scope.count_select_sistemas=0;
	scope.count_select_controladores=0;
	scope.credenciales={};
	scope.credencial=0;
	scope.credenciales.usuario_sistema=null;
	scope.credenciales.usuario=false;
	scope.credenciales.coordinador=false;
	$scope.submitForm = function(event) 
	{      
	 	//console.log(scope.tEditUSers);
	 	bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro que desea incluir este nuevo registro?",
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
	scope.filtrar = function(expresion)
			{
				if (expresion.length>0)
				{
					scope.tUsers = $filter('filter')(scope.tUsersBack, {correo_electronico: expresion});
				}
			}
	
	scope.controladores=function()
	{
		var url = base_urlHome()+"api/Usuarios/traer_controladores/";
		$http.get(url).success(function(data)
		{
			if(data!=false)
			{
				
				$scope.predicate22 = 'id';  
				$scope.reverse22 = true;						
				$scope.currentPage22 = 1;  
				$scope.order22 = function (predicate22) 
				{  
					$scope.reverse22 = ($scope.predicate22 === predicate22) ? !$scope.reverse22 : false;  
					$scope.predicate22 = predicate22;  
				}; 						
				scope.tcontroladores=data;					
				$scope.totalItems22 = scope.tcontroladores.length; 
				$scope.numPerPage22 = 50;  
				$scope.paginate22 = function (value) 
				{  
					var begin22, end22, index22;  
					begin22 = ($scope.currentPage22 - 1) * $scope.numPerPage22;  
					end22 = begin22 + $scope.numPerPage22;  
					index22 = scope.tcontroladores.indexOf(value);  
					return (begin22 <= index22 && index22 < end22);  
				};
			}
			else
			{
				 bootbox.alert({
				 		title:"Controladores",
						message: "No hemos encontrado controladores registrados",
						size: 'small'});	
			}
		});
	}
	scope.all_usuarios=function()
	{
		scope.filtro=0;

		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
		var x = document.getElementsByClassName("status-task");
        var i;
        $('#active_status').val('active');
        for (i = 0; i < x.length; i++) 
        {
           console.log(x);
           console.log(i);
           console.log(x[i]);
            $(x[i]).removeClass('active-status');
        }
        $('#all_active').addClass('active-status');
		var url = base_urlHome()+"api/Usuarios/get_users/";
		$http.get(url).then(function(result)
		{	
			//console.log(result);
			data=result.data;
			if(data!=false)
			{				
				$scope.predicate = 'id';  
				$scope.reverse2 = true;						
				$scope.currentPage = 1;  
				$scope.order = function (predicate) 
				{  
					$scope.reverse2 = ($scope.predicate === predicate) ? !$scope.reverse2 : false;  
					$scope.predicate = predicate;  
				};
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" ); 
				scope.tUsers=data;
				scope.tUsersBack=data;
				$scope.totalItems = scope.tUsers.length; 
				$scope.numPerPage = 50;  
				$scope.paginate = function (value) 
				{  
					var begin, end, index;  
					begin = ($scope.currentPage - 1) * $scope.numPerPage;  
					end = begin + $scope.numPerPage;  
					index = scope.tUsers.indexOf(value);  
					return (begin <= index && index < end);  
				}; 
			}
			else
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				scope.tUsers=null;
			}
		},function(error)
		{
			//console.log(error);
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" ); 
				bootbox.alert({
				message: "Está intentando ingresar a un módulo al cual no tiene acceso",
				size: 'middle'});
				return false;
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" ); 
				bootbox.alert({
				message: "Error de Seguridad, está intentando ingresar al sistema con un <b>ApiKey</b>. inválido",
				size: 'middle'});
				return false;
			}

			//console.log(error);
			//console.log(error.config);
			//console.log(error.data);
		});
	}
	scope.users_active=function()
	{
		scope.filtro=1;
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
		var x = document.getElementsByClassName("status-task");
        var i;
        $('#active_status').val('users_active');
        for (i = 0; i < x.length; i++) 
        {
            $(x[i]).removeClass('active-status');
        }
        $('#active').addClass('active-status');
		
		var url = base_urlHome()+"api/Usuarios/get_users_active/";
		$http.get(url).then(function(result)
		{			
			data=result.data;
			if(data!=false)
			{
				$scope.predicate2 = 'id';  
				$scope.reverse2 = true;						
				$scope.currentPage2 = 1;  
				$scope.order2 = function (predicate2) 
				{  
					$scope.reverse2 = ($scope.predicate2 === predicat2e) ? !$scope.reverse2 : false;  
					$scope.predicate2 = predicate2;  
				};
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" ); 
				scope.tUsersActive=data;
				$scope.totalItems2 = scope.tUsersActive.length; 
				$scope.numPerPage2 = 50;  
				$scope.paginate2 = function (value) 
				{  
					var begin2, end2, index2;  
					begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;  
					end2 = begin2 + $scope.numPerPage2;  
					index2 = scope.tUsersActive.indexOf(value);  
					return (begin2 <= index2 && index2 < end2);  
				}; 
			}
			else
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				scope.tUsersActive=null;
			}
		},function(error)
		{
			console.log(error);
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" ); 
				bootbox.alert({
				message: "Está intentando ingresar a un módulo al cual no tiene acceso",
				size: 'middle'});
				return false;
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" ); 
				bootbox.alert({
				message: "Error de Seguridad, está intentando ingresar al sistema con un <b>ApiKey</b>. inválido",
				size: 'middle'});
				return false;
			}

			//console.log(error);
			//console.log(error.config);
			//console.log(error.data);
		});
	}
	scope.users_disabled=function()
	{
		scope.filtro=2;
		var x = document.getElementsByClassName("status-task");
        var i;
        $('#active_status').val('disabled');
        for (i = 0; i < x.length; i++) 
        {
            $(x[i]).removeClass('active-status');
        }
        $('#all_disabled').addClass('active-status');
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
		var url = base_urlHome()+"api/Usuarios/get_users_disabled/";
		$http.get(url).then(function(result)
		{	
			data=result.data;
			if(data!=false)
			{
				$scope.predicate3 = 'id';  
				$scope.reverse3 = true;						
				$scope.currentPage3 = 1;  
				$scope.order3 = function (predicate3) 
				{  
					$scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;  
					$scope.predicate3 = predicate3;  
				};
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" ); 
				scope.tUsersDisabled=data;
				$scope.totalItems3 = scope.tUsersDisabled.length; 
				$scope.numPerPage3 = 50;  
				$scope.paginate3 = function (value) 
				{  
					var begin3, end3, index3;  
					begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;  
					end3 = begin3 + $scope.numPerPage3;  
					index3 = scope.tUsersDisabled.indexOf(value);  
					return (begin3 <= index3 && index3 < end3);  
				}; 
			}
			else
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				scope.tUsersDisabled=null;
			}
		},function(error)
		{
			//console.log(error);
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" ); 
				bootbox.alert({
				message: "Está intentando ingresar a un módulo al cual no tiene acceso",
				size: 'middle'});
				return false;
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" ); 
				bootbox.alert({
				message: "Error de Seguridad, está intentando ingresar al sistema con un <b>ApiKey</b>. inválido",
				size: 'middle'});
				return false;
			}
			//console.log(error);
			//console.log(error.config);
			//console.log(error.data);
		});
	}
	
	scope.agregar_usuarios=function()
	{
		scope.dni_busqueda=0;
		scope.usuario_buscar=0;
		scope.email_comprobar=0;
		scope.verificar_contrasena=0;
		scope.filtro=4;
		scope.tEditUSers={};
		scope.tEditUSers.dni=undefined;
		//scope.tEditUSers.usuario=undefined;
		//scope.tEditUSers.correo_electronico=undefined;
		scope.tFiltroDepartamentos=null;
		scope.tEditUSers.detalle_controlador=false;
		scope.select_carpetas=[];
		scope.count_select_carpetas=0;
		scope.count_select_controladores=0;
		scope.count_select_sistemas=0;
		scope.count_select_departamentos=0;
		scope.select_departamentos=[];
		scope.select_sistemas=[];
		scope.select_controlador=[];
		
		var x = document.getElementsByClassName("label-floating");
        var i;
        $('#is-focused').val('disabled');
        for (i = 0; i < x.length; i++) 
        {
            $(x[i]).addClass('is-empty');
        }
	}
	scope.edit_users=function(dato)
	{
		scope.filtro=4;
		scope.spinner=0;
		scope.dni_busqueda=2;
		scope.spinner_usuario=0;	
		scope.usuario_buscar=0;	
		scope.spinner_correo=0;
		scope.email_comprobar=0;
		scope.verificar_contrasena=0;
		scope.select_departamentos=[];	
		scope.select_carpetas=[];
		scope.select_sistemas=[];	
		scope.select_controlador=[];

		var x = document.getElementsByClassName("label-floating");
        var i;
        $('#is-empty').val('disabled');
        for (i = 0; i < x.length; i++) 
        {
            $(x[i]).removeClass('is-empty');
        }
      	//scope.tEditUSers=dato;
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
 
		var url = base_urlHome()+"api/Usuarios/comprobar_dni/correo_electronico/"+dato.correo_electronico;
		$http.get(url).success(function(data)
		{
			if(data!=false)
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				scope.tEditUSers=data;				
				scope.count_select_controladores=data.count_total_controladores;
				//console.log(data.detalle);
				
				angular.forEach(data.detalle_controlador, function(controller)
					{					
						scope.select_controlador[controller.id]=controller;					
									
					});
			}
			else
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			}
		});	

	}
	scope.filtrar_credenciales=function(index,id,datos)
	{
		//console.log(index);
		//console.log(id);
		//console.log(datos);
		//scope.credenciales={};
		//scope.credenciales.usuario=false;
		//scope.credenciales.coordinador=false;	
		scope.spinner_credenciales=0;
		scope.credencial=0;
		if(scope.tEditUSers.id==undefined || scope.tEditUSers.id==null)
		{
			//alert('Debe terminar primero el proceso de registro de usuario para poder registrar las credenciales');
			bootbox.alert({
			message: "Debe completar primero el registro del usuario y guardar los datos para poder asignarle las credenciales",
			size: 'middle'});
			return false;
		}
			if(id==undefined)
		{
			//alert('Estimado usuario para poder asignarle las credenciales a este sistema debe actualizar los datos primero y luego asignar las credenciales.');
			bootbox.alert({
			message: "Para poder asignarle las credenciales a este sistema debe actualizar los datos primero",
			size: 'middle'});
			return false;
		}
		else
		{
			scope.credenciales={};
			scope.credenciales.hdetalleaccesosistema=id;
			$("#modal_credenciales").modal('show');
		}
		scope.confirmar_credenciales=function()
		{
			//console.log(scope.credenciales.id_principal);
			//console.log(scope.credenciales);
			if (!scope.validar_credenciales())
			{
				return false;
			}
			$("#guardando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
			var url = base_urlHome()+"api/Usuarios/agregar_credenciales/";
			$http.post(url,scope.credenciales).success(function(data)
			{
				//console.log(data);
				if(data!=false)
				{
					$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					scope.buscar_dni();
					$("#modal_credenciales").modal('hide');
					bootbox.alert({
					message: "Credenciales asignadas con éxito",
					size: 'middle'});


				}
				else
				{
					$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					bootbox.alert({
					message: "Error al intertar registrar las credenciales, intente nuevamente",
					size: 'middle'});
				}
			});

		}
		


	}
	scope.buscar_dni=function()
	{
		//if(scope.tEditUSers.dni!=undefined)
		//{			
			scope.spinner=1;
			scope.dni_busqueda=0;
			scope.usuario_buscar=0;
			scope.email_comprobar=0;
			scope.verificar_contrasena=0;
			scope.select_departamentos=[];	
			scope.select_carpetas=[];
			scope.select_sistemas=[];		
			var url = base_urlHome()+"/api/Usuarios/comprobar_dni/correo_electronico/"+scope.tEditUSers.correo_electronico;
			dni = scope.tEditUSers.dni;
			$http.get(url).success(function(data)
			{
				if(data!=false)
				{
				
					scope.spinner=0;
					scope.dni_busqueda=2;
					scope.tEditUSers=data;
					scope.filtrar_sistemas=data.detalle_sistemas;
					scope.count_select_departamentos=data.count_total_departamentos;
					scope.count_select_carpetas=data.count_total_carpetas;
					scope.count_select_sistemas=data.count_total_sistemas;
					scope.count_select_controladores=data.count_total_controladores;
					//console.log(data.detalle);
					angular.forEach(data.detalle_departamentos, function(departamentos)
					{					
						scope.select_departamentos[departamentos.id]=departamentos;						
									
					});
					angular.forEach(data.detalle, function(carpetas)
					{					
						scope.select_carpetas[carpetas.id]=carpetas;						
									
					});
					angular.forEach(data.detalle_sistemas, function(sistemas)
					{					
						scope.select_sistemas[sistemas.id]=sistemas;						
									
					});
					angular.forEach(data.detalle_controlador, function(controller)
					{					
						scope.tid=controller.id;
						scope.select_controlador[controller.id]=controller;						
									
					});
					var x = document.getElementsByClassName("label-floating");
        			var i;
			        $('#is-empty').val('disabled');
			        for (i = 0; i < x.length; i++) 
			        {
			            $(x[i]).removeClass('is-empty');
			        }
				}
				else
				{
					scope.spinner=0;
					scope.dni_busqueda=1;
					scope.tEditUSers={};
					scope.tEditUSers.dni=dni;
					scope.count_select_departamentos=0;		
					scope.count_select_carpetas=0;
					scope.count_select_controladores=0;
					scope.count_select_sistemas=0;
					scope.select_departamentos=[];
					scope.select_carpetas=[];
					scope.select_sistemas=[];
					scope.select_controlador=[];
					
				}
			});
		//}
		//else
		//{
		//	scope.spinner=0;
		//	scope.dni_busqueda=0;
		//}
	}
	scope.comprobar_usuario=function()
	{
		if(scope.tEditUSers.usuario!=undefined)
		{			
			scope.spinner_usuario=1;
			scope.usuario_buscar=0;
			//scope.email_comprobar=0;
			var url = base_urlHome()+"api/Usuarios/comprobar_usuario/usuario/"+scope.tEditUSers.usuario;
			$http.get(url).then(function(result)
			{
				data=result.data;
				if(data!=false)
				{				
					scope.spinner_usuario=0;
					scope.usuario_buscar=2;				
				}
				else
				{
					scope.spinner_usuario=0;
					scope.usuario_buscar=1;				
				}
			},function(error)
			{
				scope.spinner_usuario=0;
				scope.usuario_buscar=0;
				if(error.status==401 && error.statusText=="Unauthorized")
			{
				//$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" ); 
				bootbox.alert({
				message: "Está intentando entrar a un controlador al cual no tiene acceso",
				size: 'middle'});
				return false;
			}

			});
		}
		else
		{
			scope.spinner_usuario=0;
			scope.usuario_buscar=0;
		}
	}
	scope.comprobar_email=function()
	{
		if(scope.tEditUSers.correo_electronico!=undefined)
		{			
			scope.spinner_correo=1;
			scope.email_comprobar=0;
			var url = base_urlHome()+"/api/Usuarios/comprobar_correo/correo_electronico/"+scope.tEditUSers.correo_electronico;
			correo_electronico = scope.tEditUSers.correo_electronico;
			$http.get(url).then(function(result)
			{
				data=result.data;
				if(data!=false)
				{				
					scope.spinner_correo=0;
					scope.email_comprobar=2;				
				}
				else
				{
					scope.spinner_correo=0;
					scope.email_comprobar=1;				
				}
			},function(error)
			{
				if(error.status==401 && error.statusText=="Unauthorized")
			{
				scope.spinner_correo=0;
				scope.email_comprobar=0;
				//$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" ); 
				bootbox.alert({
				message: "Está intentando ingresar a un módulo al cual no tiene acceso",
				size: 'middle'});
				return false;
			}
			});
		}
		else
		{
			scope.spinner_correo=0;
			scope.email_comprobar=0;
		}
	}
	scope.comprobar_contrasena=function()
	{
		if(scope.tEditUSers.contrasena!=undefined && scope.tEditUSers.re_contrasena!=undefined)
		{
			if(scope.tEditUSers.contrasena!=scope.tEditUSers.re_contrasena)	
			{	
				scope.verificar_contrasena=2;
			}
			else
			{
				scope.verificar_contrasena=1;
			}
		}
		else
		{
			scope.verificar_contrasena=0;
		}
	}
	scope.guardar=function()
	{	
		$("#guardando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
 		//console.log(scope.tEditUSers);
		var url = base_urlHome()+"api/Usuarios/crear_usuario/";
		$http.post(url,scope.tEditUSers).success(function(data)
		{
			if(data!=false)
			{
				$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
					title:"Confirmación",
					message: "Se ha agregado correctamente el registro.",
					size: 'middle'});
				 	scope.buscar_dni();
			}
			else
			{
				$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			}
		});
	}


	scope.borrar=function()
	{
		bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro que desea eliminar este registro?",
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
				console.log('Cancelando Ando...');
			}     
			else
			{						
				var url = base_urlHome()+"api/Usuarios/borrar_usuario/id/"+scope.tEditUSers.id;
				$http.delete(url).success(function(data)
				{
					if(data!=false)
					{
						 bootbox.alert({
						message: "El registro ha sido eliminado correctamente",
						size: 'small'});
						 scope.limpiar();
						//scope.tUsers.splice(index,1);	
					}
					else
					{
						 bootbox.alert({
						message: "Ha ocurrido un error al intentar eliminar el registro",
						size: 'small'});
					}
				});	
			}
		}});
	}
	scope.borrar_row=function(index,id,metodo)
	{
		bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro que desea eliminar este registro?",
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
				console.log('Cancelando Ando...');
			}     
			else
			{						
				
				if(metodo==1)
				{
					var url = base_urlHome()+"api/Usuarios/borrar_usuario/id/"+id;
					$http.delete(url).success(function(data)
					{
						if(data!=false)
						{
							 bootbox.alert({
							 	title:"confirmación",
							message: "El registro ha sido eliminado correctamente",
							size: 'middle'});
							scope.tUsers.splice(index,1);	
						}
						else
						{
							bootbox.alert({
							title:"Error",
							message: "Hubo un error al intentar eliminar el registro",
							size: 'middle'});
						}
					});	
				}
				if(metodo==2)
				{
					var url = base_urlHome()+"api/Usuarios/borrar_usuario/id/"+id;
					$http.delete(url).success(function(data)
					{
						if(data!=false)
						{
							bootbox.alert({
							title:"Confirmación",
							message: "El registro ha sido eliminado correctamente",
							size: 'middle'});
							scope.tUsersActive.splice(index,1);	
						}
						else
						{
							bootbox.alert({
							title:"Confirmación",
							message: "Hubo un error al intentar eliminar el registro",
							size: 'middle'});
						}
					});	
				}
				if(metodo==3)
				{
					var url = base_urlHome()+"api/Usuarios/borrar_usuario/id/"+id;
					$http.delete(url).success(function(data)
					{
						if(data!=false)
						{
							 bootbox.alert({
							 	title:"Confirmación",
							message: "El registro ha sido eliminado correctamente.",
							size: 'middle'});
							scope.tUsersDisabled.splice(index,1);	
						}
						else
						{
							 bootbox.alert({
							 	title:"Confirmación",
							message: "Ha ocurrido un error al intentar eliminar el registro",
							size: 'middle'});
						}
					});	
				}
				
				
			}
		}});
	}

	scope.filtrar_departamentos=function()
	{
		var url = base_urlHome()+"api/Usuarios/filtrar_por_departamentos/hdepartamento/"+scope.tEditUSers.departamentos;
		$http.get(url).success(function(data)
		{
			if(data!=false)
			{
				$scope.predicate100 = 'id';  
				$scope.reverse100 = true;						
				$scope.currentPage100 = 1;  
				$scope.order100 = function (predicate100) 
				{  
					$scope.reverse100 = ($scope.predicate100 === predicate100) ? !$scope.reverse100 : false;  
					$scope.predicate100 = predicate100;  
				}; 						
				scope.tFiltroDepartamentos=data;					
				$scope.totalItems100 = scope.tFiltroDepartamentos.length; 
				$scope.numPerPage100 = 50;  
				$scope.paginate100 = function (value) 
				{  
					var begin100, end100, index100;  
					begin100 = ($scope.currentPage100 - 1) * $scope.numPerPage100;  
					end100 = begin100 + $scope.numPerPage100;  
					index100 = scope.tFiltroDepartamentos.indexOf(value);  
					return (begin100 <= index100 && index100 < end100);  
				};
				
			}
			else
			{
				bootbox.alert({
				title:"Notificación",
				message: "Este perfil no posee carpetas asociadas",
				size: 'middle'});
				scope.tFiltroDepartamentos=[];

			}
		});
	}
	
		
	scope.agregar_carpeta_detalle=function(index,id,datos)
	{		
		
		if(scope.count_select_carpetas>0)
		{
			console.log(scope.count_select_carpetas);
			console.log(scope.count_select_departamentos);

			scope.count_select_carpetas = (Math.max(parseFloat(scope.count_select_carpetas),0)+Math.max(parseFloat(1),0));
			//scope.count_select_departamentos=(scope.count_select_departamentos+1);
		}
		else
		{
			scope.count_select_carpetas+=1;
		}
		var objCarpetas = new Object();
		scope.select_carpetas[id]=datos;	
		if (scope.tEditUSers.detalle==undefined || scope.tEditUSers.detalle==false)
		{
			scope.tEditUSers.detalle = []; 
		}		
			scope.tEditUSers.detalle.push({id:datos.id,nombre_departamento:datos.nombre_departamento,hdepartamento:datos.hdepartamento,nombre_carpeta:datos.nombre_carpeta});
			console.log(scope.tEditUSers.detalle);
	}
	scope.agregar_departamentos=function(index,datos,hdepartamento)
	{		
		var url=base_urlHome()+"api/Usuarios/filtrar_por_perfiles/";
		$http.post(url,hdepartamento).success(function(data)
		{	
			if(data!=false)
			{
				var objPerfiles = new Object();	
				scope.select_departamentos[hdepartamento]=datos;	
				if (scope.tEditUSers.detalle_departamentos==undefined || scope.tEditUSers.detalle_departamentos==false)
				{
					scope.tEditUSers.detalle_departamentos = []; 
				}	
				if(scope.count_select_departamentos>0 && scope.tEditUSers.id>0 && data!=false)
				{
					scope.count_select_departamentos = (Math.max(parseFloat(scope.count_select_departamentos),0)+Math.max(parseFloat(1),0));			
				}
				else
				{
					scope.count_select_departamentos+=1;
				}
					scope.tEditUSers.detalle_departamentos.push({id:datos.id,nombre_departamento:datos.nombre_departamento});
					//console.log(data);
					/*if(scope.count_select_carpetas>0)
					{
						//console.log(scope.count_select_carpetas);
						//console.log(scope.count_select_departamentos);
						scope.count_select_carpetas = (Math.max(parseFloat(scope.count_select_carpetas),0)+Math.max(parseFloat(1),0));
						//scope.count_select_departamentos=(scope.count_select_departamentos+1);
					}
					else
					{
						scope.count_select_carpetas+=data.total_carpetas;
					}*/
					scope.count_select_carpetas = (Math.max(parseFloat(scope.count_select_carpetas),0)+Math.max(parseFloat(data.total_carpetas),0));
					var objCarpetas = new Object();
					angular.forEach(data.detalles, function(carpetas)
					{					
						scope.select_carpetas[carpetas.id]=carpetas;						
					});
					scope.select_carpetas[data.detalles.id]=data.detalles;
					if (scope.tEditUSers.detalle==undefined || scope.tEditUSers.detalle==false)
					{
						scope.tEditUSers.detalle = []; 
					}
					angular.forEach(data.detalles, function(detalles_carpetas)
					{					
						scope.tEditUSers.detalle.push({id:detalles_carpetas.id,nombre_departamento:detalles_carpetas.nombre_departamento,hdepartamento:detalles_carpetas.hdepartamento,nombre_carpeta:detalles_carpetas.nombre_carpeta});						
					});					
				}
				else
				{
					//alert('no se encontraron carpetas asociadas a este perfil');
					bootbox.alert({
							 	title:"Notificación",
							message: "Este perfil no posee carpetas asociadas",
							size: 'middle'});
				}

			});
	}
	scope.agregar_sistemas=function(index,datos,hsistema)
	{		
		if(scope.count_select_sistemas>0)
		{
			//console.log(scope.count_select_sistemas);

			scope.count_select_sistemas = (Math.max(parseFloat(scope.count_select_sistemas),0)+Math.max(parseFloat(1),0));
			//scope.count_select_departamentos=(scope.count_select_departamentos+1);
		}
		else
		{
			scope.count_select_sistemas+=1;
		}
		var objCarpetas = new Object();	
		scope.select_sistemas[hsistema]=datos;	

		if (scope.tEditUSers.detalle_sistemas==undefined || scope.tEditUSers.detalle_sistemas==false)
		{
			scope.tEditUSers.detalle_sistemas = []; 
		}		
			scope.tEditUSers.detalle_sistemas.push({id:datos.id,nombre_sistema:datos.nombre_sistema,url_sistema:datos.url_sistema});
			//console.log(scope.tEditUSers.detalle_sistemas);
	}
	scope.agregar_controlador=function(index,datos,hcontrolador)
	{		
		if(scope.count_select_controladores>0)
		{
			//console.log(scope.count_select_controladores);
			scope.count_select_controladores = (Math.max(parseFloat(scope.count_select_controladores),0)+Math.max(parseFloat(1),0));
			//scope.count_select_departamentos=(scope.count_select_departamentos+1);
		}
		else
		{
			scope.count_select_controladores+=1;
		}
		var objCarpetas = new Object();	
		scope.select_controlador[hcontrolador]=datos;	

		if (scope.tEditUSers.detalle_controlador==undefined || scope.tEditUSers.detalle_controlador==false)
		{
			scope.tEditUSers.detalle_controlador = []; 
		}		
			scope.tEditUSers.detalle_controlador.push({id:datos.id,controller:datos.controller});
			//console.log(scope.tEditUSers.detalle_controlador);
	}
	scope.quitarcontrolador = function(index,id,datos)
	{
		scope.count_select_controladores-=1;
		scope.select_controlador[id]=false;
		i=0;
		 for (var i = 0; i < scope.tEditUSers.detalle_controlador.length; i++) 
	       {
	           	if(scope.tEditUSers.detalle_controlador[i].id==id)
	        	{
		       		scope.tEditUSers.detalle_controlador.splice(i,1);
	           	}   			

			}
			//console.log(scope.tEditUSers.detalle_controlador);
	};
	scope.quitarcarpeta = function(index,id,datos)
	{
		scope.count_select_carpetas-=1;
		scope.select_carpetas[id]=false;
		i=0;
		 for (var i = 0; i < scope.tEditUSers.detalle.length; i++) 
	     {
	        if(scope.tEditUSers.detalle[i].id==id)
	       	{
		        scope.tEditUSers.detalle.splice(i,1);
	        }
	    }
			//console.log(scope.tEditUSers.detalle);
	};
	scope.quitarsistema = function(index,id,datos)
	{
		console.log(datos);
		
		//console.log(scope.tEditUSers.id);
		
	    if(scope.tEditUSers.id!=undefined)
	    {
	    	bootbox.confirm({
			title:"Confirmación",
			message: "¿Está seguro de eliminar el acceso a este sistema?. Al confirmar todas las crendenciales asociadas a este sistema seran borradas de forma automatica",
			buttons: {
			cancel: {
		    label: '<i class="fa fa-times"></i> Cancelar'
		    },
			confirm: {
			label: '<i class="fa fa-check"></i> Confirmar'
			}},
			callback: function (result) 
			{
				if (result==false) 
				{ 
					console.log('Cancelando Ando...');
				}     
				else
				{						
					$("#quitando_sistemas").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
			    	scope.consultar_credenciales={};
			    	scope.consultar_credenciales.hsistema=id;
			    	scope.consultar_credenciales.huser=scope.tEditUSers.id;
			    	console.log(scope.consultar_credenciales);
			    	//alert('esta pasando por aqui vamos bien.');
			    	var url = base_urlHome()+"api/Usuarios/buscar_borrar_acceso_credenciales";
			    	$http.post(url,scope.consultar_credenciales).then(function(result)
			    	{
			    		if(result.data!=false)
			    		{
			    			$("#quitando_sistemas").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
			    		}
			    		else
			    		{
			    			$("#quitando_sistemas").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );	
			    		}

			    	},function(error)
			    	{	
			    		//console.log(error);
						if(error.status==404 && error.statusText=="Not Found")
						{
							$("#quitando_sistemas").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "El método que está intentando usar no puede ser localizado",
							size: 'middle'});
						}
						if(error.status==401 && error.statusText=="Unauthorized")
						{
							$("#quitando_sistemas").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo",
							size: 'middle'});
						}
						if(error.status==403 && error.statusText=="Forbidden")
						{
							$("#quitando_sistemas").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Está intentando usar un APIKEY inválido",
							size: 'middle'});
						}
						if(error.status==500 && error.statusText=="Internal Server Error")
						{
							$("#quitando_sistemas").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default " );
							bootbox.alert({
							message: "Actualmente tenemos fallas en el servidor, por favor intente más tarde",
							size: 'middle'});
						}
			    	});			
				}
			}});	
	    }
	    else
	    {
	    	scope.count_select_sistemas-=1;
			scope.select_sistemas[id]=false;
			i=0;
			for (var i = 0; i < scope.tEditUSers.detalle_sistemas.length; i++) 
		    {
		        if(scope.tEditUSers.detalle_sistemas[i].id==id)
		        {
			       	scope.tEditUSers.detalle_sistemas.splice(i,1);
		        }
		    }
	    }
		//console.log(scope.tEditUSers.detalle_sistemas);
	};
	scope.quitardepartamento = function(index,hdepartamento,datos,all_datos)
	{
		scope.count_select_departamentos-=1;
		scope.select_departamentos[hdepartamento]=false;
		i=0;
		for (var i = 0; i < scope.tEditUSers.detalle_departamentos.length; i++) 
	    {
	        if(scope.tEditUSers.detalle_departamentos[i].id==hdepartamento)
	        {
		       	scope.tEditUSers.detalle_departamentos.splice(i,1);
	         }
		}
		
		/*var url = base_urlHome()+"api/Usuarios/count_carpetas/";
		$http.post(url,hdepartamento).success(function(data)
		{
			if(data!=false)
			{
				for (var j = 0; j < scope.tEditUSers.detalle.length; j++) 
			    {
			        if(scope.tEditUSers.detalle[j].hdepartamento==hdepartamento)
			        {
				       scope.tEditUSers.detalle.splice(j,data.total_carpetas);
			        }
			        //console.log(j);
				}
				scope.count_select_carpetas-=data.total_carpetas;
			}
		});	*/

		
			
			
			
		};
	scope.quitardetalledepartamentos = function(dato)
	{
		scope.tEditUSers.detalle_departamentos.splice(dato,1);
	};
	scope.quitardetalleseleccionadas = function(index,datos)
	{
		console.log(index);
		console.log(datos);
		scope.tEditUSers.detalle.splice(index,1);
	};
	scope.validar = function()
	{
		resultado = true;			
		if (!scope.tEditUSers.detalle_departamentos.length>0)
		{
			bootbox.alert({
				title:"Departamentos",
		    message: "Debe Asignarle por lo menos un departamento al usuario que está intentando registrar",
		    size: 'middle'});					
			return false;
		}
		if (!scope.tEditUSers.detalle.length>0)
		{
			bootbox.alert({
				title:"Carpetas",
		    message: "Debe Asignarle por lo menos una carpeta al usuario que está intentado registrar",
		    size: 'middle'});					
			return false;
		}
		if (!scope.tEditUSers.detalle_sistemas.length>0)
		{
			bootbox.alert({
				title:"Sistemas",
		    message: "Debe Asignarle por lo menos un sistema al usuario que está intentado registrar",
		    size: 'middle'});					
			return false;
		}
			
				if (resultado == false)
				{				
					return false;
				} 
				return true;
			}
	scope.validar_credenciales = function()
	{
		resultado = true;			
		if (!scope.credenciales.usuario_sistema>0)
		{
			bootbox.alert({
			message: "Debe indicar un nombre de usuario para esta credencial",
		    size: 'middle'});					
			return false;
		}
		if (!scope.credenciales.contrasena_sistema>0)
		{
			bootbox.alert({
		    message: "Debe indicar una contraseña para esta credencial",
		    size: 'middle'});					
			return false;
		}
		if (!scope.credenciales.notas>0)
		{
			bootbox.alert({
		    message: "Debe indicar una nota acerca de la credencial",
		    size: 'middle'});					
			return false;
		}
					
		if (resultado == false)
		{				
			return false;
		} 
		return true;
	}
	scope.limpiar=function()
	{	
		scope.tEditUSers={};
		scope.credencial={};
		scope.tEditUSers.dni=undefined;
		scope.tEditUSers.usuario=undefined;
		scope.tEditUSers.correo_electronico=undefined;
		scope.spinner=0;
		scope.dni_busqueda=0;	
		scope.spinner_usuario=0;	
		scope.usuario_buscar=0;		
		scope.spinner_correo=0;
		scope.email_comprobar=0;
		scope.verificar_contrasena=0;
		scope.filtro=4;
		scope.tFiltroDepartamentos=null;
		scope.count_select_departamentos=0;		
		scope.count_select_carpetas=0;
		scope.count_select_controladores=0;
		scope.count_select_sistemas=0;
		scope.select_departamentos=[];
		scope.select_carpetas=[];
		scope.select_sistemas=[];
		scope.select_controlador=[];
	}
	scope.validar_usuario_credenciales=function()
	{				
		if(scope.credenciales.usuario_sistema!=null)
		{
			scope.credencial=0;			
			console.log(scope.credenciales.usuario_sistema);
			$("#comprobando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
			var url = base_urlHome()+"api/Usuarios/verificar_credencial_sistema/";
			scope.spinner_credenciales=1;
			$http.post(url,scope.credenciales).then(function(result)
			{
				console.log(result.data);
				if(result.data==true)
				{
					console.log('Este usuario ya se encuentra en uso, utilice uno diferente');
					scope.spinner_credenciales=0;
					scope.credencial=2;
				}
				else
				{
					console.log('Usuario Disponible');
					scope.spinner_credenciales=0;
					scope.credencial=1;
				}
			},function(error)
			{
				if(error.status==404 && error.statusText=="Not Found")
				{
					bootbox.alert({
					message: "El método que esté intentando usar no puede ser localizado",
					size: 'middle'});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					bootbox.alert({
					message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo",
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
					message: "Actualmente estamos prensentado fallas en el servidor. Por favor intente mas tarde.",
					size: 'middle'});
				}
			});
			$("#comprobando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );	
		}
		else
		{
			scope.spinner_credenciales=0;
			scope.credencial=0;
		}	
	}

$scope.SubmitContrasena = function(event) 
	{      
	 	//console.log(scope.tEditUSers);	 	
	 	scope.cambio_contra.huser=scope.tEditUSers.id;	 	
	 	bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro de cambiar la contraseña del empleado?",
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
				//console.log(scope.cambio_contra);
				var url = base_urlHome()+"api/Usuarios/Cambiar_Contrasena";
				$http.post(url,scope.cambio_contra).then(function(result)
				{
					if(result.data!=false)
					{
						$("#modal_cambio_contrasena").modal('hide');
						scope.cambio_contra={};
						bootbox.alert({
						message: "Contraseña Actualizada con Exito",
						size: 'middle'}); 
					}
					else
					{
						bootbox.alert({
						message: "Ha ocurrido un error al intentar actualizar la contraseña por favor intente nuevamente",
						size: 'middle'});
					}

				},function(error)
				{
					if(error.status==404 && error.statusText=="Not Found")
					{
						bootbox.alert({
						message: "El método que esté intentando usar no puede ser localizado",
						size: 'middle'});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						bootbox.alert({
						message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo",
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
						message: "Actualmente estamos prensentado fallas en el servidor. Por favor intente mas tarde.",
						size: 'middle'});
					}
				});
				
				
			}
		}});
					
	}; 					
};