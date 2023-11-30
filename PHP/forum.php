<?php
session_start();

if (isset($_SESSION['message'])) {
  echo "<script>alert('" . $_SESSION['message'] . "');</script>";
  unset($_SESSION['message']); // Xóa thông báo sau khi sử dụng
}
// session_destroy();
?>
<!DOCTYPE html>
<html>

<head>
  <title>UET Forum</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="post.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue.css">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="icon" type="png" href="images/uet.png"> 
  <style>
    html,
    body,
    h1,
    h2,
    h3,
    h4,
    h5 {
      font-family: "Open Sans", sans-serif
    }
  </style>
</head>

<body class="w3-theme-l5">
  <div class="w3-modal" id="post-modal">
    <div class="w3-modal-content">

      <div class="w3-container w3-padding">
        <span class="w3-right w3-opacity"><i class="fa fa-times" onclick="document.getElementById('post-modal').style.display='none'"></i></span>
        <form class="form1" action="upload_post.php" method="post" enctype="multipart/form-data">
          <label class="label1" for="post_title">Title:</label>
          <input class="input1" type="text" name="post_title" placeholder="Title" required><br>

          <label class="label1" for="post_description">Description:</label>
          <textarea class="myTexttarea" id="myTextarea" name="post_description" required></textarea><br>

          <label class="label1" for="group_post">Group:</label><br>
          <?php
          require_once("connection.php");
          $sql = "SELECT groupID, categoryGroup FROM groupss";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            echo '<select id="group" name="select_group">';

            while ($row = $result->fetch_assoc()) {
              $groupID = htmlspecialchars($row["groupID"]);
              $categoryGroup = htmlspecialchars($row["categoryGroup"]);
              echo '<option value="' . $groupID . '">' . $categoryGroup . '</option>';
            }

            echo '</select>';
          } else {
            echo "No data found";
          }
          ?>

          <br><br><label class="label1" for="file">Upload Image:</label>
          <input class="input1" type="file" name="file" accept="image/*"><br>

          <button class="button1">Upload</button>
        </form>
      </div>

    </div>
  </div>
  <!-- <div class="w3-modal" id="post-modal">
    <div class="w3-modal-content">
      <div class="w3-container w3-padding">
        <span class="w3-right w3-opacity"><i class="fa fa-times"
            onclick="document.getElementById('post-modal').style.display='none'"></i></span>
        <h3>ĐĂNG BÀI</h3>
        <label for="">Tiêu đề: <input class="w3-input w3-border w3-padding" type="text" id="post-title-inp"></label><br>
        <label for="">Link ảnh: <input class="w3-input w3-border w3-padding" type="text" id="post-img-inp"
            style="margin-bottom: 20px;"></label>
        <label for="">Nội dung: <br>
          <textarea id="post-content-inp" cols="102" rows="10" class="w3-border w3-padding"></textarea>
          <button class="w3-button w3-theme" style="margin-top:20px;" onclick="dangBai()">Đăng
            bài</button><br>
      </div>
    </div>
  </div> -->
  <!-- Navbar -->
  <div class="w3-top">
    <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
      <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
      <a href="#" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i class="fa fa-home w3-margin-right"></i>Logo</a>
      <a onclick="openPostModal()" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Messages"><i class="fa fa-pencil"></i></a>
      <div class="w3-dropdown-hover w3-hide-small">
        <button class="w3-button w3-padding-large" title="Notifications"><i class="fa fa-bell"></i><span class="w3-badge w3-right w3-small w3-green">3</span></button>
        <div class="w3-dropdown-content w3-card-4 w3-bar-block" style="width:300px">
          <a href="#" class="w3-bar-item w3-button">One new friend request</a>
          <a href="#" class="w3-bar-item w3-button">John Doe posted on your wall</a>
          <a href="#" class="w3-bar-item w3-button">Jane likes your post</a>
        </div>
      </div>
      <form class="w3-margin-left w3-bar-item" action="action_page.php">
        <input class="" type="text" placeholder="Search.." name="search" id="search-inp">
        <button class="" type="submit"><i class="fa fa-search"></i></button>
      </form>
      <a href="#" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white" title="My Account" onclick="clickProfile()">
        <img src="uploads/anonymous.png" class="w3-circle" style="height:25px;width:auto" alt="Avatar">
      </a>
      <a href="logout.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white w3-right" title="Messages">Sign out<i class="fa fa-sign-out"></i></a>
    </div>
  </div>

  <!-- Page Container -->
  <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px" id="page-container">
    <!-- The Grid -->
    <div class="w3-row">
      <!-- Left Column -->
      <div class="w3-col m3">
        <!-- Profile -->
        <div class="w3-card w3-round w3-white">
          <div class="w3-container">
            <h4 class="w3-center">My Profile</h4>
            <p class="w3-center"><img src="uploads/anonymous.png" class="w3-circle" style="height:106px;width:auto" alt="Avatar"></p>
            <hr>
            <p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> Designer, UI</p>
            <p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> London, UK</p>
            <p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i> April 1, 1988</p>
          </div>
        </div>
        <br>

        <!-- Accordion -->
        <div class="w3-card w3-round">
          <div class="w3-white">
            <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> Gần đây</button>
            <button onclick="myFunction('Demo2')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-calendar-check-o fa-fw w3-margin-right"></i> Group1</button>
            <button onclick="myFunction('Demo3')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-users fa-fw w3-margin-right"></i> Group2</button>
            <button onclick="myFunction('Demo4')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-users fa-fw w3-margin-right"></i> Group3</button>
          </div>
        </div>
        <br>
        <!-- End Left Column -->
      </div>
      
      <!-- Middle Column -->
      <div class="w3-col m9">

        <div id="app">
          <!-- Container for blog posts -->
          <div id="blog-posts" class="container1"></div>
        </div>

        <!-- The Modal -->
        <div id="myModal" class="modal">
          <span id="closeBtn" class="close">&times;</span>
          <img id="modalImage" class="modal-content">
        </div>


        <button type="button" class="w3-button w3-theme-d1" style="padding:0 5px 0 5px;margin:1px 1px 1px 16px;display: inline-block;"> 1</button>
        <button type="button" class="w3-button w3-theme-d1" style="padding:0 5px 0 5px;margin:1px;display: inline-block;"> 2</button>
        <button type="button" class="w3-button w3-theme-d1" style="padding:0 5px 0 5px;margin:1px;display: inline-block;"> 3</button>
        <button type="button" class="w3-button w3-theme-d1" style="padding:0 5px 0 5px;margin:1px;display: inline-block;"> 4</button>
        <button type="button" class="w3-button w3-theme-d1" style="padding:0 5px 0 5px;margin:1px;display: inline-block;"> 5</button>
        <button type="button" class="w3-button w3-theme-d1" style="padding:0 5px 0 5px;margin:1px;display: inline-block;"> 6</button>

        <!-- End Middle Column -->
      </div>

      <!-- End Grid -->
    </div>

    <!-- End Page Container -->
  </div>
  <br>

  <!-- Footer -->
  <footer class="w3-container w3-theme-d3 w3-padding-16">
    <h5>Footer</h5>
  </footer>

  <script src="insidepages.js"></script>
  <script src="app.js"></script>

</body>

</html>