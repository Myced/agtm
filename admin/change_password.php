<?php
//
//database and other function initialisations
include_once 'includes/session.php';
include_once '../classes/class.Level.php';
include_once '../classes/class.dbc.php';
include_once '../includes/functions.php';
include_once '../includes/day.php';

//initialise the database connection
$db = new dbc();
$dbc = $db->get_instance();

//include other custom plugins needed
$errors = [];

//page application logic here
if(isset($_POST['change']))
{
    //grab the various password fields.
    $old_password = filter($_POST['current_password']);
    $new_password = filter($_POST['new_password']);
    $repeat_password = filter($_POST['repeat_password']);

    $old_hash = password_hash($old_password, PASSWORD_BCRYPT);
    $new_hash = password_hash($new_password, PASSWORD_BCRYPT);

    $user_id = get_user_id();

    if(empty($old_password) || empty($new_password) || empty($repeat_password))
    {
        $error = "You must fill all form fields";
    }

    if(!isset($error))
    {
        //now check if the new password is corrent.
        $query = "SELECT `password` FROM `users` WHERE `user_id` = '$user_id'";
        $result  = mysqli_query($dbc, $query)
                 or die("Could not check the password");

        list($password) = mysqli_fetch_array($result);

        if(password_verify($old_password, $password))
        {
            //then the password are the same
            if($new_password != $repeat_password)
            {
                //error again
                $error = "The new password and the repeated password do not match";
            }
            else
            {
                //update the password.
                $query = "UPDATE `users` SET `password` = '$new_hash'";
                $result = mysqli_query($dbc, $query)
                         or die("Could not change your password");

                $success = "Password Successfully changed";
            }
        }
        else
        {
            $error = "Current Password is not correct";
        }
    }
}


include_once 'includes/head.php';
include_once 'includes/stylesheets.php';
?>
<!--//custom style here-->

<?php
include_once 'includes/middle.php';
include_once 'includes/left_sidebar.php';
include_once 'includes/start.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <h2 class="page-header">
                Change Password
            </h2>

            <br>
            <div class="row">
                <div class="col-md-12">
                    <form action="" method="POST">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <input type="password" placeholder="Enter Current Password"
                                        name="current_password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <input type="password" placeholder="Enter New Password"
                                        name="new_password" class="form-control">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <input type="password" placeholder="Repeat the new Password"
                                        name="repeat_password" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button class="btn btn-info btn-block btn-flat" name="change">
                                    <strong> Change Password </strong>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>




<?php
include_once 'includes/footer.php';
include_once 'includes/scripts.php';
include_once 'includes/notification.php';
?>

<!--//any custom javascript here-->

<?php
include_once 'includes/end.php';
?>
