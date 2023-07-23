<?php
    require_once "../models/UserModel.php";
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION["btn"] = "post_waiting";
    $db = new userModel();
    
    $rs = $db->user_waiting();

    if($rs)
    {
        if(mysqli_num_rows($rs) > 0)
        {
            echo '<div class="post_waiting">           
                    <h1 class="post_waiting_heading">
                        Danh sách các tài khoản chờ xét duyệt
                    </h1>';
            while($row = mysqli_fetch_row($rs))
            {
                echo '<div class="user_waiting_box">
                        <div class="userID">
                            <p>'.$row[1].'</p>
                        </div>
                        <div class="userName">
                            <p>'.$row[2].'</p>
                        </div>
                        <div class="userPhone">
                            <p>'.$row[3].'</p>
                        </div>
                        <div class="userEmail">
                            <p>'.$row[4].'</p>
                        </div>
                        <div class="userPermission">
                            <p>'.$row[6].'</p>
                        </div>
                        <div class="box_control">
                            <a class="btn_option" href="../controller/Admin_Accep_User.php?id=' . $row[0] . '">Duyệt</a>
                            <a class="btn_option" href="../controller/Admin_Delete_User.php?id=' . $row[0] . '">Xóa</a>
                        </div>
                    </div>';
            }
            echo '</div>';
        }
        else
        {
            echo '<h3 style="padding: 5px 10px;color: red; font-size=22px;">Không có tài khoản nào mới đăng ký</h3>';
        }
    }
?>