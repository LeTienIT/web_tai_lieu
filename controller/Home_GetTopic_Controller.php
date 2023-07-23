<?php
    require_once "../models/TopicModel.php";
    class topic_model
    {
        private $db;
        public function __construct()
        {
            $this->db = new topicModel();
        }
        public function get_topic_id($topicID)
        {
            $rs = $this->db->get_topicID($topicID);
            return $rs;
        }
        public function getTopic()
        {
            $rs = $this->db->selectAllTopic();
            return $rs;
        }
        public function get_topic_view()
        {
            $rs = $this->db->get_topic_view();
            return $rs;
        }
    }
?>