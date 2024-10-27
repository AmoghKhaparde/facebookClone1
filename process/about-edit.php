<?php

session_start();
include '../includes/db.php';

$password =  $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone_number = $_POST['phone_number'];
$email = $_POST['email'];
$bday = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
if (($bday == "N/A-N/A-N/A") || ($bday == "N/A")) {
    $bday = "N/A";
}
$gender = $_POST['gender'];

$user_id = $_SESSION['user_id'];

$sql = "UPDATE users SET password='$password', phone_number='$phone_number',email='$email',bday='$bday',gender='$gender',first_name='$first_name',last_name='$last_name' WHERE id=$user_id";

mysqli_query($conn, $sql);
mysqli_close($conn);

header("Location: ../about.php?id=$user_id");