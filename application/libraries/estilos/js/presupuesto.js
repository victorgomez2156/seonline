function hola() {
    alert('hello');
}

function showOption(option){

    var y = document.getElementsByClassName('opcion-all');
    var i;
    for (i = 0; i < y.length; i++) {
        y[i].style.display = "none";
    }

    var x = document.getElementsByClassName(option);
    var i;
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "";
    }
}

function calcularValorPresupuesto(){
    var resultado = 0;
    document.getElementById("nombre_r").innerHTML = document.getElementsByName("t_clientesNombre")[0].value;
    document.getElementById("telefono_r").innerHTML = document.getElementsByName("t_clientesTelefono")[0].value;
    document.getElementById("empresa_r").innerHTML = document.getElementsByName("t_clientesEmpresa")[0].value;
    document.getElementById("apellid_r").innerHTML = document.getElementsByName("t_clientesApellido")[0].value;
    document.getElementById("email_r").innerHTML = document.getElementsByName("t_clientesEmail")[0].value;
    document.getElementById("nif_r").innerHTML = document.getElementsByName("t_clientesNif")[0].value;
    document.getElementById("tcliente_r").innerHTML = document.getElementById("p"+$("input[name=tipoDeCliente]:checked").val()+"_o").value;

    if ($("input[name=tipoDeCliente]:checked").val() == 1) {

        document.getElementById("a_op1_r").innerHTML = document.getElementById("p"+$("input[name=op1Antiguedad]:checked").val()+"_o").value;
        document.getElementById("b_op1_r").innerHTML = document.getElementById("p"+$("input[name=op1Actividad]:checked").val()+"_o").value;
        document.getElementById("c_op1_r").innerHTML = document.getElementById("p"+$("input[name=op1SeguridadSocial]:checked").val()+"_o").value;
        document.getElementById("d_op1_r").innerHTML = document.getElementById("p"+$("input[name=op1ProcedimientosTributarios]:checked").val()+"_o").value;
        document.getElementById("e_op1_r").innerHTML = document.getElementsByName("op1NTrabajadores12")[0].value;

        var op1_Antiguedad = $("input[name=op1Antiguedad]:checked").val();
        var op1_Antiguedad_precio = document.getElementById("p"+op1_Antiguedad).value;

        var op1_Actividad = $("input[name=op1Actividad]:checked").val();
        var op1_Actividad_precio = document.getElementById("p"+op1_Actividad).value;

        var op1_SeguridadSocial = $("input[name=op1SeguridadSocial]:checked").val();
        var op1_SeguridadSocial_precio = document.getElementById("p"+op1_SeguridadSocial).value;

        var op1_ProcedimientosTributarios = $("input[name=op1ProcedimientosTributarios]:checked").val();
        var op1_ProcedimientosTributarios_precio = document.getElementById("p"+op1_ProcedimientosTributarios).value;

        var op1_NTrabajadores12 = document.getElementsByName("op1NTrabajadores12")[0].value;
        var op1_NTrabajadores12_precio = document.getElementById("p12").value;

        if (op1_NTrabajadores12 == "") {
            op1_NTrabajadores12 = 0;
        }


         resultado = parseFloat(parseFloat(op1_Antiguedad_precio) + parseFloat(op1_Actividad_precio) + parseFloat(op1_SeguridadSocial_precio) + parseFloat(op1_ProcedimientosTributarios_precio) + parseFloat((parseFloat(op1_NTrabajadores12) * parseFloat(op1_NTrabajadores12_precio))));
      
    }

    if ($("input[name=tipoDeCliente]:checked").val() == 2) {

        document.getElementById("a_op2_r").innerHTML = document.getElementById("p"+$("input[name=op2Antiguedad]:checked").val()+"_o").value;
        document.getElementById("b_op2_r").innerHTML = document.getElementById("p"+$("input[name=op2Actividad]:checked").val()+"_o").value;
        document.getElementById("c_op2_r").innerHTML = document.getElementById("p"+$("input[name=op2SeguridadSocial]:checked").val()+"_o").value;
        document.getElementById("d_op2_r").innerHTML = document.getElementById("p"+$("input[name=op2ProcedimientosTributarios]:checked").val()+"_o").value;
        document.getElementById("e_op2_r").innerHTML = document.getElementsByName("op2NTrabajadores23")[0].value;
        document.getElementById("f_op2_r").innerHTML = document.getElementById("p"+$("input[name=op2FacturacionAnual]:checked").val()+"_o").value;
       
        var op2_FacturacionAnual = $("input[name=op2FacturacionAnual]:checked").val();
        var op2_FacturacionAnual_precio = document.getElementById("p"+op2_FacturacionAnual).value;

        var op2_Antiguedad = $("input[name=op2Antiguedad]:checked").val();
        var op2_Antiguedad_precio = document.getElementById("p"+op2_Antiguedad).value;

        var op2_Actividad = $("input[name=op2Actividad]:checked").val();
        var op2_Actividad_precio = document.getElementById("p"+op2_Actividad).value;

        var op2_SeguridadSocial = $("input[name=op2SeguridadSocial]:checked").val();
        var op2_SeguridadSocial_precio = document.getElementById("p"+op2_SeguridadSocial).value;

        var op2_ProcedimientosTributarios = $("input[name=op2ProcedimientosTributarios]:checked").val();
        var op2_ProcedimientosTributarios_precio = document.getElementById("p"+op2_ProcedimientosTributarios).value;

        var op2_NTrabajadores23 = document.getElementsByName("op2NTrabajadores23")[0].value;
        var op2_NTrabajadores23_precio = document.getElementById("p23").value;

        if (op2_NTrabajadores23 == "") {
            op2_NTrabajadores23 = 0;
        }

        resultado = parseFloat(parseFloat(op2_FacturacionAnual_precio) + parseFloat(op2_Antiguedad_precio) + parseFloat(op2_Actividad_precio) + parseFloat(op2_SeguridadSocial_precio) + parseFloat(op2_ProcedimientosTributarios_precio) + parseFloat((parseFloat(op2_NTrabajadores23) * parseFloat(op2_NTrabajadores23_precio))));
      
    }

    if ($("input[name=tipoDeCliente]:checked").val() == 3) {

        document.getElementById("a_op3_r").innerHTML = document.getElementById("p"+$("input[name=op3Antiguedad]:checked").val()+"_o").value;
        document.getElementById("b_op3_r").innerHTML = document.getElementById("p"+$("input[name=op3Actividad]:checked").val()+"_o").value;
        document.getElementById("c_op3_r").innerHTML = document.getElementById("p"+$("input[name=op3SeguridadSocial]:checked").val()+"_o").value;
        document.getElementById("d_op3_r").innerHTML = document.getElementById("p"+$("input[name=op3ProcedimientosTributarios]:checked").val()+"_o").value;
        document.getElementById("e_op3_r").innerHTML = document.getElementsByName("op3NTrabajadores38")[0].value;
        document.getElementById("f_op3_r").innerHTML = document.getElementById("p"+$("input[name=op3FacturacionAnual]:checked").val()+"_o").value;
       
        var op3_FacturacionAnual = $("input[name=op3FacturacionAnual]:checked").val();
        var op3_FacturacionAnual_precio = document.getElementById("p"+op3_FacturacionAnual).value;

        var op3_Antiguedad = $("input[name=op3Antiguedad]:checked").val();
        var op3_Antiguedad_precio = document.getElementById("p"+op3_Antiguedad).value;

        var op3_Actividad = $("input[name=op3Actividad]:checked").val();
        var op3_Actividad_precio = document.getElementById("p"+op3_Actividad).value;

        var op3_SeguridadSocial = $("input[name=op3SeguridadSocial]:checked").val();
        var op3_SeguridadSocial_precio = document.getElementById("p"+op3_SeguridadSocial).value;

        var op3_ProcedimientosTributarios = $("input[name=op3ProcedimientosTributarios]:checked").val();
        var op3_ProcedimientosTributarios_precio = document.getElementById("p"+op3_ProcedimientosTributarios).value;

        var op3_NTrabajadores38 = document.getElementsByName("op3NTrabajadores38")[0].value;
        var op3_NTrabajadores38_precio = document.getElementById("p38").value;

        if (op3_NTrabajadores38 == "") {
            op3_NTrabajadores38 = 0;
        }

        resultado = parseFloat(parseFloat(op3_FacturacionAnual_precio) + parseFloat(op3_Antiguedad_precio) + parseFloat(op3_Actividad_precio) + parseFloat(op3_SeguridadSocial_precio) + parseFloat(op3_ProcedimientosTributarios_precio) + parseFloat((parseFloat(op3_NTrabajadores38) * parseFloat(op3_NTrabajadores38_precio))));
      
    }

    if ($("input[name=tipoDeCliente]:checked").val() == 4) {
        document.getElementById("a_op4_r").innerHTML = document.getElementsByName("op4NLocales53")[0].value;
        var op4_NTrabajadores53 = document.getElementsByName("op4NLocales53")[0].value;
        var op4_NTrabajadores53_precio = document.getElementById("p53").value;
        if (op4_NTrabajadores53 == "") {
            op4_NTrabajadores53 = 0;
        }
        resultado = parseFloat(parseFloat(op4_NTrabajadores53) * parseFloat(op4_NTrabajadores53_precio));
    }

    if ($("input[name=tipoDeCliente]:checked").val() == 5) {
        document.getElementById("a_op5_r").innerHTML = document.getElementsByName("op5NEmpleados54")[0].value;
        var op5_NTrabajadores54 = document.getElementsByName("op5NEmpleados54")[0].value;
        var op5_NTrabajadores54_precio = document.getElementById("p54").value;
        if (op5_NTrabajadores54 == "") {
            op5_NTrabajadores54 = 0;
        }
        resultado = parseFloat(parseFloat(op5_NTrabajadores54) * parseFloat(op5_NTrabajadores54_precio));
    }


    document.getElementById("resultadoCalculo").value = resultado;
    document.getElementById("cuotaConcepto1").value = resultado+" euros + IVA / Mes (Estimado sobre un volumen de 2.000 apuntes anuales)";


}

function mySearch(id) {
    // Declare variables 
    var input, filter, table, tr, td, i;
    input = document.getElementById("shearch_"+id);
    filter = input.value.toUpperCase();
    table = document.getElementById("table_"+id);
    tr = table.getElementsByTagName("tr");
  
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0];

      
      if (td) {
          var text = tr[i].getElementsByTagName("td")[0].innerHTML.toUpperCase() +' '+tr[i].getElementsByTagName("td")[1].innerHTML.toUpperCase()+' '+tr[i].getElementsByTagName("td")[2].innerHTML.toUpperCase();
        if (text.indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      } 
    }
}

function mySearchImpuesto(id,mode) {
    // Declare variables 
    var input, filter, table, tr, td, i;
    input = document.getElementById("shearch_"+id);
    filter = input.value.toUpperCase();
    table = document.getElementById("table_"+id);
    tr = table.getElementsByTagName("tr");
  
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            
           //alert($( "#select_"+tr[i].getElementsByTagName("td")[4].id+" option:selected" ).text().toUpperCase());
           if (mode == 1) {
                //var text = tr[i].getElementsByTagName("td")[0].innerHTML.toUpperCase() +' '+tr[i].getElementsByTagName("td")[1].innerHTML.toUpperCase()+' '+tr[i].getElementsByTagName("td")[2].innerHTML.toUpperCase()+' '+' '+tr[i].getElementsByTagName("td")[3].innerHTML.toUpperCase()+' '+tr[i].getElementsByTagName("td")[4].innerHTML.toUpperCase()+' '+$( "#select_"+tr[i].getElementsByTagName("td")[5].id+" option:selected" ).text().toUpperCase();
                var text = tr[i].getElementsByTagName("td")[0].innerHTML.toUpperCase() +' '+tr[i].getElementsByTagName("td")[1].innerHTML.toUpperCase()+' '+tr[i].getElementsByTagName("td")[2].innerHTML.toUpperCase()+' '+tr[i].getElementsByTagName("td")[3].innerHTML.toUpperCase()+' '+tr[i].getElementsByTagName("td")[4].innerHTML.toUpperCase()+' '+tr[i].getElementsByTagName("td")[5].innerHTML.toUpperCase()+' '+$( "#select_"+tr[i].getElementsByTagName("td")[6].id+" option:selected" ).text().toUpperCase();
         
            } else {
                var text = tr[i].getElementsByTagName("td")[0].innerHTML.toUpperCase() +' '+tr[i].getElementsByTagName("td")[1].innerHTML.toUpperCase()+' '+tr[i].getElementsByTagName("td")[2].innerHTML.toUpperCase()+' '+tr[i].getElementsByTagName("td")[3].innerHTML.toUpperCase()+' '+tr[i].getElementsByTagName("td")[4].innerHTML.toUpperCase()+' '+tr[i].getElementsByTagName("td")[5].innerHTML.toUpperCase()+' '+$( "#select_"+tr[i].getElementsByTagName("td")[6].id+" option:selected" ).text().toUpperCase();
         
           }
           if (text.indexOf(filter) > -1) {
            tr[i].style.display = "";
            } else {
            tr[i].style.display = "none";
            }
        } 
    }
}

function sortTable(id_table,n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById(id_table);
    switching = true;
    //Set the sorting direction to ascending:
    dir = "asc"; 
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
      //start by saying: no switching is done:
      switching = false;
      rows = table.getElementsByTagName("TR");
      /*Loop through all table rows (except the
      first, which contains table headers):*/
      for (i = 1; i < (rows.length - 1); i++) {
        //start by saying there should be no switching:
        shouldSwitch = false;
        /*Get the two elements you want to compare,
        one from current row and one from the next:*/
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
        /*check if the two rows should switch place,
        based on the direction, asc or desc:*/
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch= true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch= true;
            break;
          }
        }
      }
      if (shouldSwitch) {
        /*If a switch has been marked, make the switch
        and mark that a switch has been done:*/
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        //Each time a switch is done, increase this count by 1:
        switchcount ++;      
      } else {
        /*If no switching has been done AND the direction is "asc",
        set the direction to "desc" and run the while loop again.*/
        if (switchcount == 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }
}



// $(document).ready(
//     function(){
//         $('.change_state_tax').change(
//             function(e){
//                 e.preventDefault();
//                 var form = $(this).parents('form');
//                 var url = form.attr('action');
                
//                 $.post(url,form.serialize(),function(result){
//                         $('#alert').html(result.message);
//                         if (result.status) {
//                             $( "#alert" ).removeClass( "alert-danger" );
//                             $( "#alert" ).addClass( "alert-success" );
//                         }else{
//                             $( "#alert" ).removeClass( "alert-success" );
//                             $( "#alert" ).addClass( "alert-danger" );
                            
//                         }
//                         $('#alert').show();
//                 });
//             }
//         );
//     }
// );
