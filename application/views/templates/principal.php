<html lang="es">
<head>
       <?php $this->load->view('view_header');?>
</head>
<body>
<div ng-app="appPrincipal">
<?php $this->load->view('templates/side_menu');?>  
       <div class="text-center">
    <div class="form-signin">
            <img src="<?php echo ESTILOS;?>/img/logo_web.png"  style="margin-top: 7%;max-width: 320px;">
    </div>
</div>

  <?php $this->load->view('view_footer');?>
</body>
</html>