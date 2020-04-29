<?php
session_start();
?>



<div class='row text-right bg-secondary'>
<div class='col mx-auto my-1'>
<?php 
if(!isset($_SESSION["usuario"])) {
?>
<button type="button" class="btn btn-outline-info btn-lg" data-toggle="modal" data-target="#loginModal">
Accede
</button>

<button type="button" class="btn btn-outline-info btn-lg" data-toggle="modal" data-target="#registroModal">
Regístrate
</button>
<?php
}
else {
?>

<?php
if($_SESSION["usuario"]["tipoUsuario"]=="noticias" or $_SESSION["usuario"]["tipoUsuario"]=="administrador" or $_SESSION["usuario"]["tipoUsuario"]=="superusuario"){
  ?>
  
  <a class="btn btn-outline-info btn-lg" href="gestionnoticias.php">
  Acceso noticias
  </a>
  <?php
}

if($_SESSION["usuario"]["tipoUsuario"]=="registros" or $_SESSION["usuario"]["tipoUsuario"]=="administrador" or $_SESSION["usuario"]["tipoUsuario"]=="superusuario"){
?>
<a class="btn  btn-outline-info btn-lg" href="#">
  Acceso datos
  </a>
<?php
}

if($_SESSION["usuario"]["tipoUsuario"]=="superusuario"){
  ?>
  <a class="btn  btn-outline-info btn-lg" href="#">
  Acceso usuarios
  </a>
  <?php
  
}
?>

<a class="btn btn-outline-light btn-lg" href="perfil.php">
Perfil
</a>
<a class="btn btn-outline-danger btn-lg" href="logout.php">
Cerrar sesión
</a>

<?php

}
?>
</div>

</div>




<div class='row'>
<div class='col'>
<header class="navbar navbar-expand-md navbar-custom ">
<div class='container text-center'>
    <a class="navbar-brand mx-auto" href="index.php">
        <img class="logo" src="img/logoNuevo.png" alt="HandballWorld">
    </a>
    
   
</div>
</header>
</div>
</div>


    
  
<?php
if(!isset($_SESSION["usuario"])) {
?>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-title text-center">
          <h4>Login</h4>
        </div>
        <div class="d-flex flex-column text-center">
          <form action="login.php" method="POST">
            <div class="form-group">
              <input type="email" class="form-control" id="email"placeholder="Correo electrónico..." name="email" required>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="contraseña" placeholder="Contraseña..." name="contraseña" required>
            </div>
            <button type="submit" class="btn btn-secondary btn-block btn-round">Login</button>
          </form>
          
          </div>
      
    </div>
      
      </div>
  </div>
</div>



<div class="modal fade" id="registroModal" tabindex="-1" role="dialog" aria-labelledby="registroModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-title text-center">
          <h4>Registro</h4>
        </div>
        <div class="d-flex flex-column text-center">
          <form action="registro.php" method="POST">
            <div class="form-group">
              <input type="email" class="form-control" id="email"placeholder="Correo electrónico..." name="email" required>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="nombre"placeholder="Nombre" name="nombre" required>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="apellido1" placeholder="Primer Apellido" name="apellido1" required>
            </div>

            <div class="form-group">
              <input type="text" class="form-control" id="apellido2"placeholder="Segundo Apellido" name="apellido2">
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="contraseña1" placeholder="Contraseña..." name="contraseña1" required>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="contraseña2" placeholder="Repite contraseña..." name="contraseña2" required>
            </div>
            <button type="submit" class="btn btn-secondary btn-block btn-round">Regístrate</button>
          </form>
          
          </div>
      
    </div>
      
      </div>
  </div>
</div>
<?php
}
?>