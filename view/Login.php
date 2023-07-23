<?php
    if (!isset($_SESSION)) {
        session_start();
    }   
    $_SESSION["check_login"] = FALSE;
    $_SESSION["userName"] = "Client";
    $_SESSION["permissionID"] = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../stylers/Login_Styler.css">
    <link rel="stylesheet" href="../stylers/footer.css">
    <title>Trang đăng nhập</title>
</head>
<body>
    <div id="main">
        <form method="post" action="../controller/Login_Controller.php" class="form-login">
            <h2 class="heading">Đăng nhập</h2>
            <div class="box">
                <label for="user">Tên đăng nhập</label>
                <input type="text" id="user" name="user" placeholder="nameID" required class="form-control" value="<?php echo isset($user) ? $user : ''; ?>">
            </div>
            <div class="box">
                <label>Mật khẩu</label>
                <input type="password" id="pass" name="pass" placeholder="passID" required class="form-control">
            </div>
            <div class="tbao">
                <p><?php echo isset($errorMsg) ? $errorMsg : ''; ?></p>
            </div>
            <div class="box1">
                <input type="submit" class="login" name="login" value="Đăng nhập">
                <a href="../view/Add_Account.php">Đăng ký</a>
                <a href="../view/Forgot_Pass.php">Quên Pass</a>
                <a href="Home.php">Khách</a>
            </div>
        </form> 
    </div>
</body>
</html>