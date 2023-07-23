<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once("../controller/Home_User_Controller.php");
    if(!($_SESSION["check_login"]) || !isset($_SESSION['check_login']))
    {
        header("location: Login.php");
        exit();
    }
    $userID = $_GET['id'];
    $db = new users();
    $rs = $db->get_user_ID($userID);
    if(isset($_SESSION["Edit_account"]))
    {
        $notify = $_SESSION["Edit_account"];
        unset($_SESSION["Edit_account"]);
    }
    else
    {
        $notify = "";
    }
    if($rs)
    {
        $row = mysqli_fetch_row($rs);
    }
    else
    {
        $notify = "Lấy thông tin thất bại";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../stylers/Admin_Edit_Account.css">
    <title>Quản lý tài khoản</title>
</head>
<body>
    <div id="main">
        <form method="post" action="../controller/Admin_Edit_User.php" class="form-new">
            <h2 class="heading">Thônng tin tài khoản</h2>
            <input type="hidden" name="userID" VALUE = "<?php echo isset($row[0]) ? $row[0]: ''; ?>">
            <div class="box">
                <label for="user">Tên đăng nhập (nameID)</label>
                <input class="readonly" type="text" id="user" name="nameID" placeholder="letien2k2" readonly VALUE = "<?php echo isset($row[1]) ? $row[1]: ''; ?>">
            </div>
            <div class="box">
                <label for="user">Tên tài khoản</label>
                <input class="readonly" type="text" id="user" name="userName" placeholder="Lê Đắc Tiến" readonly VALUE = "<?php echo isset($row[2]) ? $row[2]: ''; ?>">
            </div>
            <div class="box">
                <label for="user">Số điện thoại</label>
                <input class="readonly" type="text" id="user" name="userPhone" placeholder="0926870380" readonly VALUE = "<?php echo isset($row[3]) ? $row[3]: ''; ?>">
            </div>
            <div class="box">
                <label for="user">Email</label>
                <input class="readonly" type="text" id="user" name="userEmail" placeholder="ledactien2002@gmail.com" readonly VALUE = "<?php echo isset($row[4]) ? $row[4]: ''; ?>">
            </div>
            <div class="box">
                <label for="user">Mật khẩu (passID)</label>
                <input class="readonly" type="Password" id="user" name="passID" placeholder="passID" readonly VALUE="<?php echo isset($row[5]) ? $row[5]: ''; ?>">
            </div>
            <div class="box">
                <label for="user">Mức quyền</label>
                <select id="user" name="permissionID" class="cbbOption">
                    <option value="0" <?php if (isset($row[6]) && (0 == $row[6])) echo 'selected'; ?>>0</option>
                    <option value="1" <?php if (isset($row[6]) && (1 == $row[6])) echo 'selected'; ?>>1</option> 
                    <option value="2" <?php if (isset($row[6]) && (2 == $row[6])) echo 'selected'; ?>>2</option> 
                    <option value="3" <?php if (isset($row[6]) && (3 == $row[6])) echo 'selected'; ?>>3</option> 
                    <option value="4" <?php if (isset($row[6]) && (4 == $row[6])) echo 'selected'; ?>>4</option> 
                </select>
            </div>
            <div class="box">
                <label for="user">Trạng thái tài khoản</label>
                <select id="user" name="accountStatus" class="cbbOption">
                    <option value="0" <?php if (isset($row[7]) && (0 == $row[7])) echo 'selected'; ?>>Chờ xét duyệt</option>
                    <option value="1" <?php if (isset($row[7]) && (1 == $row[7])) echo 'selected'; ?>>Đang hoạt động</option> 
                </select>
            </div>
            <div class="notify">
                <p><?php echo isset($notify) ? $notify: ''; ?></p>
            </div>
            <div class="box1">
                <input type="submit" class="btn" name="insert" value="Cập nhật">
                <a href="Admin.php" class="btn">Trở về</a>
            </div>
            <div class="clear"></div>
        </form>
        <div class="tb_permission">
            <h1>Bảng phân quyền</h1>
            <table>
                <tr>
                    <th>Mức Quyền</th>
                    <th>Chức năng</th>
                </tr>
                <tr>
                    <td>0</td>
                    <td>Chỉ Xem</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Mức 0 + Đăng bài</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Mức 1 + Duyệt Bài</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Mức 2 + Kiểm duyệt tài khoản</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Mức 3 + Quản lý bài và comment</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Mức 4 + Quản lý tài khoản</td>
                </tr>
            </table>

        </div>
    </div>
</body>
</html>