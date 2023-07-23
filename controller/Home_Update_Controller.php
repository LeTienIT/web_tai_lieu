<?php
    if (!isset($_SESSION)) {
        session_start();
    }
   
    require_once "../models/UserModel.php";
    class user_update
    {
        private $userModel;
        private $pass;
        private $passID;
        private $userID;
        public function __construct()
        {
            $this->userModel = new userModel();
            $this->pass = $_POST["pass"];
            $this->userID = $_SESSION["userID"];
            $this->passID = $_SESSION["passID"];
        }
        public function check_pass()
        {
            if($this->passID===$this->pass)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        public function update()
        {
            $userName="";$userPhone="";$userEmail="";
            if($this->check_pass())
            {
                $userName = $_POST["userName"];
                $userPhone = $_POST["userPhone"];
                $userEmail = $_POST["userEmail"];
                $new_pass = $_POST["new_pass"];
                $rs = $this->userModel->update_user($this->userID,$userName,$userPhone,$userEmail,$new_pass);
                if($rs == 1)
                {
                    $notify = "Tài khoản của bạn đã cập nhật thành công.";
                    $_SESSION["check_login"] = FALSE;
                }
                else
                {
                    $notify = "Lỗi: không thể gửi dữ liệu.";
                                
                }
                // echo $rs . "<br>" . $this->userID . "<br>" . $userName . "<br>" . $new_pass;
            }
            else
            {
                $notify = "Mật khẩu hiện tại nhập không đúng. Vui lòng kiểm tra lại";
            }
            require_once("../view/Info_Account.php");
        }
    }
    $db = new user_update();
    $db->update();
?>