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
require_once __DIR__ . '/../modelo/usuario.php';
require_once __DIR__ . '/../modelo/tipoUsuario.php';



use \Doctrine\ORM\Tools\Setup;
use \Doctrine\ORM\EntityManager;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
    $fichajes = array_slice($fichajes, 0, 9);
    echo "<div class = 'table-responsive'>
    <table class='table text-center' id='tablaFichajesJugadores'>
            <thead class='bg-primary '><tr>
            <th scope='col'>#</th>
            <th scope='col'>Jugador</th>
            <th scope='col'>Posición</th>
            <th>Edad</th>
            <th scope='col'>Procedencia</th>
            <th scope='col'>Destino</th>
            </tr></thead><tbody class='border-right border-top border-secondary'>";
    foreach($fichajes as $fichaje){

        $edad = DateTime::createFromFormat('Y-m-d', date_format($fichaje->getJugador()->getFechaNacimiento(),"Y-m-d"))
                ->diff(new DateTime('now'))
                ->y;

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


        if(file_exists("img/jugadores/".$fichaje->getJugador()->getId()."mini.jpg")){
            $imagen="<img src='img/jugadores/".$fichaje->getJugador()->getId()."mini.jpg'/>";
        }
        else {
            $imagen="<img src='img/jugadores/defectomini.jpg'/>";
        }

        echo "<tr >
        <td>$imagen</td>
        <td><a href='fichajugador.php?id=".$fichaje->getJugador()->getId()."' class='text-dark'>".$fichaje->getJugador()->getNombre()." ".$fichaje->getJugador()->getApellido1()."</a></td><td class='text-dark'>";
       

        foreach($fichaje->getJugador()->getPuestos() as $puesto){

            if($fichaje->getJugador()->getPuestos()[0]==$puesto){
                echo $puesto->getPuestoCorto();
            }else {

                echo "/".$puesto->getPuestoCorto();
            }
           
        
        }

        echo " </td>
        <td>$edad</td>
        <td><a href='fichaequipo.php?id=".$fichaje->getEquipoEmisor()->getId()."' class='text-dark'>".$fichaje->getEquipoEmisor()->getClub()->getNombreCorto()." ".$tipoA."</a></td>
        <td><a href='fichaequipo.php?id=".$fichaje->getEquipoReceptor()->getId()."' class='text-dark'>".$fichaje->getEquipoReceptor()->getClub()->getNombreCorto()." ".$tipoB."</a></td>
        </tr>";
    }
    echo "</tbody></table></div>";
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
    $libres = array_slice($libres, 0, 9);
    echo "<div class = 'table-responsive'>
    <table class='table text-center' id='tablaLibres'>
            <thead class='bg-primary'><tr>
           <th scope='col'>#</th>
            <th scope='col'>Jugador</th>
            <th scope='col'>Posición</th>
            <th>Edad</th>
            <th scope='col'>Nacionalidad</th>
            </tr></thead><tbody class='border-right border-top border-secondary'>";

    foreach($libres as $libre){

        $edad = DateTime::createFromFormat('Y-m-d', date_format($libre->getFechaNacimiento(),"Y-m-d"))
        ->diff(new DateTime('now'))
        ->y;

        if(file_exists("img/jugadores/".$libre->getId()."mini.jpg")){
            $imagen="<img src='img/jugadores/".$libre->getId()."mini.jpg' />";
        }
        else {
            $imagen="<img src='img/jugadores/defectomini.jpg'/>";
        }

        echo "<tr><td>$imagen</td>
        <td><a href='fichajugador.php?id=".$libre->getId()."' class='text-dark'>".$libre->getNombre()." ".$libre->getApellido1()."</a></td><td>";
            
        foreach($libre->getPuestos() as $puesto){

            if($libre->getPuestos()[0]==$puesto){
                echo $puesto->getPuestoCorto();
            }else {

                echo "/".$puesto->getPuestoCorto();
            }
        }

           echo "</td>
           <td>$edad</td>
           <td>".$libre->getPais()->getNacionalidad()."</td></tr>";
    }

    echo "</tbody></table></div>";
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
    $libres = array_slice($libres, 0, 9);
    echo "<div class = 'table-responsive'>
    <table class='table text-center'>
            <thead class='bg-primary'><tr>
           <th scope='col'>#</th>
            <th scope='col'>Técnico</th>
            <th scope='col'>Puesto</th>
            <th>Edad</th>
            <th scope='col'>Nacionalidad</th>
            </tr></thead><tbody class='border-right border-top border-secondary'>";

    foreach($libres as $libre){


        $edad = DateTime::createFromFormat('Y-m-d', date_format($libre->getFechaNacimiento(),"Y-m-d"))
                ->diff(new DateTime('now'))
                ->y;

        if(file_exists("img/tecnicos/".$libre->getId()."mini.jpg")){
            $imagen="<img src='img/tecnicos/".$libre->getId()."mini.jpg'/>";
        }
        else {
            $imagen="<img src='img/tecnicos/defectomini.jpg'/>";
        }
        echo "<tr>
        <td>$imagen</td>
        <td><a href='fichatecnico.php?id=".$libre->getId()."' class='text-dark'>".$libre->getNombre()." ".$libre->getApellido1()."</a></td>
            <td class='text-dark'>".$libre->getPuesto()->getPuesto()."</td>
            <td>$edad</td>
            <td class='text-dark'>".$libre->getPais()->getNacionalidad()."</td></tr>";
    }

    echo "</tbody></table></div>";
}


function cargarUltimosFichajesTecnicos(){

    $entityM = cargar("admin");
    $queryFichajes=$entityM->createQueryBuilder();
    $queryFichajes->addSelect("ft")
                ->from("HistoricoFichajeCuerpoTecnico", 'ft')
                ->orderBy("ft.id","DESC")
                ->setMaxResults(10);
    $fichajes = $queryFichajes->getQuery()->getResult();
    $fichajes = array_slice($fichajes, 0, 9);
    echo "<div class = 'table-responsive'>
    <table class='table text-center'>
            <thead class='bg-primary'><tr>
            <th scope='col'>#</th>
            <th scope='col'>Técnico</th>
            <th scope='col'>Puesto</th>
            <th>Edad</th>
            <th scope='col'>Procedencia</th>
            <th scope='col'>Destino</th>
            </tr></thead><tbody class='border-right border-top border-secondary'>";
    foreach($fichajes as $fichaje){


        $edad = DateTime::createFromFormat('Y-m-d', date_format($fichaje->getCuerpoTecnico()->getFechaNacimiento(),"Y-m-d"))
                ->diff(new DateTime('now'))
                ->y;

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

        if(file_exists("img/tecnicos/".$fichaje->getCuerpoTecnico()->getId()."mini.jpg")){
            $imagen="<img src='img/tecnicos/".$fichaje->getCuerpoTecnico()->getId()."mini.jpg'/>";
        }
        else {
            $imagen="<img src='img/tecnicos/defectomini.jpg'/>";
        }

        echo "<tr>
        <td>$imagen</td>
        <td><a href='fichatecnico.php?id=".$fichaje->getCuerpoTecnico()->getId()."' class='text-dark'>".$fichaje->getCuerpoTecnico()->getNombre()." ".$fichaje->getCuerpoTecnico()->getApellido1()."</a></td>
        <td class='text-dark'>".$fichaje->getCuerpoTecnico()->getPuesto()->getPuesto()."</td>
        <td>$edad</td>
        <td><a href='fichaequipo.php?id=".$fichaje->getEquipoEmisor()->getId()."' class='text-dark'>".$fichaje->getEquipoEmisor()->getClub()->getNombreCorto()." ".$tipoA."</a></td>
        <td><a href='fichaequipo.php?id=".$fichaje->getEquipoReceptor()->getId()."' class='text-dark'>".$fichaje->getEquipoReceptor()->getClub()->getNombreCorto()." ".$tipoB."</td>
        </tr>";
    }
    echo "</tbody></table></div>";
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
    echo "<a class='dropdown-item py-2' href='noticias.php'><h6>Mundo</h6></a>";
    foreach($paises as $pais){

        echo "<a class='dropdown-item dropright py-2' href='noticias.php?pais=".$pais->getNombre()."'><h6>".$pais->getNombre()."</h6></a>";
     }
}

function cargarNoticia($noticia){
    echo "
    <div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 my-5'>
    <div class='row'><div class='col'><small>".mb_strtoupper($noticia->getCompeticion()->getNombre())."</small></div></div>
   <div class='row text-center my-2'><div class='col'><img src='img/noticias/".$noticia->getId().".jpg' class='img-fluid'/></div></div>
    <div class='row bg-light py-3'><div class='col'><a href='noticiacompleta.php?id=".$noticia->getId()."'><h3 class='text-dark text-justify'>".$noticia->getTitular()."</h3></a></div></div>
    <div class='row '><div class='col'><small>".date_format($noticia->getFecha(),"d-m-Y")."</small></div></div>
     <div class='row'><div class='col'><small>".mb_strtoupper($noticia->getAutor()->getNombre()." ".$noticia->getAutor()->getApellido1())."</small></div></div>
   
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
            echo " <div class='row mx-1 border-top border-right border-secondary rounded'>";
            foreach($noticias as $noticia){

                cargarNoticia($noticia);
                
                // hay que enlazar en la bd al autor de la noticia
            }
            echo "</div>";
        }
    }
    else {
        
        header("Location:noticias.php");
    }

}


function cargarPaisSeleccionado($pais){
    $entityM=cargar("admin");
    
    $pais=$entityM->getRepository("Pais")->findOneBy(["nombre"=>$pais]);
   if(!is_null($pais)){
    echo "<div class='col col-lg-3 mb-2 '><a class='nav-link text-dark bg-light border border-secondary mr-lg-3 p-2 text-center' href='noticias.php?pais=".$pais->getNombre()."'><h4>".$pais->getNombre()."</h4></a></div>";
   }
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
            echo " <div class='row mx-1 border-top border-right border-secondary rounded'>";
            foreach($noticias as $noticia){

                cargarNoticia($noticia);
            }
            echo "</div>";
        }
    }
    else {
        header("Location:noticias.php");
    }
}


function cargarCompeticionSeleccionada($competicion){
    $entityM=cargar("admin");
   
    $competicion=$entityM->getRepository("Competicion")->findOneBy(["nombre"=>$competicion]);
    if(!is_null($competicion)){
    $pais=$entityM->getRepository("Pais")->findOneBy(["id"=>$competicion->getPais()->getId()]);

    echo "<div class='col col-lg-3 mb-2'><a class='nav-link text-dark bg-light border border-secondary mr-lg-3 mt-1 mb-2 text-center' href='noticias.php?pais=".$pais->getNombre()."'><h4>".$pais->getNombre()."</h4></a></div>
    <div class='col col-lg-3 mb-2'><a class='nav-link text-dark bg-light border border-secondary mt-1 mr-lg-3 mb-2 text-center' href='noticias.php?competicion=".$competicion->getNombre()."'><h5>".$competicion->getNombre()."</h5></a></div>
    ";
    }
}


function cargarCompeticionNoticiaSeleccionada($idNoticia){

    $entityM=cargar("admin");
    $noticia=$entityM->find("Noticia",$idNoticia);
    if(!is_null($noticia)){
    $competicion=$entityM->getRepository("Competicion")->findOneBy(["nombre"=>$noticia->getCompeticion()->getNombre()]);
    $pais=$entityM->getRepository("Pais")->findOneBy(["id"=>$competicion->getPais()->getId()]);

    if(!is_null($competicion)){

        echo "
        <div class='col col-lg-3 mb-2'><a class='nav-link custom text-dark bg-light border border-secondary mr-lg-3 mt-1 text-center' href='noticias.php?pais=".$pais->getNombre()."'><h4>".$pais->getNombre()."</h4></a></div>
        <div class='col col-lg-3 mb-2'><a class='nav-link custom text-dark bg-light border border-secondary mr-lg-3 mt-1 text-center' href='noticias.php?competicion=".$competicion->getNombre()."'><h5>".$competicion->getNombre()."</h5></a></div>
       ";
    }
}
}


function cargarNoticiaCompleta($idNoticia){
    $entityM=cargar("admin");
    $noticia=$entityM->find("Noticia",$idNoticia);
    if(!is_null($noticia)){
    echo "<div class='row text-center mt-5 bg-light'><div class='col'><h1>".$noticia->getTitular()."</h1></div></div>
    <div class='row border-top border-right border-secondary rounded'><div class='col'>
    <div class='row mx-lg-5'><div class='col'><small>".date_format($noticia->getFecha(),"d-m-Y")."</small></div></div>
    <div class='row mx-lg-5'><div class='col'><small>".mb_strtoupper($noticia->getAutor()->getNombre()." ".$noticia->getAutor()->getApellido1())."</small></div></div>
    <div class='row text-center my-2'><div class='col'><img src='img/noticias/".$idNoticia.".jpg' class='img-fluid'/></div></div>
    <div class='row text-center my-2'><div class='col'><small>".$noticia->getDescripcionImagen()."</small></div></div>
     <div class='row mx-1 justify-content-center my-5'><div class='col-lg-8'>".$noticia->getNoticia()."</div></div></div></div>";
    }
    else {
        cargarPantallaError("noticia");
    }
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
            echo " <div class='row mx-1 border-top border-right border-secondary rounded'>";
            foreach($noticias as $noticia){

                cargarNoticia($noticia);
                
                // hay que enlazar en la bd al autor de la noticia
            
        }
        echo "</div>";
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


function cargarDatosJugador($idJugador){
    $entityM=cargar("admin");

    $jugador=$entityM->find("Jugador",$idJugador);
    if(!is_null($jugador)){

    
    $edad = DateTime::createFromFormat('Y-m-d', date_format($jugador->getFechaNacimiento(),"Y-m-d"))
     ->diff(new DateTime('now'))
     ->y;

    if(!is_null($jugador->getApodo())){

        $apodo='"'.$jugador->getApodo().'"';
    }
    else {
        $apodo=null;
    }

    if(!is_null($jugador->getEquipoActual())){

        if($jugador->getEquipoActual()->getTipoEquipo()->getTipo()=="A"){
            $equipoActual=$jugador->getEquipoActual()->getClub()->getNombreCompleto();
        }
        else {
            $equipoActual=$jugador->getEquipoActual()->getClub()->getNombreCompleto()." ".$jugador->getEquipoActual()->getTipoEquipo()->getTipo();
        }
        
    }
    else {
        $equipoActual="Sin equipo";
    }

    if(file_exists("img/jugadores/".$idJugador.".jpg")){
        $imagen="<img src='img/jugadores/".$idJugador.".jpg' class='img-fluid'/>";
    }
    else {
        $imagen="<img src='img/jugadores/defecto.jpg' class='img-fluid'/>";
    }


    $puestos="";

    foreach($jugador->getPuestos() as $puesto){

        if($jugador->getPuestos()[0]==$puesto){
            $puestos=$puesto->getPuesto();
        }else {

           $puestos=$puestos."/".$puesto->getPuesto();
        }
    }

    $twitter="";
    $facebook="";
    $instagram="";
    if(!is_null($jugador->getTwitter())){
        $twitter="<a href='".$jugador->getTwitter()."' target='_blank'><img src='img/redessociales/twitter.jpg' class='img-fluid mx-1'/></a>";
    }
    if(!is_null($jugador->getFacebook())){
        $facebook="<a  href='".$jugador->getFacebook()."' target='_blank'><img src='img/redessociales/facebook.jpg' class='img-fluid mx-1'/></a>";
    }

    if(!is_null($jugador->getInstagram())){
        $instagram=" <a  href='".$jugador->getInstagram()."' target='_blank'><img src='img/redessociales/instagram.jpg' class='img-fluid mx-1'/></a>";
    }

    if(isset($_SESSION["usuario"])){
        $usuario=$entityM->find("Usuario",$_SESSION["usuario"]["id"]);
        $favoritoEncontrado=false;
        foreach($jugador->getUsuarios() as $usuarioActual){
            if($usuarioActual==$usuario){
                $favoritoEncontrado=true;
            }

        }
        $idJugador=$jugador->getId();
        
        if($favoritoEncontrado){
            $boton="<button class='btn btn-link'  id='btnFavorito' onclick=jugadorFavorito($idJugador,'eliminar')><i class='fa fa-star text-danger' aria-hidden='true'></i></button>";
        }
        else {
            $boton="<button class='btn btn-link' id='btnFavorito' onclick=jugadorFavorito($idJugador,'añadir')><i class='fa fa-star-o text-danger' aria-hidden='true'></i></button>";
        }

    }
    else {
        $boton="";
    }
    
    


    echo "
    <div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 text-center mt-5'>
                <h1 class='text-secondary mb-1'>Ficha de jugador</h1>
            </div>
    <div class='row px-2 borderEspecial '><div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-5 text-center ' >$imagen</div>
                             <div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 '><div class='row '><div class='col ' ><h3 class='text-secondary'>".$jugador->getNombre()." ".$jugador->getApellido1()." ".$jugador->getApellido2()." ".$apodo."$boton</h3></div>
                             </div>
                             <div class='row'><div class='col'><h5>".$puestos."</h5></div></div>
                             <div class='row'><div class='col'><h6>Fecha de nacimiento: ".date_format($jugador->getFechaNacimiento(),"d-m-Y")."</h6></div></div>
                             <div class='row'><div class='col'><h6>Edad: ".$edad."</h6></div></div>
                             <div class='row'><div class='col'><h6>Nacionalidad: ".$jugador->getPais()->getNacionalidad()."</h6></div></div>
                             <div class='row'><div class='col'><h6>Nivel: ".$jugador->getTipoContrato()->getTipoContrato()."</h6></div></div>
                             <div class='row'><div class='col'>
                             <div class='btn-group my-1 my-md-0' role='group'>
                    ".$twitter.$facebook.$instagram."
                    
                   
        
                    </div>
                </div></div>
                             
                             </div>
";

    if($equipoActual=="Sin equipo"){
        echo "<div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 justify-content-center'><div class='row'><div class='col'><h2 class='text-danger'>Sin Equipo</h2>
        </div></div></div></div>";
    }
    else {

      echo "<div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 justify-content-center'><div class='row'><div class='col text-center'><h3 class='text-secondary'>Equipo Actual</h3>
                            <div class='row '><div class='col'><img src='img/clubs/".$jugador->getEquipoActual()->getClub()->getId()."fichas.jpg' class='img-fluid'/></div></div>
                             <div class='row'><div class='col'><a class='text-secondary' href='fichaequipo.php?id=".$jugador->getEquipoActual()->getId()."'><h5>".$equipoActual."</h5></a></div></div>
                             <div class='row'><div class='col'><a class='text-secondary' href='fichacompeticion.php?id=".$jugador->getEquipoActual()->getCompeticion()->getId()."'><h6>".$jugador->getEquipoActual()->getCompeticion()->getNombre()."</h6></a></div></div>
                             </div>
                             </div>
                             </div></div>
                             ";

    }

    $comprobarEstadisticas=$entityM->getRepository("EstadisticaJugador")->findBy(["jugador"=>$idJugador]);
    if(count($comprobarEstadisticas)>0){
    $estadisticas=cargarEstadisticasJugador($jugador);
    echo $estadisticas;
    }
}
else {
   cargarPantallaError("jugador");
}

}



function cargarEstadisticasJugador($jugador){

    echo "<div class='row px-2 justify-content-center'>
    <div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 text-center mt-5'>
    <h1 class='text-secondary'>Estadísticas de ".$jugador->getNombre()."</h1>
    </div>
    </div>";


    $estadisticas=cargarEstadisticasJugadorGlobal($jugador);
    $estadisticas=$estadisticas.cargarEstadisticasJugadorTemporadas($jugador);
    $estadisticas=$estadisticas.cargarEstadisticasJugadorEquipos($jugador);

    return $estadisticas;
}



function cargarEstadisticasJugadorGlobal($jugador){
    
    $entityM=cargar("admin");

    $queryEstadisticas=$entityM->createQueryBuilder();
    $queryEstadisticas->addSelect("SUM(ej.goles),SUM(ej.perdidas),SUM(ej.recuperaciones)")
                ->from("EstadisticaJugador", 'ej')
                ->where("ej.jugador=(SELECT j.id FROM Jugador j WHERE j.id=".$jugador->getId().")");
                
    $estadisticas = $queryEstadisticas->getQuery()->getSingleResult();
    

    echo "
    <div class='row px-2 justify-content-around'>
    <div class='col-xl-4 col-lg-4 col-md-12 col-sm-12'>
    <div class='row px-2 text-secondary mt-5'>
    <div class='col'><h3>Estadísticas de carrera</h3></div></div>
    <table class='table'>
            <thead class='bg-primary' ><tr>
            <th scope='col' class='text-center'>Goles</th>
            <th scope='col' class='text-center'>Pérdidas</th>
            <th scope='col' class='text-center'>Recuperaciones</th>
            </tr></thead><tbody class='border-right border-top border-secondary'>

            <tr>
            <td class='text-center'><h6>".$estadisticas[1]."</h6></td>
            <td class='text-center'><h6>".$estadisticas[2]."</h6></td>
            <td class='text-center'><h6>".$estadisticas[3]."</h6></td>
            </tr>
            </tbody>
            </table>
            </div>
    ";
}


function cargarEstadisticasJugadorTemporadas($jugador){

    $entityM=cargar("admin");

    $queryEstadisticas=$entityM->createQueryBuilder();
    $queryEstadisticas->addSelect("SUM(ej.goles),SUM(ej.perdidas),SUM(ej.recuperaciones),(ej.temporada)")
                ->from("EstadisticaJugador", 'ej')
                ->where("ej.jugador=(SELECT j.id FROM Jugador j WHERE j.id=".$jugador->getId().")")
                ->groupBy("ej.temporada");
                
    $estadisticas = $queryEstadisticas->getQuery()->getResult();
    
    $estadisticasStr="
    <div class='col-xl-4 col-lg-6 col-md-12 col-sm-12'>
    <div class='row px-2 text-secondary mt-5'>
    <div class='col'><h3>Estadísticas de temporadas</h3></div></div>
    <table class='table'>
            <thead class='bg-primary' ><tr>
            <th scope='col' class='text-center'>Temporada</th>
            <th scope='col' class='text-center'>Goles</th>
            <th scope='col' class='text-center'>Pérdidas</th>
            <th scope='col' class='text-center'>Rec.</th>
            </tr></thead><tbody class='border-right border-top border-secondary'>";
   
   
    foreach($estadisticas as $estadistica){
        $temporada=$entityM->find("Temporada",$estadistica[4]);


        $estadisticasStr=$estadisticasStr."
    
                <tr>
                <td class='text-center'><h6>".$temporada->getTemporada()."</h6></td>
                <td class='text-center'>".$estadistica[1]."</td>
                <td class='text-center'>".$estadistica[2]."</td>
                <td class='text-center'>".$estadistica[3]."</td>
                </tr>
                ";
        
    }

    $estadisticasStr=$estadisticasStr."</tbody>
    </table>
    </div>
   ";

      return $estadisticasStr;
   

}

function cargarEstadisticasJugadorEquipos($jugador){
    $entityM=cargar("admin");

    $queryEstadisticas=$entityM->createQueryBuilder();
    $queryEstadisticas->addSelect("SUM(ej.goles),SUM(ej.perdidas),SUM(ej.recuperaciones),(ej.equipo)")
                ->from("EstadisticaJugador", 'ej')
                ->where("ej.jugador=(SELECT j.id FROM Jugador j WHERE j.id=".$jugador->getId().")")
                ->groupBy("ej.equipo");
                
    $estadisticas = $queryEstadisticas->getQuery()->getResult();
    
    $estadisticasStr="
    <div class='col-xl-4 col-lg-6 col-md-12 col-sm-12'>
    <div class='row px-2 text-secondary mt-5'>
    <div class='col'><h3>Estadísticas en equipos</h3></div></div>
    <table class='table'>
            <thead class='bg-primary' ><tr>
            <th scope='col' class='text-center'>Equipo</th>
            <th scope='col' class='text-center'>Goles</th>
            <th scope='col' class='text-center'>Pérdidas</th>
            <th scope='col' class='text-center'>Rec.</th>
            </tr></thead><tbody class='border-right border-top border-secondary'>";
   
   
    foreach($estadisticas as $estadistica){
        $equipo=$entityM->find("Equipo",$estadistica[4]);
        
        if($equipo->getTipoEquipo()->getTipo()=="A"){
            $tipo="";
        }
        else {
            $tipo=$equipo->getTipoEquipo()->getTipo();
        }
        $estadisticasStr=$estadisticasStr."
    
                <tr>
                <td class='text-center'><h6>".$equipo->getClub()->getNombreCorto()." ".$tipo."</h6></td>
                <td class='text-center'>".$estadistica[1]."</td>
                <td class='text-center'>".$estadistica[2]."</td>
                <td class='text-center'>".$estadistica[3]."</td>
                </tr>
                ";
        
    }

    $estadisticasStr=$estadisticasStr."</tbody>
    </table>
    </div>
    </div>";

      return $estadisticasStr;
}


function cargarPantallaError($dato){

    echo "<div class='row justify-content-center text-center m-5'>
    <div class='col-12 '><h1>404 Not Found</h1></div></div>
    <div class='row justify-content-center text-center'>
    <div class='col'><h3>No existe el ".$dato."</h3></div></div>";
}


function cargarPais($pais){

    $entityM=cargar("admin");
    $pais=$entityM->getRepository("Pais")->findOneBy(["nombre"=>$pais]);

    if(!is_null($pais)){
        echo "<h3 class='text-secondary'>Noticias de ".$pais->getNombre()."</h3>";
    }
}

function cargarCompeticion($competicion){

    $entityM=cargar("admin");
    $competicion=$entityM->getRepository("Competicion")->findOneBy(["nombre"=>$competicion]);

    if(!is_null($competicion)){
        echo "<h3 class='text-secondary'>Noticias de ".$competicion->getNombre()."</h3>";
    }
}


function busqueda(){

    $entityM=cargar("admin");
   
    if(isset($_POST["persona"])){
         $continentes=$entityM->getRepository("Continente")->findAll();
    $niveles=$entityM->getRepository("TipoContrato")->findAll();
    $tecnicos=[];
    $jugadores=[];
    $persona=filter_input(INPUT_POST, "persona");
        $flag="";
    if(isset($_POST["jugador"])){
       
        $consulta="select j from Jugador j where (j.nombre like '%$persona%' or j.apellido1 like '%$persona%' or j.apellido2 like '%$persona%')";
        if(isset($_POST["sinEquipo"])){
            $consulta=$consulta." and (j.equipoActual is null";
            $flag=")";
            
        }

        if(isset($_POST["conEquipo"]) and !isset($_POST["sinEquipo"])){
            $consulta=$consulta." and (j.equipoActual is not null";
            $flag=")";
            
        }
        else if(isset($_POST["conEquipo"]) and isset($_POST["sinEquipo"])){
            $consulta=$consulta." or j.equipoActual is not null";
        }

        $consulta=$consulta.$flag;  

        $flag="";
        if(isset($_POST["masculino"])){
            $consulta=$consulta." and (j.genero='M'";
            $flag=")";
        }

        if(isset($_POST["femenino"]) and !isset($_POST["masculino"])){
            $consulta=$consulta." and (j.genero='F'";
            $flag=")";
            
        }
        else if(isset($_POST["femenino"]) and isset($_POST["masculino"])){
            $consulta=$consulta." or j.genero='F'";
        }

        $consulta=$consulta.$flag; 
     
    $flag="";
    $repetido=true;
    foreach($continentes as $continente){
        
        if(isset($_POST[$continente->getNombre()])){
            
            if($repetido){
            $consulta=$consulta." and (j.pais IN(select p.id from Pais p where p.continente IN(select c.id from Continente c where c.nombre='".$continente->getNombre()."'";
            $repetido=false;
            $flag=")))";
            
            }
            else {

                $consulta=$consulta." or c.nombre='".$continente->getNombre()."'";
                
            }
        }
    }

    $consulta=$consulta.$flag;
    $flag="";
    $repetido=true;
    foreach($niveles as $nivel){

        if(isset($_POST[$nivel->getTipoContrato()])){

            if($repetido){
                $consulta=$consulta." and (j.tipoContrato IN(select tp.id from TipoContrato tp where tp.tipoContrato='".$nivel->getTipoContrato()."'";
                $flag="))";
                $repetido=false;
            }
            else {
                $consulta=$consulta." or tp.tipoContrato='".$nivel->getTipoContrato()."'";
            }
        }
    }



    $consulta=$consulta.$flag." order by j.reputacion DESC";   
    $queryJugadores=$entityM->createQuery($consulta);            
    $jugadores = $queryJugadores->getResult();
    }

    
    if(isset($_POST["tecnico"])){
        $flag="";
        $consulta="select t from CuerpoTecnico t where (t.nombre like '%$persona%' or t.apellido1 like '%$persona%' or t.apellido2 like '%$persona%')";
        
        if(isset($_POST["sinEquipo"])){
            $consulta=$consulta." and (t.equipoActual is null";
            $flag=")";
            
        }

        if(isset($_POST["conEquipo"]) and !isset($_POST["sinEquipo"])){
            $consulta=$consulta." and (t.equipoActual is not null";
            $flag=")";
            
        }
        else if(isset($_POST["conEquipo"]) and isset($_POST["sinEquipo"])){
            $consulta=$consulta." or t.equipoActual is not null";
        }
        $consulta=$consulta.$flag;

        $flag="";
        if(isset($_POST["masculino"])){
            $consulta=$consulta." and (t.genero='M'";
            $flag=")";
        }

        if(isset($_POST["femenino"]) and !isset($_POST["masculino"])){
            $consulta=$consulta." and (t.genero='F'";
            $flag=")";
            
        }
        else if(isset($_POST["femenino"]) and isset($_POST["masculino"])){
            $consulta=$consulta." or t.genero='F'";
        }

        $consulta=$consulta.$flag;

    $flag="";
    $repetido=true;
    foreach($continentes as $continente){
        
        if(isset($_POST[$continente->getNombre()])){
            
            if($repetido){
            $consulta=$consulta." and (t.pais IN(select p.id from Pais p where p.continente IN(select c.id from Continente c where c.nombre='".$continente->getNombre()."'";
            $flag=")))";
            $repetido=false;
            }
            else {

                $consulta=$consulta." or c.nombre='".$continente->getNombre()."'";
                
            }
        }
    }
    $consulta=$consulta.$flag;
    $flag="";
    $repetido=true;
    foreach($niveles as $nivel){

        if(isset($_POST[$nivel->getTipoContrato()])){

            if($repetido){
                $consulta=$consulta." and (t.tipoContrato IN(select tp.id from TipoContrato tp where tp.tipoContrato='".$nivel->getTipoContrato()."'";
                $flag="))";
                $repetido=false;
            }
            else {
                $consulta=$consulta." or tp.tipoContrato='".$nivel->getTipoContrato()."'";
            }
        }
    }

    $consulta=$consulta.$flag." order by t.reputacion DESC";   
    $queryTecnicos=$entityM->createQuery($consulta);            
    $tecnicos = $queryTecnicos->getResult();
    }
    
    $personas=array_merge($jugadores,$tecnicos);
    usort($personas, fn($a, $b) => ($a->getReputacion() < $b->getReputacion()) ? 1 : (($a->getReputacion() > $b->getReputacion()) ? -1 : 0));

   if(count($personas)>0){


    echo "<div class = 'table-responsive'>
    <table class='table text-center border-top border-secondary border-right'>
            <thead class='bg-primary'>
            <th>#</th>
            <th>Persona</th>
            <th>Trabajo</th>
            <th>Edad</th>
            <th>Nacionalidad</th>
            <th>Equipo Actual</th>
            <th>Nivel</th>
            </thead><tbody class='border-top border-right border-secondary'>";
    foreach($personas as $persona){

if($persona instanceof Jugador){
    $puesto="Jugador";
    $enlace="fichajugador.php?id=".$persona->getId()."";
    if(file_exists("img/jugadores/".$persona->getId().".jpg")){
        $imagen="<img src='img/jugadores/".$persona->getId()."mini.jpg' class='img-fluid'/>";
    }
    else {
        $imagen="<img src='img/jugadores/defectomini.jpg' class='img-fluid'/>";
    }
    
}
else if($persona instanceof CuerpoTecnico){
    $puesto=$persona->getPuesto()->getPuesto();
    $enlace="fichatecnico.php?id=".$persona->getId()."";
    if(file_exists("img/tecnicos/".$persona->getId().".jpg")){
        $imagen="<img src='img/tecnicos/".$persona->getId()."mini.jpg' class='img-fluid'/>";
    }
    else {
        $imagen="<img src='img/tecnicos/defectomini.jpg' class='img-fluid'/>";
    }
    
}

if(!is_null($persona->getEquipoActual())){

    if($persona->getEquipoActual()->getTipoEquipo()->getTipo()=="A"){
         $equipoActual="<a href='fichaequipo.php?id=".$persona->getEquipoActual()->getId()."' class='text-dark'>".$persona->getEquipoActual()->getClub()->getNombreCompleto()."</a>";
    }
    else {
        $equipoActual="<a href='fichaequipo.php?id=".$persona->getEquipoActual()->getId()."' class='text-dark'>".$persona->getEquipoActual()->getClub()->getNombreCompleto()." ".$persona->getEquipoActual()->getTipoEquipo()->getTipo()."</a>";
    }
   
}
else {
    $equipoActual="Sin Equipo";
}

$edad = DateTime::createFromFormat('Y-m-d', date_format($persona->getFechaNacimiento(),"Y-m-d"))
     ->diff(new DateTime('now'))
     ->y;

        echo "<tr>
        <td>$imagen</td>
        <td><a href='".$enlace."' class='text-dark'>".$persona->getNombre()." ".$persona->getApellido1()."</a></td>
        <td>".$puesto."</td>
        <td>".$edad."</td>
        <td>".$persona->getPais()->getNacionalidad()."</td>
        <td><a>".$equipoActual."</a></td>
        <td>".$persona->getTipoContrato()->getTipoContrato()."</td>
        </tr>";
    }
        echo "</tbody></table></div>";
   

    }
   else {

    echo "<h3 class='text-center text-danger'>La búsqueda no devolvió ningún resultado</h3>";
   }
   
    }
    else if(isset($_POST["equipos"])){
        
        $paises=$entityM->getRepository("Pais")->findAll();
        $flag="";
        $consulta="select e from Equipo e where (e.club IN(select c.id from Club c where (c.nombreCompleto like '%".$_POST["equipos"]."%'";
        $repetido=false;
        $flag=")))";
        foreach($paises as $pais){
            if(isset($_POST[$pais->getNombre()])){
                if($repetido){
                    $consulta.$consulta." or p.nombre='".$pais->getNombre()."'";
                }
                else {
                    $consulta=$consulta." and c.pais IN(select p.id from Pais p where (p.nombre='".$pais->getNombre()."'";
                    $repetido=true;
                    $flag=")))))";
                }
            }
            
        }
        
        
        $consulta=$consulta.$flag;

        $flag="";
        $generoRepetido=false;
        if(isset($_POST["masculino"])){
            $consulta=$consulta." and (e.genero='M'";
            $generoRepetido=true;
            $flag=")";
        }

        if(isset($_POST["femenino"])){

            if($generoRepetido){
                $consulta=$consulta." or e.genero='F'";
            }
            else {
                $consulta=$consulta."and (e.genero='F'";
                $flag=")";
            }
        }
        $consulta=$consulta.$flag;
        $flag="";
        $repetido=false;
        $niveles=$entityM->getRepository("TipoEquipo")->findAll();
        foreach($niveles as $nivel){
            if(isset($_POST[$nivel->getTipo()])){

                if($repetido){
                    $consulta=$consulta."or te.tipo='".$nivel->getTipo()."'";
                }
                else {
                    $consulta=$consulta." and (e.tipoEquipo IN(select te.id from TipoEquipo te where (te.tipo='".$nivel->getTipo()."' ";
                    $repetido=true;
                    $flag=")))";
                }
            }
        }


        $consulta=$consulta.$flag;

        $queryEquipos=$entityM->createQuery($consulta);            
        $equipos = $queryEquipos->getResult();
        if(count($equipos)>0){
            usort($equipos, fn($a, $b) => ($a->getReputacion() < $b->getReputacion()) ? 1 : (($a->getReputacion() > $b->getReputacion()) ? -1 : 0));
        echo "<div class='table-responsive'>
        <table class='table text-center border-top border-secondary border-right'>
                <thead class='bg-primary'>
                <th>#</th>
                <th>Equipo</th>
                <th>País</th>
                <th>Género</th>
                <th>Entrenador</th>
                <th>Competición</th>
                </thead><tbody class='border-top border-right border-secondary'>";
        foreach($equipos as $equipo){


            if($equipo->getTipoEquipo()->getTipo()=="A"){
                $equipoStr=$equipo->getClub()->getNombreCompleto();
            }
            else {
                $equipoStr=$equipo->getClub()->getNombreCompleto()." ".$equipo->getTipoEquipo()->getTipo();
            }

            if($equipo->getGenero()=="M"){
                $genero="Masculino";
            }
            else {
                $genero="Femenino";
            }
            $entrenadorEncontrado=false;
            foreach($equipo->getCuerpoTecnico() as $tecnico){

                if($tecnico->getPuesto()->getPuesto()=="Entrenador"){
                    $entrenadorEncontrado=true;
                    $entrenador=$tecnico;
                }
            }

            if($entrenadorEncontrado){
                if(!is_null($entrenador->getApodo())){
                    $entrenador="<a href='fichatecnico.php?id=".$entrenador->getId()."' class='text-dark'>".$entrenador->getApodo()."</a>";
                }
                else {
                    $entrenador="<a href='fichatecnico.php?id=".$entrenador->getId()."' class='text-dark'>".$entrenador->getNombre()." ".$entrenador->getApellido1()."</a>";
                }
                
            }
            else {
                $entrenador="Sin entrenador";
            }

            echo "<tr>
            <td><img src='img/clubs/".$equipo->getClub()->getId()."mini.jpg'/></td>
            <td><a href='fichaequipo.php?id=".$equipo->getId()."' class='text-dark'>$equipoStr</a></td>
            <td>".$equipo->getClub()->getPais()->getNombre()."</td>
            <td>$genero</td>
            <td>$entrenador</td>
            <td><a href='fichacompeticion.php?id=".$equipo->getCompeticion()->getId()."' class='text-dark'>".$equipo->getCompeticion()->getNombre()."</a></td>
            </tr>";
        }

        echo "</tbody></table></div>";
    }
    else {
        echo "<h3 class='text-center text-danger'>La búsqueda no devolvió ningún resultado</h3>";
    }
}

else if (isset($_POST["buscatecnico"])){

    $paises=$entityM->getRepository("Pais")->findAll();
        $flag="";
        $consulta="select t from CuerpoTecnico t where (t.nombre like '%".$_POST["buscatecnico"]."%' or t.apellido1 like '%".$_POST["buscatecnico"]."%' or t.apellido2 like '%".$_POST["buscatecnico"]."%') ";



        $puestos=$entityM->getRepository("PuestoCuerpoTecnico")->findAll();
        $repetido=false;
        foreach($puestos as $puesto){

            if(isset($_POST[$puesto->getPuesto()])){

                if($repetido){
                    $consulta=$consulta." or p.puesto='".$puesto->getPuesto()."'";
                }
                else {
                    $consulta=$consulta." and (t.puesto IN(select p.id from PuestoCuerpoTecnico p where (p.puesto='".$puesto->getPuesto()."'";
                    $flag=")))";
                    $repetido=true;
                }
            }
        }
        $consulta=$consulta.$flag;
        $flag="";
        $repetido=false;
        foreach($paises as $pais){

            if(isset($_POST[$pais->getNombre()])){

                if($repetido){
                    $consulta=$consulta." or pa.nombre='".$pais->getNombre()."'";
                }
                else {
                    $consulta=$consulta." and (t.pais IN(select pa.id from Pais pa where (pa.nombre='".$pais->getNombre()."'";
                    $repetido=true;
                    $flag=")))";
                }
            }
        }
         $consulta=$consulta.$flag;

         $flag="";
         $repetido=false;

         if(isset($_POST["masculino"])){

            $consulta=$consulta." and (t.genero='M'";
            $flag=")";
            $repetido=true;
         }
         
         if(isset($_POST["femenino"])){
            if($repetido){
                $consulta=$consulta." or t.genero='F'";
            }
            else {
                $consulta=$consulta." and (t.genero='F'";
                $flag=")";
            }
         }

         $consulta=$consulta.$flag;

         $flag="";
         $repetido=false;
         if(isset($_POST["sinEquipo"])){
            $consulta=$consulta." and (t.equipoActual IS NULL";
            $flag=")";
            $repetido=true;
         }

         if(isset($_POST["conEquipo"])){

            if($repetido){
                $consulta=$consulta." or t.equipoActual IS NOT NULL";
            }
            else {
                $consulta=$consulta."and (t.equipoActual IS NOT NULL";
                $flag=")";
            }
         }
         
         $consulta=$consulta.$flag;
        $queryTecnicos=$entityM->createQuery($consulta);            
        $tecnicos = $queryTecnicos->getResult();
        usort($tecnicos, fn($a, $b) => ($a->getReputacion() < $b->getReputacion()) ? 1 : (($a->getReputacion() > $b->getReputacion()) ? -1 : 0));
        if(count($tecnicos)>0){
        echo "<div class='table-responsive'>
        <table class='table text-center border-top border-secondary border-right'>
                <thead class='bg-primary'>
                <th>#</th>
                <th>Técnico</th>
                <th>Trabajo</th>
                <th>Edad</th>
                <th>Nacionalidad</th>
                <th>Género</th>
                <th>Equipo</th>
                <th>Nivel</th>
                </thead><tbody class='border-top border-right border-secondary'>";

            foreach($tecnicos as $tecnico){

                if(file_exists("img/tecnicos/".$tecnico->getId()."mini.jpg")){
                    $imagen="<img src='img/tecnicos/".$tecnico->getId()."mini.jpg' class='img-fluid'/>";
                }
                else {
                    $imagen="<img src='img/tecnicos/defectomini.jpg' class='img-fluid'/>";
                }

                if($tecnico->getGenero()=="M"){
                    $genero="Masculino";
                }
                else {
                    $genero="Femenino";
                }

                $edad = DateTime::createFromFormat('Y-m-d', date_format($tecnico->getFechaNacimiento(),"Y-m-d"))
                ->diff(new DateTime('now'))
                ->y;

                if(!is_null($tecnico->getEquipoActual())){
                    
                    if($tecnico->getEquipoActual()->getTipoEquipo()->getTipo()=="A"){
                        $equipo="<a href='fichaequipo.php?id=".$tecnico->getEquipoActual()->getId()."' class='text-dark'>".$tecnico->getEquipoActual()->getClub()->getNombreCompleto()." </a>";
                    }
                    else {
                        $equipo="<a href='fichaequipo.php?id=".$tecnico->getEquipoActual()->getId()."' class='text-dark'>".$tecnico->getEquipoActual()->getClub()->getNombreCompleto()." ".$tecnico->getEquipoActual()->getTipoEquipo()->getTipo()." </a>";
                    }
                }
                else {
                    $equipo="Sin equipo";
                }

                echo "<tr>
                <td>$imagen</td>
                <td><a href='fichatecnico.php?id=".$tecnico->getId()."' class='text-dark'>".$tecnico->getNombre()." ".$tecnico->getApellido1()." ".$tecnico->getApellido2()."</a></td>
                <td>".$tecnico->getPuesto()->getPuesto()."</td>
                <td>$edad</td>
                <td>".$tecnico->getPais()->getNacionalidad()."</td>
                <td>$genero</td>
                <td>$equipo</td>
                <td>".$tecnico->getTipoContrato()->getTipoContrato()."</td>
                </tr>";
            }

        echo "</tbody></table></div>";
        }
        else {
            echo "<h3 class='text-center text-danger'>La búsqueda no devolvió ningún resultado</h3>";
        }

}

else if(isset($_POST["buscajugador"])){

    $paises=$entityM->getRepository("Pais")->findAll();
    $flag="";
    $consulta="select j from Jugador j where (j.nombre like '%".$_POST["buscajugador"]."%' or j.apellido1 like '%".$_POST["buscajugador"]."%' or j.apellido2 like '%".$_POST["buscajugador"]."%') ";
    $puestos=$entityM->getRepository("Puesto")->findAll();


    $repetido=false;
    $flag="";
    foreach($puestos as $puesto){
        if(isset($_POST[$puesto->getPuestoCorto()])){
            
            if($repetido){
                $consulta=$consulta." or p.puesto='".$puesto->getPuesto()."'";
            }
            else {
                $consulta=$consulta." and (j.puestos.id IN(select p.id from Puesto p where (p.puesto='".$puesto->getPuesto()."'";
                $flag=")))";
                $repetido=true;
            }
        }
    }
    $consulta=$consulta.$flag;

    $repetido=false;
    $flag="";
    foreach($paises as $pais){
        
        if(isset($_POST[$pais->getNombre()])){
            if($repetido){
                $consulta=$consulta." or p.nombre='".$pais->getNombre()."'";
            }
            else {
                $consulta=$consulta." and (j.pais IN(select p.id from Pais p where (p.nombre='".$pais->getNombre()."'";
                $repetido=true;
                $flag=")))";
            }
        }
    }
    $consulta=$consulta.$flag;
    
    $flag="";
    $repetido=false;

    if(isset($_POST["masculino"])){
        $consulta=$consulta." and (j.genero='M'";
        $flag=")";
        $repetido=true;
    }
    if(isset($_POST["femenino"])){
        if($repetido){
            $consulta=$consulta." or j.genero='F'";
            
        }
        else {
            $consulta=$consulta." and (j.genero='F'";
            $flag=")";
        }
    }
    $consulta=$consulta.$flag;


    $flag="";
    $repetido=false;

    if(isset($_POST["sinEquipo"])){
        $consulta=$consulta." and (j.equipoActual IS NULL";
        $flag=")";
        $repetido=true;
    }

    if(isset($_POST["conEquipo"])){
        if($repetido){
            $consulta=$consulta." or j.equipoActual IS NOT NULL";
        }
        else {
            $consulta=$consulta." and (j.equipoActual IS NOT NULL";
            $flag=")";
        }
    }
    $consulta=$consulta.$flag;

    $queryJugadores=$entityM->createQuery($consulta);            
    $jugadores = $queryJugadores->getResult();
    usort($jugadores, fn($a, $b) => ($a->getReputacion() < $b->getReputacion()) ? 1 : (($a->getReputacion() > $b->getReputacion()) ? -1 : 0));

    if(count($jugadores)>0){

        echo "<div class='table-responsive'>
        <table class='table text-center border-top border-secondary border-right'>
                <thead class='bg-primary'>
                <th>#</th>
                <th>Jugador</th>
                <th>Puesto</th>
                <th>Edad</th>
                <th>Nacionalidad</th>
                <th>Género</th>
                <th>Equipo</th>
                <th>Nivel</th>
                </thead><tbody class='border-top border-right border-secondary'>";


            foreach($jugadores as $jugador){

                if(file_exists("img/jugadores/".$jugador->getId()."mini.jpg")){
                    $imagen="<img src='img/jugadores/".$jugador->getId()."mini.jpg' class='img-fluid'/>";
                }
                else {
                    $imagen="<img src='img/jugadores/defectomini.jpg' class='img-fluid'/>";
                }

                if($jugador->getGenero()=="M"){
                    $genero="Masculino";
                }
                else {
                    $genero="Femenino";
                }

                $edad = DateTime::createFromFormat('Y-m-d', date_format($jugador->getFechaNacimiento(),"Y-m-d"))
                ->diff(new DateTime('now'))
                ->y;

                if(!is_null($jugador->getEquipoActual())){
                    
                    if($jugador->getEquipoActual()->getTipoEquipo()->getTipo()=="A"){
                        $equipo="<a href='fichaequipo.php?id=".$jugador->getEquipoActual()->getId()."' class='text-dark'>".$jugador->getEquipoActual()->getClub()->getNombreCompleto()." </a>";
                    }
                    else {
                        $equipo="<a href='fichaequipo.php?id=".$jugador->getEquipoActual()->getId()."' class='text-dark'>".$jugador->getEquipoActual()->getClub()->getNombreCompleto()." ".$jugador->getEquipoActual()->getTipoEquipo()->getTipo()." </a>";
                    }
                }
                else {
                    $equipo="Sin equipo";
                }
                
                foreach($jugador->getPuestos() as $puesto){

                    if($puesto==$jugador->getPuestos()[0]){
                        $puestosStr=$puesto->getPuestoCorto();
                    }
                    else {
                        $puestosStr=$puestosStr."/".$puesto->getPuestoCorto();
                    }
                }
                echo "<tr>
                <td>$imagen</td>
                <td><a href='fichajugador.php?id=".$jugador->getId()."' class='text-dark'>".$jugador->getNombre()." ".$jugador->getApellido1()." ".$jugador->getApellido2()."</a></td>
                <td>$puestosStr</td>
                <td>$edad</td>
                <td>".$jugador->getPais()->getNacionalidad()."</td>
                <td>$genero</td>
                <td>$equipo</td>
                <td>".$jugador->getTipoContrato()->getTipoContrato()."</td>
                </tr>";

            }

                echo "</tbody></table></div>";

    }
    else {
        echo "<h3 class='text-center text-danger'>La búsqueda no devolvió ningún resultado</h3>";
    }
}
else {
    echo "<h3 class='text-center text-danger'>La búsqueda no devolvió ningún resultado</h3>";
}



}


function cargarFiltrosBusqueda($tipoBusqueda){


    if($tipoBusqueda=="personas"){

        
        echo "<form action='busqueda.php' method='POST'>
        <div class='row'><div class='col mt-3'><h3 class='text-secondary'>Búsqueda avanzada</h3></div></div>
        <input class='form-control p-2 ' placeholder='Buscar personas' type='text' name='persona'>
        <button class='btn btn-secondary p-2' type='submit'><i class='fa fa-search fa-lg text-white' aria-hidden='true'></i></button>
        <div class='row mt-3'><div class='col'><h4 class='text-secondary'>Filtrar por:</h4></div></div>
       
        <div class='row mt-3'><div class='col'><h6>Tipo de persona:</div></div>
        <div class='row'><div class='col'>
        <div class='form-check'>
            <input class='form-check-input' type='checkbox' value='' id='jugador' name='jugador'"; 
            if(isset($_POST["jugador"])){
                echo "checked";
            };
               echo "><label class='form-check-label' for='jugador'>Jugador</label>
            </div>
        <div class='form-check'>
            <input class='form-check-input' type='checkbox' value='' id='tecnico' name='tecnico'";
            if(isset($_POST["tecnico"])){
                echo "checked";
            };
                echo "><label class='form-check-label' for='tecnico'>Técnico</label>
            </div>



            <div class='row mt-3'> <div class='col'><h6>Género: </h6></div>
            </div>
            <div class='row'><div class='col'>
            <div class='form-check'>
            <input class='form-check-input' type='checkbox' value='' id='masculino' name='masculino'
            ";
                if(isset($_POST["masculino"])){
                    echo "checked";
                }
            echo "><label class='form-check-label' for='masculino'>Masculino</label>
            </div>
            <div class='form-check'>
            <input class='form-check-input' type='checkbox' value='' id='femenino' name='femenino'";
            if(isset($_POST["femenino"])){
                echo "checked";
            }
            echo "><label class='form-check-label' for='femenino'>Femenino</label>
            </div>
            </div></div>




            <div class='row mt-3'>
        <div class='col'><h6>Continente: </h6></div>
        </div>
        <div class='row'><div class='col'>
        ".$continentes=cargarContinentes()."
        </div></div>
        
        <div class='row mt-3'> <div class='col'><h6>Nivel: </h6></div>
        </div>
        <div class='row'><div class='col'>
        ".$nivel=cargarNiveles()."
        </div></div>


        <div class='row mt-3'> <div class='col'><h6>Estado: </h6></div>
        </div>
        <div class='row'><div class='col'>
        <div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='sinEquipo' name='sinEquipo'
        ";
            if(isset($_POST["sinEquipo"])){
                echo "checked";
            }
        echo "><label class='form-check-label' for='sinEquipo'>Sin equipo</label>
        </div>
        <div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='conEquipo' name='conEquipo'";
        if(isset($_POST["conEquipo"])){
            echo "checked";
        }
        echo "><label class='form-check-label' for='conEquipo'>Con equipo</label>
        </div>
        </div></div>


        

        </div>
        </form>
        </div>
        ";

    }

    else if($tipoBusqueda=="equipos"){


        echo "<form action='busqueda.php' method='POST'>
        <div class='row'><div class='col mt-3'><h3 class='text-secondary'>Búsqueda avanzada</h3></div></div>
        <input class='form-control p-2 ' placeholder='Buscar equipos' type='text' name='equipos'>
        <button class='btn btn-secondary p-2' type='submit'><i class='fa fa-search fa-lg text-white' aria-hidden='true'></i></button>
        <div class='row mt-3'><div class='col'><h4 class='text-secondary'>Filtrar por:</h4></div></div>
       
        <div class='row mt-3'><div class='col'><h6>País:</div></div>
        <div class='row'><div class='col'>
        ";
        cargarPaises();
        echo "</div></div>

        <div class='row mt-3'><div class='col'><h6>Género:</div></div>
        <div class='row'><div class='col'>

        <div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='masculino' name='masculino'";
        if(isset($_POST["masculino"])){
            echo "checked";
        };
        echo "><label class='form-check-label' for='masculino'>Masculino</label>
        </div>
        <div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='femenino' name='femenino'";
        if(isset($_POST["femenino"])){
            echo "checked";
        };
        echo "><label class='form-check-label' for='femenino'>Femenino</label>
        </div>
        </div></div>

        <div class='row mt-3'><div class='col'><h6>Nivel:</div></div>
        <div class='row'><div class='col'>";
        cargarTiposEquipo();
        echo "</div></div>

        </form>";

    }

    else if($tipoBusqueda=="tecnicos"){
        echo "<form action='busqueda.php' method='POST'>
        <div class='row'><div class='col mt-3'><h3 class='text-secondary'>Búsqueda avanzada</h3></div></div>
        <input class='form-control p-2 ' placeholder='Buscar técnicos' type='text' name='buscatecnico'>
        <button class='btn btn-secondary p-2' type='submit'><i class='fa fa-search fa-lg text-white' aria-hidden='true'></i></button>
        <div class='row mt-3'><div class='col'><h4 class='text-secondary'>Filtrar por:</h4></div></div>
       

        <div class='row mt-3'><div class='col'><h6>Puesto:</div></div>
        <div class='row'><div class='col'>";
        cargarPuestosTecnicos();
        echo "</div></div>

        <div class='row mt-3'><div class='col'><h6>País:</div></div>
        <div class='row'><div class='col'>
        ";
        cargarPaises();
        echo "</div></div>

        <div class='row mt-3'><div class='col'><h6>Género:</div></div>
        <div class='row'><div class='col'>

        <div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='masculino' name='masculino'";
        if(isset($_POST["masculino"])){
            echo "checked";
        };
        echo "><label class='form-check-label' for='masculino'>Masculino</label>
        </div>
        <div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='femenino' name='femenino'";
        if(isset($_POST["femenino"])){
            echo "checked";
        };
        echo "><label class='form-check-label' for='femenino'>Femenino</label>
        </div>
        </div></div>


        <div class='row mt-3'> <div class='col'><h6>Estado: </h6></div>
        </div>
        <div class='row'><div class='col'>
        <div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='sinEquipo' name='sinEquipo'
        ";
            if(isset($_POST["sinEquipo"])){
                echo "checked";
            }
        echo "><label class='form-check-label' for='sinEquipo'>Sin equipo</label>
        </div>
        <div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='conEquipo' name='conEquipo'";
        if(isset($_POST["conEquipo"])){
            echo "checked";
        }
        echo "><label class='form-check-label' for='conEquipo'>Con equipo</label>
        </div>
        </div></div>
        

        </form>";
    }

    else if($tipoBusqueda=="jugadores"){
        echo "<form action='busqueda.php' method='POST'>
        <div class='row'><div class='col mt-3'><h3 class='text-secondary'>Búsqueda avanzada</h3></div></div>
        <input class='form-control p-2 ' placeholder='Buscar técnicos' type='text' name='buscajugador'>
        <button class='btn btn-secondary p-2' type='submit'><i class='fa fa-search fa-lg text-white' aria-hidden='true'></i></button>
        <div class='row mt-3'><div class='col'><h4 class='text-secondary'>Filtrar por:</h4></div></div>
       

        <div class='row mt-3'><div class='col'><h6>Puesto:</div></div>
        <div class='row'><div class='col'>";
        cargarPuestosJugador();
        echo "</div></div>

        <div class='row mt-3'><div class='col'><h6>País:</div></div>
        <div class='row'><div class='col'>
        ";
        cargarPaises();
        echo "</div></div>

        <div class='row mt-3'><div class='col'><h6>Género:</div></div>
        <div class='row'><div class='col'>

        <div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='masculino' name='masculino'";
        if(isset($_POST["masculino"])){
            echo "checked";
        };
        echo "><label class='form-check-label' for='masculino'>Masculino</label>
        </div>
        <div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='femenino' name='femenino'";
        if(isset($_POST["femenino"])){
            echo "checked";
        };
        echo "><label class='form-check-label' for='femenino'>Femenino</label>
        </div>
        </div></div>


        <div class='row mt-3'> <div class='col'><h6>Estado: </h6></div>
        </div>
        <div class='row'><div class='col'>
        <div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='sinEquipo' name='sinEquipo'
        ";
            if(isset($_POST["sinEquipo"])){
                echo "checked";
            }
        echo "><label class='form-check-label' for='sinEquipo'>Sin equipo</label>
        </div>
        <div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='conEquipo' name='conEquipo'";
        if(isset($_POST["conEquipo"])){
            echo "checked";
        }
        echo "><label class='form-check-label' for='conEquipo'>Con equipo</label>
        </div>
        </div></div>
        

        </form>";
    }
}
function cargarPuestosJugador(){
    $entityM=cargar("admin");
    $puestos=$entityM->getRepository("Puesto")->findAll();

    foreach($puestos as $puesto){
        echo "<div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='".$puesto->getPuestoCorto()."' name='".$puesto->getPuestoCorto()."'";
        if(isset($_POST[$puesto->getPuestoCorto()])){
            echo "checked";
        }
        echo "><label class='form-check-label' for='".$puesto->getPuestoCorto()."'>".$puesto->getPuesto()."</label>
        </div>";
    }
}

function cargarPuestosTecnicos(){

    $entityM=cargar("admin");
    $puestos=$entityM->getRepository("PuestoCuerpoTecnico")->findAll();

    foreach($puestos as $puesto){
        echo "<div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='".$puesto->getPuesto()."' name='".$puesto->getPuesto()."'";
        if(isset($_POST[$puesto->getPuesto()])){
            echo "checked";
        };
        echo "><label class='form-check-label' for='".$puesto->getPuesto()."'>".$puesto->getPuesto()."</label>
        </div>";

    }
}

function cargarTiposEquipo(){
    $entityM=cargar("admin");
    $tiposEquipo=$entityM->getRepository("TipoEquipo")->findAll();

    foreach($tiposEquipo as $tipoEquipo){
        echo "<div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='".$tipoEquipo->getTipo()."' name='".$tipoEquipo->getTipo()."'";
        if(isset($_POST[$tipoEquipo->getTipo()])){
            echo "checked";
        }
        echo " ><label class='form-check-label' for='".$tipoEquipo->getTipo()."'>".$tipoEquipo->getTipo()."</label>
        </div>
        ";
    }
}

function cargarContinentes(){
    $entityM=cargar("admin");
    $continentes=$entityM->getRepository("Continente")->findAll();
    usort($continentes, fn($b, $a) => strcmp($b->getNombre(), $a->getNombre()));
    $continentesStr="";
    foreach($continentes as $continente){
        $continentesStr=$continentesStr."<div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='".$continente->getNombre()."' name='".$continente->getNombre()."'";
        if(isset($_POST[$continente->getNombre()])){
            $continentesStr=$continentesStr."checked";
        };
        $continentesStr=$continentesStr."><label class='form-check-label' for='".$continente->getNombre()."'>".$continente->getNombre()."</label>
        </div>";
    }

    return $continentesStr;
}

function cargarPaises(){
    $entityM=cargar("admin");
    $paises=$entityM->getRepository("Pais")->findAll();
    usort($paises, fn($b, $a) => strcmp($b->getNombre(), $a->getNombre()));
    $paisesStr="";
    foreach($paises as $pais){
        $paisesStr=$paisesStr."<div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='".$pais->getNombre()."' name='".$pais->getNombre()."'";

        if(isset($_POST[$pais->getNombre()])){
            $paisesStr=$paisesStr."checked";
        }
        $paisesStr=$paisesStr."><label class='form-check-label' for='".$pais->getNombre()."'>".$pais->getNombre()."</label>
        </div>";
    }

    echo $paisesStr;
}
function cargarNiveles(){
    $entityM=cargar("admin");
    $niveles=$entityM->getRepository("TipoContrato")->findAll();
    $nivelesStr="";

    foreach($niveles as $nivel){
        $nivelesStr=$nivelesStr."<div class='form-check'>
        <input class='form-check-input' type='checkbox' value='' id='".$nivel->getTipoContrato()."' name='".$nivel->getTipoContrato()."'";
        if(isset($_POST[$nivel->getTipoContrato()])){
            $nivelesStr=$nivelesStr."checked";
        };
        $nivelesStr=$nivelesStr."><label class='form-check-label' for='".$nivel->getTipoContrato()."'>".$nivel->getTipoContrato()."</label>
        </div>";
    }

    return $nivelesStr;
}


function cargarDatosTecnico($idTecnico){
    $entityM=cargar("admin");

    $tecnico=$entityM->find("CuerpoTecnico",$idTecnico);
    if(!is_null($tecnico)){

    
    $edad = DateTime::createFromFormat('Y-m-d', date_format($tecnico->getFechaNacimiento(),"Y-m-d"))
     ->diff(new DateTime('now'))
     ->y;

    if(!is_null($tecnico->getApodo())){

        $apodo="'".$tecnico->getApodo()."'";
    }
    else {
        $apodo=null;
    }

    if(!is_null($tecnico->getEquipoActual())){

        if($tecnico->getEquipoActual()->getTipoEquipo()->getTipo()=="A"){
            $equipoActual=$tecnico->getEquipoActual()->getClub()->getNombreCompleto();
        }
        else {
            $equipoActual=$tecnico->getEquipoActual()->getClub()->getNombreCompleto()." ".$tecnico->getEquipoActual()->getTipoEquipo()->getTipo();
        }
        
    }
    else {
        $equipoActual="Sin equipo";
    }

    $puestos="";

    if(isset($_SESSION["usuario"])){
        $usuario=$entityM->find("Usuario",$_SESSION["usuario"]["id"]);
        $favoritoEncontrado=false;
        foreach($tecnico->getUsuarios() as $usuarioActual){
            if($usuarioActual==$usuario){
                $favoritoEncontrado=true;
            }

        }
        $idTecnico=$tecnico->getId();
        
        if($favoritoEncontrado){
            $boton="<button class='btn btn-link'  id='btnFavorito' onclick=tecnicoFavorito($idTecnico,'eliminar')><i class='fa fa-star text-danger' aria-hidden='true'></i></button>";
        }
        else {
            $boton="<button class='btn btn-link' id='btnFavorito' onclick=tecnicoFavorito($idTecnico,'añadir')><i class='fa fa-star-o text-danger' aria-hidden='true'></i></button>";
        }

    }
    else {
        $boton="";
    }
    

    $twitter="";
    $facebook="";
    $instagram="";
    if(!is_null($tecnico->getTwitter())){
        $twitter="<a href='".$tecnico->getTwitter()."' target='_blank'><img src='img/redessociales/twitter.jpg' class='img-fluid mx-1'/></a>";
    }
    if(!is_null($tecnico->getFacebook())){
        $facebook="<a  href='".$tecnico->getFacebook()."' target='_blank'><img src='img/redessociales/facebook.jpg' class='img-fluid mx-1'/></a>";
    }

    if(!is_null($tecnico->getInstagram())){
        $instagram=" <a  href='".$tecnico->getInstagram()."' target='_blank'><img src='img/redessociales/instagram.jpg' class='img-fluid mx-1'/></a>";
    }
    
    if(file_exists("img/tecnicos/".$idTecnico.".jpg")){
        $imagen="<img src='img/tecnicos/".$idTecnico.".jpg' class='img-fluid'/>";
    }
    else {
        $imagen="<img src='img/tecnicos/defecto.jpg' class='img-fluid'/>";
    }


    echo "
    <div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 text-center mt-5'>
                <h1 class='text-secondary mb-1'>Ficha de técnico</h1>
            </div>
    <div class='row px-2 borderEspecial '><div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-5 text-center ' >$imagen</div>
                             <div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 '><div class='row '><div class='col '><h3 class='text-secondary'>".$tecnico->getNombre()." ".$tecnico->getApellido1()." ".$tecnico->getApellido2()." ".$apodo."$boton</h3></div>
                             </div>
                             <div class='row'><div class='col'><h5>".$tecnico->getPuesto()->getPuesto()."</h5></div></div>
                             <div class='row'><div class='col'><h6>Fecha de nacimiento: ".date_format($tecnico->getFechaNacimiento(),"d-m-Y")."</h6></div></div>
                             <div class='row'><div class='col'><h6>Edad: ".$edad."</h6></div></div>
                             <div class='row'><div class='col'><h6>Nacionalidad: ".$tecnico->getPais()->getNacionalidad()."</h6></div></div>
                             <div class='row'><div class='col'><h6>Nivel: ".$tecnico->getTipoContrato()->getTipoContrato()."</h6></div></div>
                             <div class='row'><div class='col'>
                             <div class='btn-group my-1 my-md-0' role='group'>
                    ".$twitter.$facebook.$instagram."
                    
                   
        
                    </div>
                </div></div>
                             
                             </div>
";

    if($equipoActual=="Sin equipo"){
        echo "<div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 justify-content-center'><div class='row'><div class='col'><h2 class='text-danger'>Sin Equipo</h2>
        </div></div></div></div>";
    }
    else {

      echo "<div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 justify-content-center'><div class='row'><div class='col text-center'><h3 class='text-secondary'>Equipo Actual</h3>
                            <div class='row '><div class='col'><img src='img/clubs/".$tecnico->getEquipoActual()->getClub()->getId()."fichas.jpg' class='img-fluid'/></div></div>
                             <div class='row'><div class='col'><a class='text-secondary' href='fichaequipo.php?id=".$tecnico->getEquipoActual()->getId()."'><h5>".$equipoActual."</h5></a></div></div>
                             <div class='row'><div class='col'><a class='text-secondary' href='fichacompeticion.php?id=".$tecnico->getEquipoActual()->getCompeticion()->getId()."'><h6>".$tecnico->getEquipoActual()->getCompeticion()->getNombre()."</h6></a></div></div>
                             </div>
                             </div>
                             </div></div>
                             ";

    }
echo "<div class='row'>";
$estadisticas=cargarEstadisticasTecnico($idTecnico);
echo $estadisticas;
echo "</div>";
}
else {
   cargarPantallaError("jugador");
}

}


function cargarEstadisticasTecnico($idTecnico){

    $estadisticas="";
    $estadisticas=$estadisticas.cargarEstadisticasTecnicoEquipos($idTecnico);

    return $estadisticas;
}



function cargarEstadisticasTecnicoEquipos($idTecnico){
    $entityM=cargar("admin");
    $equiposTecnico=$entityM->getRepository("HistoricoEquipoCuerpoTecnico")->findBy(["cuerpoTecnico"=>$idTecnico]);

    usort($equiposTecnico, fn($a, $b) => strcmp($b->getTemporada()->getTemporada(), $a->getTemporada()->getTemporada()));
    $estadisticas="";
    if(!is_null($equiposTecnico)){
         $estadisticas=$estadisticas."<div class='col-xl-4 col-lg-6 col-md-12 col-sm-12'>
        <div class='row px-2 text-secondary mt-5'>
        <div class='col'><h3>Equipos dirigidos</h3></div></div>
        <table class='table text-center'>
                <thead class='bg-primary' ><tr>
                <th scope='col' class='text-center'>Equipo</th>
                <th scope='col' class='text-center'>Temporada</th>
                </tr></thead><tbody class='border-right border-top border-secondary'>";
        foreach($equiposTecnico as $equipoTecnico){

            if($equipoTecnico->getEquipo()->getTipoEquipo()->getTipo()=="A"){

                $equipo=$equipoTecnico->getEquipo()->getClub()->getNombreCompleto();

            }
            else {
                $equipo=$equipoTecnico->getEquipo()->getClub()->getNombreCompleto()." ".$equipoTecnico->getEquipo()->getTipoEquipo()->getTipo();
            }
            $estadisticas=$estadisticas."
            <tr>
            <td>".$equipoTecnico->getTemporada()->getTemporada()."</td>
            <td><a href='fichaequipo.php?id=".$equipoTecnico->getEquipo()->getId()."' class='text-dark'>".$equipo."</a></td>
            
            </tr>
            ";

        }

        $estadisticas=$estadisticas."</tbody></table></div>";

    }

    return $estadisticas;


}


function cargarDatosEquipo($idEquipo){
    $entityM=cargar("admin");

    $equipo=$entityM->find("Equipo",$idEquipo);
    $jugadores=$entityM->getRepository("Jugador")->findBy(["equipoActual"=>$idEquipo]);
    $puestoEntrenador=$entityM->getRepository("PuestoCuerpoTecnico")->findOneBy(["puesto"=>"Entrenador"]);
    $entrenador=$entityM->getRepository("CuerpoTecnico")->findOneBy(["equipoActual"=>$idEquipo,"puesto"=>$puestoEntrenador->getId()]);
    if(!is_null($equipo)){

        if(file_exists("img/clubs/".$equipo->getClub()->getId().".jpg")){
            $imagen="<img src='img/clubs/".$equipo->getClub()->getId().".jpg' class='img-fluid'/>";
        }
        else {
            $imagen="<img src='img/clubs/defecto.jpg' class='img-fluid'/>";
        }

        if($equipo->getTipoEquipo()->getTipo()=="A"){
            $equipoStr=$equipo->getClub()->getNombreCompleto();
        }
        else {
            $equipoStr=$equipo->getClub()->getNombreCompleto()." ".$equipo->getTipoEquipo()->getTipo();
        }

        $temporadasEquipo=$entityM->getRepository("HistoricoEquipoCompeticion")->findAll();
        usort($temporadasEquipo, fn($a, $b) => strcmp($b->getTemporada()->getTemporada(), $a->getTemporada()->getTemporada()));

        if(isset($_SESSION["usuario"])){
            $usuario=$entityM->find("Usuario",$_SESSION["usuario"]["id"]);
            $favoritoEncontrado=false;
            foreach($equipo->getUsuarios() as $usuarioActual){
                if($usuarioActual==$usuario){
                    $favoritoEncontrado=true;
                }
    
            }
            $idEquipo=$equipo->getId();
            
            if($favoritoEncontrado){
                $boton="<button class='btn btn-link'  id='btnFavorito' onclick=equipoFavorito($idEquipo,'eliminar')><i class='fa fa-star text-danger' aria-hidden='true'></i></button>";
            }
            else {
                $boton="<button class='btn btn-link' id='btnFavorito' onclick=equipoFavorito($idEquipo,'añadir')><i class='fa fa-star-o text-danger' aria-hidden='true'></i></button>";
            }
    
        }
        else {
            $boton="";
        }
       
       echo "
        <div class='row'>
    <div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 text-center mt-5'>
                <h1 class='text-secondary mb-1'>Ficha de equipo</h1>
            </div></div>
    <div class='row px-2 borderEspecial'><div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-5 text-center '><div class='col'>$imagen</div></div>
                             <div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 '><div class='row '><div class='col '><h3 class='text-secondary'>".$equipoStr.$boton."</h3></div></div>
                            <div class='row'><div class='col'><h6>División: <a href='fichacompeticion.php?id=".$equipo->getCompeticion()->getId()."' class='text-dark'>".$equipo->getCompeticion()->getNombre()."</a></h6></div></div>
                             <div class='row'><div class='col'><h6>Jugadores en plantilla: ".count($jugadores)."</h6></div></div>";
                             
                             if(!is_null($entrenador)){
                             echo "<div class='row'><div class='col'><h6>Entrenador: <a href='fichatecnico.php?id=".$entrenador->getId()."' class='text-dark'>".$entrenador->getNombre()." ".$entrenador->getApellido1()."</a></h6></div></div>";
                             }
                             else {
                                echo "<div class='row'><div class='col'><h6>Entrenador: Sin entrenador</h6></div></div>";
                             }
                             echo "<div class='row'><div class='col'><h4><a href='fichaclub.php?id=".$equipo->getClub()->getId()."' class='text-secondary'>Ver club</a></h4></div></div>";
                            
                echo "</div>";
                
                if(count($temporadasEquipo)>0){
                echo "
                <div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 '>
                <div class='row'><div class='col text-secondary text-center'><h3>Últimas temporadas</h3></div></div>
                <div class='table-responsive'>
                <table class='table text-center'>
                <thead class='bg-primary' ><tr>
                <th scope='col' class='text-center'>Temporada</th>
                <th scope='col' class='text-center'>Competición</th>
                <th scope='col' class='text-center'>Puesto</th>
                </tr></thead><tbody class='border-right border-top border-secondary'>";

                
                foreach($temporadasEquipo as $temporadaEquipo){

                    if($temporadaEquipo->getEquipo()->getId()==$idEquipo){

                        $historicoCompeticion=$entityM->getRepository("HistoricoEquipoCompeticion")->findBy(["competicion"=>$temporadaEquipo->getCompeticion()->getId(),"temporada"=>$temporadaEquipo->getTemporada()->getId()]);
                        $contador=1;
                        
                        usort($historicoCompeticion, fn($a, $b) => (2*($a->getGanados())+$a->getEmpatados() < 2*($b->getGanados()+$b->getEmpatados())) ? 1 : (2*($a->getGanados())+$a->getEmpatados() < 2*($b->getGanados()+$b->getEmpatados()) ? -1 : 0));
                        foreach($historicoCompeticion as $historico){
                            if($historico->getEquipo()->getId()==$idEquipo){
                                echo "<tr>
                                <td>".$temporadaEquipo->getTemporada()->getTemporada()."</td>
                                <td><a href='fichacompeticion.php?id=".$temporadaEquipo->getCompeticion()->getId()."' class='text-dark'>".$temporadaEquipo->getCompeticion()->getNombre()."</a></td>
                                <td>".$contador."º</td>
                                </tr>";
                            }
                            $contador++;
                        }

                    }
                    
                }
            
                echo "
                
                </tbody></table></div></div></div>";
                
            }
                 

    $plantilla=cargarPlantilla($jugadores);
    echo $plantilla;
    $cuerpoTecnico=cargarCuerpoTecnico($equipo->getCuerpoTecnico());
    echo $cuerpoTecnico;
   
    }
    else {

        cargarPantallaError("equipo");
    }
}

function cargarCuerpoTecnico($tecnicos){

    $tecnicosStr="";


    $tecnicosStr=$tecnicosStr."<section class='row'>
    <div class='col'>
    <div class='row px-2 text-secondary text-center my-5'>
    <div class='col'><h2>Cuerpo técnico</h2></div></div>
    <div class='table-responsive'>
    <table class='table text-center'>
            <thead class='bg-primary' ><tr>
            <th scope='col' class='text-center'>#</th>
            <th scope='col' class='text-center'>Técnico</th>
            <th scope='col' class='text-center'>Puesto</th>
            <th scope='col' class='text-center'>Edad</th>
            <th scope='col' class='text-center'>Nacionalidad</th>
            <th scope='col' class='text-center'>Nivel</th>
            </tr></thead><tbody class='border-right border-top border-secondary'>";


            foreach($tecnicos as $tecnico){

                if(file_exists("img/tecnicos/".$tecnico->getId()."mini.jpg")){
                    $imagen="<img src='img/tecnicos/".$tecnico->getId()."mini.jpg' class='img-fluid'/>";
                }
                else {
                    $imagen="<img src='img/tecnicos/defectomini.jpg' class='img-fluid'/>";
                }
                $edad = DateTime::createFromFormat('Y-m-d', date_format($tecnico->getFechaNacimiento(),"Y-m-d"))
                ->diff(new DateTime('now'))
                ->y;
                $tecnicosStr=$tecnicosStr."
                
                <tr>
                <td>$imagen</td>
                <td><a href='fichatecnico.php?id=".$tecnico->getId()."' class='text-dark'>".$tecnico->getNombre()." ".$tecnico->getApellido1()." ".$tecnico->getApellido2()."</a></td>
                <td>".$tecnico->getPuesto()->getPuesto()."</td>
                <td>$edad</td>
                <td>".$tecnico->getPais()->getNacionalidad()."</td>
                <td>".$tecnico->getTipoContrato()->getTipoContrato()."</td>
                </tr>";
            }


            $tecnicosStr=$tecnicosStr. "</tbody></table></div></div></section></div>";    
    return $tecnicosStr;
}




function cargarPlantilla($jugadores){

$plantillaStr="";

$plantillaStr=$plantillaStr."
<section class='row borderEspecial'>
<div class='col'>
<div class='row px-2 text-secondary text-center my-5'>
<div class='col'><h2>Plantilla</h2></div></div>
<div class='table-responsive'>
<table class='table text-center'>
        <thead class='bg-primary' ><tr>
        <th scope='col' class='text-center'>#</th>
        <th scope='col' class='text-center'>Jugador</th>
        <th scope='col' class='text-center'>Posición</th>
        <th scope='col' class='text-center'>Edad</th>
        <th scope='col' class='text-center'>Nacionalidad</th>
        <th scope='col' class='text-center'>Nivel</th>
        </tr></thead><tbody class='border-right border-top border-secondary'>";


        foreach($jugadores as $jugador){

            foreach($jugador->getPuestos() as $puesto){

                if($jugador->getPuestos()[0]==$puesto){
                    $puestos=$puesto->getPuesto();
                }else {
        
                   $puestos=$puestos."/".$puesto->getPuesto();
                }
            }

            if(file_exists("img/jugadores/".$jugador->getId()."mini.jpg")){
                $imagen="<img src='img/jugadores/".$jugador->getId()."mini.jpg' class='img-fluid'/>";
            }
            else {
                $imagen="<img src='img/jugadores/defectomini.jpg' class='img-fluid'/>";
            }

            $edad = DateTime::createFromFormat('Y-m-d', date_format($jugador->getFechaNacimiento(),"Y-m-d"))
            ->diff(new DateTime('now'))
            ->y;

            $plantillaStr=$plantillaStr."
            <tr>
            <td><img src='img/jugadores/".$jugador->getId()."mini.jpg'/></td>
            <td><a href='fichajugador.php?id=".$jugador->getId()."' class='text-dark'>".$jugador->getNombre()." ".$jugador->getApellido1()." ".$jugador->getApellido2()."</a></td>
            <td>$puestos</td>
            <td>$edad</td>
            <td>".$jugador->getPais()->getNacionalidad()."</td>
            <td>".$jugador->getTipoContrato()->getTipoContrato()."</td>
            </tr>
            ";


        }

        $plantillaStr=$plantillaStr. "</tbody></table></div></div></section>";
return $plantillaStr;

}

function cargarEquiposSinEntrenador(){
    $entityM=cargar("admin");
   
    $equipos=$entityM->getRepository("Equipo")->findAll();
    $equiposSinEntrenador=[];
    if(!is_null($equipos)){

        foreach($equipos as $equipo){
            $entrenadorEncontrado=false;
            foreach($equipo->getCuerpoTecnico() as $tecnico){

                if($tecnico->getPuesto()->getPuesto()=="Entrenador"){
                    $entrenadorEncontrado=true;
                }

            }

            if($entrenadorEncontrado==false){
                array_push($equiposSinEntrenador,$equipo);
            }
        }
    }


    usort($equiposSinEntrenador, fn($a, $b) => strcmp(date_format($b->getFechaSinEntrenador(),"Y-m-d"), date_format($a->getFechaSinEntrenador(),"Y-m-d")));
    $equiposSinEntrenador = array_slice($equiposSinEntrenador, 0, 9);

    echo "<div class='table-responsive'>
    <table class='table text-center border-top border-secondary border-right'>
            <thead class='bg-primary border-secondary border-left' ><tr>
            <th scope='col' class='text-center'>#</th>
            <th scope='col' class='text-center'>Equipo</th>
            <th scope='col' class='text-center'>País</th>
            <th scope='col' class='text-center'>Género</th>
            </tr></thead><tbody class='border-right border-top border-secondary'>";

    foreach($equiposSinEntrenador as $equipoSinEntrenador){
        
        if(file_exists("img/clubs/".$equipoSinEntrenador->getClub()->getId()."mini.jpg")){
            $imagen="<img src='img/clubs/".$equipoSinEntrenador->getClub()->getId()."mini.jpg' class='img-fluid'/>";
        }
        else {
            $imagen="<img src='img/clubs/defectomini.jpg' class='img-fluid'/>";
        }
        if($equipoSinEntrenador->getTipoEquipo()->getTipo()=="A"){
            $equipo=$equipoSinEntrenador->getClub()->getNombreCompleto();
        }
        else {
            $equipo=$equipoSinEntrenador->getClub()->getNombreCompleto()." ".$equipoSinEntrenador->getTipoEquipo()->getTipo();
        }


        echo "<tr>
        <td>$imagen</td>
        <td><a href='fichaequipo.php?id=".$equipoSinEntrenador->getId()."' class='text-dark'>$equipo</a></td>
        <td>".$equipoSinEntrenador->getClub()->getPais()->getNombre()."</td>
        <td>".$equipoSinEntrenador->getGenero()."</td>
        </tr>";
    }


    echo "</tbody></table></div>";
}

function cargarDatosClub($idClub){
    $entityM=cargar("admin");
    $club=$entityM->find("Club",$idClub);
    $equipos=$entityM->getRepository("Equipo")->findBy(["club"=>$club->getId()]);
    $jugadores=0;

    foreach($equipos as $equipo){
        $jugadores+=count($equipo->getJugadores());
    }

    if(!is_null($club)){

        if(file_exists("img/clubs/".$club->getId().".jpg")){
            $imagen="<img src='img/clubs/".$club->getId().".jpg' class='img-fluid'/>";
        }
        else {
            $imagen="<img src='img/clubs/defecto.jpg' class='img-fluid'/>";
        }

        echo "
    <div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 text-center mt-5'>
                <h1 class='text-secondary mb-1'>Ficha de club</h1>
            </div>
    <div class='row px-2 borderEspecial'><div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-5 text-center '><div class='col'>$imagen</div></div>
                             <div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 '><div class='row '><div class='col '><h3 class='text-secondary'>".$club->getNombreCompleto()."</h3></div></div>
                             <div class='row'><div class='col'><h6>Fundación: ".$club->getFundacion()."</h6></div></div>
                             <div class='row'><div class='col'><h6>Número de equipos: ".count($equipos)."</h6></div></div>
                             <div class='row'><div class='col'><h6>Número de jugadores: $jugadores</h6></div></div>
                             "
                             ;
                             
                             
                   
                echo "</div>";
                echo "<div class='col-xl-4 col-lg-4 col-md-12 col-sm-12 text-center'>
                <h1 class='text-secondary'>Equipos</h1>
                <div class='row justify-content-center'>
    <div class='table-responsive'>
    <table class='table'>
    <thead class='bg-primary'>
    <tr>
    <th>Equipo</th>
    <th>Competición</th>
    </tr>
    </thead><tbody class='border-top border-right border-secondary'>";
                
      foreach($equipos as $equipo){

        if($equipo->getTipoEquipo()->getTipo()=="A"){
            $tipoEquipo="";
        }
        else {
            $tipoEquipo=$equipo->getTipoEquipo()->getTipo();
        }
        echo "<tr>
        <td><a href='fichaequipo.php?id=".$equipo->getId()."' class='text-dark'>".$club->getNombreCompleto()." ".$tipoEquipo."</a></td>
        <td><a href='fichacompeticion.php?id=".$equipo->getCompeticion()->getId()."' class='text-dark'>".$equipo->getCompeticion()->getNombre()."</a></td>
        </tr>";
      }      

     echo "</tbody></table></div></div></div></div>";         


    }
    else {
        header("Location:index.php");
    }
}

function cargarDatosCompeticion($idCompeticion){

$entityM=cargar("admin");

$competicion=$entityM->find("Competicion",$idCompeticion);
$ultimaTemporada=$entityM->getRepository("Temporada")->findAll();
usort($ultimaTemporada, fn($a, $b) => strcmp($b->getTemporada(), $a->getTemporada()));
$ultimaTemporada = $ultimaTemporada[0];
$historicoCompeticion=$entityM->getRepository("HistoricoEquipoCompeticion")->findBy(["competicion"=>$idCompeticion,"temporada"=>$ultimaTemporada]);



if(!is_null($competicion)){

    echo "<div class='row text-center mt-5 borderEspecial'>
    <div class='col'>
    <h1 class='text-secondary'>".$competicion->getNombre()."</h1>
    <div class='row justify-content-center'>
    <div class='col-xl-6 col-lg-6 col-md-12 col-sm-12'><h2>Clasificación</h2>
    
    <div class='table-responsive'>
    <table class='table'>
    <thead class='bg-primary'>
    <tr>
    <th>Puesto</th>
    <th>Equipo</th>
    <th>Jugados</th>
    <th>Ganados</th>
    <th>Empatados</th>
    <th>Perdidos</th>
    <th>Puntos</th>
    </tr>
    </thead><tbody class='border-top border-right border-secondary'>";

    $contador=1;
    usort($historicoCompeticion, fn($a, $b) => (2*($a->getGanados())+$a->getEmpatados() < 2*($b->getGanados()+$b->getEmpatados())) ? 1 : (2*($a->getGanados())+$a->getEmpatados() < 2*($b->getGanados()+$b->getEmpatados()) ? -1 : 0));
    foreach($historicoCompeticion as $historico){
        $jugados=$historico->getGanados()+$historico->getEmpatados()+$historico->getPerdidos();
        $puntos=2*($historico->getGanados())+$historico->getEmpatados();

        if($historico->getEquipo()->getTipoEquipo()->getTipo()=="A"){
            $equipo=$historico->getEquipo()->getClub()->getNombreCompleto();
        }
        else {
            $equipo=$historico->getEquipo()->getClub()->getNombreCompleto()." ".$historico->getEquipo()->getTipoEquipo()->getTipo();
        }

        echo "<tr>
        <td>$contador</td>
        <td><a href='fichaequipo.php?id=".$historico->getEquipo()->getId()."' class='text-dark'>$equipo</a></td>
        <td>$jugados</td>
        <td>".$historico->getGanados()."</td>
        <td>".$historico->getEmpatados()."</td>
        <td>".$historico->getPerdidos()."</td>
        <td>$puntos</td>
        </tr>";
        $contador++;
    }

  $temporadas=$entityM->getRepository("Temporada")->findAll();
  usort($temporadas, fn($b, $a) => strcmp($a->getTemporada(), $b->getTemporada()));
  
   echo "</tbody>
    </table>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    <div class='row mt-5 justify-content-center text-center '>
    <div class='col-xl-8 col-lg-8 col-md-12 col-sm-12'>
    <h1 class='text-secondary'>Histórico de competicion</h1>
    
    <div class='table-responsive'>
    <table class='table'>
    <thead class='bg-primary'>
    <tr>
    <th>Temporada</th>
    <th>1º</th>
    <th>2º</th>
    <th>3º</th>
    <th>4º</th>
    <th>5º</th>
    <th>6º</th>
    </tr>
    </thead><tbody class='border-top border-right border-secondary'>";
   
        echo "</tr>";
    
        foreach($temporadas as $temporada){
            $historicoTemporadas=$entityM->getRepository("HistoricoEquipoCompeticion")->findBy(["competicion"=>$idCompeticion,"temporada"=>$temporada->getId()]);
            usort($historicoCompeticion, fn($a, $b) => (2*($a->getGanados())+$a->getEmpatados() < 2*($b->getGanados()+$b->getEmpatados())) ? 1 : (2*($a->getGanados())+$a->getEmpatados() < 2*($b->getGanados()+$b->getEmpatados()) ? -1 : 0));
            echo "<tr><td>".$temporada->getTemporada()."</td>";
            $historicoTemporadas = array_slice($historicoTemporadas, 0, 5);
            foreach($historicoTemporadas as $historico){

                if($historico->getEquipo()->getTipoEquipo()->getTipo()=="A"){
                    $equipo=$historico->getEquipo()->getClub()->getNombreCompleto();
                }
                else {
                    $equipo=$historico->getEquipo()->getClub()->getNombreCompleto()." ".$historico->getEquipo()->getTipoEquipo()->getTipo();
                }
               
                echo "<td><a href='fichaequipo.php?id=".$historico->getEquipo()->getId()."' class='text-dark'>$equipo</a></td>";
            }
            echo "</tr>";
        }
    
        
    

    echo "</tbody></table></div></div>
    </div>
    
    ";
}
else {
    header("Location:index.php");
}

}

function cargarInputsHidden(){
    $entityM=cargar("admin");
    $continentes=$entityM->getRepository("Continente")->findAll();
    foreach($continentes as $continente){
        echo "<input name='".$continente->getNombre()."' type='hidden'>";
    }

    $niveles=$entityM->getRepository("TipoContrato")->findAll();
    foreach($niveles as $nivel){
        echo "<input type='hidden' name='".$nivel->getTipoContrato()."'>";
    }
}

function cargarInputsHiddenTecnicos(){
    $entityM=cargar("admin");
    $paises=$entityM->getRepository("Pais")->findAll();
    foreach($paises as $pais){
        echo "<input name='".$pais->getNombre()."' type='hidden'>";
    }

    $puestos=$entityM->getRepository("PuestoCuerpoTecnico")->findAll();

    foreach($puestos as $puesto){
        echo "<input name='".$puesto->getPuesto()."' type='hidden'>";
    }
}


function cargarEquiposSinEntrenadorGrande($genero){
    $entityM=cargar("admin");

    $equipos=$entityM->getRepository("Equipo")->findBy(["genero"=>$genero]);
    $equiposSinEntrenador=[];
    foreach($equipos as $equipo){
        $entrenadorEncontrado=false;
        foreach($equipo->getCuerpoTecnico() as $tecnico){
            if($tecnico->getPuesto()->getPuesto()=="Entrenador"){
                $entrenadorEncontrado=true;
            }
        }

        if($entrenadorEncontrado==false){
            array_push($equiposSinEntrenador,$equipo);
        }
    }


    echo "<div class='table-responsive'>
    <table class='table'>
    <thead class='bg-primary'>
    <tr>
    <th>#</th>
    <th>Equipo</th>
    <th>País</th>
    <th>Competición</th>
    </tr>
    </thead><tbody class='border-top border-right border-secondary'>";

    usort($equiposSinEntrenador, fn($a, $b) => strcmp(date_format($b->getFechaSinEntrenador(),"Y-m-d"),date_format($a->getFechaSinEntrenador(),"Y-m-d")));
    foreach($equiposSinEntrenador as $equipo){

        if($equipo->getTipoEquipo()->getTipo()=="A"){
            $equipoStr=$equipo->getClub()->getNombreCompleto();
        }
        else {
            $equipoStr=$equipo->getClub()->getNombreCompleto()." ".$equipo->getTipoEquipo()->getTipo();
        }

        if(file_exists("img/clubs/".$equipo->getClub()->getId()."mini.jpg")){
            $imagen="<img src='img/clubs/".$equipo->getClub()->getId()."mini.jpg' class='img-fluid'/>";
        }
        else {
            $imagen="<img src='img/clubs/defectomini.jpg' class='img-fluid'/>";
        }



        echo "<tr>
        <td>$imagen</td>
        <td><a href='fichaequipo.php?id=".$equipo->getId()."' class='text-dark'>$equipoStr</a></td>
        <td>".$equipo->getClub()->getPais()->getNombre()."</td>
        <td><a href='fichacompeticion.php?id=".$equipo->getCompeticion()->getId()."' class='text-dark'>".$equipo->getCompeticion()->getNombre()."</a></td>
        </tr>";
    }

    echo "</tbody></table></div>";

}


function registrarUsuario(){
    $entityM=cargar("admin");
    $email = filter_input(INPUT_POST,"email");
    $contraseña=filter_input(INPUT_POST,"contraseña1");
    $nombre=filter_input(INPUT_POST,"nombre");
    $apellido1=filter_input(INPUT_POST,"apellido1");
    
    $usuarioExistente=$entityM->getRepository("Usuario")->findOneBy(["email"=>$email]);

    $tipoUsuario=$entityM->getRepository("TipoUsuario")->findOneBy(["tipoUsuario"=>"registrado"]);
    $contraseña=password_hash($contraseña,PASSWORD_DEFAULT);

    $confirmacion=randomURL(20);
    if(is_null($usuarioExistente)){
        $usuario=new Usuario($email,$contraseña,$tipoUsuario,$confirmacion,$nombre,$apellido1);

        if($apellido2=filter_input(INPUT_POST,"apellido2")){
            $usuario->setApellido2($apellido2);
        }
        $entityM->persist($usuario);
        $entityM->flush();
        enviarEmailConfirmacion($usuario);
        return true;
    }
    else {
        return false;
    }
    


    
}

function enviarEmailConfirmacion($usuario){
    $mail=new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug=0;
    $mail->SMTPAuth=true;
    $mail->SMTPSecure="tls";
    $mail->Host="smtp.gmail.com";
    $mail->Port=587;
    $mail->CharSet='UTF-8';
    $mail->Username="phptestiesteis@gmail.com"; 
    $mail->Password="duhfjyzcmfvxdnnt"; 
    $mail->setFrom("phptestiesteis@gmail.com");
    $mail->Subject=ucfirst("Confirma tu cuenta");
    $mail->isHTML(true);
    $confirmacion=$usuario->getConfirmacion();
    $mail->Body='Haz click en el siguiente enlace para activar tu cuenta: <a href="http://192.168.0.11/www/confirmacion.php?id='.$confirmacion.'">Confirma tu cuenta</a>';
    $mail->addAddress($usuario->getEmail());
    if($mail->send()){
       
        return true;
    }

    return false;
    
}


function randomURL($URLlength = 8) {
    $charray = array_merge(range('a','z'), range('0','9'));
    $max = count($charray) - 1;
    $url="";
    for ($i = 0; $i < $URLlength; $i++) {
        $randomChar = mt_rand(0, $max);
        $url .= $charray[$randomChar];
    }
    return $url;
}


function confirmarCuenta(){
    $entityM=cargar("admin");
    $usuario=$entityM->getRepository("Usuario")->findOneBy(["confirmacion"=>$_GET["id"]]);

    if(!is_null($usuario)){
        $usuario->setEstado('C');
        $entityM->flush();

        return true;
    }
    else {
        return false;
    }
}

function comprobarUsuario(){
    $entityM=cargar("admin");

    $usuario=$entityM->getRepository("Usuario")->findOneBy(["email"=>filter_input(INPUT_POST,"email")]);
    $contraseña=filter_input(INPUT_POST,"contraseña");
    if(!is_null($usuario)){
        
        if(password_verify($contraseña,$usuario->getContraseña())){
            if($usuario->getEstado()=="C"){
                session_start();
                $datosUsuario=[
                    "id"=>$usuario->getId(),
                    "email"=>$usuario->getEmail(),
                    "tipoUsuario"=>$usuario->getTipoUsuario()->getTipoUsuario(),
                    "nombre"=>$usuario->getNombre(),
                    "apellido1"=>$usuario->getApellido1(),
                    "apellido2"=>$usuario->getApellido2(),
                    "caducidad"=>$usuario->getCaducidadSuscripcion()
                ];
    
                $_SESSION["usuario"]=$datosUsuario;
                return "sesionI";
            }
            else if($usuario->getEstado()=="D"){
                return "D";
            }
            else {
                return "NC";
            }
            
        }
    }
    return false;
}

function cargarNoticiasUsuario(){
    $entityM=cargar("admin");
    $noticias=$entityM->getRepository("Noticia")->findBy(["autor"=>$_SESSION["usuario"]["id"]]);
    usort($noticias, fn($b, $a) => strcmp(date_format($a->getFecha(),"d-m-Y"), date_format($b->getFecha(),"d-m-Y")));
    echo "<div class='table-responsive'>
    <table class='table'>
    <thead class='bg-primary'>
    <tr>
    <th class='text-center'>Noticia completa</th>
    <th>Titular</th>
    <th class='text-center'>Fecha</th>
    <th class='text-center'>Acción</th>
    </tr>
    </thead><tbody class='border-top border-right border-secondary'>";


    foreach($noticias as $noticia){
        echo "<tr>
        <td class='text-center'><a href='noticiacompleta.php?id=".$noticia->getId()."' class='text-secondary'>Ver</a></td>
        <td>".$noticia->getTitular()."</td>
        <td class='text-center'>".date_format($noticia->getFecha(),"d-m-Y")."</td>
        <td class='text-center'>
        <form action='publicarnoticia.php' method='POST'><button class='fa fa-edit'></button><input type='hidden' name='noticia' value='".$noticia->getId()."'></form>
        <form action='borrar.php' class='text-secondary' method='POST'><button class='fa fa-trash'></button>
        <input type='hidden' name='noticia' value='".$noticia->getId()."'></form></td>
        </tr>";
    }

    echo "</tbody></table></div>";

    
}

function publicarNoticia(){
    $entityM=cargar("admin");

    if(isset($_POST["editada"])){
       $noticiaEditada=$entityM->find("Noticia",$_POST["editada"]);
       $titular=ucfirst(filter_input(INPUT_POST,"titular"));
       $noticia=ucfirst(filter_input(INPUT_POST,"noticia"));
       $pieFoto=ucfirst(filter_input(INPUT_POST,"piefoto"));
       $competicion=$entityM->find("Competicion",filter_input(INPUT_POST,"selectCompeticiones"));
       $noticiaEditada->setTitular($titular);
       $noticiaEditada->setNoticia($noticia);
       $noticiaEditada->setCompeticion($competicion);
       $noticiaEditada->setDescripcionImagen($pieFoto);
       $entityM->flush();
    }
    else {
        $autor=$entityM->find("Usuario",$_SESSION["usuario"]["id"]);
    $fecha=date("Y-m-d");
    $titular=ucfirst(filter_input(INPUT_POST,"titular"));
    $noticia=ucfirst(filter_input(INPUT_POST,"noticia"));
    
    
    $competicion=$entityM->find("Competicion",filter_input(INPUT_POST,"selectCompeticiones"));
    $nuevaNoticia=new Noticia($titular,$noticia,$competicion,$autor,new Datetime($fecha));
    $pieFoto=ucfirst(filter_input(INPUT_POST,"piefoto"));
    $noticiaEditada->setDescripcionImagen($pieFoto);
    $entityM->persist($nuevaNoticia);
    $entityM->flush();


    $imagen = $nuevaNoticia->getId().".jpg";
    
    $tmp=$_FILES["imagen"];
    $destino = "img/noticias/$imagen";
    move_uploaded_file($tmp["tmp_name"], $destino);
    }
    
    
}

function cargarCompeticiones($competicionId=null){
    $entityM=cargar("admin");
    $competiciones=$entityM->getRepository("Competicion")->findAll();
    foreach($competiciones as $competicion){
        
            if($competicionId==$competicion->getId()){
                echo "<option value='".$competicion->getId()."' selected>".$competicion->getNombre()."</option>";
            }
        
        else {
            echo "<option value='".$competicion->getId()."'>".$competicion->getNombre()."</option>";
        }
        
    }
}

function borrarNoticia(){
    $entityM=cargar("admin");
    $noticia=$entityM->find("Noticia", $_POST["noticia"]);
    
    $entityM->remove($noticia);
    $entityM->flush();
}

function cargarDatosNoticia(){
    $entityM=cargar("admin");
    $noticia=$entityM->find("Noticia", $_POST["noticia"]);
    return $noticia;
}

function desactivarPerfil(){
    $entityM=cargar("admin");
    $usuario=$entityM->find("Usuario",$_SESSION["usuario"]["id"]);
    $usuario->setEstado("D");
    $entityM->flush();
}

function reenviarEmail(){
    $entityM=cargar("admin");
    $usuario=$entityM->getRepository("Usuario")->findOneBy(["email"=>filter_input(INPUT_POST,"emailreenvio")]);

    if(!is_null($usuario)){
        if($usuario->getEstado=="NC"){
            enviarEmailConfirmacion($usuario);
        }
        
    }
}

function modificarPerfil(){
    $entityM=cargar("admin");
    $usuario=$entityM->find("Usuario",$_SESSION["usuario"]["id"]);
    $nombre=filter_input(INPUT_POST,"nombre");
    $apellido1=filter_input(INPUT_POST,"apellido1");
    if(isset($_POST["apellido2"])){
        $apellido2=filter_input(INPUT_POST,"apellido2");
        $usuario->setApellido2($apellido2);
        $_SESSION["usuario"]["apellido2"]=$apellido2;
    }
    $usuario->setNombre($nombre);
    $usuario->setApellido1($apellido1);

    $_SESSION["usuario"]["nombre"]=$nombre;
    $_SESSION["usuario"]["apellido1"]=$apellido1;
    $entityM->flush();
    
}


function cargarJugadoresFavoritos(){
    $entityM=cargar("admin");
    $usuario=$entityM->find("Usuario",$_SESSION["usuario"]["id"]);
    $jugadores=$usuario->getJugadoresFavoritos();
    echo "<div class='table-responsive'>
    <table class='table'>
    <thead class='bg-primary'>
    <tr>
    <th class='text-center'>#</th>
    <th>Jugador</th>
    <th>Puesto</th>
    <th>Edad</th>
    <th>Nacionalidad</th>
    <th>Género</th>
    <th>Equipo</th>
    <th>Nivel</th>
    </tr>
    </thead><tbody class='border-top border-right border-secondary'>";
    $jugadores=iterator_to_array($jugadores);
    usort($jugadores, fn($a, $b) => ($a->getReputacion() < $b->getReputacion()) ? 1 : (($a->getReputacion() > $b->getReputacion()) ? -1 : 0));
    foreach($jugadores as $jugador){

        if(file_exists("img/jugadores/".$jugador->getId()."mini.jpg")){
            $imagen="<img src='img/jugadores/".$jugador->getId()."mini.jpg' class='img-fluid'/>";
        }
        else {
            $imagen="<img src='img/jugadores/defectomini.jpg' class='img-fluid'/>";
        }

        if($jugador->getGenero()=="M"){
            $genero="Masculino";
        }
        else {
            $genero="Femenino";
        }

        $edad = DateTime::createFromFormat('Y-m-d', date_format($jugador->getFechaNacimiento(),"Y-m-d"))
        ->diff(new DateTime('now'))
        ->y;

        if(!is_null($jugador->getEquipoActual())){
            
            if($jugador->getEquipoActual()->getTipoEquipo()->getTipo()=="A"){
                $equipo="<a href='fichaequipo.php?id=".$jugador->getEquipoActual()->getId()."' class='text-dark'>".$jugador->getEquipoActual()->getClub()->getNombreCompleto()." </a>";
            }
            else {
                $equipo="<a href='fichaequipo.php?id=".$jugador->getEquipoActual()->getId()."' class='text-dark'>".$jugador->getEquipoActual()->getClub()->getNombreCompleto()." ".$jugador->getEquipoActual()->getTipoEquipo()->getTipo()." </a>";
            }
        }
        else {
            $equipo="Sin equipo";
        }
        
        foreach($jugador->getPuestos() as $puesto){

            if($puesto==$jugador->getPuestos()[0]){
                $puestosStr=$puesto->getPuestoCorto();
            }
            else {
                $puestosStr=$puestosStr."/".$puesto->getPuestoCorto();
            }
        }
        echo "<tr>
        <td>$imagen</td>
        <td><a href='fichajugador.php?id=".$jugador->getId()."' class='text-dark'>".$jugador->getNombre()." ".$jugador->getApellido1()." ".$jugador->getApellido2()."</a></td>
        <td>$puestosStr</td>
        <td>$edad</td>
        <td>".$jugador->getPais()->getNacionalidad()."</td>
        <td>$genero</td>
        <td>$equipo</td>
        <td>".$jugador->getTipoContrato()->getTipoContrato()."</td>
        </tr>";

    }

    echo "</tbody></table></div>";
}

function cargarTecnicosFavoritos(){
    $entityM=cargar("admin");
    $usuario=$entityM->find("Usuario",$_SESSION["usuario"]["id"]);
    $tecnicos=$usuario->getTecnicosFavoritos();

    $tecnicos=iterator_to_array($tecnicos);
    usort($tecnicos, fn($a, $b) => ($a->getReputacion() < $b->getReputacion()) ? 1 : (($a->getReputacion() > $b->getReputacion()) ? -1 : 0));
        
        echo "<div class='table-responsive'>
        <table class='table text-center border-secondary'>
                <thead class='bg-primary'>
                <th>#</th>
                <th>Técnico</th>
                <th>Trabajo</th>
                <th>Edad</th>
                <th>Nacionalidad</th>
                <th>Género</th>
                <th>Equipo</th>
                <th>Nivel</th>
                </thead><tbody class='border-top border-right border-secondary'>";

            foreach($tecnicos as $tecnico){

                if(file_exists("img/tecnicos/".$tecnico->getId()."mini.jpg")){
                    $imagen="<img src='img/tecnicos/".$tecnico->getId()."mini.jpg' class='img-fluid'/>";
                }
                else {
                    $imagen="<img src='img/tecnicos/defectomini.jpg' class='img-fluid'/>";
                }

                if($tecnico->getGenero()=="M"){
                    $genero="Masculino";
                }
                else {
                    $genero="Femenino";
                }

                $edad = DateTime::createFromFormat('Y-m-d', date_format($tecnico->getFechaNacimiento(),"Y-m-d"))
                ->diff(new DateTime('now'))
                ->y;

                if(!is_null($tecnico->getEquipoActual())){
                    
                    if($tecnico->getEquipoActual()->getTipoEquipo()->getTipo()=="A"){
                        $equipo="<a href='fichaequipo.php?id=".$tecnico->getEquipoActual()->getId()."' class='text-dark'>".$tecnico->getEquipoActual()->getClub()->getNombreCompleto()." </a>";
                    }
                    else {
                        $equipo="<a href='fichaequipo.php?id=".$tecnico->getEquipoActual()->getId()."' class='text-dark'>".$tecnico->getEquipoActual()->getClub()->getNombreCompleto()." ".$tecnico->getEquipoActual()->getTipoEquipo()->getTipo()." </a>";
                    }
                }
                else {
                    $equipo="Sin equipo";
                }

                echo "<tr>
                <td>$imagen</td>
                <td><a href='fichatecnico.php?id=".$tecnico->getId()."' class='text-dark'>".$tecnico->getNombre()." ".$tecnico->getApellido1()." ".$tecnico->getApellido2()."</a></td>
                <td>".$tecnico->getPuesto()->getPuesto()."</td>
                <td>$edad</td>
                <td>".$tecnico->getPais()->getNacionalidad()."</td>
                <td>$genero</td>
                <td>$equipo</td>
                <td>".$tecnico->getTipoContrato()->getTipoContrato()."</td>
                </tr>";
            }
    echo "</tbody></table></div>";

}


function cargarEquiposFavoritos(){
    $entityM=cargar("admin");
    $usuario=$entityM->find("Usuario",$_SESSION["usuario"]["id"]);
    $equipos=$usuario->getEquiposFavoritos();

    $equipos=iterator_to_array($equipos);
    usort($equipos, fn($a, $b) => ($a->getReputacion() < $b->getReputacion()) ? 1 : (($a->getReputacion() > $b->getReputacion()) ? -1 : 0));

    echo "<div class='table-responsive'>
    <table class='table text-center border-top border-secondary border-right'>
            <thead class='bg-primary'>
            <th>#</th>
            <th>Equipo</th>
            <th>País</th>
            <th>Género</th>
            <th>Entrenador</th>
            <th>Competición</th>
            </thead><tbody class='border-top border-right border-secondary'>";
    foreach($equipos as $equipo){


        if($equipo->getTipoEquipo()->getTipo()=="A"){
            $equipoStr=$equipo->getClub()->getNombreCompleto();
        }
        else {
            $equipoStr=$equipo->getClub()->getNombreCompleto()." ".$equipo->getTipoEquipo()->getTipo();
        }

        if($equipo->getGenero()=="M"){
            $genero="Masculino";
        }
        else {
            $genero="Femenino";
        }
        $entrenadorEncontrado=false;
        foreach($equipo->getCuerpoTecnico() as $tecnico){

            if($tecnico->getPuesto()->getPuesto()=="Entrenador"){
                $entrenadorEncontrado=true;
                $entrenador=$tecnico;
            }
        }

        if($entrenadorEncontrado){
            if(!is_null($entrenador->getApodo())){
                $entrenador="<a href='fichatecnico.php?id=".$entrenador->getId()."' class='text-dark'>".$entrenador->getApodo()."</a>";
            }
            else {
                $entrenador="<a href='fichatecnico.php?id=".$entrenador->getId()."' class='text-dark'>".$entrenador->getNombre()." ".$entrenador->getApellido1()."</a>";
            }
            
        }
        else {
            $entrenador="Sin entrenador";
        }

        echo "<tr>
        <td><img src='img/clubs/".$equipo->getClub()->getId()."mini.jpg'/></td>
        <td><a href='fichaequipo.php?id=".$equipo->getId()."' class='text-dark'>$equipoStr</a></td>
        <td>".$equipo->getClub()->getPais()->getNombre()."</td>
        <td>$genero</td>
        <td>$entrenador</td>
        <td><a href='fichacompeticion.php?id=".$equipo->getCompeticion()->getId()."' class='text-dark'>".$equipo->getCompeticion()->getNombre()."</a></td>
        </tr>";
    }

    echo "</tbody></table></div>";

}


function añadirFavorito($id,$tipoFavorito){
    $entityM=cargar("admin");
    
    $usuario=$entityM->find("Usuario",$_SESSION["usuario"]["id"]);
    if($tipoFavorito=="jugador"){
        $jugador=$entityM->find("Jugador",$id);
       
        $jugador->getUsuarios()->add($usuario);
        $usuario->getJugadoresFavoritos()->add($jugador);
        $entityM->persist($jugador);
        $entityM->persist($usuario);
        $entityM->flush();
    }

    else if($tipoFavorito=="tecnico"){
        $tecnico=$entityM->find("CuerpoTecnico",$id);
       
        $tecnico->getUsuarios()->add($usuario);
        $usuario->getTecnicosFavoritos()->add($tecnico);
        $entityM->persist($tecnico);
        $entityM->persist($usuario);
        $entityM->flush();
    }
    else if($tipoFavorito=="equipo"){
        $equipo=$entityM->find("Equipo",$id);
       
        $equipo->getUsuarios()->add($usuario);
        $usuario->getEquiposFavoritos()->add($equipo);
        $entityM->persist($equipo);
        $entityM->persist($usuario);
        $entityM->flush();
    }


}

function eliminarFavorito($id,$tipoFavorito){
    $entityM=cargar("admin");
    
    $usuario=$entityM->find("Usuario",$_SESSION["usuario"]["id"]);
    if($tipoFavorito=="jugador"){
        $jugador=$entityM->find("Jugador",$id);
       
        $jugador->getUsuarios()->removeElement($usuario);
        $usuario->getJugadoresFavoritos()->removeElement($jugador);
        $entityM->persist($jugador);
        $entityM->persist($usuario);
        $entityM->flush();
    }
    else if($tipoFavorito=="tecnico"){
        $tecnico=$entityM->find("CuerpoTecnico",$id);
       
        $tecnico->getUsuarios()->removeElement($usuario);
        $usuario->getTecnicosFavoritos()->removeElement($tecnico);
        $entityM->persist($tecnico);
        $entityM->persist($usuario);
        $entityM->flush();
    }
    else if($tipoFavorito=="equipo"){
        $equipo=$entityM->find("Equipo",$id);
       
        $equipo->getUsuarios()->removeElement($usuario);
        $usuario->getEquiposFavoritos()->removeElement($equipo);
        $entityM->persist($equipo);
        $entityM->persist($usuario);
        $entityM->flush();
    }
}

function cargarUsuarios(){
    $entityM=cargar("admin");
    $usuarios=$entityM->getRepository("Usuario")->findAll();
    //usort($usuarios, fn($b, $a) => strcmp($b->getApellido1(), $a->getApellido1()));


    usort($usuarios, function($a, $b) {
        if ($a->getApellido1() == $b->getApellido1()) {
            if ($a->getApellido2() == $b->getApellido2()) {
                return $a->getNombre() < $b->getNombre() ? -1 : 1;
            } else {
                return 0;
            }
            return $a->getApellido2() < $b->getApellido2() ? -1 : 1;
        }
        return $a->getApellido1() < $b->getApellido1() ? -1 : 1;
    });


    $tiposUsuario=$entityM->getRepository("TipoUsuario")->findAll();
    $usuarioActual=$entityM->find("Usuario",$_SESSION["usuario"]["id"]);
    echo "<div class='table-responsive'>
    <table class='table text-center border-top border-secondary border-right'>
            <thead class='bg-primary'>
            <th>Nombre completo</th>
            <th>Email</th>
            <th>Estado</th>
            <th>Tipo de usuario</th>
            </thead><tbody class='border-top border-right border-secondary'>";


    foreach($usuarios as $usuario){
        if($usuario!=$usuarioActual){
        if($usuario->getEstado()=="NC"){
            $estado="No confirmado";
        }
        else if($usuario->getEstado()=="D"){
            $estado="Desactivado";
        }
        else {
            $estado="Confirmado";
        }

        echo "<tr>
        <td>".$usuario->getNombre()." ".$usuario->getApellido1()." ".$usuario->getApellido2()."</td>
        <td>".$usuario->getEmail()."</td>
        <td>$estado</td>
        <td>
        <select class='form-control border' onchange=cambiarTipoUsuario(".$usuario->getId().") id='selectUsuario".$usuario->getId()."'>
        ";

        foreach($tiposUsuario as $tipoUsuario){
            if($tipoUsuario==$usuario->getTipoUsuario()){
                echo "<option value='".$tipoUsuario->getId()."' selected>".ucfirst($tipoUsuario->getTipoUsuario())."</option>";
            }
            else {
                echo "<option value='".$tipoUsuario->getId()."'>".ucfirst($tipoUsuario->getTipoUsuario())."</option>";
            }
        }


        echo "</select>
        </td>
        </tr>";
    }
}
            echo "</tbody></table></div>";
}


function cambiarTipoUsuario($idUsuario,$idTipoUsuario){
    $entityM=cargar("admin");
    $tipoUsuario=$entityM->find("TipoUsuario",$idTipoUsuario);
    $usuario=$entityM->find("Usuario",$idUsuario);

    $usuario->setTipoUsuario($tipoUsuario);
    
    if($tipoUsuario->getTipoUsuario()=="premium"){
        if(is_null($usuario->getCaducidadSuscripcion()) or $usuario->getCaducidadSuscripcion()<date("Y-m-d")){
        $fecha = new DateTime(date("Y-m-d"));
        $fecha->modify('+1 month');
        $usuario->setCaducidadSuscripcion(date_format($fecha,"Y-m-d"));
    }
}
    
    $entityM->flush();
}


function cargarPaisesOption(){
    $entityM=cargar("admin");
    $paises=$entityM->getRepository("Pais")->findAll();

    foreach($paises as $pais){
        echo "<option value='".$pais->getId()."'>".$pais->getNombre()."</option>";
    }
}

function insertarClub(){
    $entityM=cargar("admin");
    $nombreCompleto=filter_input(INPUT_POST,"nombreCompleto");
    $nombreCorto=filter_input(INPUT_POST,"nombreCorto");
    $pais=$entityM->find("Pais",filter_input(INPUT_POST,"selectPaises"));
    $fundacion=filter_input(INPUT_POST,"fundacion");


    $club=new Club($nombreCompleto,$nombreCorto,$pais,$fundacion);
    $entityM->persist($club);
    $entityM->flush();
}


function cargarClubs(){
    $entityM=cargar("admin");
    $clubs=$entityM->getRepository("Club")->findAll();

    foreach($clubs as $club){
        echo "<option value='".$club->getId()."'>".$club->getNombreCompleto()."</option>";
    }
}

function cargarTiposEquipoOption(){
    $entityM=cargar("admin");
    $tiposEquipo=$entityM->getRepository("TipoEquipo")->findAll();

    foreach($tiposEquipo as $tipoEquipo){
        echo "<option value='".$tipoEquipo->getId()."'>".$tipoEquipo->getTipo()."</option>";
    }
}

function insertarEquipo(){
    $entityM=cargar("admin");
    $club=$entityM->find("Club",filter_input(INPUT_POST,"selectClubs"));
    $tipoEquipo=$entityM->find("TipoEquipo",filter_input(INPUT_POST,"selectTipoEquipo"));
    $competicion=$entityM->find("Competicion",filter_input(INPUT_POST,"selectCompeticion"));
    $reputacion=filter_input(INPUT_POST,"reputacion");
    $genero=filter_input(INPUT_POST,"selectGenero");
    


    $equipo=new Equipo($club,$tipoEquipo,$competicion,$reputacion,$genero,new Datetime(date("Y-m-d H:i:s")));
    $entityM->persist($equipo);
    $entityM->flush();
}
?>