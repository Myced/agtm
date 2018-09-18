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
    //get the id and others
    $id = filter($_GET['id']);
    $row = filter($_GET['row']);

    //the default posotion is 1;
    $position = 1;

    //save the item to the row table
    if(!empty($id) && !empty($row))
    {
        //don't double insert the items
        //check that the product does not exist there.
        $query = "SELECT * FROM `product_rows` WHERE `product_id` = '$id' ";
        $result = mysqli_query($dbc, $query)
            or die("Could not check for the product");

        if(mysqli_num_rows($result) == 0)
        {
            //inser the product
            //preaprea a query
            $query = "INSERT INTO `product_rows`
                        (`row`, `position`, `product_id`)
                        VALUES
                        ('$row', '$position', '$id') ";

            $result = mysqli_query($dbc, $query )
                or die("Error, Could not add the product");

            $success = "Product added to the row";
        }
        else {
            $info  = "Product has already been added to the row";
        }

    }
    else {
        $error = "Sorry. Could not add the product to the row";
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
                Add Product to Advert Row
            </h2>
            <br>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>S/N</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>

                            <?php
                            //initialise an array to contain the products
                            $products = [];
                            $count = 1;

                            //get all the products in the rows.
                            $query = "SELECT * FROM `product_rows` ";
                            $result = mysqli_query($dbc, $query)
                                or die("Error. cannot get products advertised");

                            //loop through the results and add them to an aaray
                            while($row = mysqli_fetch_array($result))
                            {
                                //push all the results to the array
                                array_push($products, $row['product_id']);
                            }

                            //now get list all the products
                            $query = "SELECT * FROM `products` ";
                            $result = mysqli_query($dbc, $query)
                                or die("Error");

                            //now if a product is not in the list then show it out
                            while($row = mysqli_fetch_array($result))
                            {
                                //check that its not in the array of insertted products
                                if(!in_array($row['id'], $products))
                                {
                                    ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td>
                                        <img src="<?php echo $row['photo'] ?>" alt=""
                                            width="100px" height="100px">
                                    </td>

                                    <td>
                                        <?php echo $row['product_name']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['price']; ?>
                                    </td>

                                    <td>
                                        <a href="add_to_row.php?row=1&id=<?php echo $row['id']; ?>"
                                            class="btn btn-success">
                                            Row 1
                                        </a>

                                        <a href="add_to_row.php?row=2&id=<?php echo $row['id']; ?>"
                                            class="btn btn-primary">
                                            Row 2
                                        </a>

                                        <a href="add_to_row.php?row=3&id=<?php echo $row['id']; ?>"
                                            class="btn btn-warning">
                                            Row 3
                                        </a>
                                    </td>
                                </tr>
                                    <?php
                                }
                            }

                             ?>
                        </table>
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
