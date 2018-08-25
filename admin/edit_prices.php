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
if(isset($_POST['id']))
{
    //grab all the form items.
    //mostly just id and prices
    $prices[] = $_POST['prices'];

    $ids[] = $_POST['id'];



    //now loop through the ids and save them
    for($i = 0; $i < count($ids[0]); $i++)
    {
        $id = filter($ids[0][$i]);
        $price = filter($prices[0][$i]);

        //then update accordingly
        $query = "UPDATE `spot_price` SET `price` = '$price'
            WHERE `id` = '$id' ";

        $result = mysqli_query($dbc, $query)
            or die("Error. ");
    }

    $success = "Prices Updated";

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
                Edit Prices
            </h1>

            <br>
            <br>
            <form class="" action="" method="post">
                <?php
                //get all the items
                $query = "SELECT * FROM `spot_price`";
                $result =  mysqli_query($dbc, $query)
                    or die("Error.");

                while($row = mysqli_fetch_array($result))
                {
                    ?>
                <div class="row">
                    <div class="col-md-3">
                        <input type="hidden" name="id[]" value="<?php echo $row['id']; ?>">
                        <input type="text" name="item[]" value="<?php echo $row['item']; ?>" placeholder="Item" class="form-control" disabled>
                    </div>

                    <div class="col-md-3">
                        <input type="text" name="quantity[]" value="<?php echo $row['quantity']; ?>" placeholder="Quantity" class="form-control" disabled>
                    </div>

                    <div class="col-md-3">
                        <input type="text" name="unit[]" value="<?php echo $row['unit']; ?>" placeholder="Unit" class="form-control" disabled>
                    </div>

                    <div class="col-md-3">
                        <input type="text" name="prices[]" value="<?php echo $row['price']; ?>" placeholder="Price" class="form-control">
                    </div>
                </div>
                <br>
                    <?php
                }
                 ?>

                 <div class="row">
                     <div class="col-md-12">
                         <input type="submit" name="save" value="Update Prices" class="btn btn-primary">
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
