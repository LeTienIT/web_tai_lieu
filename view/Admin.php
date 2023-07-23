<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once("../controller/Home_GetTopic_Controller.php");
    require_once("../controller/Home_getPost_Controller.php");
    if(!($_SESSION["check_login"]) || !isset($_SESSION['check_login']) || ($_SESSION["permissionID"] == 0))
    {
        header("location: Login.php");
        exit();
    }
    $userName = $_SESSION["userName"];
    $permissionID = $_SESSION["permissionID"];
    $_SESSION["last_page"] = "Admin.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../fonts/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../stylers/Admin.css">
    <link rel="stylesheet" href="../stylers/Reponsive_Admin.css">
    <title>ADMIN</title>
</head>
<body>
    <div id="main">
        <div class="main_control">
            <div class="user">
                <div class="name">
                    <h3><?php echo $userName; ?></h3>
                </div>
                <div class="permission">
                    <h3>Quyền: <span><?php echo $permissionID; ?></span></h3>
                </div>
                <div class="list_menu">
                    <Button id="l_menu" onclick="toggleListMenu()">
                        <i class="ti-view-list"></i>
                    </Button>
                </div>
            </div>
            <div class="control">
                <?php 
                     if($permissionID == 1) 
                     {
                        echo '<a class="btn" href="Add_Post.php">Tạo bài viết</a>';
                     }
                    if($permissionID == 2) 
                    {
                        echo '<a class="btn" href="Add_Post.php">Tạo bài viết</a>
                        <button class="btn" id="post_waiting">Duyệt bài</button>';
                    }
                    else if($permissionID == 3)
                    {
                        echo '<a class="btn" href="Add_Post.php">Tạo bài viết</a>
                        <button class="btn" id="post_waiting">Duyệt bài</button>
                        <button class="btn" id="user_waiting">Duyệt tài khoản</button>
                        <button class="btn" id="user_pass">Yêu cầu mật khẩu</button>';
                    }
                    else if($permissionID == 4)
                    {
                        echo '<a class="btn" href="Add_Post.php">Tạo bài viết</a>
                        <button class="btn" id="post_waiting">Duyệt bài</button>
                            <button class="btn" id="user_waiting">Duyệt tài khoản</button>
                            <button class="btn" id="user_pass">Yêu cầu mật khẩu</button>
                            <button class="btn" id="posts">Quản lý bài viết</button>
                            <button class="btn" id="comments">Quản lý comment</button>';
                    }
                    else if($permissionID == 5)
                    {
                        echo '<a class="btn" href="Add_Post.php">Tạo bài viết</a>
                        <button class="btn" id="post_waiting">Duyệt bài</button>
                            <button class="btn" id="user_waiting">Duyệt tài khoản</button>
                            <button class="btn" id="user_pass">Yêu cầu mật khẩu</button>
                            <button class="btn" id="posts">Quản lý bài viết</button>
                            <button class="btn" id="comments">Quản lý comment</button>
                            <button class="btn" id="users">Quản lý tài khoản</button>';
                    }
                ?>
                <a class="btn" href="Home.php">Home</a>
                <a class="btn" href="../controller/Home_Logout_Controller.php">Đăng xuất</a>
            </div>
        </div>
        <div class="main_content">
           
        </div>
    </div>
    <script>
        function hienthiMenu(){
            if (window.innerWidth > 1028) {
                var listMenuElement = document.querySelector('.control');
                listMenuElement.style.display = 'block';
            }
        }
        window.addEventListener('resize', function() {
            hienthiMenu();
        });
    </script>
    <script>
        
        function toggleListMenu() {
            var listMenuElement = document.querySelector('.control');
            if (listMenuElement.style.display === 'none' || listMenuElement.style.display === '') {
                listMenuElement.style.display = 'block'; 
            } else {
                listMenuElement.style.display = 'none';
            }
        }   

        function closeMenu() {
            var listMenuElement = document.querySelector('.control');
            listMenuElement.style.display = 'none';  
        }

    </script>
    <script>
        var buttons = document.getElementsByClassName('btn');
        if(buttons.length > 0)
        {
            for (var i = 0; i < buttons.length; i++) 
            {
                buttons[i].addEventListener('click', function() 
                {
                    for (var j = 0; j < buttons.length; j++) {
                        buttons[j].classList.remove('active');
                    }
                    this.classList.add('active');
                });
            }
        }
    </script>
    <script src="../Jquery/code.jquery.com_jquery-3.4.1.min.js"> </script>
    <script>
        $(document).ready(function() { 
            var selectedButton = localStorage.getItem('selectedButton');

            $("#post_waiting").click(function() {
                if (window.innerWidth <= 1028) {
                    closeMenu();
                }
                localStorage.setItem('selectedButton', 'post_waiting');
                $.ajax({
                    url: "../controller/Admin_Get_Post_Waiting.php", 
                    method: "GET",
                    success: function(response) {
                        $(".main_content").html(response);
                    }
                });
            });
        
            $("#user_waiting").click(function() {
                if (window.innerWidth <= 1028) {
                    closeMenu();
                }
                localStorage.setItem('selectedButton', 'user_waiting');
                $.ajax({
                    url: "../controller/Admin_Get_User_Waiting.php", 
                    method: "GET",
                    success: function(response) {
                        $(".main_content").html(response);
                    }
                });
            });

            $("#user_pass").click(function() {
                if (window.innerWidth <= 1028) {
                    closeMenu();
                }
                localStorage.setItem('selectedButton', 'user_pass');
                $.ajax({
                    url: "../controller/Admin_Get_User_Forgot_Pass.php", 
                    method: "GET",
                    success: function(response) {
                        $(".main_content").html(response);
                    }
                });
            });

            $("#posts").click(function() {
                if (window.innerWidth <= 1028) {
                    closeMenu();
                }
                localStorage.setItem('selectedButton', 'posts');
                $.ajax({
                    url: "../controller/Admin_Manage_Post_Controller.php",
                    type: "GET",
                    success: function(response) {
                        $(".main_content").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
            $("body").on("submit", "form.post_option_title", function(event) {
                event.preventDefault();  //topicID=2&submits=Tìm
                var selectElement = document.getElementById("user");
                var selectedValue = parseInt(selectElement.value, 10);
                $.ajax({
                    url: "../controller/Admin_Manage_Post_Controller.php?topicID=" + selectedValue + "&submits=Tìm",
                    type: "GET",
                    success: function(response) {
                        $(".main_content").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });

            $("#comments").click(function() {
                if (window.innerWidth <= 1028) {
                    closeMenu();
                }
                localStorage.setItem('selectedButton', 'comments');
                $.ajax({
                    url: "../controller/Admin_Manage_Comments.php",
                    type: "GET",
                    success: function(response) {
                        $(".main_content").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });

            $("#users").click(function() {
                if (window.innerWidth <= 1028) {
                    closeMenu();
                }
                localStorage.setItem('selectedButton', 'users');
                $.ajax({
                    url: "../controller/Admin_Manage_Account.php",
                    type: "GET",
                    success: function(response) {
                        $(".main_content").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });

            if (selectedButton) 
            {
                $("#" + selectedButton).trigger('click');
            }
            else
            {
                $("#post_waiting").trigger('click');
            }
        }); 
     </script>
</body>
</html>