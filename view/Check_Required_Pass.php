<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once("../controller/Home_User_Controller.php");
    $requiredID = $_GET['id'];
    $db = new users();
    $rq = $db->get_user_required_id($requiredID);
    if($rq)
    {
        $rqs = mysqli_fetch_row($rq);
        $nameID = $rqs[1];
        $userName = $rqs[2];
        $userPhone = $rqs[3];
        $userEmail = $rqs[4];
        $permission = $rqs[5];
    }
    $checkID = TRUE;
    $checkValue = 0;
    $checkName="";
    if(isset($nameID))
    {
        $rn = $db->get_user_name_id($nameID);
        if($rn)
        {
            $checkValue+=20;
            $rns = mysqli_fetch_row($rn);
            if($userName == $rns[2])
            {
                $checkValue+=20;
            }
            if($userPhone == $rns[3])
            {
                $checkValue+=20;
            }
            if($userEmail == $rns[4])
            {
                $checkValue+=20;
            }
            if($permission == $rns[6])
            {
                $checkValue+=20;
            }
        }
        else
        {
            $checkID = FALSE;
            $checkName="Không tìm thấy nameID tương ứng. Thông tin yêu cầu không thể xác nhận";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../stylers/Check_Required_Pass.css">
    <link rel="stylesheet" href="../stylers/Reponsive_pass.css">
    <title>Check pass</title>
</head>
<body>
    <div class="main">
        <div class="heading">
            <h1>Kiểm tra thông tin yêu cầu quên mật khẩu</h1>
        </div>
        <div class="info_user">
            <h1>Thông tin tài khoản yêu cầu</h1>
            <div class="user_waiting_box">
                <div class="userID">
                    <p><?php echo $nameID; ?></p>
                </div>
                <div class="userName">
                    <p><?php echo $userName; ?></p>
                </div>
                <div class="userPhone">
                    <p><?php echo $userPhone; ?></p>
                </div>
                <div class="userEmail">
                    <p><?php echo $userEmail; ?></p>
                </div>
                <div class="userPermission">
                    <p><?php echo $permission; ?></p>
                </div>
            </div>
        </div>
        <div class="check">
            <h1>Thông tin tài khoản tìm kiếm được trong cơ sở dữ liệu</h1>
            <?php 
                if($checkID)
                {
                    echo '<div class="user_waiting_box">
                            <div class="userID">
                                <p>'.$rns[1].'</p>
                            </div>
                            <div class="userName">
                                <p>'.$rns[2].'</p>
                            </div>
                            <div class="userPhone">
                                <p>'.$rns[3].'</p>
                            </div>
                            <div class="userEmail">
                                <p>'.$rns[4].'</p>
                            </div>
                            <div class="userPermission">
                                <p>'.$rns[6].'</p>
                            </div>
                        </div>';
                }
                else
                {
                    echo '<h1 style="text-align:center;font-size:22px;padding:10px 0;">Khòng tìm thấy dữ liệu trong CSDL</h1>';
                }
            ?>
            
            <div class="output">
                <div class="user_pass">
                    <h3>Mật khẩu của tài khoản truy xuất được là: <span class="pass"><?php echo isset($rns[5]) ? $rns[5] : ''; ?></span></h3>
                </div>
                <?php
                    echo '<h2>Dữ liệu user xét duyệt giống<span> '.$checkValue.'%</span> dữ liệu truy xuất trong cơ sở dữ liệu</h2>';
                ?>
                <div class="box_control">
                    <?php
                        if($checkID)
                        {
                            echo '<button class="btn_option" onclick="sendEmail()">Gửi lại Pass</button>';
                        }
                    
                        echo '<a class="btn_option" href="../controller/Admin_Delete_Forgot_Pass.php?id=' . $requiredID . '">Xóa yêu cầu</a>';
                    ?>
                    <a class="btn_option" href="Admin.php">Trở về</a>
                </div>
            </div>
        </div>
    </div> 
    <script>
        function sendEmail() {
            var recipientElement = document.querySelector('.userEmail p');
            var subject = 'Xử lý yêu cầu quên mật khẩu tài khoản';
            var userIDElement = document.querySelector('.userID');
            var passElement = document.querySelector('.pass');

            var userID = userIDElement.textContent.trim(); // Lấy nội dung của phần tử .userID
            var password = passElement.textContent.trim(); // Lấy nội dung của phần tử .pass

            var body = 'Mật khẩu tài khoản: ' + userID + ' mà bạn yêu cầu đã được xử lý và xác minh. Mật khẩu hiện tại là: ' + password + '. Vui lòng không chia sẻ mật khẩu cho bất kỳ ai, và thực hiện thay đổi mật khẩu sớm nhất có thể.';
            
            var recipient = recipientElement.textContent.trim();

            var emailUrl = 'mailto:' + recipient + '?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(body);
            var tempLink = document.createElement('a');
            tempLink.href = emailUrl;
            tempLink.target = '_blank';
            tempLink.style.display = 'none';
            document.body.appendChild(tempLink);

            tempLink.click();

            document.body.removeChild(tempLink);
        }
    </script>   
</body>
</html>