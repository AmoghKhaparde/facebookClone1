<?php 
session_start();
?>

<!doctype html>
<html lang="en">
<head>

    <title>ZBOOK</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

</head>
<body id="profile-about">

    <nav class="login-nav">
        <img src="img/zbook-logo.png" alt="" class="nav__zbook-logo">

        <form>
            <input type="text">

            <button>
                <i class="fa fa-search" aria-hidden="true"></i>
            </button>

        </form>

        <div class="profile-nav__options">
            <a class="profile-nav__photo-link">
                <img src="img/profile-photo.jpg" alt="" class="profile-nav__photo">
            </a>
            <a class="profile-nav__name-link"><span class="profile-nav__name">James</span></a>
            <a><span class="profile-nav__home">Home</span></a>
            <a class="profile-nav__friends">
                <i class="fa fa-users" aria-hidden="true"></i>
                <span class="profile-nav__friends-num">0</span>
            </a>
        </div>
    </nav>

    <div class="container">

    <header>
        <img src="img/background.jpeg" alt="Background Image" class="cover-photo">
        <?php 
            include 'includes/profile-menu-bar-fake.php'; 
        ?>
        <?php
                    $profile_id = $_GET['id'];
                    $sql = "SELECT file_name FROM profile_photos WHERE user_id=$profile_id LIMIT 1";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    if (is_null($row)) {
                        $row['file_name'] = "https://i.pinimg.com/736x/c9/e3/e8/c9e3e810a8066b885ca4e882460785fa.jpg";
                    } elseif (!$row['file_name']) {
                        $row['file_name'] = "https://i.pinimg.com/736x/c9/e3/e8/c9e3e810a8066b885ca4e882460785fa.jpg";
                    } else {
                        $row['file_name'] = "img/" . $row['file_name'];
                    }
                ?>

                <img src="<?php echo $row['file_name']; ?>" alt="Profile Picture" class="profile-photo" style="width: 200px;">
    </header>


    <div class="about">
        <div class="about__title">
            <h3>Edit Post</h3>
        </div>

        <div class="about__details">

            <form action="process/post-edit.php" method="post" class="about__form">
                <?php
                    $post_id = $_GET['id'];
                    include 'includes/db.php';
                    $sql = "SELECT text FROM posts WHERE id=$post_id";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $text = $row["text"];
                ?>
                <input name="text" value="<?php echo $text; ?>" id="" cols="30" rows="10" class="post-edit__textarea"></input>
                <input type="hidden" name="post_id" value="<?php echo $_GET['id']; ?>">
                <input type="hidden" name="receiver_id" value="<?php echo $_GET['receiver_id']; ?>">

                <input type="submit" value="Repost" class="about__submit">

            </form>

        </div>

    </div>

</div>

</body>
</html>