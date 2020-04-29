<?php
include "controlador/db.php";
include "head.html";
$opcion=comprobarUsuario();

if($opcion=="sesionI"){
    header("Location:index.php");
}
else if($opcion=="NC"){
    ?>
    
    <body> 
<div class="container-fluid">
<div class="row bg-light">
<div class="col">
<?php
include "header.php";
?>
</div>
</div>

<?php
include "nav.php";
?>

<div class='row text-center mt-5 text-secondary'><div class='col'>
<h4>Tu cuenta no está activada. Actívala con el email de confirmación que te hemos enviado al email</h4>
<h4>Volver a enviar email. Asegúrate de que es el mismo con el que te registraste</h4>
</div></div>
<div class='row text-center justify-content-center'><div class='col-xl-4 col-lg-6 col-md-12 col-sm-12'>
<form method='POST' action='registro.php'>

<input class='form-control border border-dark' type='text' name='emailreenvio' placeholder='Email'>
<button type='submit' class='btn btn-outline-secondary mt-1'>Enviar</button>
</form>
</div></div>
<div class='row text-center'><div class='col'>
<a class='btn btn-link text-secondary' href='index.php'><h4>Volver a Inicio</h4></a>
</div></div>




</div>
</body>
    <?php
}
else if($opcion="D"){
    ?>
    
    <body> 
<div class="container-fluid">
<div class="row bg-light">
<div class="col">
<?php
include "header.php";
?>
</div>
</div>

<?php
include "nav.php";
?>

<div class='row text-center mt-5'><div class='col'>
<h4>Tu cuenta está desactivada. Contacta con un administrador para restablecerla</h4>

</div></div>
<div class='row text-center'><div class='col'>
<a class='btn btn-link text-secondary' href='index.php'><h4>Volver a Inicio</h4></a>

</div></div>

</div>
</body>
    
    <?php
}
else {
    header("Location:index.php");
}
?>


