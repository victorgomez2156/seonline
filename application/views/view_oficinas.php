<html lang="en">
<head>
   <?php $this->load->view('view_header');?>
</head>
<body>
<div ng-app="appPrincipal">
<?php $this->load->view('templates/side_menu');?>    

<div class="container" ng-controller="Controlador_Oficinas as vm">
    <div class="tab-content">
    <h2  id="t-0000" style="margin-top: 0px;"><i class="fa fa-home"></i> Oficinas</h2>
    <div id="t-0001">
        <div id="t-0002">
            <div class="t-0029">
                   <button style=" float: left;margin-left: 15px;padding: 10px;margin-top: 1px;margin-bottom: 2px;" class="btn btn-info " ng-click="vm.agregar_office()" id="addTask" ><i class="fa fa-plus"></i> Agregar</button>

                </div>                
                <div style="float:left; margin-top: 8px;" class="removeForMobile">                   
                    <div class="t-0029">
                            <div class="t-0031" style="margin-top: -8px; ">
                                <button style="" class="btn t-0032 status-task active-status" id="all_active" ng-click="vm.office_all()"><i class="fa fa-clone"></i> Todos</button>
                                <button style="" class="btn t-0032 status-task" id="active" ng-click="vm.office_active()"><i class="fa fa-check"></i> Activos</button>
                                <button style="" class="btn t-0032 status-task" id="all_disabled" ng-click="vm.office_disabled()"><i class="fa fa-close"></i> Inactivos</button>
                            </div>
                        </div>
                </div>
            </div>
           
            <div id="t-0003">               
                <br>      
        <div ng-show="vm.filtro==0">
        <div class="bd bd-gray-300 rounded table-responsive" ng-init="vm.office_all()">
            <table class="table table-hover mg-b-0"> 
                <thead>
                    <tr>
                    
                    <td><i class="fa fa-home"></i> Nombre de La Oficina</td>
                    <td><i class="fa fa-dot-circle-o"></i> Estatus</td>
                    <td><i class="fa fa-dedent"></i> Acción</td>
                </tr>
                </thead>
                <tbody>
                      <tr ng-show="vm.tOficinas==null"> 
                     <td colspan="7" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>                   
                    </tr>
                    <tr ng-repeat="dato in vm.tOficinas | filter:paginate | filter:search" ng-class-odd="odd"> 
                    
                    <td><div class="td-usuario-table">{{dato.nombre_oficina}}</div></td>                 
                    <td><div class="td-usuario-table"><label ng-show="dato.estatus==1" style="color:green; text-align: center;"><i class="fa fa-check-circle"></i> Activo</label><label ng-show="dato.estatus==2"  style="color:red; text-align: center;"><i class="fa fa-close"></i> Desactivado</label></div></td>
                    <td>	
                    	<a ng-click="vm.edit_office(dato)" title='Editar Oficina {{dato.nombre_oficina}} ' class="btn btn-info btn-icon  mg-r-5"><div><i class="fa fa-edit" style="color:white;"></i></div></a>
                   		<a ng-click="vm.borrar_row($index,dato.id,1)" ng-show="vm.nivel_users==1" title='Eliminar Oficina {{dato.nombre_oficina}} ' class="btn btn-danger btn-icon  mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a>
                	</td>
                </tr>                   
                </tbody>
            </table>
        </div>  
           <div align="center">
              <span class="store-qty"> <a ng-click="vm.office_all()" title='Refrescar' class="btn btn-warning btn-icon  mg-r-5"><div><i class="fa fa-refresh" style="color:white;"></i></div></a>        

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
                                      
                    <td><i class="fa fa-home"></i> Nombre Oficina</td>                    
                    <td><i class="fa fa-dot-circle-o"></i> Estatus</td>
                    <td><i class="fa fa-dedent"></i>Acción</td>
                </tr>
                </thead>
                <tbody>
                     <tr ng-show="vm.tOficinasActive==null"> 
                     <td colspan="7" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>                   
                    </tr>
                    <tr ng-repeat="dato in vm.tOficinasActive | filter:paginate2 | filter:search" ng-class-odd="odd"> 
                    
                    <td><div class="td-usuario-table">{{dato.nombre_oficina}}</div> </td>                   
                  
                    <td><div class="td-usuario-table"><label ng-if="dato.estatus==1" style="color:green;"><i class="fa fa-check-circle"></i> Activo</label></div></td>
                    <td>
                    	<a ng-click="vm.edit_office(dato)" title='Editar Oficina {{dato.nombre_oficina}} ' class="btn btn-info btn-icon  mg-r-5"><div><i class="fa fa-edit" style="color:white;"></i></div></a>
                    	<a ng-click="vm.borrar_row($index,dato.id,2)" ng-show="vm.nivel_users==1" title='Eliminar Oficina {{dato.nombre_oficina}} ' class="btn btn-danger btn-icon  mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a> 
                    </td>
                </tr>                   
                </tbody>
            </table>
        </div>  
           <div align="center">
              <span class="store-qty"> <a ng-click="vm.office_active()" title='Refrescar' class="btn btn-warning btn-icon  mg-r-5"><div><i class="fa fa-refresh" style="color:white;"></i></div></a>        

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
                    
                    <td><i class="fa fa-home"></i> Nombre Oficina</td>                   
                    <td><i class="fa fa-dot-circle-o"></i> Estatus</td>
                    <td><i class="fa fa-dedent"></i> Acción</td>
                </tr>
                </thead>
                <tbody>
                     <tr ng-show="vm.tOficinasDisabled==null"> 
                     <td colspan="7" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>                   
                    </tr> 
                    <tr ng-repeat="dato in vm.tOficinasDisabled | filter:paginate3 | filter:search" ng-class-odd="odd"> 
                    
                    <td><div class="td-usuario-table">{{dato.nombre_oficina}}</div> </td>                    
                     <td><div class="td-usuario-table"><label ng-if="dato.estatus==2" style="color:red;"><i class="fa fa-close"></i> Desactivado</label></div></td>
                    <td>
                    	<a ng-click="vm.edit_office(dato)" title='Editar Oficina {{dato.nombre_oficina}} ' class="btn btn-info btn-icon  mg-r-5"><div><i class="fa fa-edit" style="color:white;"></i></div></a>
                    	<a ng-click="vm.borrar_row($index,dato.id,3)" ng-show="vm.nivel_users==1" title='Eliminar Oficina {{dato.nombre_oficina}} ' class="btn btn-danger btn-icon  mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a> 
                    </td>
                </tr>                   
                </tbody>
            </table>
        </div>  
           <div align="center">
              <span class="store-qty"> <a ng-click="vm.office_disabled()" title='Refrescar' class="btn btn-warning btn-icon  mg-r-5"><div><i class="fa fa-refresh" style="color:white;"></i></div></a>        

              <div class='btn-group' align="center">
                      <pagination total-items="totalItems3" ng-model="currentPage3"  
                    max-size="5" boundary-links="true"  
                    items-per-page="numPerPage3" class="pagination-sm">  
              </pagination>
                    </div>
            </div>
        </div>    

          <div ng-show="vm.filtro==4">
        <form id="frmoffice" name="frmoffice" ng-submit="submitForm($event)">	

			<h2 ng-show="vm.tEditOficinas.id==undefined" align="center"><i class="fa fa-plus"></i> Registro de Oficina</h2>
                            <h2 ng-show="vm.tEditOficinas.id>0" align="center"><i class="fa fa-database"></i> Actualización de datos</h2>
           <div id="DivFormCustomer" class="col-sm-12" style="clear: both; padding: 15px;">
                        <div id="DivFormCustomer2" class="col-sm-12" style=" background-color: #fff;">                            
                            <div class="col-sm-6" style="">
                                <div>
                                     <div class="input-group">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-home"></i> Nombre Oficina</label>
                                            <input name="nombre_oficina" id="nombre_oficina" type="text"class="form-control" ng-model="vm.tEditOficinas.nombre_oficina" required>
                                        <span class="material-input"></span></div>
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-6" style="">
                                <div>                                                               
                                    <div class="input-group">
                                        <div class="form-group label-floating is-empty">
                                           <label class="control-label"><i class="fa fa-dot-circle-o"></i> Estatus</label>
                                            <select name="estatus" id="estatus" class="form-control" required ng-model="vm.tEditOficinas.estatus"><option ng-repeat="opcion in vm.estatus"value="{{opcion.id}}">{{opcion.nombre}}</option></select>
                                        <span class="material-input"></span></div>
                                    </div>                                   
                                </div>
                            </div>
                           
                            <input type="hidden" name="id" id="id" ng-model="vm.tEditOficinas.id">
                        </div>
                       
                        <div id="crear" class="col-sm-12" > 
                        	<button class="btn btn-sm btn-warning" type="button" id="limpiar_input" ng-click="vm.limpiar()"><i class="fa fa-refresh"></i> Limpiar</button>
                        	
                        	<button ng-show="vm.tEditOficinas.id==undefined" class="btn btn-sm btn-info" type="submit" id="guardar" ng-disabled="frmoffice.$invalid || vm.Oficina_buscar==2 || vm.email_comprobar==2 || vm.verificar_contrasena==2"><i class="fa fa-save"></i> Crear Oficina</button>

                        	<button ng-show="vm.tEditOficinas.id>0" class="btn btn-sm btn-success" type="submit" id="actualizar" ng-disabled="frmoffice.$invalid || vm.Oficina_buscar==2 || vm.email_comprobar==2 || vm.verificar_contrasena==2"><i class="fa fa-edit"></i> Actualizar Datos</button>

                        	<button class="btn btn-sm btn-danger" ng-show="vm.tEditOficinas.id>0" ng-disabled="vm.nivel_users!=1" type="button" id="borrar" ng-click="vm.borrar()"><i class="fa fa-trash"></i> Borrar Oficina</button>

                    	</div>

                      
                    </div>
                </form>
        </div>            
            </div>
        </div>
    </div>
</div>  
<?php $this->load->view('view_footer');?>
</body>
<div id="cargando" class="loader loader-default"  data-text="Cargando registros, Por Favor Espere..."></div>
<div id="guardando" class="loader loader-default"  data-text="Guardando registro, Por Favor Espere..."></div>
</html>