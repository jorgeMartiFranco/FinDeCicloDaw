<?php


require_once __DIR__ . '/controlador/db.php';

if(isset($_POST["idUsuario"])){
    session_start();

    cambiarTipoUsuario($_POST["idUsuario"],$_POST["idTipoUsuario"]);

    $datos=[
            
        "resultado"=>"true"
    ];
   
    $json=json_encode($datos);
    echo $json;
}
?>