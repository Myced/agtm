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
if(isset($_POST['title']))
{
    //ge the information
    $title = filter($_POST['title']);
    $description = filter($_POST['description']);

    //validate
    if(empty($title))
    {
        //we push an error
        array_push($errors, "Sorry. You must provide the SCO Title");
    }

    if(empty($description))
    {
        array_push($errors, "The SCO Description is required");
    }

    //upload image
    if(isset($_FILES['file']))
    {
        //thne grab the filres
        //now grab photo options
        $photo_location = '';
        $file_name = $_FILES['file']['name'];
        $tmp_name  = $_FILES['file']['tmp_name'];
        $file_type = $_FILES['file']['type'];
        $file_size = $_FILES['file']['size'];

        $max_file_size = 20000000; //20Mb

        if(!empty($file_name))
        {
            //$error = "Sorry. You must upload a profile Picture";
            if($file_size > $max_file_size)
            {
                array_push($errors, "Sorry. File Size too large");
            }

            //Now validate the file format
            if($file_type != "image/jpg" && $file_type != "image/jpeg" && $file_type != "image/gif"
                    && $file_type != "image/png" && $file_type != "image/tiff" )
            {
                array_push($errors, "Sorry. Inappropriate File Type. Acceptable Picture formats include \"jpg, jpeg, png, gif\"  ");
            }

            //picture destination
            $destination = "uploads/sco/";
            $date_string = date("Ymdhms") . '_';
            $final_name = $date_string . $file_name;

            $photo_location = $destination . $final_name;

            if(!isset($error))
            {
                $upload = TRUE;

                //try moving the file
                if(move_uploaded_file($tmp_name, $photo_location))
                {
                    $upload = TRUE;
                }
                else {
                    $upload = FALSE;
                    $photo_location = '';
                }
            }
        }
        else
        {
            $upload = FALSE;
            $photo_location = '';
        }

    }



    //then save to the database
    if(count($errors) == 0)
    {
        //we can then save to the database
        $query = " INSERT INTO `sco` (`title`, `description`, `user_id`, `image`)
                VALUES('$title', '$description', '$user_id', '$photo_location') ";
        $result = mysqli_query($dbc, $query)
            or die("Could not query the database");

        $success = "SCO Saved";

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
                Add New SCO
            </h1>


            <br><br>
            <form class="form-horizontal" action="add_sco.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Title
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-12">
                                <input type="text" name="title" class="form-control" placeholder="SCO Title" required>
                            </div>
                        </div>

                        <br>
                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Description:
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-12">
                                <textarea name="description" rows="8" class="form-control"
                                placeholder="Enter the LOI Details here" required
                                ></textarea>
                            </div>
                        </div>

                        <br>
                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                            </label>
                            <div class="col-md-12">
                                <input type="submit" name="" value="Save SCO" class="btn btn-primary">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                SCO Image:
                            </label>
                            <div class="col-md-12">
                                <input type="file" name="file" value="" class="form-control" id="img">

                                <div class="row">
                                    <div class="col-md-12">
                                        <br>
                                        <br>
                                        <img src="<?php echo LOI_IMAGE; ?>" alt="SCO Image" title="LOI Image" id="blah" width="200px" height="200px;">
                                    </div>
                                </div>
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
<script type="text/javascript">
    function readURL(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#blah').attr('src', e.target.result);

          $('#blah').hide();
          $('#blah').fadeIn(650);

        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#img").change(function() {
      readURL(this);
    });
</script>

<?php
include_once 'includes/end.php';
?>
