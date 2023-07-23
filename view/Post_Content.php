<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once("../controller/Home_getPost_Controller.php");
    require_once("../models/CommentsModel.php");
    $userName = $_SESSION["userName"];
    $permissionID = $_SESSION["permissionID"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../fonts/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../stylers/Post_Content.css">
    <link rel="stylesheet" href="../stylers/Reponsive_Post.css">
    <title>Nội dung bài viết</title>
</head>
<body>
    <div id="main">
        <div id="header">
            <i class="ti-world"></i>
            <h1>Trang Thông Tin</h1>
        </div>
        <div class="back_home">
            <a href="<?php echo $_SESSION["last_page"]; ?>"><i class="ti-arrow-left"></i><span>Trở về</span></a>
        </div>
        <div class="main_content">
            <?php
                $postID = $_GET['id'];
                $d = new post();
                $r = $d->get_post_postID($postID);
                $p = mysqli_fetch_row($r);
            ?>
            <div class="content">
                <div class="post_header">
                    <h1><?php echo $p[0]; ?></h1>
                </div>
                <div class="post_info">
                    <div class="box">
                        <h3>Tác giả: <span><?php echo $p[1]; ?></span></h3>
                    </div>
                    <div class="box">
                        <h3>Ngày viết: <span><?php echo $p[2]; ?></span></h3>
                    </div>
                    <div class="box">
                        <h3>Chủ để: <span><?php echo $p[3]; ?></span></h3>
                    </div>
                </div>
                <div class="post_content">
                    <?php echo $p[4]; ?>
                </div>
            </div>
            <div class="sub_content">
                <p class="sub_content_heading">
                    Bài viết cùng chủ đề
                </p>
                <div class="sub_content_main">
                    <?php
                        $postTopic = $p[6];
                        $d1 = new post();
                        $r1 = $d1->get_post_topic_view($postTopic,$postID);
                        if(mysqli_num_rows($r1) > 0)
                        {
                            $dem=0;
                            while($row4 = mysqli_fetch_row($r1))
                            {
                                echo '<a href="Post_Content.php?id=' . $row4[0] . '" class="box_sp">
                                        <div class="box_sp_text">
                                            <p>'.$row4[6].'</p>
                                        </div>
                                        <div class="box_sp_img">
                                            <img src="'.$row4[5].'" alt="">
                                        </div>
                                    </a>';
                                $dem++;
                                if($dem==4)break;
                            }
                        }
                    ?>
                </div>
                
            </div>
            <form method="post" action="../controller/Add_Comment_Controller.php" class="add_comment" id="comments">
                <textarea name="ct_comment" id="" cols="50" rows="3" placeholder="Nhập bình luận" required></textarea>
                <input type="hidden" name="postID" id="" value = "<?php echo $postID; ?>">
                <input type="submit" name="" id="" value="Bình luận">
            </form>
            <div class="sub_comment">
                <?php
                    $cm = new comment_model();
                    $rms = $cm->get_comment($postID);
                    while($rm = mysqli_fetch_row($rms))
                    {
                        echo '<div class="box_comment">
                                <h3 class="user_name">'.$rm[3].'</h3>
                                <p>'.$rm[4].'</p>
                            </div>';
                    }
                ?> 
            </div>
        </div>
    </div>
</body>
</html>