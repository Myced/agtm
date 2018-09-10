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
if(isset($_POST['save']))
{
    //get the paramenters
    $link = filter($_POST['link']);

    $destination = '';

    //upload the image if neccessary
    if($_FILES['image']['name'] != '')
    {
        //first get the files details.
        $file_name = filter($_FILES['image']['name']);
        $file_type = $_FILES['image']['type'];
        $file_size = $_FILES['image']['size'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $name_part = date("Ymdhis");

        $uploaded_name = $name_part . '_' . $file_name;

        $dest = "uploads/ads/";

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
            array_push($errors, "Sorry. The image type is not supported. Please use either jpg or png or gif");
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

    //now insert
    $query = "INSERT INTO `ads` (`id`, `link`, `image`, `time_added`, `last_modified`)

            VALUES('1', '$link', '$destination', NOW(), NOW())
    ";

    $result = mysqli_query($dbc, $query)
        or die("Error");

    $success = "Ad has been placed";
}

if(isset($_POST['update']))
{
    //get the paramenters
    $link = filter($_POST['link']);

    $destination = '';

    //upload the image if neccessary
    if($_FILES['image']['name'] != '')
    {
        //first get the files details.
        $file_name = filter($_FILES['image']['name']);
        $file_type = $_FILES['image']['type'];
        $file_size = $_FILES['image']['size'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $name_part = date("Ymdhis");

        $uploaded_name = $name_part . '_' . $file_name;

        $dest = "uploads/ads/";

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
            array_push($errors, "Sorry. The image type is not supported. Please use either jpg or png or gif");
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
        $query = "SELECT `image` FROM `ads` WHERE `id` = '1' ";
        $result = mysqli_query($dbc, $query)
            or die("Error");

        list($destination) = mysqli_fetch_array($result);
    }

    //now insert
    $query = "UPDATE `ads` SET `link` = '$link', `image` = '$destination',
                                `last_modified` = NOW()
                        WHERE `id` = '1'
    ";

    $result = mysqli_query($dbc, $query)
        or die("Error");

    $success = "Ad has been updated";
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
                Advert Space 1
            </h1>

            <div class="row">
                <div class="col-md-6">
                    <h3 class="box-title">Information</h3>

                    <div class="row">
                        <div class="col-md-12">
                            <?php

                            //get the ad spance
                            $query = "SELECT * FROM `ads` WHERE `id` = '1' ";
                            $result = mysqli_query($dbc, $query)
                                or die("Error. Could not get the ad");

                            if(mysqli_num_rows($result) == 0)
                            {
                                ?>
                            <form class="" action="" method="post" enctype="multipart/form-data">


                                <div class="form-group row">
                                    <label for="" class="col-md-4">Hyper Link</label>
                                    <div class="col-md-8">
                                        <input type="text" name="link" value="" class="form-control"
                                            placeholder="Enter the hyper link" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-md-4 control-label">Upload Image</label>
                                    <div class="col-md-8">
                                        <input type="file" name="image" id="image" class="form-control"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-md-4 control-label">Image Preview</label>
                                    <div class="col-md-8">
                                        <br>
                                        <img src="../images/photo.png" alt=" Product Image" width="200px" height="200px" id="img">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-md-4"></label>
                                    <div class="col-md-8">
                                        <input type="submit" name="save" value="Save Ad Image" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                                <?php
                            }
                            else {
                                while ($row = mysqli_fetch_array($result))
                                {
                                    ?>
                                <form class="" action="" method="post" enctype="multipart/form-data">


                                    <div class="form-group row">
                                        <label for="" class="col-md-4">Hyper Link</label>
                                        <div class="col-md-8">
                                            <input type="text" name="link" value="<?php echo $row['link']; ?>" class="form-control"
                                                placeholder="Enter the hyper link">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="" class="col-md-4 control-label">Upload Image</label>
                                        <div class="col-md-8">
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="" class="col-md-4 control-label">Image Preview</label>
                                        <div class="col-md-8">
                                            <br>
                                            <img src="<?php echo $row['image']; ?>" alt=" Product Image" width="200px" height="200px" id="img">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="" class="col-md-4"></label>
                                        <div class="col-md-8">
                                            <input type="submit" name="update" value="Update Ad Image" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                                    <?php
                                }
                            }
                             ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <h3 class="box-title">Preview</h3>

                    <div class="row">
                        <div class="col-md-12">
                            <?php

                            $query = "SELECT `link`, `image` FROM `ads` WHERE `id` = '1' ";
                            $result = mysqli_query($dbc, $query);

                            list($link, $image) = mysqli_fetch_array($result);
                             ?>

                             <a href="<?php echo $link; ?>" target="_blank">
                                 <img src="<?php echo $image; ?>" alt="Advert Image" width="100%" height="400px">
                             </a>
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
<script type="text/javascript">
$(document).ready(function(){
    function readURL(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#img').attr('src', e.target.result);

          $('#img').hide();
          $('#img').fadeIn(650);

        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#image").change(function() {
      readURL(this);
    });
});

</script>
<?php
include_once 'includes/end.php';
?>
