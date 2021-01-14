<html lang="en">
<head>
  <?php $this->load->view('view_header');?> 
</head>
<body>
<div ng-app="appPrincipal" ng-controller="Controlador_Consultas as vm">

<?php $this->load->view('templates/side_menu');?>  

<div  class="container">
    <div class="tab-content">
    <h2  id="t-0000" style="margin-top: 0px;">Asistencias General</h2>
    <div id="t-0001">
       
           
            <div id="t-0003">   
           <div id="DivFormCustomer" class="col-sm-12" style="clear: both; padding: 15px;">           
                       
                    
<div id="DivFormCustomer" class="col-sm-12" style="clear: both; padding: 15px;">

<div id="DivFormCustomer2" class="col-sm-12" style=" background-color: #fff;" ng-init="vm.fecha_server()">                            
    <form id="frmasistenciageneral" name="frmasistenciageneral" ng-submit="submitFormReporteGeneal($event)" autocomplete="off">
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
        </div>
        <!--div id="crear" class="col-sm-12" align="center">
                <label style="color: black;">Tipo Consulta: </label> 
                <input type="radio" id="Normal" value="1" name="tipo_consulta" ng-model="vm.selec_consulta"> Normal 
                <input type="radio" id="Detallado" value="2" name="tipo_consulta" ng-model="vm.selec_consulta"> Detallado 
        </div--><br>
        <div id="crear" class="col-sm-12" align="center"> 
                <!--button class="btn btn-sm btn-info" type="button" id="limpiar_input" ng-click="vm.limpiar()"><i class="fa fa-refresh"></i> Limpiar</button-->
                <button class="btn btn-sm btn-primary" id="Generar Consulta" ng-disabled="frmasistenciageneral.$invalid"><i class="fa fa-search"></i> Consultar</button>
        </div><br>
            <div align="center" class="col-sm-12"><br>
                <span class="material-input" ng-show="vm.spinner==1"><img src="application/libraries/estilos/img/ajax-loader.gif"> Buscando datos, Por Favor Espere...</span>
                <span class="material-input" ng-show="vm.resultado==1" style="color:green;"><i class="fa fa-check-circle"></i> Mostrando datos...</span>
                <span class="material-input" ng-show="vm.resultado==2" style="color:red;"><i class="fa fa-close"></i> No se han encontrado datos en el rango de fecha seleccionado...</span> <br> 
                    
            </div>
    </form>

      <div class="bd bd-gray-300 rounded table-responsive">
        <a ng-show="vm.excel_pdf==1" title='Exportar PDF' target="_black" class="btn btn-info" href="reportes/Exportar_Pdf/Reporte_General/{{vm.desde}}/{{vm.hasta}}"><div><i class="fa fa-file" style="color:white;"></i></div></a>

        <a ng-show="vm.excel_pdf==1" title='Exportar Excel' class="btn btn-primary" ng-click="vm.exportar_excel_general()"><div><i class="fa fa-file-excel-o" style="color:white;"></i></div></a>
        
        <a ng-show="vm.excel==true" title='Descargar Reporte Excel' href="reportes/{{vm.nombre_reporte}}" class="btn btn-success" download><div><i class="fa fa-cloud-download" style="color:white;"></i></div></a>

        <br>
            <span class="material-input" style="margin-left: 5px;"><i class="fa fa-bars"></i> LISTADO DE EMPLEADOS</span><br>           
            <table class="table table-hover mg-b-0"> 
                <thead>
                  <tr>
                    <td><i class="fa fa-users"></i> <b>Empleados</b></td>
                    <td><i class="fa fa-clock-o"></i> <b>Total Horas</b></td>
                    <td><i class="fa fa-clock-o"></i> <b>Horas</b></td>
                </tr>
                </thead>
                <tbody>
                    <tr ng-show="vm.tResultado==undefined"> 
                         <td colspan="7" align="center"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</td>                   
                    </tr> 
                    <tr ng-repeat="dato in vm.tResultado | filter:paginate35 | filter:search" ng-class-odd="odd"> 
                        <td><div class="td-usuario-table">{{dato.nombres}} {{dato.apellidos}}</div></td> 
                        <td><div class="td-usuario-table">{{dato.total_con_descuento}}</div></td>
                        <td><div class="td-usuario-table">{{dato.decimales}}</div></td>
                    </tr>             
                </tbody>
                <tfoot> <td><i class="fa fa-users"></i> <b>Empleados</b></td>
                    <td><i class="fa fa-clock-o"></i> <b>Total Horas</b></td>
                    <td><i class="fa fa-clock-o"></i> <b>Horas</b></td>
                </tfoot>
            </table>
            <div align="center">                 
            <div class='btn-group' align="center">
                <pagination total-items="totalItems35" ng-model="currentPage35" max-size="5" boundary-links="true" items-per-page="numPerPage35" class="pagination-sm">  
                </pagination>
            </div>
        </div>
        </div> 

       

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