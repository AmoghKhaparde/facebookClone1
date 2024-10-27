<?php

session_start();
include '../includes/db.php';

$viewer_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];

$sql = "SELECT * FROM post_likes WHERE user_liked_id=$user_id AND post_id=$post_id";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);

if ($num_rows == 0) {
    $sql = "INSERT INTO post_likes (user_liked_id, post_id) VALUES ($user_id, $post_id)";
    mysqli_query($conn, $sql);
}

mysqli_close($conn);

header("Location: ../profile.php?id=$viewer_id");
