<?php

include_once 'includes/class.dbc.php';
include_once 'includes/session.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';
include_once 'admin/classes/class.Product.php';

//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();

//make sure that the id is selected. Else send them back to the products page
if(isset($_GET['id']))
{
    $id = filter($_GET['id']);
}
else {
    //redirect them back
    header("Location: products.php?error=select_prod");
}


include_once 'includes/head.php';
?>
<!-- custom styles can go here  -->
<link rel="stylesheet" href="plugins/slick/slick-theme.css">
<style media="screen">
   .slick-prev,
   .slick-next {
    font-size: 0;
    position: absolute;
    bottom: 50px;
    color: #d5122f;
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
<div class="row">
    <div class="col-md-3">
        <div class="box box-solid">
            <div class="box-header with-border">
                <div class="box-title">
                    Recently Added Items
                </div>
            </div>

            <div class="box-body vticker">
                <ul class="products-list product-list-in-box ">
                    <?php
                    $query = "SELECT * FROM `products` ORDER BY `id` DESC LIMIT 10";
                    $result = mysqli_query($dbc, $query)
                        or die("Error");

                    while ($row = mysqli_fetch_array($result)) {
                        $pic = 'admin/'. $row['photo'];
                        $default_pic  = PRODUCT_IMAGE;

                        ?>
                    <li class="item">
                      <div class="product-img">
                          <img
                          src="<?php if($row['photo'] != '' && file_exists($pic)) { echo $pic; } else { echo $default_pic; } ?>"
                          alt="Product Image" class="product-image">
                      </div>
                      <div class="product-info">
                        <a href="product_details.php?id=<?php echo $row['id']; ?>" class="product-title">
                            <?php echo $row['product_name']; ?>
                          <span class="label label-primary pull-right">
                              $<?php echo $row['price']; ?>
                          </span>
                      </a>
                        <span class="product-description">
                            <?php echo substr($row['description'], 0, 20); ?>
                        </span>
                      </div>
                    </li>
                        <?php
                    }
                     ?>

              </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <div class="p-20 bg-white">
                    <?php
                    //get the id of the product
                    $product = new  Product($id);
                    $product->addView();
                     ?>
                     <h1 class="page-header">
                         <?php echo $product->product_name; ?>
                     </h1>

                     <div class="row">
                         <div class="col-md-6">
                             <?php

                             if($product->photo == '')
                             {
                                 $pic = PRODUCT_IMAGE;
                             }
                             else {
                                 if(!file_exists('admin/' . $product->photo))
                                 {
                                     $pic = PRODUCT_IMAGE;
                                 }
                                 else {
                                     $pic = 'admin/' . $product->photo;
                                 }
                             }
                              ?>
                              <img src="<?php echo $pic; ?>" alt="Product Image" width="100%" height="350px">
                         </div>

                         <div class="col-md-6">
                             <div class="row">
                                 <div class="col-md-12">
                                     <dl class="dl-horizontal">
                                       <dt>Product Name</dt>
                                       <dd><?php echo $product->product_name; ?></dd>
                                       <br>

                                       <dt>Price </dt>
                                       <dd>$<?php echo $product->price; ?></dd>
                                       <br>

                                       <dt>Quantity</dt>
                                       <dd><?php echo $product->quantity . ' ' . $product->unit; ?></dd>
                                       <br>

                                       <dt> Category </dt>
                                       <dd> <?php echo $product->category; ?> </dd>
                                       <br>
                                       <br>
                                     </dl>
                                 </div>
                             </div>

                             <div class="row">
                                 <div class="col-md-6 col-md-offset-3">
                                     <a href="#" class="btn btn-info btn-block shadow btn-flat">
                                         Place Order
                                     </a>

                                     <a href="products.php" class="btn btn-info btn-block shadow btn-flat">
                                         <i class="fa fa-chevron-left"></i>
                                         Product List
                                     </a>
                                 </div>
                             </div>
                         </div>
                     </div>
                </div>
            </div>
        </div>
        <!-- end of row  -->

        <!-- start of row -->
        <div class="row">
            <div class="col-md-12">
                <div class="p-20 bg-white">
                    <?php
                    $description = nl2br($product->description);
                     ?>

                     <h2 class="page-header">Product Description</h2>
                     <div class="row">
                         <div class="col-md-12" style="font-size: 1.2em;">
                             <?php echo $description; ?>
                         </div>
                     </div>
                </div>
            </div>


        </div>
        <!-- end of row  -->

        <br>

    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Related Products</h3>
            </div>

            <div class="box-body">
                <div class="row ">
                    <div class="slider first">
                        <?php
                        //perform the query
                        $cat_id = $product->category_id;
                        $query = " SELECT * FROM `products` WHERE `category` = '$cat_id' ORDER BY `id` DESC LIMIT 12";
                        $result = mysqli_query($dbc, $query)
                            or die("Error. Could not get the products");

                        while ($row = mysqli_fetch_array($result)) {

                            $product = new Product($row['id']);
                            $pic = 'admin/' . $product->photo;
                            $default_pic  = PRODUCT_IMAGE;
                            ?>
                            <div class="col-md-4">
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
            </div>
        </div>
    </div>
</div>

<?php
include_once 'includes/footer.php';
include_once 'includes/scripts.php';
include_once 'includes/toast.php';
?>

<!-- custom scripts here -->
<script type="text/javascript" src="plugins/slick/slick.min.js"></script>
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
           visible: 6,
           mousePause: 0,
           controls: {
               up: '.up',
               down: '.down',
               toggle: '.toggle',
               stopText: 'Stop !!!'
           }
       }).data('easyTicker');

       //initialse slick too
       $('.first').slick({
         slidesToShow: 3,
         slidesToScroll: 1,
         autoplay: true,
         autoplaySpeed: 2000,
       });

    })
</script>

<?php
include_once 'includes/end.php';
?>
