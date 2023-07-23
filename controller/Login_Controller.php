<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    //$_SESSION["check_login"] = FALSE;
    require_once "../models/UserModel.php";
    class login_controller
    {
        private $userModel;

        public function __construct()
        {
            $this->userModel = new userModel();
        }
        public function login()
        {
            $user = "";$errorMsg="";
            if($_SERVER["REQUEST_METHOD"] === "POST")
            {
                $user = $_POST["user"];
                $pass = $_POST["pass"];

                $rs = $this->userModel->userLogin($user,$pass);
                $counts = $rs->num_rows;
                if($counts == 1)
                {
                    $row = mysqli_fetch_row($rs);
                    $accountStatus = $row[7];
                    if($accountStatus == 0)
                    {
                        $errorMsg = "Tài khoản của bạn hiên đang trong quá trình xử lý. Hãy đợi để người quản trị Xác Nhận";
                        require_once("../view/Login.php");
                    }
                    else
                    {
                        $_SESSION["userID"] = $row[0];
                        $_SESSION["userName"] = $row[2];
                        $_SESSION["passID"] = $row[5]; 
                        $_SESSION["permissionID"] = $row[6];
                        $_SESSION["check_login"] = TRUE;
                        $errorMsg = "";
                        header("Location: ../view/Admin.php");
                    }
                }
                else
                {
                    $errorMsg = "Tài khoản hoặc mật khẩu không chính xác, hãy kiểm tra lại.";
                    require_once("../view/Login.php");
                }
            }
        }
    }
    $loginc =  new login_controller();
    $loginc->login();
?>