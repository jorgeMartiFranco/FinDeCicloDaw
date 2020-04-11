<?php


if(isset($_GET["id"]) or !empty($_GET["id"])){
include "head.html";
include "controlador/db.php";
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


            <div class="row position-sticky fixed-top">
                <div class='col p-0'>
        <?php
        include "nav.php";
        ?>
        </div>
</div>

<?php include "navCompeticionesPais.php"; ?>

        <div class='row mt-5 mx-1 border-top border-right border-secondary'>
                    
            <div class='col'>

            <?php
            cargarNoticiaCompleta($_GET["id"]);
            ?>
        </div>
        </div>
<?php
        include "footer.html";
        ?>
</div>
<?php
}
else {
    header("Location:index.php");
}

?>