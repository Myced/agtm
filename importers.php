<?php

include_once 'includes/class.dbc.php';
include_once 'includes/session.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';


//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();

//include other custom plugins needed
$errors = [];

//function to generate a  a request code
function gen_code ()
{
    global $dbc;

  $query  = "select `id` from `importers` ORDER BY `id` DESC LIMIT 1";
  $result = mysqli_query($dbc, $query);

  if(mysqli_num_rows($result) == 0)
  {
     return 'IMP-00001';
  }
  else
    {
        list($id) = mysqli_fetch_array($result);
        ++$id;
        $nn = "IMP-";

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
    $destination = filter($_POST['destination']);
    $packing = filter($_POST['packing']);
    $trade_term = filter($_POST['trade_term']);
    $contact_name = filter($_POST['contact_name']);
    $contact_tel = filter($_POST['tel']);
    $email  = filter($_POST['email']);
    $company = filter($_POST['company']);
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
        $query = "INSERT INTO `importers` ( `code`,
                `product_name`, `quantity`, `destination`, `packing`, `trade_term`,
                `contact_name`, `contact_email`, `tel`, `company`, `user_id`,
                `day`, `month`, `year`, `date`, `time_added`
            )

            VALUES ( '$code',
                '$product', '$quantity', '$destination', '$packing', '$trade_term',
                '$contact_name', '$email', '$contact_tel', '$company', '$user_id',
                '$day', '$month', '$year', '$date', NOW()
            ) ";

        $result = mysqli_query($dbc, $query)
            or die("Internal Error. Cannot Save the Request");

        $success = "Details Saved. You will be contacted later";
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
        <h2 class="page-header" >For Importers / Buyers</h2>

        <?php
        if(isset($_SESSION['user_id']))
        {
            ?>
            <form class="form-horizontal" action="" method="post">
                <div class="row">
                    <div class="col-md-6 col-md-offset-2">
                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">Product Name:</label>
                            <div class="col-md-7">
                                <input type="text" name="product" class="form-control" placeholder="Enter the Product Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">Quantity:</label>
                            <div class="col-md-7">
                                <input type="text" name="quantity" class="form-control" placeholder="Quantity">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Destination:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                <input type="text" name="destination" class="form-control" placeholder="Destination">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Required Packing:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                <input type="text" name="packing" class="form-control" placeholder="Required Packing">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Required Trade Term:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                <input type="text" name="trade_term" class="form-control" placeholder="Trade Term">
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Contact Name:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                <input type="text" name="contact_name" class="form-control" placeholder="Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Contact Email:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                <input type="text" name="email" class="form-control" placeholder="example@email.com">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Contact Phone Number:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                <input type="text" name="tel" class="form-control" placeholder="(+237) 667-898-098">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">
                                Company Name:
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                <input type="text" name="company" class="form-control" placeholder="Company Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product" class="control-label col-md-5">

                            </label>
                            <div class="col-md-7">
                                <input type="submit" name="save" class="btn btn-primary" value="Make Request">
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
