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

$loiStatus = Status::AVAILABLE;


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
         <link rel="stylesheet" href="plugins/slick/slick.css">
         <!-- <link rel="stylesheet" href="plugins/slick/slick-theme.css"> -->
         <style media="screen">
            .slick-prev,
            .slick-next {
             font-size: 0;
             position: absolute;
             bottom: 50px;
             color: #6a8799;
             border: 0;
             background: none;
             z-index: 1;
            }

            .slick-prev {
             left: 20px;
            }

            .slick-prev:after {
               content: "\f104";
             font: 40px/1 'FontAwesome';
            }

            .slick-next {
             right: 20px;
             text-align: right;
            }

            .slick-next:after {
                content: "\f105";
              font: 40px/1 'FontAwesome';
            }

            .slick-prev:hover:after,
            .slick-next:hover:after {
             color: #7e7e7e;
            }
         </style>

         <?php
         include_once 'includes/navigation.php';
         ?>

                <div class="bg-white p-20">
                    <div class="row">
                        <div class="col-xs-12 col-md-3">
                            <form class="" action="search.php" method="get">
                                 <div class="input-group ">
                                     <input type="text" class="form-control input-orange" name="search" placeholder="Search">
                                       <span class="input-group-btn">
                                         <button type="submit" class="btn btn-orange btn-flat">
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

                            <div class="slim">
                                <ul class="categories">
                                    <?php

                                    //get all the categories
                                    $query = "SELECT * FROM `categories` ";
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


                        </div>
                        <!-- end of col-md-2 to show the categories -->

                        <!-- columnt to show the soc for sa-->
                        <div class="col-md-3">

                            <!-- a row for the latest confirm loi -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="loi-heading">
                                        Latest
                                        <a href="approved_trades.php">
                                            Confirmed LOI
                                        </a>
                                         for Purchase
                                    </h3>

                                    <div class="table-responsive">

                                        <table class="table table-home vticker">
                                            <?php
                                            $query = "SELECT * FROM `loi` WHERE `status`  = '$loiStatus' ORDER BY `id` DESC ";
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
                                                        <a href="loi_details.php?offer=<?php echo $row['id']; ?>">
                                                            <?php echo $row['title']; ?>
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
                                    <h3 class="loi-heading">
                                        Latest

                                        <a href="approved_trades.php?sco=true">
                                            Confirmed SCO
                                        </a>

                                        for sale
                                    </h3>

                                    <div class="table-responsive">
                                        <table class="table table-home vticker">

                                            <?php
                                            $query = "SELECT * FROM `sco` WHERE `status` = '$loiStatus' ORDER BY `id` DESC ";
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
                                                        <a href="sco_details.php?offer=<?php echo $row['id']; ?>">
                                                            <?php echo $row['title']; ?>
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
                        <div class="col-md-3">
                            <!-- a row for the latest confirm loi -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="loi-heading">
                                        Latest <a href="all_buy_offers.php">Buy Offers</a>
                                    </h3>

                                    <div class="table-responsive">
                                        <table class="table table-home vticker">
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
                                                             Needed
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
                                    <h3 class="loi-heading">
                                        Latest
                                        <a href="all_sell_offers.php">Sell Offers</a>
                                    </h3>

                                    <div class="table-responsive">
                                        <table class="table table-home vticker">
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
                            <!-- end of the row SCO for sale -->

                            <br><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php

                                    $query = "SELECT `link`, `image` FROM `ads` WHERE `id` = '4' ";
                                    $result = mysqli_query($dbc, $query);

                                    list($link, $image) = mysqli_fetch_array($result);
                                     ?>

                                     <a href="<?php echo $link; ?>" target="_blank">
                                         <img src="admin/<?php echo $image; ?>" alt="Advert Image"
                                         class="ad1" width="100%" height="300px">
                                     </a>
                                </div>
                            </div>
                        </div>

                        <!-- //next column for forum post  -->
                        <div class="col-md-4">
                            <div class="row">
                                <h3 class="page-header">Forum Updates</h3>

                                <div class="col-md-12">
                                    <?php
                                    $query = "SELECT * FROM `threads` ORDER BY `views` DESC LIMIT 4";
                                    $result = $dbc->query($query);

                                    while($row = $result->fetch_assoc())
                                    {
                                        ?>
                                    <div class="callout">
                                        <h5> <strong><?php echo $row['title']; ?></strong> </h5>
                                        <p>
                                            <?php
                                            $text = nl2br(substr($row['description'], 0, 60));

                                            echo $text;
                                             ?> ...
                                        </p>
                                    </div>
                                        <?php
                                    }

                                     ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of row for categories, confirm loi purchases and co  -->

                    <!-- row to cotain the market place, forum infor and products -->
                    <div class="row">

                        <!-- column to contain the market place, and requesting for quotation -->
                        <div class="col-md-3">

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

                            <!-- //ad space -->
                            <br><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php

                                    $query = "SELECT `link`, `image` FROM `ads` WHERE `id` = '1' ";
                                    $result = mysqli_query($dbc, $query);

                                    list($link, $image) = mysqli_fetch_array($result);
                                     ?>

                                     <a href="<?php echo $link; ?>" target="_blank">
                                         <img src="admin/<?php echo $image; ?>" alt="Advert Image"
                                         class="ad1" width="100%" height="300px">
                                     </a>
                                </div>
                            </div>

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
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="page-header">Products </h3>
                                    </div>
                                </div>

                                <!-- //peform slick for the first five items  -->
                                <div class="row ">
                                    <div class="slider first">
                                        <?php
                                        //perform the query
                                        $query = " SELECT * FROM `product_rows` WHERE `row` = '1'
                                                    ORDER BY `position` ASC LIMIT 8";
                                        $result = mysqli_query($dbc, $query)
                                            or die("Error. Could not get the products");

                                        while ($row = mysqli_fetch_array($result)) {

                                            $product = new Product($row['product_id']);
                                            $pic = 'admin/' . $product->photo;
                                            $default_pic  = PRODUCT_IMAGE;
                                            ?>
                                            <div class="col-md-5 p-10">
                                                <a href="product_details.php?id=<?php echo $row['id'] ?>">
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

                                                                <span class="bolder text-black">
                                                                    US $<span class="price"> <?php echo $product->price; ?> </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                         ?>
                                    </div>
                                </div>

                                <!-- next row for the next six items  -->
                                <div class="row">
                                    <div class="slider first">
                                        <?php
                                        //perform the query
                                        $query = " SELECT * FROM `product_rows` WHERE `row` = '2'
                                                    ORDER BY `position` ASC LIMIT 8";
                                        $result = mysqli_query($dbc, $query)
                                            or die("Error. Could not get the products");

                                        while ($row = mysqli_fetch_array($result)) {

                                            $product = new Product($row['product_id']);
                                            $pic = 'admin/' . $product->photo;
                                            $default_pic  = PRODUCT_IMAGE;
                                            ?>
                                            <div class="col-md-5 p-10">
                                                <a href="product_details.php?id=<?php echo $row['id']; ?>">
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

                                                                <span class="bolder text-black">
                                                                    US $<span class="price"> <?php echo $product->price; ?> </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                         ?>
                                    </div>
                                </div>

                                <!-- next row for the next six items  -->
                                <div class="row">
                                    <div class="slider first">
                                        <?php
                                        //perform the query
                                        $query = " SELECT * FROM `product_rows` WHERE `row` = '3'
                                                    ORDER BY `position` ASC LIMIT 8";
                                        $result = mysqli_query($dbc, $query)
                                            or die("Error. Could not get the products");

                                        while ($row = mysqli_fetch_array($result)) {

                                            $product = new Product($row['product_id']);
                                            $pic = 'admin/' . $product->photo;
                                            $default_pic  = PRODUCT_IMAGE;
                                            ?>
                                            <div class="col-md-5 p-10">

                                                <a href="product_details.php?id=<?php echo $row['id']; ?>">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-md-3">
                                                            <img
                                                            src="<?php if($product->photo != '' && file_exists($pic)) { echo $pic; } else { echo $default_pic; } ?>"
                                                            alt="Product Image" class="product-image">
                                                        </div>

                                                        <div class="col-xs-12 col-md-9 text-black" >
                                                            <div class="middle text-center p-20">
                                                                <span class="product-name"><?php echo $product->product_name; ?></span>

                                                                <br><br>

                                                                <span class="bolder">
                                                                    US $<span class="price"> <?php echo $product->price; ?> </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>

                                            </div>
                                            <?php
                                        }
                                         ?>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <!-- end of column for forum posts and products -->

                        <!-- advertisement space -->
                        <div class="col-md-3">
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php

                                    $query = "SELECT `link`, `image` FROM `ads` WHERE `id` = '2' ";
                                    $result = mysqli_query($dbc, $query);

                                    list($link, $image) = mysqli_fetch_array($result);
                                     ?>

                                     <a href="<?php echo $link; ?>" target="_blank">
                                         <img src="admin/<?php echo $image; ?>" alt="Advert Image"
                                         class="ad2"  width="100%" height="300px">
                                     </a>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php

                                    $query = "SELECT `link`, `image` FROM `ads` WHERE `id` = '3' ";
                                    $result = mysqli_query($dbc, $query);

                                    list($link, $image) = mysqli_fetch_array($result);
                                     ?>

                                     <a href="<?php echo $link; ?>" target="_blank">
                                         <img src="admin/<?php echo $image; ?>" alt="Advert Image"
                                          class="ad3"  width="100%" height="300px">
                                     </a>
                                </div>
                            </div>
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
         <script type="text/javascript" src="plugins/slick/slick.min.js"></script>
         <script type="text/javascript" src="js/jquery.slimscroll.js"></script>
         <script type="text/javascript" src="js/jquery.easing.min.js"></script>
         <script type="text/javascript" src="js/jquery.easy-ticker.min.js"></script>
         <script type="text/javascript">
             $(document).ready(function(){
                 var dd = $('.vticker').easyTicker({
            		direction: 'up',
            		easing: 'easeInOutBack',
            		speed: 'slow',
            		interval: 2000,
            		height: 'auto',
            		visible: 10,
            		mousePause: 0,
            		controls: {
            			up: '.up',
            			down: '.down',
            			toggle: '.toggle',
            			stopText: 'Stop !!!'
            		}
            	}).data('easyTicker');

                $('.slim').slimScroll({
            		height: '500px'
            	});


                //initialse slick too
                $('.first').slick({
                  slidesToShow: 2,
                  slidesToScroll: 1,
                  autoplay: true,
                  autoplaySpeed: 2000,
                });
             })
         </script>
     </body>
 </html>
