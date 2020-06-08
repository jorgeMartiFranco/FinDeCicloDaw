<?php
include "head.html";
session_start();
include "controlador/db.php";
if(isset($_SESSION["usuario"])){
    if($_SESSION["usuario"]["tipoUsuario"]=="registros" or $_SESSION["usuario"]["tipoUsuario"]=="administrador" or $_SESSION["usuario"]["tipoUsuario"]=="superusuario"){
        if(isset($_POST["nombreCompleto"]) and isset($_POST["nombreCorto"])){

            insertarClub();
            header("Location:datos.php");
        }
        else if(isset($_POST["selectTipoEquipo"])){
            insertarEquipo();
            header("Location:datos.php");
        }
        else {
        ?>


<div class='container-fluid'>
<div class='row '>
<div class='col mt-3'>
<a class='btn btn-secondary btn-lg' href='datos.php'>Volver a gestión de datos</a>
<a class='btn btn-outline-secondary btn-lg' href='index.php'>Volver a inicio</a>
</div>
</div>
<div class='row mt-5 justify-content-center mt-3'>
    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 '>
    <?php
    if(isset($_POST["club"])){
    ?>
        <h1 class='text-center'>Nuevo club</h1>
       <div class='row justify-content-center'>
<form action='añadir.php' method='POST' enctype="multipart/form-data">
<div class='row justify-content-center mt-3'>
        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
            <input class='form-control bg-light border' type='text' placeholder='Nombre completo' name='nombreCompleto' required>
        </div>
   

       </div>

       <div class='row justify-content-center mt-3'>

        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
        <input class='form-control bg-light border' type='text' placeholder='Nombre corto' name='nombreCorto' required>
        </div>
   

       </div>

       <div class='row justify-content-center mt-3'>

        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
            <select class='form-control bg-light' id="selectPaises" name="selectPaises">
            <?php
            cargarPaisesOption();
            ?>
            </select>
        </div>
   

       </div>


       <div class='row justify-content-center mt-3'>

<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
<input class='form-control bg-light border' type='text' placeholder='Año de fundación' name='fundacion' required>
</div>


</div>

       <div class='row justify-content-center mt-3 text-center'>
           <div class='col'>
       <h6>Selecciona un escudo (Tamaño mínimo recomendado 300x300 píxeles)</h6>
    </div>
    </div>
    
   
    <div class='row justify-content-center mt-3'>
        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
           
            <input class='form-control' type='file' name='imagen' id='imagen' accept="image/jpeg">
            
            
            
            
        </div>
   

       </div>
       

       <div class='row text-right mt-3'>
        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
           
            <button type='submit' class='btn btn-secondary'>Añadir</button>
        </div>
   

       </div>

       

    </form>
    </div>
<?php
    }
else if(isset($_POST["equipo"])){
    ?>
    
    <h1 class='text-center'>Nuevo equipo</h1>
       <div class='row justify-content-center'>
<form action='añadir.php' method='POST' enctype="multipart/form-data">
<div class='row justify-content-center mt-3'>
        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
        <select class='form-control bg-light' id="selectClubs" name="selectClubs">
            <?php
            cargarClubs();
            ?>
            </select>
        </div>
   

       </div>

       <div class='row justify-content-center mt-3'>

        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
        <select class='form-control bg-light' id="selectTipoEquipo" name="selectTipoEquipo">
            <?php
            cargarTiposEquipoOption();
            ?>
            </select>
        </div>
   

       </div>

       <div class='row justify-content-center mt-3'>

        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
        <select class='form-control bg-light' id="selectCompeticion" name="selectCompeticion">
            <?php
            cargarCompeticiones();
            ?>
            </select>
        </div>
   

       </div>

       <div class='row justify-content-center mt-3'>

        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
        <select class='form-control bg-light' id="selectGenero" name="selectGenero">
           <option value='M'>Masculino</option>
           <option value='F'>Femenino</option>
            </select>
        </div>
   

       </div>

       
       <div class='row justify-content-center mt-3'>

        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
        <label for='reputacion'>Reputación (Mínimo 0 Máximo 200)</label>
        <input type='number' value='0' min='0' max='200' name='reputacion' id='reputacion'>
        </div>
   

       </div>

    <div class='row text-right mt-3'>
        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
           
            <button type='submit' class='btn btn-secondary'>Añadir</button>
        </div>
   

       </div>

       

    </form>
    </div>
    
    <?php
}
?>
</div>
</div>
        <?php
        }
    }else {
        header("Location:index.php");
    }
}
else {
    header("Location:index.php");
}


?>