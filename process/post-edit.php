<?php

include '../includes/db.php';

$text = $_POST['text'];
$post_id = $_POST['post_id'];
$receiver_id = $_POST['receiver_id'];

$sql = "UPDATE posts SET text='$text' WHERE id=$post_id";
mysqli_query($conn, $sql);
mysqli_close($conn);

header("Location: ../profile.php?id=$receiver_id");