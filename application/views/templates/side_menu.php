<div ng-controller="Validador as vm">
<nav class="navbar navbar-expand-lg navbar-light bg-light rounded border-bottom box-shadow"  >
    <a class="navbar-brand" href="<?php echo base_url();?>"><img src="<?php echo ESTILOS;?>img/logo_web.png" height="50" style=" margin-top: -20px;">      
    </a>
    
       
    <div class="collapse navbar-collapse" style="max-width: 200px;">
        <div style=" text-transform: capitalize;color: rgb(255, 117, 63);max-width: 200px;"><i class="fa fa-user"></i> <?php echo $this->full_name;?></div>
        <div style=" text-transform: capitalize;color: rgb(120, 120, 120);max-width: 200px;"><i class="fa fa-home"></i> <?php echo $this->session->userdata('oficina');?></div>
        
        
    </div>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
          <!-- Dropdown -->
            <li class="nav-item dropdown" ng-show="vm.nivel_users==1 || vm.nivel_users==2"><a class="nav-link dropdown-toggle" href="#" id="navbardrop1" data-toggle="dropdown" ><i class="fa fa-object-group"></i> Maestros</a>
                <div class="dropdown-menu">
                <div class="dropdown-header">Maestros</div>
                    <a class="dropdown-item"  href="Usuarios"><i class="fa fa-users"></i> Usuarios</a>
                    <a class="dropdown-item"  href="Oficinas"><i class="fa fa-industry"></i> Oficinas</a>                    
                  <a class="dropdown-item"  href="Horarios"><i class="fa fa-clock-o"></i> Horarios</a>
                </div>
            </li> 
           
             <li class="nav-item dropdown" ng-show="vm.nivel_users==1 || vm.nivel_users==2"><a class="nav-link dropdown-toggle" href="#" id="navbardrop1" data-toggle="dropdown" ><i class="fa fa-search"></i> Consultas</a>
                <div class="dropdown-menu">
                <div class="dropdown-header">Consultas</div>                  
                    <!--a class="dropdown-item"  href="Consultas_Contrasena"><i class="fa fa-key"></i> Contraseñas</a-->
                    <a class="dropdown-item"  href="Consultas_Asistencias"><i class="fa fa-area-chart"></i> Asistencia</a>
                    <a class="dropdown-item"  href="Asistencia_General"><i class="fa fa-line-chart"></i> Asistencia General</a>
                </div>
            </li> 
             <li class="nav-item" ng-if="vm.nivel_users==1 || vm.nivel_users==2" ><a class="nav-link" href="Notificaciones" id="navbardrop1" ng-init="vm.count_notificaciones()">
              <i class="fa fa-bell-slash-o" ng-show="vm.total_notificaciones==0"></i>
              <i class="fa fa-bell" ng-show="vm.total_notificaciones>0"></i> Notificaciones 
              <span class="badge badge-pill badge-success" ng-show="vm.total_notificaciones>0" style="background: #D10024;">{{vm.total_notificaciones}}</span></a>               
            </li>     
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="javascript:void;" id="cerrar-sesion" data-username="<?php $this->full_name;?> " data-end-url="<?php echo 'Login/desconectar';?>" onclick="javascript:void(0)"><span class="fa fa-sign-in"></span> Cerrar Sesión</a></li>
          </ul>
      </div>  
</nav>  
</div>
 <script>
$(function(){
    var username = "<?php echo $this->full_name;?>";
 
  $("#cerrar-sesion").on('click', function(){
    bootbox.confirm( "<b>" + username + "</b> ¿Estás seguro que quieres cerrar sesi&oacute;n? ", function(result){ 
      if( result == true ){ 
       
        document.location.href = 'Login/desconectar';    
      } 
    });       
  });
}); 
 
</script>