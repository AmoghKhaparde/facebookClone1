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

    <nav class="login-nav">
        <img src="img/zbook-logo.png" alt="" class="nav__zbook-logo">

        <form action="search.php" method="post">
            <input type="text" placeholder="Enter a specific name or enter an empty query for a list of all existing users" name="search_query">

            <button>
                <i class="fa fa-search" aria-hidden="true"></i>
            </button>

        </form>

        <div class="profile-nav__options">

            <?php
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT * FROM users WHERE id=$user_id LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            ?>

            <a class="profile-nav__name-link"><span class="profile-nav__name"><?php echo $row['first_name'] ?></span></a>
            <a href="profile.php?id=<?php echo $user_id; ?>"><span class="profile-nav__home">Home</span></a>
            <a href="friends-accept.php" class="profile-nav__friends">
                <i class="fa fa-users" aria-hidden="true"></i>

                <?php
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT * FROM friend_requests WHERE requested_id=$user_id";
                $results = mysqli_query($conn, $sql);
                $num_results = mysqli_num_rows($results);
                ?>

                <?php if($num_results >= 0): ?>

                <span class="profile-nav__friends-num"><?php echo $num_results; ?></span>

                <?php endif; ?>
            </a>
        </div>
    </nav>

    <div class="search-results">
    <div class="container">

        <?php
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM friend_requests WHERE requested_id=$user_id";
        $result = mysqli_query($conn, $sql);
        ?>

        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        
        <div class="search-results__single">
            <img src="img/profile-photo.jpg" alt="">

            <?php
            $requester_id = $row['requester_id'];
            $name_sql = "SELECT * FROM users WHERE id=$requester_id LIMIT 1";
            $name_result = mysqli_query($conn, $name_sql);
            $name_row = mysqli_fetch_assoc($name_result);
            ?>

            <a><?php echo $name_row['first_name'] . ' ' . $name_row['last_name']; ?></a>

            <form action="process/friend-accept.php" method="POST">
                <input type="hidden" name="requester_id" value="<?php echo $requester_id; ?>">

                <button>
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                    <span>Accept Request</span>
                </button>
            </form>
        </div>

        <?php endwhile; ?>

        <?php if($num_results == 0) : ?>
            <div class="search-results__single">
                <h3 style="text-align: center;"><a>No Friend Requests At The Moment</a></h3>
                <a href="profile.php?id=<?php echo $user_id; ?>"><button style="margin-left: 23%;margin-top: 50px;background-color: #008CBA;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;">Go Back To Profile Page</button></a>
            </div>
        <?php endif; ?>
        

    </div>


</div>







</body>
</html>