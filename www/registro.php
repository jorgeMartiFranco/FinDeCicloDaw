<?php
include "controlador/db.php";
if(isset($_POST["email"]) and isset($_POST["contraseña1"]) and isset($_POST["contraseña2"])){

    $noRepetido=registrarUsuario();
    if($noRepetido){
        header("Location:confirmacion.php");
    }
    else {
        header("Location:index.php");
    }
    
}
else if(isset($_POST["emailreenvio"])){
    reenviarEmail();
    header("Location:index.php");
}

?>