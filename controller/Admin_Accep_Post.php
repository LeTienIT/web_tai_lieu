<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once("../controller/Home_getPost_Controller.php");
    $postID = $_GET['id'];
    $date_time = date("Y-m-d");
    $d = new post();
    $r = $d->accep_posts($postID,$date_time);
    if($r == 1)
    {
        header("location: ../view/Admin.php");
    }
    else
    {
        echo "Loi cap nhat";
    }
?>