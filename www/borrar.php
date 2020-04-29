<?php
session_start();
include "controlador/db.php";
if(isset($_SESSION["usuario"])){


    if(isset($_POST["noticia"])){
        borrarNoticia();
        header("Location:gestionnoticias.php");
    }
}
else {
    header("Location:index.php");
    
}

?>