<?php
    require_once "../models/UserModel.php";
    class add_account
    {
        private $db;

        public function __construct()
        {
            $this->db = new userModel();
        }
        public function add()
        {
            $notify = "";$nameID="";$userName="";$userEmail="";
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $nameID = $_POST["nameID"];
                $userName = $_POST["userName"];
                $userPhone = $_POST["userPhone"];
                $userEmail = $_POST["userEmail"];
                $passID = $_POST["passID"];
                $permissionID = $_POST["permissionID"];
                if(!$this->db->check_nameID($nameID))
                {
                    $notify = "Tên đăng nhập (nameID) của bạn đã có người sử dụng, vui lòng chọn tên khác";
                    //require_once("../view/Add_Account.php");
                }
                else
                {
                    $rs = $this->db->userAdd($nameID,$userName,$userPhone,$userEmail,$passID,$permissionID);
                    if($rs == 1)
                    {
                        $notify = "Thông tin tài khoản của bạn đã được gửi đi để xử lý. Vui lòng chờ quản trị viên Xác Nhận";
                        //require_once("../view/Add_Account.php");
                    }
                    else
                    {
                        $notify = "Lỗi: không thể tạo tài khoản mới. Tạo tại khoản mới thất bại";
                        
                    }
                }
                require_once("../view/Add_Account.php");
            }
        }
    }
    $add = new add_account();
    $add->add();
?>