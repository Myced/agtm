<?php

include_once 'includes/class.dbc.php';
include_once 'includes/session.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';
include_once 'admin/classes/class.Product.php';

//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();

//get the search and show the results.
$search = filter($_GET['search']);

if(empty($search))
{

}
else {
    //do your search here.
    //start with LOIs
    $query = "SELECT * FROM `loi` WHERE `title` LIKE '%%$search' OR `description` LIKE '%$search%' ";
    $lois = mysqli_query($dbc, $query);

    //now search scos too
    $query = "SELECT * FROM `sco` WHERE `title` LIKE '%%$search' OR `description` LIKE '%$search%' ";
    $scos = mysqli_query($dbc, $query);

    //now search sell offers
    $query = "SELECT * FROM `sell_offers` WHERE `product_name` LIKE '$search' OR `description` LIKE '%$search%'";
    $sell_offers = mysqli_query($dbc, $query);

    //do same for buy offers
    $query = "SELECT * FROM `buy_offers` WHERE `product_name` LIKE '$search' OR `description` LIKE '%$search%'";
    $buy_offers = mysqli_query($dbc, $query);

    //now check for products too
    $query = "SELECT * FROM `products` WHERE `product_name` LIKE '%$search%' OR `description` LIKE '%$search%' ";
    $products  = mysqli_query($dbc, $query);


}

//check the state of results
$empty = TRUE;


include_once 'includes/head.php';
?>
<!-- custom styles can go here  -->

<?php
include_once 'includes/navigation.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="bg-white p-20">
            <h2 class="page-header">Search Results for "<?php echo $search; ?>"</h2>


            <?php
            if(!isset($lois))
            {
                ?>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="text-center">
                        <div class="alert alert-info">
                            <strong>Sorry. You did not enter a search term</strong>
                            <br>
                            Search Below or return to homepage
                        </div>

                        <form class="" action="" method="get">
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

                        <br>
                        <a href="index.php">
                            <i class="fa fa-home"></i>
                            Back to Home
                        </a>
                    </div>

                    <br>
                </div>
            </div>
                <?php
            }
            else {
                //for each search ttype. Only show it when ther is a result
                //start with LOI
                if(mysqli_num_rows($lois) > 0)
                {
                    $empty = FALSE;

                    ?>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="page-header search-heading">LOI found</h3>

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="timeline" >
                                    <li class="">
                                        <?php

                                        while ($row = mysqli_fetch_array($lois)) {
                                            ?>
                                            <div class="timeline-item" style="border: 1px solid #ccc;">
                                              <span class="time"><i class="fa fa-clock-o"></i> <?php echo date_from_timestamp($row['time_added']); ?> </span>

                                              <h3 class="timeline-header"><a href="loi_details.php?offer=<?php echo $row['id']; ?>">
                                                  <?php echo $row['title']; ?>
                                                  </a>
                                              </h3>

                                              <div class="timeline-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <img src="admin/<?php echo $row['image']; ?>" alt="LOI Image"
                                                                width="200px" height="200px">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <?php
                                                            $text = nl2br(substr($row['description'], 0, 200));

                                                            echo $text;
                                                             ?>
                                                        </div>
                                                    </div>
                                              </div>
                                              <div class="timeline-footer">
                                                <a class="btn btn-primary" href="loi_details.php?offer=<?php echo $row['id']; ?>">Read more</a>
                                              </div>
                                            </div>

                                            <br><br>
                                            <?php
                                        }
                                         ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php
                }

                //next is sco
                if(mysqli_num_rows($scos) > 0)
                {

                    $empty = FALSE;

                    ?>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="page-header search-heading">SCOs  found</h3>

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="timeline">
                                    <li class="">
                                        <?php

                                        //get all the offers
                                        $query = "SELECT * FROM `sco` WHERE `status` = '$status' ";
                                        $result = mysqli_query($dbc, $query)
                                            or die("Error.");
                                        while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                            <div class="timeline-item" style="border: 1px solid #aaa;">
                                              <span class="time"><i class="fa fa-clock-o"></i> <?php echo date_from_timestamp($row['time_added']); ?> </span>

                                              <h3 class="timeline-header"><a href="sco_details.php?offer=<?php echo $row['id']; ?>">
                                                  <?php echo $row['title']; ?>
                                                  </a>
                                              </h3>

                                              <div class="timeline-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <img src="admin/<?php echo $row['image']; ?>" alt="LOI Image"
                                                                width="200px" height="200px">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <?php
                                                            $text = nl2br(substr($row['description'], 0, 200));

                                                            echo $text;
                                                             ?>
                                                        </div>
                                                    </div>
                                              </div>
                                              <div class="timeline-footer">
                                                <a class="btn btn-primary" href="sco_details.php?offer=<?php echo $row['id']; ?>">Read more</a>
                                              </div>
                                            </div>

                                            <br><br>
                                            <?php
                                        }
                                         ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php
                }

                if(mysqli_num_rows($sell_offers) > 0)
                {

                    $empty = FALSE;

                    ?>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="page-header search-heading">Sell Offers Found</h3>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <tr>
                                        <th>S/N</th>
                                        <th>Date Added</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Units/Packaging</th>
                                        <th>Description</th>

                                    </tr>

                                    <?php

                                    $count = 1;

                                    while ($row = mysqli_fetch_array($sell_offers))
                                    {
                                        ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['date']; ?></td>
                                        <td>
                                            <a href="sell_offer_details.php?offer=<?php echo $row['id'] ?>">
                                                <?php echo $row['product_name']; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $row['price']; ?></td>
                                        <td><?php echo $row['packaging']; ?></td>
                                        <td>
                                            <?php
                                            $des = substr($row['description'], 0, 50);

                                            echo nl2br($des);
                                             ?>
                                        </td>
                                    </tr>
                                        <?php
                                    }
                                     ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php
                }

                if(mysqli_num_rows($buy_offers) > 0)
                {

                    $empty = FALSE;

                    ?>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="page-header search-heading">Buy Offers Found</h3>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <tr>
                                        <th>S/N</th>
                                        <th>Date Added</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Units/Packaging</th>
                                        <th>Description</th>

                                    </tr>

                                    <?php

                                    $count = 1;

                                    while ($row = mysqli_fetch_array($buy_offers))
                                    {
                                        ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['date']; ?></td>
                                        <td>
                                            <a href="buy_offer_details.php?offer=<?php echo $row['id'] ?>">
                                                <?php echo $row['product_name']; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $row['price']; ?></td>
                                        <td><?php echo $row['packaging']; ?></td>
                                        <td>
                                            <?php
                                            $des = substr($row['description'], 0, 50);

                                            echo nl2br($des);
                                             ?>
                                        </td>
                                    </tr>
                                        <?php
                                    }
                                     ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php
                }

                if(mysqli_num_rows($products) > 0)
                {

                    $empty = FALSE;

                    ?>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="page-header">Product Results</h3>

                        <div class="row">
                            <?php
                            while($row = mysqli_fetch_array($products))
                            {
                                $product = new Product($row['id']);
                                $pic = 'admin/' . $product->photo;
                                $default_pic  = PRODUCT_IMAGE;

                                ?>
                            <div class="col-md-3 p-10">
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
                </div>
                    <?php
                }

                //now if no result was found the show
                if($empty == TRUE)
                {
                    ?>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="text-center">
                            <div class="alert alert-info">
                                <strong>No Results Found</strong>
                                <br>
                                Try Searching again by reducing the sentence length
                            </div>

                            <form class="" action="" method="get">
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

                            <br>
                            <a href="index.php">
                                <i class="fa fa-home"></i>
                                Back to Home
                            </a>
                        </div>

                        <br>
                    </div>
                </div>
                    <?php
                }
            }
             ?>

        </div>
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
