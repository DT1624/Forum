<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("connection.php");
include 'comments.inc.php';

$postID = '';

if (isset($_GET['postId'])) {
    $postID = $_GET['postId'];
    $_SESSION['postID'] = $postID;
}

$sqlPost = "SELECT * FROM posts WHERE postID = '$postID'";
$resultPost = $conn->query($sqlPost);

// Kiểm tra xem có bài viết nào hay không
if ($resultPost->num_rows > 0) {
    $post = $resultPost->fetch_assoc();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    setComments($conn, $postID);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Title of the document</title>
    <link rel="stylesheet" type="text/css" href="comment.css">
    <link rel="stylesheet" type="text/css" href="post.css">
</head>

<body>

    <div id="comments-section">
        <div style="background-color: #E8E8C3">
            <p style="text-align: right; font-size: small; font-weight: 600"><i><?php echo $post['dateOfPost']; ?></i></p>
            <h1 style="text-align: left"><i><?php echo $post['titlePost']; ?></i></h1>
            <p style="text-align: center"><img class='post-image' style="width: 300px;
    height: auto" src="<?php echo $post['imagePost']; ?>" alt='Post Image' 
            style="width: 150px;height: auto;"></p>
            <div class='description-container'>
                <p><?php echo $post['descriptionPost']; ?></p>
            </div>
        </div>
        <hr>

        <form method='POST' action='indexCom.php?postId=<?php echo $postID; ?>'>
            <input type='hidden' name='userIDComment'>
            <textarea name='comment' required></textarea><br>
            <button type='submit' name='commentSubmit'>Comment</button>
        </form>
        <hr>

        <?php
        getComments($conn, $postID);
        ?>

    </div>

    <script src="app.js"></script>
</body>

</html>