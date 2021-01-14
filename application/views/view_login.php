<html lang="es"> 
	<head>
    	<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="<?php echo ESTILOS;?>img/favicon.ico" >
        <title><?php echo TITULO;?> | Inicio Sesión</title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo ESTILOS;?>css/bootstrap2.css?v=0.66189000 1550161441" rel="stylesheet" />
        <link href="<?php echo ESTILOS;?>css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo ESTILOS;?>css/font-awesome.min.css" rel="stylesheet" />
        <script src="<?php echo ESTILOS;?>js/jquery-2.2.4.min.js" type="text/javascript"></script>
        <script src="<?php echo ESTILOS;?>js/bootstrap.min_old.js" type="text/javascript"></script>
        <script src="<?php echo ESTILOS;?>js/jquery.bootstrap.js" type="text/javascript"></script>
        <!-- Custom styles for this template -->
        <link href="<?php echo ESTILOS;?>css/signin.css?v=0.66192800 1550161441" rel="stylesheet" />
        <link href="<?php echo ESTILOS;?>css/presupuesto.css?v=0.66193200 1550161441" rel="stylesheet" />
        <link href="<?php echo ESTILOS;?>css-loader-master/dist/css-loader.css" rel="stylesheet" />
        <script src="<?php echo ESTILOS;?>js/bloqueador.js"></script> 
        <script src="<?php echo ESTILOS;?>js/md5.js"></script> 
     	<style>
	      	body
	      	{
	           /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f6f8f9+1,f1f1f1+70,eaeaea+70,eaeaea+70 */
				background: rgb(246,248,249); /* Old browsers */
				background: -moz-linear-gradient(top, rgba(246,248,249,1) 1%, rgba(241,241,241,1) 70%, rgba(234,234,234,1) 70%, rgba(234,234,234,1) 70%); /* FF3.6-15 */
				background: -webkit-linear-gradient(top, rgba(246,248,249,1) 1%,rgba(241,241,241,1) 70%,rgba(234,234,234,1) 70%,rgba(234,234,234,1) 70%); /* Chrome10-25,Safari5.1-6 */
				background: linear-gradient(to bottom, rgba(246,248,249,1) 1%,rgba(241,241,241,1) 70%,rgba(234,234,234,1) 70%,rgba(234,234,234,1) 70%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f6f8f9', endColorstr='#eaeaea',GradientType=0 ); /* IE6-9 */
	        }

.input-group {
  position: relative;
  display: flex;
  flex-wrap: wrap;
  align-items: stretch;
  width: 100%; }
  .input-group > .form-control, .dataTables_filter .input-group > input,
  .input-group > .custom-select,
  .input-group > .custom-file {
    position: relative;
    flex: 1 1 auto;
    width: 1%;
    margin-bottom: 0; }
    .input-group > .form-control + .form-control, .dataTables_filter .input-group > input + .form-control, .dataTables_filter .input-group > .form-control + input, .dataTables_filter .input-group > input + input,
    .input-group > .form-control + .custom-select, .dataTables_filter
    .input-group > input + .custom-select,
    .input-group > .form-control + .custom-file, .dataTables_filter
    .input-group > input + .custom-file,
    .input-group > .custom-select + .form-control, .dataTables_filter
    .input-group > .custom-select + input,
    .input-group > .custom-select + .custom-select,
    .input-group > .custom-select + .custom-file,
    .input-group > .custom-file + .form-control, .dataTables_filter
    .input-group > .custom-file + input,
    .input-group > .custom-file + .custom-select,
    .input-group > .custom-file + .custom-file {
      margin-left: -1px; }
  .input-group > .form-control:focus, .dataTables_filter .input-group > input:focus,
  .input-group > .custom-select:focus,
  .input-group > .custom-file .custom-file-input:focus ~ .custom-file-label {
    z-index: 3; }
  .input-group > .custom-file .custom-file-input:focus {
    z-index: 4; }
  .input-group > .form-control:not(:last-child), .dataTables_filter .input-group > input:not(:last-child),
  .input-group > .custom-select:not(:last-child) {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0; }
  .input-group > .form-control:not(:first-child), .dataTables_filter .input-group > input:not(:first-child),
  .input-group > .custom-select:not(:first-child) {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0; }
  .input-group > .custom-file {
    display: flex;
    align-items: center; }
    .input-group > .custom-file:not(:last-child) .custom-file-label,
    .input-group > .custom-file:not(:last-child) .custom-file-label::after {
      border-top-right-radius: 0;
      border-bottom-right-radius: 0; }
    .input-group > .custom-file:not(:first-child) .custom-file-label {
      border-top-left-radius: 0;
      border-bottom-left-radius: 0; }

.input-group-prepend,
.input-group-append {
  display: flex; }
  .input-group-prepend .btn, .input-group-prepend .sp-container button, .sp-container .input-group-prepend button,
  .input-group-append .btn,
  .input-group-append .sp-container button, .sp-container
  .input-group-append button {
    position: relative;
    z-index: 2; }
  .input-group-prepend .btn + .btn, .input-group-prepend .sp-container button + .btn, .sp-container .input-group-prepend button + .btn, .input-group-prepend .sp-container .btn + button, .sp-container .input-group-prepend .btn + button, .input-group-prepend .sp-container button + button, .sp-container .input-group-prepend button + button,
  .input-group-prepend .btn + .input-group-text,
  .input-group-prepend .sp-container button + .input-group-text, .sp-container
  .input-group-prepend button + .input-group-text,
  .input-group-prepend .input-group-text + .input-group-text,
  .input-group-prepend .input-group-text + .btn,
  .input-group-prepend .sp-container .input-group-text + button, .sp-container
  .input-group-prepend .input-group-text + button,
  .input-group-append .btn + .btn,
  .input-group-append .sp-container button + .btn, .sp-container
  .input-group-append button + .btn,
  .input-group-append .sp-container .btn + button, .sp-container
  .input-group-append .btn + button,
  .input-group-append .sp-container button + button, .sp-container
  .input-group-append button + button,
  .input-group-append .btn + .input-group-text,
  .input-group-append .sp-container button + .input-group-text, .sp-container
  .input-group-append button + .input-group-text,
  .input-group-append .input-group-text + .input-group-text,
  .input-group-append .input-group-text + .btn,
  .input-group-append .sp-container .input-group-text + button, .sp-container
  .input-group-append .input-group-text + button {
    margin-left: -1px; }

.input-group-prepend {
  margin-right: -1px; }

.input-group-append {
  margin-left: -1px; }

.input-group-text {
  display: flex;
  align-items: center;
  padding: 0.65rem 0.75rem;
  margin-bottom: 0;
  font-size: 0.875rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  text-align: center;
  white-space: nowrap;
  background-color: #e9ecef;
  border: 1px solid #ced4da;
  border-radius: 3px; }
  .input-group-text input[type="radio"],
  .input-group-text input[type="checkbox"] {
    margin-top: 0; }

.input-group-lg > .form-control, .dataTables_filter .input-group-lg > input,
.input-group-lg > .input-group-prepend > .input-group-text,
.input-group-lg > .input-group-append > .input-group-text,
.input-group-lg > .input-group-prepend > .btn, .sp-container
.input-group-lg > .input-group-prepend > button,
.input-group-lg > .input-group-append > .btn, .sp-container
.input-group-lg > .input-group-append > button {
  height: calc(2.64063rem + 2px);
  padding: 0.5rem 1rem;
  font-size: 1.09375rem;
  line-height: 1.5;
  border-radius: 0.3rem; }

.input-group-sm > .form-control, .dataTables_filter .input-group-sm > input,
.input-group-sm > .input-group-prepend > .input-group-text,
.input-group-sm > .input-group-append > .input-group-text,
.input-group-sm > .input-group-prepend > .btn, .sp-container
.input-group-sm > .input-group-prepend > button,
.input-group-sm > .input-group-append > .btn, .sp-container
.input-group-sm > .input-group-append > button {
  height: calc(1.64844rem + 2px);
  padding: 0.25rem 0.5rem;
  font-size: 0.76563rem;
  line-height: 1.5;
  border-radius: 0.2rem; }

.input-group > .input-group-prepend > .btn, .sp-container .input-group > .input-group-prepend > button,
.input-group > .input-group-prepend > .input-group-text,
.input-group > .input-group-append:not(:last-child) > .btn, .sp-container
.input-group > .input-group-append:not(:last-child) > button,
.input-group > .input-group-append:not(:last-child) > .input-group-text,
.input-group > .input-group-append:last-child > .btn:not(:last-child):not(.dropdown-toggle), .sp-container
.input-group > .input-group-append:last-child > button:not(:last-child):not(.dropdown-toggle),
.input-group > .input-group-append:last-child > .input-group-text:not(:last-child) {
  border-top-right-radius: 0;
  border-bottom-right-radius: 0; }

.input-group > .input-group-append > .btn, .sp-container .input-group > .input-group-append > button,
.input-group > .input-group-append > .input-group-text,
.input-group > .input-group-prepend:not(:first-child) > .btn, .sp-container
.input-group > .input-group-prepend:not(:first-child) > button,
.input-group > .input-group-prepend:not(:first-child) > .input-group-text,
.input-group > .input-group-prepend:first-child > .btn:not(:first-child), .sp-container
.input-group > .input-group-prepend:first-child > button:not(:first-child),
.input-group > .input-group-prepend:first-child > .input-group-text:not(:first-child) {
  border-top-left-radius: 0;
  border-bottom-left-radius: 0; }

	    </style>
	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo PATH_ESTILOS_JS.'bootbox.js'?>"></script>
	 <script type="text/javascript"> 
$(document).ready(function() 
{
  
  $('#formulario').submit(function()
  {
$("#sesion").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
  $.ajax({
    type: 'POST',
     url: $(this).attr('action'),
    data: $(this).serialize(),
    success: function(data) {
      //alert(data);
      if (data == 1)
      {
          $("#sesion").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
        bootbox.alert({
            title:'Datos Incorrectos',
            message: "El usuario o clave son incorrectas. Inténtelo de Nuevo",
            size: 'large'
        });
      }

      if(data==7){
         $("#sesion").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
        bootbox.alert({
          title:'Usuario no encontrado',
            message: "El usuario no se encuentra registrado en la base de datos",
            size: 'large'
        });
        
      }
      
      if(data == 6){
        
       $("#sesion").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
        bootbox.alert({
          title:'Seguridad',
            message: "El usuario ha sido bloqueado por seguridad",
            size: 'large'
        });
      }
       if (data == 9)
      {
          $("#sesion").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
        bootbox.alert({
          title:'Oficina',
            message: "Actualmente la oficina no se encuentra disponible por lo que no es posible iniciar sesión",
            size: 'large'
        });
      }         
      
      if (data == 2)
      {
          $("#sesion").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
      url = "<?php echo base_url('Principal') ?>";
      $(location).attr('href',url);
      }
      
      
    }
    })
      return false;
  }); 
   
});
</script>
    </head>
    
    <body class="text-center">
    	<form method="POST" action="<?=site_url('Login/accesando')?>" name="formulario" id="formulario" accept-charset="UTF-8" class="form-signin" style="margin-top: 5%;">
	      	<img class="mb-4" src="<?php echo ESTILOS;?>img/logo_web.png" alt="" width="280" >
	         <div class="col-lg-12 mg-t-20 mg-lg-t-0">
              <label style="color:black;" ><i class="fa fa-at"></i> Usuario o Correo Electrónico:</label>
             
                <input type="text" class="form-control" name="usuario" id="usuario"  placeholder="Ingrese su Usuario o Correo Electrónico" required autofocus="">
               
             <br>
              <label style="color:black;" ><i class="fa fa-key"></i> Contraseña:</label>
             
                <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese su Contraseña" required>
               
            
            </div>	               
	        <button class="btn btn-lg btn-primary btn-block" type="submit" onclick="cifrar()" id="login"><i class="fa fa-sign-in"></i> Iniciar Sesión</button>
        </form>
      
      	<div class="footer">
            <p><a href="http://somostuwebmaster.es" style=" color:white;">Powered by SomosTuWebMaster.es - 2019</a></p>
     	 </div>
      	<script>        
        checkBrowser();
        function checkBrowser()
        {
            // Opera 8.0+
            var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
            // Firefox 1.0+
            var isFirefox = typeof InstallTrigger !== 'undefined';
            // Safari 3.0+ "[object HTMLElementConstructor]" 
            var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
            // Internet Explorer 6-11
            var isIE = /*@cc_on!@*/false || !!document.documentMode;
            // Edge 20+
            var isEdge = !isIE && !!window.StyleMedia;
            // Chrome 1+
            var isChrome = !!window.chrome && !!window.chrome.webstore;
            // Blink engine detection
            var isBlink = (isChrome || isOpera) && !!window.CSS;
            if (isIE) 
            {
              var html = '';
              html += '<div style=" text-align: center;width: 100%;color: rgb(28, 95, 152);">';
                html += '<h1>Lo sentimos, su navegador no es compatible</h1>';
                html += '<h3>Recomendamos usar Google Chrome </h3>';
                html += '<a href="https://www.google.com/chrome/"><img src="/img/Google_Chrome_icon.png"  height="80" ></a>';
              html += '</div>'
              document.getElementsByTagName("BODY")[0].innerHTML = html;
            }
        }        
      </script>

<script type="text/javascript" language="javascript">
$(function(){
$("#login").on('click',function(){
var error = false;
var errmsg = '';

if($("#usuario").val()==""){
  error = true;
  errmsg += "<p>* Debe Especificar un usuario en el campo <b>USUARIO</b></p>";
}

if($("#password").val().length < 4){
  error = true;
  errmsg += "<p>* La contraseña no puede estar vacía o tener menos de <b>4 CARACTERES</b>.</p>";
}

if(error == true){
  bootbox.dialog({
  title: '<span class="text-danger">Error Campos Obligatorios Vacíos</span>',
  message: '<div>' + errmsg + '</div>',
  buttons: {
    success: {
      label: "Continuar",
    className: "btn-primary",
    callback: function() {
      bootbox.close;
        }
    }
  }
  });

  error = false;
  errmsg = "";

  return false;

  }
  });
});
</script>
<script>
    function cifrar(){
      var input_pass = document.getElementById("password");
      input_pass.value = md5(input_pass.value);
    }
  </script>
    </body>
    <div id="sesion" class="loader loader-default"  data-text="Iniciando Sesión, Por Favor Espere..."></div>
</html>