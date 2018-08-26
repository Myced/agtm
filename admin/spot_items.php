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

if(isset($_GET['id']))
{
    //get the id
    $id = filter($_GET['id']);
    $action = filter($_GET['action']);

    if(empty($action))
    {
        //do nothing
    }
    else {
        //perform the action
        if($action == 'del')
        {
            //delete the item
            $query = "DELETE FROM `spot_price` WHERE `id` = '$id' ";
            $result = mysqli_query($dbc, $query)
                or die("Error. Could not delete");

            $success  = "Item Deleted";
        }
        elseif ($action == 'disable') {
            $query = "UPDATE `spot_price` SET `status` = '0' WHERE `id`  = '$id' ";
            $result = mysqli_query($dbc, $query)
                or die("Could not update product status");

            $success = "Item Disabled.";
        }
        elseif ($action == 'activate') {
            $query = "UPDATE `spot_price` SET `status` = '1'  WHERE `id` = '$id' ";
            $result  = mysqli_query($dbc, $query)
                or die("Could not activate item");

            $success = "Item Activated";
        }
        else {
            $error = "Unknown Action";
        }
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
                Live Spot Items
            </h1>


            <br>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>s/n</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                        <?php
                        //get all the product items
                        $query = "SELECT * FROM `spot_price`";
                        $result = mysqli_query($dbc, $query)
                            or die("Error");

                        $count = 1;

                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr>
                                <td> <?php echo $count++; ?> </td>
                                <td> <?php echo $row['item']; ?></td>
                                <td> <?php echo $row['quantity']; ?></td>
                                <td> <?php echo $row['unit']; ?></td>
                                <td> <?php echo $row['price']; ?></td>
                                <td>
                                    <?php
                                    if($row['status'] == '1')
                                    {
                                        ?>
                                        <div class="badge badge-success">
                                            Active
                                        </div>
                                        <?php
                                    }
                                    else {
                                        ?>
                                        <div class="badge badge-danger">
                                            Disabled
                                        </div>
                                        <?php
                                    }
                                     ?>
                                </td>
                                <td>

                                    <?php
                                    if($row['status'] == '1')
                                    {
                                        ?>
                                        <a href="spot_items.php?id=<?php echo $row['id']; ?>&action=disable"
                                            class="btn btn-xs btn-warning" title="Disable This Item">
                                            <i class="fa fa-times"></i>
                                            Disable
                                        </a>
                                        <?php
                                    }
                                    else {
                                        ?>
                                        <a href="spot_items.php?id=<?php echo $row['id']; ?>&action=activate"
                                            class="btn btn-xs btn-success" title="Activate This Item">
                                            <i class="fa fa-check"></i>
                                            Activate
                                        </a>
                                        <?php
                                    }
                                     ?>


                                    <a href="edit_item.php?id=<?php echo $row['id']; ?>"
                                        class="btn btn-xs btn-primary" title="Edit this item">
                                        <i class="fa fa-pencil"></i>
                                        Edit
                                    </a>

                                    <a href="spot_items.php?id=<?php echo $row['id']; ?>&action=del"
                                        class="btn btn-xs btn-danger" title="Delete this Item">
                                        <i class="fa fa-trash"></i>
                                        Del
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                         ?>
                    </table>
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
