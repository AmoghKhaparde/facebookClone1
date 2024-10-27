<?php

session_start();
include '../includes/db.php';

$our_id = $_SESSION['user_id'];
$their_id = $_POST['requester_id'];

$sql = "INSERT INTO friends (user_id_one, user_id_two) VALUES ($our_id, $their_id)";
mysqli_query($conn, $sql);

$sql = "DELETE FROM friend_requests WHERE (requested_id=$our_id AND requester_id=$their_id) 
                               OR (requested_id=$their_id AND requester_id=$our_id)";
mysqli_query($conn, $sql);
mysqli_close($conn);

header("Location: ../profile.php?id=$our_id");