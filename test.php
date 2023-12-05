<!-- index.php -->
<?php
    require_once("connection.php");
    // Load danh sách bài viết từ CSDL
    // $posts = getPostsFromDatabase();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Forum</title>
</head>
<body>
<div class="w3-modal" id="post-modal">
    <div class="w3-modal-content">
      <div class="w3-container w3-padding">
        <span class="w3-right w3-opacity"><i class="fa fa-times"
            onclick="document.getElementById('post-modal').style.display='none'"></i></span>
        <h3>ĐĂNG BÀI</h3>
        <label for="">Tiêu đề: <input class="w3-input w3-border w3-padding" type="text" id="post-title-inp"></label><br>
        <label for="">Link ảnh: <input class="w3-input w3-border w3-padding" type="text" id="post-img-inp"
            style="margin-bottom: 20px;"></label>
        <label for="">Nội dung: <br>
          <!-- <input class="w3-input" type="text" id="post-content-inp" style="height: 30vh;"></label> -->
          <textarea id="post-content-inp" cols="102" rows="10" class="w3-border w3-padding"></textarea>
          <button class="w3-button w3-theme" style="margin-top:20px;" onclick="dangBai()">Đăng
            bài</button><br>
      </div>
    </div>
  </div>
</body>
</html>
