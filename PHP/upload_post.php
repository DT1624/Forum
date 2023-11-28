<?php
    require_once("connection.php");
    session_start();    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $post_title = $_POST["post_title"];
        $post_description = $_POST["post_description"];
        $groupID = $_POST["select_group"];
        $postID = 'PID'.str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);
        $userIDPost = $_SESSION["userID"];
        $target_file = '';
        
        if (isset($_FILES["file"])) {
            $file_name = $_FILES["file"]["name"];
            $file_tmp = $_FILES["file"]["tmp_name"];
            $file_size = $_FILES["file"]["size"]; 

            $upload_directory = "imagesPost/";

            // Generate a unique filename using timestamp and original file extension
            $new_filename = $postID . '.' . pathinfo($file_name, PATHINFO_EXTENSION);

            $target_file = $upload_directory . $new_filename;

            if ($file_size > 0 && move_uploaded_file($file_tmp, $target_file)) {
                $file = $target_file;
            } else {
                echo "Failed to upload file.";
            }
        }

        $stmt = $conn->prepare("INSERT INTO posts (postID, userIDPost, groupIDPost, tittlePost, descriptionPost, imagePost) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $postID, $userIDPost, $groupID, $post_title, $post_description, $file);
        $result = $stmt->execute();

        if ($result) {
            $_SESSION['message'] = "Đăng bài thành công!";
        } else {
            $_SESSION['message'] = "Lỗi khi đăng bài: " . $stmt->error;
        }
        $stmt->close();
        header("Location: forum.php");
        exit();
    }
?>
