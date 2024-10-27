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
                <?php include 'includes/profile-menu-bar-fake.php'; ?>
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


                        <form action="process/about-edit.php" method="post">
                            <?php
                                include 'includes/db.php';
                                $sql = "SELECT phone_number, email, bday, gender, first_name, last_name, password FROM users WHERE id=$user_id";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    // output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        $password = $row['password'];
                                        $first_name = $row['first_name'];
                                        $last_name = $row['last_name'];
                                        $phone_number = $row["phone_number"];
                                        $gender = $row["gender"];
                                        $bday = $row["bday"];
                                        $email = $row["email"];
                                    }
                                    // echo " HOLAR ";
                                    $year = substr($bday,0,4);
                                    // echo $year . " HOLAR ";
                                    $month = substr($bday,5,2);
                                    // echo $month . " HOLAR ";
                                    $day = substr($bday,8,10);
                                    // echo $day;
                                    
                                } else {
                                    echo "0 results";
                                }
                            ?>
                            <!-- <script type="text/javascript">
                                var pass = prompt("Please Enter Your Password To Edit");
                                while (pass != <?php // echo $password; ?>) {
                                    if (pass == null) {
                                        <?php ?>
                                    } else if (pass != <?php echo $password; ?>) {
                                        // <?php // header("Location: about-edit.php?id=$user_id"); ?>
                                    }
                                }
                            </script> -->
                            <div class="row">
                                <div class="one-of-four">
                                    First Name (Required)
                                </div>
                                <div class="three-of-four">
                                    <input name="first_name" required placeholder="First Name, Ex: John (Required)" value="<?php echo $first_name; ?>" class="about__details-phone-form">
                                </div>
                            </div>

                            <div class="row">
                                <div class="one-of-four">
                                    Last Name
                                </div>
                                <div class="three-of-four">
                                    <input name="last_name" placeholder="Last Name, Ex: Doe (Optional)" value="<?php echo $last_name; ?>" class="about__details-phone-form">
                                </div>
                            </div>

                            <div class="row">
                                <div class="one-of-four">
                                    Email (Required)
                                </div>
                                <div class="three-of-four">
                                    <input type="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Email Format Incorrect. Enter A Correct Email" name="email" placeholder="Email, Ex: 123@gmail.com (Required)" value="<?php echo $email; ?>" class="about__details-phone-email">
                                    <?php
                                        if (!$email) {
                                            echo '<script>alert("You Need To Enter An Email")</script>';
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="one-of-four">
                                    Password (Required)
                                </div>
                                <div class="three-of-four">
                                    <input type="pwd" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="Password, Ex: ILOVEcats10 (Required)" value="<?php echo $password; ?>" class="about__details-phone-form">
                                    <?php
                                        if(!$password) {
                                            echo '<script>alert(""Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters")</script>';
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="one-of-four">
                                    Phone Number
                                </div>
                                <div class="three-of-four">
                                    <input type="tel" name="phone_number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" title="Please Enter A Correct Phone Number Format (separate with hyphens). Ex: 123-456-7890" placeholder="Phone Number, Ex: 123-456-7890 (Optional)" value="<?php echo $phone_number; ?>" class="about__details-phone-form">
                                </div>
                            </div>

                            <div class="row">
                                <div class="one-of-four">
                                    Birth Date (Required)
                                </div>
                                <div class="three-of-four">
                                    <select name="month" required>
                                        <option value="1" <?php if ($month == "01") {echo "selected";} ?>>Jan</option>
                                        <option value="2" <?php if ($month == "02") {echo "selected";} ?>>Feb</option>
                                        <option value="3" <?php if ($month == "03") {echo "selected";} ?>>Mar</option>
                                        <option value="4" <?php if ($month == "04") {echo "selected";} ?>>Apr</option>
                                        <option value="5" <?php if ($month == "05") {echo "selected";} ?>>May</option>
                                        <option value="6" <?php if ($month == "06") {echo "selected";} ?>>Jun</option>
                                        <option value="7" <?php if ($month == "07") {echo "selected";} ?>>Jul</option>
                                        <option value="8" <?php if ($month == "08") {echo "selected";} ?>>Aug</option>
                                        <option value="9" <?php if ($month == "09") {echo "selected";} ?>>Sep</option>
                                        <option value="10" <?php if ($month == "10") {echo "selected";} ?>>Oct</option>
                                        <option value="11" <?php if ($month == "11") {echo "selected";} ?>>Nov</option>
                                        <option value="12" <?php if ($month == "12") {echo "selected";} ?>>Dec</option>
                                    </select>

                                    <select name="day" required>
                                        <option value="1" <?php if ($day == "01") {echo "selected";} ?>>1</option>
                                        <option value="2" <?php if ($day == "02") {echo "selected";} ?>>2</option>
                                        <option value="3" <?php if ($day == "03") {echo "selected";} ?>>3</option>
                                        <option value="4" <?php if ($day == "04") {echo "selected";} ?>>4</option>
                                        <option value="5" <?php if ($day == "05") {echo "selected";} ?>>5</option>
                                        <option value="6" <?php if ($day == "06") {echo "selected";} ?>>6</option>
                                        <option value="7" <?php if ($day == "07") {echo "selected";} ?>>7</option>
                                        <option value="8" <?php if ($day == "08") {echo "selected";} ?>>8</option>
                                        <option value="9" <?php if ($day == "09") {echo "selected";} ?>>9</option>
                                        <option value="10" <?php if ($day == "10") {echo "selected";} ?>>10</option>
                                        <option value="11" <?php if ($day == "11") {echo "selected";} ?>>11</option>
                                        <option value="12" <?php if ($day == "12") {echo "selected";} ?>>12</option>
                                        <option value="13"<?php if ($day == "13") {echo "selected";} ?>>13</option>
                                        <option value="14" <?php if ($day == "14") {echo "selected";} ?>>14</option>
                                        <option value="15" <?php if ($day == "15") {echo "selected";} ?>>15</option>
                                        <option value="16" <?php if ($day == "16") {echo "selected";} ?>>16</option>
                                        <option value="17" <?php if ($day == "17") {echo "selected";} ?>>17</option>
                                        <option value="18" <?php if ($day == "18") {echo "selected";} ?>>18</option>
                                        <option value="19" <?php if ($day == "19") {echo "selected";} ?>>19</option>
                                        <option value="20" <?php if ($day == "20") {echo "selected";} ?>>20</option>
                                        <option value="21" <?php if ($day == "21") {echo "selected";} ?>>21</option>
                                        <option value="22" <?php if ($day == "22") {echo "selected";} ?>>22</option>
                                        <option value="23" <?php if ($day == "23") {echo "selected";} ?>>23</option>
                                        <option value="24" <?php if ($day == "24") {echo "selected";} ?>>24</option>
                                        <option value="25" <?php if ($day == "25") {echo "selected";} ?>>25</option>
                                        <option value="26" <?php if ($day == "26") {echo "selected";} ?>>26</option>
                                        <option value="27" <?php if ($day == "27") {echo "selected";} ?>>27</option>
                                        <option value="28" <?php if ($day == "28") {echo "selected";} ?>>28</option>
                                        <option value="29" <?php if ($day == "29") {echo "selected";} ?>>29</option>
                                        <option value="30" <?php if ($day == "30") {echo "selected";} ?>>30</option>
                                        <option value="31" <?php if ($day == "31") {echo "selected";} ?>>31</option>
                                    </select>

                                    <select name="year" required>
                                        <option value="2021" <?php if ($year == "2021") {echo "selected";} ?>>2021</option>
                                        <option value="2020" <?php if ($year == "2020") {echo "selected";} ?>>2020</option>
                                        <option value="2019" <?php if ($year == "2019") {echo "selected";} ?>>2019</option>
                                        <option value="2018" <?php if ($year == "2018") {echo "selected";} ?>>2018</option>
                                        <option value="2017" <?php if ($year == "2017") {echo "selected";} ?>>2017</option>
                                        <option value="2016" <?php if ($year == "2016") {echo "selected";} ?>>2016</option>
                                        <option value="2015" <?php if ($year == "2015") {echo "selected";} ?>>2015</option>
                                        <option value="2014" <?php if ($year == "2014") {echo "selected";} ?>>2014</option>
                                        <option value="2013" <?php if ($year == "2013") {echo "selected";} ?>>2013</option>
                                        <option value="2012" <?php if ($year == "2012") {echo "selected";} ?>>2012</option>
                                        <option value="2011" <?php if ($year == "2011") {echo "selected";} ?>>2011</option>
                                        <option value="2010" <?php if ($year == "2010") {echo "selected";} ?>>2010</option>
                                        <option value="2009" <?php if ($year == "2009") {echo "selected";} ?>>2009</option>
                                        <option value="2008" <?php if ($year == "2008") {echo "selected";} ?>>2008</option>
                                        <option value="2007" <?php if ($year == "2007") {echo "selected";} ?>>2007</option>
                                        <option value="2006" <?php if ($year == "2006") {echo "selected";} ?>>2006</option>
                                        <option value="2005" <?php if ($year == "2005") {echo "selected";} ?>>2005</option>
                                        <option value="2004" <?php if ($year == "2004") {echo "selected";} ?>>2004</option>
                                        <option value="2003" <?php if ($year == "2003") {echo "selected";} ?>>2003</option>
                                        <option value="2002" <?php if ($year == "2002") {echo "selected";} ?>>2002</option>
                                        <option value="2001" <?php if ($year == "2001") {echo "selected";} ?>>2001</option>
                                        <option value="2000" <?php if ($year == "2000") {echo "selected";} ?>>2000</option>
                                        <option value="1999" <?php if ($year == "1999") {echo "selected";} ?>>1999</option>
                                        <option value="1998" <?php if ($year == "1998") {echo "selected";} ?>>1998</option>
                                        <option value="1997" <?php if ($year == "1997") {echo "selected";} ?>>1997</option>
                                        <option value="1996" <?php if ($year == "1996") {echo "selected";} ?>>1996</option>
                                        <option value="1995" <?php if ($year == "1995") {echo "selected";} ?>>1995</option>
                                        <option value="1994" <?php if ($year == "1994") {echo "selected";} ?>>1994</option>
                                        <option value="1993" <?php if ($year == "1993") {echo "selected";} ?>>1993</option>
                                        <option value="1992" <?php if ($year == "1992") {echo "selected";} ?>>1992</option>
                                        <option value="1991" <?php if ($year == "1991") {echo "selected";} ?>>1991</option>
                                        <option value="1990" <?php if ($year == "1990") {echo "selected";} ?>>1990</option>
                                        <option value="1989" <?php if ($year == "1989") {echo "selected";} ?>>1989</option>
                                        <option value="1988" <?php if ($year == "1988") {echo "selected";} ?>>1988</option>
                                        <option value="1987" <?php if ($year == "1987") {echo "selected";} ?>>1987</option>
                                        <option value="1986" <?php if ($year == "1986") {echo "selected";} ?>>1986</option>
                                        <option value="1985" <?php if ($year == "1985") {echo "selected";} ?>>1985</option>
                                        <option value="1984" <?php if ($year == "1984") {echo "selected";} ?>>1984</option>
                                        <option value="1983" <?php if ($year == "1983") {echo "selected";} ?>>1983</option>
                                        <option value="1982" <?php if ($year == "1982") {echo "selected";} ?>>1982</option>
                                        <option value="1981" <?php if ($year == "1981") {echo "selected";} ?>>1981</option>
                                        <option value="1980" <?php if ($year == "1980") {echo "selected";} ?>>1980</option>
                                        <option value="1979" <?php if ($year == "1979") {echo "selected";} ?>>1979</option>
                                        <option value="1978" <?php if ($year == "1978") {echo "selected";} ?>>1978</option>
                                        <option value="1977" <?php if ($year == "1977") {echo "selected";} ?>>1977</option>
                                        <option value="1976" <?php if ($year == "1976") {echo "selected";} ?>>1976</option>
                                        <option value="1975" <?php if ($year == "1975") {echo "selected";} ?>>1975</option>
                                        <option value="1974" <?php if ($year == "1974") {echo "selected";} ?>>1974</option>
                                        <option value="1973" <?php if ($year == "1973") {echo "selected";} ?>>1973</option>
                                        <option value="1972" <?php if ($year == "1972") {echo "selected";} ?>>1972</option>
                                        <option value="1971" <?php if ($year == "1971") {echo "selected";} ?>>1971</option>
                                        <option value="1970" <?php if ($year == "1970") {echo "selected";} ?>>1970</option>
                                        <option value="1969" <?php if ($year == "1969") {echo "selected";} ?>>1969</option>
                                        <option value="1968" <?php if ($year == "1968") {echo "selected";} ?>>1968</option>
                                        <option value="1967" <?php if ($year == "1967") {echo "selected";} ?>>1967</option>
                                        <option value="1966" <?php if ($year == "1966") {echo "selected";} ?>>1966</option>
                                        <option value="1965" <?php if ($year == "1965") {echo "selected";} ?>>1965</option>
                                        <option value="1964" <?php if ($year == "1964") {echo "selected";} ?>>1964</option>
                                        <option value="1963" <?php if ($year == "1963") {echo "selected";} ?>>1963</option>
                                        <option value="1962" <?php if ($year == "1962") {echo "selected";} ?>>1962</option>
                                        <option value="1961" <?php if ($year == "1961") {echo "selected";} ?>>1961</option>
                                        <option value="1960" <?php if ($year == "1960") {echo "selected";} ?>>1960</option>
                                        <option value="1959" <?php if ($year == "1959") {echo "selected";} ?>>1959</option>
                                        <option value="1958" <?php if ($year == "1958") {echo "selected";} ?>>1958</option>
                                        <option value="1957" <?php if ($year == "1957") {echo "selected";} ?>>1957</option>
                                        <option value="1956" <?php if ($year == "1956") {echo "selected";} ?>>1956</option>
                                        <option value="1955" <?php if ($year == "1955") {echo "selected";} ?>>1955</option>
                                        <option value="1954" <?php if ($year == "1954") {echo "selected";} ?>>1954</option>
                                        <option value="1953" <?php if ($year == "1953") {echo "selected";} ?>>1953</option>
                                        <option value="1952" <?php if ($year == "1952") {echo "selected";} ?>>1952</option>
                                        <option value="1951" <?php if ($year == "1951") {echo "selected";} ?>>1951</option>
                                        <option value="1950" <?php if ($year == "1950") {echo "selected";} ?>>1950</option>
                                        <option value="1949" <?php if ($year == "1949") {echo "selected";} ?>>1949</option>
                                        <option value="1948" <?php if ($year == "1948") {echo "selected";} ?>>1948</option>
                                        <option value="1947" <?php if ($year == "1947") {echo "selected";} ?>>1947</option>
                                        <option value="1946" <?php if ($year == "1946") {echo "selected";} ?>>1946</option>
                                        <option value="1945" <?php if ($year == "1945") {echo "selected";} ?>>1945</option>
                                        <option value="1944" <?php if ($year == "1944") {echo "selected";} ?>>1944</option>
                                        <option value="1943" <?php if ($year == "1943") {echo "selected";} ?>>1943</option>
                                        <option value="1942" <?php if ($year == "1942") {echo "selected";} ?>>1942</option>
                                        <option value="1941" <?php if ($year == "1941") {echo "selected";} ?>>1941</option>
                                        <option value="1940" <?php if ($year == "1940") {echo "selected";} ?>>1940</option>
                                        <option value="1939" <?php if ($year == "1939") {echo "selected";} ?>>1939</option>
                                        <option value="1938" <?php if ($year == "1938") {echo "selected";} ?>>1938</option>
                                        <option value="1937" <?php if ($year == "1937") {echo "selected";} ?>>1937</option>
                                        <option value="1936" <?php if ($year == "1936") {echo "selected";} ?>>1936</option>
                                        <option value="1935" <?php if ($year == "1935") {echo "selected";} ?>>1935</option>
                                        <option value="1934" <?php if ($year == "1934") {echo "selected";} ?>>1934</option>
                                        <option value="1933" <?php if ($year == "1933") {echo "selected";} ?>>1933</option>
                                        <option value="1932" <?php if ($year == "1932") {echo "selected";} ?>>1932</option>
                                        <option value="1931" <?php if ($year == "1931") {echo "selected";} ?>>1931</option>
                                        <option value="1930" <?php if ($year == "1930") {echo "selected";} ?>>1930</option>
                                        <option value="1929" <?php if ($year == "1929") {echo "selected";} ?>>1929</option>
                                        <option value="1928" <?php if ($year == "1928") {echo "selected";} ?>>1928</option>
                                        <option value="1927" <?php if ($year == "1927") {echo "selected";} ?>>1927</option>
                                        <option value="1926" <?php if ($year == "1926") {echo "selected";} ?>>1926</option>
                                        <option value="1925" <?php if ($year == "1925") {echo "selected";} ?>>1925</option>
                                        <option value="1924" <?php if ($year == "1924") {echo "selected";} ?>>1924</option>
                                        <option value="1923" <?php if ($year == "1923") {echo "selected";} ?>>1923</option>
                                        <option value="1922" <?php if ($year == "1922") {echo "selected";} ?>>1922</option>
                                        <option value="1921" <?php if ($year == "1921") {echo "selected";} ?>>1921</option>
                                        <option value="1920" <?php if ($year == "1920") {echo "selected";} ?>>1920</option>
                                        <option value="1919" <?php if ($year == "1919") {echo "selected";} ?>>1919</option>
                                        <option value="1918" <?php if ($year == "1918") {echo "selected";} ?>>1918</option>
                                        <option value="1917" <?php if ($year == "1917") {echo "selected";} ?>>1917</option>
                                        <option value="1916" <?php if ($year == "1916") {echo "selected";} ?>>1916</option>
                                        <option value="1915" <?php if ($year == "1915") {echo "selected";} ?>>1915</option>
                                        <option value="1914" <?php if ($year == "1914") {echo "selected";} ?>>1914</option>
                                        <option value="1913" <?php if ($year == "1913") {echo "selected";} ?>>1913</option>
                                        <option value="1912" <?php if ($year == "1912") {echo "selected";} ?>>1912</option>
                                        <option value="1911" <?php if ($year == "1911") {echo "selected";} ?>>1911</option>
                                        <option value="1910" <?php if ($year == "1910") {echo "selected";} ?>>1910</option>
                                        <option value="1909" <?php if ($year == "1909") {echo "selected";} ?>>1909</option>
                                        <option value="1908" <?php if ($year == "1908") {echo "selected";} ?>>1908</option>
                                        <option value="1907" <?php if ($year == "1907") {echo "selected";} ?>>1907</option>
                                        <option value="1906" <?php if ($year == "1906") {echo "selected";} ?>>1906</option>
                                        <option value="1905" <?php if ($year == "1905") {echo "selected";} ?>>1905</option>
                                    </select>
                                </div>
                            </div>


                            <div class="row">
                                <div class="one-of-four">
                                    Gender
                                </div>
                                <div class="three-of-four">
                                    <input type="radio" name="gender" <?php if ($gender == "male") {echo "checked";} ?> value="male"> Male
                                    <br>
                                    <input type="radio" name="gender" <?php if ($gender == "female") {echo "checked";} ?> value="female"> Female
                                    <br>
                                    <input type="radio" name="gender" <?php if ($gender == "NA") {echo "checked";} ?> value="NA"> N/A
                                </div>
                            </div>

                            <div class="row about__edit-btn">
                                <div class="one-of-four">
                                    &zwnj;
                                </div>
                                <div class="three-of-four">
                                    <button type="submit" class="about__details-btn">Update</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>

            <div class="about">

                <div class="about__details">
                    <div class="about__details-left">
                        <ul>
                            <li>Profile Photo 
                            <?php echo "<br>"; ?>
                            <?php echo "(Leave this empty if you wish to use the default profile picture)"; ?></li>
                        </ul>
                    </div>

                    <div class="about__details-right">


                        <form action="process/profile-photo-create.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="one-of-four">
                                    Upload Photo
                                </div>
                                <div class="three-of-four">
                                    <input type="file" name="photo">  <!-- Might make an issue if the file is in a different folder -->
                                </div>
                                
                            </div>
                            

                            <div class="row about__edit-btn">
                                <div class="one-of-four">
                                    &zwnj;
                                </div>
                                <div class="three-of-four">
                                    <button type="submit" class="about__details-btn">Update</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>

        </div>
        

    </body>
</html>