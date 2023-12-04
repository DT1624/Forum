<?php
session_start();
require_once("connection.php");
$userID = $_SESSION['userID'];
$sql = "SELECT * FROM users WHERE userID = '$userID'";
$result = $conn->query($sql);
$userInfo = $result->fetch_assoc();
$userIDNow = $userID;
if (isset($_GET['userIDNow'])) {
  $userIDNow = $_GET['userIDNow'];
  $_SESSION['usserIDNow'] = $userIDNow;
}
$_SESSION['wherePost'] = "profile";
?>
<!DOCTYPE html>
<html>

<head>
  <title>UET Forum</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue.css">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="icon" type="image/x-icon" href="https://cdn.haitrieu.com/wp-content/uploads/2021/10/Logo-DH-Cong-Nghe-UET.png">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="post.css">
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
    upPostForum($conn, "profile.php");
  ?>  

  <!-- Navbar -->
  <div class="w3-top">
    <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
      <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
      <a href="#" class="w3-bar-item w3-button w3-padding-large w3-theme-d4" onclick="clickLogo()"><i class="fa fa-home w3-margin-right"></i>Logo</a>
      <a onclick="openPostModal()" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Messages"><i class="fa fa-pencil"></i></a>
      <div class="w3-dropdown-hover w3-hide-small">
        <button class="w3-button w3-padding-large" title="Notifications"><i class="fa fa-bell"></i><span class="w3-badge w3-right w3-small w3-green">3</span></button>
        <div class="w3-dropdown-content w3-card-4 w3-bar-block" style="width:300px">
          <a href="#" class="w3-bar-item w3-button">One new friend request</a>
          <a href="#" class="w3-bar-item w3-button">John Doe posted on your wall</a>
          <a href="#" class="w3-bar-item w3-button">Jane likes your post</a>
          <a href="#" class="w3-bar-item w3-button">XIn chào</a>
        </div>
      </div>
      <form class="w3-margin-left w3-bar-item" action="/action_page.php">
        <input class="" type="text" placeholder="Search.." name="search">
        <button class="" type="submit"><i class="fa fa-search"></i></button>
      </form>
      <a href="#" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white" style="height:auto" title="My Account" onclick="clickProfile()">
        <img src="<?php echo $userInfo['linkAva'] ?>"style="height:23px;width:23px;border-radius: 50%; object-fit: cover;display: flex;
        flex-direction: row;
        align-items: center;text-align: center;" alt="Avatar">
      </a>
      <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white w3-right" title="Messages"><i class="fa fa-sign-out"></i></a>
    </div>
  </div>

  <!-- Page Container -->
  <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">
    <div class="w3-row">
      <div class="w3-col m3" style="display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                    width: 250;
                                    margin-top: 20px;">
        <?php
        require_once("comments.inc.php");
        displayUserProfile($conn, $userID, $userIDNow);
        ?>
        
        <br>
      </div>

      <!-- <div class="w3-col m9">
        <div id="myModal" class="modal">
          <span id="closeBtn" class="close">&times;</span>
          <img id="modalImage" class="modal-content">
        </div>
      </div> -->

      <div class="w3-col m9">
        <div id="app">
          <!-- Container for blog posts -->
          <div id="blog-posts" class="container1"></div>
        </div>

        <div id="myModal" class="modal1">
          <span id="closeBtn" class="close">&times;</span>
          <img id="modalImage" class="modal-content">
        </div>

        <button type="button" class="w3-button w3-theme-d1" style="padding:0 5px 0 5px;margin:1px 1px 1px 16px;display: inline-block;"> 1</button>
        <button type="button" class="w3-button w3-theme-d1" style="padding:0 5px 0 5px;margin:1px;display: inline-block;"> 2</button>
        <button type="button" class="w3-button w3-theme-d1" style="padding:0 5px 0 5px;margin:1px;display: inline-block;"> 3</button>
        <button type="button" class="w3-button w3-theme-d1" style="padding:0 5px 0 5px;margin:1px;display: inline-block;"> 4</button>
        <button type="button" class="w3-button w3-theme-d1" style="padding:0 5px 0 5px;margin:1px;display: inline-block;"> 5</button>
        <button type="button" class="w3-button w3-theme-d1" style="padding:0 5px 0 5px;margin:1px;display: inline-block;"> 6</button>

      </div>

    </div>

  </div>
  <br>

  <!-- Footer -->
  <footer class="w3-container w3-theme-d3 w3-padding-16">
    <h5>Footer</h5>
  </footer>

  <footer class="w3-container w3-theme-d5">
    <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
  </footer>

  <script src="insidepages.js"></script>
  <script src="profile.js"></script>
  <script src="app.js"></script>
  <script>
    function editprofile() {
      window.location.href = "editProfile.php?userId=<?php echo $userID; ?>";
    }

    function clickLogo() {
      window.location.href = "forum.php?category=recently";
    }
    window.onload = function() {
      displayProfile();
    };
  </script>



</body>

</html>