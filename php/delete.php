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
    <link rel="stylesheet" href="../css/delete_style.css">
    <title>Siggraph BNMIT Delete User</title>
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
                    <label>Enter usn to delete:</label>
                    <input name="usn" type="text"><span class="highlight"></span><span class="bar"></span>
                </div>
                <div id="group-invalid">
                    <div class="invalid-text">Invalid usn!</div>
                </div>
                <div class="login-group">
                    <button name="pay-submit" type="submit" value="Submit" class="login-button">DELETE</button>
                    <div class="go-back-text">Go back?<br><a href="../php/dashboard.php">Click here!</a></div>
                </div>
            </div>
        </form>
    </div>

    <?php

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //something was posted
    $usn = $_POST['usn'];
    if(!empty($usn))
    {
        //read to database
        $query = "SELECT * FROM members WHERE USN='$usn'";
        $res=mysqli_query($con, $query);
        if($res && mysqli_num_rows($res))
        {
                $query = "DELETE FROM members WHERE USN='$usn'";
                mysqli_query($con, $query);
                header("Location: ../php/dashboard.php");
                die;
        }
        else
        {
            $display = "block";
            echo "

            <script>
                const elem = document.getElementById('group-invalid')
                elem.style.display = '$display'
            </script>

        ";
        }
    }
    else
    {
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