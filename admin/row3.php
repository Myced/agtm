<?php
//
//database and other function initialisations
include_once 'includes/session.php';
include_once '../classes/class.Level.php';
include_once '../classes/class.dbc.php';
include_once '../includes/functions.php';
include_once '../includes/day.php';
include_once 'classes/class.Product.php';

//initialise the database connection
$db = new dbc();
$dbc = $db->get_instance();

//include other custom plugins needed
$errors = [];

//page application logic here
if(isset($_GET['id']))
{
    $id = filter($_GET['id']);

    if(!empty($id))
    {
        $query = "DELETE FROM `product_rows` WHERE `id` = '$id' ";
        $result = mysqli_query($dbc, $query)
            or die("Error.");

        $success = "Product Deleted from row";
    }
    else {
        $warning = "Could not delete item";
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
            <h2 class="page-header">
                Advert Row 1 Products
            </h2>
            <br>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>S/N</th>
                                <th>Image</th>
                                <th>Row</th>
                                <th>Position</th>
                                <th>Product Name</th>
                                <th>Action</th>
                            </tr>

                            <?php
                            //get all the products for row 1
                            $row = 3;
                            $count = 1;

                            $query  = "SELECT * FROM `product_rows` WHERE `row` = '$row'
                                    ORDER BY `position` ";
                            $result = mysqli_query($dbc, $query)
                                or die("Could not get the products");

                            while($row = mysqli_fetch_array($result))
                            {
                                $product = new Product($row['product_id']);

                                ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td> <img src="<?php echo $product->photo; ?>" alt="" width="100px" height="100px"> </td>
                                <td><?php echo $row['row']; ?></td>
                                <td><?php echo $row['position']; ?></td>
                                <td><?php echo $product->product_name; ?></td>
                                <td>
                                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $row['id']; ?>"
                                        class="btn btn-danger">
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
                <br>

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">

                        </div>

                        <div class="col-md-4">
                            <a href="edit_positions.php?row=3" class="btn btn-primary">
                                <i class="fa fa-edit"></i>
                                Edit Positions
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

<?php
include_once 'includes/end.php';
?>
