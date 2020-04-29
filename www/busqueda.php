<?php 

include "head.html";
include "controlador/db.php";
?>

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


<?php
if(isset($_POST["persona"])){

?>



<div class='row text-center'>
<div class='col-xl-2 col-lg-3 col-md-12 col-sm-12'>
</div>

<div class='col-xl-10 col-lg-9 col-md-12 col-sm-12 justify-content-center'>

<h2 class='text-secondary my-5'>Resultados de la búsqueda</h2>
</div>

</div>


<a href="#collapse" class="btn btn-secondary filtros" data-toggle="collapse">Filtros de búsqueda</a>
<div class='row' >
<div class='col-xl-2 col-lg-3 col-md-12 col-sm-12 bg-primary mx-xl-0 mx-lg-0 mx-md-3 mx-sm-3 border-top border-right border-secondary collapse d-lg-block' id="collapse">
    <?php
cargarFiltrosBusqueda("personas");
?>
</div>

    <div class='col-xl-10 col-lg-9 col-md-12 col-sm-12 justify-content-center p-0'>
    <?php
    busqueda();

 ?> 
 
</div>
</div>






<?php
}


else if(isset($_POST["equipos"])){
    ?>
    
    <div class='row text-center'>
<div class='col-xl-2 col-lg-3 col-md-12 col-sm-12'>
</div>

<div class='col-xl-10 col-lg-9 col-md-12 col-sm-12 justify-content-center'>

<h2 class='text-secondary my-5'>Resultados de la búsqueda</h2>
</div>

</div>


<a href="#collapse" class="btn btn-secondary filtros" data-toggle="collapse">Filtros de búsqueda</a>
<div class='row' >
<div class='col-xl-2 col-lg-3 col-md-12 col-sm-12 bg-primary mx-xl-0 mx-lg-0 mx-md-3 mx-sm-3 border-top border-right border-secondary collapse d-lg-block' id="collapse">
    <?php
cargarFiltrosBusqueda("equipos");
?>
</div>

    <div class='col-xl-10 col-lg-9 col-md-12 col-sm-12 justify-content-center p-0'>
    <?php
    busqueda();
 ?>
</div>
</div>
    
    <?php
}

else if(isset($_POST["equipoLibre"])){

?>

<div class='row mt-5'>

    <div class='col-xl-6 col-lg-6 col-md-12 col-sm-12 text-center'>
    <h2 class='text-secondary'>Masculino</h2>
        <?php
        cargarEquiposSinEntrenadorGrande("M");
        ?>
    </div>
    
    <div class='col-xl-6 col-lg-6 col-md-12 col-sm-12 text-center '>
    <h2 class='text-secondary'>Femenino</h2>
        <?php
        cargarEquiposSinEntrenadorGrande("F");
        ?>
    </div>
</div>

<?php
}

else if (isset($_POST["buscatecnico"])){
    ?>
    
    
    <div class='row text-center'>
<div class='col-xl-2 col-lg-3 col-md-12 col-sm-12'>
</div>

<div class='col-xl-10 col-lg-9 col-md-12 col-sm-12 justify-content-center'>

<h2 class='text-secondary my-5'>Resultados de la búsqueda</h2>
</div>

</div>


<a href="#collapse" class="btn btn-secondary filtros" data-toggle="collapse">Filtros de búsqueda</a>
<div class='row' >
<div class='col-xl-2 col-lg-3 col-md-12 col-sm-12 bg-primary mx-xl-0 mx-lg-0 mx-md-3 mx-sm-3 border-top border-right border-secondary collapse d-lg-block' id="collapse">
    <?php
cargarFiltrosBusqueda("tecnicos");
?>
</div>

    <div class='col-xl-10 col-lg-9 col-md-12 col-sm-12 justify-content-center p-0'>
    <?php
    busqueda();
 ?>
</div>
</div>
    
    <?php

}
else if(isset($_POST["buscajugador"])){
    ?>
    
    <div class='row text-center'>
<div class='col-xl-2 col-lg-3 col-md-12 col-sm-12'>
</div>

<div class='col-xl-10 col-lg-9 col-md-12 col-sm-12 justify-content-center'>

<h2 class='text-secondary my-5'>Resultados de la búsqueda</h2>
</div>

</div>


<a href="#collapse" class="btn btn-secondary filtros" data-toggle="collapse">Filtros de búsqueda</a>
<div class='row' >
<div class='col-xl-2 col-lg-3 col-md-12 col-sm-12 bg-primary mx-xl-0 mx-lg-0 mx-md-3 mx-sm-3 border-top border-right border-secondary collapse d-lg-block' id="collapse">
    <?php
cargarFiltrosBusqueda("jugadores");
?>
</div>

    <div class='col-xl-10 col-lg-9 col-md-12 col-sm-12 justify-content-center p-0'>
    <?php
    busqueda();
 ?>
</div>
</div>
    <?php
}
else {
    header("Location:index.php");
}
?>


</div>

<?php
   include "footer.html";
 ?>



