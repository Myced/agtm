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
    $id = filter($_GET['id']);

    //check that the email is not blank
    if(empty($email))
    {
        array_push($errors, 'The email cannot be empty');
    }

    //insert it.
    $query = " UPDATE `subscriptions`  SET  `email` = '$email'
        WHERE `id` = '$id'
    ";

    $result = mysqli_query($dbc, $query);

    $success = "Email Has been updated";

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
                Edit Email Address
            </h1>

            <br>
            <br>

            <?php
            //get the id
            $id = filter($_GET['id']);

            $query = "SELECT * FROM `subscriptions` WHERE `id` = '$id' ";
            $result = mysqli_query($dbc, $query)
                or die("Error. Cannot get the email address");

            while($row = mysqli_fetch_array($result))
            {
                ?>
                <form class="form-horizontal" action="" method="post">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="product" class="control-label col-md-5">
                                    Email:
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-12">
                                    <input type="email" name="email" class="form-control" placeholder="Email" required
                                        value="<?php echo $row['email'];  ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product" class="control-label col-md-5">
                                </label>
                                <div class="col-md-12">
                                    <input type="submit" name="save" value="Update Email" class="btn btn-primary">
                                    <a href="manage_mailing_list.php" class="btn btn-primary">
                                        <i class="fa fa-chevron-left"></i>
                                        Back to List
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
            }
             ?>



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
