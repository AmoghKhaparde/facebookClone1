<?php

session_start();
include '../includes/db.php';

$user_id = $_SESSION['user_id'];
$requested_id = $_POST['requested_id'];

$sql = "SELECT * FROM friend_requests WHERE requester_id=$user_id AND requested_id=$requested_id";

$results = mysqli_query($conn, $sql);
$num_results = mysqli_num_rows($results);

if ($num_results == 0) {
    $sql = "INSERT INTO friend_requests (requester_id, requested_id) VALUES ($user_id, $requested_id)";

    mysqli_query($conn, $sql);
}

mysqli_close($conn);

header("Location: ../profile.php?id=$user_id");