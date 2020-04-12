<div class="row" id="navPagina">
    <div class='col p-0'>
<nav class="navbar navbar-expand-lg navbar-light bg-secondary p-0">
 
  <button class="navbar-toggler bg-white" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
     
    <ul class="navbar-nav">
      <li class="nav-item active mx-3">
        <a class="nav-link text-white" href="index.php"><h5>Inicio</h5></a>
      </li>

      <li class="nav-item dropdown mx-3" id="navNoticias">
      <a class="nav-link text-white" href="noticias.php" >
       <h5>Noticias</h5>
      </a>
      <div class="dropdown-menu bg-primary">
      <?php
      cargarDropdownNoticias();
      ?>
        
      </div>
    </li>
      
      <li class="nav-item mx-3">
        <a class="nav-link text-white" href="#"><h5>Fichajes</h5></a>
      </li>
      <li class="nav-item mx-3">
        <a class="nav-link text-white" href="#"><h5>Jugadores</h5></a>
      </li>
      <li class="nav-item mx-3">
        <a class="nav-link text-white" href="#"><h5>Entrenadores</h5></a>
      </li>
      <li class="nav-item mx-3">
        <a class="nav-link text-white" href="#"><h5>Equipos</h5></a>
      </li>
      
    </ul>

    <div class="container text-right">
       
        <div class="btn-group my-1 my-md-0" role="group">
            <a class="btn btn-secondary p-3" href="https://www.twitter.com"><i class="fa fa-twitter fa-lg text-white" aria-hidden="true"></i></a>
            <a class="btn btn-secondary p-3" href="https://www.facebook.com"><i class="fa fa-facebook fa-lg text-white" aria-hidden="true"></i></a>
            <a class="btn btn-secondary p-3" href="https://www.instagram.com"><i class="fa fa-instagram fa-lg text-white" aria-hidden="true"></i></a>
        
</div>


        <form action="search.php" method="POST" class="form-check-inline">
            
                
            <input class="form-control p-2" placeholder="Buscar personas" type="text" name="persona">
           
            <button class="btn btn-secondary p-3" type="submit"><i class="fa fa-search fa-lg text-white" aria-hidden="true"></i></button>

        </form>
</div>
        </div>
  </div>
</nav>
</div>