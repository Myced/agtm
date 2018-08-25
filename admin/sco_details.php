<?php
//
//database and other function initialisations
include_once 'includes/session.php';
include_once '../classes/class.dbc.php';
include_once '../includes/functions.php';
include_once '../includes/day.php';
include_once 'includes/admin.php';
include_once 'classes/class.Status.php';

//initialise the database connection
$db = new dbc();
$dbc = $db->get_instance();

//include other custom plugins needed
$errors = [];

//page application logic here
if(isset($_GET['status']))
{
    //get the new status and set it.
    $statu = filter($_GET['status']);
    $id = filter($_GET['id']);

    //now update the product to the new status
    $query = "UPDATE `sco` SET `status` = '$statu' WHERE `id` = '$id' ";
    $result = mysqli_query($dbc, $query)
        or die("Error, Could not complete the action");

    //alert the user
    $success = "SCO Status Changed Successfully";
}

//delete files
if(isset($_GET['file']))
{
    $id = filter($_GET['id']);
    $file = filter($_GET['file']);
    $action = filter($_GET['del']);

    if($action == 'true')
    {
        //get the location of the file before deleteing
        $query = "SELECT * FROM `sco_files` WHERE `id` = '$file' ";
        $result = $dbc->query($query);

        $file_location = '';

        while($row = $result->fetch_assoc())
        {
            $file_location = $row['location'];
        }

        //now unlink the file

        if(file_exists($file_location))
        {
            if(unlink($file_location))
            {
                //then delete from the database
                $query = "DELETE FROM `sco_files` WHERE `id` = '$file' ";
                $result = $dbc->query($query);

                $success = "File Deleted";
            }
            else {
                array_push ($errors, "Could not delete the file");
            }
        }
        else {
            $info = "File may have already been deleted";
        }

    }
}


//upload the LOI document if it has been submitted
if(isset($_POST['upload']))
{
    //grab the file and details.
    $file_name = $_FILES['file']['name'];
    $tmp_name  = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];
    $file_size = human_filesize($_FILES['file']['size']);

    //get the loi id;
    $sco_id = filter($_GET['id']);

    //file type
    // $type = filter($_POST['type']);

    //get the file extenstion
    $spl = new SplFileInfo($file_name);
    $extention = $spl->getExtension();

    $type = $extention;

    //file location
    $file_location = '';

    $max_file_size = 20000000; //20Mb

    if(!empty($file_name))
    {
        //$error = "Sorry. You must upload a profile Picture";
        if($file_size > $max_file_size)
        {
            array_push($errors, "Sorry. File Size too large");
        }


        //picture destination
        $destination = "uploads/sco/";
        $date_string = date("Ymdhms") . '_';
        $final_name = $date_string . $file_name;

        $file_location = $destination . $final_name;

        if(count($errors) == 0)
        {

            //try moving the file
            if(move_uploaded_file($tmp_name, $file_location))
            {
                //save to the database
                $query  = "INSERT INTO `sco_files` (`loi_id`, `file_name`, `size`, `location`,
                                    `type`, `user_id`)

                                VALUES ('$sco_id', '$file_name', '$file_size', '$file_location',
                                    '$type', '$user_id'
                                )
                                    ";
                $result = $dbc->query($query);

                $success = "File Uploaded";

            }
            else {
                array_push($errors, "Sorry. File could not be uploaded");
            }
        }
    }
    else
    {
        array_push($errors, "Please you must select a file to upload");
    }

}

include_once 'includes/head.php';
include_once 'includes/stylesheets.php';
?>
<!--//custom style here-->
<link href="plugins/custombox/css/custombox.min.css" rel="stylesheet">

<?php
include_once 'includes/middle.php';
include_once 'includes/left_sidebar.php';
include_once 'includes/start.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <h2 class="page-header">
                SCO Details
            </h2>

            <?php
            //get the id of the loi to work with
            if(isset($_GET['id']))
            {
                $id = filter($_GET['id']);
            }
            else {
                $id = '';
            }

            $status = '';
            //get the loi details
            $query = "SELECT * FROM `sco` WHERE `id` = '$id'";
            $result = $dbc->query($query);

            while($row = $result->fetch_assoc())
            {
                $status = $row['status'];
                ?>
                <br><br>
            <div class="row">
                <div class=" col-xs-12 col-md-6">
                    <h4>LOI Image</h4>
                    <div class="image">
                        <img src="<?php echo $row['image'] ?>" alt="LOI image" width="100%" height="100%" >
                    </div>
                </div>

                <div class=" col-xs-12 col-md-6">
                    <h3 class="loi-title"><?php echo $row['title']; ?></h3>

                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <strong>SCO Status:</strong>
                        </div>
                        <div class="col-md-6">
                            <?php

                            if($status == Status::AVAILABLE)
                            {
                                ?>
                            <div class="badge badge-success">
                                AVAILABLE
                            </div>
                                <?php
                            }
                            elseif ($status == Status::CLOSED) {
                                ?>
                            <div class="badge badge-danger">
                                CLOSED
                            </div>
                                <?php
                            }
                            elseif ($status == Status::PENDING) {
                                ?>
                            <div class="badge badge-warning">
                                PENDING
                            </div>
                                <?php
                            }
                             ?>
                        </div>
                    </div>

                    <br><br>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo $row['description']; ?>
                        </div>
                    </div>
                </div>
            </div>
                <?php
            }
             ?>



        </div>
        <!-- end of card box -->

        <br>
        <br>
        <div class="card-box">
            <a href="#custom-modal" class="btn btn-custom btn-rounded w-md waves-effect waves-light pull-right" data-animation="flip" data-plugin="custommodal"
               data-overlaySpeed="100" data-overlayColor="#36404a">
               <i class="mdi mdi-upload"></i>
               Upload Files
           </a>

            <h4 class="header-title m-b-30">LOI Files</h4>

            <div class="row">

                <?php
                $query = "SELECT * FROM `sco_files` WHERE `loi_id` = '$id'";
                $result = $dbc->query($query);

                if($result->num_rows == 0)
                {
                    echo '<strong> NO files have been uploaded </strong>';
                }
                else {
                    while($row = mysqli_fetch_array($result))
                    {
                        //generate the file path. if it does not exist then set a default

                        $path = "assets/images/file_icons/" . $row['type'] . ".svg";
                        if(file_exists($path))
                        {

                        }
                        else {
                            $path = "assets/images/file_icons/doc.svg";
                        }
                        ?>
                    <div class="col-lg-4 col-xl-3">
                        <div class="file-man-box">
                            <a href="loi_details.php?id=<?php echo $id; ?>&del=true&file=<?php echo $row['id']; ?>"
                                class="file-close" title="Delete this file"><i class="mdi mdi-close-circle"></i></a>
                            <div class="file-img-box">
                                <img src="<?php echo $path; ?>" alt="icon">
                            </div>
                            <a href="<?php echo $row['location'] ?>" class="file-download"><i class="mdi mdi-download"></i> </a>
                            <div class="file-man-title">
                                <h5 class="mb-0 text-overflow"><?php echo $row['file_name']; ?></h5>
                                <p class="mb-0"><small><?php echo $row['size']; ?></small></p>
                            </div>
                        </div>
                    </div>
                        <?php
                    } // end of while loop
                }//enf of else
                     ?>

            </div>
        </div>


    </div>
    <!-- end of col-md-12 -->

    <!-- now col-md-12 -->
    <br><br>
    <div class="col-md-12">
        <div class="text-center">

            <?php
            //generate the previous
            $query = "SELECT `id` FROM `sco` WHERE `id` < $id ORDER BY `id` DESC LIMIT 1";
            $result = mysqli_query($dbc, $query)
                or die("Error.");

            if(mysqli_num_rows($result) == 0)
            {

            }
            else {

                list($prev) = mysqli_fetch_array($result);
                ?>
                <div class="pull-left">
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $prev; ?>" class="btn btn-info">
                        <i class="fa fa-chevron-left"></i>
                        Previous
                    </a>
                </div>
                <?php
            }

             ?>

            <?php
            if($status != Status::AVAILABLE)
            {
                ?>
            <a href="sco_details.php?id=<?php echo $id; ?>&status=<?php echo Status::AVAILABLE; ?>" class="btn btn-success">
                <i class="fa fa-check"></i>
                Make Available
            </a>
                <?php
            }

            if($status != Status::CLOSED)
            {
                ?>
            <a href="sco_details.php?id=<?php echo $id; ?>&status=<?php echo Status::CLOSED; ?>" class="btn btn-danger">
                <i class="fa fa-times"></i>
                Close
            </a>
                <?php
            }

            if($status != Status::PENDING)
            {
                ?>
            <a href="sco_details.php?id=<?php echo $id; ?>&status=<?php echo Status::PENDING; ?>" class="btn btn-warning">
                <i class="fa fa-clock-o"></i>
                Set to Pending
            </a>
                <?php
            }
            ?>

            <?php
            //generate the previous
            $query = "SELECT `id` FROM `sco` WHERE `id` > $id ORDER BY `id` DESC LIMIT 1";
            $result = mysqli_query($dbc, $query)
                or die("Error.");

            if(mysqli_num_rows($result) == 0)
            {

            }
            else {

                list($next) = mysqli_fetch_array($result);
                ?>
                <div class="pull-right">
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $next; ?>" class="btn btn-info">

                        Next
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </div>
                <?php
            }

             ?>

        </div>
    </div>
    <!-- end of col-md-12 -->
</div>

<!-- Modal -->
<div id="custom-modal" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Upload SCO Documents</h4>
    <div class="custom-modal-text">
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

            <div class="form-group m-b-25">
                <div class="col-12">
                    <label for="emailaddress3" class="control-label pull-left">Select File</label>
                    <input class="form-control" type="file" id="emailaddress3" required="" name="file">
                </div>
            </div>

            <!-- <br>
            <div class="form-group m-b-25">
                <div class="col-12">
                    <a href="#" class="text-muted pull-right font-14">Select the document Type</a>
                    <label  class="pull-left">Document Type</label>
                    <select class="form-control select2" name="type">
                        <option value="jpg"> Photo</option>
                        <option value="jpg">JPG (Photo)</option>
                        <option value="png">PNG (Photo)</option>
                        <option value="gif">GIF (Photo)</option>
                        <option value="pdf">PDF</option>
                        <option value="ppt">PowerPoint</option>
                        <option value="doc">Word Document</option>
                        <option value="xls">Excel Document</option>
                        <option value="jpg">Unknown Type</option>
                    </select>
                </div>
            </div> -->


            <div class="form-group account-btn text-center m-t-10">
                <div class="col-12">
                    <button class="btn w-lg btn-rounded btn-custom waves-effect waves-light" type="submit" name="upload">Upload</button>
                </div>
            </div>

        </form>
    </div>
</div>


<?php
include_once 'includes/footer.php';
include_once 'includes/scripts.php';
include_once 'includes/notification.php';
?>
<!--//any custom javascript here-->
<!-- Modal-Effect -->
<script src="plugins/custombox/js/custombox.min.js"></script>
<script src="plugins/custombox/js/legacy.min.js"></script>

<?php
include_once 'includes/end.php';
?>
