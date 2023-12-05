<?php
session_start();
require_once("connection.php");
if (isset($_SESSION['message'])) {
  echo "<script>alert('" . $_SESSION['message'] . "');</script>";
  unset($_SESSION['message']);
}
$categoryGroup = '';
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
  <?php
  require_once("comments.inc.php");
  require_once("connection.php");
  upPostForum($conn, "forum.php?category=recently");
  ?>

  <div class="w3-top">
    <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
      <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2"
        href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
      <a href="forum.php?category=recently" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i
          class="fa fa-home w3-margin-right"></i>Logo</a>
      <a onclick="openPostModal()" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white"
        title="Messages"><i class="fa fa-pencil"></i></a>
      <div class="w3-dropdown-hover w3-hide-small">
        <button class="w3-button w3-padding-large" title="Notifications"><i class="fa fa-bell"></i><span
            class="w3-badge w3-right w3-small w3-green">3</span></button>
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
      <a href="profile.php?userId=<?php echo $userID ?>"
        class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white" title="My Account">
        <img src="<?php echo $userInfo['linkAva'] ?>" class="w3-circle" style="height:25px;width:auto" alt="Avatar">
      </a>
      <a href="logout.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white w3-right"
        title="Messages">Sign out<i class="fa fa-sign-out"></i></a>
    </div>
  </div>

  <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px" id="page-container">
    <div class="w3-row">
      <div class="w3-col m3">
        <div class="w3-card w3-round" style="max-width: 80%; overflow:auto; max-height: 500px;">
          <div class="w3-white">
            <?php
            require_once("comments.inc.php");
            require_once("connection.php");
            loadGroup($conn);
            ?>
          </div>
        </div>
        <br>
      </div>

      <div class="w3-col m9">
        <?php
        require_once("comments.inc.php");
        require_once("connection.php");
        getPostsForum($conn, $categoryGroup);
        ?>

        <button type="button" class="w3-button w3-theme-d1"
          style="padding:0 5px 0 5px;margin:1px 1px 1px 16px;display: inline-block;"> 1</button>
        <button type="button" class="w3-button w3-theme-d1"
          style="padding:0 5px 0 5px;margin:1px;display: inline-block;"> 2</button>
        <button type="button" class="w3-button w3-theme-d1"
          style="padding:0 5px 0 5px;margin:1px;display: inline-block;"> 3</button>
        <button type="button" class="w3-button w3-theme-d1"
          style="padding:0 5px 0 5px;margin:1px;display: inline-block;"> 4</button>
        <button type="button" class="w3-button w3-theme-d1"
          style="padding:0 5px 0 5px;margin:1px;display: inline-block;"> 5</button>
        <button type="button" class="w3-button w3-theme-d1"
          style="padding:0 5px 0 5px;margin:1px;display: inline-block;"> 6</button>

      </div>
    </div>
  </div>
  <br>

  <footer class="w3-container w3-theme-d3 w3-padding-16">
    <h5>Footer</h5>
  </footer>
  <script src="script.js"></script>
  <!-- <script src="app.js"></script> -->

</body>

</html>