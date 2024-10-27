<!doctype html>
<html lang="en">
    <head>

        <title>ZBOOK</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">

    </head>
    <body id="profile-about">

        <?php include 'includes/profile-login-nav.php'; ?>

        <div class="container">

            <header>
                <img src="img/background.jpeg" alt="Background Image" class="cover-photo">
                <?php
                    if ($_GET['id'] != $user_id) {
                        include 'includes/profile-menu-bar-fake.php'; 
                    } else {
                        include 'includes/profile-menu-bar.php';
                    }
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


            <div id="profile-single-photo">
                <div class="about__title">
                    <i class="fa fa-picture-o" aria-hidden="true"></i>
                    <h3>Photos</h3>

                </div>

                <div class="profile-photos">

                    <div class="row">

                        <img src="img/profile-photo.jpg" alt="">

                        <form>
                            <button>Delete</button>
                        </form>

                    </div>



                </div>

            </div>

        </div>

    </body>
</html>