<?php
    class post_model
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
        public function get_post_id($postID)
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT p.postHeader, p.userName, p.postDate, t.topicName,  p.postContent 
                    FROM posts p
                    JOIN topic t ON p.postTopic = t.topicID
                    WHERE p.postID = ? AND postStatus = '1'
                    ORDER BY p.postID DESC";
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
        public function get_post_ids($postID)
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT p.postHeader, p.userName, p.postDate, t.topicName,  p.postContent ,p.postIMG,p.postTopic
                    FROM posts p
                    JOIN topic t ON p.postTopic = t.topicID
                    WHERE p.postID = ?
                    ORDER BY p.postID DESC";
                
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("i", $postID);
                $stmt->execute();
                $rs = $stmt->get_result();
                $sql2 ="UPDATE posts SET view = view + 1 WHERE postID = $postID";
                mysqli_query($this->db,$sql2);
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
        public function get_post_topic($postTopic)
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `posts` WHERE `postTopic` = ? AND postStatus = '1' ORDER BY `postID` DESC";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("i", $postTopic);
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
        public function get_post_topics($postTopic)
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT posts.postID, topic.topicName, posts.postDate, posts.userID, posts.userName, posts.postIMG, posts.postHeader
                    FROM posts
                    JOIN topic ON posts.postTopic = topic.topicID
                    WHERE posts.postTopic = ? AND posts.postStatus = '1' ORDER BY `postID` DESC";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("i", $postTopic);
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
        public function get_post_date($postDate)
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `posts` WHERE `postDate` = ? AND postStatus = '1' ORDER BY `postID` DESC";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("s", $postDate);
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
        public function get_post_all_date()
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `posts` WHERE postStatus = '1' ORDER BY `postID` DESC";
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

        public function get_post_waiting()
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT posts.postID, topic.topicName, posts.postDate, posts.userID, posts.userName, posts.postIMG, posts.postHeader
                    FROM posts
                    JOIN topic ON posts.postTopic = topic.topicID
                    WHERE posts.postStatus = 0 ORDER BY `postID` DESC";
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

        public function get_post_top_comment()
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT posts.postID, posts.postTopic, posts.postDate, posts.userID, posts.userName,
                         posts.postIMG, posts.postHeader, posts.postContent, COUNT(comments.commentID) as commentCount
                    FROM posts
                    INNER JOIN comments ON posts.postID = comments.postID
                    GROUP BY posts.postID
                    ORDER BY commentCount DESC";
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
        public function get_post_view()
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `posts` WHERE postStatus = '1' ORDER BY `view` DESC";
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
        public function get_post_topic_view($postTopic,$postID)
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `posts` WHERE (`postTopic` = ? AND `postID` != $postID) AND (postStatus = '1') ORDER BY `view` DESC";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("i", $postTopic);
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
        public function add_post($postTopic,$userID,$userName,$postImg,$postHeader,$postContent)
        {
            try 
            {
                $this->open_kn();
                $sql = "INSERT INTO `posts`(`postTopic`, `userID`, `userName`, `postIMG`, `postHeader`, `postContent`)
                VALUES (?, ?, ?, ?, ?, ?)";
        
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("isssss", $postTopic, $userID, $userName, $postImg, $postHeader, $postContent);
                $stmt->execute();
                //$rs = $stmt->get_result();
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
        public function accep_post($postID,$date_time)
        {
            try 
            {
                $this->open_kn();
                //$sql = "UPDATE `posts` SET `postDate`='$date_time',`postStatus`='1' WHERE `postID`='$postID'";
                $sql = "UPDATE `posts` SET `postDate`=?, `postStatus`='1' WHERE `postID`=?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("si", $date_time, $postID);
                $stmt->execute();
                //$rs = $stmt->get_result();
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

        public function delete_post($postID)
        {
            try 
            {
                $this->open_kn();
                $sub_sql = "DELETE FROM `comments` WHERE `postID`=?";
                $stmt1 = $this->db->prepare($sub_sql);
                $stmt1->bind_param("i", $postID);
                $stmt1->execute();

                $sql = "DELETE FROM `posts` WHERE `postID`=?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("i", $postID);
                $stmt->execute();
                //$rs = $stmt->get_result();
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

    }
?>