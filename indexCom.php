<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("connection.php");
include 'comments.inc.php';

$postID = '';
$commentID ='';
$comment = '';

if (isset($_GET['commentId'])) {
    $commentID = $_GET['commentId'];
}

if (isset($_GET['postId'])) {
    $postID = $_GET['postId'];
}

$sqlPost = "SELECT * FROM posts WHERE postID = '$postID'";
$resultPost = $conn->query($sqlPost);
// Kiểm tra xem có bài viết nào hay không
if ($resultPost->num_rows > 0) {
    $post = $resultPost->fetch_assoc();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentID = $_POST['commentID'];
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    if($id == '1') {
        $comment = $_POST['comment'];
        $sql = "UPDATE comments SET comment = '$comment', dateOfComment = default WHERE commentID = '$commentID'";
        $result = $conn->query($sql);
    } else if($id == '2') {
        $postID = isset($_GET['postId']) ? $_GET['postId'] : '';
        setComments($conn, $postID);
    } else if($id == '3') {
        $postID = $_POST['postIDComment'];
        deleteComments($conn, $postID, $commentID);
    }
    header("Location: indexCom.php?postId=$postID");
    exit();
}

// if (isset($_GET['id']))
// {
//     $commentID = $_POST['commentID'];
//     $comment = $_POST['comment'];
//     echo $commentID ." ".$comment;
//     $sql = "UPDATE comments SET comment = '$comment', dateOfComment = default WHERE commentID = '$commentID'";
//     $result = $conn->query($sql);
//     header("Location: indexCom.php?postId=$postID");
//     exit();
// }
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
    
    <div id="comments-section" >
        <?php
        $imageHtml = $post['imagePost'] ? "<p style='text-align: center;'><img class='post-image' style='width: 250px; height: auto;' src='{$post['imagePost']}' alt='Post Image'></p>" : '';
        ?>
        <div style="background-color: #E8E8C3">
            <p style="text-align: right; font-size: small; font-weight: 600"><i><?php echo $post['dateOfPost']; ?></i></p>
            <h1 style="text-align: left; margin: 0px 50px 0px 50px"><i><?php echo $post['titlePost']; ?></i></h1>
            <?php echo $imageHtml; ?>
            <div class='description-container'>
                <p><?php echo $post['descriptionPost']; ?></p>
            </div>
        </div>
        <hr style="border-width: 10px">

        <form method='POST' action="indexCom.php?postId=<?php echo $postID; ?>&id=2">
            <input type='hidden' name='userIDComment'>
            <textarea  style='height: 200px; resize:none' name='comment' required></textarea><br>
            <div class='reaction-comment-container'>
                <div class='like-container' id='likeContainer_{$postID}'>
                    <span class='reaction-count'><?php echo 0 ?></span>
                    <div class='like-button' id='likeButton_{$postID}'>
                        <a class='like-button'>❤️</a>
                    </div>
                </div>
            
                <div>                    
                    <button type='submit' onclick="goBackForum()"> BACK</button>
                    <button type='submit' name='commentSubmit'>Comment</button>
                </div>
            </div>
        </form>
        <hr style='border-width: 10px; border-color:#2D0258;'>

        <?php
        getComments($conn, $postID);
        ?>

    </div>

    <script src="app.js"></script>
    <script>
        function goBackForum() {
            window.location.href = "forum.php?category=recently";
        }
    </script> 
</body>

</html>