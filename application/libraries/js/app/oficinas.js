app.controller('Controlador_Oficinas', ['$http', '$scope','$cookies','$route','$filter','$cookieStore','netTesting', Controlador]);
function Controlador($http , $scope ,$cookies, $route,$filter,$cookieStore,netTesting){
	
	var scope = this;
	scope.fdatos = {}; // datos del formulario
	scope.tOficinas=null; // datos de todos los Oficinas activos o desactivos
	scope.tOficinasActive=null; // datos de los Oficinas activos
	scope.tOficinasDisabled=null; // datos de los Oficinas desactivados
	scope.tEditOficinas={}; // datos del formulario para agregar Oficinas
	//scope.nID = $route.current.params.ID;  //contiene el id del registro en caso de estarse consultando desde la grid
	scope.ApiKey = $cookies.get('ApiKey'); 
	scope.nivel_users = $cookies.get('nivel');
	scope.id = $cookies.get('id');
	scope.estatus=[{id:1 , nombre:"Activo"}, {id:2 , nombre:"Desactivada"}]	
	scope.index  = 0;
	scope.filtro=0;	
	scope.spinner=0;
	scope.dni_busqueda=0;	
	scope.spinner_usuario=0;	
	scope.usuario_buscar=0;	
	scope.spinner_correo=0;
	scope.email_comprobar=0;
	scope.verificar_contrasena=0;
	
	$scope.submitForm = function(event) 
	{      
	 	bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro que desea incluir este registro?",
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
	scope.office_all=function()
	{
		scope.filtro=0;

		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
		var x = document.getElementsByClassName("status-task");
        var i;
        $('#active_status').val('active');
        for (i = 0; i < x.length; i++) 
        {
            $(x[i]).removeClass('active-status');
        }
        $('#all_active').addClass('active-status');
		var url = base_urlHome()+"api/Oficinas/get_office/";
		$http.get(url).then(function(result)
		{	
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
				scope.tOficinas=data;
				$scope.totalItems = scope.tOficinas.length; 
				$scope.numPerPage = 50;  
				$scope.paginate = function (value) 
				{  
					var begin, end, index;  
					begin = ($scope.currentPage - 1) * $scope.numPerPage;  
					end = begin + $scope.numPerPage;  
					index = scope.tOficinas.indexOf(value);  
					return (begin <= index && index < end);  
				}; 
			}
			else
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				scope.tOficinas=null;
			}
		},function(error)
		{
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
		});
	}
	scope.office_active=function()
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
		
		var url = base_urlHome()+"api/Oficinas/get_office_active/";
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
				scope.tOficinasActive=data;
				$scope.totalItems2 = scope.tOficinasActive.length; 
				$scope.numPerPage2 = 50;  
				$scope.paginate2 = function (value) 
				{  
					var begin2, end2, index2;  
					begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;  
					end2 = begin2 + $scope.numPerPage2;  
					index2 = scope.tOficinasActive.indexOf(value);  
					return (begin2 <= index2 && index2 < end2);  
				}; 
			}
			else
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				scope.tOficinasActive=null;
			}
		},function(error)
		{
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
		});
	}
	scope.office_disabled=function()
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
		var url = base_urlHome()+"api/Oficinas/get_office_disabled/";
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
				scope.tOficinasDisabled=data;
				$scope.totalItems3 = scope.tOficinasDisabled.length; 
				$scope.numPerPage3 = 50;  
				$scope.paginate3 = function (value) 
				{  
					var begin3, end3, index3;  
					begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;  
					end3 = begin3 + $scope.numPerPage3;  
					index3 = scope.tOficinasDisabled.indexOf(value);  
					return (begin3 <= index3 && index3 < end3);  
				}; 
			}
			else
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				scope.tOficinasDisabled=null;
			}
		},function(error)
		{
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
		});
	}
	scope.edit_office=function(dato)
	{
		scope.filtro=4;
		scope.usuario_buscar=0;
		scope.spinner=0;
		scope.dni_busqueda=0;	
		scope.spinner_usuario=0;	
		scope.usuario_buscar=0;	
		scope.spinner_correo=0;
		scope.email_comprobar=0;
		scope.verificar_contrasena=0;
		var x = document.getElementsByClassName("label-floating");
        var i;
        $('#is-empty').val('disabled');
        for (i = 0; i < x.length; i++) 
        {
            $(x[i]).removeClass('is-empty');
        }
      	scope.tEditOficinas=dato;			
	}
	scope.agregar_office=function()
	{
		scope.dni_busqueda=0;
		scope.usuario_buscar=0;
		scope.email_comprobar=0;
		scope.verificar_contrasena=0;
		scope.filtro=4;
		scope.tEditOficinas={};
		
		var x = document.getElementsByClassName("label-floating");
        var i;
        $('#is-focused').val('disabled');
        for (i = 0; i < x.length; i++) 
        {
            $(x[i]).addClass('is-empty');
        }

	}
	
	scope.guardar=function()
	{
		$("#guardando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
 		//console.log(scope.tEditOficinas);
		var url = base_urlHome()+"api/Oficinas/create_office/";
		$http.post(url,scope.tEditOficinas).then(function(result)
		{
			data=result.data;
			if(data!=false)
			{
				$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				scope.tEditOficinas=data;					
			}
			else
			{
				$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			}
		},function(error)
		{
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" ); 
				bootbox.alert({
				message: "Está intentando ingresar a un módulo al cual no tiene acceso",
				size: 'middle'});
				return false;
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#guardando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" ); 
				bootbox.alert({
				message: "Error de Seguridad, está intentando ingresar al sistema con un <b>ApiKey</b>. inválido",
				size: 'middle'});
				return false;
			}
		});
	}
	scope.limpiar=function()
	{	
		scope.tEditOficinas={};
		scope.tEditOficinas.dni=undefined;
		scope.tEditOficinas.usuario=undefined;
		scope.tEditOficinas.correo_electronico=undefined;
		scope.spinner=0;
		scope.dni_busqueda=0;	
		scope.spinner_usuario=0;	
		scope.usuario_buscar=0;		
		scope.spinner_correo=0;
		scope.email_comprobar=0;
		scope.verificar_contrasena=0;
		scope.filtro=4;

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
				var url = base_urlHome()+"api/Oficinas/delete_office/id/"+scope.tEditOficinas.id;
				$http.delete(url).success(function(data)
				{
					if(data!=false)
					{
						 bootbox.alert({
						 	title:"Confirmación",
						message: "El registro ha sido eliminado correctamente",
						size: 'small'});
						 scope.limpiar();
						//scope.tOficinas.splice(index,1);	
					}
					else
					{
						 bootbox.alert({
						 	title:"Error",
						message: "Hubo un error al intentar eliminar el registro o se encuentra asociado a un usuario y no puede ser eliminado",
						size: 'middle'});
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
					var url = base_urlHome()+"api/Oficinas/delete_office/id/"+id;
					$http.delete(url).success(function(data)
					{
						if(data!=false)
						{
							 bootbox.alert({
							 	title:"Confirmación",
							message: "El registro ha sido eliminado correctamente",
							size: 'small'});
							scope.tOficinas.splice(index,1);	
						}
						else
						{
							 bootbox.alert({
							 	title:"Error",
							message: "Hubo un error al intentar eliminar el registro o se encuentra asociado a un usuario y no puede ser eliminado",
							size: 'middle'});
						}
					});	
				}
				if(metodo==2)
				{
					var url = base_urlHome()+"api/Oficinas/delete_office/id/"+id;
					$http.delete(url).success(function(data)
					{
						if(data!=false)
						{
							 bootbox.alert({
							 	title:"Confirmación",
							message: "El registro ha sido eliminado correctamente",
							size: 'small'});
							scope.tOficinasActive.splice(index,1);	
						}
						else
						{
							 bootbox.alert({
							 	title:"Error",
							message: "Hubo un error al intentar eliminar el registro o se encuentra asociado a un usuario y no puede ser eliminado",
							size: 'middle'});
						}
					});	
				}
				if(metodo==3)
				{
					var url = base_urlHome()+"api/Oficinas/delete_office/id/"+id;
					$http.delete(url).success(function(data)
					{
						if(data!=false)
						{
							 bootbox.alert({
							 	title:"Confirmación",
							message: "El registro ha sido eliminado correctamente",
							size: 'small'});
							scope.tOficinasDisabled.splice(index,1);	
						}
						else
						{
							 bootbox.alert({
							 	title:"Error",
							message: "Hubo un error al intentar eliminar el registro o se encuentra asociado a un usuario y no puede ser eliminado",
							size: 'middle'});
						}
					});	
				}
				
				
			}
		}});
	}
					
};
/**/