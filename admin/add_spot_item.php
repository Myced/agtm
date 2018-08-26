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

if(isset($_POST['name']))
{
    //grab the items
    $name = filter($_POST['name']);
    $unit = filter($_POST['unit']);
    $price = filter($_POST['price']);
    $quantity = filter($_POST['quantity']);

    if(empty($name))
    {
        array_push($errors, "Product Name is Required");
    }

    if(empty($unit))
    {
        array_push($errors, "The Unit is Required");
    }

    if(empty($price))
    {
        array_push($errors, "Price is needed");
    }

    if(empty($quantity))
    {
        array_push($errors, "Quantity is needed");
    }


    //now if there was no error. Then save the item
    if(count($errors) == 0)
    {
        //then save the item
        $query = "INSERT INTO `spot_price`
                ( `item`, `quantity`, `unit`, `price`, `user_id` )

                VALUES
                ( '$name', '$quantity', '$unit', '$price', '$user_id' )
        ";

        $result = mysqli_query($dbc, $query)
            or die("Error. Cannot insert Spot item");

        $success = "Spot Item Added";
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
                Add Spot Item
            </h1>


            <br>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Product Name:
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-12">
                                <input type="text" name="name" class="form-control" placeholder="Product Name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Quantity:
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-12">
                                <input type="text" name="quantity" class="form-control" placeholder="Quantity E.G 1" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Unit:
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-12">
                                <input type="text" name="unit" class="form-control" placeholder="Unit E.g Tonnes" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Price:
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-12">
                                <input type="text" name="price" class="form-control" placeholder="Price" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                            </label>
                            <div class="col-md-12">
                                <input type="submit" name="save" class="btn btn-primary" value="Save Item" >
                            </div>
                        </div>
                    </form>
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
