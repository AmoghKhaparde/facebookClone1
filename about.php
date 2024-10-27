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
                    $profile_id = $_SESSION['user_id'];
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
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <h3>About</h3>
                </div>

                <div class="about__details">
                    <div class="about__details-left">
                        <ul>
                            <li>Contact and Basic Info</li>
                        </ul>
                    </div>
                    
                    <div class="about__details-right">

                        <?php
                        $user_id = $_SESSION['user_id'];
                        $sql = "SELECT * FROM users WHERE id=$user_id LIMIT 1";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        ?>

                        <div class="row">   
                            <div class="one-of-four">
                                First Name
                            </div>
                            <div class="three-of-four">
                                <?php
                                    if ($row['first_name']) {
                                        echo $row['first_name'];
                                    } else {
                                        echo "N/A";
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="row">   
                            <div class="one-of-four">
                                Last Name
                            </div>
                            <div class="three-of-four">
                                <?php
                                    if ($row['last_name']) {
                                        echo $row['last_name'];
                                    } else {
                                        echo "N/A";
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="one-of-four">
                                Email
                            </div>
                            <div class="three-of-four">
                            <?php 
                                echo $row['email'];
                            ?>
                            </div>
                        </div>
                        
                        <div class="row">   
                            <div class="one-of-four">
                                Password
                            </div>
                            <div class="three-of-four">
                                <?php
                                    if ($row['password']) {
                                        $stringsa = "";
                                        for ($x = 1; $x <= strlen($row['password']); $x++) {
                                            $stringsa .= "* ";
                                        }
                                        echo $stringsa;
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="one-of-four">
                                Mobile Phone
                            </div>
                            <div class="three-of-four">
                                <?php 
                                    echo $row['phone_number'];
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="one-of-four">
                                Birth Date
                            </div>
                            <div class="three-of-four">
                                <?php
                                    echo $row['bday'];
                                ?>
                            </div>
                        </div>


                        <div class="row">
                            <div class="one-of-four">
                                Gender
                            </div>
                            <div class="three-of-four">
                                <?php if ($row['gender'] == "NA") {echo "N/A";} else if ($row['gender'] == "male") {echo "Male";} else {echo "Female";} ?>
                            </div>
                        </div>
                        
                        <?php
                        $user_id = $_SESSION['user_id'];
                        $sql = "SELECT file_name FROM profile_photos WHERE user_id=$user_id LIMIT 1";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        ?>

                        <div class="row">
                            <div class="one-of-four">
                                Profile Photo
                            </div>
                            <div class="three-of-four">
                                <?php if ((is_null($row)) || ($row['file_name'] == "")) {echo "N/A (Displaying default profile picture)";} else {echo $row['file_name'];} ?>
                            </div>
                        </div>

                        <div class="row about__edit-btn">
                            <div class="one-of-four">
                                &zwnj;
                            </div>
                            <div class="three-of-four">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                <a href="passkey-about-edit.php?id=<?php echo $user_id; ?>">Edit</a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>





    </body>
</html>