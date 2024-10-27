<?php

include '../includes/db.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$bday = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
$gender = $_POST['gender'];
$phone_number = '';

$sql = "INSERT INTO users (first_name, last_name, email, password, bday, gender, phone_number) VALUES ('$first_name', '$last_name', '$email', '$password', '$bday', '$gender', '$phone_number')";

mysqli_query($conn, $sql);
mysqli_close($conn);

echo '<script>alert("Welcome to Geeks for Geeks")</script>';

header("Location: ../index.php");

?>