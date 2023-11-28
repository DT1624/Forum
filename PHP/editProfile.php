<?php

;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel='stylesheet' type='text/css' media='screen' href='demo.css'>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit profile</h1>
    <form class="form" action="editProfile_process.php" method="post">
        <div class = "input-group">
            <label class = "label" for="username">Username</label>
            <input class = "input" type="text" id="username" name="username" required><br>
            
        </div>

        <div class = "input-group">
            <label class = "label" for="password">Password</label>
            <input class = "input" type="password" id="password" name="password" required><br>
            
        </div>
        
        <button class = "input" type="submit">Update</button>
    </form>
</body>
</html>

