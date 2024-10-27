<?php
session_start();
$user_id = $_SESSION['user_id'];
include '../includes/db.php';

/*START - CREATE THUMBNAIL AND SAVE TO FOLDER*/

$imgSrc = $_FILES['photo']['tmp_name'];

$death = "";
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM profile_photos WHERE user_id=$user_id LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$id = $row['id'];

if (!$imgSrc) {
    $user_id = $_SESSION['user_id'];

    $sql = "UPDATE profile_photos SET file_name='$death' WHERE id=$id";

    mysqli_query($conn, $sql);

    mysqli_close($conn);
    header("Location: ../about.php?id=$user_id");
}

list($width, $height) = getimagesize($imgSrc);

$myImage = imagecreatefromjpeg($imgSrc);

if($width > $height){
    $y = 0;
    $x = ($width - $height)/2;
    $smallestSide = $height;
} else {
    $x = 0;
    $y = ($width - $height)/2;
    $smallestSide = $width;
}

$thumbSize = 300;
$thumb = imagecreatetruecolor($thumbSize, $thumbSize);

imagecopyresampled($thumb, $myImage, 0,0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);

$filename = pathinfo($_FILES['photo']['name'], PATHINFO_FILENAME);

imagejpeg($thumb, '../img/' . $filename . '.jpg');

/*END - CREATE THUMBNAIL AND SAVE TO FOLDER*/


/*START - DATABASE ENTRY*/

$user_id = $_SESSION['user_id'];

$sql = "UPDATE profile_photos SET file_name='$filename.jpg' WHERE id=$id";

mysqli_query($conn, $sql);

mysqli_close($conn);

/*END - DATABASE ENTRY*/
header("Location: ../about.php?id=$user_id");