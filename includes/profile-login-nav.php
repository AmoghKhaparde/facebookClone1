<?php // session_start(); ?>
<nav class="login-nav">

    <form action="search.php" method="post">
        <input type="text" placeholder="Enter a specific name or enter an empty query for a list of all existing users" name="search_query">

        <button>
            <i class="fa fa-search" aria-hidden="true"></i>
        </button>

    </form>

    <div class="profile-nav__options container-fluid">

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
        <a class="profile-nav__logout" href="process/endsession.php?id=<?php echo $user_id; ?>">Logout</a>
    </div>
</nav>