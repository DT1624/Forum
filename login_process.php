<?php
require_once("connection.php");
    session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $sql1 = "SELECT * FROM users WHERE username='$username'";
            $result1 = $conn->query($sql1);
            $row = $result1->fetch_row();
            $_SESSION['message'] = "Đăng nhập thành công!";
            $_SESSION['userID'] = $row[0];
            $isLogin = intval(true);

            $stmt = $conn->prepare("INSERT INTO personalusers (userIDpersonal, isLogin) VALUES (?, ?)");
            $stmt->bind_param("si", $_SESSION['userID'], $isLogin);
            $result3 = $stmt->execute();
            header("Location: forum.php?category=recently");
        } else {
            $_SESSION['message'] = "Sai mật khẩu";
            $_SESSION["loginSucces"] = true;
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Người dùng không tồn tại!";
        $_SESSION["loginSucces"] = true;
        header("Location: index.php");
        exit();
    }

    $conn->close();
}
?>