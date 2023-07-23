<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once("../controller/Home_User_Controller.php");
    $userID = $_GET['id'];
    $d = new users();
    $inf = $d->get_user_id($userID);
    $row = mysqli_fetch_row($inf);
    $userId = $row[1];
    $password = $row[5];
    $r = $d->accep_users($userID);
    if($r == 1)
    {
        header("location: ../view/Admin.php");
    }
    else
    {
        echo "Lỗi không thể duyệt tài khoản người dung";
    }
?>