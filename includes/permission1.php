<?php
session_start();
$user_id = $_SESSION['user_id'];
if ($_SESSION['permission1'] !== 1) {
    header("Location: about.php?id=$user_id");
} else {
    header("Location: about-edit.php?id=$user_id");
}