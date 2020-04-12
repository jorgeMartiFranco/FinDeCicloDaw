<nav class="row py-0 text-dark mt-5 mb-3 mx-1 

<?php 
  if(isset($_GET["pais"]) and !isset($_GET["competicion"])){
    echo 'border-bottom border-secondary';
  }
  
?> ">
 
  
 
     
    
      
    <?php
    if(isset($_GET["pais"]) and !isset($_GET["competicion"]) ){
        cargarPaisSeleccionado($_GET["pais"]);

        ?>
        
        
        <?php
    }
    else if(isset($_GET["competicion"]) and !isset($_GET["pais"])){
        cargarCompeticionSeleccionada($_GET["competicion"]);
    }
    else if(isset($_GET["id"])){
        cargarCompeticionNoticiaSeleccionada($_GET["id"]);
    }
    else if(!isset($_GET["competicion"]) and !isset($_GET["pais"])){
      cargarPaisesNoticias();
  }
    
    ?>
 

  



</nav>

<nav class="row py-0 text-dark mx-1 ">
 
  

<?php
    if(isset($_GET["pais"]) and !isset($_GET["competicion"]) ){
        
cargarCompeticionesPaisSeleccionado($_GET["pais"]);
        ?>


  <?php
    }
  ?>

 
  </nav>