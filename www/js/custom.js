

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
            var tbody=$("<tbody class='border-right border-top border-secondary'>");
            
            for(let fichaje of fichajes){
                
               var tr=$("<tr>");
               
              
                var arrayPropiedades=[fichaje.imagen,"<a href='fichajugador.php?id="+fichaje.id+"' class='text-dark'>"+fichaje.nombre+" "+ fichaje.apellido1+"</a>",fichaje.puestos,fichaje.equipoEmisor,fichaje.equipoReceptor];
               
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
            var tbody=$("<tbody class='border-right border-top border-secondary'>");
            
            
            for(let libre of libres){
                
               var tr=$("<tr>");
               
              
                var arrayPropiedades=[libre.imagen,"<a href='fichajugador.php?id="+libre.id+"' class='text-dark'>"+libre.nombre+" "+ libre.apellido1+"</a>",libre.puestos,libre.pais];
               
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


    $('#imagen').change(function(evt) {

        var files = evt.target.files;
        var file = files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagen').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });


function ResizeImage() {
    if (window.File && window.FileReader && window.FileList && window.Blob) {
        var filesToUploads = document.getElementById('imageFile').files;
        var file = filesToUploads[0];
        if (file) {

            var reader = new FileReader();
            // Set the image once loaded into file reader
            reader.onload = function(e) {

                var img = document.createElement("img");
                img.src = e.target.result;

                var canvas = document.createElement("canvas");
                var ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0);

                var MAX_WIDTH = 300;
                var MAX_HEIGHT = 300;
                var width = img.width;
                var height = img.height;

                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height *= MAX_WIDTH / width;
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width *= MAX_HEIGHT / height;
                        height = MAX_HEIGHT;
                    }
                }
                canvas.width = width;
                canvas.height = height;
                var ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0, width, height);

                dataurl = canvas.toDataURL(file.type);
                document.getElementById('imagen').src = dataurl;
            }
            reader.readAsDataURL(file);

        }

    } else {
        alert('The File APIs are not fully supported in this browser.');
    }
}


    var prevScrollpos = window.pageYOffset;
    window.onscroll = function() {
    var nav = document.getElementById("navPagina");
    var currentScrollPos = window.pageYOffset;
    if(nav!=null){
        if (prevScrollpos > currentScrollPos) {
            nav.style.top = "0";
            nav.style.position="sticky";
        } else {
            
            nav.style.position="inherit";
            nav.style.top="";
        }
      prevScrollpos = currentScrollPos;
    }
    
}




});



