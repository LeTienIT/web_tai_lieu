<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once("../controller/Home_GetTopic_Controller.php");
    if(!($_SESSION["check_login"]) || !isset($_SESSION['check_login']))
    {
        header("location: Login.php");
        exit();
    }
    $userID = $_SESSION["userID"];
    $userName = $_SESSION["userName"];
    $permissionID = $_SESSION["permissionID"];
    $db = new topic_model();
    $rs = $db->getTopic();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../stylers/Add_Post.css">
    <link rel="stylesheet" href="../stylers/Reponsive_Add_Post.css">
    <title>Tạo bài đăng</title>
</head>
<body>
    <div id="main">
        <form action="../controller/Home_Add_Post_Controller.php" method="post" enctype="multipart/form-data" class="form-new">
            <h1 class="heading">Tạo bài đăng mới</h1>
            <div class="title">
                <label for="td">Tiêu đề </label>
                <textarea name="title" id="td" cols="50" rows="3"></textarea>
            </div>
            <div class="img">
                <label for="">Ảnh tiêu đề</label>
                <input type="file" name="image_title" id="file-input" VALUE="Chọn file">
            </div>
            <div class="menu_topic">
                <p class="">Chủ đề </p> 
                <select id="user" name="postTopic" class="cbb_option">
                    <?php
                        while($row = mysqli_fetch_row($rs))
                        {
                            echo '<option value="'.$row[0].'"> '.$row[1].' </option>';
                        }
                    ?>
                </select>
            </div>
            <div class="content">
                <h3>Soạn thảo nội dung bài viết</h3>
                <!-- <h3 style="padding:0;font-size:12px;color:red;">(Nên soạn trước trên word rồi copy vào đây)</h3> -->
                <textarea name="content" id="editor"></textarea>
            </div>
            <p class="announce"><?php echo isset($notify) ? $notify: ''; ?></p>  
            <div class="btn">
                <input type="submit" name="submit" class="btn_submit" value="Đăng bài">
                <a href="../view/Admin.php" class="btn_submit">Trở về</a>
            </div> 
            
        </form>
    </div>
    <script src="../js/tinymce/tinymce.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#editor',
            plugins: 'image',
            toolbar: 'image',
            height: 600,
            file_picker_callback: function (callback, value, meta) {
                if (meta.filetype === 'image') {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function () {
                        var file = this.files[0];
                        var reader = new FileReader();
                        reader.onload = function () {
                            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                            var base64 = reader.result.split(',')[1];
                            var blobInfo = blobCache.create(file.name, file, base64);
                            blobCache.add(blobInfo);

                            callback(blobInfo.blobUri(), { title: file.name });
                        };
                        reader.readAsDataURL(file);
                    };

                    input.click();
                }
            }
        }); 
    </script>
</body>
</html>
