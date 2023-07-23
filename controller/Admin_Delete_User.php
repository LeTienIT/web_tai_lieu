<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once("../controller/Home_User_Controller.php");
    $userID = $_GET['id'];
    $d = new users();
    $r = $d->delete_users($userID);
    if($r == 1)
    {
        header("location: ../view/Admin.php");
    }
    else
    {
        echo "Lỗi không thể xóa tài khoản";
    }
?>