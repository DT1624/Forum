<?php
    session_start();
    if (isset($_SESSION['message'])) {
        echo "<script>alert('" . $_SESSION['message'] . "');</script>";
        unset($_SESSION['message']); 
    }
    session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel='stylesheet' type='text/css' media='screen' href='demo.css'>
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng nhập</h2>
    <form action="login_process.php" method="post">
        <div class = "input-group">
            <ion-icon name="lock-closed-outline"></ion-icon>
            <input class = "input" type="text" id="username" name="username" required><br>
            <label class = "label" for="username">Username</label>
        </div>

        <div class = "input-group">
            <input class = "input" type="password" id="password" name="password" required><br>
            <label class = "label" for="password">Password</label>
        </div>
        <!-- <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required><br><br> -->
        
        <button class = "input" type="submit">Đăng nhập</button>
    </form>
</body>
</html>

