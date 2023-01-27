<?php

function check_login($con)
{

    if(isset($_SESSION['usn']))
    {
        $usn = $_SESSION['usn'];
        $query = "SELECT * FROM members m, other_details o where m.usn='$usn' and m.usn = o.usn limit 1";

        $result = mysqli_query($con, $query);
        if($result && mysqli_num_rows($result)>0)
        {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    //redirect to login
    header("Location: ../php/login.php");
    die;
}


