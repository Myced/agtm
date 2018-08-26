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
    //get all the form values
    $product = filter($_POST['name']);
    $quantity = filter($_POST['quantity']);
    $unit = filter($_POST['unit']);
    $price = filter($_POST['price']);
    $category = filter($_POST['category']);
    $description = filter($_POST['description']);

    $id = filter($_GET['id']);


    $upload = FALSE;

    //now check for errors
    if(empty($product))
    {
        $errors = "Sorry, The product name is needed";
    }

    if($price == '')
    {
        $error = "Sorry, The price is needed";
    }

    if(count($errors) == 0)
    {
        //process the image
        if(isset($_FILES['photo']))
        {
            //thne grab the filres
            //now grab photo options
            $photo_location = '';
            $file_name = $_FILES['photo']['name'];
            $tmp_name  = $_FILES['photo']['tmp_name'];
            $file_type = $_FILES['photo']['type'];
            $file_size = $_FILES['photo']['size'];

            $max_file_size = 20000000; //20Mb

            if(!empty($file_name))
            {
                //$error = "Sorry. You must upload a profile Picture";
                if($file_size > $max_file_size)
                {
                    $errors = "Sorry. File Size too large";
                }

                //Now validate the file format
                if($file_type != "image/jpg" && $file_type != "image/jpeg" && $file_type != "image/gif"
                        && $file_type != "image/png" && $file_type != "image/tiff" )
                {
                    $errors = "Sorry. Inappropriate File Type. Acceptable Picture formats include \"jpg, jpeg, png, gif\"  ";
                }

                //picture destination
                $destination = "uploads/products/";
                $date_string = date("Ymdhms") . '_';
                $final_name = $date_string . $file_name;

                $photo_location = $destination . $final_name;

                if(!isset($error))
                {
                    $upload = TRUE;
                }
            }
            else
            {
                $upload = FALSE;
                $photo_location = '';
            }
        }

        //check if there are no errors
        if(count($errors == 0))
        {
            if($upload == TRUE)
            {

                if(move_uploaded_file($tmp_name, $photo_location))
                {
                    $query = "UPDATE `products` SET "
                            . "   `product_name` = '$product', `category` = '$category', `quantity` = '$quantity', "
                            . " `unit` = '$unit', `description` = '$description', `photo` = '$photo_location',  "
                            . " `price` = '$price' "
                            . " WHERE `id` = '$id' ";
                    $result = mysqli_query($dbc, $query)
                            or die("Error" . mysqli_error($dbc));


                }
                else
                {
                    $warning = "Could not upload the picture";

                    $photo_location = '';
                    $query = "UPDATE `products` SET "
                            . "   `product_name` = '$product', `category` = '$category', `quantity` = '$quantity', "
                            . " `unit` = '$unit', `description` = '$description', `photo` = '$photo_location',  "
                            . " `price` = '$price' "
                            . " WHERE `id` = '$id' ";
                    $result = mysqli_query($dbc, $query)
                            or die("Error");
                }
            }
            else
            {
                $query = "UPDATE `products` SET "
                        . "   `product_name` = '$product', `category` = '$category', `quantity` = '$quantity', "
                        . " `unit` = '$unit', `description` = '$description', "
                        . " `price` = '$price' "
                        . " WHERE `id` = '$id' ";
                $result = mysqli_query($dbc, $query)
                            or die("Error");
            }


            //indicate that the transaction was successful
            $success = "Product Details Updated";

        }//end of checking if there are erros
    }
}

//get the producut details
if(isset($_GET['id']))
{
    $id = filter($_GET['id']);
}
else {
    $id = '0';
}

//now query
$query = "SELECT * FROM `products` WHERE `id` = '$id' ";
$result = mysqli_query($dbc, $query)
    or die("Error. Cannot get the product details");


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
            <h1 class="page-title">
                Add New Product
            </h1>


            <br>
            <?php
            while($row = mysqli_fetch_array($result))
            {
                ?>
                <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="product" class="control-label col-md-5">
                                        Product Name:
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-12">
                                        <input type="text" name="name" class="form-control" placeholder="Product Name" required
                                            value="<?php echo $row['product_name']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="product" class="control-label col-md-5">Quantity:</label>
                                    <div class="col-md-12">
                                        <input type="text" name="quantity" class="form-control" placeholder="Quantity"
                                            value="<?php echo $row['quantity']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="product" class="control-label col-md-5"> Unit:</label>
                                    <div class="col-md-12">
                                        <input type="text" name="unit" class="form-control" placeholder="Unit e.g. Barrels"
                                            value="<?php echo $row['unit']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="product" class="control-label col-md-5">
                                        Price:
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-12">
                                        <input type="text" name="price" class="form-control" placeholder="Price" required
                                            value="<?php echo $row['price']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="product" class="control-label col-md-5">Category:</label>
                                    <div class="col-md-12">
                                        <select class="form-control select2" name="category">
                                            <?php
                                            $query = "SELECT * FROM `categories` ";
                                            $result = mysqli_query($dbc, $query)
                                                or die("Error. Cannot get categories");

                                            while ($ro = mysqli_fetch_array($result)) {
                                                ?>
                                            <option value="<?php echo $ro['id']; ?>"
                                                <?php if($row['category'] == $ro['id']) { echo 'selected'; } ?>
                                                >
                                                <?php echo $ro['category_name'] ?>
                                            </option>
                                                <?php
                                            }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="product" class="control-label col-md-5">Product Description:</label>
                                    <div class="col-md-12">
                                        <textarea name="description" rows="8" cols="80"
                                        class="form-control"
                                        ><?php echo $row['description'] ?></textarea>
                                    </div>
                                </div>


                            </div>
                            <!-- //end the first column -->

                            <!-- nex column -->
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="product" class="control-label col-md-5">Product Image:</label>
                                    <div class="col-md-12">
                                        <input type="file" name="photo" value="" class="form-control" id="image">

                                        <br>
                                        <img src="
                                        <?php if($row['photo'] != NULL && file_exists($row['photo'])) { echo $row['photo']; } else { echo STATIC_PRODUCT_IMAGE; } ?>
                                        " alt=" Product Image" width="200px" height="200px" id="img">
                                    </div>
                                </div>
                            </div>
                            <!-- //end of second column  -->
                    </div>
                    <!-- end of row -->

                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <a href="product_list.php" class="btn btn-info">
                                    <i class="fa fa-chevron-left"></i>
                                    Back to Product List
                                </a>
                                <input type="submit" name="submit" value="Save Product" class="btn btn-success">
                                <!-- <a href="" class="btn btn-info" title="Clear form inputs">Clear</a> -->
                            </div>
                        </div>
                    </div>
                </form>
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
<script type="text/javascript">
$(document).ready(function(){
    function readURL(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#img').attr('src', e.target.result);

          $('#img').hide();
          $('#img').fadeIn(650);

        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#image").change(function() {
      readURL(this);
    });
});
</script>

<?php
include_once 'includes/end.php';
?>
