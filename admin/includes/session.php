<?php
session_start();

//script to determine if the currently logged in user has access to this page or not
if(!isset($_SESSION['user_id']))
{
    //redirect the user to the user login.
    header("Location: ../login.php");
}
else {
    //check that the user is of admin level.
    if(isset($_SESSION['level']))
    {
        if($_SESSION['level'] == 1)
        {
            //then send them to the 503 unathorised page
            header("Location: 401.php");
        }
    }
    else {
        header("Location: ../login.php");
    }
}
 ?>
