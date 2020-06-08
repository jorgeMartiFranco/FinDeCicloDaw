<?php

require_once __DIR__ . '/controlador/db.php';

if(isset($_POST["idJugador"])){
    session_start();
    if($_POST["accion"]=="eliminar"){
        eliminarFavorito($_POST["idJugador"],"jugador");
        $datos=[
            
            "resultado"=>"true"
        ];
       
        $json=json_encode($datos);
        echo $json;
    }
    else {

        añadirFavorito($_POST["idJugador"],"jugador");
        $datos=[
            
            "resultado"=>"true"
        ];
       
        $json=json_encode($datos);
        echo $json;
    }
}

else if(isset($_POST["idTecnico"])){

    session_start();
    if($_POST["accion"]=="eliminar"){
        eliminarFavorito($_POST["idTecnico"],"tecnico");
        $datos=[
            
            "resultado"=>"true"
        ];
       
        $json=json_encode($datos);
        echo $json;
    }
    else {

        añadirFavorito($_POST["idTecnico"],"tecnico");
        $datos=[
            
            "resultado"=>"true"
        ];
       
        $json=json_encode($datos);
        echo $json;
    }
}

else if(isset($_POST["idEquipo"])){
    session_start();
    if($_POST["accion"]=="eliminar"){
        eliminarFavorito($_POST["idEquipo"],"equipo");
        $datos=[
            
            "resultado"=>"true"
        ];
       
        $json=json_encode($datos);
        echo $json;
    }
    else {

        añadirFavorito($_POST["idEquipo"],"equipo");
        $datos=[
            
            "resultado"=>"true"
        ];
       
        $json=json_encode($datos);
        echo $json;
}
}
?>