<html lang="en">
<head>
   <?php $this->load->view('view_header');?>
</head>
<body> 
<div ng-app="appPrincipal">
<?php $this->load->view('templates/side_menu');?>    
<div class="container" ng-controller="CtrlUsuariosController as vm">
    <div class="tab-content">
    <h2  id="t-0000" style="margin-top: 0px;"><i class="fa fa-users"></i> Usuarios</h2>
    <div id="t-0001">
        <div id="t-0002">
            <div class="t-0029">
                   <button style=" float: left;margin-left: 15px;padding: 10px;margin-top: 1px;margin-bottom: 2px;" class="btn btn-info " ng-click="vm.agregar_usuarios()" id="addTask" ><i class="fa fa-plus"></i> Agregar</button>

                </div> 
                
                <div style="float:left; margin-top: 8px;" class="removeForMobile">
                   
                    <div class="t-0029">
                            <div class="t-0031" style="margin-top: -8px; ">
                                <button style="" class="btn t-0032 status-task active-status" id="all_active" ng-click="vm.all_usuarios()"><i class="fa fa-clone"></i> Todos</button>
                                <button style="" class="btn t-0032 status-task" id="active" ng-click="vm.users_active()"><i class="fa fa-check-circle"></i> Activos</button>
                                <button style="" class="btn t-0032 status-task" id="all_disabled" ng-click="vm.users_disabled()"><i class="fa fa-close"></i> Inactivos</button>
                            </div>
                        </div>              
                 
                                    </div>
                                </div>
           
            <div id="t-0003">               
                <br>      
        <div ng-show="vm.filtro==0">            
        
        <div class="bd bd-gray-300 rounded table-responsive" ng-init="vm.all_usuarios()">
            <table class="table table-hover mg-b-0"> 
                <thead>
                    <tr>
                   
                    <td><i class="fa fa-user"></i> Nombre y Apellidos</td>
                    <td><i class="fa fa-users"></i> Usuario</td>
                    <td><i class="fa fa-envelope-open"></i> Correo Electrónico</td>
                    <td><i class="fa fa-industry"></i> Nivel</td>
                    <td><i class="fa fa-dot-circle-o"></i> Est.</td>
                    <td><i class="fa fa-dedent"></i> Acción</td>
                </tr>
                </thead>
                <tbody >
                      <tr ng-show="vm.tUsers==null"> 
                     <td colspan="7" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>           
                    </tr>
                    <tr ng-repeat="dato in vm.tUsers | filter:paginate | filter:search" ng-class-odd="odd"> 
                    
                    <td><div class="td-usuario-table">{{dato.nombres}} {{dato.apellidos}}</div></td>
                    <td><div class="td-usuario-table">{{dato.usuario}}</div></td>
                    <td><div class="td-usuario-table">{{dato.correo_electronico}}</div></td>
                    <td>
                       <div class="td-usuario-table" ng-show="dato.nivel==1"><img  src="application/libraries/estilos/img/SuperAdmin.png" width="50" height="50" style="border-radius: 5px;"> SuperAdmin</div>
                        <div class="td-usuario-table" ng-show="dato.nivel==2"><img src="application/libraries/estilos/img/Coordinadores.png" width="50" height="50" style="border-radius: 5px;"> Coordinador</div>
                        <div class="td-usuario-table" ng-show="dato.nivel==3"><img  src="application/libraries/estilos/img/Estandar.png" width="50" height="50" style="border-radius: 5px;"> Estandar</div> 
                    </td>
                    <td><div class="td-usuario-table"><label ng-show="dato.bloqueado==1" style="color:green; text-align: center;"><i class="fa fa-check-circle"></i> Activo</label><label ng-show="dato.bloqueado==2"  style="color:red; text-align: center;"><i class="fa fa-close"></i> Desactivado</label></div></td>
                    <td>

                    	<a ng-click="vm.edit_users(dato)" title='Editar Usuario {{dato.nombres}} {{dato.apellidos}}' class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-edit" style="color:white;"></i></div></a>
                   		<a ng-click="vm.borrar_row($index,dato.id,1)" ng-show="vm.nivel_users==1" title='Eliminar Usuario {{dato.nombres}} {{dato.apellidos}}' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a>
                	</td>
                </tr>                   
                </tbody>
            </table>
        </div>  
           <div align="center">
              <span class="store-qty"> <a ng-click="vm.all_usuarios()" title='Refrescar' class="btn btn-warning btn-icon mg-r-5"><div><i class="fa fa-refresh" style="color:white;"></i></div></a>        

              <div class='btn-group' align="center">
                      <pagination total-items="totalItems" ng-model="currentPage"  
                    max-size="5" boundary-links="true"  
                    items-per-page="numPerPage" class="pagination-sm">  
              </pagination>
                    </div>
            </div>
        </div> 
        
        <div ng-show="vm.filtro==1">        
        <div class="bd bd-gray-300 rounded table-responsive">
            <table class="table table-hover mg-b-0"> 
                <thead>
                    <tr>
                   <td><i class="fa fa-user"></i> Nombre y Apellidos</td>
                    <td><i class="fa fa-users"></i> Usuario</td>
                    <td><i class="fa fa-at"></i> Correo Electrónico</td>
                    <td><i class="fa fa-industry"></i> Nivel</td>
                    <td><i class="fa fa-dot-circle-o"></i> Estatus</td>
                    <td><i class="fa fa-dedent"></i> Acción</td>
                </tr>
                </thead>
                <tbody>
                     <tr ng-show="vm.tUsersActive==null"> 
                     <td colspan="7" align="center"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</td>                   
                    </tr>
                    <tr ng-repeat="dato in vm.tUsersActive | filter:paginate2 | filter:search" ng-class-odd="odd"> 
                    
                    <td><div class="td-usuario-table">{{dato.nombres}} {{dato.apellidos}}</div></td>
                    
                    <td><div class="td-usuario-table">{{dato.usuario}}</div></td>
                    <td><div class="td-usuario-table">{{dato.correo_electronico}}</div></td>
                     <td>
                       <div class="td-usuario-table" ng-show="dato.nivel==1"><img  src="application/libraries/estilos/img/SuperAdmin.png" width="50" height="50" style="border-radius: 5px;"> SuperAdmin</div>
                        <div class="td-usuario-table" ng-show="dato.nivel==2"><img src="application/libraries/estilos/img/Coordinadores.png" width="50" height="50" style="border-radius: 5px;"> Coordinador</div>
                        <div class="td-usuario-table" ng-show="dato.nivel==3"><img  src="application/libraries/estilos/img/Estandar.png" width="50" height="50" style="border-radius: 5px;"> Estandar</div>
                       

                    </td>

                    <td><div class="td-usuario-table"> <label ng-show="dato.bloqueado==1" style="color:green;"><i class="fa fa-check-circle"></i> Activo</label></div></td>
                    <td>


                    	<a ng-click="vm.edit_users(dato)" title='Editar Usuario {{dato.nombres}} {{dato.apellidos}}' class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-edit" style="color:white;"></i></div></a>
                    	<a ng-click="vm.borrar_row($index,dato.id,2)" ng-show="vm.nivel_users==1" title='Eliminar Usuario {{dato.nombres}} {{dato.apellidos}}' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a> 
                    </td>
                </tr>                   
                </tbody>
            </table>
        </div>  
           <div align="center">
              <span class="store-qty"> <a ng-click="vm.users_active()" title='Refrescar' class="btn btn-warning btn-icon mg-r-5"><div><i class="fa fa-refresh" style="color:white;"></i></div></a>        

              <div class='btn-group' align="center">
                      <pagination total-items="totalItems2" ng-model="currentPage2"  
                    max-size="5" boundary-links="true"  
                    items-per-page="numPerPage2" class="pagination-sm">  
              </pagination>
                    </div>
            </div>
        </div>
    
         <div ng-show="vm.filtro==2">        
        <div class="bd bd-gray-300 rounded table-responsive">
            <table class="table table-hover mg-b-0"> 
                <thead>
                    <tr>
                    <td><i class="fa fa-user"></i> Nombre y Apellidos</td>
                    <td><i class="fa fa-users"></i> Usuario</td>
                    <td><i class="fa fa-at"></i> Correo Electrónico</td>
                    <td><i class="fa fa-industry"></i> Nivel</td>
                    <td><i class="fa fa-dot-circle-o"></i> Estatus</td>
                    <td><i class="fa fa-dedent"></i> Acción</td>
                </tr>
                </thead>
                <tbody>
                     <tr ng-show="vm.tUsersDisabled==null"> 
                     <td colspan="7" align="center"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</td>                   
                    </tr> 
                    <tr ng-repeat="dato in vm.tUsersDisabled | filter:paginate3 | filter:search" ng-class-odd="odd"> 
                    
                    <td><div class="td-usuario-table">{{dato.nombres}} {{dato.apellidos}}</div></td>                    
                    <td><div class="td-usuario-table">{{dato.usuario}}</div></td>
                    <td><div class="td-usuario-table">{{dato.correo_electronico}}</div></td>
                     <td>
                       <div class="td-usuario-table" ng-show="dato.nivel==1"><img  src="application/libraries/estilos/img/SuperAdmin.png" width="50" height="50" style="border-radius: 5px;"> SuperAdmin</div>
                        <div class="td-usuario-table" ng-show="dato.nivel==2"><img src="application/libraries/estilos/img/Coordinadores.png" width="50" height="50" style="border-radius: 5px;"> Coordinador</div>
                        <div class="td-usuario-table" ng-show="dato.nivel==3"><img  src="application/libraries/estilos/img/Estandar.png" width="50" height="50" style="border-radius: 5px;"> Estandar</div>
                       

                    </td>
                    <td><div class="td-usuario-table"><label ng-if="dato.bloqueado==2" style="color:red;"><i class="fa fa-close"></i> Desactivado</label></div></td>
                    <td>
                    	<a ng-click="vm.edit_users(dato)" title='Editar Usuario {{dato.nombres}} {{dato.apellidos}}' class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-edit" style="color:white;"></i></div></a>
                    	<a ng-click="vm.borrar_row($index,dato.id,3)" ng-show="vm.nivel_users==1" title='Eliminar Usuario {{dato.nombres}} {{dato.apellidos}}' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a> 
                    </td>
                </tr>                   
                </tbody>
            </table>
        </div>  
           <div align="center">
              <span class="store-qty"> <a ng-click="vm.users_disabled()" title='Refrescar' class="btn btn-warning"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       

              <div class='btn-group' align="center">
                      <pagination total-items="totalItems3" ng-model="currentPage3"  
                    max-size="5" boundary-links="true"  
                    items-per-page="numPerPage3" class="pagination-sm">  
              </pagination>
                    </div>
            </div>
        </div> 
        
          <div ng-show="vm.filtro==4">
        <form id="frmclientes" name="frmclientes" ng-submit="submitForm($event)" autocomplete="off">	

			<h2 ng-show="vm.tEditUSers.id==undefined" align="center"><i class="fa fa-plus"></i> Registro de Usuario</h2>
                            <h2 ng-show="vm.tEditUSers.id>0" align="center"><i class="fa fa-database"></i> Actualización de datos</h2>
           <div id="DivFormCustomer" class="col-sm-12" style="clear: both; padding: 15px;">
                        <div id="DivFormCustomer2" class="col-sm-12" style=" background-color: #fff;">                            
                            <div class="col-sm-6" style="">
                                <div>
                                     <div class="input-group">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-blind"></i> Nombre</label>
                                            <input name="nombres" id="nombres" type="text"class="form-control" ng-model="vm.tEditUSers.nombres" required>
                                        <span class="material-input"></span></div>
                                    </div>
                                    <div class="input-group">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-blind"></i> Apellidos </label>
                                            <input name="apellidos" id="apellidos" type="text" class="form-control" ng-model="vm.tEditUSers.apellidos" required>
                                        <span class="material-input"></span></div>
                                    </div>
                                    <div class="input-group">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-user"></i> Usuario </label>
                                            <input name="usuario" id="usuario" type="text" maxlength="100" onpaste="return false" oncut="return false" autocomplete="off" class="form-control" ng-model="vm.tEditUSers.usuario" required ng-blur="vm.comprobar_usuario()" >

                                            <span class="material-input" ng-show="vm.spinner_usuario==1"><img src="application/libraries/estilos/img/ajax-loader.gif"> Comprobando Usuario, Por Favor Espere...</span>
                                        	<span class="material-input" ng-show="vm.usuario_buscar==1" style="color:green;"><i class="fa fa-check-circle"></i> Usuario Disponible...</span>
                                        	<span class="material-input" ng-show="vm.usuario_buscar==2" style="color:red;"><i class="fa fa-close"></i> Usuario Registrado...</span>                                	
                                        
                                        </div>
                                    </div>
                                    
                                    <div class="input-group">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-envelope-open"></i> Email</label>
                                            <input name="correo_electronico" id="correo_electronico" type="email" class="form-control" ng-model="vm.tEditUSers.correo_electronico" required ng-blur="vm.comprobar_email()" maxlength="100" onpaste="return false" oncut="return false" autocomplete="off">
                                        <span class="material-input" ng-show="vm.spinner_correo==1"><img src="application/libraries/estilos/img/ajax-loader.gif"> Comprobando Correo Electrónico, Por Favor Espere...</span>
                                        	<span class="material-input" ng-show="vm.email_comprobar==1" style="color:green;"><i class="fa fa-check-circle"></i> Correo Electrónico Disponible...</span>
                                        	<span class="material-input" ng-show="vm.email_comprobar==2" style="color:red;"><i class="fa fa-close"></i> Correo Electrónico Registrado en otro Usuario...</span>
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-flash"></i> Nivel</label>
                                            <select name="nivel" id="nivel" class="form-control" ng-disabled="vm.nivel_users!=1 && vm.tEditUSers.id>0" required ng-model="vm.tEditUSers.nivel"><option ng-repeat="opcion in vm.nivel"value="{{opcion.id}}">{{opcion.nombre}}</option></select>
                                        <span class="material-input"></span></div>
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-6" style="">
                                <div>
                                    <div class="input-group" ng-show="vm.tEditUSers.id==undefined">
                                        <div class="form-group label-floating is-empty">
                                             <label class="control-label"><i class="fa fa-key"></i> Contraseña</label>
                                            <input name="contrasena" id="contrasena" type="password" class="form-control" ng-model="vm.tEditUSers.contrasena" ng-change="vm.comprobar_contrasena()" maxlength="100" onpaste="return false" oncut="return false" autocomplete="off">
                                        <span class="material-input"></span></div>
                                    </div>
                                    <div class="input-group" ng-show="vm.tEditUSers.id==undefined">
                                        <div class="form-group label-floating is-empty">
                                             <label class="control-label"><i class="fa fa-key"></i> Confirmar Contraseña</label>
                                            <input name="re_contrasena" id="re_contrasena" type="password" class="form-control" ng-model="vm.tEditUSers.re_contrasena" ng-change="vm.comprobar_contrasena()">
                                        <span class="material-input" ng-show="vm.verificar_contrasena==1" style="color:green;"><i class="fa fa-check-circle"></i> Sus Contraseñas Coinciden...</span>
                                        <span class="material-input" ng-show="vm.verificar_contrasena==2" style="color:red;"><i class="fa fa-close"></i> Sus Contraseñas No Coinciden...</span>
                                        </div>
                                    </div>
                                    <!--div class="input-group">
                                        <div class="form-group label-floating is-empty">
                                             <label class="control-label">Telefono</label>
                                            <input name="telefono" id="telefono" type="text" class="form-control" ng-model="vm.tEditUSers.telefono" >
                                        <span class="material-input"></span></div>
                                    </div-->
                                    <div class="input-group">
                                        <div class="form-group label-floating is-empty">
                                             <label class="control-label"><i class="fa fa-home"></i> Oficina</label>
                                            <select name="hoficina" class="form-control" required ng-model="vm.tEditUSers.hoficina"><option ng-repeat="opcion in vm.Oficinas"value="{{opcion.id}}">{{opcion.nombre_oficina}}</option></select>
                                        <span class="material-input"></span></div>
                                    </div>                                    
                                    <div class="input-group">
                                        <div class="form-group label-floating is-empty">
                                           <label class="control-label"><i class="fa fa-dot-circle-o"></i> Estatus</label>
                                            <select name="bloqueado" id="bloqueado" class="form-control"  required ng-model="vm.tEditUSers.bloqueado"><option ng-repeat="opcion in vm.bloqueado"value="{{opcion.id}}">{{opcion.nombre}}</option></select>
                                        <span class="material-input"></span></div>
                                    </div>                                    
                                    <div class="input-group" ng-show="vm.tEditUSers.id>0 && vm.nivel_users==1">
                                       <div align="center">
                                           <a data-toggle="modal" title='Cambiar Contraseña' data-target="#modal_cambio_contrasena" class="btn btn-warning btn-icon mg-r-5"><div><i class="fa fa-key" style="color:white;"></i></div></a>
                                       </div>

                                    </div> 
                                </div>
                            </div>
                           
                            <input type="hidden" name="id" id="id" ng-model="vm.tEditUSers.id" readonly>
                        </div>
                         <hr>
                <!--div class="bd bd-gray-300 rounded table-responsive" ng-init="vm.departamentos()" ng-show="vm.tDepartamentos!=null">
                   <h3 align="center">Asignar Perfiles:</h3>
    		   <div class="bd bd-gray-300 rounded table-responsive" align="center">
                   
             	 <a data-toggle="modal" title='Perfiles Seleccionados' data-target="#modal_departamentos_seleccionados" class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-eye" style="color:white;"></i></div></a> <label><span style="color:black; font-size: 24;">{{vm.count_select_departamentos}}</span></label>            
           

                </div>     
                    <table class="table table-hover mg-b-0"> 
                     <thead>
                    <tr>
                    
                    <td><i class="fa fa-bank"></i> Perfiles</td>                                        
                    <td><i class="fa fa-dot-circle-o"></i> Acción</td>
                </tr>
                </thead>
                <tbody>
                  
                    <tr ng-repeat="dato in vm.tDepartamentos | filter:paginate20" ng-class-odd="odd"> 
                    
                    <td>{{dato.nombre_departamento}}</td>                                
                    <td> 
                        <a ng-show="!vm.select_departamentos[dato.id]" ng-click="vm.agregar_departamentos($index,dato,dato.id)" title='Agregar Perfil {{dato.nombre_departamento}}' class="btn btn-success btn-icon mg-r-5"><div><i class="fa fa-check-circle" style="color:white;"></i></div></a>                      
                       

                        <a ng-show="vm.select_departamentos[dato.id]" ng-if="vm.nivel_users==1" ng-click="vm.quitardepartamento($index,dato.id,dato,vm.tDepartamentos)" title='Eliminar Perfil {{dato.nombre_departamento}}' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a> 
                    </td>
                </tr>                   
                </tbody>
            </table> <div align="center">                  

              <div class='btn-group' align="center">
                      <pagination total-items="totalItems20" ng-model="currentPage20"  
                    max-size="5" boundary-links="true"  
                    items-per-page="numPerPage20" class="pagination-sm">  
              </pagination>
                    </div>
            </div>
        </div--> 
                     
              
        <hr>
                <div class="bd bd-gray-300 rounded table-responsive" ng-init="vm.controladores()">
                   <h3 align="center">Asignar Módulos:</h3>
    		   <div class="bd bd-gray-300 rounded table-responsive" align="center">
                   
             	 <a data-toggle="modal" title='Controladores Selecionados' data-target="#modal_seleccion_controladores" class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-eye" style="color:white;"></i></div></a> <label><span style="color:black; font-size: 24;">{{vm.count_select_controladores}}</span></label>            
                   
           

        </div>     
                    <table class="table table-hover mg-b-0"> 
                     <thead>
                    <tr>
                    
                    <td><i class="fa fa-globe"></i> Módulos</td>                                        
                    <td><i class="fa fa-dot-circle-o"></i> Acción</td>
                </tr>
                </thead>
                <tbody>
                  
                    <tr ng-repeat="dato in vm.tcontroladores | filter:paginate22" ng-class-odd="odd"> 
                    
                    <td>{{dato.controller}}</td>                                
                    <td> 
                        <a ng-show="!vm.select_controlador[dato.id]" ng-click="vm.agregar_controlador($index,dato,dato.id)" title='Agregar Controladores {{dato.controller}}' class="btn btn-success btn-icon mg-r-5"><div><i class="fa fa-check-circle" style="color:white;"></i></div></a>  
                        <a ng-show="vm.select_controlador[dato.id]" ng-if="vm.nivel_users==1" ng-click="vm.quitarcontrolador($index,dato.id,dato)" title='Eliminar Controladores {{dato.controller}}' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a> 
                    </td>
                </tr>                   
                </tbody>
            </table><div align="center">                  

              <div class='btn-group' align="center">
                      <pagination total-items="totalItems22" ng-model="currentPage22"  
                    max-size="5" boundary-links="true"  
                    items-per-page="numPerPage22" class="pagination-sm">  
              </pagination>
                    </div>
            </div>
        </div>      


                        <div id="crear" class="col-sm-12" > 
                        	<button class="btn btn-sm btn-warning" type="button" id="limpiar_input" ng-click="vm.limpiar()"><i class="fa fa-refresh"></i> Limpiar</button>
                        	
                        	<button ng-show="vm.tEditUSers.id==undefined" class="btn btn-sm btn-info" type="submit" id="guardar" ng-disabled="frmclientes.$invalid || vm.usuario_buscar==2 || vm.email_comprobar==2 || vm.verificar_contrasena==2"><i class="fa fa-save"></i> Crear Usuario</button>

                        	<button ng-show="vm.tEditUSers.id>0" class="btn btn-sm btn-success" type="submit" id="actualizar" ng-disabled="frmclientes.$invalid || vm.usuario_buscar==2 || vm.email_comprobar==2 || vm.verificar_contrasena==2"><i class="fa fa-edit"></i> Actualizar Datos</button>

                        	<button class="btn btn-sm btn-danger" ng-show="vm.tEditUSers.id>0" ng-disabled="vm.nivel_users!=1" type="button" id="borrar" ng-click="vm.borrar()"><i class="fa fa-trash"></i> Borrar Usuario</button>

                    	</div>

                      
                    </div>      

</form>
        </div>            
            </div>
        </div>
    </div> <!-- Departamentos Modal-->    
     <div class="modal fade" id="modal_departamentos_seleccionados" role="dialog" style="display: none; padding-right: 17px;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Perfiles Seleccionados</h4>
            </div>

            <div class="modal-body" style="padding:0; overflow: scroll;width: 100%; height: 350px;">
                <div style="padding: 10px;">
                     <table class="table table-hover mg-b-0"> 
		                	<thead>
		                    <tr>
			                                       
			                    <td><i class="fa fa-bank"></i> Perfiles</td>                                                       
			                    <td ng-show="vm.nivel_users==1"><i class="fa fa-dot-circle-o"></i> Acción</td>
		                	</tr>
		                </thead>
		                <tbody>	
		                	<tr ng-show="vm.count_select_departamentos==0">
                 		<td colspan="3" align="center"><label style="color:black;"><i class="fa fa-close"></i> No ha seleccionado ningún departamento actualmente.</label></td>
                 		</tr>   	                     
		                    <tr ng-repeat="dato in vm.tEditUSers.detalle_departamentos" ng-class-odd="odd"> 
		                                                            
		                    <td>{{dato.nombre_departamento}}</td>	                                    
		                    <td>                       
		                        <a ng-click="vm.quitardepartamento($index,dato.id,dato)" ng-show="vm.nivel_users==1" title='Eliminar Departamento {{dato.nombre_departamento}}' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a> 
		                    </td>
		                </tr>                   
		                </tbody>
		            	</table>
        
                </div>
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
    <!-- Departamentos Modal-->   

 <!-- Carpetas Modal-->    
     <div class="modal fade" id="modal_acceso_carpetas" role="dialog" style="display: none; padding-right: 17px; ">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Carpetas Seleccionadas</h4>
            </div>

            <div class="modal-body" style="padding:0; overflow: scroll;width: 100%; height: 350px;">
                <div style="padding: 10px;">
               
               <div class="bd bd-gray-300 rounded table-responsive">
                 <table class="table table-hover mg-b-0"> 
                     <thead>
                    <tr>
                                     
                                       
                    <td><i class="fa fa-folder"></i> Nombre de la Carpeta</td>                                     
                    <td ng-show="vm.nivel_users==1"><i class="fa fa-dot-circle-o"></i> Acción</td>
                </tr>
                </thead>
                <tbody>
                     <tr ng-show="vm.count_select_carpetas==0">
                 		<td colspan="3" align="center"><label style="color:black;"><i class="fa fa-close"></i> No ha seleccionado ninguna carpeta actualmente.</label></td>
                 		</tr> 
                    <tr ng-repeat="dato in vm.tEditUSers.detalle | filter:paginate3 | filter:search" ng-class-odd="odd"> 
                                      
                   <td>{{dato.nombre_carpeta}}</td>                  
                    <td>                       
                        <a ng-click="vm.quitarcarpeta($index,dato.id,dato)" ng-show="vm.nivel_users==1" title='Eliminar Carpeta {{dato.nombre_carpeta}}' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a> 
                    </td>
                </tr>                   
                </tbody>
            </table>
        </div>         
                </div>         
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
    <!-- Carpetas Modal--> 
     
      <!-- Sistemas Modal-->    
     <div class="modal fade" id="modal_seleccion_sistemas" role="dialog" style="display: none; padding-right: 17px;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sistemas Seleccionados:</h4>
            </div>

            <div class="modal-body" style="padding:0; overflow: scroll;width: 100%; height: 350px;">
                <div style="padding: 10px;">
                     <table class="table table-hover mg-b-0"> 
		                	<thead>
		                    <tr>
			                                       
			                    <td><i class="fa fa-desktop"></i> Sistema</td> 
			                    <td><i class="fa fa-tags"></i> Url Sistema</td>                                                      
			                    <td ng-show="vm.nivel_users==1"><i class="fa fa-dot-circle-o"></i> Acción</td>
		                	</tr>
		                </thead>
		                <tbody>	
		                	<tr ng-show="vm.count_select_sistemas==0">
                 		<td colspan="3" align="center"><label style="color:black;"><i class="fa fa-close"></i> No ha seleccionado ningun sistema actualmente.</label></td>
                 		</tr>   	                     
		                    <tr ng-repeat="dato in vm.tEditUSers.detalle_sistemas" ng-class-odd="odd"> 
		                                                            
		                    <td>{{dato.nombre_sistema}}</td>
		                    <td>{{dato.url_sistema}}</td>	                                    
		                    <td style="width: auto;">                       
		                        
		                    	<button type="button" class="btn btn-primary btn-credenciales" ng-show="vm.tEditUSers.id>0" title='Credenciales' ng-click="vm.filtrar_credenciales($index,dato.id_principal,dato)"><i class="fa fa-key" style="color:white;"></i> Credenciales</button>

		                        <a ng-click="vm.quitarsistema($index,dato.id,dato)" ng-show="vm.nivel_users==1" title='Eliminar Sistema {{dato.nombre_sistema}}' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a> 
		                    </td>
		                </tr>                   
		                </tbody>
		            	</table>
        
                </div>
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>

            </div>
        </div>
    </div>
</div>
    <!-- Sistemas Modal-->  
     <!-- Credenciales Modal-->    
     <div class="modal fade" id="modal_credenciales" role="dialog" style="display: none; padding-right: 17px;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Credenciales</h4>
            </div>

            <div class="modal-body" style="padding:0;">
                <div style="padding: 10px;">
                    <span><i class="fa fa-user"></i> Usuario:</span> 
                    <input name="usuario_sistema" id="usuario_sistema" type="text" maxlength="100" onpaste="return false" oncut="return false" autocomplete="off" class="form-control" ng-model="vm.credenciales.usuario_sistema" required ng-blur="vm.validar_usuario_credenciales()" >
                    <span class="material-input" ng-show="vm.spinner_credenciales==1"><img src="application/libraries/estilos/img/ajax-loader.gif"> Comprobando, Por Favor Espere...</span>
                    <span class="material-input" style="color:red;" ng-show="vm.credencial==2"><i class="fa fa-close"></i> Este usuario se encuentra registrado.</span>
                    <span style="color:green;" ng-show="vm.credencial==1"><i class="fa fa-check-circle"></i> Usuario disponible...</span><br ng-show="vm.spinner_credenciales>=0 || vm.credencial>=0">
                    <span><i class="fa fa-key"></i> Contraseña:</span> 
                    <input type="password" name="clave_sistema" id="clave_sistema" class="form-control" ng-model="vm.credenciales.contrasena_sistema" maxlength="255" onpaste="return false" oncut="return false" autocomplete="off" ng-disabled="vm.credencial==0 || vm.credencial==2">
        			
        			<span><i class="fa fa-book"></i> Notas:</span> <textarea class="form-control" rows="5" cols="5" ng-model="vm.credenciales.notas" maxlength="255" onpaste="return false" oncut="return false" autocomplete="off" ng-disabled="vm.credencial==0 || vm.credencial==2"></textarea >
        			<span><i class="fa fa-eye"></i> Mostrar a:</span><br> <input type="checkbox" ng-model="vm.credenciales.coordinador" ng-disabled="vm.credencial==0 || vm.credencial==2"><i class="fa fa-gavel"></i> Coordinador<br> 
        			<input type="checkbox" ng-model="vm.credenciales.usuario" ng-disabled="vm.credencial==0 || vm.credencial==2"><i class="fa fa-user"></i> Usuario 
                </div>               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" ng-disabled="vm.credencial==0 || vm.credencial==2" ng-click="vm.confirmar_credenciales()"><i class="fa fa-check"></i> Confirmar</button>
            </div> 
        </div>
    </div>
</div>
    <!-- Credenciales Modal-->  
    <!-- Controladores Modal-->    
     <div class="modal fade" id="modal_seleccion_controladores" role="dialog" style="display: none; padding-right: 17px;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Controladores Seleccionados</h4>
            </div>

            <div class="modal-body" style="padding:0; overflow: scroll;width: 100%; height: 350px;">
                <div style="padding: 10px;">
                     <table class="table table-hover mg-b-0"> 
		                	<thead>
		                    <tr>
			                                      
			                    <td><i class="fa fa-globe"></i> Controlador</td> 
			                                                                          
			                    <td ng-show="vm.nivel_users==1"><i class="fa fa-dot-circle-o"></i> Acción</td>
		                	</tr>
		                </thead>
		                <tbody>	
		                	<tr ng-show="vm.count_select_controladores==0">
                 		<td colspan="3" align="center"><label style="color:black;"><i class="fa fa-close"></i> No ha seleccionado ningun controlador actualmente.</label></td>
                 		</tr>   	                     
		                    <tr ng-repeat="dato in vm.tEditUSers.detalle_controlador" ng-class-odd="odd"> 
		                                                           
		                    <td>{{dato.controller}}</td>
		                    	                                    
		                    <td>                       
		                        <a ng-click="vm.quitarcontrolador($index,dato.id,dato)" ng-show="vm.nivel_users==1" title='Eliminar Controlador {{dato.controller}}' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a> 
		                    </td>
		                </tr>                   
		                </tbody>
		            	</table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
    <!-- Controladores Modal-->  
     <!-- Cambiar Contraseña Modal-->    
     <div class="modal fade" id="modal_cambio_contrasena" role="dialog" style="display: none; padding-right: 17px; ">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cambiar Contraseña</h4>
            </div>
            <div class="modal-body" style="padding:0; overflow: scroll;width: 100%; height: 350px;">
            <form id="fmrcontrasena" name="fmrcontrasena" ng-submit="SubmitContrasena($event)" autocomplete="off">
                <div style="padding: 10px;">
                    <span><i class="fa fa-key"></i> Contraseña Nueva:</span> 
                    <input name="contrasena_nueva" id="contrasena_nueva" type="password" maxlength="100" onpaste="return false" oncut="return false" autocomplete="off" class="form-control" ng-model="vm.cambio_contra.contrasena_nueva" required> 
                    <span><i class="fa fa-key"></i> Confirmar Contraseña:</span>
                    <input type="password" name="r_contrasena" id="r_contrasena" class="form-control" ng-model="vm.cambio_contra.r_contrasena" maxlength="255" onpaste="return false" oncut="return false" autocomplete="off" required>
                </div> 
                 <div id="crear" align="center" > 
                    <!--button class="btn btn-sm btn-warning" type="button" id="limpiar_input" ng-click="vm.limpiar()"><i class="fa fa-refresh"></i> Limpiar</button-->
                    <button  class="btn btn-sm btn-success" type="submit" id="actualizar" ng-disabled="fmrcontrasena.$invalid || vm.verificar_contrasena==2"><i class="fa fa-edit"></i> Actualizar Contraseña</button>
                </div>
            </form>     
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
    <!-- Cambiar Contraseña Modal-->  

</div>        

 <?php $this->load->view('view_footer');?>
</body>

<div id="cargando" class="loader loader-default"  data-text="Cargando los registros, Por Favor Espere..."></div>
<div id="guardando" class="loader loader-default"  data-text="Guardando el registro, Por Favor Espere..."></div>
<div id="comprobando" class="loader loader-default"  data-text="Comprobando Usuario, Por Favor Espere..."></div>
</html>