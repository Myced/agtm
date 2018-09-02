<?php
//
//database and other function initialisations
include_once 'includes/session.php';
include_once '../classes/class.dbc.php';
include_once '../includes/functions.php';
include_once '../includes/day.php';
include_once 'includes/admin.php';
include_once '../classes/class.Level.php';

//initialise the database connection
$db = new dbc();
$dbc = $db->get_instance();

/////FUNCTION TO GENEREATE A USER ID
function gen_user_id()
{
    global $dbc;

    $query = "SELECT `id` FROM `users` ORDER BY  `id` DESC LIMIT 1";
    $result = mysqli_query($dbc, $query);

    list($id) = mysqli_fetch_array($result);

    $prefix = 'MD-' . date("y") . 'U';

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

//generate the user id
$uid = gen_user_id();

//include other custom plugins needed
$errors = [];

//page application logic here
if(isset($_POST['worker_name']))
{
    $name = filter($_POST['worker_name']);
    $contact = filter($_POST['contact']);
    $position = filter($_POST['position']);
    $email = filter($_POST['email']);

    $user = filter($_POST['user_id']);
    $username = filter($_POST['username']);
    $password = filter($_POST['password']);
    $repeat_password = filter($_POST['repeat_password']);

    $hash = password_hash($password, PASSWORD_BCRYPT);

    //get the user level
    $level = filter($_POST['user_level']);

    //GET THE USER AGENT AND IP ADDRESS
    $ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $destination = '';

    //if the user is a moderator then get the previledges as they come
    if($level == Level::ADMIN)
    {
        $categories = TRUE;
        $loi = TRUE;
        $sco = TRUE;
        $spot_prices = TRUE;
        $importers = TRUE;
        $exporters = TRUE;
        $sell_offer = TRUE;
        $buy_offer = TRUE;
        $products = TRUE;
        $newsletter = TRUE;
        $quotation = TRUE;
        $forum = TRUE;
    }
    elseif ($level == Level::USER) {
        $categories = FALSE;
        $loi = FALSE;
        $sco = FALSE;
        $spot_prices = FALSE;
        $importers = FALSE;
        $exporters = FALSE;
        $sell_offer = FALSE;
        $buy_offer = FALSE;
        $products = FALSE;
        $newsletter = FALSE;
        $quotation = FALSE;
        $forum = FALSE;
    }
    else {
        //GET moderatore previledges as set
        $categories = TRUE ? isset($_POST['categories']) : FALSE;
        $loi = TRUE ? isset($_POST['loi']) : FALSE;
        $sco = TRUE ? isset($_POST['sco']) : FALSE;
        $spot_prices = TRUE ? isset($_POST['price']) : FALSE;
        $importers = TRUE ? isset($_POST['importers']) : FALSE;
        $exporters = TRUE ? isset($_POST['exporters']) : FALSE;
        $sell_offer = TRUE ? isset($_POST['sell_offer']) : FALSE;
        $buy_offer = TRUE ? isset($_POST['buy_offer']) : FALSE;
        $products = TRUE ? isset($_POST['products']) : FALSE;
        $newsletter = TRUE ? isset($_POST['newsletter']) : FALSE;
        $quotation = TRUE ? isset($_POST['quotation']) : FALSE;
        $forum = TRUE ? isset($_POST['forum']) : FALSE;
    }

    //check that the passwords Match
    if($password != $repeat_password)
    {
        $error = "Sorry. The passwords do not match";
    }

    //validate the username and pasword
    $query = "SELECT `username` FROM `users` WHERE `username` = '$username'";
    $result = mysqli_query($dbc, $query)
             or die("Error. Could not look up db");
    if(mysqli_num_rows($result) > 0)
    {
        array_push($errors, 'This Username already exist. Choose another one');
    }

    $query = "SELECT * FROM `users` WHERE `full_name` = '$name'";
    $result = mysqli_query($dbc, $query);

    if(mysqli_num_rows($result) > 0)
    {
        array_push($errors, "This worker is already in the database. You can instead update his information");
    }

    //make sure the user_id is not in the database
    $query = "SELECT * FROM `users` WHERE `user_id` = '$user'";
    $result = mysqli_query($dbc, $query)
             or die("Error. Could not look up db");

    if(mysqli_num_rows($result) > 0)
    {
        //generate a new id
        $user = gen_user_id();
    }

    //upload photo
    //now if the image is uploaded. then send it to the server
    if($_FILES['image']['name'] != '')
    {
        //first get the files details.
        $file_name = filter($_FILES['image']['name']);
        $file_type = $_FILES['image']['type'];
        $file_size = $_FILES['image']['size'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $name_part = date("Ymdhis");

        $uploaded_name = $name_part . '_' . $file_name;

        $dest = "uploads/avatars/";

        //now get the destination location
        $destination = $dest . $uploaded_name;

        //now we validate our image here.
        define('MAX_FILE_SIZE', 20000000);

        // 1. Check the image size
        if($file_size > MAX_FILE_SIZE)
        {
            //Set an error alerting the user.
            array_push($errors, "File size is too large. Limit is 20Mb");
        }

        // 2. Check the file type.
        if($file_type != 'image/jpeg'  && $file_type != 'image/jpg'
                && $file_type != 'image/gif' && $file_type != 'image/png')
        {
            $error = "Sorry. The image type is not supported. Please use either jpg or png or gif";
        }

        if(!isset($error) || count($errors) == 0)
        {
            //we upload the photo
            if(move_uploaded_file($tmp_name, $destination))
            {
                //upload was successful
            }
            else
            {
                //uploading failed. so warn user and set destination to null
                $warning = "Logo could not be uploaded";
                $destination = '';
            }
        }
    }

    //now upload if there is no error.
    if(count($errors) == 0)
    {
        //insert into the db.
        $query = "INSERT INTO `users` ("
                        . " `id`, `user_id`, `username`, `password`, `full_name`, `ip_address`, `user_agent`, "
                        . " `position`, `tel`, `email`, `avatar`, `time_added`, `level`, "
                        . " `day`, `month`, `year`, `date`, `mysql_date` )"
                        . ""
                        . " VALUES ("
                        . " 0, '$user', '$username', '$hash', '$name', '$ip', '$user_agent',"
                        . " '$position', '$contact', '$email', '$destination', NOW(), '$level', "
                        . " '$day', '$month', '$year', '$date', '$mysql_date')";
                $result = mysqli_query($dbc, $query)
                        or die("Error" . mysqli_error($dbc));

        $prev = "INSERT INTO `user_prefs` (`user_id`, `user_level`, `categories`, `loi`, `sco`,
                            `spot_prices`, `importers`, `exporters`, `sell_offers`, `buy_offers`,
                            `products`, `newsletter`, `quotation`, `forum`
         )
                VALUES ('$user', '$level', '$categories', '$loi', '$sco',
                            '$spot_prices', '$importers', '$exporters', '$sell_offer', '$buy_offer',
                            '$products', '$newsletter', '$quotation', '$forum'
                )
         ";

         $result  = mysqli_query($dbc, $prev)
            or die("Could not create user Account");

        $success = "User Account Created";
    }
}

//generate the user id
$uid = gen_user_id();


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
            <h1 class="box-title">
                Add User
            </h1>

            <form class="" action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="name" class="control-label col-md-12">
                                    Name of Worker
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="worker_name" required="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="control-label col-md-12">
                                    Position
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="position" required="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="control-label col-md-5">
                                    Contact
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="contact" required="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="control-label col-md-5">
                                    Email

                                </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="email" >
                                </div>
                            </div>

                            <div class="form-group hide"  id="rest">
                                <label for="name" class="control-label col-md-12">
                                    User Type

                                </label>
                                <div class="col-md-9">
                                    <select name="user_level" class="form-control">
                                        <option value="" selected="true"> -- SELECT -- </option>
                                        <option value="<?php echo Level::ADMIN; ?>">Admin</option>
                                        <option value="<?php echo Level::MODERATOR; ?>">Moderator</option>
                                        <option value="<?php echo Level::USER; ?>"> Normal User</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="name" class="control-label col-md-8">
                                    User ID
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="user_id" readonly="true"
                                           required="true" value="<?php echo $uid; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="control-label col-md-8">
                                    Username
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="username" required="true"
                                           placeholder="Username used to login">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="control-label col-md-8">
                                    Password
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-12">
                                    <input type="password" class="form-control" name="password" required="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="control-label col-md-8">
                                    Repeat Password
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-12">
                                    <input type="password" class="form-control" name="repeat_password" required="true">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                <!--            <div style="margin-top:10px; float:left; width: 100px; height: 105px; border:1px solid #ccc; text-align: center; margin-left: 30px;">

                            <input type="file" name="photo" class="form-control">
                        </div>-->


                        <div class="row">
                            <div class="col-md-12">
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <strong>Picture </strong>
                            </div>

                            <br>
                            <br>
                            <div class="col-md-9">
                              <h6 class="page-title"> <strong>User Preference <strong> </h6>
                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="cat" type="checkbox" name="categories">
                                            <label for="cat" class="text-bold">
                                                Categories
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="loi" type="checkbox" name="loi">
                                            <label for="loi" class="text-bold">
                                                LOI
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="sco" type="checkbox" name="sco">
                                            <label for="sco" class="text-bold">
                                                SCO
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="price" type="checkbox" name="price">
                                            <label for="price" class="text-bold">
                                                Spot Prices
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="importer" type="checkbox" name="importers">
                                            <label for="importer" class="text-bold">
                                                Importers
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="exporters" type="checkbox" name="exporters">
                                            <label for="exporters" class="text-bold">
                                                Exporters
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="sell" type="checkbox" name="sell_offer">
                                            <label for="sell" class="text-bold">
                                                Sell Offers
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="buy" type="checkbox" name="buy_offer">
                                            <label for="buy" class="text-bold">
                                                Buy Offers
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="products" type="checkbox" name="products">
                                            <label for="products" class="text-bold">
                                                Products
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="newsletter" type="checkbox" name="newsletter">
                                            <label for="newsletter" class="text-bold">
                                                NewsLetter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="quotation" type="checkbox" name="quotation">
                                            <label for="quotation" class="text-bold">
                                                Quotation
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="forum" type="checkbox" name="forum">
                                            <label for="forum" class="text-bold">
                                                Forum
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <button type="submit" name="button" class="btn btn-primary">
                                Add User
                            </button>
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
