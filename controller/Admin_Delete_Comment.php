<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once("../models/CommentsModel.php");
    $commentID = $_GET['id'];
    $d = new comment_model();
    $r = $d->delete_comment($commentID);
    if($r == 1)
    {
        header("location: ../view/Admin.php");
    }
    else
    {
        echo "Lỗi không thể xóa bình luận này";
    }
?>