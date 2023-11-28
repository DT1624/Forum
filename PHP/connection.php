<?php
$servername = "127.0.0.1:3307";
$username = "root";
$password = "TAD16112004@tad";
$database = "csdl1";

// Tạo kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
} else {
    //  echo "Kết nối thành công";
}
?>