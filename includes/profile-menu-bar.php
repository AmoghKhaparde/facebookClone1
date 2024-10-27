<?php   
$user_id = $_SESSION['user_id'];
// $user_id = $_GET['id'];
?>

<div class="menu-bar">
    <ul>
        <li><a href="profile.php?id=<?php echo $user_id; ?>">Timeline</a></li>
        <li><a href="about.php?id=<?php echo $user_id; ?>">About</a></li>
        <li><a href="friends.php?id=<?php echo $user_id; ?>">Friends</a></li>
        <li><a href="photos.php?id=<?php echo $user_id; ?>">Photos</a></li>
    </ul>
</div>