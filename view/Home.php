<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once("../controller/Home_GetTopic_Controller.php");
    require_once("../controller/Home_getPost_Controller.php");

    if(!isset($_SESSION['check_login']) || !($_SESSION["check_login"]))
    {
        $_SESSION["userID"] = '-1';
        $_SESSION["userName"] = "Client";
        $_SESSION["permissionID"] = '0';
        $userName = "Client";
        $permissionID = 0;
    }
    else
    {
        if(isset($_SESSION["userName"]))
        {
            $userName = $_SESSION["userName"];
            $permissionID = $_SESSION["permissionID"];
        }
        else
        {
            $_SESSION["userID"] = '-1';
            $_SESSION["userName"] = "Client";
            $_SESSION["permissionID"] = '0';
            $userName = "Client";
            $permissionID = 0;
        }
    }

    $db = new topic_model();
    $rs = $db->getTopic();
    $_SESSION["last_page"] = "Home.php";

    $d = new post();
    $rd = $d->get_post_all(); 
    if($row = mysqli_fetch_row($rd))
    {
        $id_post = $row[0];
        $img = $row[5];
        $title = $row[6];
        $post_time = $row[2];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../fonts/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../stylers/Home_styler.css">
    <link rel="stylesheet" href="../stylers/footer.css">
    <link rel="stylesheet" href="../stylers/Reponsive_Home.css">
    <title>Home</title>
</head>
<body>
    <div id="main">
        <div id="header">
            <i class="ti-world"></i>
            <h1>Trang Thông Tin</h1>
        </div>
        <div id="navigation_menu">
            <ul>
                <li class="sub_menu_header"><i class="ti-home"></i></li>
                <li class="sub_menu"><a href="../controller/Home_Post_Topic.php?postID= -1">Tin mới</a></li>
                <li class="sub_menu"><a href="../controller/Home_Post_Topic.php?postID= 1">Thời Sự</a></li>
                <li class="sub_menu"><a href="../controller/Home_Post_Topic.php?postID= 2">Thế giới</a></li>
                <li class="sub_menu"><a href="../controller/Home_Post_Topic.php?postID= 4">Khoa học</a></li>
                <li class="sub_menu"><a href="../controller/Home_Post_Topic.php?postID= 3">Xã hội</a></li>
                <li class="sub_menu"><a href="../controller/Home_Post_Topic.php?postID= 5">Giáo dục</a></li>
                <li class="sub_menu"><a href="../controller/Home_Post_Topic.php?postID= 6">Giải trí</a></li>
                <li class="sub_menu"><a href="../controller/Home_Post_Topic.php?postID= 0">Top comment</a></li>
            </ul>
        </div>
        <div id="navigation_select">
            <div class="time">
                <?php
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $timestamp = time();
                    $formattedDate = date('l, d/m/Y, H:i', $timestamp);
                    echo "<p>".$formattedDate."</p>";
                ?>
            </div>
            <form action="../controller/Home_Post_Topic.php" method="get" class="sub_search">
                <select id="user" name="postID" class="cbb_Option">
                    <?php
                        while($row = mysqli_fetch_row($rs))
                        {
                            echo '<option value="'.$row[0].'"> '.$row[1].' </option>';
                        }
                    ?>
                </select>
                <input type="submit" value="Tìm">
            </form>
        </div>
        <div id="main_content">
            <div class="row_content">

                <div class="column_main">
                    <div class="heading_column">
                        <H3>Tin mới nhất</H3>
                    </div>
                    <div class="column_body">
                        <a href="Post_Content.php?id=<?php echo $id_post?>" class="box1">
                            <div class="box_img">
                                <img src="<?php echo isset($img) ? $img : ''; ?>" alt="">
                            </div>
                            <div class="box_text">
                                <div class="heading">
                                    <p><?php echo isset($title) ? $title : ''; ?></p>
                                </div>
                                <div class="sub_heading">
                                    <p>Time: <?php echo isset($post_time) ? $post_time : ''; ?></p>
                                </div>
                            </div>
                        </a>
                        <div class="box2">
                            <?php
                                $dem = 0;
                                while ($row = mysqli_fetch_row($rd)) 
                                {
                                    echo '<a href="Post_Content.php?id=' . $row[0] . '" class="box">
                                            <div class="box2_text">
                                                <p>'.$row[6].'</p>
                                            </div>
                                            <div class="box2_img">
                                                <img src="'.$row[5].'" alt="">
                                            </div>
                                        </a> ';
                                        $dem++;
                                        if($dem==5)break;
                                }
                            ?>
                             
                        </div>
                    </div>
                    
                </div> 

                <div class="new_column">
                    <div class="heading_column">
                        <H3>Tin tức trong nước</H3>
                    </div>
                    <?php
                        $dp2 = new post();
                        $rp2 = $dp2->get_post_Topic(1);

                        if (mysqli_num_rows($rp2) > 0) {
                            $i = 0;
                            while ($row2 = mysqli_fetch_row($rp2)) 
                            {
                                echo '<a href="Post_Content.php?id=' . $row2[0] . '" class="box">
                                        <div class="img">
                                            <img src="' . $row2[5] . '" alt="">
                                        </div>
                                        <div class="box_content">
                                            <div class="title">
                                                <h3>' . $row2[6] . '</h3>
                                            </div>
                                            <div class="userName">
                                                <h3>Time: <span>' . $row2[2] . '</span></h3>
                                            </div>
                                        </div>
                                    </a>';
                                $i++;
                                if($i == 5)
                                {
                                    break;
                                }
                            }
                        }
                    ?>

                </div>

                <div class="new_column">
                    <div class="heading_column">
                        <H3>Tin tức quốc tế</H3>
                    </div>
                    <?php
                        $dp3 = new post();
                        $rp3 = $dp3->get_post_Topic(2);

                        if (mysqli_num_rows($rp3) > 0) {
                            $i = 0;
                            while ($row3 = mysqli_fetch_row($rp3)) 
                            {
                                echo '<a href="Post_Content.php?id=' . $row3[0] . '" class="box">
                                        <div class="img">
                                            <img src="' . $row3[5] . '" alt="">
                                        </div>
                                        <div class="box_content">
                                            <div class="title">
                                                <h3>' . $row3[6] . '</h3>
                                            </div>
                                            <div class="userName">
                                                <h3>Time: <span>' . $row3[2] . '</span></h3>
                                            </div>
                                        </div>
                                    </a>';
                                $i++;
                                if($i == 5)
                                {
                                    break;
                                }
                            }
                        }
                    ?>
                </div>
            </div>
            
            <div class="row_sp">
                <div class="sp_column_info">
                    <div class="heading_column">
                        <H3>Giới thiệu</H3>
                    </div>
                    <div class="info">
                        <p>Chào mừng bạn đến với trang web của chúng tôi 
                            - nơi mang đến những bài viết đa dạng và cảm xúc về nhiều chủ đề giống như báo điện tử. 
                            Khám phá và cảm nhận những điều tuyệt vời mà chúng tôi chia sẻ! 
                            Cảm ơn bạn đã đồng hành cùng chúng tôi
                        </p>
                    </div>
                </div>
                <div class="sp_column_new">
                    <div class="heading_column">
                        <H3>Tin nổi bật</H3>
                    </div>
                    <?php
                        $d2 = new post();
                        $r_view = $d->get_post_view(); 
                        if(mysqli_num_rows($r_view) > 0)
                        {
                            $dem=0;
                            while($row4 = mysqli_fetch_row($r_view))
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
                                    if($dem==6)break;
                            }
                        }
                    ?>
                </div>
                <div class="sp_column_new">
                    <div class="heading_column">
                        <H3>Chủ đề hot</H3>
                    </div>
                    <?php
                        $d3 = new topic_model();
                        $r_topic_view = $d3->get_topic_view();
                        if(mysqli_num_rows($r_view) > 0)
                        {
                            $dem=0;
                            while($row5 = mysqli_fetch_row($r_topic_view))
                            {
                                echo '<div class="box_sp_title">
                                        <a href="../controller/Home_Post_Topic.php?postID='.$row5[0].'">'.$row5[1].'</a>
                                    </div>';
                                    $dem++;
                                    if($dem==6)break;
                            }
                        }
                    ?>
                </div>
                <div class="sp_column_new">
                    <div class="heading_column">
                        <H3>Liên hệ</H3>
                    </div>
                    <div class="box_sp_contact">
                        <i class="ti-mobile"></i>
                        <p>0926870380</p>
                    </div>
                    <div class="box_sp_contact">
                        <i class="ti-email"></i>
                        <p>laptrinhvuive@gmail.com</p>
                    </div>               
                    <div class="box_sp_contact">
                        <a href="" class="contact"><i style="font-size:22px;" class="ti-facebook"></i></a>
                        <a href="" class="contact"><i style="font-size:22px;" class="ti-youtube"></i></a>
                        <a href="" class="contact"><i style="font-size:22px;" class="ti-github"></i></a>
                    </div>        
                </div>
            </div>
        </div>
        <div id="footer">
            <div class="social-list">
                <a href=""><i class="ti-facebook"></i></a>
                <a href=""><i class="ti-youtube"></i></a>
                <a href=""><i class="ti-instagram"></i></a>
                <a href=""><i class="ti-pinterest"></i></a>
                <a href=""><i class="ti-twitter"></i></a>
                <a href=""><i class="ti-linkedin"></i></a>
            </div>
            <p class="copyright">Powered by <a href="" target="_blank">....</a></p>
        </div>
    </div>
</body>
</html>