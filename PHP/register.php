<?php
    session_start();

if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']); // Xóa thông báo sau khi sử dụng
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once("connection.php");
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['birthday'] = $_POST['birthday'];
    $_SESSION['firstname'] = $_POST['firstname'];
    $_SESSION['lastname'] = $_POST['lastname'];
    $_SESSION['gender'] = $_POST['gender'];
    $user = $_SESSION['username'];
    $sql = "SELECT * FROM users WHERE username='$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['message'] = "Tên đăng nhập đã tồn tại";
        echo "<script>registerForm();</script>";
        header("Location: index.php");
        exit();
    } else {
        header("Location: register_process.php");
        exit();
    }
} else {
    echo "Không nhận được đường truyền";
}
?>

