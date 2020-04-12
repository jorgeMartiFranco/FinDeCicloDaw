

$(document).ready(function() {
    $("#selectFichajes").change(function(){
        var genero=$("#selectFichajes").val();
        var tbodyFichajes=$("#tablaFichajesJugadores tbody");
        var tablaFichajes=$("#tablaFichajesJugadores");

        var generoFichajes={
            genero:genero
        };
        //peticion a servidor
        $.post('cambiarFichajes.php', generoFichajes,function(fichajesJSON) {
            
            var fichajes=JSON.parse(fichajesJSON);
            tbodyFichajes.remove();
            var tbody=$("<tbody>");
            
            for(let fichaje of fichajes){
                
               var tr=$("<tr>");
               
              
                var arrayPropiedades=[fichaje.nombre+" "+ fichaje.apellido1,fichaje.puestos,fichaje.equipoEmisor,fichaje.equipoReceptor];
               
                for(let i=0;i<arrayPropiedades.length;i++){
                    var td=$("<td>");
                    var texto=arrayPropiedades[i];
                    td.append(texto);
                    tr.append(td);

                }
                
              
               tbody.append(tr);
               
            }
            tablaFichajes.append(tbody);
        });

    });

    $("#selectLibres").change(function(){
        var genero=$("#selectLibres").val();
        var tbodyLibres=$("#tablaLibres tbody");
        var tablaLibres=$("#tablaLibres");

        var generoLibres={
            genero:genero
        };
        //peticion a servidor
        $.post('cambiarLibres.php', generoLibres,function(libresJSON) {
            
            var libres=JSON.parse(libresJSON);
            tbodyLibres.remove();
            var tbody=$("<tbody>");
            
            for(let libre of libres){
                
               var tr=$("<tr>");
               
              
                var arrayPropiedades=[libre.nombre+" "+ libre.apellido1,libre.puestos,libre.pais];
               
                for(let i=0;i<arrayPropiedades.length;i++){
                    var td=$("<td>");
                    var texto=arrayPropiedades[i];
                    td.append(texto);
                    tr.append(td);

                }
                
              
               tbody.append(tr);
               
            }
            tablaLibres.append(tbody);
        });

    });


    var prevScrollpos = window.pageYOffset;
    window.onscroll = function() {
    var nav = document.getElementById("navPagina");
    var currentScrollPos = window.pageYOffset;
    if (prevScrollpos > currentScrollPos) {
        nav.style.top = "0";
        nav.style.position="sticky";
    } else {
        
        nav.style.position="inherit";
        nav.style.top="";
    }
  prevScrollpos = currentScrollPos;
}

     


});



