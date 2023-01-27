<?php
session_start();

    include("../php/connection.php");
    include("../php/functions.php");
    $user_data = check_login($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/dashboard_menu_style.css">
    <link rel="stylesheet" href="../css/dashboard_style.css">
    <title>Document</title>
</head>
<body>

    <div class="preloader">
        <img class="preloader-logo" src="../assets/logo_color.png" alt="logo_preloader">
    </div>

    <div class="navbar">
        <button class="c-hamburger c-hamburger--htx">
            <span>toggle menu</span>
        </button>
        <nav class="sub-menu open">
            <ul class="list-unstyled">
                <li><a href="#home">Home</a></li>
                <li><a href="#profile">Profile</a></li>
                <li><a href="#event">Events</a></li>
                <?php
                $usn = $user_data['USN'];
                $res1=mysqli_query($con, "CALL CheckIfAdmin('$usn', @ausn)");
                $res = mysqli_query($con, "SELECT @ausn as usn");
                $row = mysqli_fetch_assoc($res);
                if($row['usn']!=null) {
                    $display = 'flex';
                    echo '<li><a href="#admin">Admin</a></li>';
                }
                ?>  
                <li><a href="../php/logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>

    <div id="home">
        <div class="hero-container">
            <h3>Welcome,<br><span><?php echo ucwords(strtolower($user_data['FName'])); ?></span> <br> <span> <?php echo ucwords(strtolower($user_data['LName']));?></span>.</h3>
        </div>
        <div class="hero-anti-container">
            <img src="../assets/wordmark_2.png" alt="" class="home-logo">
            <img src="../assets/merch.png" alt="" class="merch">
            <div class="pay-text-container">
                <h3>Get access to Workshops, <br> Events, <br> Courses & <br> Goodies!</h3>
                <a href="../php/payment.php">PAY NOW!</a>
            </div>
        </div>
    </div>

    <?php
    $usn = $user_data['USN'];
    $query = "SELECT * FROM `FEES_PAID` WHERE USN='$usn'";
    $result = mysqli_query($con, $query);
    if($result && mysqli_num_rows($result)>0)
    {
        $display = "none";
        echo "
            <script>
                const elem = document.querySelector('.pay-text-container h3')
                elem.innerHTML = 'Thank you for<br>becoming a<br>member!<br><br>Your merch<br>will arrive<br>soon!'
                const ebutton = document.querySelector('.pay-text-container a')
                ebutton.style.display = '$display'
            </script>
        ";
    }

    ?>

    <div id="profile">
        <div class="heading">
            <div class="line"></div>
            <h3>Your Profile</h3>
        </div>
        <div class="profile-card">
            <div class="left">
                <h3 class="name"><span><?php echo ucwords(strtolower($user_data['FName'])); ?></span><span> <?php echo ucwords(strtolower($user_data['LName']));?></span></h3>
                <h3 class="designation others"><span><?php echo ucwords(strtolower($user_data['Role'])); ?></span></h3>
                <h3 class="usn others"><span>🞂 USN: </span><?php echo strtoupper($user_data['USN']); ?></h3>
                <h3 class="semester others"><span>🞂 Semester: </span><?php if($user_data['Semester']!='Not Set') {echo ucwords(strtolower($user_data['Semester']));} ?></h3>
                <h3 class="branch-section others"><span>🞂 Branch & Section: </span><?php if ($user_data['Branch'] != 'Not Set') { echo strtoupper($user_data['Branch']); } ?> <?php if ($user_data['Section'] != 'Not Set') { echo strtoupper($user_data['Section']);} ?></h3>
                <h3 class="email others"><span>🞂 Email ID: </span><?php echo strtolower($user_data['EmailID']); ?> </h3>
            </div>
            <div class="right">
                <a href="../php/profile.php">EDIT PROFILE!</a>
            </div>
        </div>
    </div>

    <!-- <div id="news">
        <div class="heading">
            <div class="line"></div>
            <h3>News and Posts</h3>
        </div>
        <div class="news-group">
            <iframe max-width="100%" height="600" src="https://www.instagram.com/p/CnZKp02sTFX/embed" frameborder="0"></iframe>
            <iframe max-width="100%" height="600" src="https://www.instagram.com/p/Cm4JszVpkPd/embed" frameborder="0"></iframe>
            <iframe max-width="100%" height="600" src="https://www.instagram.com/p/CmgJ-fohg98/embed" frameborder="0"></iframe>
            <iframe max-width="100%" height="600" src="https://www.instagram.com/p/Cl8aCWxrpFP/embed" frameborder="0"></iframe>
        </div>
    </div>
    -->

    <div id="event">
        <div class="heading">
            <div class="line"></div>
            <h3>Upcoming Events</h3>
        </div>
        <div class="event-card">
            <img class="event-banner" src="../assets/event.jpg" alt="">
            <h3 class="desc">
                <span>🞂 Date: </span> 12 Feb 2023<br>
                <span>🞂 Timings: </span> 4:30 pm to 6:30 pm<br>
                <span>🞂 Venue: </span> M309 <br>
                <span>🞂 Event-type: </span> Club Members only.
            </h3>
            <h3 class="brief">
                🞂 This event is an interactive session with the students, by the guest Mrs. Rashmi 
                BV, on graphic designing, and some of the most used software in the field. <br>
                🞂 The talk will give an idea and an overview of the use of the software and a view into 
                the graphic design ecosystem, the differences in the software obtained through 
                different sources, and the applications of graphic design.
            </h3>
            <div class="registration">
                <h3>Registrations close on 12th</h3>
                <?php
                $usn = $user_data['USN'];
                $query = "SELECT * FROM `FEES_PAID` WHERE USN='$usn'";
                $result = mysqli_query($con, $query);
                if($result && mysqli_num_rows($result)>0)
                {

                    $query = "SELECT * FROM `event_enrolled` WHERE USN='$usn'";
                    $result = mysqli_query($con, $query);
                    if($result && mysqli_num_rows($result)>0)
                    {
                        echo '
                        <style>
                            .locked-text {
                                color: #ffffff;
                                font-size: 1.8rem;
                                width: 10em;
                                padding-top: 0.8em;
                                padding-bottom: 0.8em;
                                padding-right: 1.3em;
                                padding-left: 1.3em;
                                background-color: #230658;
                                border-radius: 1em;
                                text-decoration: none;
                                font-weight: bold;
                                opacity: 1;
                                cursor: pointer;
                            }
                        </style>
                        ';
                        $htmlstmt = "<div class=\"locked-text\">✓ REGISTERED</div>";
                        echo "
                            $htmlstmt
                        ";
                    }
                    else
                    {
                        $link = "\"../php/register.php\"";
                        $htmlstmt = "<a href=$link>REGISTER NOW!</a>";
                        echo "
                            $htmlstmt
                        ";
                    }
                }
                else
                {
                    echo '
                    <style>
                            .locked-text {
                                color: #ffffff;
                                font-size: 1.8rem;
                                width: 13em;
                                padding-top: 0.8em;
                                padding-bottom: 0.8em;
                                padding-right: 1.3em;
                                padding-left: 1.3em;
                                background-color: #230658;
                                border-radius: 1em;
                                text-decoration: none;
                                font-weight: bold;
                                opacity: 1;
                                cursor: pointer;
                            }
                    </style>
                    ';
                    $htmlstmt = "<div class=\"locked-text\">🔒 REGISTER NOW!</div>";
                    echo "
                        $htmlstmt
                    ";
                }

                ?>
            </div>
        </div>
    </div>

    <div id="admin">
        <div class="heading">
                <div class="line"></div>
                <h3>Admin Panel</h3>
        </div>
        <div class="admin-card">
            <div class="analytics mcount">
                <h1>Total Members</h1>
                <h3>5</h3>
            </div>
            <div class="analytics fcount">
                <h1>Total Fees</h1>
                <h3>5</h3>
            </div>
            <div class="analytics pcount">
                <h1>Total Paid</h1>
                <h3>5</h3>
            </div>
            <div class="analytics ecount">
                <h1>Total Enrolled</h1>
                <h3>5</h3>
            </div>
            <div class="button-set">
                <a href="../php/delete.php" class="delete-cta cta">Delete User</a>
                <a href="../php/addrole.php" class="addrole-cta cta">Add Role</a>
                <a href="../php/addevent.php" class="addevent-cta cta">Add Event</a>
            </div>
        </div>
    </div>

    <?php
                $usn = $user_data['USN'];
                $res1=mysqli_query($con, "CALL CheckIfAdmin('$usn', @ausn)");
                $res = mysqli_query($con, "SELECT @ausn as usn");
                $row = mysqli_fetch_assoc($res);
                if($row['usn']!=null) {
                    $display = 'flex';
                    echo "
                    <script>
                        const admin = document.querySelector('#admin')
                        admin.style.display='$display'
                    </script>
                ";
                }

                $res1=mysqli_query($con, "CALL MemberCount(@mcount)");
                $res = mysqli_query($con, "SELECT @mcount as mcount");
                $row = mysqli_fetch_assoc($res);
                if($row['mcount']!=null) {
                    $mcount = $row['mcount'];
                    echo "
                    <script>
                        const mcount = document.querySelector('.mcount h3')
                        mcount.innerHTML = '$mcount'
                    </script>
                ";
                }

                $res1=mysqli_query($con, "CALL FeesCount(@fcount)");
                $res = mysqli_query($con, "SELECT @fcount as fcount");
                $row = mysqli_fetch_assoc($res);
                if($row['fcount']!=null) {
                    $fcount = $row['fcount'];
                    echo "
                    <script>
                        const fcount = document.querySelector('.fcount h3')
                        fcount.innerHTML = '$fcount'
                    </script>
                ";
                }

                $res1=mysqli_query($con, "CALL PaidCount(@pcount)");
                $res = mysqli_query($con, "SELECT @pcount as pcount");
                $row = mysqli_fetch_assoc($res);
                if($row['pcount']!=null) {
                    $pcount = $row['pcount'];
                    echo "
                    <script>
                        const pcount = document.querySelector('.pcount h3')
                        pcount.innerHTML = '$pcount'
                    </script>
                ";
                }

                $res1=mysqli_query($con, "CALL EnrollCount(@ecount)");
                $res = mysqli_query($con, "SELECT @ecount as ecount");
                $row = mysqli_fetch_assoc($res);
                if($row['ecount']!=null) {
                    $ecount = $row['ecount'];
                    echo "
                    <script>
                        const ecount = document.querySelector('.ecount h3')
                        ecount.innerHTML = '$ecount'
                    </script>
                ";
                }
    ?>  

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="../js/preloader.js"></script>
    <script src="../js/dashboard_menu.js"></script>

</body>
</html>