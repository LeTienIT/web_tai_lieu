<?php
    require_once "../models/CommentsModel.php";
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION["btn"] = "post_waiting";
    $db = new comment_model();
    
    $rs = $db->get_all_comment();

    if($rs)
    {
        if(mysqli_num_rows($rs) > 0)
        {
            echo '<div class="post_waiting">           
                    <h1 class="post_waiting_heading">
                        Quản lý các bình luận
                    </h1>';
            while($row = mysqli_fetch_row($rs))
            {
                echo '<div class="user_waiting_box">
                        <div class="commentID">
                            <p>'.$row[3].'</p>
                        </div>
                        <div class="comment">
                            <p>'.$row[4].'</p>
                        </div>
                        <div class="box_control">
                            <a class="btn_option" href="../controller/Admin_Delete_Comment.php?id=' . $row[0] . '">Xóa</a>
                        </div>
                    </div>';
            }
            echo '</div>';
        }
        else
            {
                echo '<h3 style="padding: 5px 10px;color: red; font-size=22px;">Không tìm thấy bình luận nào</h3>';
            }
    }
?>