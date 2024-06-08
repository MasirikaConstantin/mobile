<?php
    session_start();
    session_destroy();
    header('Location: actionOuv/ConnexionClie.php');
?>