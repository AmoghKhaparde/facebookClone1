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
    <body id="profile">

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


            <div id="left-panel">
                <div class="intro white-background">
                    <i class="fa fa-globe" aria-hidden="true"></i>
                    <h2>Home Page</h2>
                    <a> - Welcome!</a>
                    <a> - This is where you'll be able to see friends and posts</a>
                </div>

                <div class="friends white-background">

                    <?php
                    $profile_id = $_GET['id'];
                    $sql = "SELECT * FROM friends WHERE user_id_one=$profile_id OR user_id_two=$profile_id";
                    $result = mysqli_query($conn, $sql);

                    $friends = array();

                    while($row = mysqli_fetch_assoc($result)) {
                        if ($row['user_id_one'] == $profile_id) {
                            $friends[] = $row['user_id_two'];
                        }

                        if ($row['user_id_two'] == $profile_id) {
                            $friends[] = $row['user_id_one'];
                        }
                    }

                    $num_friends = count($friends);

                    ?>

                    <div class="friends__heading">
                        <i class="fa fa-users" aria-hidden="true"></i>

                        <h2>Friends:    <?php echo $num_friends; ?> </h2>
                    </div>


                    <div class="container">
                        <div class="row">

                            <?php for($i = 0; $i < $num_friends; $i++): ?>
                                    <div class="one-of-three">
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

                                        <a>
                                            <?php if($photo != 0) : ?>
                                                
                                            <a href="profile.php?id=<?php echo $friend_id; ?>"><img src="img/<?php echo $photo_row['file_name']; ?>" alt="Friend"></a>

                                            <?php endif; ?>

                                            <?php if($photo == 0): ?>
                                                
                                                <a href="profile.php?id=<?php echo $friend_id; ?>"><img src="<?php echo "https://i.pinimg.com/736x/c9/e3/e8/c9e3e810a8066b885ca4e882460785fa.jpg"; ?>" alt="Friend"></a>
            
                                            <?php endif; ?>
                                        </a>

                                        <?php
                                        $user_id = $_SESSION['user_id'];
                                        $name_sql = "SELECT * FROM users WHERE id=$friend_id LIMIT 1";
                                        $name_result = mysqli_query($conn, $name_sql);
                                        $name_row = mysqli_fetch_assoc($name_result);
                                        // print_r($name_row);
                                        // print_r($friend_id);
                                        ?>
                                        <div style="text-align: center">
                                        <?php if(($_GET['id'] != $user_id) && ($friends[$i] == $user_id)) : ?>
                                            <a href="profile.php?id=<?php echo $friend_id; ?>" style="color: blue;"><?php echo $name_row['first_name'] . ' ' . $name_row['last_name'] . " (You)"; ?></a>
                                        <?php else : ?>
                                            <a href="profile.php?id=<?php echo $friend_id; ?>" style="color: blue;"><?php echo $name_row['first_name'] . ' ' . $name_row['last_name'] . " (Profile)"; ?></a> 
                                        <?php endif; ?>
                                        </div>
                                    </div>

                            <?php endfor; ?>

                        </div> <!--END ROW-->
                    </div>




                </div>



            </div>

            <?php
            $user_id = $_SESSION['user_id'];
            $profile_id = $_GET['id'];
            $sql = "SELECT * FROM friends WHERE (user_id_one=$user_id AND user_id_two=$profile_id) OR (user_id_one=$profile_id AND user_id_two=$user_id)";
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);
            ?>

            <?php if($num_rows > 0 || $user_id == $profile_id): ?>

            <div id="right-panel">
                <?php
                $viewing_id = $_GET['id'];
                $sql = "SELECT * FROM users WHERE id=$viewing_id LIMIT 1";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $first_name = $row['first_name'];
                ?>    

                <?php if($_GET['id'] == $user_id) : ?>
                    <div class="status-update white-background">
                        <form style="text-align: center;" action="process/post-create.php" method="post">
                            <input type="hidden" name="receiver_id" value="<?php echo $_GET['id']; ?>">
                            <input type="text" name="text" placeholder="What's on your mind?">
                            <input type="submit" value="Post">
                        </form>
                    </div>
                <?php else : ?>
                    <div class="status-update white-background">
                        <form style="text-align: center;" action="process/post-create.php" method="post">
                            Viewing <?php echo $first_name ?>'s Posts
                        </form>
                    </div>
                <?php endif; ?>

                <?php
                $receiver_id = $_GET['id'];
                $sql = "SELECT * FROM posts WHERE receiver_id=$receiver_id ORDER BY id DESC";
                $result = mysqli_query($conn, $sql);
                $row1 = mysqli_fetch_assoc($result);
                ?>

                <?php if(($_GET['id'] != $user_id) && (is_null($row1))) : ?>
                    <div class="profile-wall">

                        <div class="text-wall-post white-background">
                            <div class="text-wall-post__details">

                                <h2 style="text-align: center;padding-left: 5px;padding-top: 50px;"><b>No Posts Yet</b><h2>

                            <div class="text-wall-post__content">
                                
                        </div>

                    </div> <!--END TEXT WALL POST-->
                <?php endif; ?>

                <?php
                $receiver_id = $_GET['id'];
                $sql = "SELECT * FROM posts WHERE receiver_id=$receiver_id ORDER BY id DESC";
                $result = mysqli_query($conn, $sql);
                ?>

                <?php while($row = mysqli_fetch_assoc($result)): ?>
                
                <div class="profile-wall">

                    <div class="text-wall-post white-background">
                        <div class="text-wall-post__details">

                            <?php
                            $poster_id = $row['poster_id'];
                            $photo_sql = "SELECT * FROM profile_photos WHERE user_id=$poster_id LIMIT 1";
                            $photo_result = mysqli_query($conn, $photo_sql);
                            $photo_row = mysqli_fetch_assoc($photo_result);
                            ?>

                            <img src="img/<?php echo $photo_row['file_name']; ?>" alt="">

                            <?php
                            $poster_id = $row['poster_id'];
                            $name_sql = "SELECT * FROM users WHERE id=$poster_id LIMIT 1";
                            $name_result = mysqli_query($conn, $name_sql);
                            $name_row = mysqli_fetch_assoc($name_result);
                            ?>

                            <p class="text-wall-post__name"><?php echo $name_row['first_name'] . ' ' . $name_row['last_name']; ?></p>
                        </div>

                        <div class="text-wall-post__content">
                            <p><?php echo $row['text']; ?></p>
                            <form action="process/like-create.php?id=<?php echo $_GET['id']; ?>" method="post" class="text-wall-post__actions">
                                <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">

                                <?php
                                $post_id = $row['id'];
                                $likes_sql = "SELECT * FROM post_likes WHERE post_id=$post_id";
                                $likes_result = mysqli_query($conn, $likes_sql);
                                $likes_num = mysqli_num_rows($likes_result);
                                ?>

                                <button><i class="fa fa-thumbs-up" aria-hidden="true"></i><h3>Likes: <?php echo $likes_num; ?></h3></button>

                            </form>

                            <?php if($row['poster_id'] == $_SESSION['user_id']): ?>

                            <a href="post-edit.php?id=<?php echo $row['id']; ?>&receiver_id=<?php echo $receiver_id; ?>" class="text-wall-post__actions">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                Edit
                            </a>

                            <?php endif; ?>


                            <?php if($row['poster_id'] == $_SESSION['user_id'] || $_GET['id'] == $_SESSION['user_id']): ?>

                            <form action="process/post-delete.php" method="post" class="text-wall-post__actions">
                                <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="receiver_id" value="<?php echo $receiver_id; ?>">

                                <button>
                                    <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                    Delete
                                </button>
                            </form>

                            <?php endif; ?>



                        </div>

                    </div> <!--END TEXT WALL POST-->

                </div>
                    <?php endwhile; ?>
                <?php
                $viewing_id = $_GET['id'];
                $sql = "SELECT * FROM users WHERE id=$viewing_id LIMIT 1";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $first_name = $row['first_name'];
                ?>
                <?php if($_GET['id'] != $user_id) : ?>
                    <a href="profile.php?id=<?php echo $user_id; ?>"><button style="margin-left: 31.5%;margin-top: 50px;background-color: #008CBA;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;">Go Back To Your Profile</button></a>
                <?php endif; ?>
                <?php if($_GET['id'] != $user_id) : ?>
                    <a href="photos.php?id=<?php echo $_GET['id']; ?>"><button style="margin-left: 31%;margin-top: 50px;background-color: #008CBA;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;">Go To <?php echo $first_name; ?>'s Photos</button></a>
                <?php endif; ?>
                <?php if($_GET['id'] != $user_id) : ?>
                    <a href="friends.php?id=<?php echo $_GET['id']; ?>"><button style="margin-bottom: 50px;margin-left: 31%;margin-top: 50px;background-color: #008CBA;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;">Go To <?php echo $first_name; ?>'s Friends Page</button></a>
                <?php endif; ?>
            </div>

            <?php else: ?>

                <div class="right-panel">
                <div class="status-update white-background">
                        <h4 style="text-align: center;">You are not friends with this person. Friend them to view their profile.</h4>
                    </div>
                </div>

            <?php endif; ?>

        </div>

    </body>
</html>