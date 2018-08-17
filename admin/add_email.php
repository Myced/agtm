<?php
//
//database and other function initialisations
include_once 'includes/session.php';
include_once '../classes/class.dbc.php';
include_once '../includes/functions.php';
include_once '../includes/day.php';
include_once 'includes/admin.php';

//initialise the database connection
$db = new dbc();
$dbc = $db->get_instance();

//include other custom plugins needed
$errors = [];

//page application logic here
if(isset($_POST['save']))
{
    //grab the email
    $email = filter($_POST['email']);


    //check that the email is not blank
    if(empty($email))
    {
        array_push($errors, 'The email cannot be empty');
    }

    //now check if the email has already subscribed
    $query = "SELECT * FROM `subscriptions` WHERE `email` = '$email' ";
    $result = mysqli_query($dbc, $query)
    or die(mysqli_error($dbc));

    //if the result is one. then send a notification that this email is already there
    if(mysqli_num_rows($result) == 1)
    {
        //then notifu that the email already enchant_broker_dict_exists
        $info = "This email is already in our Mailing List";
    }
    else {
        //insert it.
        $query = " INSERT INTO `subscriptions` ( `email`, `user_id`)

            VALUES('$email', '$user_id');
        ";

        $result = mysqli_query($dbc, $query);

        $success = "You have sucessfully subscribed to our NewsLetter";
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
            <h1 class="page-header">
                Add Email
            </h1>

            <br>
            <br>

            <form class="form-horizontal" action="" method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Email:
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-12">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                            </label>
                            <div class="col-md-12">
                                <input type="submit" name="save" value="Add Email" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

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
