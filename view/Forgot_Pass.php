<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../stylers/Add_Account.css">
    <title>Yêu cầu lấy mật khẩu</title>
</head>
<body>
<div id="main">
        <form method="post" action="../controller/Login_Forgot_Pass_Controller.php" class="form-new">
            <h2 class="heading">Nhập chính xác thông tin về tài khoản</h2>
            <div class="box">
                <label for="user">Tên đăng nhập</label>
                <input type="text" id="user" name="nameID" placeholder="loginID" required VALUE = "<?php echo isset($nameID) ? $nameID: ''; ?>">
            </div>
            <div class="box">
                <label for="user">Tên tài khoản</label>
                <input type="text" id="user" name="userName" placeholder="Lê T" required VALUE = "<?php echo isset($userName) ? $userName: ''; ?>">
            </div>
            <div class="box">
                <label for="user">Số điện thoại</label>
                <input type="text" id="user" name="userPhone" placeholder="0123456789" required VALUE = "<?php echo isset($userPhone) ? $userPhone: ''; ?>">
            </div>
            <div class="box">
                <label for="user">Email</label>
                <input type="text" id="user" name="userEmail" placeholder="email@gmai.com" VALUE = "<?php echo isset($userEmail) ? $userEmail: ''; ?>">
            </div>
            <div class="box">
                <label for="user">Quyền</label>
                <select id="user" name="permissionID" class="cbbOption">
                    <option value="0">Không</option>
                    <option value="1">Viết bài</option> 
                    <option value="-1">Quyền khác</option> 
                </select>
            </div>
            <div class="notify">
                <p><?php echo isset($notify) ? $notify: ''; ?></p>
            </div>
            <div class="box1">
                <input type="submit" class="btn" name="insert" value="Yêu cầu">
                <a href="../view/Login.php" class="btn">Trở về</a>
            </div>
            <div class="clear"></div>
        </form>
    </div>
</body>
</html>