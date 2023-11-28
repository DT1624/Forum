<?php
    require_once("connection.php");
    session_start();
    $userIDPost = $_SESSION['userID'];
// Query to get posts from the database
$sql = "SELECT * FROM posts where userIDPost = '$userIDPost' ORDER BY dateOfPost DESC";
$result = $conn->query($sql);

// Fetch posts as an associative array
$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}

// Close the database connection
$conn->close();

// Return posts as JSON
header('Content-Type: application/json');
echo json_encode($posts);
?>
