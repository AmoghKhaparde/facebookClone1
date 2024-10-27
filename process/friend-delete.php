<?php
session_start();
include '../includes/db.php';

$user_id = $_SESSION['user_id'];
$friend_user_id = $_POST['friend_user_id'];

$sql = "DELETE FROM friends WHERE (user_id_one=$user_id AND user_id_two=$friend_user_id) OR (user_id_one=$friend_user_id AND user_id_two=$user_id)";
mysqli_query($conn, $sql);
mysqli_close($conn);

header("Location: ../friends.php?id=$user_id");