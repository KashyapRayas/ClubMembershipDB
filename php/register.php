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
    <link rel="stylesheet" href="../css/register_style.css">
    <title>Siggraph BNMIT Register</title>
</head>
<body>




    <div class="preloader">
        <img class="preloader-logo" src="../assets/logo_color.png" alt="logo_preloader">
    </div>

    
    <div class="login-page">
        <div class="ribbon"></div>
        <form method="post" class="form-wrapper">
            <div class="top">
                <img src="../assets/logo.jpg" alt="">
            </div>
            <div class="bottom">
                <div class="group">
                    <label>By clicking below, you agree to register and attend the event!</label>
                </div>
                <div class="login-group">
                    <button name="pay-submit" type="submit" value="Submit" class="login-button">REGISTER</button>
                    <div class="go-back-text">Go back?<br><a href="../php/dashboard.php">Click here!</a></div>
                </div>
            </div>
        </form>
    </div>

    <?php

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        //something was posted
            //read to database
        $usn = $user_data['USN'];
        $date = date("Y-m-d");
        $res = mysqli_query($con, "SELECT EventID FROM events WHERE Status='ONGOING'");
        $row = mysqli_fetch_assoc($res);
        $eventid = $row['EventID'];
        $query = "INSERT INTO `event_enrolled` VALUES('$usn', '$eventid', '$date')";
        mysqli_query($con, $query);
        header("Location: ../php/dashboard.php");
        die;
    }
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="../js/preloader.js"></script>


</body>
</html>