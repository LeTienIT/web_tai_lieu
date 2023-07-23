<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if(!($_SESSION["check_login"]) || !isset($_SESSION['check_login']))
    {
        header("location: ../view/Login.php");
        exit();
    }
    require_once "../models/UserModel.php";
    $userID = $_SESSION["userID"];
    $userName = $_SESSION["userName"];
    $db = new userModel();
    $r = $db->get_user_id($userID);
    if($r)
    {
        $row = mysqli_fetch_row($r);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../stylers/Add_Account.css">
    <title>Thông tin tài khoản</title>
</head>
<body>
<div id="main">
        <form method="post" action="../controller/Home_Update_Controller.php" class="form-new">
            <h2 class="heading">Cập nhật thông tin tài khoản</h2>
            <div class="box">
                <label for="user">Tên tài khoản</label>
                <input type="text" id="user" name="userName" placeholder="" required VALUE = "<?php echo $userName; ?>">
            </div>
            <div class="box">
                <label for="user">Số điện thoại</label>
                <input type="text" id="user" name="userPhone" placeholder="<?php echo isset($row[3]) ? $row[3]: ''; ?>" required VALUE = "<?php echo isset($row[3]) ? $row[3]: ''; ?>">
            </div>
            <div class="box">
                <label for="user">Email</label>
                <input type="text" id="user" name="userEmail" placeholder="<?php echo isset($row[4]) ? $row[4]: ''; ?>" VALUE = "<?php echo isset($row[4]) ? $row[4]: ''; ?>">
            </div>
            <div class="box">
                <label for="user">Mật khẩu hiện tại</label>
                <input type="password" id="user" name="pass" placeholder="Pass" required>
            </div>
            <div class="box">
                <label for="user">Mật khẩu mới</label>
                <input type="password" id="user" name="new_pass" required placeholder="new pass">
            </div>
            <div class="notify">
                <p><?php echo isset($notify) ? $notify: ''; ?></p>
            </div>
            <div class="box1">
                <input type="submit" class="btn" name="insert" value="Cập nhật">
                <a href="../view/Home.php" class="btn">Trở về</a>
            </div>
            <div class="clear"></div>
        </form>
    </div>
</body>
</html>