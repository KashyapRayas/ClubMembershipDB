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
    <link rel="stylesheet" href="../css/addrole_style.css">
    <title>Siggraph BNMIT Add Event</title>
</head>
<body>

    <div class="preloader">
        <img class="preloader-logo" src="../assets/logo_color.png" alt="logo_preloader">
    </div>

    <div class="signup-page page">
        <div class="ribbon"></div>
        <form method="post" class="form-wrapper">
            <div class="top">
                <img src="../assets/logo.jpg" alt="">
            </div>
            <div class="bottom">
                <div class="group">
                    <label>Event Name:</label>
                    <input name="ename" type="text"><span class="highlight"></span><span class="bar"></span>
                </div>
                <div class="group">
                    <label>Event Date (YYYY-MM-DD):</label>
                    <input name="edate" type="text"><span class="highlight"></span><span class="bar"></span>
                </div>
                <div id="group-invalid">
                    <h3 class="invalid-text">An event is already ongoing!</h3>
                </div>
                <div class="login-group">
                    <button type="submit" name="update" value="Signup" class="login-button">UPDATE</button>
                    <div class="sign-up-text">Want to go back?<br><a href="../php/dashboard.php">Click here!</a></div>
                </div>
            </div>
        </form>
    </div>

    <?php
        $usn = $user_data['USN'];
        $display = "block";
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //something was posted
            $name = ucwords(strtolower($_POST['ename']));
            $date = $_POST['edate'];
    
            if(!is_numeric($name) && !empty($date) && !empty($name))
            {
                //save to database
                $eventid = rand(1000000, 9999999);
                $query = "UPDATE events SET STATUS='DONE'";
                $res = mysqli_query($con, $query);

                $query = "INSERT INTO events VALUES('$eventid', '$name', '$date', 'ONGOING', '$usn')";
                $res = mysqli_query($con, $query);

                header("Location: ../php/dashboard.php");
                die;
            }
            else
            {
                // $htmlstmt = 'Enter USN and Role!';
                $display = "block";
                echo "
                <script>
                    const elem = document.getElementById('group-invalid')
                    elem.style.display = '$display'
                </script>
                ";
            }
        }
    
    ?>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="../js/preloader.js"></script>

</body>
</html>