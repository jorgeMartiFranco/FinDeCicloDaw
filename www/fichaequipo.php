<?php


if(isset($_GET["id"]) or !empty($_GET["id"])){
    
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



<?php cargarDatosEquipo($_GET["id"]);?>


</div>
</div>
<?php
        include "footer.html";
        ?>
<?php
}
else {
    header("Location:index.php");
}

?>