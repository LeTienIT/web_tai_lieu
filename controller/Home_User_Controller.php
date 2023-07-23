<?php
    require_once "../models/UserModel.php";
    class users
    {
        private $db;
        public function __construct()
        {
            $this->db = new userModel();
        }
        public function accep_users($userID)
        {
            $rs = $this->db->accep_user($userID);
            return $rs;
        }
        public function delete_users($userID)
        {
            $rs = $this->db->delete_user($userID);
            return $rs;
        }

        public function get_user_required_id($requiredID)
        {
            $rs = $this->db->get_user_forgot_pass_id($requiredID);
            return $rs;
        }

        public function get_user_name_id($nameID)
        {
            $rs = $this->db->get_user_nameID($nameID);
            return $rs;
        }

        public function delete_users_forgot_pass($requiredID)
        {
            $rs = $this->db->delete_user_forgot_pass($requiredID);
            return $rs;
        }

        public function get_user_ID($userID)
        {
            $rs = $this->db->get_user_id($userID);
            return $rs;
        }
        public function edit_user_ID($userID,$permissionID,$accountStatus)
        {
            $rs = $this->db->Edit_user_id($userID,$permissionID,$accountStatus);
            return $rs;
        }
    }
?>