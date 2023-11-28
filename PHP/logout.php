<?php
require_once("connection.php");
session_start();
    $uerIDpersonal = $_SESSION['userID'];
    $isLogout = intval(true);
    echo $uerIDpersonal;
    $stmt = $conn->prepare("INSERT INTO personalusers (userIDpersonal, isLogout) VALUES (?, ?)");
    $stmt->bind_param("si", $uerIDpersonal, $isLogout);
    $result3 = $stmt->execute();
    session_destroy();
    header("Location: index.php");
?>