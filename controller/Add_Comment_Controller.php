<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once "../models/CommentsModel.php";
    class comment
    {
        private $postID;
        private $userID;
        private $userName;
        private $content;
        private $db;
        public function __construct()
        {
            $this->postID = $_POST["postID"];
            $this->userID = $_SESSION["userID"];
            $this->userName = $_SESSION["userName"];
            $this->content = $_POST["ct_comment"];
            $this->db = new comment_model();
        }
        public function add_cm()
        {
            $rs = $this->db->add_comment($this->postID,$this->userID,$this->userName,$this->content);
            if($rs == 1)
            {
                header('Location: ../view/Post_Content.php?id=' .$this->postID . '#comments');
            }
            else
            {
                echo '<h1 style="font-size: 20px;color: red;text-align:center;padding:20px 10%;">Lỗi thêm nội dung</h1>';
            }
        }
    }
    $add = new comment();
    $add->add_cm()
?>