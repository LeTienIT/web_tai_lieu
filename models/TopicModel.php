<?php   
    class topicModel
    {
        private $host = "localhost";
        private $username = "root";
        private $pass = "";
        private $database = "web_tin_tuc";
        private $db;

        public function open_kn()
        {
            $this->db = mysqli_connect($this->host,$this->username,$this->pass,$this->database);
            if($this->db->connect_error)
            {
                die("LỖI: Không thể kêt nối đến cơ sở dữ liệu.");
            }
            else
            {
                mysqli_query($this->db,"SET NAME 'utf8'");
            }
        }
        public function get_topicID($topicID)
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT `topicName` FROM `topic` WHERE `topicID` = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("i", $topicID);
                $stmt->execute();
                $rs = $stmt->get_result();
                //$rs = mysqli_query($this->db,$sql);
                return $rs;
            } 
            catch (Throwable $th) {
                throw $th;
            }
            finally
            {
                mysqli_close($this->db);
            }
            
        }
        public function selectAllTopic()
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `topic` WHERE 1";
                $rs = mysqli_query($this->db,$sql);
                return $rs;
            } 
            catch (Throwable $th) {
                throw $th;
            }
            finally
            {
                mysqli_close($this->db);
            }
           
        }

        public function get_topic_view()
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `topic` WHERE 1 ORDER BY `view` DESC";
                $rs = mysqli_query($this->db,$sql);
                return $rs;
            } 
            catch (Throwable $th) {
                throw $th;
            }
            finally
            {
                mysqli_close($this->db);
            }
           
        }
    }
?>