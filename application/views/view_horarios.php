<html lang="en">
<head>
   <?php $this->load->view('view_header');?>
</head>
<body>
<div ng-app="appPrincipal">
<?php $this->load->view('templates/side_menu');?>    

<div class="container" ng-controller="Controlador_Horarios as vm">
    <div class="tab-content">
    <h2  id="t-0000" style="margin-top: 0px;"><i class="fa fa-clock-o"></i> Horarios Usuarios</h2>
    <div id="t-0001">
        
           
            <div id="t-0003">               
                <br> 
          <div>
        <form id="frmhorarios" name="frmhorarios" ng-submit="submitForm($event)">	

			 <div id="DivFormCustomer" class="col-sm-12" style="clear: both; padding: 15px;">
                        <div id="DivFormCustomer2" class="col-sm-12" style=" background-color: #fff;">                            
                            
                             <div class="col-sm-6" style="">
                                <div>
                                    <div class="col-sm-6" style="">
                                <div>
                                      <div class="input-group">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label" ng-show="vm.fdatos.huser==undefined"><i class="fa fa-users"></i> Seleccione un usuario</label>
                                            <label class="control-label" ng-show="vm.fdatos.huser>0"><i class="fa fa-users"></i> Usuario Seleccionado</label>
                                            <!--input name="correo_electronico" id="correo_electronico" type="text" class="form-control" ng-model="vm.fdatos.correo_electronico" required ng-blur="vm.comprobar_datos()"-->
                                            <select name="huser" id="huser" class="form-control" required ng-model="vm.fdatos.usuario" ng-change="vm.buscar_usuario()">
                                                <option ng-repeat="opcion in vm.usuarios"value="{{opcion.id}}">{{$index+1}}.- {{opcion.nombres}} {{opcion.apellidos}} Usuario: {{opcion.usuario}}</option></select>
                                            <span class="material-input" ng-show="vm.spinner_usuario==1"><img src="application/libraries/estilos/img/ajax-loader.gif"> Buscando, Por Favor Espere...</span>
                                            <span class="material-input" ng-show="vm.resultado==1" style="color:green;"><i class="fa fa-check-circle"></i> Datos encontrados...</span>
                                            <span class="material-input" ng-show="vm.resultado==2" style="color:red;"><i class="fa fa-close"></i> No se encontraron datos...</span>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>                      
                        </div>                                                    
                            <!--input type="hidden" name="huser" id="huser" ng-model="vm.fdatos.usuario" readonly-->
                             <input type="hidden" name="id" id="id" ng-model="vm.fdatos.id" readonly>

                        </div>

                         <div id="DivFormCustomer3" class="col-sm-12" style=" background-color: #fff;">     
                        <a ng-show="vm.fdatos.usuario>0" title='Exportar PDF' target="_black" class="btn btn-info" href="reportes/Exportar_Pdf/Consultas_Horarios/{{vm.fdatos.usuario}}"><div><i class="fa fa-file" style="color:white;"></i></div></a>                       
                        
                        <div align="center"><p><b>Inicio de Contrato</b></p></div><br>
                           <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-calendar tx-16 lh-0 op-6"></i> Inicio de Contrato <b style="color:red;">(*)</b> </label>
                                            <input name="fecha_inicio_contrato" id="fecha_inicio_contrato" type="text"class="form-control" ng-model="vm.fecha_inicio_contrato" required ng-disabled="vm.fdatos.usuario==undefined">                                          
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-calendar tx-16 lh-0 op-6"></i> Fecha de fin del periodo de prueba </label>
                                            <input name="fecha_perioro_prueba" id="fecha_perioro_prueba" type="text"class="form-control" ng-model="vm.fecha_perioro_prueba" ng-disabled="vm.fdatos.usuario==undefined">                                          
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-calendar tx-16 lh-0 op-6"></i> Fecha fin de contrato </label>
                                            <input name="fecha_fin_contrato" id="fecha_fin_contrato" type="text"class="form-control" ng-model="vm.fecha_fin_contrato" ng-disabled="vm.fdatos.usuario==undefined">                                          
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-clock-o"></i> Estatus Contrato <b style="color:red;">(*)</b></label>
                                            <!--input name="hora_salida" id="hora_salida" type="text"class="form-control"  ng-model="vm.fdatos.hora_salida" required-->
                                            <select name="estatus" id="estatus" class="form-control" required ng-model="vm.fdatos.estatus_contrato" ng-disabled="vm.fdatos.usuario==undefined">
                                                <option ng-repeat="opcion in vm.estatus_contrato" value="{{opcion.id}}">{{opcion.estatus}}</option>
                                                
                                            </select>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>                 
                <input name="hcontrato" id="hcontrato" type="hidden" class="form-control" ng-model="vm.fdatos.hcontrato" readonly ng-disabled>
                        </div>

                        <!--div id="DivFormCustomer2" class="col-sm-12" style=" background-color: #fff;">                            
                           <div align="center"><p><b>Asignación de Horarios</b></p></div><br>
                            <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-clock-o"></i> Hora de Entrada <b style="color:red;">(*)</b></label>
                                            <input name="hora_entrada" id="hora_entrada" type="text"class="form-control"  ng-model="vm.fdatos.hora_entrada" required>
                                            <select name="hora_entrada" id="hora_entrada" class="form-control" required ng-model="vm.fdatos.hora_entrada" ng-disabled="vm.fdatos.usuario==undefined">
                                                <option value="06:00:00">6:00</option>
                                                <option value="07:00:00">7:00</option>
                                                <option value="08:00:00">8:00</option>
                                                <option value="09:00:00">9:00</option>
                                                <option value="10:00:00">10:00</option>
                                                <option value="11:00:00">11:00</option>
                                                <option value="12:00:00">12:00</option>
                                                <option value="13:00:00">13:00</option>
                                                <option value="14:00:00">14:00</option>
                                                <option value="15:00:00">15:00</option>
                                                <option value="16:00:00">16:00</option>
                                                <option value="17:00:00">17:00</option>
                                            </select>                                          
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-clock-o"></i> Duración de Almuerzo <b style="color:red;">(*)</b></label>
                                            <input name="duracion_almuerzo" min="1" pattern="^[0-9]+" string-to-number id="duracion_almuerzo" type="number"class="form-control"  ng-model="vm.fdatos.duracion_almuerzo" required ng-disabled="vm.fdatos.usuario==undefined">                                          
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-clock-o"></i> Hora de Salida <b style="color:red;">(*)</b></label>
                                            <input name="hora_salida" id="hora_salida" type="text"class="form-control"  ng-model="vm.fdatos.hora_salida" required>
                                            <select name="hora_salida" id="hora_salida" class="form-control" required ng-model="vm.fdatos.hora_salida" ng-disabled="vm.fdatos.usuario==undefined">
                                                <option value="11:00:00">11:00</option>
                                                <option value="12:00:00">12:00</option>
                                                <option value="13:00:00">13:00</option>
                                                <option value="14:00:00">14:00</option>
                                                <option value="15:00:00">15:00</option>
                                                <option value="16:00:00">16:00</option>
                                                <option value="17:00:00">17:00</option>
                                                <option value="18:00:00">18:00</option>
                                                <option value="19:00:00">19:00</option>
                                                <option value="20:00:00">20:00</option>
                                                <option value="21:00:00">21:00</option>
                                                <option value="22:00:00">22:00</option>
                                            </select>                                            
                                        </div>
                                    </div>
                                </div>
                            </div> 
                             <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-clock-o"></i> Break 1</label>
                                            <input name="break_1" id="break_1" class="form-control" ng-model="vm.fdatos.break_1" ng-disabled="vm.fdatos.usuario==undefined">
                                               
                                                                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-clock-o"></i> Break 2</label>
                                            <input name="break_2" id="break_2" class="form-control" ng-model="vm.fdatos.break_2" ng-disabled="vm.fdatos.usuario==undefined">
                                               
                                                                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                       </div-->

                          
                         <div id="DivFormCustomer3" class="col-sm-12" style=" background-color: #fff;">                            
                           <div align="center"><b>Asignación de vacaciones</b> 
                           <a data-toggle="modal" ng-show="vm.fdatos.usuario>0" title='Agregar mas vacaciones' data-target="#modal_agregar_mas_vacaciones"><i class="fa fa-plus-square"></i></a>
                           
                           <a ng-show="vm.fdatos.usuario>0" title='Ver Historial de Vacaciones' ng-click="vm.consultar_historico_vacaciones()"><i class="fa fa-eye"></i></a>
                           </div>
                           <br>
                           <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-calendar tx-16 lh-0 op-6"></i> Fecha Vacaciones desde </label>
                                            <input name="fecha_vacaciones_desde" id="fecha_vacaciones_desde" type="text"class="form-control" ng-model="vm.fecha_vacaciones_desde"  ng-change="vm.contar_dias_vacaciones()" ng-disabled="vm.fdatos.usuario==undefined">                                          
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-calendar tx-16 lh-0 op-6"></i> Fecha Vacaciones Hasta </label>
                                            <input name="fecha_vacaciones_hasta" id="fecha_vacaciones_hasta" type="text"class="form-control" ng-model="vm.fecha_vacaciones_hasta" ng-change="vm.contar_dias_vacaciones()"  ng-disabled="vm.fdatos.usuario==undefined">                                          
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-calendar tx-16 lh-0 op-6"></i> Días de vacaciones </label>
                                            <input name="dias_vacaciones" id="dias_vacaciones" type="text"class="form-control" ng-model="vm.fdatos.dias_vacaciones" ng-disabled="vm.fdatos.usuario==undefined" readonly>                                          
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-clock-o"></i> Estatus Vacaciones</label>
                                            <!--input name="hora_salida" id="hora_salida" type="text"class="form-control"  ng-model="vm.fdatos.hora_salida" required-->
                                            <select name="estatus_vacaciones" id="estatus_vacaciones" class="form-control"  ng-model="vm.fdatos.estatus_vacaciones" ng-disabled="vm.fdatos.usuario==undefined">
                                                <option ng-repeat="opcion in vm.estatus_vacaciones" value="{{opcion.id}}">{{opcion.estatus}}</option>
                                                
                                            </select> 

                                        </div>
                                        <input name="hvacaciones" id="hvacaciones" type="hidden" class="form-control" ng-model="vm.fdatos.hvacaciones" readonly ng-disabled> 
                                    </div>
                                </div>
                            </div>                     
                
                        </div>
<hr ng-show="vm.fdatos.final_laborable!=false">
    <div align="center" ng-show="vm.fdatos.final_laborable!=false"><i class="fa fa-check-circle"></i> <b>Dias Laborales Asignados.</b></div>
<hr ng-show="vm.fdatos.final_laborable!=false">
        <div class="bd bd-gray-300 rounded table-responsive" ng-show="vm.fdatos.final_laborable!=false">
            <table class="table table-hover mg-b-0"> 
                <thead>
                    <tr>
                    <td><i class="fa fa-clock-o"></i> Días Laborables: <b style="color:red;">(*)</b></td>
                     <td><i class="fa fa-clock-o"></i> Hora Entrada: <b style="color:red;">(*)</b></td> 
                      <td><i class="fa fa-clock-o"></i> Hora Salida: <b style="color:red;">(*)</b></td>                    
                </tr>
                </thead>
                <tbody >
                      <tr ng-show="vm.fdatos.final_laborable==false"> 
                     <td colspan="7" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>           
                    </tr>
                    <tr ng-repeat="dato in vm.fdatos.final_laborable" ng-class-odd="odd"> 
                    <td><div class="td-usuario-table">{{dato.dia_laborable}}</div></td>                                      
                    <td><div class="td-usuario-table">{{dato.hora_entrada}}</div></td>
                    <td><div class="td-usuario-table">{{dato.hora_salida}}</div></td>
                </tr>                   
                </tbody>
<script>
      $(function(){
        'use strict'

        // Input Masks
        $('#fecha_vacaciones_desde1').mask('99/99/9999');
        $('#fecha_vacaciones_hasta1').mask('99/99/9999'); 
        $('#hora_entrada').mask('99:99:99');
        $('#hora_salida').mask('99:99:99'); 

      });
    </script>
            </table>
        </div> 
<hr>
        <div align="center"><i class="fa fa-exclamation"></i> <b>Dias Laborales Para Asignadar.</b></div>
<hr>
        <div class="bd bd-gray-300 rounded table-responsive" ng-init="vm.consultar_dias_laborables()">
            <table class="table table-hover mg-b-0"> 
                <thead>
                    <tr>
                    
                    <td><i class="fa fa-clock-o"></i> Días Laborables: <b style="color:red;">(*)</b></td>
                     <td><i class="fa fa-clock-o"></i> Hora Entrada: <b style="color:red;">(*)</b></td> 
                      <td><i class="fa fa-clock-o"></i> Hora Salida: <b style="color:red;">(*)</b></td> 

                    <td><i class="fa fa-compass"></i> Acción</td>
                </tr>
                </thead>
                <tbody >
                      <tr ng-show="vm.detalle_dia_laborable==null"> 
                     <td colspan="7" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>           
                    </tr>
                    <tr ng-repeat="dato in vm.detalle_dia_laborable" ng-class-odd="odd"> 
                     

                    <td><div class="td-usuario-table">{{dato.dia_laborable}}</div></td>                                      
                    
                    <td><input name="hora_entrada" id="hora_entrada[$index]" type="text"class="form-control" ng-model="vm.fdatos.detalle_dia_laborable.hora_entrada[$index]" ng-disabled="vm.select_dia_laborables[dato.id]"  ></td>
                    
                    <td><input name="hora_salida" id="hora_salida[$index]" ng-disabled="vm.select_dia_laborables[dato.id]" type="text"class="form-control" ng-model="vm.fdatos.detalle_dia_laborable.hora_salida[$index]" ></td>
                    <td>    
                        <!--a ng-click="vm.borrar_row($index)" ng-show="vm.nivel_users==1" title='Eliminar Dia {{dato.nombre}}' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a-->
                         
                    <button type="button" ng-show="!vm.select_dia_laborables[dato.id]" ng-click="vm.agregar_dias($index,dato,dato.id,vm.fdatos.detalle_dia_laborable.hora_entrada[$index],vm.fdatos.detalle_dia_laborable.hora_salida[$index])" title='Agregar Dia {{dato.dia_laborable}}' ng-disabled="vm.fdatos.detalle_dia_laborable.hora_entrada[$index]==undefined || vm.fdatos.detalle_dia_laborable.hora_salida[$index]==undefined" class="btn btn-success btn-icon mg-r-5"><div><i class="fa fa-check-circle" style="color:white;"></i></div></button>                      
                       

                        <button type="button"  ng-show="vm.select_dia_laborables[dato.id]" ng-if="vm.nivel_users==1" ng-click="vm.quitardia($index,dato.id,dato)" title='Eliminar Dia {{dato.dia_laborable}}' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></button> 
                    </td>
                </tr>                   
                </tbody>
<script>
      $(function(){
        'use strict'

        // Input Masks
        $('#fecha_vacaciones_desde1').mask('99/99/9999');
        $('#fecha_vacaciones_hasta1').mask('99/99/9999'); 
        $('#hora_entrada').mask('99:99:99');
        $('#hora_salida').mask('99:99:99'); 

      });
    </script>
            </table>
        </div>  
                        <div id="crear" class="col-sm-12" > 
                        	<button class="btn btn-sm btn-warning" type="button" id="limpiar_input" ng-click="vm.limpiar()"><i class="fa fa-refresh"></i> Limpiar</button>
                        	
                        	<button ng-show="vm.fdatos.usuario>0" class="btn btn-sm btn-info" type="submit" id="guardar" ng-disabled="frmhorarios.$invalid"><i class="fa fa-save"></i> Asignar Horarios</button>                        

                        	<button class="btn btn-sm btn-danger" ng-show="vm.fdatos.usuario>0" ng-disabled="vm.nivel_users!=1" type="button" id="borrar" ng-click="vm.borrar_horarios()"><i class="fa fa-trash"></i> Borrar Horarios</button>

                    	</div>

                      
                    </div>
                </form>
        </div>            
            </div>
        </div>
    </div>
     <!-- Agregar Mas Vacaciones Modal-->    
     <div class="modal fade" id="modal_agregar_mas_vacaciones" role="dialog" style="display: none; padding-right: 17px;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar Vacaciones</h4>
            </div>

            <div class="modal-body" style="padding:0;"><br>
                   <form id="frmvacacionesadicionales" name="frmvacacionesadicionales" ng-submit="submitFormVaca($event)" autocomplete="off">
                   <div id="DivFormCustomer3" class="col-sm-12" style=" background-color: #fff;">       
                           <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-calendar tx-16 lh-0 op-6"></i> Fecha vacaciones desde </label>
                                            <input name="fecha_vacaciones_desde1" id="fecha_vacaciones_desde1" type="text"class="form-control" ng-model="vm.fecha_vacaciones_desde1" required ng-change="vm.contar_dias_vacaciones1()" ng-disabled="vm.fdatos.usuario==undefined">                                          
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-calendar tx-16 lh-0 op-6"></i> Fecha vacaciones Hasta </label>
                                            <input name="fecha_vacaciones_hasta1" id="fecha_vacaciones_hasta1" type="text"class="form-control" ng-model="vm.fecha_vacaciones_hasta1" ng-change="vm.contar_dias_vacaciones1()" required ng-disabled="vm.fdatos.usuario==undefined">                                          
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-calendar tx-16 lh-0 op-6"></i> Días de vacaciones </label>
                                            <input name="dias_vacaciones1" id="dias_vacaciones1" type="text"class="form-control" ng-model="vm.fdatos_extras.dias_vacaciones1" ng-disabled="vm.fdatos.usuario==undefined" readonly>                                          
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-sm-6" >
                                <div>
                                     <div class="input-group">                                       
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-clock-o"></i> Estatus Vacaciones</label>
                                            <!--input name="hora_salida" id="hora_salida" type="text"class="form-control"  ng-model="vm.fdatos.hora_salida" required-->
                                            <select name="estatus_vacaciones1" id="estatus_vacaciones1" class="form-control" required ng-model="vm.fdatos_extras.estatus_vacaciones1" ng-disabled="vm.fdatos.usuario==undefined">
                                                <option ng-repeat="opcion in vm.estatus_vacaciones" value="{{opcion.id}}">{{opcion.estatus}}</option>
                                                
                                            </select>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>               
                        </div>
                       </form>
             
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <!--button type="submit" class="btn btn-primary" ng-disabled="frmvacacionesadicionales.$invalid" ng-click="vm.confirmar_credenciales()"><i class="fa fa-check"></i> Confirmar</button-->
                <button class="btn btn-primary" type="button" id="guardar" ng-disabled="frmvacacionesadicionales.$invalid" ng-click="vm.submitFormVaca()"><i class="fa fa-save"></i> Guardar</button>
            </div> 
        </div>
    </div>
</div>
    <!-- Agregar Mas Vacaciones Modal--> 
     <!-- Historico de Vacaciones Modal-->    
     <div class="modal fade" id="modal_historico_vacaciones" role="dialog" style="display: none; padding-right: 17px;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Histórico de Vacaciones</h4>
            </div>

            <div class="modal-body" style="padding:0;">
                
            	 <div class="bd bd-gray-300 rounded table-responsive">
                  
    		  	 <table class="table table-hover mg-b-0"> 
                     <thead>
                    <tr>
                    
                    <td><i class="fa fa-calendar"></i> Desde</td>
                    <td><i class="fa fa-calendar"></i> Hasta</td>
                    <td><i class="fa fa-calendar"></i> Días Vacaciones</td>
                    <td><i class="fa fa-dot-circle-o"></i> Estatus</td>                                           
                    <!--td><i class="fa fa-dedent"></i> Acción</td-->
                </tr>
                </thead>
                <tbody>
                  
                    <tr ng-repeat="dato in vm.tvacaciones | filter:paginate201" ng-class-odd="odd"> 
                    
                    <td align="center"><div class="td-usuario-table">{{dato.fecha_desde}}</div></td>
                    <td align="center"><div class="td-usuario-table">{{dato.fecha_hasta}}</div></td>
                    <td align="center"><div class="td-usuario-table">{{dato.dias_vacaciones}}</div></td>
                    <td align="center"><div class="td-usuario-table">
                        <select name="estatus_vacaciones" id="estatus_vacaciones" class="form-control" required ng-model="vm.tvacaciones[$index].estatus" ng-change="vm.actualizar_historico($index,dato)">
                            <option ng-repeat="opcion in vm.estatus_vacaciones" value="{{opcion.id}}">{{opcion.estatus}}</option>
                        </select></div></td>                             
                    <!--td> 
                        <a ng-show="!vm.select_controlador[dato.id]" ng-click="vm.agregar_controlador($index,dato,dato.id)" title='Agregar Controladores {{dato.controller}}' class="btn btn-success btn-icon mg-r-5"><div><i class="fa fa-check-circle" style="color:white;"></i></div></a>  
                        <a ng-show="vm.select_controlador[dato.id]" ng-if="vm.nivel_users==1" ng-click="vm.quitarcontrolador($index,dato.id,dato)" title='Eliminar Controladores {{dato.controller}}' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a> 
                    </td-->
                </tr>                   
                </tbody>
            </table><div align="center">                  

              <div class='btn-group' align="center">
                      <pagination total-items="totalItems201" ng-model="currentPage201"  
                    max-size="5" boundary-links="true"  
                    items-per-page="numPerPage201" class="pagination-sm">  
              </pagination>
                    </div>
            </div>
        </div>      




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <!--button type="button" class="btn btn-primary" ng-click="vm.confirmar_credenciales()"><i class="fa fa-check"></i> Confirmar</button-->
            </div> 
        </div>
    </div>
</div>
    <!-- Historico de Vacaciones Modal-->   
</div>  
  <script>
      $(function(){
        'use strict'

        // Input Masks
        $('#fecha_vacaciones_desde').mask('99/99/9999');
        $('#fecha_vacaciones_hasta').mask('99/99/9999');
       	$('#fecha_inicio_contrato').mask('99/99/9999');
       	$('#fecha_fin_contrato').mask('99/99/9999');
       	$('#fecha_perioro_prueba').mask('99/99/9999');





      });
    </script>
<?php $this->load->view('view_footer');?>
</body>
<div id="cargando" class="loader loader-default"  data-text="Cargando registros, Por Favor Espere..."></div>
<div id="guardando" class="loader loader-default"  data-text="Guardando Horarios, Por Favor Espere..."></div>
</html>