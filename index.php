<?php
include_once 'includes/class.dbc.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';
include_once 'admin/classes/class.Status.php';
include_once 'includes/session.php';
include_once 'admin/classes/class.Product.php';

//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();

$loiStatus = Status::ACCEPTED;


//save quotation request to the database
if(isset($_POST['quotation']))
{
    //get all the values
    $quotation = filter($_POST['quotation']);
    $quantity = filter($_POST['quantity']);
    $unit = filter($_POST['unit']);
    $type = filter($_POST['quote_type']);


    //check thta ll fields are filled,
    if(empty($quotation) || empty($type))
    {
        $error = "Quotation and Type are needed";
    }

    if(!isset($error))
    {
        //process the quotation
        //save the quotation
        $query = "INSERT INTO `quotation` ( `quotation`, `unit`, `quantity`, `type`, `user_id` )

            VALUES('$quotation', '$unit', '$quantity', '$type', '$user_id');
        ";

        $result = mysqli_query($dbc, $query)
            or die("Error. Could not make quotation");

        //then indicate that it went through successfully.
        $success = "Quotation Made";
    }
}


 ?>

 <!DOCTYPE html>
 <html>
     <head>
         <meta charset="utf-8">
         <title>AGTM - Home</title>

         <link rel="shortcut icon" href="admin/assets/images/favicon.ico">

         <link rel="stylesheet" href="css/bootstrap.css">
         <link rel="stylesheet" href="css/font-awesome.css">
         <link rel="stylesheet" href="css/AdminLTE.css">
         <link rel="stylesheet" href="css/style.css">
         <link rel="stylesheet" href="css/toastr.min.css">


         <?php
         include_once 'includes/navigation.php';
         ?>

                <div class="bg-white p-20">
                    <div class="row">
                        <div class="col-xs-12 col-md-3">
                            <form class="" action="index.html" method="post">
                                 <div class="input-group ">
                                     <input type="text" class="form-control input-orange" name="search" placeholder="Search">
                                       <span class="input-group-btn">
                                         <button type="button" class="btn btn-orange btn-flat">
                                             <i class="fa fa-search"></i>
                                             Search!
                                         </button>
                                       </span>
                                 </div>
       <!--                         <div class="input-group">
                                    <input type="text" name="search" value="" placeholder="What are you looking for?"
                                           class="form-control">

                                    <div class="input-group-append">
                                        <button type="button" name="button" class="">
                                            <i class="fa fa-search"></i>
                                            Search
                                        </button>
                                    </div>
                                </div>-->
                            </form>

                        </div>

                        <div class="col-xs-12 col-md-9">
                            <?php
                            $query = "SELECT * FROM `spot_price` WHERE `status` = '1' ORDER BY `id` ";
                            $result = mysqli_query($dbc, $query)
                                or die("Error. Cannot get products");
                             ?>
                            <marquee>
                                Live Spot Prices.  <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    echo $row['item'] . " ( Arrivals: ";
                                    echo $row['quantity'] . ' ' . $row['unit'];
                                    echo ",  Price: ";
                                    echo $row['price'];
                                    echo " )  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;";
                                }
                                 ?>
                            </marquee>
                        </div>
                    </div>

                    <!-- row to cotain the categories, confirm loi and co -->
                    <br>
                    <div class="row">

                        <!-- column to show the categoeries. th -->
                        <div class="col-md-2">

                            <h3 class="categories">Categories</h3>

                            <ul class="categories">
                                <?php

                                //get all the categories
                                $query = "SELECT * FROM `categories` LIMIT 10";
                                $result = mysqli_query($dbc, $query)
                                   or die("Sorry. Internal Error");

                               while($row = mysqli_fetch_array($result))
                               {
                                   ?>
                                <li>
                                   <a href="products.php?category=<?php echo $row['id']; ?>">
                                       <?php echo $row['category_name']; ?>
                                   </a>
                                </li>
                                   <?php
                               }
                                 ?>
                            </ul>


                        </div>
                        <!-- end of col-md-2 to show the categories -->

                        <!-- columnt to show the soc for sa-->
                        <div class="col-md-4">

                            <!-- a row for the latest confirm loi -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>
                                        Latest Confirmed LOI for Purchase
                                    </h3>

                                    <div class="table-responsive">
                                        <table class="table table-home">
                                            <?php
                                            $query = "SELECT * FROM `importers` WHERE `status`  = '$loiStatus' ORDER BY `id` DESC LIMIT 5";
                                            $result = mysqli_query($dbc, $query)
                                                or die("Error. Could not get the SCOs");

                                            while($row = mysqli_fetch_array($result))
                                            {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <i class="fa fa-caret-right"></i>
                                                    </td>

                                                    <td>
                                                        <a href="#">
                                                            <?php echo $row['product_name'] . ' To ' . $row['destination']; ?>
                                                            <span>
                                                                <i class="fa fa-lock"></i>
                                                            </span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                             ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end of the first row -->

                            <!-- a row for the latest sco for sales. -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>
                                        Latest Confirmed SCO for sale
                                    </h3>

                                    <div class="table-responsive">
                                        <table class="table table-home">

                                            <?php
                                            $query = "SELECT * FROM `exporters` WHERE `status` = '$loiStatus' ORDER BY `id` DESC LIMIT 5";
                                            $result = mysqli_query($dbc, $query)
                                                or die("Error. Could not get the SCOs");

                                            while($row = mysqli_fetch_array($result))
                                            {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <i class="fa fa-caret-right"></i>
                                                    </td>

                                                    <td>
                                                        <a href="#">
                                                            <?php echo $row['product_name'] . ' From ' . $row['origin']; ?>
                                                            <span>
                                                                <i class="fa fa-lock"></i>
                                                            </span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                             ?>



                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end of the row SCO for sale -->

                        </div>
                        <!-- end of col-md-4 for the loi purchases and sco sales -->

                        <!-- next column buy and sell offers. -->
                        <div class="col-md-4">
                            <!-- a row for the latest confirm loi -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>
                                        Latest Buy Offers
                                    </h3>

                                    <div class="table-responsive">
                                        <table class="table table-home">
                                            <?php
                                            //get the latest buy offers
                                            $product_status = Status::ACCEPTED;
                                            $query = "SELECT * FROM `buy_offers` WHERE `status` = '$product_status' LIMIT 5 ";
                                            $result  = mysqli_query($dbc, $query)
                                                or die("Error Could not query");

                                            while($row = mysqli_fetch_array($result))
                                            {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <i class="fa fa-flag-checkered"></i>
                                                    </td>

                                                    <td>
                                                        <a href="buy_offer_details.php?offer=<?php echo $row['id']; ?>">
                                                            <?php echo $row['product_name']; ?>
                                                             For Sale
                                                        </a>
                                                    </td>

                                                    <td>
                                                        <?php echo agtm_date($row['time_added']); ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>



                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end of the first row -->

                            <!-- a row for the latest sco for sales. -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>
                                        Latest Sell Offers
                                    </h3>

                                    <div class="table-responsive">
                                        <table class="table table-home">
                                            <?php
                                            //get the latest buy offers
                                            $product_status = Status::ACCEPTED;
                                            $query = "SELECT * FROM `sell_offers` WHERE `status` = '$product_status' LIMIT 5 ";
                                            $result  = mysqli_query($dbc, $query)
                                                or die("Error Could not query");

                                            while($row = mysqli_fetch_array($result))
                                            {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <i class="fa fa-flag-checkered"></i>
                                                    </td>

                                                    <td>
                                                        <a href="sell_offer_details.php?offer=<?php echo $row['id']; ?>">
                                                            Buy
                                                            <?php echo $row['product_name']; ?>
                                                        </a>
                                                    </td>

                                                    <td>
                                                        <?php echo agtm_date($row['time_added']); ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end of the row SCO for sale -->
                        </div>
                    </div>
                    <!-- end of row for categories, confirm loi purchases and co  -->

                    <!-- row to cotain the market place, forum infor and products -->
                    <div class="row">

                        <!-- column to contain the market place, and requesting for quotation -->
                        <div class="col-md-3">
                            <h2>Market<span class="text-pink">Place </span> </h2>

                            <!-- row for madis live -->
                            
                            <!-- end of manis live -->

                            <!-- quotation -->
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn">
                                        Request for Quotation
                                    </button>
                                </div>
                            </div>
                            <!-- end quotation -->

                            <!-- quotation -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 class="title">
                                        One Request,
                                        <br>
                                        Multiple Quotes
                                    </h2>
                                </div>
                            </div>
                            <!-- end quotation -->

                            <!-- quotation request -->
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="post" class="form-horizontal">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="text" name="quotation" placeholder="Quotation "
                                                   class="form-control">
                                            </div>
                                        </div>

                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="quantity" placeholder="Quantity"
                                                   class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <input type="text" name="unit" value="" class="form-control" placeholder="Unit">
                                            </div>
                                        </div>

                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="text" name="quote_type" value="" class="form-control" placeholder="Type. E.G, Price, or Description">
                                            </div>
                                        </div>

                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="">
                                                    <input type="submit" name="quotation_request" value="Request Quotation" class="btn btn-orange">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end quotation request -->
                        </div>
                        <!-- end of col-md-3 for quotation and market place -->

                        <!-- column for the latest forum posts and some products. -->
                        <div class="col-md-6">

                            <!-- //get the first row for the forum news -->
                            <div class="row">
                                <div class="col-md-12">

                                </div>
                            </div>

                            <!-- //get the new row for the products -->
                            <div class="row">

                                <!-- //title -->
                                <div class="col-md-12">
                                    <h3 class="page-header">Products </h3>
                                </div>

                                <!-- //now get the latest 6 products  -->
                                <?php
                                //perform the query
                                $query = " SELECT * FROM `products` ORDER BY `id` DESC LIMIT 6";
                                $result = mysqli_query($dbc, $query)
                                    or die("Error. Could not get the products");

                                while ($row = mysqli_fetch_array($result)) {

                                    $product = new Product($row['id']);
                                    $pic = 'admin/' . $product->photo;
                                    $default_pic  = PRODUCT_IMAGE;
                                    ?>
                                    <div class="col-md-6 p-10">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-3">
                                                <img
                                                src="<?php if($product->photo != '' && file_exists($pic)) { echo $pic; } else { echo $default_pic; } ?>"
                                                alt="Product Image" class="product-image">
                                            </div>

                                            <div class="col-xs-12 col-md-9">
                                                <div class="middle text-center p-20">
                                                    <span class="product-name"><?php echo $product->product_name; ?></span>

                                                    <br><br>

                                                    <span class="bolder">
                                                        US $<span class="price"> <?php echo $product->price; ?> </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <?php
                                }
                                 ?>

                            </div>
                        </div>
                        <!-- end of column for forum posts and products -->

                        <!-- advertisement space -->
                        <div class="col-md-3">

                        </div>
                        <!-- end of advertisement space. -->
                    </div>
                </div>


                <!--//next row for the footer-->
                <?php
                include_once 'includes/footer.php';
                 ?>



         <?php

         include_once 'includes/scripts.php';
         include_once 'includes/toast.php';

         ?>
     </body>
 </html>
