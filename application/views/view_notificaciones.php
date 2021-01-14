<html lang="en">
<head>
   <?php $this->load->view('view_header');?>
</head>
<body>
<div ng-app="appPrincipal" ng-controller="ControllerNotificaciones as vm">
<?php $this->load->view('templates/side_menu');?>    

<div class="container" >
    <div class="tab-content">
    <h2  id="t-0000" style="margin-top: 0px;"><i class="fa fa-bell"></i> Notificaciones</h2>
    <div id="t-0001">
        
           
            <div id="t-0003">               
                      <br>
                              <!--Inicio Filtro 0 -->      
        <div ng-show="vm.filtro==0">       
        
        <div class="bd bd-gray-300 rounded table-responsive" ng-init="vm.notificaciones_pendientes()">
            <table class="table table-hover mg-b-0"> 
                <thead>
                    <tr>               
                    <td><i class="fa fa-user"></i> Empleado</td>
                    <td><i class="fa fa-calendar"></i> Fecha</td>
                    <td><i class="fa fa-clock-o"></i> Hora Entrada</td>
                    <td><i class="fa fa-clock-o"></i> Hora Salida</td>
                    <td><i class="fa fa-clock-o"></i> Total</td>                   
                    <td><i class="fa fa-dot-circle-o"></i> Tipo</td>
                    <td><i class="fa fa-dedent"></i> Acción</td>
                </tr>
                </thead>
                <tbody >
                      <tr ng-show="vm.TNotificacionesPendientes==null"> 
                     <td colspan="7" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>           
                    </tr>
                    <tr ng-repeat="dato in vm.TNotificacionesPendientes | filter:paginate | filter:search" ng-class-odd="odd">
                    <td><div class="td-usuario-table">{{dato.nombres}} {{dato.apellidos}}</div></td>
                     <td>
                      <div class="td-usuario-table">{{dato.fecha}}</div>                      
                    </td>
                    <td><div class="td-usuario-table">{{dato.horario_entrada}}</div></td>
                    <td><div class="td-usuario-table">{{dato.horario_salida}}</div></td>
                     <td><div class="td-usuario-table">{{dato.total_jornada}}</div></td>                 
                    <td>
                      <div class="td-usuario-table">
                          <div ng-switch on="dato.type">
                            <span ng-switch-when="4"><i class="fa fa-caret-square-o-right"></i> Cierre de Jornada</span>
                            <span ng-switch-when="3"><i class="fa fa-hand-o-left"></i> Cierre de Break</span>
                            <span ng-switch-when="6"><i class="fa fa-hand-o-left"></i> Cierre de Reunión</span>
                          </div>

                        <!--label ng-show="dato.type==1" style="color:green; text-align: center;"><i class="fa fa-caret-square-o-left"></i> Entrada</label>
                        <label ng-show="dato.type==2"  style="color:red; text-align: center;"><i class="fa fa-hand-o-right"></i> Salida de Break</label>
                        <label ng-show="dato.type==3"  style="color:blue; text-align: center;"><i class="fa fa-hand-o-left"></i> Regreso de Break</label>
                        <label ng-show="dato.type==4"  style="color:red; text-align: center;"><i class="fa fa-caret-square-o-right"></i> Jornada Finalizada</label-->
                      </div>
                    </td>
                    

                    <td>
                      <a title='Validar Asistencia Usuario: {{dato.nombres}} {{dato.apellidos}}' ng-click="vm.validar_asistencia($index,dato)" class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-eye" style="color:white;"></i></div></a>
                      
                  </td>
                </tr>                   
                </tbody>
            </table>
        </div>  
           <div align="center">
              <span class="store-qty"> <a ng-click="vm.notificaciones_pendientes()" title='Refrescar' class="btn btn-warning btn-icon mg-r-5"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       

              <div class='btn-group' align="center">
                      <pagination total-items="totalItems" ng-model="currentPage"  
                    max-size="5" boundary-links="true"  
                    items-per-page="numPerPage" class="pagination-sm">  
              </pagination>
                    </div>
            </div>


 <!-- Controladores Modal-->    
  <div class="modal fade" id="modal_admin_aprueba" role="dialog" style="display: none; padding-right: 17px;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" align="center"><i class="fa fa-user"></i> Empleado: {{vm.nombres}} {{vm.apellidos}}</h4>
            </div>
            <div class="modal-body" style="padding:12; overflow: scroll;width: 100%; height: 500px;">
                <div id="DivFormCustomer" class="col-sm-12" style="clear: both; padding: 15px;">
                        <form id="frmconfirmacionesempleados" name="frmconfirmacionesempleados" ng-submit="SubmitForm($event)" autocomplete="off">
                        <div id="DivFormCustomer2" class="col-sm-12" style=" background-color: #fff;">                            
                            <div class="col-sm-12" style="">
                                <div> 
                                <div class="input-group">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-calendar"></i> Fecha</label>
                                            <input name="fecha" id="fecha" type="text" maxlength="100" required onpaste="return false" oncut="return false" autocomplete="off" class="form-control" ng-model="vm.tdatamodal.fecha" ng-disabled="vm.validar_tipo>=0" readonly="readonly">
                                        </div>
                                    </div>                                   
                                    <div class="input-group">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-clock-o"></i> Hora Entrada <span ng-show="vm.validar_tipo==3 || vm.validar_tipo==6" style="color:red; ">(*)</span></label>
                                            <input name="horario_entrada" id="horario_entrada" type="text"class="form-control" ng-model="vm.tdatamodal.horario_entrada" required ng-disabled="vm.validar_tipo==0 || vm.validar_tipo==4">
                                        <span class="material-input"></span>
                                      </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><i class="fa fa-clock-o"></i> Hora Salida <span ng-show="vm.validar_tipo==4" style="color:red; ">(*)</span></label>
                                            <input name="horario_salida" id="horario_salida" type="text" class="form-control" ng-model="vm.tdatamodal.horario_salida" required ng-disabled="vm.validar_tipo==0 || vm.validar_tipo==3 || vm.validar_tipo==6">
                                        <span class="material-input"></span></div>
                                    </div>
                                                                   
                                    
                                    
                                </div>
                            </div>
                             <!--div class="col-sm-6" style="">
                                <div>
                                  
                                    <div class="input-group">
                                        <div class="form-group label-floating is-empty">
                                             <label class="control-label"><i class="fa fa-dot-circle-o"></i> Tipo</label>
                                            <input name="type" id="type" type="text" class="form-control" ng-disabled="vm.validar_tipo>=0" required ng-model="vm.tdatamodal.type" maxlength="100" onpaste="return false" oncut="return false" autocomplete="off">
                                        <span class="material-input"></span></div>
                                    </div>
                                </div>
                            </div-->                           
                            <input type="hidden" name="id" id="id" ng-model="vm.tdatamodal.id" required readonly>
                            <input type="hidden" name="estatus" id="estatus" ng-model="vm.tdatamodal.estatus" required readonly>
                        </div>
                         <div align="center">
                          <span style="text-align: justify; color: red;" ng-show="vm.tdatamodal.estatus==2">Pendiente de Aprobación.</span><br>
                    <button type="submit" class="btn btn-success" ng-disabled="frmconfirmacionesempleados.$invalid"><i class="fa fa-check-circle"></i> Confirmar Operación</button>

                    </div>
                    </form>
<div align="center" ng-show="vm.validar_tipo==3"><span style="text-align: justify;">El Empleado: <b>{{vm.nombres}} {{vm.apellidos}}</b> el día <b>{{vm.tdatamodal.fecha}}</b> no marcó regreso de break y ha indicado que regresó a las <b>{{vm.horario_entrada}}</b>, para un total de tiempo de break: <b>{{vm.jornada_final}}</b> . Si es correcto confirme la operación, en caso contrario dirijase al campo <b>Hora Entrada</b> y modifique la hora de regreso de break del empleado.</span>
</div>                 
<div align="center" ng-show="vm.validar_tipo==4"><span style="text-align: justify;">El Empleado: <b>{{vm.nombres}} {{vm.apellidos}}</b> el día <b>{{vm.tdatamodal.fecha}}</b> no marcó hora de salida y ha indicado que se retiró a las <b>{{vm.horario_salida}}</b>, para un total de tiempo laboral: <b>{{vm.jornada_final}}</b> . Si es correcto confirme la operación, en caso contrario dirijase al campo <b>Hora Salida</b> y modifique la hora de salida del empleado.</span>
</div>
<div align="center" ng-show="vm.validar_tipo==6"><span style="text-align: justify;">El Empleado: <b>{{vm.nombres}} {{vm.apellidos}}</b> el día <b>{{vm.tdatamodal.fecha}}</b> no marcó regreso de la reunión y ha indicado que regresó a las <b>{{vm.horario_entrada}}</b>, para un total de tiempo de reunión: <b>{{vm.jornada_final}}</b> . Si es correcto confirme la operación, en caso contrario dirijase al campo <b>Hora Entrada</b> y modifique la hora de regreso de reunión del empleado.</span>
</div>

<script>
      $(function(){
        'use strict'

        // Input Masks
        $('#horario_entrada').mask('99:99:99');
        $('#horario_salida').mask('99:99:99'); 

      });
    </script>
                     </div>    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
    <!-- Controladores Modal-->   


        </div>
<!--Final Filtro 0 --> 
            </div>
        </div>
    </div>
  
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