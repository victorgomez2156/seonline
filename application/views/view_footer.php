   <div id="cookies-overlay" class="cookies-overlay" style="display: none;"><div class="cookies-wrapper">
 <a href="#" class="close">×</a>
 <p>
  Utilizamos cookies propios y de terceros para mejor tu experiencia en nuestro sistema analizando tu navegación. Si sigues navegando estarás aceptando su uso.
  <a target="_blank" href="https://www.weblogssl.com/cookies">Más información </a>
 </p>
</div></div>
  <div class="footer">
   <p><a href="http://somostuwebmaster.es" style=" color:white; ">Powered by SomosTuWebMaster.es - 2019</a></p>
      </div>

      <div class="loader_page" id="loader_div" style="display: none;">
            <div class="lds-grid"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </div><!-- Modal -->

<input id="IdUsers" type='hidden' value="<?php echo $this->session->userdata('id');?>" readonly></input>      
<input id="nombres" type='hidden' value="<?php echo $this->session->userdata('nombres');?>" readonly></input>        
<input id="apellidos" type='hidden' value="<?php echo $this->session->userdata('apellidos');?>" readonly></input> 
<input id="usuario" type='hidden' value="<?php echo $this->session->userdata('usuario');?>" readonly></input> 
<input id="NivelUsers" type='hidden' value="<?php echo $this->session->userdata('nivel');?>" readonly></input> 
<input id="sesion_clientes" type='hidden' value="<?php echo $this->session->userdata('sesion_clientes');?>" readonly></input> 
<input id="ApiKey" type='hidden' value="<?php echo $this->session->userdata('key');?>" readonly></input> 
<input id="correo_electronico" type='hidden' value="<?php echo $this->session->userdata('correo_electronico');?>" readonly></input> 
<input id="oficina" type='hidden' value="<?php echo $this->session->userdata('oficina');?>" readonly></input>            
</div>
<script> 
    $(document).ready(function() {
    $.material.init();});
</script>
<!--script src="<?php echo ESTILOS;?>js/vanillaCalendar.js?v=0.54020700 1550163945"></script--> 
<script src="<?php echo ESTILOS;?>js/check_explorer.js"></script>
<script src="<?php echo ESTILOS;?>js/jquery.maskedinput.js"></script>
<!--   Control Presupuesto   -->
<script src="<?php echo ESTILOS;?>js/presupuesto.js?v=0.54159200 1550163945"></script>
<script src="<?php echo ESTILOS;?>js/impuesto.js?v=0.54159800 1550163945"></script>
<!--   Core JS Files   -->