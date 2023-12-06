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
$_SESSION['userID'] = $userID;
$sql = "SELECT * FROM users WHERE userID = '$userID'";
$result = $conn->query($sql);
$userInfo = $result->fetch_assoc();
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
  <link rel="icon" type="png" href="uploads/uet.png">
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
  <!-- khung đăng bài -->
  <?php
    require_once("comments.inc.php");
    require_once("connection.php");
    upPostForum($conn, "forum.php?category=recently");
  ?>

  <!-- thanh menu -->
  <?php
    require_once("comments.inc.php");
    require_once("connection.php");
    displayMenu($conn, $userID);
  ?>

  <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px" id="page-container">
    <div class="w3-row">
      <div class="w3-col m3">
        <div class="w3-card w3-round" style="max-width: 80%; overflow:auto; max-height: 500px;">
          <div class="w3-white">
            <!-- hiển thị các group -->
            <?php
            require_once("comments.inc.php");
            require_once("connection.php");
            loadGroup($conn);
            ?>
          </div>
        </div>
        <br>
      </div>

      <!-- hiển thị bài theo group -->
      <div class="w3-col m9" style="min-height: 100%;">
        <div style="min-height: 100%;">
        <?php
        require_once("comments.inc.php");
        require_once("connection.php");
        getPostsForum($conn, $categoryGroup);
        ?>
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

  <footer class="w3-container w3-theme-d3 w3-padding-16">
    <h5>Footer</h5>
  </footer>
  <script src="script.js"></script>
  <script src="app.js"></script>

</body>

</html>