<?php
//
//database and other function initialisations
include_once 'includes/session.php';
include_once '../classes/class.dbc.php';
include_once '../includes/functions.php';
include_once '../includes/day.php';
include_once 'includes/admin.php';
include_once '../classes/class.AccountStatus.php';
include_once '../classes/class.Level.php';

//initialise the database connection
$db = new dbc();
$dbc = $db->get_instance();

//include other custom plugins needed
$errors = [];

function get_level($position)
{
    //get the positon and return the type
    $type = '';

    if($position == Level::ADMIN)
        $type = "Admin";
    elseif($position == Level::MODERATOR)
        $type = "Moderator";
    elseif($position == Level::USER)
        $type = "Normal User";
    else {
      $type = "Unknown";
    }

    return $type;
}

//page application logic here
if(isset($_GET['id']))
{
    $id = filter($_GET['id']);
}
else {
    $error = "Sorry. Password could not be edited";
}

if(isset($_POST['save']))
{
    $password = filter($_POST['new_password']);
    $rpassword = filter($_POST['repeat_password']);

    $hash = password_hash($password, PASSWORD_BCRYPT);

    if($password != $rpassword)
    {
        $error = "Passwords do not match";
    }

    if(!isset($error))
    {
        $query = "UPDATE `users` SET `password` = '$hash'
                    WHERE `user_id` = '$id'";

        //Execute the query now
        $result = mysqli_query($dbc, $query)
                or die("Could not query");

        $success = "Password Changed";
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
                Password Reset
            </h2>

            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group  mg-b-0">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input class="form-control" placeholder="Enter New Password" type="text"
                             name="new_password" required value=""> <br>

                            <input class="form-control" placeholder="Repeat Password" type="text"
                             name="repeat_password" value=""> <br>



                            <input class="btn  btn-success" value="Update Password" type="submit" name="save">
                            <a href="user_list.php" class="btn btn-primary">Back to Users</a>
                        </form>

                    </div><!-- form-group -->
                </div>

                <div class="col-md-6">
                    <div class="card pd-20">

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                    <?php
                                    //fetch all the restaurants.
                                    $query = "SELECT * FROM `users` WHERE `user_id` = '$id'";
                                    $result = mysqli_query($dbc, $query);

                                    while($row = mysqli_fetch_array($result))
                                    {
                                    ?>

                                    <li class="list-group-item">
                                        <strong>User Name : </strong> <?php echo $row['username']; ?>
                                    </li>

                                    <li class="list-group-item">
                                        <strong>Full Name : </strong> <?php echo $row['username']; ?>
                                    </li>

                                    <li class="list-group-item">
                                        <strong>User ID : </strong> <?php echo $row['user_id']; ?>
                                    </li>

                                    <li class="list-group-item">
                                        <strong>User Level : </strong> <?php echo get_level($row['level']); ?>
                                    </li>
                                    <?php
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>
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
