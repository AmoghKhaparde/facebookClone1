<?php
include 'includes/permission.php';
include 'includes/db.php';
$user_id = $_SESSION['user_id'];
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
            <div id="profile-photos">
                <div class="about__title">
                    <i class="fa fa-picture-o" aria-hidden="true"></i>
                    <?php
                    $viewing_id = $_GET['id'];
                    $sql = "SELECT * FROM users WHERE id=$viewing_id LIMIT 1";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $first_name = $row['first_name'];
                    ?>
                    <h3>Photos (Viewing <?php echo $first_name; ?>'s Photos)</h3>
                    <?php
                    $user_id = $_SESSION['user_id'];
                    ?>
                    <?php if($_GET['id'] == $user_id) : ?>
                        <form action="process/photo-create.php" method="post" enctype="multipart/form-data">
                            <input type="file" name="photo">
                            <button>+Add</button>
                        </form>
                    <?php endif; ?>
                </div>

                <div class="profile-photos">

                    <div class="row">

                        <?php
                        $user_id = $_GET['id'];
                        $sql = "SELECT * FROM photos WHERE user_id=$user_id LIMIT 1";
                        $result = mysqli_query($conn, $sql);
                        $row1 = mysqli_fetch_assoc($result);
                        ?>

                        <?php
                            if (is_null($row1)) {
                                echo "<h2 style='text-align: center;padding-top: 50px;'><b>No Photos Available</b></h2>";
                            }
                        ?>

                        <?php
                        $user_id = $_GET['id'];
                        $sql = "SELECT * FROM photos WHERE user_id=$user_id";
                        $result = mysqli_query($conn, $sql);
                        ?>

                        <?php while($row = mysqli_fetch_assoc($result)): ?>

                        <div class="one-of-four">
                            <a><img src="img/<?php echo $row['file_name']; ?>" alt="" style="width: 100%; border: 5px solid black"></a>
                        </div>

                        <?php endwhile; ?>

                    </div> <!--END ROW-->
                    

                </div>

            </div>
            <?php
            $viewing_id = $_GET['id'];
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT * FROM users WHERE id=$viewing_id LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $first_name = $row['first_name'];
            ?>
            <div class="profile_photos" style="background-color: white;padding-bottom: 40px;display: flex;">
                <?php if($_GET['id'] != $user_id) : ?>
                    <a style="padding-left: 60px;" href="profile.php?id=<?php echo $_GET['id']; ?>"><button style="margin-top: 50px;background-color: #008CBA;border: none;color: white;padding: 15px 42px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;">Go Back To <?php echo $first_name; ?>'s Profile Page</button></a>
                <?php endif; ?>
                <?php if($_GET['id'] != $user_id) : ?>
                    <a style="padding-left: 20px;" href="profile.php?id=<?php echo $user_id; ?>"><button style="margin-top: 50px;background-color: #008CBA;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;">Go To Your Profile Page</button></a>
                <?php endif; ?>
                <?php if($_GET['id'] != $user_id) : ?>
                    <a style="padding-left: 20px;" href="friends.php?id=<?php echo $_GET['id']; ?>"><button style="margin-top: 50px;background-color: #008CBA;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;">Go To <?php echo $first_name; ?>'s Friends Page</button></a>
                <?php endif; ?>
            </div>

        </div>

    </body>
</html>