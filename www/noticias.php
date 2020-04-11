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


            <div class="row position-sticky fixed-top">
                <div class='col p-0'>
        <?php
        include "nav.php";
        ?>
        </div>
       
        
                
                <?php include "navCompeticionesPais.php"; ?>
                <div class='row mt-5 mx-1'>
                    
                    <div class='col'>

            <?php
            if(isset($_GET["pais"]) and !isset($_GET["competicion"])){
            ?>
            <h3 class="text-secondary">Noticias de <?php echo $_GET["pais"]?></h3>
            <?php
            }
            else if(isset($_GET["competicion"]) and !isset($_GET["pais"])){
            ?>
            <h3 class="text-secondary">Noticias de <?php echo $_GET["competicion"]?></h3>
            <?php
            }
            ?>
            </div>
             </div>

             <div class='row mx-1 border-top border-right border-secondary rounded'>
            <?php
            
             if(isset($_GET["pais"]) and !isset($_GET["competicion"])){
             
                 cargarNoticiasPais($_GET["pais"]);
             }
             else if(isset($_GET["competicion"]) and !isset($_GET["pais"])){
                cargarNoticiasCompeticion($_GET["competicion"]);
             }
             ?>
            </div>
        

        <?php
        include "footer.html";
        ?>
            </div>


            

       
    

