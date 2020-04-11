<nav class="navbar navbar-expand-lg navbar-light py-0 text-dark">
 
  <button class="navbar-toggler bg-primary mt-5" type="button" data-toggle="collapse" data-target="#navbarCompeticiones" aria-controls="navbarCompeticiones" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCompeticiones">
     
    <ul class="navbar-nav mt-5">
      
    <?php
    if(isset($_GET["pais"]) and !isset($_GET["competicion"]) ){
        cargarCompeticionesPais($_GET["pais"]);
    }
    else if(isset($_GET["competicion"]) and !isset($_GET["pais"])){
        cargarPaisCompeticion($_GET["competicion"]);
    }
    else if(isset($_GET["id"])){
        cargarCompeticionNoticia($_GET["id"]);
    }
    
    ?>
      
  </ul>

</div>
        </div>
  </div>
</nav>