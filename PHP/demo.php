<?php
    // include("database.php");
    require_once("connection.php");
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo $row["userID"] . "<br>";
            echo $row["fullName"] . "<br>";
            echo $row["userName"] . "<br>";
            echo $row["userPermission"] . "<br>";
            echo $row["followers"] . "<br>";
            echo $row["birthday"] . "<br>";
            echo $row["gender"] . "<br>";
            echo $row["linkAva"] . "<br>";
            echo $row["dateRegistration"] . "<br><br>";
        }
    } else {
        echo "no user found";
    }
    mysqli_close($conn);
?>