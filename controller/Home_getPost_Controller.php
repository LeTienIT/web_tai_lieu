<?php
    require_once "../models/PostModel.php";
    class post
    {
        private $db;
        public function __construct()
        {
            $this->db = new post_model();
        }
        public function get_post_postID($postID)
        {
            $rs = $this->db->get_post_ids($postID);
            return $rs;
        }
        public function get_post_Topic($postTopic)
        {
            $rs = $this->db->get_post_topic($postTopic);
            return $rs;
        }
        public function get_post_Date()
        {
            $postDate = date("Y-m-d");
            $rs = $this->db->get_post_date($postDate);
            return $rs;
        }
        public function get_post_all()
        {
            $rs = $this->db->get_post_all_date();
            return $rs;
        }
        public function get_post_comment()
        {
            $rs = $this->db->get_post_top_comment();
            return $rs;
        }
        public function get_post_view()
        {
            $rs = $this->db->get_post_view();
            return $rs;
        }
        public function get_post_topic_view($postTopic,$postID)
        {
            $rs = $this->db->get_post_topic_view($postTopic,$postID);
            return $rs;
        }
        public function accep_posts($postID,$date_time)
        {
            $rs = $this->db->accep_post($postID,$date_time);
            return $rs;
        }
        public function delete_posts($postID)
        {
            $rs = $this->db->delete_post($postID);
            return $rs;
        }
    }
?>