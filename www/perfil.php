<?php



include "head.html";
include "controlador/db.php";

?>
<body> 
<div class="container-fluid">
<div class="row bg-light">
<div class="col">
<?php
include "header.php";
if(isset($_SESSION["usuario"])){
    if(!isset($_POST["desactivarperfil"])){

    if(!isset($_POST["nombre"]) or !isset($_POST["apellido1"])){
?>
</div>
</div>
<?php
        include "nav.php";
        ?>
<?php
if(!isset($_POST["modificarperfil"])){
?>
<a href="#collapse" class="btn btn-secondary filtros mt-5" data-toggle="collapse">Opciones de perfil</a>
<div class='row ' >

<div class='col-xl-2 col-lg-3 col-md-12 col-sm-12 bg-primary mx-xl-0 mx-lg-0 mx-md-3 mx-sm-3 border-right border-secondary collapse d-lg-block text-right' id="collapse">
<div class='row'><div class='col'>

    <a class='btn btn-primary btn-lg text-secondary' href='#perfil'>Mi perfil</a>
   
    </div></div>

    <div class='row'><div class='col'>
    
    <a class='btn btn-primary btn-lg text-secondary'  href='#premium'>Experiencia premium</a>
    
   
    </div></div>
    
    <div class='row'><div class='col'>
    <a class='btn btn-primary btn-lg text-secondary'  href='#favoritos'>Gestión de favoritos</a>
    
   
    </div></div>
</div>
<div class='col-xl-2 col-lg-2 col-md-0 col-sm-0'>
</div>

<div class='col-xl-6 col-lg-5 col-md-12 col-sm-12 '>


    
    <div class='row mt-5 text-secondary text-center' id='perfil'><div class='col'><h2>Mi perfil</h2></div></div>
    <div class='row text-center bg-primary mt-3'>
    <div class='col'>
    <div class='row border border-secondary'><div class='col'>
    <div class='row p-2 border-bottom border-light'><div class='col'>
    
    <h5>Correo electrónico: <?php echo $_SESSION["usuario"]["email"]?></h5>
    </div>
    </div>
    <div class='row p-2 border-bottom border-light'><div class='col'>
    
    <h5>Nombre completo: <?php echo $_SESSION["usuario"]["nombre"]." ".$_SESSION["usuario"]["apellido1"]." ".$_SESSION["usuario"]["apellido2"]?></h5>
    </div>
    </div>

    <div class='row p-2 border-bottom border-light'><div class='col'>
    
    <h5>Suscripción: <?php 
    
    if($_SESSION["usuario"]["tipoUsuario"]=="superusuario" or $_SESSION["usuario"]["tipoUsuario"]=="administrador" or $_SESSION["usuario"]["tipoUsuario"]=="noticias" or $_SESSION["usuario"]["tipoUsuario"]=="registros" or $_SESSION["usuario"]["tipoUsuario"]=="premium"){
        echo "Premium";
    }
    else {
        echo "Estándar";
    }
    ?></h5>
    </div>
    </div>
    </div></div>
    <div class='row text-right bg-white pt-3'>
    <div class='col d-inline-flex'>
    <form action='perfil.php' method='POST'>
    <button type='submit' class='btn btn-secondary mr-2'>Modificar cuenta</button>
    <input type='hidden' name='modificarperfil'>
    </form>
    <form action='perfil.php' method='POST'> 
    <button type='submit' class='btn btn-danger'>Desactivar cuenta</button>
    <input type='hidden' name='desactivarperfil'>
    </form>
    </div>
    </div>
    </div>
    </div>
    <div class='row mt-5'>
    <div class='col'>
    <div class='row text-secondary text-center'>
    <div class='col'><h2>Experiencia premium</h2>
    </div>
    </div>
    <div class='row'>
    <div class='col'>
    <?php
    if($_SESSION["usuario"]["tipoUsuario"]=="registrado"){
        ?>
        <div class='row'><div class='col text-center'>
        <form class='form' action='perfil.php' method='POST'>
        <input type='hidden' name='suscripcion'>
        <button type='submit' class='btn btn-secondary'>Házte premium</button>
        </form>
        </div></div>
        <?php
    }
    else {
        ?><div class='row'><div class='col'>
        <h5>Eres usuario premium. Ya tienes acceso a todas las características de la página hasta el <?php echo date_format(new Datetime($_SESSION["usuario"]["caducidad"]),"d-m-Y")?></h5>
        </div></div>
        <div class='row '><div class='col text-right'>
        <form class='form' action='perfil.php' method='POST'>
        <input type='hidden' name='suscripcion'>
        <button type='submit' class='btn btn-secondary'>Amplía tu suscripción</button>
        </form>
        </div></div>
        <?php
    }
    ?>
    </div>
    </div>
    </div>
    </div>
<div class='row'>
<div class='col'>

<div class='row text-center text-secondary'>
<div class='col'><h2>Gestión de favoritos</h2>
</div>
</div>
<div class='row text-secondary'>
<div class='col'>
<h4>Tus jugadores favoritos</h4>
</div></div>
<div class='row'>
<div class='col'>
<?php
cargarJugadoresFavoritos();
?>
</div>
</div>
</div>
</div>


<div class='row text-secondary'>
<div class='col'>
<h4>Tus técnicos favoritos</h4>
</div></div>
<div class='row'>
<div class='col'>
<?php
cargarTecnicosFavoritos();
?>
</div>
</div>

<div class='row text-secondary'>
<div class='col'>
<h4>Tus equipos favoritos</h4>
</div></div>
<div class='row'>
<div class='col'>
<?php
cargarTecnicosFavoritos();
?>
</div>
</div>
</div>
</div>





    <?php
    
    } else {
        ?>
        <div class='row mt-5'>
        <div class='col'>
        <a class='btn btn-link text-secondary' href='perfil.php'><h5>&lt; Volver a perfil</h5></a>
        </div>
        </div>

        <div class='row justify-content-center'>
        <div class='col-xl-6 col-lg-6 col-md-12 col-sm-12 text-center'>
        <div class='row justify-content-center bg-primary border border-secondary p-3'>
        <div class='col-xl-6 col-lg-6 col-md-12 col-sm-12'>
        <div class="form-title text-center text-secondary">
        <h2>Modifica tus datos</h2>
        </div>
        <div class="d-flex flex-column text-center">
          <form action="perfil.php" method="POST">
            <div class="form-group">
            <label for='nombre'><h6>Nombre</h6></label>
              <input type="text" class="form-control" id="nombre" placeholder="Nombre..." name="nombre" required value='<?php echo $_SESSION["usuario"]["nombre"]?>'>
            </div>
            <div class="form-group">
            <label for='apellido1'><h6>Primer apellido</h6></label>
              <input type="text" class="form-control" id="apellido1" placeholder="Primer apellido..." name="apellido1" required value='<?php echo $_SESSION["usuario"]["apellido1"]?>'>
            </div>

            <div class="form-group">
            <label for='apellido2'><h6>Segundo apellido</h6></label>
              <input type="text" class="form-control" id="apellido2" placeholder="Segundo apellido..." name="apellido2" value='<?php echo $_SESSION["usuario"]["apellido2"]?>'>
            </div>

            
            <button type="submit" class="btn btn-secondary btn-block btn-round">Guardar cambios</button>
          </form>
          
          </div>
        </div>
        </div>
        </div>
        </div>
        <?php
    }
    ?>
</div>
</div>
</div>

<?php
include "footer.html";

    }
    else {
        modificarPerfil();
        header("Location:perfil.php");
    }
    }else {
        desactivarPerfil();
        header("Location:logout.php");
    }
}
else {
header("Location:index.php");
}
?>