<?php

//include some plugins.

include_once 'classes/class.dbc.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';
include_once 'classes/class.Level.php';
include_once 'classes/class.AccountStatus.php';

//include email templates
include_once 'mail.php';


//initialise the database connection
$db = new dbc();
$dbc = $db->get_instance();

//include other custom plugins needed
$errors = [];

//function to generate unique token
function gen_token()
{
    $alpha = "a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,
    x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,
    Z,1,2,3,4,5,6,7,8,9,!,@,#,$,%,&,(,),+";

    //convert this to an array ;
    $array = explode(',', $alpha);

    $start = 0;
    $end = count($array) - 1;

    $characters  = '';

    for($i = 0; $i <= 20; $i++)
    {
        //get a random letter and show it
        $index = rand($start, $end);
        $letter =  $array[$index];

        //add the letter to the string of characters
        $characters .= $letter;
    }

    //now encrypt with md5 and return
    $token = hash("sha256", $characters);

    return $token;
}


//function to create a new user id
/////FUNCTION TO GENEREATE A USER ID
function gen_user_id()
{
    global $dbc;

    $query = "SELECT `id` FROM `users` ORDER BY  `id` DESC LIMIT 1";
    $result = mysqli_query($dbc, $query);

    list($id) = mysqli_fetch_array($result);

    $prefix = 'AGT-' . date("ym") . 'U';

    $idd = $id + 1;

    if($idd < 10)
        $value = '000' . $idd;
    elseif($idd < 100)
        $value = '00' . $idd;
    elseif($idd < 1000)
        $value = '0' . $idd;
    else
        $value = $idd;

    return $prefix . $value;
}

if(isset($_POST['register']))
{
    //get the parameters here
    $name = filter($_POST['name']);
    $tel = filter($_POST['tel']);
    $email = filter($_POST['email']);

    $username = filter($_POST['username']);
    $password = filter($_POST['password']);
    $rpassword = filter($_POST['rpassword']);

    //GET THE USER AGENT AND IP ADDRESS
    $ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    //registration token
    $token = gen_token();
    //email confirmation url
    $full_name = $name;
    $confirm_link = "http://www.a-gtm.com/confirm_email.com?token=" . $token;
    $to = $email;

    //user id
    $user_id = gen_user_id();


    //all normal registrations are user registration. only an admin can create a new admin
    $level = Level::USER;

    $hash = password_hash($password, PASSWORD_BCRYPT);

    //validation.

    if(empty($name))
    {
        array_push($errors, "Name Field is required");
    }

    if(empty($tel))
    {
        array_push($errors, "Telephone cannot be empty");
    }

    if(empty($email))
    {
        array_push($errors, "Email is Required");
    }

    if(empty($password) || empty($rpassword))
    {
        array_push($errors, "Password and Repeated password are needed");
    }

    if($password != $rpassword )
    {
        array_push($errors, "Password and Repeated password do not match");
    }

    //now check if the email has already been used.
    // if yest then alert the user
    $query = "SELECT * FROM `users` WHERE `email` = '$email'";
    $result = mysqli_query($dbc, $query)
        or die("Could not query");

    if(mysqli_num_rows($result) > 0)
    {
        array_push($errors, "This Email has already been used. Please use another one.");
    }

    $query = "SELECT * FROM `users` WHERE `tel` = '$tel'";
    $result = mysqli_query($dbc, $query)
        or die("Could not query");

    if(mysqli_num_rows($result) > 0)
    {
        array_push($errors, "This Tel has already been used. Please use another one.");
    }

    //if there are no errors. then insert the user into the database;
    if(!isset($error) && empty($errors))
    {
        //there was no error. so register this user.
        $query = " INSERT INTO `users` (`user_id`, `full_name`, `tel`, `email`, `level`,
                `ip_address`, `user_agent`, `token`,
                        `username`, `password`, `day`, `month`, `year`, `date`, `mysql_date`, `time_added`)

                    VALUES('$user_id', '$name', '$tel', '$email', '$level',
                        '$ip', '$user_agent', '$token', '$username', '$hash',
                        '$day', '$month', '$year', '$date', '$mysql_date', NOW() )";

        $result = mysqli_query($dbc, $query)
               or die("Error. Could not complete registration");

        //send an email
        include_once 'mail_template.php';
        mail($to ,$subject ,$mymail, $headers);

        $success = "User Registered Successfully";
        $info = "Please Check you email box to confirm your registration";
    }
}

?>

<html>
    <head>
        <title> AGTM - SIGN UP </title>

        <link rel="shortcut icon" href="admin/assets/images/favicon.ico">

        <link href="css/bootstrap.css" rel="stylesheet" id="bootstrap-css">
        <link href="css/toastr.min.css" rel="stylesheet" >
        <link rel="stylesheet" href="css/font-awesome.css">
        <link href="css/login.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <h1 class="text-center login-title">AGTM - Sign Up</h1>

                    <div class="account-wall">
                        <img class="profile-img" src="images/photo.png?sz=120"
                             alt="">
                        <form class="form-signin" action="register.php" method="POST">
                            <input type="text" class="form-control" placeholder="Full Names" required autofocus
                                   value="<?php if(isset($name) && !isset($success)) echo $name; ?>" name="name">
                            <br>

                            <input type="text" class="form-control" placeholder="Telephone" required="true"
                                   value="<?php if(isset($tel) && !isset($success) ) echo $tel; ?>" name="tel">
                            <br>

                            <input type="text" class="form-control" placeholder="Email" required="true"
                                   value="<?php if(isset($email) && !isset($success)) echo $email; ?>" name="email">

                            <hr>
                            <input type="text" class="form-control" placeholder="Username" required="true"
                                   value="<?php if(isset($username) && !isset($success)) echo $username; ?>" name="username">
                            <br>

                            <input type="password" class="form-control" placeholder="Password" required
                                   value="<?php if(isset($password) && !isset($success)) echo $password; ?>" name="password">

                            <input type="password" class="form-control" placeholder="Repeat Password" required
                                   value="<?php if(isset($rpassword) && !isset($success)) echo $rpassword; ?>" name="rpassword">

                            <button class="btn btn-lg btn-primary btn-block" type="submit" name="register">
                                Create Account
                            </button>

                            <br><br>
                            <a href="index.php" class="pull-left need-help"> <i class="fa fa-home"></i> Home </a>
                            <a href="login.php" class="pull-right need-help">Login </a><span class="clearfix"></span>
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
