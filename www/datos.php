<?php

include "head.html";
session_start();
include "controlador/db.php";
if(isset($_SESSION["usuario"])){
    if($_SESSION["usuario"]["tipoUsuario"]=="registros" or $_SESSION["usuario"]["tipoUsuario"]=="administrador" or $_SESSION["usuario"]["tipoUsuario"]=="superusuario"){
        
        ?>
<body>

<div class='container-fluid'>

    <div class='row bg-secondary'>
        <div class='col'>
            <h4 class='text-light text-center'>Te encuentras en la sección de gestión de datos de Handball World. <a href='index.php' class='text-info'>Volver a inicio.</a></h4>
        </div>
    </div>

    <div class='row mt-5 justify-content-around text-center'>
    
        <div class='col-xl-2 col-lg-4 col-md-12 col-sm-12'>
        <form class='form m-2' action='añadir.php' method='POST'>
            <button class='btn btn-secondary'>Añadir club</button>
            <input type='hidden' name='club'>
            </form>
            </div>
            <div class='col-xl-2 col-lg-4 col-md-12 col-sm-12'>
            <form class='form  m-2' action='añadir.php' method='POST'>
            <button class='btn btn-secondary'>Añadir equipo</button>
            <input type='hidden' name='equipo'>
            </form>
            </div>
            <div class='col-xl-2 col-lg-4 col-md-12 col-sm-12'>
            <form class='form  m-2' action='añadir.php' method='POST'>
            <button class='btn btn-secondary'>Añadir competición</button>
            <input type='hidden' name='competicion'>
            </form>
            </div>
            <div class='col-xl-2 col-lg-4 col-md-12 col-sm-12'>
            <form class='form  m-2' action='añadir.php' method='POST'>
            <button class='btn btn-secondary'>Añadir jugador</button>
            <input type='hidden' name='jugador'>
            </form>
            </div>
            <div class='col-xl-2 col-lg-4 col-md-12 col-sm-12'>
            <form class='form  m-2' action='añadir.php' method='POST'>
            <button class='btn btn-secondary'>Añadir técnico</button>
            <input type='hidden' name='tecnico'>
            </form>
            </div>
            </div>

</div>
</div>

</div>

</div>
</body>

        <?php




    }
    else {
        header("Location:index.php");
    }
}
else {
    header("Location:index.php");
}
?>