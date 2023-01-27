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
    <title>Siggraph BNMIT Add Role</title>
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
                    <label>USN</label>
                    <input name="usn" type="text"><span class="highlight"></span><span class="bar"></span>
                </div>
                <div class="group">
                    <label>Role</label>
                    <input name="role" type="text"><span class="highlight"></span><span class="bar"></span>
                </div>
                <div id="group-invalid">
                    <h3 class="invalid-text">Invalid USN!</h3>
                </div>
                <div class="login-group">
                    <button type="submit" name="update" value="Signup" class="login-button">UPDATE</button>
                    <div class="sign-up-text">Want to go back?<br><a href="../php/dashboard.php">Click here!</a></div>
                </div>
            </div>
        </form>
    </div>

    <?php
        $display = "block";
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //something was posted
            $role = ucwords(strtolower($_POST['role']));
            $usn = $_POST['usn'];
    
            if(!is_numeric($role) && !empty($role) && !empty($usn))
            {
                //save to database
                $query = "SELECT * FROM members WHERE USN='$usn'";
                $res = mysqli_query($con, $query);
                if($res && mysqli_num_rows($res)>0)
                {
                    $query = "UPDATE other_details SET Role = '$role' WHERE USN='$usn'";
                    $res = mysqli_query($con, $query);
                    header("Location: ../php/dashboard.php");
                    die;
                }
                else
                {
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
                $htmlstmt = 'Enter USN and Role!';
                echo "
                <script>
                    const elem = document.getElementById('group-invalid')
                    elem.style.display = '$display'
                    const elem1 = document.querySelector('.invalid-text')
                    elem1.innerHTML = '$htmlstmt'
                </script>
                ";
            }
        }
    
    ?>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="../js/preloader.js"></script>

</body>
</html>