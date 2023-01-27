<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login_style.css">
    <title>Siggraph BNMIT Login</title>
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
                    <label>USN</label>
                    <input name="usn" type="text"><span class="highlight"></span><span class="bar"></span>
                </div>
                <div class="group">
                    <label>Password</label>
                    <input name="password" type="password"><span class="highlight"></span><span class="bar"></span>
                </div>
                <div id="group-invalid">
                    <div class="invalid-text">Invalid USN or Password!</div>
                </div>
                <div class="login-group">
                    <button name="login" type="submit" value="Submit" class="login-button">LOGIN</button>
                    <div class="sign-up-text">Haven't registered?<br><a href="../php/signup.php">Sign up!</a></div>
                </div>
            </div>
        </form>
    </div>

    <?php

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    include("../php/connection.php");
    include("../php/functions.php");
    //something was posted
    $usn = $_POST['usn'];
    $pass = $_POST['password'];

    if(!empty($usn) && !empty($pass))
    {
        //read to database
        $query = "SELECT * FROM members WHERE usn='$usn'";
        //create stored procedure
        $result = mysqli_query($con, $query);

        if($result && mysqli_num_rows($result)>0)
        {
            $user_data = mysqli_fetch_assoc($result);
            if($user_data['Password'] === $pass)
            {
                $_SESSION['usn'] = $user_data['USN'];
                header("Location: dashboard.php");
                die;
            }
        }
        $display = "block";
        echo "

            <script>
                const elem = document.getElementById('group-invalid')
                elem.style.display = '$display'
            </script>

        ";
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