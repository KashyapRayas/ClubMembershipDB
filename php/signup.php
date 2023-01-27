<?php
session_start();
    include("../php/connection.php");
    include("../php/functions.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/signup_style.css">
    <title>Siggraph BNMIT Sign Up</title>
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
                    <label>First Name</label>
                    <input name="fname" type="text"><span class="highlight"></span><span class="bar"></span>
                </div>
                <div class="group">
                    <label>Last Name</label>
                    <input name="lname" type="text"><span class="highlight"></span><span class="bar"></span>
                </div>
                <div class="group">
                    <label>Email ID</label>
                    <input name="email" type="text"><span class="highlight"></span><span class="bar"></span>
                </div>
                <div class="group">
                    <label>USN</label>
                    <input name="usn" type="text"><span class="highlight"></span><span class="bar"></span>
                </div>
                <div class="group last">
                    <label>Password</label>
                    <input name="password" type="password"><span class="highlight"></span><span class="bar"></span>
                </div>
                <div id="group-invalid">
                    <h3 class="invalid-text">Please fill all the details</h3>
                </div>
                <div class="login-group">
                    <button type="submit" name="signup" value="Signup" class="login-button">SIGN UP</button>
                    <div class="sign-up-text">Already registered?<br><a href="../php/login.php">Sign in!</a></div>
                </div>
            </div>
        </form>
    </div>

    <?php 
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //something was posted
            $fname = strtoupper($_POST['fname']);
            $lname = strtoupper($_POST['lname']);
            $usn = strtoupper($_POST['usn']);
            $email = strtolower($_POST['email']);
            $pass = $_POST['password'];
    
            if(!empty($usn) && !empty($pass) && !is_numeric($fname) &&!is_numeric($lname))
            {
    
                $query = "SELECT * FROM `members` WHERE USN='$usn'";
                $result = mysqli_query($con, $query);
                if($result && mysqli_num_rows($result)>0) {
                    $display = "block";
                    echo "
                    <script>
                        const elem = document.getElementById('group-invalid')
                        const textinvalid = document.querySelector('#group-invalid .invalid-text')
                        textinvalid.innerHTML = 'USN already exists!'
                        elem.style.display = '$display'
                    </script>
                ";
                }
                else {
                    //save to database
                    $query = "INSERT INTO `members` VALUES('$usn', '$fname', '$lname', '$email', '$pass')";
                    mysqli_query($con, $query);
                    header("Location: ../php/login.php");
                    die;
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