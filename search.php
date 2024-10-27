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
    <body id="search">

        <?php include 'includes/profile-login-nav.php'; ?>

        <div class="search-results">

            <?php if(isset($_POST['search_query'])): ?>

            <!---------------------->
            <!--START SEARCH QUERY-->
            <!---------------------->

                <?php
                    $profile_id = $_SESSION['user_id'];
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

                <?php
                    $user_id = $_SESSION['user_id'];
                    $search_query = $_POST['search_query'];
                    $sql = "SELECT * FROM users WHERE (first_name LIKE '%$search_query%' OR last_name LIKE '%$search_query%') AND id <> $user_id";
                    $results = mysqli_query($conn, $sql);
                ?>

                <?php
                    $profile_id = $_SESSION['user_id'];
                    $sql = "SELECT * FROM friends WHERE user_id_one=$profile_id OR user_id_two=$profile_id";
                    $result = mysqli_query($conn, $sql);

                    $friends = array();

                    while($row1 = mysqli_fetch_assoc($result)) {
                        if ($row1['user_id_one'] == $profile_id) {
                            $friends[] = $row1['user_id_two'];
                        }

                        if ($row1['user_id_two'] == $profile_id) {
                            $friends[] = $row1['user_id_one'];
                        }
                    }

                    $num_friends = count($friends);
                ?>

                <?php while($row = mysqli_fetch_assoc($results)): ?>

                    <div class="container">

                        <div class="search-results__single">
                            <a href="profile.php?id=<?php echo $row['id']; ?>"><?php echo $row['first_name'] . ' ' . $row['last_name']. " (Profile)"; ?></a>

                            <!-- Put If statement here to see if you are already friends or not -->
    
                                <?php if(in_array($row['id'], $friends) == false) : ?>
                                    <form action="process/friend-request.php" method="post">
                                        <input type="hidden" name="requested_id" value="<?php echo $row['id']; ?>">
                                    
                                        <button>
                                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                                            <span>Add Friend</span>
                                        </button>
                                    </form>
                                <?php else : ?>
                                    <input type="hidden" name="requested_id" value="<?php echo $row['id']; ?>">
                                
                                    <a style="float: right;" href="profile.php?id=<?php echo $row['id']; ?>"><button>View Profile</button></a>
                                <?php endif; ?>
                        </div> <!--END SINGLE SEARCH RESULTS-->

                    </div> <!--END CONTAINER-->

                <?php endwhile; ?>

            <!---------------------->
            <!---END SEARCH QUERY--->
            <!---------------------->

            <?php else: ?>

            <!------------------->
            <!--START ALL USERS-->
            <!------------------->

            <?php
                $profile_id = $_SESSION['user_id'];
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

            <?php
                $user_id = $_SESSION['user_id'];
                $search_query = $_POST['search_query'];
                $sql = "SELECT * FROM users WHERE (first_name LIKE '%$search_query%' OR last_name LIKE '%$search_query%') AND id <> $user_id";
                $results = mysqli_query($conn, $sql);
            ?>

            <?php while($row = mysqli_fetch_assoc($results)): ?>

                <div class="container">

                    <div class="search-results__single">
                        <a href="profile.php?id=<?php echo $row['id']; ?>"><?php echo $row['first_name'] . ' ' . $row['last_name']. " (Profile)"; ?></a>

                        <!-- Put If statement here to see if you are already friends or not -->

                            <?php if(in_array($row['id'], $friends) == false) : ?>
                                <form action="process/friend-request.php" method="post">
                                    <input type="hidden" name="requested_id" value="<?php echo $row['id']; ?>">
                                
                                    <button>
                                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                                        <span>Add Friend</span>
                                    </button>
                                </form>
                            <?php else : ?>
                                <input type="hidden" name="requested_id" value="<?php echo $row['id']; ?>">
                            
                                <a style="float: right;" href="profile.php?id=<?php echo $row['id']; ?>"><button>View Profile</button></a>
                            <?php endif; ?>
                    </div> <!--END SINGLE SEARCH RESULTS-->

                </div> <!--END CONTAINER-->

            <?php endwhile; ?>

            <!------------------->
            <!---END ALL USERS--->
            <!------------------->

            <?php endif; ?>

        </div>

    </body>
</html>