<?php
    require_once "../models/PostModel.php";
    class add_post
    {
        private $postTopic;
        private $userID ;
        private $userName ;
        private $postHeader ;
        private $img_sql;
        //private $imgHeader = $_FILES["image_title"]["name"];    
        private $content ;
        private $db;
        public function __construct()
        {
            session_start();
            $this->userID = $_SESSION["userID"];
            $this->userName = $_SESSION["userName"];
            $this->postTopic = $_POST["postTopic"];
            $this->postHeader = $_POST["title"];
            $this->content = $_POST['content'];
            $this->db = new post_model();

        }

        public function save_img_header()
        {
            $uploadDirectory = "../post_img_title/";
            $imageName = uniqid() . '.' . pathinfo($_FILES["image_title"]["name"], PATHINFO_EXTENSION);

            $tmpImagePath = $_FILES["image_title"]["tmp_name"];

            $destinationPath = $uploadDirectory . $imageName;
            if (move_uploaded_file($tmpImagePath, $destinationPath)) {
                $imagePath = str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', $destinationPath);
                $this->img_sql = $imagePath;
                return true;
            } 
            else 
            {
                return false;
            }
        }

        public function handle_content()
        {
            $folderName = uniqid();
            $uploadPath = '../post_img_content/' . $folderName . '/';
            if (!mkdir($uploadPath, 0777, true)) {
                die("Không thể tạo thư mục lưu trữ ảnh");
            }
            $this->content = html_entity_decode($this->content);

            preg_match_all('/<img[^>]+src="([^"]+)"/', $this->content, $matches);
            $imageUrls = $matches[1];

            foreach ($imageUrls as $imageUrl) {
                $imageUrl = html_entity_decode($imageUrl);
                //echo $imageUrl;echo "<br>";
                $imageName = uniqid() . '.jpg';
                $imagePath = $uploadPath . $imageName;

                if (strpos($imageUrl, "data:image") === 0) {
                    // Ảnh được chọn từ máy tính
                    $base64Image = substr($imageUrl, strpos($imageUrl, ",") + 1);
                    $imageData = base64_decode($base64Image);
                    file_put_contents($imagePath, $imageData);
        
                    $newImageUrl = $uploadPath . $imageName;
                    $this->content = str_replace($imageUrl, $newImageUrl, $this->content);
                }
                else
                {
                    // Kiểm tra trạng thái HTTP của đường dẫn ảnh trước khi tải về
                    $ch = curl_init($imageUrl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    if ($httpCode === 200) {
                        // Tải ảnh từ đường dẫn tạm thời và lưu vào thư mục mới
                        $fp = fopen($imagePath, 'wb');
                        $ch = curl_init($imageUrl);
                        curl_setopt($ch, CURLOPT_FILE, $fp);
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_exec($ch);
                        curl_close($ch);
                        fclose($fp);

                        $newImageUrl = $uploadPath . $imageName;
                        $this->content = str_replace($imageUrl, $newImageUrl, $this->content);
                        // echo $newImageUrl;
                        // echo $this->content;
                    }
                }
                
            }
            return true;
        }


        public function more_posts()
        {
            $notify = "";
            if($this->save_img_header())
            {
                $this->handle_content();
                $rs = $this->db->add_post($this->postTopic,$this->userID,$this->userName,$this->img_sql,$this->postHeader,$this->content);
                if($rs == 1)
                {
                    $notify = "Bài viết đã được đăng tải thành công. Hãy chờ đợi xác nhận từ người Quản Trị"; 
                }
                else
                {
                    $notify = "Xảy ra lỗi, bài viết đăng tải thất bại. Vui lòng thử lại sau hoặc liên hệ người Quản trị";
                }
                require_once("../view/Add_Post.php");
           }
           else
           {
                $notify = "Ảnh tiêu đề không được trống. Hãy chọn một tệp hình ảnh làm ảnh tiêu đề"; 
                require_once("../view/Add_Post.php");
           }
        } 
    }  
    $d = new add_post();
    $d->more_posts();
?>