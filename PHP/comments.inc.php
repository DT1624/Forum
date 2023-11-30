<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
function setComments ($conn, $postID) {
    if (isset($_POST['commentSubmit'])) {
        $userIDComment = $_SESSION['userID'];
        $comment = $_POST['comment'];
        $commentID = 'CMT'.str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);
        $parent_cid = isset($_POST['parent_cid']) ? $_POST['parent_cid'] : null;

        $stmt = $conn->prepare("INSERT INTO comments (commentID, userIDComment, postIDComment, comment) VALUES (?, ?, ?, ?)"); 
        $stmt->bind_param("ssss", $commentID, $userIDComment, $postID, $comment);
        $result = $stmt->execute();
        header("Location: indexCom.php?postId=$postID");
        exit();
    }

}

function setComments2($conn) {
    if (isset($_POST['commentSubmit'])) {
        if (isset($_POST['userIDComment'], $_POST['dateOfComment'], $_POST['comment'])) {
            $userIDComment = $_POST['userIDComment'];
            $comment = $_POST['comment'];
            $parent_cid = isset($_POST['parent_cid']) ? $_POST['parent_cid'] : null;
            $sql = "INSERT INTO comments (userIDComment, comment, parent_cid) VALUES ($userIDComment, $comment, $parent_cid)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssi', $userIDComment, $comment, $parent_cid);
            $result = $stmt->execute();
            $stmt->close();
        }
    }
}

function getComments($conn, $postID) {
    $sql = "SELECT * FROM comments WHERE postIDComment = '$postID' order by dateOfComment DESC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {   
        echo "<div>";
            echo "
            <div> 
                <span class='user-name'>" . $row['userIDComment'] . "</span><br>
                <span class='comment-date'>" . $row['dateOfComment'] . "</span><br>
            </div>
                <div class='comment-box'><p>";
                    echo nl2br($row['comment']);
                echo "</div>";

            echo "<div style='display: flex; justify-content: space-between;'>
                <form class='edit-form' method='POST' action='editcomment.php?commentId=".$row['commentID']."'> 
                    <input type='hidden' name='commentID' value='".$row['commentID']."'>
                    <input type='hidden' name='userIDComment' value='".$row['userIDComment']."'>
                    <input type='hidden' name='postIDComment' value='".$row['postIDComment']."'>
                    <input type='hidden' name='comment' value='".$row['comment']."'>
                    <button>Edit</button>
                </form> 
                

                <form class='delete-form' method='POST' action='".deleteComments($conn)."'> 
                    <input type='hidden' name='cid' value='".$row['commentID']."'>
                    <button type = 'submit' name = 'commentDelete'>Delete</button>
                </form>    
                <form class='reply-form' method='POST' action='replyComment.php'> 
                    <input type='hidden' name='parent_cid' value='" . $row['commentID'] . "'>
                    <input type='hidden' name='userIDComment' value='" . $row['userIDComment'] . "'> 
                    <button type='submit' name='replyComment'>Reply</button>
                </form>   
                   
            </div>
        </div>";
        echo "<hr>";
    }
}


function deleteComments($conn) {
    if (isset($_POST['commentDelete'])) {
        $cid = $_POST['commentID'];
        $sql = "DELETE FROM comments WHERE commentID = '$cid'";
        $result = $conn->query($sql);
        header("Location: indexCom.php");
    }
}

function replyComment($conn) {
    if (isset($_POST['replyComment'])) {
        $parent_cid = $_POST['parent_cid'];
        $userIDComment = $_POST['userIDComment'];
        $comment = $_POST['comment'];

        if (empty($comment)) {
            header("Location: replyComment.php?error=emptymessage&parent_cid=$parent_cid");
            exit();
        }
        $sql = "INSERT INTO comments (userIDComment, comment, parent_cid) VALUES ($userIDComment, $comment, $parent_cid)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssi", $userIDComment, $comment, $parent_cid);
            $stmt->execute();
            $stmt->close();
            header("Location: indexCom.php");
            exit();
        } else {
            header("Location: replyComment.php?error=sqlerror&parent_cid=$parent_cid");
            exit();
        }
    }
}

