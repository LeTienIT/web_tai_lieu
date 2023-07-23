<?php
    require_once "../models/PostModel.php";
    require_once "Home_GetTopic_Controller.php";
    if (!isset($_SESSION)) {
        session_start();
    }
    $dt = new topic_model();
    $rt = $dt->getTopic();
    
    global $nameTopic;
    if(isset($_GET["submits"]))
    {
        $postTopic = $_GET["topicID"];
        $db = new post_model();
        $rs = $db->get_post_topics($postTopic);

        $rr = $dt->get_topic_id($postTopic);
        $nameT = mysqli_fetch_row($rr);
        $nameTopic = $nameT[0];

       // echo 'nut submit dc chon '.$postTopic." ".$_GET["submits"];
    }
    else
    {
        $postTopic = 1;
        $db = new post_model();
        $rs = $db->get_post_topics($postTopic);
        $nameTopic = "Thời sự";
       // echo 'nut submit khong dc chon'.rand();
    }
    
?>

<div class="post_waiting">           
    <h1 class="post_waiting_heading">
        Quản lý bài viết
    </h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="post_option_title" method="get">
        <p>Chủ đề</p>
        <select id="user" name="topicID" class="option">
            <?php
                while($rowt = mysqli_fetch_row($rt))
                {?>
                    <option value="<?php echo $rowt[0]; ?>" <?php if ($rowt[0] == $postTopic) echo 'selected'; ?>>
                        <?php echo $rowt[1]; ?>
                    </option>
             <?php   }?>
            
        </select>
        <input id="search-form" type="submit" name="submits" value="Tìm">

    </form>
    <div class="clear"></div>
    <div class="title_heading">
        <h1><?php echo $nameTopic;?></h1>
    </div>

    <?php
        if($rs)
        {
            if(mysqli_num_rows($rs) > 0)
            {
                while($row = mysqli_fetch_row($rs))
                {
                    echo '<div class="post_waiting_box">
                        <div class="box_img">
                            <img src="' . $row[5] . '" alt="">
                        </div>
                        <div class="box_title">
                            <p>' . $row[6] . '</p>
                        </div>
                        <div class="box_time">
                            <h3>' . $row[2] . '</h3>
                        </div>
                        <div class="box_username">
                            <h3>' . $row[4] . '</h3>
                        </div>
                        <div class="box_control">
                            <a class="btn_option" href="Post_Content.php?id=' . $row[0] . '">Xem</a>
                            <a class="btn_option" href="../controller/Admin_Delete_Post.php?id=' . $row[0] . '">Xóa</a>
                        </div>
                    </div> ';
                }
            }
            else
            {
                echo '<h3 style="padding: 5px 10px;color: red; font-size=22px;">Không tìm thấy bài nào</h3>';
            }
        }
        else
        {
            echo '<h3 style="padding: 5px 10px;color: red; font-size=22px;">Lỗi truy vấn</h3>';
        }
    ?>
</div>

