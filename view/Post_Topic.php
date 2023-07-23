<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once("../controller/Home_getPost_Controller.php");
    require_once("../controller/Home_GetTopic_Controller.php");
    $userName = $_SESSION["userName"];
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../fonts/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../stylers/Post_Topic.css">
    <link rel="stylesheet" href="../stylers/Reponsive_Post_Topic.css">
    <title>Danh sách bài viết</title>
</head>
<body>
    <div id="main">
        <div id="header">
            <i class="ti-world"></i>
            <h1>Trang Thông Tin</h1>
        </div>
        <div class="back_home">
            <a href="../view/Home.php"><i class="ti-arrow-left"></i><span>Trở về</span></a>
        </div>
        <div class="main_content">
            <?php
                $topicID = $_GET['topicID'];
                $_SESSION["last_page"] = "Post_Topic.php?topicID=$topicID";
                if ($topicID == -1)
                {
                    echo '<div class="topic">
                            <h1>Các bài viết mới nhất</h1>
                        </div>';
                }
                else if($topicID == 0)
                {
                    echo '<div class="topic">
                            <h1>Các bài viết comment nhiều nhất</h1>
                        </div>';
                }
                else
                {
                    $dp = new topic_model();
                    $rps = $dp->get_topic_id($topicID);
                    if($rps)
                    {
                        $rp = mysqli_fetch_row($rps);
                        echo '<div class="topic">
                            <h1>'.$rp[0].'</h1>
                        </div>';
                    }
                    else
                    {
                        echo '<div class="topic">
                            <h1>Lỗi!!</h1>
                        </div>';
                    }
                }
            ?>        
            <div class="post">
                <?php
                    $topicID = $_GET['topicID'];
                    $db = new post();
                    if ($topicID == -1)
                    {
                        $rs = $db->get_post_all();
                    } 
                    else if($topicID == 0)
                    {
                        $rs = $db->get_post_comment();
                    }
                    else
                    {
                        $rs = $db->get_post_Topic($topicID);
                    }
                    if($rs)
                    {
                        if (mysqli_num_rows($rs) > 0)
                        {
                            while($row = mysqli_fetch_row($rs))
                            {
                                echo '<a href="Post_Content.php?id=' . $row[0] . '" class="box_main">
                                        <div class="img">
                                            <img src="' . $row[5] . '" alt="">
                                        </div>
                                        <div class="title">
                                            <h3>' . $row[6] . '</h3>
                                        </div>
                                        <div class="date_time">
                                            <h3>Ngày đăng: <span>' . $row[2] . '</span></h3>
                                        </div>
                                        <div class="userName">
                                            <h3>Tác giả: <span>' . $row[4] . '</span></h3>
                                        </div>
                                    </a> ';
                            }
                            echo '<p style="text-align:center;color:black;font-size:16px;display:block;width:100%;">Không còn bài viết khác</p>';
                        }
                        else
                        {
                            echo '<h3 style="text-align: center;padding: 5px 10px;color: red; font-size=22px;">Không có bài viết nào cho chủ đề này</h3>';
                             
                        }
                        
                    }
                    else
                    {
                        echo "Không thể truy xuất csdl: '.$rs.'";
                    }
                ?>
                
            </div>
        </div>
    </div>
</body>
</html>