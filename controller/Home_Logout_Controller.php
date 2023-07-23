<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if(!($_SESSION["check_login"]) || !isset($_SESSION['check_login']))
    {
        header("location: ../view/Login.php");
        exit();
    }
    else
    {
        session_unset();
        session_destroy();

        header("location: ../view/Login.php");
        exit();
    }
    
?>