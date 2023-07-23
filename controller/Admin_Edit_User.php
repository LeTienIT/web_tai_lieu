<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once("../controller/Home_User_Controller.php");
    $userID = $_POST["userID"];
    $permissionID = $_POST["permissionID"];
    $accountStatus = $_POST["accountStatus"];
    $notify = "";
    $d = new users();
    $r = $d->edit_user_ID($userID,$permissionID,$accountStatus);
    if($r == 1)
    {
        $_SESSION["Edit_account"] = "Tài khoản đã được cập nhật thành công";
    }
    else
    {
        $_SESSION["Edit_account"] =  "Lỗi không thể cập nhật tài khoản";
    }
    header("location: ../view/Admin_Edit_Account.php?id=".$userID);
?>