<?php
session_start();
if(isset($_SESSION['usuario'])) {
    $_SESSION = [];
    setcookie(session_name(), '', time() - 1000);
}
session_destroy();
header('Location: index.php');