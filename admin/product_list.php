<?php
//
//database and other function initialisations
include_once '../classes/class.dbc.php';
include_once '../includes/functions.php';
include_once '../includes/day.php';
include_once 'includes/admin.php';
include_once 'classes/class.Product.php';

//initialise the database connection
$db = new dbc();
$dbc = $db->get_instance();

//include other custom plugins needed
$errors = [];

if(isset($_GET['id']))
{
    if(isset($_GET['action']))
    {
        $action = filter($_GET['action']);
        $id = filter($_GET['id']);

        if($action = 'del')
        {
            $query = "DELETE FROM `products` WHERE `id` = '$id'";
            $result = mysqli_query($dbc, $query)
                or die("Error. Cannot delete item");

            $success = "Item Deleted";
        }
    }
}

//page application logic here
//pageinate
//query initialisation
$results_per_page = RESULTS_PER_PAGE; //number of results to show on a sigle page

//data manipulation
if(isset($_GET['page']))
{
    //get the page number
    $page_number = filter($_GET['page']);

    //Variable to maintain countring
    $inter  = $page_number - 1; //reduces the page numer in order to count
    $count = (int) ($inter * $results_per_page) + 1;
}
else
{
    $page_number = 1;

    //Variable to do countring
    $count = 1;
}

//START OF search results
if($page_number < 2)
{
    $start = 0;
}
 else {
     $start = (($page_number - 1) * ($results_per_page));
}

//total data in the database;
$query = "SELECT * from `products` ";
$result  = mysqli_query($dbc, $query);

$total = mysqli_num_rows($result);

if($results_per_page >= 1)
{

   $number_of_pages = ceil($total/$results_per_page);

   if($number_of_pages < 1)
   {
       $page_count = 1;
   }
   else
   {
       $page_count = $number_of_pages;
   }

}
else
{
    $error = "Results Per page Cannot be zero or Less";
    $page_count = 1;
}
//end
$end = $results_per_page;

//now if page number is greater that
if($page_number > $page_count)
{
    $error = "That Page does not Exist";
}

//do the query here
$query = "SELECT * FROM `products` ORDER BY `id` DESC LIMIT $start, $end";
$result = mysqli_query($dbc, $query)
        or die("Error");


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
        <div class="">
            <h1 class="page-header">
                Product List
            </h1>

            <br><br>
            <div class="row">

                <?php
                while($row = mysqli_fetch_array($result))
                {
                    $product = new Product($row['product_code'])

                    ?>
                    <div class="col-md-6 col-lg-4">
                        <!-- Simple card -->
                        <div class="card m-b-30">
                            <img class="card-img-top img-fluid thumbnail" src="
                            <?php if(file_exists($row['photo'])) { echo $row['photo']; } else { echo STATIC_PRODUCT_IMAGE; } ?>
                            " alt="Product Image" width="100px" height="100px">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <?php echo $row['product_name']; ?>
                                </h4>
                                <p class="card-text">
                                    Category: <strong> <?php echo $product->category; ?> </strong>

                                    <br>
                                    Price: <strong>$ <?php echo $product->price; ?> </strong>

                                    <br>

                                    Quantity: <strong> <?php echo $product->quantity; ?> </strong>

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                    Units : <strong> <?php echo $product->unit; ?> </strong>
                                </p>
                                <a href="product_details.php?id=<?php echo $row['id']; ?>" class="btn btn-custom waves-effect waves-light"> Details</a>
                                <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-primary waves-effect waves-light">
                                    <i class="fa fa-pencil"></i>
                                    Edit
                                </a>
                                <a href="product_list.php?id=<?php echo $row['id']; ?>&action=del" class="btn btn-danger waves-effect waves-light">
                                    <i class="fa fa-trash"></i>
                                    Delete
                                </a>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <?php
                }

                 ?>

            </div>

            <!-- //row to show page number  -->
            <div class="row">
                <!-- //page number -->
                <div class="col-md-12">
                    <div class="pull-right">
                        Page <?php echo $page_number; ?>/<?php echo $page_count; ?>
                    </div>
                </div>
            </div>

            <!-- //row for pagination  -->
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-right">
                        <?php

                        //the scrpt name
                        $script = basename(__FILE__);

                        if($page_count > 1)
                        {
                            ?>
                        <ul class="pagination">
                            <?php
                            if($page_number != 1)
                            {
                                ?>
                            <li class="previous">
                                <a href="<?php echo $script; ?>?page=<?php echo $page_number - 1; ?>" >Prev</a>
                            </li>
                                <?php
                            }
                            ?>
                            <?php
                            for($i = 1; $i <= $page_count; $i++)
                            {
                                ?>
                            <li class="<?php  $i == $page_number ? print 'active' : ''; ?>">
                                <a href="<?php echo $script; ?>?page=<?php echo $i; ?>"  >
                                    <?php echo $i; ?>
                                </a>
                            </li>
                                <?php
                            }
                            ?>

                            <?php
                            //If the pages and page number are not the same then show the next button
                            if($page_number != $page_count)
                            {
                                ?>
                            <li class="next">
                                <a href="<?php echo $script; ?>?page=<?php echo $page_number + 1; ?>"> Next</a>
                            </li>
                                <?php
                            }
                            ?>

                        </ul>
                            <?php
                        }
                        ?>
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
