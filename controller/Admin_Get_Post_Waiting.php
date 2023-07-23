<?php
    require_once "../models/PostModel.php";
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION["btn"] = "post_waiting";
    $db = new post_model();
    
    $rs = $db->get_post_waiting();

    if($rs)
    {
        if(mysqli_num_rows($rs) > 0)
        {
            echo '<div class="post_waiting">
                    <h1 class="post_waiting_heading">
                        Danh sách các bài viết chờ xét duyệt
                    </h1>';
            while($row = mysqli_fetch_row($rs))
            {
                echo '<div class="post_waiting_box">
                        <div class="box_img">
                            <img src="'.$row[5].'" alt="">
                        </div>
                        <div class="box_title">
                            <p>'.$row[6].'</p>
                        </div>
                        <div class="box_time">
                            <h3>'.$row[1].'</h3>
                        </div>
                        <div class="box_username">
                            <h3>'.$row[4].'</h3>
                        </div>
                        <div class="box_control">
                            <a class="btn_option" href="Post_Content.php?id=' . $row[0] . '">Xem</a>
                            <a class="btn_option" href="../controller/Admin_Accep_Post.php?id=' . $row[0] . '">Duyệt</a>
                            <a class="btn_option" href="../controller/Admin_Delete_Post.php?id=' . $row[0] . '">Xóa</a>
                        </div>
                    </div> ';
            }
            echo '</div>';
        }
        else
        {
            echo '<h3 style="padding: 5px 10px;color: red; font-size=22px;">Không có bài viết nào</h3>';
        }
    }
?>