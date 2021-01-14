
  window.oncontextmenu = function () {
            return false;
        }
        $(document).keydown(function (event) {
            if (event.keyCode == 123) {
                return false;
            }
            else if ((event.ctrlKey && event.shiftKey && event.keyCode == 73) || (event.ctrlKey && event.shiftKey && event.keyCode == 74)) {
                return false;
            }
        });
   function right(e) {    
     var ano=new Date().getFullYear();
      var msg = "Esta Prohibido Usar el Click Derecho En Esta Pagina !!! ";
      if (navigator.appName == 'Netscape' && e.which == 3) {
        alert(msg); //- Si no quieres asustar a tu usuario entonces quita esta linea...
          /* bootbox.alert({
          title:'Seguridad',
            message: "<b><?php echo $this->nombre_full;?> </b>"+msg+" <br><b>Copyright &copy; " +ano+ " Todos los Derechos Reservados | Este Sistema Fue Desarrollado <i class='fa fa-heart-o' aria-text='true'></i> Por <a href='https://www.sistemasonline2018.com.ve' target='_blank'>Tsu. Victor Gómez</a> </b>" ,
            size: 'middle'
        }); */
         return false;
      }
      else if (navigator.appName == 'Microsoft Internet Explorer' && event.button==2) {
      alert(msg); //- Si no quieres asustar al usuario que utiliza IE,  entonces quita esta linea...
                        //- Aunque realmente se lo merezca...
      /*bootbox.alert({
          title:'Seguridad',
            message: "<?php echo $this->nombre_full;?> "+msg+" <br><b>Copyright &copy; Todos los Derechos Reservados | Este Sistema Fue Desarrollado <i class='fa fa-heart-o' aria-text='true'></i> Por <a href='https://www.sistemasonline2018.com.ve' target='_blank'>Tsu. Victor Gómez</a> </b>" ,
            size: 'middle'
        }); */
      return false;
      }
   return true;
}
document.onmousedown = right;
