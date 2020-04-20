
<?php

require_once __DIR__ . '/controlador/db.php';

if($_POST['genero']=="masculino"){

    $fichajes=cargarFichajesJSON('M');
}
else {
    $fichajes=cargarFichajesJSON('F');
}


$arrayFichajes=[];


foreach($fichajes as $fichaje) {
$puestos="";


foreach($fichaje->getJugador()->getPuestos() as $puesto){
   
    
        if($fichaje->getJugador()->getPuestos()[0]==$puesto){
            $puestos=$puesto->getPuestoCorto();
        }
        else {
            $puestos=$puestos."/".$puesto->getPuestoCorto();
        }
        
      
    
}
    if($fichaje->getEquipoEmisor()->getTipoEquipo()->getTipo()=="A"){
        $tipoA="";
    }
    else {
        $tipoA=$fichaje->getEquipoEmisor()->getTipoEquipo()->getTipo();
    }
    if($fichaje->getEquipoReceptor()->getTipoEquipo()->getTipo()=="A"){
        $tipoB="";
    }
    else {
        $tipoB=$fichaje->getEquipoReceptor()->getTipoEquipo()->getTipo();
    }
    $arrayFichaje=[
        "id"=>$fichaje->getJugador()->getId(),
        "imagen"=>"<img src='img/jugadores/".$fichaje->getJugador()->getId()."mini.jpg'/>",
        "nombre"=> $fichaje->getJugador()->getNombre(),
        "apellido1"=>$fichaje->getJugador()->getApellido1(),
        "puestos"=>$puestos,
        "equipoEmisor"=>$fichaje->getEquipoEmisor()->getClub()->getNombreCorto()." ".$tipoA,
        "equipoReceptor"=>$fichaje->getEquipoReceptor()->getClub()->getNombreCorto()." ".$tipoB

    ];
    array_push($arrayFichajes,$arrayFichaje);
   
}

$json=json_encode($arrayFichajes);
echo $json;
?>