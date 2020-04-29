<!DOCTYPE html>
<html>
<?php

include "head.html";
session_start();
include "controlador/db.php";
if(isset($_SESSION["usuario"])){
    if(isset($_POST["noticia"])){
        $noticia=cargarDatosNoticia();
       
    }
    else {
        $noticia=null;
    }
    

    if($_SESSION["usuario"]["tipoUsuario"]=="noticias" or $_SESSION["usuario"]["tipoUsuario"]=="administrador" or $_SESSION["usuario"]["tipoUsuario"]=="superusuario"){
        if(!isset($_POST["titular"])){
?>

<div class='container-fluid'>
<div class='row '>
<div class='col mt-3'>
<a class='btn btn-secondary btn-lg' href='gestionnoticias.php'>Volver a gestión de noticias</a>
<a class='btn btn-outline-secondary btn-lg' href='index.php'>Volver a inicio</a>
</div>
</div>
<div class='row mt-5 justify-content-center mt-3'>
    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 '>
        <h1 class='text-center'><?php
    if(isset($_POST["noticia"])){
        echo "Editar";
    }
    else {
        echo "Nueva";
    }
        ?> noticia</h1>
       <div class='row justify-content-center'>
<form action='publicarnoticia.php' method='POST' enctype="multipart/form-data">
<div class='row justify-content-center mt-3'>
        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
            <input class='form-control bg-light border' type='text' placeholder='Titular' name='titular' value='<?php
            if(isset($_POST["noticia"])){
                echo $noticia->getTitular();
            }
            ?>'required>
        </div>
   

       </div>

       <div class='row justify-content-center mt-3'>

        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
            <textarea class='form-control bg-light border' type='text' placeholder='Noticia' rows='20' name='noticia' required><?php
            if(isset($_POST["noticia"])){
                echo $noticia->getNoticia();
            }
            ?></textarea>
        </div>
   

       </div>

       <div class='row justify-content-center mt-3'>

        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
            <select class='form-control bg-light' id="selectCompeticiones" name="selectCompeticiones">
            <?php
            if(!is_null($noticia)){
                cargarCompeticiones($noticia->getCompeticion()->getId());
            }
            else{
                cargarCompeticiones();
            }
                
            ?>
            </select>
        </div>
   

       </div>

       <div class='row justify-content-center mt-3 text-center'>
           <div class='col'>
       <h6>Selecciona una imagen (Tamaño mínimo recomendado 300x300 píxeles)</h6>
    </div>
    </div>
    <?php
    if(isset($_POST["noticia"])){
    ?>
    <div class='row justify-content-center mt-3 text-center'>
           <div class='col'>
       <h6>La imagen anterior se eliminará</h6>
    </div>
    </div>

    <?php
    }
    ?>
   
    <div class='row justify-content-center mt-3'>
        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
           
            <input class='form-control' type='file' name='imagen' id='imagen' accept="image/jpeg" <?php
            
            if(!isset($_POST["noticia"])){
                echo "required";
            }
            ?>>
            
            
        </div>
   

       </div>
       
       <div class='row justify-content-center mt-3'>
        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
           
            <input class='form-control bg-light border' type='text' name='piefoto' placeholder='Texto de pie de foto' <?php
            
            if(isset($_POST["noticia"])){
                echo "value='".$noticia->getDescripcionImagen()."'";
            }
            ?>>
        </div>
   

       </div>
       <?php
       if(isset($_POST["noticia"])){
           echo "<input type='hidden' name='editada' value='".$_POST["noticia"]."'>";
       }
       ?>

       <div class='row text-right mt-3'>
        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
           
            <button type='submit' class='btn btn-secondary'>Publicar</button>
        </div>
   

       </div>

       

    </form>
    </div>

</div>
</div>
<?php
}
else {
    publicarNoticia();
    header("Location:gestionnoticias.php");
}
    }
    else {
        header("Location:index.php");
    }
}
    else {
        header("Location:index.php");
    }
        ?>