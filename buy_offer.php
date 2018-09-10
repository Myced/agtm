<?php

include_once 'includes/class.dbc.php';
include_once 'includes/session.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';


//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();

$page_title = "Make Buy Offer";

//include other custom plugins needed
$errors = [];

//function to generate a  a request code
function gen_code ()
{
    global $dbc;

  $query  = "select `id` from `buy_offers` ORDER BY `id` DESC LIMIT 1";
  $result = mysqli_query($dbc, $query);

  if(mysqli_num_rows($result) == 0)
  {
     return 'BUY-00001';
  }
  else
    {
        list($id) = mysqli_fetch_array($result);
        ++$id;
        $nn = "BUY-";

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

//process the form
if(isset($_POST['product']))
{
    //get the form fields and save them
    $product = filter($_POST['product']);
    $quantity = filter($_POST['quantity']);
    $packaging = filter($_POST['packaging']);
    $contact_name = filter($_POST['contact_name']);
    $price = get_money(filter($_POST['price']));
    $contact_tel = filter($_POST['tel']);
    $email  = filter($_POST['email']);
    $company = filter($_POST['company']);
    $description = filter($_POST['description']);
    $code = gen_code();


    //now validate
    if(empty($contact_name))
    {
        $errors[] = "Sorry, Contact Name is required";
    }

    if(empty($email))
    {
        $errors[] = "Sorry. Contact Email is required";
    }

    if(empty($product))
    {
        $errors[] = "Sorry, You must provide the product name";
    }

    //if an error is not set then save the requiest
    if(count($errors) == 0)
    {
        //save it to the databaase
        $query = "INSERT INTO `buy_offers` ( `code`,
                `product_name`, `quantity`,  `packaging`, `price`,
                `contact_name`, `contact_email`, `tel`, `company`, `user_id`,
                `day`, `month`, `year`, `time_added`, `date`, `description`
            )

            VALUES ( '$code',
                '$product', '$quantity',  '$packaging', '$price',
                '$contact_name', '$email', '$contact_tel', '$company', '$user_id',
                '$day', '$month', '$year', NOW(), '$date', '$description'
            )";

        $result = mysqli_query($dbc, $query)
            or die("Internal Error. Cannot Save the Request");

        $success = "Buy Offer Saved. You will be contacted when it is approved";
    }

}


include_once 'includes/head.php';
?>
<!-- custom styles can go here  -->

<?php
include_once 'includes/navigation.php';
?>

<div class="row">
    <div class="col-md-12">
        <h2 class="page-header" >Make Buy Offer</h2>

        <?php
        if(isset($_SESSION['user_id']))
        {
            ?>
            <form class="form-horizontal" action="" method="post">
                <div class="row">
                    <div class="col-md-6 col-md-offset-2">
                        <h3 class="page-header">Product Details</h3>
                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Product Name:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                <input type="text" name="product" class="form-control" placeholder="Enter the Product Name"
                                    required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Quantity:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                <input type="text" name="quantity" class="form-control" placeholder="Quantity"
                                    required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Price:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                <input type="text" name="price" class="form-control" placeholder="Price"
                                    required="">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                packaging:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                <input type="text" name="packaging" class="form-control" placeholder="packaging or units">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Description:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                <textarea name="description" rows="8" class="form-control"
                                placeholder="Enter the Description here"
                                ></textarea>
                            </div>
                        </div>


                        <br>
                        <h3 class="page-header">Your Contact</h3>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Contact Name:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                <input type="text" name="contact_name" class="form-control" placeholder="Name"
                                    required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Contact Email:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                <input type="text" name="email" class="form-control" placeholder="example@email.com"
                                    required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Contact Phone Number:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                <input type="text" name="tel" class="form-control" placeholder="(+237) 667-898-098"
                                    required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Company Name:
                            </label>
                            <div class="col-md-7">
                                <input type="text" name="company" class="form-control" placeholder="Company Name"
                                    >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">

                            </label>
                            <div class="col-md-7">
                                <input type="submit" name="save" class="btn btn-primary" value="Save Buy Offer">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php
        }
        else {
            include_once 'includes/notice.php';
        }
         ?>

    </div>
</div>

<?php
include_once 'includes/footer.php';
include_once 'includes/scripts.php';
include_once 'includes/toast.php';
?>

<!-- custom scripts here -->

<?php
include_once 'includes/end.php';
?>
