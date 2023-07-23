<?php
    class userModel{
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
        public function userLogin($userID, $passID)
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `player` WHERE `nameID` = ? AND `passID` = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("ss", $userID, $passID);
                $stmt->execute();
                $rs = $stmt->get_result();
                return $rs;
            } 
            catch (Throwable $th) {
                throw $th;
            }
            finally
            {
                $stmt->close();
                mysqli_close($this->db);
            }
        }

        public function user_waiting()
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `player` WHERE `accountStatus` = '0'";
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
        public function all_user()
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `player` WHERE `accountStatus` = '1' AND `userID` != '1'";
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
        public function check_nameID($nameID)
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `player` WHERE `nameID` = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("s", $nameID);
                $stmt->execute();
                $rs = $stmt->get_result();
                //$rs = mysqli_query($this->db,$sql);
                if($rs->num_rows > 0)
                {
                    return false;
                }
                else
                {
                    return true;
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
        public function userAdd($nameID, $userName, $userPhone, $userEmail, $passID, $permissionID)
        {
            try 
            {
                $this->open_kn();
                $sql = "INSERT INTO `player`(`nameID`, `userName`, `userPhone`, `userEmail`, `passID`, `permissionID`)
                        VALUES (?, ?, ?, ?, ?, ?)";
                        
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("sssssi", $nameID, $userName, $userPhone, $userEmail, $passID, $permissionID);
                
                $stmt->execute();
                
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
                $stmt->close();
                mysqli_close($this->db);
            }
        }

        public function get_user_forgot_pass()
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `password_required`";
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
        public function get_user_nameID($nameID)
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `player` WHERE `nameID` =?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("s", $nameID);
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
        public function get_user_forgot_pass_id($requiredID)
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `password_required` WHERE `requiredID` = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("i", $requiredID);
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
        public function delete_user_forgot_pass($requiredID)
        {
            try 
            {
                $this->open_kn();
                $sql = "DELETE FROM `password_required` WHERE `requiredID` = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("i", $requiredID);
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
        public function check_forgot_pass($nameID)
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `password_required` WHERE `nameID` = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("s", $nameID);
                $stmt->execute();
                $rs = $stmt->get_result();
                //$rs = mysqli_query($this->db,$sql);
                if($rs->num_rows > 0)
                {
                    return false;
                }
                else
                {
                    return true;
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
        public function add_forgot_pass($nameID, $userName, $userPhone, $userEmail, $permissionID)
        {
            try 
            {
                $this->open_kn();
                $sql = "INSERT INTO `password_required`(`nameID`, `userName`, `userPhone`, `userEmail`, `permissionID`)
                        VALUES (?, ?, ?, ?, ?)";
                        
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("ssssi", $nameID, $userName, $userPhone, $userEmail, $permissionID);
                
                $stmt->execute();
                
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
                $stmt->close();
                mysqli_close($this->db);
            }
        }

        public function update_user($userID, $userName, $userPhone, $userEmail, $passID)
        {
            try 
            {
                $this->open_kn();
                $sql = "UPDATE `player` SET `userName` = ?, `userPhone` = ?, `userEmail` = ?, `passId` = ? WHERE `userID` = ?";
                        
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("ssssi", $userName, $userPhone, $userEmail, $passID, $userID);
                
                $stmt->execute();
                
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
                $stmt->close();
                mysqli_close($this->db);
            }
        }

        public function accep_user($userID)
        {
            try 
            {
                $this->open_kn();
                $sql = "UPDATE `player` SET `accountStatus`='1' WHERE `userID`=?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("i", $userID);
                $stmt->execute();
                //$rs = $stmt->get_result();
                //$rs = mysqli_query($this->db,$sql);
                if($stmt->affected_rows > 0)
                {
                    return 1;
                }
                else
                {
                    return 0;
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
        public function delete_user($userID)
        {
            try 
            {
                $this->open_kn();
                $sql = "DELETE FROM `player` WHERE `userID`=?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("i", $userID);
                $stmt->execute();
                //$rs = $stmt->get_result();
                //$rs = mysqli_query($this->db,$sql);
                if($stmt->affected_rows > 0)
                {
                    return 1;
                }
                else
                {
                    return 0;
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
        public function get_user_id($userID)
        {
            try 
            {
                $this->open_kn();
                $sql = "SELECT * FROM `player` WHERE `userID`=?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("i", $userID);
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
        public function Edit_user_id($userID,$permissionID,$accountStatus)
        {
            try 
            {
                $this->open_kn();
                $sql = "UPDATE `player` SET `permissionID` = ?, `accountStatus` = ? WHERE `userID` = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("iii", $permissionID, $accountStatus, $userID);
                $stmt->execute();
                //$rs = $stmt->get_result();
                //$rs = mysqli_query($this->db,$sql);
                if($stmt->affected_rows > 0)
                {
                    return 1;
                }
                else
                {
                    return 0;
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