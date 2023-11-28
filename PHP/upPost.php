<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* CSS để kiểm soát chiều rộng của textarea */
        #myTextarea {
            resize: none; 
            width: 150%;
            height: 200px;
            margin-left: -50px;
            margin-top: 20px;/* Chiều rộng 100% nếu không đủ */
        }
        #group {
            font-size: 100%;
        }
    </style>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://www.w3schools.om/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="png"
    href="images/uet.png">
    <title>Upload Post</title>
</head>
<body class="w3-theme-l5">
    <!-- <div class="w3-modal" id="post-modal">
        <div class="w3-modal-content">
            <div class="w3-container w3-padding">
                <form class="form" action="upload_post.php" method="post" enctype="multipart/form-data">
                <label for="post_title">Title:</label>
                <input type="text" name="post_title" placeholder="Title" required><br>

                <label for="post_description">Description:</label>
                <textarea id="myTextarea" name="post_description" required></textarea><br>

                <label for="group_post">Group:</label><br>
                <?php 
                    require_once("connection.php");
                    $sql = "SELECT groupID, categoryGroup FROM groupss";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<select id="group" name="select_group">';
                        
                        while ($row = $result->fetch_assoc()) {
                            $groupID = htmlspecialchars($row["groupID"]);
                            $categoryGroup = htmlspecialchars($row["categoryGroup"]);
                            echo '<option value="' . $groupID . '">' . $categoryGroup . '</option>';
                        }

                        echo '</select>';
                    } else {
                        echo "No data found";
                    }
                ?>

                <br><br><label for="file">Upload Image:</label>
                <input type="file" name="file" accept="image/*"><br>

                <button>Upload</button>
            </form>
            </div>
        </div>
    </div> -->
    <div class="container">
        <h1>Upload Your Post</h1>
        <form class="form" action="upload_post.php" method="post" enctype="multipart/form-data">
            <label for="post_title">Title:</label>
            <input type="text" name="post_title" placeholder="Title" required><br>

            <label for="post_description">Description:</label>
            <textarea id="myTextarea" name="post_description" required></textarea><br>

            <label for="group_post">Group:</label><br>
            <?php 
                require_once("connection.php");
                $sql = "SELECT groupID, categoryGroup FROM groupss";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<select id="group" name="select_group">';
                    
                    while ($row = $result->fetch_assoc()) {
                        $groupID = htmlspecialchars($row["groupID"]);
                        $categoryGroup = htmlspecialchars($row["categoryGroup"]);
                        echo '<option value="' . $groupID . '">' . $categoryGroup . '</option>';
                    }

                    echo '</select>';
                } else {
                    echo "No data found";
                }
            ?>

            <br><br><label for="file">Upload Image:</label>
            <input type="file" name="file" accept="image/*"><br>

            <button>Upload</button>
        </form>
    </div>

</body>
</html>

