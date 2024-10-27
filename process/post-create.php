<?php

session_start();
include '../includes/db.php';

$poster_id = $_SESSION['user_id'];
$text = mysqli_real_escape_string($conn, $_POST['text']);
$receiver_id = $_POST['receiver_id'];

if ($text != "") {
    $sql = "INSERT INTO posts (poster_id, receiver_id, text) VALUES ($poster_id, $receiver_id, '$text')";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
}
header("Location: ../profile.php?id=$receiver_id");