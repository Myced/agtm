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


    //get the user level
    $level = filter($_POST['user_level']);

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
    else {
        //get the image that was there and put it back
        $query = "SELECT `avatar` FROM `users` WHERE `user_id` = '$user' ";
        $result = mysqli_query($dbc, $query);

        list($avatar) = mysqli_fetch_array($result);

        $destination = $avatar;
    }

    //now upload if there is no error.
    if(count($errors) == 0)
    {
        //insert into the db.
        $query = "UPDATE `users` SET "
                        . "   `username` = '$username',  `full_name` = '$name', "
                        . " `position` = '$position', `tel` = '$contact', `email` = '$email',
                            `avatar` = '$destination', `level` = '$level' "
                        . " WHERE `user_id` = '$user' ";
                $result = mysqli_query($dbc, $query)
                        or die("Error" . mysqli_error($dbc));

        $prev = "UPDATE `user_prefs`  SET  `user_level` = '$level', `categories`='$categories', `loi`='$loi', `sco` = '$sco',
                            `spot_prices`='$spot_prices', `importers` = '$importers', `exporters`= '$exporters', `sell_offers`='$sell_offer',
                             `buy_offers` = '$buy_offer', `products` = '$products', `newsletter` = '$newsletter',
                             `quotation` = '$quotation', `forum` = '$forum'

                WHERE `user_id` = '$user' ";

         $result  = mysqli_query($dbc, $prev)
            or die("Could not create user Account");

        $success = "User Account Updated";
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
                Edit User
            </h1>

            <?php
            //get the details for the user
            if(isset($_GET['id']))
            {
                $id = filter($_GET['id']);
            }
            else {
                $id = '';
            }

            //get the user detaisl
            $query = "SELECT * FROM `users` WHERE `user_id` = '$id' ";
            $result = $dbc->query($query);

            while($row = $result->fetch_assoc())
            {
                ?>
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
                                    <input type="text" class="form-control" name="worker_name" required="true"
                                    value="<?php echo $row['full_name']; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="control-label col-md-12">
                                    Position
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="position" required="true"
                                    value="<?php echo $row['position']; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="control-label col-md-5">
                                    Contact
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="contact" required="true"
                                    value="<?php echo $row['tel']; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="control-label col-md-5">
                                    Email

                                </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="email"
                                    value="<?php echo $row['email']; ?>">
                                </div>
                            </div>

                            <div class="form-group hide"  id="rest">
                                <label for="name" class="control-label col-md-12">
                                    User Type

                                </label>
                                <div class="col-md-9">
                                    <select name="user_level" class="form-control">
                                        <option value="" selected="true"> -- SELECT -- </option>
                                        <option value="<?php echo Level::ADMIN; ?>"
                                            <?php if($row['level'] == Level::ADMIN) { echo 'selected'; } ?>
                                            >Admin</option>
                                        <option value="<?php echo Level::MODERATOR; ?>"
                                            <?php if($row['level'] == Level::MODERATOR) { echo 'selected'; } ?>
                                            >Moderator</option>
                                        <option value="<?php echo Level::USER; ?>"
                                            <?php if($row['level'] == Level::USER) { echo 'selected'; } ?>
                                            > Normal User</option>
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
                                           required="true" value="<?php echo $row['user_id']; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="control-label col-md-8">
                                    Username
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="username" required="true"
                                           placeholder="Username used to login" value="<?php echo $row['username']; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="control-label col-md-8">
                                    Password
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-12">
                                    <input type="password" class="form-control" name="password" required="true" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="control-label col-md-8">
                                    Repeat Password
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-12">
                                    <input type="password" class="form-control" name="repeat_password" required="true" disabled>
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
                                <div class="">
                                    <img src="<?php echo $row['avatar']; ?>" alt="User Picture" width="100px" height="100px">
                                </div>
                            </div>

                            <br>
                            <br>
                            <div class="col-md-9">
                              <h6 class="page-title"> <strong>User Preference <strong> </h6>
                                <br>

                                <?php
                                //now get the user previledges
                                $level = $row['level'];

                                $query = "SELECT * FROM `user_prefs` WHERE `user_id` = '$id' ";
                                $res = mysqli_query($dbc, $query)
                                    or die("Error");

                                while($r = mysqli_fetch_array($res))
                                {
                                    ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="cat" type="checkbox" name="categories" <?php if($r['categories'] == '1') { echo 'checked'; } ?> >
                                            <label for="cat" class="text-bold">
                                                Categories
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="loi" type="checkbox" name="loi" <?php if($r['loi'] == '1') { echo 'checked'; } ?>>
                                            <label for="loi" class="text-bold">
                                                LOI
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="sco" type="checkbox" name="sco" <?php if($r['sco'] == '1') { echo 'checked'; } ?> >
                                            <label for="sco" class="text-bold">
                                                SCO
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="price" type="checkbox" name="price" <?php if($r['spot_prices'] == '1') { echo 'checked'; } ?>  >
                                            <label for="price" class="text-bold">
                                                Spot Prices
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="importer" type="checkbox" name="importers" <?php if($r['importers'] == '1') { echo 'checked'; } ?> >
                                            <label for="importer" class="text-bold">
                                                Importers
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="exporters" type="checkbox" name="exporters"  <?php if($r['exporters'] == '1') { echo 'checked'; } ?> >
                                            <label for="exporters" class="text-bold">
                                                Exporters
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="sell" type="checkbox" name="sell_offer"  <?php if($r['sell_offers'] == '1') { echo 'checked'; } ?> >
                                            <label for="sell" class="text-bold">
                                                Sell Offers
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="buy" type="checkbox" name="buy_offer" <?php if($r['buy_offers'] == '1') { echo 'checked'; } ?> >
                                            <label for="buy" class="text-bold">
                                                Buy Offers
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="products" type="checkbox" name="products"  <?php if($r['products'] == '1') { echo 'checked'; } ?> >
                                            <label for="products" class="text-bold">
                                                Products
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="newsletter" type="checkbox" name="newsletter"  <?php if($r['newsletter'] == '1') { echo 'checked'; } ?> >
                                            <label for="newsletter" class="text-bold">
                                                NewsLetter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="quotation" type="checkbox" name="quotation"  <?php if($r['quotation'] == '1') { echo 'checked'; } ?> >
                                            <label for="quotation" class="text-bold">
                                                Quotation
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-custom">
                                            <input id="forum" type="checkbox" name="forum"  <?php if($r['forum'] == '1') { echo 'checked'; } ?> >
                                            <label for="forum" class="text-bold">
                                                Forum
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                    <?php
                                }
                                 ?>



                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <a href="user_list.php" class="btn btn-primary">
                                <i class="fa fa-chevron-left"></i>
                                Back to User List
                            </a>
                            <button type="submit" name="button" class="btn btn-primary">
                                Update User Information
                            </button>
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
