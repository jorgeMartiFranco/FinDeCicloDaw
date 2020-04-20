
<?php

require_once __DIR__ . '/controlador/db.php';

if($_POST['genero']=="masculino"){

    $libres=cargarLibresJSON('M');
}
else {
    $libres=cargarLibresJSON('F');
}




//Test
$arrayLibres=[];


foreach($libres as $libre) {
$puestos="";


foreach($libre->getPuestos() as $puesto){
   
    
        if($libre->getPuestos()[0]==$puesto){
            $puestos=$puesto->getPuestoCorto();
        }
        else {
            $puestos=$puestos."/".$puesto->getPuestoCorto();
        }
        
      
    
}
    
    $arrayLibre=[
        "id"=>$libre->getId(),
        "imagen"=>"<img src='img/jugadores/".$libre->getId()."mini.jpg'/>",
        "nombre"=> $libre->getNombre(),
        "apellido1"=>$libre->getApellido1(),
        "puestos"=>$puestos,
        "pais"=>$libre->getPais()->getNombre()
        
    ];
    array_push($arrayLibres,$arrayLibre);
   
}

$json=json_encode($arrayLibres);
echo $json;
?>