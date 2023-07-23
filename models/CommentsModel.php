<?php
    class comment_model
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
        public function add_comment($postID,$userID,$userName,$content)
        {
            try 
            {
                $this->open_kn();
                $sql = "INSERT INTO `comments`(`postID`, `userID`, `userNAME`, `comment`)
                VALUES (?,?,?,?)";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("iiss", $postID, $userID, $userName, $content);
                $stmt->execute();
                //$rs = mysqli_query($this->db,$sql);
                if($stmt->affected_rows > 0)
                {
                    return 1; // Thành công
                }
                else
                {
                    return 0; // Thất bại
                }
            } 
            catch (Throwable $th) {
                throw $th;
            }
            finally
            {
                mysqli_close($this->db);
            }
           
        }
        public function get_comment($postID)
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `comments` WHERE `postID` = ? ORDER BY `commentID` DESC";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("i", $postID);
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

        public function get_all_comment()
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `comments` ORDER BY `commentID` DESC";
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
        public function delete_comment($commentID)
        {
            try 
            {
                $this->open_kn();
                $sql = "DELETE FROM `comments` WHERE `commentID` = ? ";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("i", $commentID);
                $stmt->execute();
                //$rs = $stmt->get_result();
                //$rs = mysqli_query($this->db,$sql);
                //return $rs;
                if($stmt->affected_rows > 0)
                {
                    return 1; // Thành công
                }
                else
                {
                    return 0; // Thất bại
                }
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