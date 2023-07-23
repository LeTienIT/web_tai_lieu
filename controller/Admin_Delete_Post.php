<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once("../controller/Home_getPost_Controller.php");
    $postID = $_GET['id'];
    $d = new post();
    $xl = $d->get_post_postID($postID);
    if($xl)
    {
        $row = mysqli_fetch_row($xl);
        $pathIMG = $row[5];
        $content = $row[4];
        $pattern = '/src="(.*?)"/';
        preg_match($pattern, $content, $matches);
        $imageSrc = $matches[1]; // Đường dẫn ảnh

        $folderPath = dirname($imageSrc); // Đường dẫn thư mục

        // echo "Đường dẫn thư mục: " . $folderPath;
        // echo "Đường dẫn ảnh là: " . $pathIMG;

        if (file_exists($pathIMG)) {
            unlink($pathIMG);
            echo "Xóa ảnh thành công.";
        } else {
            echo "Không tìm thấy ảnh.";
            die();
        }
        
        // Xóa thư mục
        if (is_dir($folderPath)) {
            $files = glob($folderPath . "/*");
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            rmdir($folderPath);
            echo "Xóa thư mục thành công.";
        } else {
            echo "Không tìm thấy thư mục.";
            die();
        }
    }
    $r = $d->delete_posts($postID);
    if($r == 1)
    {
        header("location: ../view/Admin.php");
    }
    else
    {
        echo "Lỗi xóa bài viết. Không thể xóa";
    }
?>