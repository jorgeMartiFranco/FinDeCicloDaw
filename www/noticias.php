<?php



include "head.html";
include "controlador/db.php";
?>
<body> 
<div class="container-fluid">
    <div class="row bg-light">
        <div class="col">
<?php
include "header.php";
?>
</div>


   </div> 
 <?php
        include "nav.php";
        ?>
       
      <?php include "navCompeticionesPais.php"; ?>
                
                <div class='row mt-5 mx-1'>
                    
                    <div class='col'>

            <?php
            if(isset($_GET["pais"]) and !isset($_GET["competicion"])){
                cargarPais($_GET["pais"]);
            ?>
            
            <?php
            }
            else if(isset($_GET["competicion"]) and !isset($_GET["pais"])){
                cargarCompeticion($_GET["competicion"]);
            ?>
           
            <?php
            }
            else if(!isset($_GET["competicion"]) and !isset($_GET["pais"])){
            ?>
            <h3 class="text-secondary">Noticias del mundo</h3>
            <?php
            }
            ?>
            
            
             </div>

            
            <?php
            
             if(isset($_GET["pais"]) and !isset($_GET["competicion"])){
             
                 cargarNoticiasPais($_GET["pais"]);
             }
             else if(isset($_GET["competicion"]) and !isset($_GET["pais"])){
                cargarNoticiasCompeticion($_GET["competicion"]);
             }
             else if(!isset($_GET["competicion"]) and !isset($_GET["pais"])){
                cargarNoticiasGlobales();
             }
             
             ?>
           
        

       
            </div>

           
            </div>
            <?php
        include "footer.html";
        ?>

       
    

