<?php
  session_start();
  require_once("connection.php");
  if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']); // Xóa thông báo sau khi sử dụng
  }
  $categoryGroup='';
  if (isset($_GET['category'])) {
    $categoryGroup = $_GET['category'];
  }
  $_SESSION['category'] = $categoryGroup;
  $userID = $_SESSION['userID'];
  $sql = "SELECT * FROM users WHERE userID = '$userID'";
  $result = $conn->query($sql);
  $userInfo = $result->fetch_assoc();
  
  $_SESSION['wherePost'] = "forum";
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
  <!-- Khung đăng bài -->
  <?php
    require_once("comments.inc.php");
    require_once("connection.php");
    upPostForum($conn, "forum.php");
  ?>  
  
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
        <img src="<?php echo $userInfo['linkAva'] ?>" class="w3-circle" style="height:25px;width:auto" alt="Avatar">
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
        <!-- <div class="w3-card w3-round w3-white">
          <div class="w3-container">
              <h4 class="w3-center">User Profile</h4>
              <p class="w3-center"><img src="<?php echo $userInfo['linkAva']; ?>" class="w3-circle" style="height:106px;width:auto" alt="Avatar"></p>
              <hr>
              <p><i class="fa fa-user fa-fw w3-margin-right w3-text-theme"></i><?php echo $userInfo['fullName']; ?></p>
              <p><i class="fa fa-user fa-fw w3-margin-right w3-text-theme"></i><?php echo $userInfo['userName']; ?></p>
              <p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i><?php echo $userInfo['birthday']; ?></p>
              <p><i class="fa fa-venus-mars fa-fw w3-margin-right w3-text-theme"></i><?php echo $userInfo['gender']; ?></p>
              <p><i class="fa fa-users fa-fw w3-margin-right w3-text-theme"></i>Followers: <?php echo $userInfo['followers']; ?></p>
          </div>
        </div> -->
        
        <br>

        <div class="w3-card w3-round">
          <div class="w3-white">
            <?php
              require_once("comments.inc.php");
              require_once("connection.php");
              loadGroup($conn);
            ?>  
            <!-- <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-history fa-fw w3-margin-right"></i> Gần đây</button>
            <button onclick="myFunction('Demo2')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-calendar-plus-o fa-fw w3-margin-right"></i> Group1</button>
            <button onclick="myFunction('Demo3')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-group fa-fw w3-margin-right"></i> Group2</button>
            <button onclick="myFunction('Demo4')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-user fa-fw w3-margin-right"></i> Group3</button> -->
          </div>
        </div>
        <br>
      </div>
      
      <!-- Middle Column -->
      <div class="w3-col m9">

        <div id="app">
          <div id="blog-posts" class="container1"></div>
        </div>

        <div id="myModal" class="modal1">
          <span id="closeBtn" class="close">&times;</span>
          <img id="modalImage" class="modal-content">
        </div>
        <!-- <div id="app">
        <?php
          require_once("comments.inc.php");
          require_once("connection.php");
          getPosts($conn, $userID);
        ?>
        </div>
          <div id="myModal" class="modal1">
        <span id="closeBtn" class="close">&times;</span>
        <img id="modalImage" class="modal-content">
      </div> -->

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