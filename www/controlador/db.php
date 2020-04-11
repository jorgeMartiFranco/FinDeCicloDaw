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
            <th scope='col'>Nuevo Equipo</th>
            </tr></thead><tbody>";
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
            </tr></thead><tbody>";

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
            </tr></thead><tbody>";

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
            <th scope='col'>Nuevo Equipo</th>
            </tr></thead><tbody>";
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
        
        <td>".$fichaje->getJugador()->getNombre()." ".$fichaje->getJugador()->getApellido1()."</td><td>";
       

        foreach($fichaje->getJugador()->getPuestos() as $puesto){
            echo $puesto->getPuestoCorto();
        }

        echo " </td><td>".$fichaje->getEquipoEmisor()->getClub()->getNombreCorto()." ".$tipoA."</td>
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

    echo "<table class='table'>
            <tbody>";
    foreach($noticias as $noticia){
        
        echo "<tr>
        
        <td class='bg-light'><a href='noticiacompleta.php?id=".$noticia->getId()."'><h5 class='text-dark text-justify'>".$noticia->getTitular()."</h5></a></td></tr>";
       

       
    }
    echo "</tbody></table>";
}


function cargarDropdownNoticias(){

    $entityM = cargar("admin");
    $paises=$entityM->getRepository("Pais")->findAll();

    foreach($paises as $pais){

        echo "<a class='dropdown-item text-white py-2' href='noticias.php?pais=".$pais->getNombre()."'><h6>".$pais->getNombre()."</h6></a>";
    }
}

function cargarNoticia($noticia){
    echo "<div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 my-5'>
    <div class='row mx-2'><div class='col'><small>".mb_strtoupper($noticia->getCompeticion()->getNombre())."</small></div></div>
   <div class='row text-center my-2'><div class='col'><img src='../img/noticia.jpg' class='w-75'/></div></div>
    <div class='row bg-light py-3 mx-2'><div class='col'><a href='noticiacompleta.php?id=".$noticia->getId()."'><h3 class='text-dark text-justify'>".$noticia->getTitular()."</h3></a></div></div>
     <div class='row mx-2'><div class='col'><small>//JORGE MARTÍNEZ</small></div></div>
   
    </div>";
}

function cargarNoticiasPais($pais){

    $entityM=cargar("admin");

    $objPais=$entityM->getRepository("Pais")->findOneBy(["nombre"=>$pais]);

    if(!is_null($objPais)){
        $competiciones=$entityM->getRepository("Competicion")->findBy(["pais"=>$objPais]);
        $noticias=$entityM->getRepository("Noticia")->findBy(["competicion"=>$competiciones]);

        if(!is_null($noticias)){

            foreach($noticias as $noticia){

                cargarNoticia($noticia);
                //Hay que enlazar imagen de la noticia en bd o en sistema de archivos
                //También hay que enlazar en la bd al autor de la noticia
            }
        }
    }

}


function cargarCompeticionesPais($pais){
    $entityM=cargar("admin");

    $objPais=$entityM->getRepository("Pais")->findOneBy(["nombre"=>$pais]);
    if(!is_null($objPais)){
        $competiciones=$entityM->getRepository("Competicion")->findBy(["pais"=>$objPais]);
       

       

            foreach($competiciones as $competicion){

                echo "<li class='nav-item mx-3 border border-secondary'>
                <a class='nav-link custom text-dark bg-light' href='noticias.php?competicion=".$competicion->getNombre()."'>".$competicion->getNombre()."</a>
              </li>";
               
            }
        
    }
}


function cargarNoticiasCompeticion($competicion){

    $entityM=cargar("admin");
    $objCompeticion=$entityM->getRepository("Competicion")->findOneBy(["nombre"=>$competicion]);
    if(!is_null($competicion)){

        $noticias=$entityM->getRepository("Noticia")->findBy(["competicion"=>$objCompeticion]);

        if(!is_null($noticias)){

            foreach($noticias as $noticia){

                cargarNoticia($noticia);
            }
        }
    }
}


function cargarPaisCompeticion($competicion){
    $entityM=cargar("admin");
    $objCompeticion=$entityM->getRepository("Competicion")->findOneBy(["nombre"=>$competicion]);

    $pais=$entityM->getRepository("Pais")->findOneBy(["nombre"=>$objCompeticion->getPais()->getNombre()]);

    echo "<li class='nav-item mx-3'>
    <a class='nav-link custom text-dark bg-light' href='noticias.php?pais=".$pais->getNombre()."'>Volver a noticias de ".$pais->getNombre()."</a>
  </li>";
}


function cargarCompeticionNoticia($idNoticia){

    $entityM=cargar("admin");
    $noticia=$entityM->find("Noticia",$idNoticia);
    $competicion=$entityM->getRepository("Competicion")->findOneBy(["nombre"=>$noticia->getCompeticion()->getNombre()]);

    if(!is_null($competicion)){

        echo "<li class='nav-item mx-3'>
        <a class='nav-link custom text-dark bg-light' href='noticias.php?competicion=".$competicion->getNombre()."'>Volver a noticias de ".$competicion->getNombre()."</a>
        </li>";
    }

}


function cargarNoticiaCompleta($idNoticia){
    $entityM=cargar("admin");
    $noticia=$entityM->find("Noticia",$idNoticia);

    echo "<div class='row text-center mt-5'><div class='col'><h1>".$noticia->getTitular()."</h1></div></div>
    <div class='row mx-lg-5'><div class='col bg-light'><small>JORGE MARTÍNEZ</small></div></div>
    <div class='row text-center my-2'><div class='col'><img src='../img/noticia.jpg' class='w-50'/></div></div>
            
            <div class='row mx-1 justify-content-center my-5'><div class='col-lg-8'>".$noticia->getNoticia()."</div></div>";
}

?>