<?php
session_start();
    include("../php/connection.php");
    include("../php/functions.php");
    $user_data = check_login($con);

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //something was posted
        $fname = strtoupper($_POST['fname']);
        $lname = strtoupper($_POST['lname']);
        $email = strtolower($_POST['email']);
        $branch = isset($_POST['branch'])? strtolower($_POST['branch']) : null;
        $semester = isset($_POST['semester'])? strtolower($_POST['semester']) : null;
        $section = isset($_POST['section'])? strtolower($_POST['section']) : null;
        $usn = $user_data['USN'];
        $pass = $_POST['password'];

        if(!is_numeric($fname) && !is_numeric($lname) )
        {
            //save to database
            if(!empty($fname)) {
                $query = "UPDATE `members` SET FNAME='$fname' WHERE USN='$usn'";
                mysqli_query($con, $query);
            }
            if(!empty($lname)) {
                $query = "UPDATE `members` SET LNAME='$lname' WHERE USN='$usn'";
                mysqli_query($con, $query);
            }
            if(!empty($email)) {
                $query = "UPDATE `members` SET EMAILID='$email' WHERE USN='$usn'";
                mysqli_query($con, $query);
            }
            if(!empty($pass)) {
                $query = "UPDATE `members` SET PASSWORD='$pass' WHERE USN='$usn'";
                mysqli_query($con, $query);
            }

            $query = "SELECT * FROM `other_details` WHERE USN='$usn'";
            $result = mysqli_query($con, $query);
            if(mysqli_num_rows($result)>0)
            {
                if(!empty($branch))
                {
                    $query = "UPDATE `other_details` SET Branch='$branch' WHERE USN='$usn'";
                    mysqli_query($con, $query);
                }
                if(!empty($semester))
                {
                    $query = "UPDATE `other_details` SET Semester='$semester' WHERE USN='$usn'";
                    mysqli_query($con, $query);
                }
                if(!empty($section))
                {
                    $query = "UPDATE `other_details` SET Section='$section' WHERE USN='$usn'";
                    mysqli_query($con, $query);
                }
            }
            else
            {
                $query = "INSERT INTO `other_details` VALUES('$usn', '$semester', '$branch')";
                mysqli_query($con, $query);
            }
            header("Location: ../php/dashboard.php");
            die;
        }
        else
        {
        echo "Please enter some valid information";
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/profile_style.css">
    <title>Siggraph BNMIT Profile</title>
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
                    <label>Semester</label>
                    <div class="sub-group">
                        <input name="semester" id="1st" type="radio" value="1st"><span class="highlight"></span><span class="bar"></span>
                        <label for="1st">1st Semester</label>
                    </div>
                    <div class="sub-group">
                        <input name="semester" id="3rd" type="radio"value="3rd"><span class="highlight"></span><span class="bar"></span>
                        <label for="3rd">3rd Semester</label>
                    </div>
                    <div class="sub-group">
                        <input name="semester" id="5th" type="radio" value="5th"><span class="highlight"></span><span class="bar"></span>
                        <label for="5th">5th Semester</label>
                    </div>
                    <div class="sub-group">
                        <input name="semester" id="7th" type="radio" value="7th"><span class="highlight"></span><span class="bar"></span>
                        <label for="7th">7th Semester</label>
                    </div>
                </div>
                <div class="group">
                    <label>Branch</label>
                    <div class="sub-group">
                        <input name="branch" id="CSE" type="radio" value="CSE"><span class="highlight"></span><span class="bar"></span>
                        <label for="CSE">CSE</label>
                    </div>
                    <div class="sub-group">
                        <input name="branch" id="IS" type="radio" value="IS"><span class="highlight"></span><span class="bar"></span>
                        <label for="IS">IS</label>
                    </div>
                    <div class="sub-group">
                        <input name="branch" id="AIML" type="radio" value="AIML"><span class="highlight"></span><span class="bar"></span>
                        <label for="AIML">AIML</label>
                    </div>
                    <div class="sub-group">
                        <input name="branch" id="ECE" type="radio" value="ECE"><span class="highlight"></span><span class="bar"></span>
                        <label for="ECE">ECE</label>
                    </div>
                    <div class="sub-group">
                        <input name="branch" id="EEE" type="radio" value="EEE"><span class="highlight"></span><span class="bar"></span>
                        <label for="EEE">EEE</label>
                    </div>
                    <div class="sub-group">
                        <input name="branch" id="MECH" type="radio" value="MECH"><span class="highlight"></span><span class="bar"></span>
                        <label for="MECH">MECH</label>
                    </div>
                </div>
                <div class="group">
                    <label>Section</label>
                    <div class="sub-group">
                        <input name="section" id="A" type="radio" value="A"><span class="highlight"></span><span class="bar"></span>
                        <label for="A">A</label>
                    </div>
                    <div class="sub-group">
                        <input name="B" id="B" type="radio" value="B"><span class="highlight"></span><span class="bar"></span>
                        <label for="B">B</label>
                    </div>
                </div>
                <div class="group ">
                    <label>New Password</label>
                    <input name="password" type="password"><span class="highlight"></span><span class="bar"></span>
                </div>
                
                
                <div class="login-group">
                    <button type="submit" name="update" value="Signup" class="login-button">UPDATE</button>
                    <div class="sign-up-text">Want to go back?<br><a href="../php/dashboard.php">Click here!</a></div>
                </div>
            </div>
        </form>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="../js/preloader.js"></script>

</body>
</html>