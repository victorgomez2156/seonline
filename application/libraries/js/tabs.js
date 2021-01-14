function activarTab(unTab) {
    try {
        //Los elementos div de todas las pesta�as est�n todos juntos en una
        //�nica celda de la segunda fila de la tabla de estructura de pesta�as.
        //Hemos de buscar la seleccionada, ponerle display block y al resto
        //ponerle display none.
        var id = unTab.id;
        if (id){
            var tr = unTab.parentNode || unTab.parentElement;
            var tbody = tr.parentNode || tr.parentElement;
            var table = tbody.parentNode || tbody.parentElement;
            //Pesta�as en varias filas
            if (table.getAttribute("data-filas")!=null){
                var filas = tbody.getElementsByTagName("tr");
                var filaDiv = filas[filas.length-1];
                tbody.insertBefore(tr, filaDiv);
            }
            //Para compatibilizar con la versi�n anterior, si la tabla no tiene los
            //atributos data-min y data-max le ponemos los valores que ten�an antes del
            //cambio de versi�n.
            var desde = table.getAttribute("data-min");
            if (desde==null) desde = 0;
            var hasta = table.getAttribute("data-max");
            if (hasta==null) hasta = MAXTABS;
            var idTab = id.split("tabck-");
            var numTab = parseInt(idTab[1]);
            //Las "tabdiv" son los bloques interiores mientras que los "tabck"
            //son las pesta�as.
            var esteTabDiv = document.getElementById("tabdiv-" + numTab);
            for (var i=desde; i<=hasta; i++) {
                var tabdiv = document.getElementById("tabdiv-" + i);
                if (tabdiv) {
                    var tabck = document.getElementById("tabck-" + i);
                    if (tabdiv.id == esteTabDiv.id) {
                        tabdiv.style.display = "block";
                        tabck.style.color = "slategrey";
                        tabck.style.backgroundColor = "rgb(235, 235, 225)";
                        tabck.style.borderBottomColor = "rgb(235, 235, 225)";
                    } else {
                        tabdiv.style.display = "none";
                        tabck.style.color = "white";
                        tabck.style.backgroundColor = "gray";
                        tabck.style.borderBottomColor = "gray";
                    }
                }
            }
        }
    } catch (e) {
        alert("Error al activar una pesta�a. " + e.message);
    }
}