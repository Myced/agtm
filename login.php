<?php

//include some plugins.
include_once 'classes/class.dbc.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';
include_once 'classes/class.Level.php';
include_once 'classes/class.AccountStatus.php';
include_once 'includes/session.php';

//initialise the database connection
$db = new dbc();
$dbc = $db->get_instance();

//include other custom plugins needed
$errors = [];

if(isset($_POST['username']))
{
    //grab thee username and passwor
    $user_name = filter($_POST['username']);
    $password = filter($_POST['password']);

    // check these and compare them.
    $query = "SELECT * FROM `users` WHERE `username` = '$user_name'";

    $result = mysqli_query($dbc, $query)
            or die("Cannot query");

    if(mysqli_num_rows($result) == 1)
    {
        //nwo get the persons details.
        while($row = mysqli_fetch_array($result))
        {
            $pass = $row['password'];
            $user_id = $row['user_id'];
            $level = $row['level'];
            $status = $row['account_status'];
            $avatar = $row['avatar'];

        }

        //compare the two passwords
        if(password_verify($password, $pass))
        {
            //then logg the user in.

            //check that the user is authorised to do the login.

            if($status == AccountStatus::BLOCKED) {
                $error = "Sorry. Your Account has been blocked. Please contact admin";
            }
            elseif($status == AccountStatus::SUSPENDED)
            {
                $error = "Sorry. Your Account has been suspended. Please contact admin";
            }
            elseif($status == AccountStatus::UNCONFIRMED)
            {
                $error = "You have not verified your account yet.";
                $info = "Please check your email box and verify your email from the link we sent to you";
            }
            else {
                echo 'true4';
                $_SESSION['user_id'] = $user_id;
                $_SESSION['level'] = $level;
                $_SESSION['username'] = $user_name;
                $_SESSION['avatar'] = $avatar;


                //register the login into the login table.
                $query = "INSERT INTO `login` SET `user_id` = '$user_id',
                        `date` = '$date'";
                $result = mysqli_query($dbc, $query)
                    or die("Could not complete login");

                //send the person now to the index page-break-inside
                //check the user level

                if($level == Level::ADMIN)
                {
                    //redirect to the admin page
                    header("Location: admin/index.php");
                }
                elseif($level == Level::MODERATOR) {
                    //then set all session variable for the user
                    $query = "SELECT * FROM `user_prefs` WHERE `user_id` = '$user_id' ";
                    $result = mysqli_query($dbc, $query)
                        or die("Error. Cannot get user preferences");

                    while($row = mysqli_fetch_array($result))
                    {
                        $_SESSION['categories'] = $row['categories'];
                        $_SESSION['loi'] = $row['loi'];
                        $_SESSION['sco'] = $row['sco'];
                        $_SESSION['spot_prices'] = $row['spot_prices'];
                        $_SESSION['importers'] = $row['importers'];
                        $_SESSION['exporters'] = $row['exporters'];
                        $_SESSION['buy_offers'] = $row['buy_offers'];
                        $_SESSION['sell_offers'] = $row['sell_offers'];
                        $_SESSION['products'] = $row['products'];
                        $_SESSION['newsletter'] = $row['newsletter'];
                        $_SESSION['quotation'] = $row['quotation'];
                        $_SESSION['forum'] = $row['forum'];
                    }

                    header("Location: admin/index.php");
                }
                else {
                    header("Location: index.php");
                }

              }
        }
        else
        {
            $error = "Invalid Username or Password";
        }
    }
    else
    {
        //error
        $error = "Invalid Username or Password";
    }
}

 ?>

<html>
    <head>
        <title> AGTM - LOGIN </title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="author" content="AGTM Team" />
        <meta content="Online Trading Site, APEX GLOBAL TRADING AND MARKETTING" name="description" />
        <meta name="keywords" content="AGTM, APEX GLOBAL TRADING AND MARKETING, a-gtm.com, www.a-gtm.com" />


        <link rel="shortcut icon" href="admin/assets/images/favicon.ico">
        <link href="css/toastr.min.css" rel="stylesheet" >
        <link href="css/bootstrap.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="css/font-awesome.css">
        <link href="css/login.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <h1 class="text-center login-title">AGTM - Sign In</h1>
                    <div class="account-wall">
                        <img class="profile-img" src="images/photo.png?sz=120"
                             alt="">
                        <form class="form-signin" method="POST" action="">
                            <input type="text" class="form-control" placeholder="Username" required autofocus
                                    name="username">
                            <br>
                            <input type="password" class="form-control" placeholder="Password" required
                                    name="password">
                            <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">
                                Sign in</button>

                            <br>
                            <label class="checkbox pull-left">
                                <input type="checkbox" value="remember-me">
                                Remember me
                            </label>
                            <br>
                            <br>

                            <a href="index.php" class="pull-left need-help"> <i class="fa fa-home"></i> Home </a>
                            <a href="register.php" class="pull-right need-help">Register </a><span class="clearfix"></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script src="js/jquery.js"></script>
    <script src="js/toastr.min.js"></script>
    <?php
    include_once 'includes/toast.php';
    ?>
</html>
