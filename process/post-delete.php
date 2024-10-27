<?php

include '../includes/db.php';

$post_id = $_POST['post_id'];
$receiver_id = $_POST['receiver_id'];

$sql = "DELETE FROM posts WHERE id=$post_id";
mysqli_query($conn, $sql);
mysqli_close($conn);

header("Location: ../profile.php?id=$receiver_id");