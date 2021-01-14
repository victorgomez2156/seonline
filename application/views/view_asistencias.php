<html lang="en">
<head>
  <?php $this->load->view('view_header');?> 
</head>
<body>
<div ng-app="appPrincipal" ng-controller="Controlador_Consultas as vm">

<?php $this->load->view('templates/side_menu');?>  

<div  class="container">
    <div class="tab-content">
    <h2  id="t-0000" style="margin-top: 0px;">Asistencias</h2>
    <div id="t-0001">
       
           
            <div id="t-0003">   
           <div id="DivFormCustomer" class="col-sm-12" style="clear: both; padding: 15px;">
           	<div id="DivFormCustomer2" class="col-sm-12" style=" background-color: #fff;"><br><br>                  
                            <div class="col-sm-6" style="">
                                    <div>
                                      <div class="input-group">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label" ng-show="vm.fdatos.huser==undefined"><i class="fa fa-users"></i> Seleccione un usuario</label>
                                            <label class="control-label" ng-show="vm.fdatos.huser>0"><i class="fa fa-users"></i> Usuario Seleccionado</label>
                                            <!--input name="correo_electronico" id="correo_electronico" type="text" class="form-control" ng-model="vm.fdatos.correo_electronico" required ng-blur="vm.comprobar_datos()"-->
                                            <select name="huser" id="huser" class="form-control" required ng-model="vm.fdatos.huser" ng-change="vm.buscar_asistencias()">
                                                <option ng-repeat="opcion in vm.usuarios"value="{{opcion.id}}">{{$index+1}}.- {{opcion.nombres}} {{opcion.apellidos}} Usuario: {{opcion.usuario}}</option></select>
                                            <span class="material-input" ng-show="vm.spinner_correo==1"><img src="application/libraries/estilos/img/ajax-loader.gif"> Buscando, Por Favor Espere...</span>
                                            <span class="material-input" ng-show="vm.email_comprobar==1" style="color:green;"><i class="fa fa-check-circle"></i> Datos encontrados...</span>
                                            <span class="material-input" ng-show="vm.email_comprobar==2" style="color:red;"><i class="fa fa-close"></i> No se encontraron datos...</span>
                                        </div>
                                    </div>
                                </div>
                                </div>                     
                    </div> 
                       
                       <div id="DivFormCustomer2" class="col-sm-12" style=" background-color: #fff;" ng-show="vm.fdatos.huser>0">
                        <!--br><i class="fa fa-user-circle"></i><b>Usuario:&nbsp;&nbsp; </b><b><h4>{{vm.consulta_datos.nombres}} {{vm.consulta_datos.apellidos}}</h4></b-->

                        <!--a  title='Exportar PDF {{vm.consulta_datos.nombres}} {{vm.consulta_datos.apellidos}}' target="_black" class="btn btn-info" href="reportes/Exportar_Pdf/Reportes_Asistencias/{{vm.fdatos.huser}}"><div><i class="fa fa-file" style="color:white;"></i></div></a-->  </div> <!--Final del Div de la vista de usuarios-->
                        <div id="DivFormCustomer" class="col-sm-12" style="clear: both; padding: 15px;">

<div id="DivFormCustomer2" class="col-sm-12" style=" background-color: #fff;" ng-show="vm.fdatos.huser>0" ng-init="vm.fecha_server()">                            
    <form id="frmasistenciaempleados" name="frmasistenciaempleados" ng-submit="submitFormAsistencias($event)" autocomplete="off">
        <div class="col-sm-6" style="">
            <div>
                <div class="input-group">
                    <div class="form-group label-floating is-focused">
                        <label class="control-label"><i class="fa fa-calendar"></i> Desde</label>
                        <input name="desde" id="fecha_desde" type="text"class="form-control" ng-model="vm.desde"  maxlength="100" onpaste="return false" oncut="return false" autocomplete="off" required placeholder="DD/MM/YYYY"><span class="material-input"></span>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6" style="">
                <div>
                    <div class="input-group">
                        <div class="form-group label-floating is-focused">
                            <label class="control-label"><i class="fa fa-calendar"></i> Hasta</label>
                            <input name="hasta" id="fecha_hasta" type="text" class="form-control" ng-model="vm.hasta"  maxlength="100" required onpaste="return false" oncut="return false" autocomplete="off" placeholder="DD/MM/YYYY"><span class="material-input"></span>
                        </div>
                  </div>
                </div>
                    <input type="hidden" name="id" id="id" ng-model="vm.consulta_datos.id" readonly>
        </div>
        <div id="crear" class="col-sm-12" align="center"> 
                <!--button class="btn btn-sm btn-info" type="button" id="limpiar_input" ng-click="vm.limpiar()"><i class="fa fa-refresh"></i> Limpiar</button-->
                <label style="color: black;">Tipo Consulta: </label> 
                <input type="radio" id="Normal" value="1" name="tipo_consulta" ng-model="vm.selec_consulta"> Normal 
                <input type="radio" id="Detallado" value="2" name="tipo_consulta" ng-model="vm.selec_consulta"> Detallado 
        </div><br>
        <div id="crear" class="col-sm-12" align="center"> 
                <!--button class="btn btn-sm btn-info" type="button" id="limpiar_input" ng-click="vm.limpiar()"><i class="fa fa-refresh"></i> Limpiar</button-->
                <button class="btn btn-sm btn-primary" ng-click="vm.submitFormAsistencias(event)" id="Generar Consulta" ng-disabled="frmasistenciaempleados.$invalid"><i class="fa fa-search"></i> Consultar Empleado</button>
        </div><br>
            <div align="center" class="col-sm-12"><br>
                <span class="material-input" ng-show="vm.spinner==1"><img src="application/libraries/estilos/img/ajax-loader.gif"> Buscando datos, Por Favor Espere...</span>
                <span class="material-input" ng-show="vm.resultado==1" style="color:green;"><i class="fa fa-check-circle"></i> Se encontraron datos...</span>
                <span class="material-input" ng-show="vm.resultado==2" style="color:red;"><i class="fa fa-close"></i> No se han encontrado datos en el rango seleccionado...</span> <br> 
                    
            </div>
    </form>

      <div class="bd bd-gray-300 rounded table-responsive" ng-show="vm.resultado==1 && vm.vista==1">
        <a ng-show="vm.resultado==1" title='Exportar PDF {{vm.consulta_datos.nombres}} {{vm.consulta_datos.apellidos}}' target="_black" class="btn btn-info" href="reportes/Exportar_Pdf/Asistencia/{{vm.fdatos.huser}}/{{vm.desde}}/{{vm.hasta}}"><div><i class="fa fa-file" style="color:white;"></i></div></a>

         <a ng-show="vm.resultado==1" title='Exportar Excel {{vm.consulta_datos.nombres}} {{vm.consulta_datos.apellidos}}' class="btn btn-primary" ng-click="vm.exportar_excel()"><div><i class="fa fa-file-excel-o" style="color:white;"></i></div></a>
        
        <a ng-show="vm.excel==true" title='Descargar Reporte Excel {{vm.consulta_datos.nombres}} {{vm.consulta_datos.apellidos}}' href="reportes/{{vm.nombre_reporte}}" class="btn btn-success" download><div><i class="fa fa-cloud-download" style="color:white;"></i></div></a>

        <br>
            <span class="material-input" style="margin-left: 5px;"><i class="fa fa-bars"></i> LISTADO DE FICHAJES</span><br>
            <h3 style="margin-top: 1px; margin-left: 5px;"><i class="fa fa-users"></i> Empleado: {{vm.consulta_datos.nombres}} {{vm.consulta_datos.apellidos}}</h3>
            <table class="table table-hover mg-b-0"> 
                <thead>
                  <tr>
                    <td><i class="fa fa-calendar"></i> <b>Fecha</b></td>
                    <td><i class="fa fa-hand-o-left"></i> <b>Entrada</b></td>
                    <td><i class="fa fa-hand-o-right"></i> <b>Salida</b></td>
                    <td><i class="fa fa-industry"></i> <b>Total Horas</b></td>
                </tr>
                </thead>
                <tbody>
                    <tr ng-show="vm.tResultado==null"> 
                         <td colspan="7" align="center"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</td>                   
                    </tr> 
                    <tr ng-repeat="dato in vm.tResultado | filter:paginate | filter:search" ng-class-odd="odd"> 
                        <td><div class="td-usuario-table">{{dato.fecha}}</div></td>                    
                        <td><div class="td-usuario-table">{{dato.hora_entrada}}</div></td>
                        <td><div class="td-usuario-table">{{dato.hora_salida}}</div></td>
                        <td><div class="td-usuario-table">{{dato.total_trabajadas}}</div></td>
                    </tr> 
                    <tr> 
                        <td colspan="3"><div class="td-usuario-table"><i class="fa fa-clock-o"></i> <b>Total Horas:</b> </div></td>                    
                        <td colspan="1"><div class="td-usuario-table">{{vm.total_laborado}}</div></td> 
                    </tr>                   
                </tbody>
            </table>
            <div align="center">                 
            <div class='btn-group' align="center">
                <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
                </pagination>
            </div>
        </div>
        </div>  

         <div class="bd bd-gray-300 rounded table-responsive" ng-show="vm.resultado==1 && vm.vista==2">
            <a ng-show="vm.resultado==1" title='Exportar PDF {{vm.consulta_datos.nombres}} {{vm.consulta_datos.apellidos}}' target="_black" class="btn btn-info" href="reportes/Exportar_Pdf/Asistencia_Detallada/{{vm.fdatos.huser}}/{{vm.desde}}/{{vm.hasta}}"><div><i class="fa fa-file" style="color:white;"></i></div></a>
            
             <a ng-show="vm.resultado==1" title='Exportar Excel {{vm.consulta_datos.nombres}} {{vm.consulta_datos.apellidos}}' class="btn btn-primary" ng-click="vm.exportar_excel_detallado()"><div><i class="fa fa-file-excel-o" style="color:white;"></i></div></a>
        
            <a ng-show="vm.excel_detallado==true" title='Descargar Reporte Excel {{vm.consulta_datos.nombres}} {{vm.consulta_datos.apellidos}}' href="reportes/{{vm.nombre_reporte}}" class="btn btn-success" download><div><i class="fa fa-cloud-download" style="color:white;"></i></div></a>  

<br>



            <span class="material-input" style="margin-left: 5px;"><i class="fa fa-bars"></i> LISTADO DE FICHAJES</span><br>
            <h3 style="margin-top: 1px; margin-left: 5px;"><i class="fa fa-users"></i> Empleado: {{vm.consulta_datos.nombres}} {{vm.consulta_datos.apellidos}}</h3>
            
           <div class="row">
				 
				  <div class="col-sm-6 col-md-3" ng-repeat="opcion in vm.tReporteDetallado track by opcion.id">
					<div class="thumbnail">
				<div class="bd bd-gray-300 rounded table-responsive"> 
					<table class="table table-hover mg-b-0">              
                	<tbody>
	                	<tr>
				            <tr bgcolor="#E5E5E5" align="center">
								<td border="0" colspan="4"><i class="fa fa-calendar"></i> Fecha: {{opcion.fecha}}</td>
							</tr>
						    <tr>
						    	
							    	<tr>
								    	<td colspan="2">
								    		<b>Entrada: </b>
								    	</td> 
								    	<td colspan="2">
								    		<b> {{opcion.hora_entrada}}</b>
							    		</td>
							    	</tr>
							   
							</tr>
                            <tr>
                                
                                    <tr >
                                        <td>
                                            <a title='Ver Breaks' ng-click="vm.Breaks_Reuniones_Empleado($index,opcion.id,vm.fdatos.huser,1,opcion.fecha)" class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-hotel" style="color:white;"></i></div></a>
                                        </td> 
                                        <td >
                                            <a title='Ver Reuniones' ng-click="vm.Breaks_Reuniones_Empleado($index,opcion.id,vm.fdatos.huser,2,opcion.fecha)" class="btn btn-primary btn-icon mg-r-5"><div><i class="fa fa-suitcase" style="color:white;"></i></div></a>
                                        </td>
                                        <td>
                                            <a title='Ver Inactividades' ng-click="vm.Breaks_Reuniones_Empleado($index,opcion.id,vm.fdatos.huser,3,opcion.fecha)" class="btn btn-warning btn-icon mg-r-5"><div><i class="fa fa-ban" style="color:white;"></i></div></a>
                                        </td>
                                    </tr>
                                
                            </tr>
							<tr>
						    	
							    	<tr>
								    	<td colspan="2">
								    		 <b>Salida: </b>
								    	</td> 
								    	<td colspan="2" ng-show="opcion.hora_salida==null">
								    		<b> Sin Finalizar</b>
							    		</td>
                                        <td colspan="2" ng-show="opcion.hora_salida!=null">
                                            <b> {{opcion.hora_salida}}</b>
                                        </td>
							    	</tr>
							    
							</tr>
                            <tr>
                               
                                    <tr>
                                        <td colspan="2">
                                           <b>Total Horas: </b>
                                        </td> 
                                        <td colspan="2" ng-show="opcion.total_trabajadas==null">
                                            <b> Sin Calcular</b>
                                        </td>
                                        <td colspan="2" ng-show="opcion.total_trabajadas!=null">
                                            <b> {{opcion.total_trabajadas}}</b>
                                        </td>
                                    </tr>
                                
                            </tr>
	                	</tr>
                	</tbody>
            	</table>
            </div>
					</div>
				  </div><!--FINAL DEL DIV SM-6-->
		</div>
                 

            <div align="center">   
            <div class="td-usuario-table"><i class="fa fa-clock-o"></i> <b>Total Horas:</b> {{vm.total_laborado}}  </div>              
            <div class='btn-group' align="center">
                <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
                </pagination>
            </div>
        </div> 
            
        </div>  

<!-- Breaks Modal-->    
<div class="modal fade" id="modal_detalles_breaks" role="dialog" style="display: none; padding-right: 17px;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-calendar"></i> Breaks {{vm.busqueda_detalle.fecha}}</h4>
            </div>

            <div class="modal-body" style="padding:0;">
                <div style="padding: 10px;">
                    <div class="bd bd-gray-300 rounded table-responsive">
                        <table class="table table-hover mg-b-0"> 
                            <thead>
                                <tr>
                                    <td><i class="fa fa-clock-o"></i> Hora Salida</td>
                                    <td><i class="fa fa-clock-o"></i> Hora Entrada</td>
                                    <td><i class="fa fa-at"></i> Tiempo Breaks</td>
                                    <td><i class="fa fa-dedent"></i> Tipo</td>                    
                                    <!--td><i class="fa fa-dot-circle-o"></i> Estatus</td-->
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-show="vm.tdetallesbreaks==null"> 
                                    <td colspan="7" align="center"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</td>                   
                                </tr>
                                <tr ng-repeat="dato in vm.tdetallesbreaks | filter:paginate2 | filter:search" ng-class-odd="odd"> 
                                    <td><div class="td-usuario-table">{{dato.break_salida}}</div></td>
                                    <td><div class="td-usuario-table">{{dato.break_entrada}}</div></td>
                                    <td><div class="td-usuario-table">{{dato.total_break}}</div></td>
                                    <td>
                                        <div class="td-usuario-table" ng-show="dato.tipo==2"> En Proceso</div>
                                        <div class="td-usuario-table" ng-show="dato.tipo==3"> Finalizado</div>
                                    </td>
                                    <!--td>
                                        <div class="td-usuario-table" ng-show="dato.estatus_breaks==0"> Pendiente</div>
                                        <div class="td-usuario-table" ng-show="dato.estatus_breaks==1"> Completado</div>
                                        <div class="td-usuario-table" ng-show="dato.estatus_breaks==2"> Pendiente de Aprobación</div>
                                        <div class="td-usuario-table" ng-show="dato.estatus_breaks==3"> Aprobado por Admin</div>
                                    </td-->
                                </tr>
                                <tr>
                                    <td colspan="2"><i class="fa fa-clock-o"></i> <b>Total Break Acumulado:</b></td> <td colspan="2">{{vm.horas}}:{{vm.minutos}}:{{vm.segundos}}</td>
                                </tr>                   
                            </tbody>
                        </table>
                    </div>
                    <div align="center">
                        <!--span class="store-qty">
                            <a ng-click="vm.asistencia_hoy()" title='Refrescar' class="btn btn-warning btn-icon mg-r-5"><div><i class="fa fa-refresh" style="color:white;"></i></div>
                            </a>
                        </span-->      
                        <div class='btn-group' align="center">
                            <pagination total-items="totalItems2" ng-model="currentPage2" max-size="5" boundary-links="true" items-per-page="numPerPage2" class="pagination-sm"></pagination>
                        </div>
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                    </div> 
                </div>
            </div>
        </div>
    </div> 
</div> <!-- Breaks Modal-->  

<!-- Reuniones Modal-->    
     <div class="modal fade" id="modal_detalles_reuniones" role="dialog" style="display: none; padding-right: 17px;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-calendar"></i> Reuniones {{vm.busqueda_detalle.fecha}}</h4>
            </div>

            <div class="modal-body" style="padding:0;">
                <div style="padding: 10px;">
                    <div class="bd bd-gray-300 rounded table-responsive">
            <table class="table table-hover mg-b-0"> 
                <thead>
                    <tr>
                   <td><i class="fa fa-clock-o"></i> Hora Salida</td>
                    <td><i class="fa fa-clock-o"></i> Hora Entrada</td>
                    <td><i class="fa fa-at"></i> Tiempo Reunión</td>
                    <td><i class="fa fa-dedent"></i> Tipo</td>                    
                    <td><i class="fa fa-dot-circle-o"></i> Estatus</td>
                    
                </tr>
                </thead>
                <tbody>
                     <tr ng-show="vm.tdetallesreuniones==null"> 
                     <td colspan="7" align="center"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</td>                   
                    </tr>
                    <tr ng-repeat="dato in vm.tdetallesreuniones | filter:paginate3 | filter:search" ng-class-odd="odd"> 
                    
                    <td><div class="td-usuario-table">{{dato.reuniones_salida}}</div></td>
                    
                    <td><div class="td-usuario-table">{{dato.reuniones_entrada}}</div></td>
                    <td><div class="td-usuario-table">{{dato.total_reunion}}</div></td>
                      <td>
                       <div class="td-usuario-table" ng-show="dato.tipo==5"> En Proceso</div>
                        <div class="td-usuario-table" ng-show="dato.tipo==6"> Finalizado</div>
                    </td>
                     <td>
                        <div class="td-usuario-table" ng-show="dato.estatus_reuniones==0"> En Proceso</div>
                       <div class="td-usuario-table" ng-show="dato.estatus_reuniones==1"> Completado</div>
                        <div class="td-usuario-table" ng-show="dato.estatus_reuniones==2"> Pendiente de Aprobación</div>
                        <div class="td-usuario-table" ng-show="dato.estatus_reuniones==3"> Aprobado por Admin</div>
                       
                    </td>
                </tr> 
                 <tr>
                    <td colspan="2"><i class="fa fa-clock-o"></i> <b>Total Reunión Acumulado:</b></td> 
                    <td colspan="2">{{vm.hora_reunion}}:{{vm.minutos_reunion}}:{{vm.segundos_reunion}}</td>
                </tr>                   
                </tbody>
            </table>
        </div> 
        <div align="center">
                        <!--span class="store-qty">
                            <a ng-click="vm.asistencia_hoy()" title='Refrescar' class="btn btn-warning btn-icon mg-r-5"><div><i class="fa fa-refresh" style="color:white;"></i></div>
                            </a>
                        </span-->      
            <div class='btn-group' align="center">
                <pagination total-items="totalItems3" ng-model="currentPage3" max-size="5" boundary-links="true" items-per-page="numPerPage3" class="pagination-sm"></pagination>
            </div>
        </div>   
                          

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div> 
        </div>
    </div>
</div>
</div> 
</div> <!-- Reuniones Modal-->  

<!-- Inactividades Modal-->    
     <div class="modal fade" id="modal_detalle_inactividades" role="dialog" style="display: none; padding-right: 17px;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-calendar"></i> Inactividades {{vm.busqueda_detalle.fecha}}</h4>
            </div>

            <div class="modal-body" style="padding:0;">
                <div style="padding: 10px;">
                    <div class="bd bd-gray-300 rounded table-responsive">
            <table class="table table-hover mg-b-0"> 
                <thead>
                 <tr>
                  
                   <td><i class="fa fa-clock-o"></i> Hora</td>
                   <td><i class="fa fa-at"></i> Tiempo Inactivo</td>
                </tr>
                </thead>
                <tbody>
                     <tr ng-show="vm.tdetalleinactividades==null"> 
                     <td colspan="7" align="center"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</td>                   
                    </tr>
                    <tr ng-repeat="dato in vm.tdetalleinactividades | filter:paginate4 | filter:search" ng-class-odd="odd"> 
                    
                  
                    
                    <td><div class="td-usuario-table">{{dato.hora_inactividad}}</div></td>
                    <td><div class="td-usuario-table">{{dato.tiempo_inactivo}} Segundos</div></td>
                     
                </tr> 
                 <tr>
                    <td><i class="fa fa-clock-o"></i> <b>Total Tiempo inactivos: {{vm.total_segundos}}</b></td> 
                    <td>{{vm.hora_inactivo}}:{{vm.minutos_inactivos}}:{{vm.segundos_inactivos}}</td>
                </tr>                   
                </tbody>
            </table>
        </div> 
        <div align="center">
                        <!--span class="store-qty">
                            <a ng-click="vm.asistencia_hoy()" title='Refrescar' class="btn btn-warning btn-icon mg-r-5"><div><i class="fa fa-refresh" style="color:white;"></i></div>
                            </a>
                        </span-->      
            <div class='btn-group' align="center">
                <pagination total-items="totalItems4" ng-model="currentPage4" max-size="5" boundary-links="true" items-per-page="numPerPage4" class="pagination-sm"></pagination>
            </div>
        </div>   
                          

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div> 
        </div>
    </div>
</div>
</div> 
</div> <!-- Inactividades Modal--> 

        </div>
    </div>
</div>  
      <script type="text/javascript">
   $(function(){
        'use strict'

        // Input Masks
        $('#fecha_desde').mask('99-99-9999');
        $('#fecha_hasta').mask('99-99-9999'); 

      });

  jQuery(function($) 
  {            
    
    $( "#tabs" ).tabs(); 
  });
</script>
<?php $this->load->view('view_footer');?>
</body>
<div id="Cargando" class="loader loader-default"  data-text="Buscando, Por Favor Espere... "></div>
<div id="guardando" class="loader loader-default"  data-text="Estamos Guardando los Datos, Por Favor Espere... "></div>
</html>