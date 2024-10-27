<?php

session_start();
include '../includes/db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($password == $row['password']) {
    $_SESSION['permission'] = 1;
    $_SESSION['user_id'] = $row['id'];

    header("Location: ../profile.php?id={$row['id']}");
} else {
    header("Location: ../index.php");
}