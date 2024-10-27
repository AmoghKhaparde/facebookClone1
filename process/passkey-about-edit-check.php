<?php

session_start();
include '../includes/db.php';

$user_id = $_SESSION['id'];
$email = $_POST['email'];
$password = $_POST['passkey'];

$sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($password == $row['password']) {
    $_SESSION['permission1'] = 1;
    header("Location: ../about-edit.php?id=$user_id");
} else {
    header("Location: ../about.php?id=$user_id");
}
?>