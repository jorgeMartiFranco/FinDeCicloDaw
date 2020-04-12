<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../modelo/historicoFichajeJugador.php';
require_once __DIR__ . '/../modelo/club.php';
require_once __DIR__ . '/../modelo/competicion.php';
require_once __DIR__ . '/../modelo/continente.php';
require_once __DIR__ . '/../modelo/cuerpoTecnico.php';
require_once __DIR__ . '/../modelo/equipo.php';
require_once __DIR__ . '/../modelo/estadisticaJugador.php';
require_once __DIR__ . '/../modelo/historicoEquipoCompeticion.php';
require_once __DIR__ . '/../modelo/historicoEquipoCuerpoTecnico.php';
require_once __DIR__ . '/../modelo/historicoEquipoJugador.php';
require_once __DIR__ . '/../modelo/historicoFichajeCuerpoTecnico.php';
require_once __DIR__ . '/../modelo/jugador.php';
require_once __DIR__ . '/../modelo/pais.php';
require_once __DIR__ . '/../modelo/puesto.php';
require_once __DIR__ . '/../modelo/puestoCuerpoTecnico.php';
require_once __DIR__ . '/../modelo/temporada.php';
require_once __DIR__ . '/../modelo/tipoCompeticion.php';
require_once __DIR__ . '/../modelo/tipoContrato.php';
require_once __DIR__ . '/../modelo/tipoEquipo.php';
require_once __DIR__ . '/../modelo/noticia.php';



use \Doctrine\ORM\Tools\Setup;
use \Doctrine\ORM\EntityManager;

function cargar($user): EntityManager {
    $global = parse_ini_file("config/db-global.ini");
    $account = parse_ini_file("config/db-$user.ini");
    $isDevMode = false;

    if ($global['debug'] && $global['debug'] === "true") {
        $isDevMode = true;
    }
    $paths = [__DIR__ . "/../modelo/"];
    $dbParams = [
        'driver' => 'pdo_mysql',
        'host' => $global['host'],
        'dbname' => $global['dbname'],
        'charset' => $global['charset'],
        'user' => $account['username'],
        'password' => $account['password'] ?? ""
    ];
    $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
    $config->setAutoGenerateProxyClasses(true);
    return EntityManager::create($dbParams, $config);
}




function cargarUltimosFichajes() {

    $entityM = cargar("admin");
    $queryFichajes=$entityM->createQueryBuilder();
    $queryFichajes->addSelect("fj")
                ->from("HistoricoFichajeJugador", 'fj')
                ->where("fj.equipoReceptor IN(SELECT e FROM Equipo e WHERE e.genero='M')")
                ->orderBy("fj.id","DESC")
                ->setMaxResults(10);
    $fichajes = $queryFichajes->getQuery()->getResult();

    echo "<table class='table' id='tablaFichajesJugadores'>
            <thead class='bg-primary'><tr>
            
            <th scope='col'>Jugador</th>
            <th scope='col'>Posición</th>
            <th scope='col'>Procedencia</th>
            <th scope='col'>Destino</th>
            </tr></thead><tbody class='border-right border-top border-secondary'>";
    foreach($fichajes as $fichaje){
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
        echo "<tr >
        
        <td>".$fichaje->getJugador()->getNombre()." ".$fichaje->getJugador()->getApellido1()."</td><td>";
       

        foreach($fichaje->getJugador()->getPuestos() as $puesto){

            if($fichaje->getJugador()->getPuestos()[0]==$puesto){
                echo $puesto->getPuestoCorto();
            }else {

                echo "/".$puesto->getPuestoCorto();
            }
           
        
        }

        echo " </td><td>".$fichaje->getEquipoEmisor()->getClub()->getNombreCorto()." ".$tipoA."</td>
        <td>".$fichaje->getEquipoReceptor()->getClub()->getNombreCorto()." ".$tipoB."</td>
        </tr>";
    }
    echo "</tbody></table>";
}


function cargarJugadoresLibres(){

    $entityM = cargar("admin");
    $queryLibres=$entityM->createQueryBuilder();
    $queryLibres->addSelect("j")
                ->from("Jugador", 'j')
                ->where("j.equipoActual IS NULL")
                ->andWhere("j.genero='M'")
                ->orderBy("j.ultimoCambioEquipo","DESC")
                ->setMaxResults(10);
    $libres = $queryLibres->getQuery()->getResult();

    echo "<table class='table' id='tablaLibres'>
            <thead class='bg-primary'><tr>
           
            <th scope='col'>Jugador</th>
            <th scope='col'>Posición</th>
            <th scope='col'>Nacionalidad</th>
            </tr></thead><tbody class='border-right border-top border-secondary'>";

    foreach($libres as $libre){

        echo "<tr><td>".$libre->getNombre()." ".$libre->getApellido1()."</td><td>";
            
            foreach($libre->getPuestos() as $puesto){
                echo $puesto->getPuestoCorto();
            }

           echo "</td><td>".$libre->getPais()->getNombre()."</td></tr>";
    }

    echo "</tbody></table>";
}


function cargarTecnicosLibres(){
    $entityM = cargar("admin");
    $queryLibres=$entityM->createQueryBuilder();
    $queryLibres->addSelect("e")
                ->from("CuerpoTecnico", 'e')
                ->where("e.equipoActual IS NULL")
                ->orderBy("e.ultimoCambioEquipo","DESC")
                ->setMaxResults(10);
    $libres = $queryLibres->getQuery()->getResult();

    echo "<table class='table'>
            <thead class='bg-primary'><tr>
           
            <th scope='col'>Técnico</th>
            <th scope='col'>Puesto</th>
            <th scope='col'>Nacionalidad</th>
            </tr></thead><tbody class='border-right border-top border-secondary'>";

    foreach($libres as $libre){

        echo "<tr><td>".$libre->getNombre()." ".$libre->getApellido1()."</td>
            <td>".$libre->getPuesto()->getPuesto()."</td>
            <td>".$libre->getPais()->getNombre()."</td></tr>";
    }

    echo "</tbody></table>";
}


function cargarUltimosFichajesTecnicos(){

    $entityM = cargar("admin");
    $queryFichajes=$entityM->createQueryBuilder();
    $queryFichajes->addSelect("ft")
                ->from("HistoricoFichajeCuerpoTecnico", 'ft')
                ->orderBy("ft.id","DESC")
                ->setMaxResults(10);
    $fichajes = $queryFichajes->getQuery()->getResult();

    echo "<table class='table'>
            <thead class='bg-primary'><tr>
            
            <th scope='col'>Técnico</th>
            <th scope='col'>Posición</th>
            <th scope='col'>Procedencia</th>
            <th scope='col'>Destino</th>
            </tr></thead><tbody class='border-right border-top border-secondary'>";
    foreach($fichajes as $fichaje){
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
        echo "<tr>
        
        <td>".$fichaje->getCuerpoTecnico()->getNombre()." ".$fichaje->getCuerpoTecnico()->getApellido1()."</td>
        <td>".$fichaje->getCuerpoTecnico()->getPuesto()->getPuesto()."</td>
        <td>".$fichaje->getEquipoEmisor()->getClub()->getNombreCorto()." ".$tipoA."</td>
        <td>".$fichaje->getEquipoReceptor()->getClub()->getNombreCorto()." ".$tipoB."</td>
        </tr>";
    }
    echo "</tbody></table>";
}



function cargarFichajesJSON($genero){
    $entityM = cargar("admin");
    $queryFichajes=$entityM->createQueryBuilder();
    $queryFichajes->addSelect("fj")
                ->from("HistoricoFichajeJugador", 'fj')
                ->where("fj.equipoReceptor IN(SELECT e FROM Equipo e WHERE e.genero='".$genero."')")
                ->orderBy("fj.id","DESC")
                ->setMaxResults(10);
    $fichajes = $queryFichajes->getQuery()->getResult();
   
    return $fichajes;
}


function cargarLibresJSON($genero){
    $entityM = cargar("admin");
    $queryLibres=$entityM->createQueryBuilder();
    $queryLibres->addSelect("j")
                ->from("Jugador", 'j')
                ->where("j.equipoActual IS NULL")
                ->andWhere("j.genero='".$genero."'")
                ->orderBy("j.ultimoCambioEquipo","DESC")
                ->setMaxResults(10);
    $libres = $queryLibres->getQuery()->getResult();
   
    return $libres;
}


function cargarUltimasNoticias(){
    $entityM = cargar("admin");
    $queryNoticias=$entityM->createQueryBuilder();
    $queryNoticias->addSelect("n")
                ->from("Noticia", 'n')
                ->orderBy("n.id","DESC")
                ->setMaxResults(10);
    $noticias = $queryNoticias->getQuery()->getResult();

    echo "<table class='table border-top border-right border-secondary'>
            <tbody>";
    foreach($noticias as $noticia){
        
        echo "<tr>
        
        <td class='bg-light'><a href='noticiacompleta.php?id=".$noticia->getId()."'><h5 class='text-dark text-justify'>".$noticia->getTitular()."</h5></a>
        <a class='text-dark 'href='noticias.php?competicion=".$noticia->getCompeticion()->getNombre()."'><small>".$noticia->getCompeticion()->getNombre()."</small></a>
        </td></tr>";
       

       
    }
    echo "</tbody></table>";
}


function cargarDropdownNoticias(){

    $entityM = cargar("admin");
    $paises=$entityM->getRepository("Pais")->findAll();

    foreach($paises as $pais){

        echo "<a class='dropdown-item py-2' href='noticias.php?pais=".$pais->getNombre()."'><h6>".$pais->getNombre()."</h6></a>";
    }
}

function cargarNoticia($noticia){
    echo "<div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 my-5'>
    <div class='row'><div class='col'><small>".mb_strtoupper($noticia->getCompeticion()->getNombre())."</small></div></div>
   <div class='row text-center my-2'><div class='col'><img src='img/noticias/".$noticia->getId().".jpg' class='img-fluid'/></div></div>
    <div class='row bg-light py-3'><div class='col'><a href='noticiacompleta.php?id=".$noticia->getId()."'><h3 class='text-dark text-justify'>".$noticia->getTitular()."</h3></a></div></div>
    <div class='row '><div class='col'><small>".date_format($noticia->getFecha(),"d-m-Y")."</small></div></div>
     <div class='row'><div class='col'><small>//JORGE MARTÍNEZ</small></div></div>
   
    </div>";
}

function cargarNoticiasPais($pais){

    $entityM=cargar("admin");

    $objPais=$entityM->getRepository("Pais")->findOneBy(["nombre"=>$pais]);

    if(!is_null($objPais)){
        $competiciones=$entityM->getRepository("Competicion")->findBy(["pais"=>$objPais]);
        $noticias=$entityM->getRepository("Noticia")->findBy(["competicion"=>$competiciones]);
        $noticias=array_reverse($noticias);
        $noticias = array_slice($noticias, 0, 18);
        if(!is_null($noticias)){

            foreach($noticias as $noticia){

                cargarNoticia($noticia);
                
                // hay que enlazar en la bd al autor de la noticia
            }
        }
    }

}


function cargarPaisSeleccionado($pais){
    $entityM=cargar("admin");
    
    $pais=$entityM->getRepository("Pais")->findOneBy(["nombre"=>$pais]);
   

    echo "<div class='col col-lg-3 mb-2 '><a class='nav-link text-dark bg-light border border-secondary mr-lg-3 p-2 text-center' href='noticias.php?pais=".$pais->getNombre()."'><h4>".$pais->getNombre()."</h4></a></div>";
       
    

    }

function cargarCompeticionesPaisSeleccionado($pais){
    $entityM=cargar("admin");
    
    $pais=$entityM->getRepository("Pais")->findOneBy(["nombre"=>$pais]);
    $competiciones=$entityM->getRepository("Competicion")->findBy(["pais"=>$pais]);
    
    
    
    
    foreach($competiciones as $competicion){
        echo "<div class='col col-lg-3'><a class='nav-link text-dark bg-light border border-secondary mr-lg-3 mt-1 p-2 text-center' href='noticias.php?competicion=".$competicion->getNombre()."'>".$competicion->getNombre()."</a></div>";
    }

   
}

function cargarNoticiasCompeticion($competicion){

    $entityM=cargar("admin");
    $competicion=$entityM->getRepository("Competicion")->findOneBy(["nombre"=>$competicion]);
    if(!is_null($competicion)){

        $noticias=$entityM->getRepository("Noticia")->findBy(["competicion"=>$competicion]);
        $noticias=array_reverse($noticias);

        $noticias = array_slice($noticias, 0, 18);
        if(!is_null($noticias)){

            foreach($noticias as $noticia){

                cargarNoticia($noticia);
            }
        }
    }
}


function cargarCompeticionSeleccionada($competicion){
    $entityM=cargar("admin");
   
    $competicion=$entityM->getRepository("Competicion")->findOneBy(["nombre"=>$competicion]);
    $pais=$entityM->getRepository("Pais")->findOneBy(["id"=>$competicion->getPais()->getId()]);

    echo "<div class='col col-lg-3 mb-2'><a class='nav-link text-dark bg-light border border-secondary mr-lg-3 mt-1 mb-2 text-center' href='noticias.php?pais=".$pais->getNombre()."'><h4>".$pais->getNombre()."</h4></a></div>
    <div class='col col-lg-3 mb-2'><a class='nav-link text-dark bg-light border border-secondary mt-1 mr-lg-3 mb-2 text-center' href='noticias.php?competicion=".$competicion->getNombre()."'><h5>".$competicion->getNombre()."</h5></a></div>
    ";
}


function cargarCompeticionNoticiaSeleccionada($idNoticia){

    $entityM=cargar("admin");
    $noticia=$entityM->find("Noticia",$idNoticia);
    $competicion=$entityM->getRepository("Competicion")->findOneBy(["nombre"=>$noticia->getCompeticion()->getNombre()]);
    $pais=$entityM->getRepository("Pais")->findOneBy(["id"=>$competicion->getPais()->getId()]);

    if(!is_null($competicion)){

        echo "
        <div class='col col-lg-3 mb-2'><a class='nav-link custom text-dark bg-light border border-secondary mr-lg-3 mt-1 text-center' href='noticias.php?pais=".$pais->getNombre()."'><h4>".$pais->getNombre()."</h4></a></div>
        <div class='col col-lg-3 mb-2'><a class='nav-link custom text-dark bg-light border border-secondary mr-lg-3 mt-1 text-center' href='noticias.php?competicion=".$competicion->getNombre()."'><h5>".$competicion->getNombre()."</h5></a></div>
       ";
    }

}


function cargarNoticiaCompleta($idNoticia){
    $entityM=cargar("admin");
    $noticia=$entityM->find("Noticia",$idNoticia);

    echo "<div class='row text-center mt-5 bg-light'><div class='col'><h1>".$noticia->getTitular()."</h1></div></div>
    <div class='row border-top border-right border-secondary rounded'><div class='col'>
    <div class='row mx-lg-5'><div class='col'><small>".date_format($noticia->getFecha(),"d-m-Y")."</small></div></div>
    <div class='row mx-lg-5'><div class='col'><small>JORGE MARTÍNEZ</small></div></div>
    <div class='row text-center my-2'><div class='col'><img src='img/noticias/".$idNoticia.".jpg' class='img-fluid'/></div></div>
    <div class='row text-center my-2'><div class='col'><small>".$noticia->getDescripcionImagen()."</small></div></div>
     <div class='row mx-1 justify-content-center my-5'><div class='col-lg-8'>".$noticia->getNoticia()."</div></div></div></div>";
}


function cargarCompeticionesPais($pais){
    $entityM=cargar("admin");
    
    $pais=$entityM->getRepository("Pais")->findOneBy(["nombre"=>$pais]);

    $competiciones=$entityM->getRepository("Competicion")->findBy(["pais"=>$pais]);
    
    foreach($competiciones as $competicion){

        echo "<option value='noticias.php?competicion=".$competicion->getNombre()."'>".$competicion->getNombre()."</option>";
    }

}


function cargarNoticiasGlobales(){
    $entityM=cargar("admin");

   
        $noticias=$entityM->getRepository("Noticia")->findAll();
        $noticias=array_reverse($noticias);
        $noticias = array_slice($noticias, 0, 18);
        if(!is_null($noticias)){

            foreach($noticias as $noticia){

                cargarNoticia($noticia);
                
                // hay que enlazar en la bd al autor de la noticia
            
        }
    }
}


function cargarPaisesNoticias(){
    $entityM=cargar("admin");
    
    
    $paises=$entityM->getRepository("Pais")->findAll();

   
    foreach($paises as $pais){
        echo "
        <div class='col col-lg-3 mb-2'><a class='nav-link custom text-dark bg-light border border-secondary mr-lg-3 mt-1 text-center' href='noticias.php?pais=".$pais->getNombre()."'><h4>".$pais->getNombre()."</h4></a></div>";
    }
        
    }


?>