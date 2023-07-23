<?php
    require_once "../models/UserModel.php";
    class forgot_pass
    {
        private $db;

        public function __construct()
        {
            $this->db = new userModel();
        }
        public function request()
        {
            $notify = "";$nameID="";$userName="";$userEmail="";
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $nameID = $_POST["nameID"];
                $userName = $_POST["userName"];
                $userPhone = $_POST["userPhone"];
                $userEmail = $_POST["userEmail"];
                $permissionID = $_POST["permissionID"];
                if($this->db->check_nameID($nameID))
                {
                    $notify = "Tên đăng nhập (nameID) không có trong cơ sở dữ liệu. Hãy chắc chắn bạn không nhập sai";
                    //require_once("../view/Add_Account.php");
                }
                else
                {
                    if(!$this->db->check_forgot_pass($nameID))
                    {
                        $notify = "Tên đăng nhập (nameID) đã có trong danh sách chờ xử lý. Vui lòng đợi";
                        //require_once("../view/Add_Account.php");
                    }
                    else
                    {
                        $rs = $this->db->add_forgot_pass($nameID,$userName,$userPhone,$userEmail,$permissionID);
                        if($rs == 1)
                        {
                            $notify = "Thông tin tài khoản của bạn đã được gửi đi để xử lý. Vui lòng chờ quản trị viên Xác Nhận";
                                //require_once("../view/Add_Account.php");
                        }
                        else
                        {
                            $notify = "Lỗi: không thể gửi dữ liệu.";
                                
                        }
                    }
                }
                
                
                require_once("../view/Forgot_Pass.php");
            }
        }
    }
    $add = new forgot_pass();
    $add->request();
?>