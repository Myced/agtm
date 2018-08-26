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
                Product Details
            </h1>

<?php
    //get the id of the product
    $id  = filter($_GET['id']);

    $product = new Product($id);


 ?>
             <div class="row">
                 <div class="col-md-3">
                     <div class="image thumbnail text-center">
                         <a href="#">
                             <img src="<?php echo $product->photo; ?>" alt="Product Image">
                             <?php echo $product->product_name; ?>
                         </a>
                     </div>
                 </div>

                 <div class="col-md-6">

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
