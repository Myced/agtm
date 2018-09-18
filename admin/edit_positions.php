<?php
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
if(isset($_POST['id']))
{
    $ids = $_POST['id'];
    $positions = $_POST['positions'];

    for ($i = 0; $i < count($positions); $i++)
    {
        $id = filter($ids[$i]);
        $position = filter($positions[$i]);

        //the updat eht positions as required.
        $query = "UPDATE `product_rows` SET `position` = '$position' WHERE `id` = '$id' ";
        $result = $dbc->query($query);


    }

    //success mesage
    $success = "Positions Updated";
}

//do the requrest parameter here
if(isset($_GET['row']))
{
    $row = filter($_GET['row']);
}
else {
    $row = "";
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
                Edit Product Positions
            </h2>
            <br>

            <br>

            <form class="form-horizontal" action="" method="post">

                <div class="row">
                    <div class="col-md-4">
                        <strong>Product Name</strong>
                    </div>

                    <div class="col-md-4">
                        Position
                    </div>
                </div>
                <br>

                <?php
                $query = "SELECT  * FROM `product_rows` WHERE `row` = '$row' ";
                $result = $dbc->query($query);

                while($row = $result->fetch_assoc())
                {
                    $product = new Product($row['product_id']);

                    ?>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="name[]" value="<?php echo $product->product_name; ?>"
                        class="form-control" readonly>
                    </div>

                    <div class="col-md-4">
                        <input type="text" name="positions[]" value="<?php echo $row['position']; ?>"
                        class="form-control" >

                        <input type="hidden" name="id[]" value="<?php echo $row['id']; ?>">
                    </div>
                </div>
                <br>
                    <?php
                }
                 ?>

                 <div class="row">
                     <div class="col-md-4">

                     </div>

                     <div class="col-md-4">
                         <input type="submit" name="submit" value="Update Positions" class="btn btn-primary">
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
