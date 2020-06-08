<?php
include "head.html";
session_start();
include "controlador/db.php";
if(isset($_SESSION["usuario"])){


if($_SESSION["usuario"]["tipoUsuario"]=="superusuario"){

?>

<body>

    <div class='container-fluid'>

        <div class='row bg-secondary'>
            <div class='col'>
                <h4 class='text-light text-center'>Te encuentras en la sección de gestión de usuarios de Handball World. <a href='index.php' class='text-info'>Volver a inicio.</a></h4>
            </div>
        </div>

        <div class='row mt-5'>
        
            <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>
                <h3 class='text-center'>Usuarios</h3>
                <div class='row'>
                    <div class='col'>
                        <?php
                        cargarUsuarios();
                        ?>
    </div>
    </div>
    </div>
    
</div>

    </div>
</body>
<?php

}
else {
    header("Location:index.php");
}
}
else {
    header("Location:index.php");
}

?>