<?php

include_once 'includes/class.dbc.php';
include_once 'includes/session.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';

//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();

//initialise and error array
$errors = [];

//update information here
if(isset($_POST['update']))
{
    //grab the form fields
    $full_name  = filter($_POST['full_name']);
    $email = filter($_POST['email']);
    $tel = filter($_POST['tel']);
    $nationality  = filter($_POST['nationality']);
    $about_me = filter($_POST['about_me']);

    $user_id = $_SESSION['user_id'];
    $user_photo = '';

    //validate everything
    if(empty($full_name))
    {
        array_push($errors, "Name Field Cannot be empty");
    }

    if(empty($email))
    {
        array_push($errors, "Email Field Cannot be empty");
    }

    if(empty($tel))
    {
        array_push($errors, "Telephone number cannot be empty");
    }


    //upload the user picture
    if(count($errors) == 0)
    {
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

            $user_photo = $dest . $uploaded_name;

            //now put the right path to upload
            $dest = "admin/uploads/avatars/";

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
                    $user_photo = '';
                }
            }
        }
        else {
            //get the image that was there and put it back
            $query = "SELECT `avatar` FROM `users` WHERE `user_id` = '$user_id' ";
            $result = mysqli_query($dbc, $query);

            list($avatar) = mysqli_fetch_array($result);

            $user_photo = $avatar;
        }

        //now if the photo had no errors. then update
        if(count($errors) == 0)
        {
            $query = "UPDATE `users` SET
                            `full_name` = '$full_name', `tel` = '$tel',
                            `email` = '$email', `nationality` = '$nationality',
                            `about_me` = '$about_me', `avatar` = '$user_photo'

                            WHERE `user_id` = '$user_id';
                            ";

            $result = mysqli_query($dbc, $query)
                or die("Error");

            $success = "Profile Information Updated";
        }
    }
}


include_once 'includes/head.php';
?>
<!-- custom styles can go here  -->
<link rel="stylesheet" href="css/lib/select2.css">

<?php
include_once 'includes/navigation.php';

//will be able to use the user object below becuase it
 //was created in the navigation .php file
?>

<div class="row">
    <div class="col-md-12">
        <div class="bg-white p-20">
            <h2 class="page-header">Edit My Profile</h2>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                <?php
                if(!isset($_SESSION['user_id']))
                {
                    ?>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="callout callout-info">
                            Sorry. You need to be logged In
                        </div>
                    </div>
                </div>
                    <?php
                }
                 ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label col-md-5">Full Names</label>
                            <div class="col-md-7">
                                <input type="text" name="full_name" value="<?php echo $user->full_name; ?>"
                                class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="control-label col-md-5">Telephone</label>
                            <div class="col-md-7">
                                <input type="text" name="tel" value="<?php echo $user->tel; ?>"
                                class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="control-label col-md-5">Email</label>
                            <div class="col-md-7">
                                <input type="text" name="email" value="<?php echo $user->email; ?>"
                                class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="control-label col-md-5">Nationality</label>
                            <div class="col-md-7">
                                <select class="select2 form-control" name="nationality">
                                    <option value="">-- Select Country -- </option>
                                    <?php
                                    $query  = "SELECT * FROM `countries`";
                                    $result = $dbc->query($query);

                                    while($row = $result->fetch_object())
                                    {
                                        ?>
                                    <option value="<?php echo $row->country_name; ?>"
                                        <?php
                                        if($row->country_name == $user->nationality)
                                        {
                                            echo 'selected';
                                        }
                                         ?> >
                                        <?php echo $row->country_name; ?>
                                    </option>
                                        <?php
                                    }
                                     ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="control-label col-md-5">About Me</label>
                            <div class="col-md-7">
                                <textarea name="about_me" rows="8" class="form-control"><?php echo $user->about_me; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label col-md-5">Photo</label>
                            <div class="col-md-7">
                                <input type="file" name="image" value="" id="imgForm"
                                class="form-control">

                                <div class="row">
                                    <div class="col-md-12">
                                        <br>
                                        <img src="<?php echo $user->photo; ?>" alt="Profile Picture" id="img"
                                        width="200px" height="200px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <?php
                            if(isset($_SESSION['user_id']))
                            {
                                ?>
                            <button type="submit" name="update" class="btn btn-primary">
                                Update Information
                            </button>
                                <?php
                            }
                             ?>

                             <a href="profile.php" class="btn btn-primary">
                                 <i class="fa fa-chevron-left"></i>
                                 Back to Profile
                             </a>
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
include_once 'includes/toast.php';
?>

<!-- custom scripts here -->
<script type="text/javascript" src="js/lib/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $(".select2").select2();

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

        $("#imgForm").change(function() {
          readURL(this);
        });
    });
</script>

<?php
include_once 'includes/end.php';
?>
