<!DOCTYPE html>
<html>
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
    


<div class='row text-center mt-5'>
<div class='col'>
<h1 class='text-secondary'>Últimos fichajes</h1></div>
</div>
<div class='row mx-lg-5 mt-5'>

<div class=' col-xl-6 col-lg-6 col-md-12 col-sm-12'>

  <h3 class="text-secondary">Jugadores</h3>
        
            <?php
            cargarUltimosFichajes("M");
            ?>
       
       <div class="form-group">

<select class="form-control border col-lg-4 bg-primary" id="selectFichajes">
 <option value="masculino">Masculino</option>
 <option value="femenino">Femenino</option>
</select>

</div>


    <!-- Últimos fichajes jugadores-->
</div>

<div class=' col-xl-6 col-lg-6 col-md-12 col-sm-12'>
       
        <h3 class="text-secondary ">Técnicos</h3>
        
        <?php
        cargarUltimosFichajesTecnicos();
        ?>
        
        </div>
        

</div>
<div class='row text-center mt-5 '>
<div class='col'>
<h1 class='text-secondary'>Agentes libres</h1></div>
</div>
<div class='row mx-lg-5'>
<div class=' col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-5'>

        <h3 class="text-secondary">Jugadores</h3>
        <?php
        cargarJugadoresLibres();
        ?>
        <div class="form-group">

<select class="form-control border col-lg-4 bg-primary" id="selectLibres">
 <option value="masculino">Masculino</option>
 <option value="femenino">Femenino</option>
</select>

</div>
        </div>
    <!-- Jugadores libres-->




<div class=' col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-5'>

        <h3 class="text-secondary">Técnicos</h3>
        <?php
        cargarTecnicosLibres();
        ?>
        </div>
    <!-- Entrenadores libres-->
</div>





<div class='row mx-lg-5'>
<div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-5 '>
<h3 class='text-secondary'>Equipos sin entrenador</h3>
<?php
cargarEquiposSinEntrenador();
?>
</div>


<div class='col-xl-8 col-lg-8 col-md-12 col-sm-12 mt-5'>
    <h1 class='text-secondary'>Últimas noticias</h1>
    <?php
        cargarUltimasNoticias();
        ?>
</div>

</div>
</div>
</div>

</div>
<?php
include "footer.html";
?>
</div>
</body>
</html>

