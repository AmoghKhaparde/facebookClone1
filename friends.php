<?php
include 'includes/permission.php';
include 'includes/db.php';
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


            <div id="profile-friends">
                <div class="about__title">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    <?php
                    $viewing_id = $_GET['id'];
                    $sql = "SELECT * FROM users WHERE id=$viewing_id LIMIT 1";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $first_name = $row['first_name'];
                    ?>
                    <h3>Friends (Viewing <?php echo $first_name; ?>'s Friends)</h3>
                </div>

                <?php
                    $profile_id = $_GET['id'];
                    $sql = "SELECT * FROM friends WHERE user_id_two=$profile_id OR user_id_one=$profile_id";
                    $result = mysqli_query($conn, $sql);

                    $friends = array();

                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['user_id_one'] == $profile_id) {
                            $friends[] = $row['user_id_two'];
                        }

                        if ($row['user_id_two'] == $profile_id) {
                            $friends[] = $row['user_id_one'];
                        }
                    }
                    $num_friends = count($friends);
                ?>

                <!-- Everything works till here -->

                <div class="profile-friends__list">

                    <?php for($i = 0; $i < $num_friends; $i++): ?>

                        <div class="row">
                            <div class="one-of-one" style="margin: 0px;">
                                <?php
                                $friend_id = $friends[$i];
                                $photo_sql = "SELECT * FROM profile_photos WHERE user_id=$friend_id LIMIT 1";
                                $photo_result = mysqli_query($conn, $photo_sql);
                                $photo_row = mysqli_fetch_assoc($photo_result);
                                if (isset($photo_row['file_name'])) {
                                    $photo = strlen($photo_row['file_name']);
                                } else {
                                    $photo = 0;
                                }
                                ?>

                                <a href="profile.php?id=<?php echo $friend_user_id; ?>">
                                    <?php if($photo != 0) : ?>
                                        
                                    <img style="margin: 0px;" src="img/<?php echo $photo_row['file_name']; ?>" alt="Friend">

                                    <?php endif; ?>

                                    <?php if($photo == 0): ?>
                                        
                                        <img style="margin: 0px;" src="<?php echo "https://i.pinimg.com/736x/c9/e3/e8/c9e3e810a8066b885ca4e882460785fa.jpg"; ?>" alt="Friend">
    
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="one-of-two">

                                <div class="search-results__single">
                                    <?php
                                    $friend_user_id = $friends[$i];
                                    $sql = "SELECT * FROM users WHERE id=$friend_user_id";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    ?>
                                    <?php if(($_GET['id'] != $user_id) && ($friends[$i] == $user_id)) : ?>
                                        <a style="margin-top: 20px;margin-right: 50px;margin-left: 50px;float:left;font-size: 20px;margin-top: 19px;color: blue;" href="profile.php?id=<?php echo $friend_user_id; ?>"><?php echo $row['first_name'] . ' ' . $row['last_name'] .  " (You)"; ?></a>
                                    <?php else: ?>
                                        <a style="margin-top: 20px;margin-right: 50px;margin-left: 50px;float:left;font-size: 20px;margin-top: 19px;color: blue;" href="profile.php?id=<?php echo $friend_user_id; ?>"><?php echo $row['first_name'] . ' ' . $row['last_name'] .  " (Click To See Profile)"; ?></a>
                                    <?php endif; ?>
                                        <?php if($_GET['id'] == $user_id) : ?>
                                        <form style="display: flex;padding-top: 10px;" action="process/friend-delete.php" method="post">
                                            <input type="hidden" name="friend_user_id" value="<?php echo $friend_user_id; ?>">
                                            <button style="margin-left: 30px;float: right;background-color: #008CBA;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;">Unfriend</button>
                                        </form>
                                    <?php endif; ?>
                                </div>

                            </div>

                        </div> <!--END ROW-->

                        <hr style="margin-bottom: 10px;">

                    <?php endfor; ?>
                    

                </div>
                <?php
                $viewing_id = $_GET['id'];
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT * FROM users WHERE id=$viewing_id LIMIT 1";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $first_name = $row['first_name'];
                ?>
                <div class="smth" style="background-color: white;padding-bottom: 40px;display: flex;">
                    <?php if($_GET['id'] != $user_id) : ?>
                        <a style="padding-left: 60px;" href="profile.php?id=<?php echo $_GET['id']; ?>"><button style="margin-top: 50px;background-color: #008CBA;border: none;color: white;padding: 15px 42px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;">Go Back To <?php echo $first_name; ?>'s Profile Page</button></a>
                    <?php endif; ?>
                    <?php if($_GET['id'] != $user_id) : ?>
                        <a style="padding-left: 20px;" href="profile.php?id=<?php echo $user_id; ?>"><button style="margin-top: 50px;background-color: #008CBA;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;">Go To Your Profile Page</button></a>
                    <?php endif; ?>
                    <?php if($_GET['id'] != $user_id) : ?>
                        <a style="padding-left: 20px;" href="photos.php?id=<?php echo $_GET['id']; ?>"><button style="margin-top: 50px;background-color: #008CBA;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;">Go To <?php echo $first_name; ?>'s Photos</button></a>
                    <?php endif; ?>
                </div>

            </div>
            
        </div>

    </body>
</html>