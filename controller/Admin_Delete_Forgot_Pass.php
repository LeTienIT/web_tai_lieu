<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once("../controller/Home_User_Controller.php");
    $requiredID = $_GET['id'];
    $d = new users();
    $r = $d->delete_users_forgot_pass($requiredID);
    if($r == 1)
    {
        header("location: ../view/Admin.php");
    }
    else
    {
        echo "Lỗi không thể xóa tài khoản";
    }
?>