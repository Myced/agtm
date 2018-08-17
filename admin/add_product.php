<?php
//
//database and other function initialisations
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

//generate a product code
function gen_code()
{
  //database connection;
  global $dbc;


  $query  = "select `id` from `products` ORDER BY `id` DESC LIMIT 1";
  $result = mysqli_query($dbc, $query);

  if(mysqli_num_rows($result) == 0)
  {
     return 'PR-000001';
  }
  else
    {
        list($id) = mysqli_fetch_array($result);
        ++$id;
        $nn = "PR-";

        if($id < 10)
        {
          $zeros = '00000';
        }
        elseif ($id < 100) {
          $zeros = '0000';
        }
        elseif ($id < 1000) {
          $zeros = '000';
        }
        elseif ($id < 10000) {
          $zeros = '00';
        }
        elseif ($id < 100000) {
          $zeros = '0';
        }
        return $nn . $zeros . $id;
    }
}

if(isset($_POST['name']))
{
    //get all the form values
    $product = filter($_POST['name']);
    $quantity = filter($_POST['quantity']);
    $unit = filter($_POST['unit']);
    $price = filter($_POST['price']);
    $category = filter($_POST['category']);
    $description = filter($_POST['description']);

    $product_code = gen_code();

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
                $warning = "User's Photo has not been set. You might consider uploading it later";
            }
        }

        //check if there are no errors
        if(count($errors == 0))
        {
            if($upload == TRUE)
            {

                if(move_uploaded_file($tmp_name, $photo_location))
                {
                    $query = "INSERT INTO `products` ("
                            . "  `product_code`, `product_name`, `category`, `quantity`, `price`, "
                            . " `unit`, `description`, `photo`, `time_added`, `user_id` )"
                            . ""
                            . " VALUES ("
                            . " '$product_code', '$product', '$category', '$quantity', '$price', "
                            . " '$unit', '$description', '$photo_location', NOW(), '$user_id')";
                    $result = mysqli_query($dbc, $query)
                            or die("Error" . mysqli_error($dbc));


                }
                else
                {
                    $warning = "Could not upload the picture";

                    $photo_location = '';
                    $query = "INSERT INTO `products` ("
                            . "  `product_code`, `product_name`, `category`, `quantity`, `price`, "
                            . " `unit`, `description`, `photo`, `time_added`, `user_id` )"
                            . ""
                            . " VALUES ("
                            . " '$product_code', '$product', '$category', '$quantity', '$price', "
                            . " '$unit', '$description', '$photo_location', NOW(), '$user_id')";
                    $result = mysqli_query($dbc, $query)
                            or die("Error");
                }
            }
            else
            {
                $photo_location = '';
                $query = "INSERT INTO `products` ("
                        . "  `product_code`, `product_name`, `category`, `quantity`,  `price`, "
                        . " `unit`, `description`, `photo`, `time_added`, `user_id` )"
                        . ""
                        . " VALUES ("
                        . " '$product_code', '$product', '$category', '$quantity', '$price' "
                        . " '$unit', '$description', '$photo_location', NOW(), '$user_id')";
                $result = mysqli_query($dbc, $query)
                            or die("Error");
            }


            //indicate that the transaction was successful
            $success = "Product Saved";

        }//end of checking if there are erros
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
            <h1 class="page-title">
                Add New Product
            </h1>


            <br>
            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                        <div class="col-md-7">
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
                                <label for="product" class="control-label col-md-5">Quantity:</label>
                                <div class="col-md-12">
                                    <input type="text" name="quantity" class="form-control" placeholder="Quantity">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product" class="control-label col-md-5"> Unit:</label>
                                <div class="col-md-12">
                                    <input type="text" name="unit" class="form-control" placeholder="Unit e.g. Barrels">
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
                                <label for="product" class="control-label col-md-5">Category:</label>
                                <div class="col-md-12">
                                    <select class="form-control select2" name="category">
                                        <?php
                                        $query = "SELECT * FROM `categories` ";
                                        $result = mysqli_query($dbc, $query)
                                            or die("Error. Cannot get categories");

                                        while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                        <option value="<?php echo $row['id']; ?>">
                                            <?php echo $row['category_name'] ?>
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
                                    ></textarea>
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
                                    <img src="../images/photo.png" alt=" Product Image" width="200px" height="200px" id="img">
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
                            <input type="submit" name="submit" value="Save Product" class="btn btn-success">
                            <!-- <a href="" class="btn btn-info" title="Clear form inputs">Clear</a> -->
                        </div>
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
