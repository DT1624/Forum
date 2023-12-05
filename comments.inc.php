<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("connection.php");

//hàm xử lý đăng comment
function setComments($conn, $postID)
{
    if (isset($_POST['commentSubmit'])) {
        $userIDComment = $_SESSION['userID'];
        $comment = $_POST['comment'];
        $commentID = 'CMT' . str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);
        $parent_cid = isset($_POST['parent_cid']) ? $_POST['parent_cid'] : null;

        //cập nhật số cmt
        $sql = "UPDATE posts SET numberComments = numberComments + 1 WHERE postID = '$postID'";
        $result = $conn->query($sql);

        //ghi vào db
        $stmt = $conn->prepare("INSERT INTO comments (commentID, userIDComment, postIDComment, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $commentID, $userIDComment, $postID, $comment);
        $result = $stmt->execute();

        // ghi vào interact post
        $isComment = intval(true);
        $stmt = $conn->prepare("INSERT INTO interactposts (userIDInteract, postIDInteract, isComment) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $userIDComment, $postID, $isComment);
        $result = $stmt->execute();

        $noticeID = 'NO' . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);

        $fullName = '';
        $fullNameQuery = "SELECT fullName FROM users WHERE userID = '$userIDComment'";
        $fullNameResult = $conn->query($fullNameQuery);
        if ($fullNameResult->num_rows > 0) {
            $row = $fullNameResult->fetch_assoc();
            $fullName = $row['fullName'];
        }

        $titlePost = '';
        $titlePostQuery = "SELECT titlePost FROM posts WHERE postID = '$postID'";
        $titlePostResult = $conn->query($titlePostQuery);
        if ($titlePostResult->num_rows > 0) {
            $row = $titlePostResult->fetch_assoc();
            $titlePost = $row['titlePost'];
        }

        $message = 'Người dùng: ' . $fullName . ' đã comment bài viết ' . $titlePost . ' của bạn.';

        $userIDNotice = '';
        $userIDNoticeQuery = "
            SELECT userID FROM users u
            INNER JOIN posts p ON p.userIDPost = u.userID 
            WHERE postID = '$postID'";
        $userIDNoticeResult = $conn->query($userIDNoticeQuery);
        if ($userIDNoticeResult->num_rows > 0) {
            $row = $userIDNoticeResult->fetch_assoc();
            $userIDNotice = $row['userID'];
        }
        //cập nhật thông báo cho người comment nếu khác chủ bài viết
        if ($userIDNotice != $userIDComment) {
            $stmt = $conn->prepare("INSERT INTO notices (noticeID, userIDNotice, message) VALUES (?, ?, ?);");
            $stmt->bind_param("sss", $noticeID, $userIDNotice, $message);
            $result = $stmt->execute();
        }

        header("Location: indexCom.php?postId=$postID");
        exit();
    }

}

//hiện khung trang cá nhân bên phải profile khi truy cập profile 1 user
function displayUserProfile($conn, $userID, $userIDNow)
{
    $sql = "SELECT * FROM users WHERE userID = '$userIDNow'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $userInfo = $result->fetch_assoc();
        echo "
            <div class='w3-card w3-round w3-white' >
                <div class='w3-container' style='width:250px;'>
                    <p class='w3-center'><img src='" . $userInfo['linkAva'] . "'style='height:150px;width:150px; border-radius: 50%; object-fit: cover;display: flex;
                    flex-direction: row;margin: 3rem auto;
                    align-items: center;text-align: center;' alt='Avatar'></p>
                    <hr>
                    <p><i class='fa fa-user fa-fw w3-margin-right w3-text-theme'></i>" . $userInfo['fullName'] . "</p>
                    <p><i class='fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme'></i>" . $userInfo['birthday'] . "</p>
                    <p><i class='fa fa-venus-mars fa-fw w3-margin-right w3-text-theme'></i>" . $userInfo['gender'] . "</p>
                    <p><i class='fa fa-users fa-fw w3-margin-right w3-text-theme'></i>Followers: " . $userInfo['followers'] . "</p>
                    <p><i class='fa fa-id-card fa-fw w3-margin-right w3-text-theme'></i></p>
                </div>
            </div>";
        if ($userID === $userIDNow) {
            echo "<button type='button' class='w3-button w3-theme' style='margin-top: 20px; border-radius: 10%' onclick=\"editprofile('{$userID}')\">Edit profile</button>";
        }
    } else {
        echo "User not found.";
    }
    echo $userID ;
}

//load các group hiện có, có thể bấm vô để xem các bài viết theo chủ đề
function loadGroup($conn)
{
    echo '<button style="padding: 20px" onclick="redirectToForum(\'recently\')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-history fa-fw w3-margin-right"></i>Gần đây</button>';

    $sql = "SELECT * FROM groupss";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<button style="padding: 20px" onclick="redirectToForum(\'' . $row['categoryGroup'] . '\')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-group fa-fw w3-margin-right"></i>' . $row['categoryGroup'] . '</button>';
        }

        echo '</select>';
    }
    echo
        '<script>
            function redirectToForum(categoryGroup) {
                window.location.href = "forum.php?category=" + categoryGroup;
            }
        </script>';
}



function upPostForum($conn, $redirectFile)
{
    echo
        '<div class="w3-modal" style="align-items:center; padding-top: 50px" id="post-modal">
        <div class="w3-modal-content">

        <div class="w3-container w3-padding" style="align-items:center; background-color: #F6DDCA">
            <span class="w3-right w3-opacity">
                <i class="fa fa-times" onclick="closePostModal()"></i>
            </span>
            <form class="form1"  action="upload_post.php" method="post" enctype="multipart/form-data">
            <label class="label1" for="post_title"><i>Title:</i></label><br>
            <input style="width: 50%;" class="input1" type="text" name="post_title" placeholder="Title" required><br>

            <label class="label1" for="post_description"><i>Description:</i></label><br>
            <textarea class="myTexttarea" style="text-align: left" id="myTextarea" name="post_description" required></textarea><br>

            <label class="label1" for="group_post" ><i>Group:</i></label><br>';

    require_once("connection.php");
    $sql = "SELECT groupID, categoryGroup FROM groupss";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<select id="group" name="select_group" style="text-align:center; width: 15%; height:40px; max-height: 50px; overflow:auto;">';

        while ($row = $result->fetch_assoc()) {
            $groupID = htmlspecialchars($row["groupID"]);
            $categoryGroup = htmlspecialchars($row["categoryGroup"]);
            echo '<option value="' . $groupID . '">' . $categoryGroup . '</option>';
        }

        echo '</select>';
    } else {
        echo "No data found";
    }

    echo '<br><br><label class="label1" for="file"><i>Upload Image:<i></label><br>
            <input class="input1" type="file" name="file" style="text-align: center;" accept="image/*"><br>

            <button style="width: 40%" class="button1">Upload</button>
            </form>
        </div>

        </div>
    </div>';
    echo
        '<script>
            function closePostModal() {
                document.getElementById("post-modal").style.display = "none";
            }
        </script>';
}

function setComments2($conn)
{
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

//hàm load Post của từng userID khi xem profile
function getPosts($conn, $userID)
{
    $sql = "SELECT * FROM posts where userIDPost = '$userID' ORDER BY dateOfPost DESC";
    $result = $conn->query($sql);

    $posts = [];
    while ($row = $result->fetch_assoc()) {
        $postID = $row['postID'];

        $imageHtml = isset($row['imagePost']) ? "<p style='text-align: center'><img class='post-image' src='{$row['imagePost']}' alt='Post Image' onclick='openModal(\"{$row['imagePost']}\", \"myModal_{$postID}\")'></p>" : '';
        echo "
            <div class='post' id='blog-post_{$postID}'>
                <p style='text-align: right; font-size: small; font-weight: 700'><i>{$row['dateOfPost']}</i></p>
                <h1><i>{$row['titlePost']}<i></h1>";
        echo $imageHtml;
        echo "
                <div class='description-container'>
                    <p>{$row['descriptionPost']}</p>
                </div>
                <br>
                
                <div class='reaction-comment-container'>
                    <div></div>
                    <div class='comment-container'>
                        <span>{$row['numberComments']} <a href='indexCom.php?postId={$postID}' class='comment-button' data-post-id='{$postID}' >Comments</a></span><br>    
                    </div>
                </div>
            </div>
            <div id='myModal_{$postID}' class='modal1'>
                <span id='closeBtn_{$postID}' class='close' onclick='closeModal(\"myModal_{$postID}\")'>&times;</span>
                <img id='modalImage_{$postID}' style='display: block;
                margin: auto; 
                max-width: 100%;
                max-height: 100%;
                border-radius: 5%;' >
            </div>
            
        ";
    }
    echo "
            <script>
                function openModal(imageSrc, modalID) {
                    const modal = document.getElementById(modalID);
                    const modalImg = document.getElementById('modalImage_' + modalID.split('_')[1]);
    
                    modalImg.src = imageSrc;
                    
                    modalImg.onload = function () {
                        modal.style.display = 'block';
                        modal.style.top = '0px';
                        modal.style.left = '0px';
                    };
    
                    window.addEventListener('click', function(event) { outsideClick(event, modalID); });
                }
    
                function closeModal(modalID) {
                    const modal = document.getElementById(modalID);
                    modal.style.display = 'none';
                }
    
                function outsideClick(event, modalID) {
                    const modal = document.getElementById(modalID);
                    const closeBtn = document.getElementById('closeBtn_' + modalID.split('_')[1]);
        
                    if (event.target === modal || event.target === closeBtn) {
                        modal.style.display = 'none';
                    }
                }
            </script>
        ";
}


function handleLike($userID, $postID) {
    include "connection.php";
    header("Location: forum.php");
    // $stmt = $conn->prepare("SELECT * from interactposts where userIDInteract = '?' and postIDInteract = '?' and isLike not null");
    // $stmt->bind_param("ssi", $userID, $postID, 1);
    // $result = $stmt->execute();
    // if ($row = $result->fetch_assoc()) {
    //     $sql = "UPDATE interactposts SET isLike = 1 - {$row['isLike']}";
    //     $result1 = $conn->query($sql);

    // }
}

//hàm load bài theo group ở forum
function getPostsForum($conn, $categoryGroup)
{
    $sql = "";
    if ($categoryGroup === "recently") {
        $sql = "SELECT * FROM posts ORDER BY dateOfPost DESC";
    } else {
        $sql1 = "select * from groupss WHERE categoryGroup = '$categoryGroup'";
        $result1 = $conn->query($sql1);
        $row = $result1->fetch_assoc();
        $groupID = $row['groupID'];

        $sql = "SELECT * FROM posts WHERE groupIDPost = '$groupID' ORDER BY dateOfPost DESC";
    }
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $postID = $row['postID'];
        $userID = $row['userIDPost'];
        $sql1 = "select * from users WHERE userID = '$userID'";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();

        echo "
                <div class='post' id='blog-post_{$postID}' onclick='clickPost(\"{$row['postID']}\")'>
                    <p style='text-align: right; font-size: small; font-weight: 700'><i>{$row['dateOfPost']}</i></p>
                    <a href='profile.php?userIDNow=" . $row['userIDPost'] . "' style='text-overflow: ellipsis;text-decoration:none;'>
                        <div class='comment-container' style='display: flex; align-items: center;max-width: 200px;'>
                            <img src=" . $row1['linkAva'] . " class='w3-circle' style='height:50px;width:auto;border-radius: 50%;margin-right: 10px;' alt='Avatar'>
                            <div style='text-align: left;'>     
                                <span class='user-name'>" . $row1['fullName'] . "</span><br>
                            </div>
                        </div>
                    </a>
                    <h1><i>{$row['titlePost']}<i></h1>";
        echo "
                    <div class='description-container'>
                    <p>{$row['descriptionPost']}</p>
                    </div>
                    <br>
                
                    <div class='reaction-comment-container'>
                        <div></div>
                        <div class='comment-container'>
                            <span>{$row['numberComments']} <a href='indexCom.php?postId={$postID}' class='comment-button' data-post-id='{$postID}' >Comments</a></span><br>    
                        </div>
                    </div>
                </div>
            ";
    }
}

//hàm load tất cả comment của bài viết
function getComments($conn, $postID)
{
    $sql = "SELECT * FROM comments WHERE postIDComment = '$postID' order by dateOfComment DESC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $sql1 = "SELECT * FROM users WHERE userID = \"" . $row['userIDComment'] . "\"";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();
        echo "
            <div>";
        echo "
                <div> 
                    <p style='text-align: right; font-size: small; font-weight: 600'><i>" . $row['dateOfComment'] . "</i></p>
                    <a href='profile.php?userIDNow=" . $row['userIDComment'] . "' style='text-decoration:none'>
                        <div class='comment-container' style='display: flex; align-items: center;'>
                            <img src=" . $row1['linkAva'] . " class='w3-circle' style='height:50px;width:auto;border-radius: 50%;margin-right: 10px;' alt='Avatar'>
                            <div style='text-align: left;'> 
                                
                                <span class='user-name'>" . $row1['fullName'] . "</span><br>
                            </div>
                        </div>
                    </a>
                </div>
                <br>
                <div class='comment-box'
                style='height: auto; max-height: 300px; resize:none; overflow-y: auto;'><p>";
        echo nl2br($row['comment']);
        echo "</div>";

        echo "
                <div style='display: flex; justify-content: space-between;'>
                    <form class='edit-form' method='POST' action='editcomment.php?commentId=" . $row['commentID'] . "'> 
                        <input type='hidden' name='commentID' value='" . $row['commentID'] . "'>
                        <input type='hidden' name='userIDComment' value='" . $row['userIDComment'] . "'>
                        <input type='hidden' name='postIDComment' value='" . $row['postIDComment'] . "'>
                        <input type='hidden' name='comment' value='" . $row['comment'] . "'>
                        <button>Edit</button>
                    </form> 
                    
                    <form class='delete-form' method='POST' action='indexCom.php?id=3'> 
                        <input type='hidden' name='commentID' value='" . $row['commentID'] . "'>
                        <input type='hidden' name='postIDComment' value='" . $row['postIDComment'] . "'>
                        <button type = 'submit' name = 'commentDelete'>Delete</button>
                    </form>    
                    <form class='reply-form' method='POST' action='replyComment.php'> 
                        <input type='hidden' name='parent_cid' value='" . $row['commentID'] . "'>
                        <input type='hidden' name='userIDComment' value='" . $row['userIDComment'] . "'> 
                        <input type='hidden' name='postIDComment' value='" . $row['postIDComment'] . "'>
                        <button type='submit' name='replyComment'>Reply</button>
                    </form>   
                    
                </div>
            </div>";
        echo "<hr style='border-width: 10px; border-color:#037937;'><hr>";
    }
}

//hàm xử lý khi nhấn nút delete
function deleteComments($conn, $postID, $commentID)
{
    if (isset($_POST['commentDelete'])) {
        $sql = "UPDATE posts SET numberComments = greatest(numberComments - 1, 0) WHERE postID = '$postID'";
        $result = $conn->query($sql);
        $sql = "DELETE FROM comments WHERE commentID = '$commentID'";
        $result = $conn->query($sql);
        header("Location: indexCom.php?postId=$postID");
        exit();
    }
}

function replyComment($conn)
{
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
?>