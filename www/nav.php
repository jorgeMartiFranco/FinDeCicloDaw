<div class="row" id="navPagina">
    <div class='col p-0'>
<nav class="navbar navbar-expand-lg navbar-light bg-secondary p-0">
 
  <button class="navbar-toggler bg-white" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
     
    <ul class="navbar-nav w-100 ">
      <li class="nav-item active mx-3 py-2">
        <a class="nav-link text-white" href="index.php"><h5>Inicio</h5></a>
      </li>

      <li class="nav-item dropdown mx-3 py-2" id="navNoticias">
      <a class="nav-link text-white" href="#">
       <h5>Noticias</h5>
      </a>
      <div class="dropdown-menu bg-primary">
      <?php
      cargarDropdownNoticias();
      ?>
        
      </div>
    </li>
      
      <li class="nav-item mx-3 p-2">
        <a class="nav-link text-white" href="#"><h5>Fichajes</h5></a>
      </li>
      <li class="nav-item dropdown mx-3 py-2">
        <a class="nav-link text-white" href="#"><h5>Jugadores</h5></a>
        <div class="dropdown-menu bg-primary">
        <form action="busqueda.php" method='POST'>
        <button type='submit' class='dropdown-item py-2 btn btn-link' href=""><h6>Buscar jugadores</h6></button>
        <input type='hidden' name='buscajugador'>
        <input type='hidden' name='femenino'>
        <input type='hidden' name='masculino'>
        <input type='hidden' name='sinEquipo'>
        <input type='hidden' name='conEquipo'>
        </form>
       
        </div>
      </li>
      <li class="nav-item dropdown mx-3 py-2">
        <a class="nav-link text-white" href="#"><h5>Técnicos</h5></a>
        <div class="dropdown-menu bg-primary">
        <form action="busqueda.php" method='POST'>
        <button type='submit' class='dropdown-item py-2 btn btn-link' href=""><h6>Buscar técnicos</h6></button>
        <input type='hidden' name='buscatecnico'>
        <input type='hidden' name='femenino'>
        <input type='hidden' name='masculino'>
        <input type='hidden' name='sinEquipo'>
        <input type='hidden' name='conEquipo'>
        <?php
        cargarInputsHiddenTecnicos();
        ?>
        </form>
       
        </div>
      </li>
      <li class="nav-item dropdown mx-3 py-2">
        <a class="nav-link text-white" href="#"><h5>Equipos</h5></a>
        <div class="dropdown-menu bg-primary">
        <form action="busqueda.php" method='POST'>
        <button type='submit' class='dropdown-item py-2 btn btn-link' href=""><h6>Buscar equipos</h6></button>
        <input type='hidden' name='equipos'>
        </form>
        <form action="busqueda.php" method='POST'>
        <button type='submit' class='dropdown-item py-2 btn btn-link' href=""><h6>Equipos sin entrenador</h6></button>
        <input type='hidden' name='equipoLibre'>
        </form>
        </div>
      </li>
      <?php
      if(isset($_SESSION["usuario"])){
      ?>
      <li class="nav-item mx-3 py-2">
        <a class="nav-link text-white" href="favoritos.php"><h5>Favoritos</h5></a>
      </li>
      <?php
      }
      ?>
    </ul>

    <div class="container text-right ">
       
        <div class="btn-group my-1 my-md-0 " role="group">
            <a class="btn btn-secondary" href="https://www.twitter.com"><i class="fa fa-twitter fa-lg text-white" aria-hidden="true"></i></a>
            <a class="btn btn-secondary" href="https://www.facebook.com"><i class="fa fa-facebook fa-lg text-white" aria-hidden="true"></i></a>
            <a class="btn btn-secondary " href="https://www.instagram.com"><i class="fa fa-instagram fa-lg text-white" aria-hidden="true"></i></a>
        
</div>


        <form action="busqueda.php" method="POST" class="form-check-inline custom-check-form">
            
                
            <input class="form-control " placeholder="Buscar personas" type="text" name="persona">
            <input name='jugador' type='hidden'>
            <input name='tecnico' type='hidden'>
            <?php
            cargarInputsHidden();
            ?>
            <input name='sinEquipo' type='hidden'>
            <input name='conEquipo' type='hidden'>
            <input name='masculino' type='hidden'>
            <input name='femenino' type='hidden'>
            <button class="btn btn-secondary" type="submit"><i class="fa fa-search fa-lg text-white" aria-hidden="true"></i></button>

        </form>
</div>
        </div>
  </div>
</nav>
</div>