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

<div class='row'>
<div class='col text-center py-5'>
<?php
if(!isset($_GET["id"])){
    ?>
    
    <h4>Se ha enviado un correo de confirmación a tu email. Podrás acceder a tu cuenta una vez confirmada.</h4>
<a class='btn btn-link text-secondary' href='index.php'><h4>Volver al inicio</h4></a>
    <?php
}
else {
    

    $confirmado=confirmarCuenta();
    if($confirmado){
        ?>
        
        <h4>Tu cuenta se ha activado. Ya puedes iniciar sesión</h4>
        <a class='btn btn-link text-secondary' href='index.php'><h4>Volver al inicio</h4></a>
        <?php
    }
    else {
        header("Location:index.php");
    }
    ?>
    
    
    <?php
}
?>

</div>
</div>


</div>