<?php
//
//database and other function initialisations
include_once 'includes/session.php';
include_once '../classes/class.Level.php';
include_once '../classes/class.dbc.php';
include_once '../includes/functions.php';
include_once '../includes/day.php';
include_once 'classes/class.Status.php';
include_once 'includes/admin.php';

//initialise the database connection
$db = new dbc();
$dbc = $db->get_instance();

//include other custom plugins needed
$errors = [];

//page application logic here
//page application logic here
if(isset($_GET['status']))
{
    //get the new status and set it.
    $statu = filter($_GET['status']);
    $id = filter($_GET['id']);

    //now update the product to the new status
    $query = "UPDATE `buy_offers` SET `status` = '$statu' WHERE `id` = '$id' ";
    $result = mysqli_query($dbc, $query)
        or die("Error, Could not complete the action");

    //alert the user
    $success = "Offer Status Changed Successfully";
}

//get the export details
if(isset($_GET['id']))
{
    //then get the id
    $id = filter($_GET['id']);
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
                Buy Offer Details
            </h1>
            <br>

            <div class="row">
                <?php
                //get the order details
                $id = filter($_GET['id']);

                $query = "SELECT * FROM `buy_offers` WHERE `id` = '$id' ";
                $result = mysqli_query($dbc, $query)
                    or die("Error");

                while($row = mysqli_fetch_array($result))
                {
                    ?>

                    <div class="col-md-6">

                        <h3 class="page-header">Product Details</h3>
                        <br>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">

                                <tr>
                                    <th>Product Name</th>
                                    <td>
                                        <?php echo $row['product_name']; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Quantity</th>
                                    <td>
                                        <?php echo $row['quantity']; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Unit Price</th>
                                    <td>
                                        <?php echo $row['price']; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Packaging</th>
                                    <td>
                                        <?php echo $row['packaging']; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Date Submitted</th>
                                    <td>
                                        <?php echo date_from_timestamp($row['time_added']); ?>
                                        <br> At -
                                        <?php echo time_from_timestamp($row['time_added']); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <?php

                                        $status = $row['status'];
                                        if($status == Status::ACCEPTED)
                                        {
                                            ?>
                                        <div class="badge badge-success">
                                            ACCEPTED
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
                                        elseif ($status == Status::REJECTED) {
                                            ?>
                                        <div class="badge badge-danger">
                                            REJECTED
                                        </div>
                                            <?php
                                        }
                                         ?>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">

                        <h3>Contact Details</h3>

                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Contact Name:</strong>
                            </div>

                            <div class="col-md-6">
                                <?php echo $row['contact_name']; ?>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Contact Email:</strong>
                            </div>

                            <div class="col-md-6">
                                <?php echo $row['contact_email']; ?>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Telephone:</strong>
                            </div>

                            <div class="col-md-6">
                                <?php echo $row['tel']; ?>
                            </div>
                        </div>

                    </div>
                    <?php
                }
                 ?>


            </div>
        </div>
    </div>


    <br><br>
    <div class="col-md-12">
        <div class="text-center">

            <?php
            //generate the previous
            $query = "SELECT `id` FROM `buy_offers` WHERE `id` < $id LIMIT 1";
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
            if($status != Status::ACCEPTED)
            {
                ?>
            <a href="buy_offer_details.php?id=<?php echo $id; ?>&status=<?php echo Status::ACCEPTED; ?>" class="btn btn-success">
                <i class="fa fa-check"></i>
                Accept
            </a>
                <?php
            }

            if($status != Status::REJECTED)
            {
                ?>
            <a href="buy_offer_details.php?id=<?php echo $id; ?>&status=<?php echo Status::REJECTED; ?>" class="btn btn-danger">
                <i class="fa fa-times"></i>
                Reject
            </a>
                <?php
            }

            if($status != Status::PENDING)
            {
                ?>
            <a href="buy_offer_details.php?id=<?php echo $id; ?>&status=<?php echo Status::PENDING; ?>" class="btn btn-warning">
                <i class="fa fa-clock-o"></i>
                Pending
            </a>
                <?php
            }
            ?>

            <?php
            //generate the previous
            $query = "SELECT `id` FROM `buy_offers` WHERE `id` > $id LIMIT 1";
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
