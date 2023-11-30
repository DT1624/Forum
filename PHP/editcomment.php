<?php
    require_once("connection.php");
    include 'comments.inc.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $commentID = $_POST['commentID'];
        $comment = $_POST['comment'];
        
        editComments($conn, $commentID, $comment);
        // header("Location: indexCom.php?postId=$postID");
        // exit();
    }
    
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8">
    <title>Title of the document</title>
    <link rel = "stylesheet" type = "text/css" href = "comment.css">
    <link rel="stylesheet" type="text/css" href="post.css">
</head>
<body style="background-color: #C6E6F2">
    <h1 style="text-align: center; color: darkmagenta">EDIT COMMENT</h1>
    <div id="comments-section" >
        <form method='POST' action='editcomment.php'>
            <input type='hidden' name='commentID'>
            <textarea name='comment' required><?php echo $comment ?></textarea><br>
            <button type='submit' name='editComment'>Update Comment</button>
        </form>
        <hr>

    </div>   
</body>
</html>

<?php
function editComments($conn, $commentID, $comment) {
    if (isset($_POST['editComment'])) {
        $sql = "UPDATE comments SET comment = '$comment' WHERE commentID = '$commentID'";
        $result = $conn->query($sql);
    }
}
?>