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
  <div class="w3-modal" id="post-modal">
    <div class="w3-modal-content">
      <div class="w3-container w3-padding">
        <span class="w3-right w3-opacity"><i class="fa fa-times" onclick="document.getElementById('post-modal').style.display='none'"></i></span>
        <h3>ĐĂNG BÀI</h3>
        <label for="">Tiêu đề: <input class="w3-input w3-border w3-padding" type="text" id="post-title-inp"></label><br>
        <label for="">Link ảnh: <input class="w3-input w3-border w3-padding" type="text" id="post-img-inp" style="margin-bottom: 20px;"></label>
        <label for="">Nội dung: <br>
          <!-- <input class="w3-input" type="text" id="post-content-inp" style="height: 30vh;"></label> -->
          <textarea id="post-content-inp" cols="102" rows="10" class="w3-border w3-padding"></textarea>
          <button class="w3-button w3-theme" style="margin-top:20px;" onclick="dangBai()">Đăng
            bài</button><br>
      </div>
    </div>
  </div>
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
        </div>
      </div>
      <form class="w3-margin-left w3-bar-item" action="/action_page.php">
        <input class="" type="text" placeholder="Search.." name="search">
        <button class="" type="submit"><i class="fa fa-search"></i></button>
      </form>
      <a href="#" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white" title="My Account">
        <img src="/w3images/avatar2.png" class="w3-circle" style="height:23px;width:23px" alt="Avatar">
      </a>
      <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white w3-right" title="Messages"><i class="fa fa-sign-out"></i></a>
    </div>
  </div>

  <!-- Page Container -->
  <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">
    <div class="w3-row">
      <div class="w3-col m3">
        <div class="w3-card w3-round w3-white">
          <div class="w3-container">
            <h4 class="w3-center">My Profile</h4>
            <p class="w3-center"><img src="/w3images/avatar3.png" class="w3-circle" style="height:106px;width:106px" alt="Avatar"></p>
            <hr>
            <p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> Designer, UI</p>
            <p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> London, UK</p>
            <p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i> April 1, 1988</p>
          </div>
        </div>
        <button type="button" class="w3-button w3-theme" style="margin-top:20px;" onclick="editprofile()">Edit profile</button>
        <br>
      </div>

      <!-- <div id="profile"></div> -->
      <!-- Middle Column -->
      <div class="w3-col m9">

      <div id="app">
          <!-- Container for blog posts -->
          <div id="blog-posts" class="container"></div>
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
      window.location.href = "editProfile.php";
    }
    function clickLogo() {
      window.location.href = "forum.php";
    }
    window.onload = function() {
      displayProfile();
    };
  </script>
  
  

</body>

</html>