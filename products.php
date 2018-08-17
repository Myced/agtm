<?php

include_once 'includes/class.dbc.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';

//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();


include_once 'includes/head.php';
?>
<!-- custom styles can go here  -->

<?php
include_once 'includes/navigation.php';
?>

<div class="row">
    <div class="col-md-12">
        <h2 class="page-header">Products</h2>
    </div>
</div>

<br>
<div class="row">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Product Categories</h3>
            </div>

            <div class="box-body">
                <div class="list-group">
                    <li class="list-group-item <?php if(!isset($_GET['category'])) { echo 'active'; } ?>">
                        <a href="products.php" class="text-bold  <?php if(!isset($_GET['category'])) { echo 'text-white'; } ?>">
                            All Categories
                        </a>
                    </li>
                    <?php
                    //get the product category
                    if(isset($_GET['category']))
                    {
                        $category = filter($_GET['category']);
                    }
                    else {
                        $category  = '-100'; /// this will make the query to return nothing
                    }

                    $query = "SELECT * FROM `categories`";
                    $result = mysqli_query($dbc, $query)
                        or die("Error");

                    while ($row = mysqli_fetch_array($result)) {
                        ?>
                    <li class="list-group-item <?php if($category == $row['id']) { echo 'active'; } ?>">
                        <a href="products.php?category=<?php echo $row['id']; ?>" class="text-bold <?php if($category == $row['id']) { echo 'text-white'; } ?>">
                            <?php echo $row['category_name']; ?>
                        </a>
                    </li>
                        <?php
                    }
                     ?>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-9">
        <div class="box box-primary with-border">
            <div class="box-header">
                <h3 class="box-title">Prouct List</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <?php
                    //if the category is set then get items only of that category
                    if($category == '-100')
                    {
                        $query = "SELECT * FROM `products` "; //don't specify the category since its not set.
                        //see the category list above on how -100 came about
                    }
                    else {
                        $query = "SELECT * FROM `products` WHERE `category` = '$category' ";
                        //filter the products by the category given
                    }

                    //now do the query
                    $result = mysqli_query($dbc, $query)
                        or die("Error. Cannot get the products" . mysqli_error($dbc));

                    //now go through the results and show them
                    while($row = mysqli_fetch_array($result))
                    {

                        //get the picture and format it
                        if($row['photo'] == '')
                        {
                            //not photo was uploaded. so picture is the defualt
                            $pic = PRODUCT_IMAGE;

                        }
                        else {
                            $pic = 'admin/' . $row['photo'];
                        }
                        ?>
                        <div class="col-md-4 ">
                            <div class="m-10 border">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <img src="<?php echo $pic; ?>" alt="Picture" class="product-page-image">
                                    </div>
                                </div>

                                <h4 class="box-title text-center text-bold">
                                    <?php echo $row['product_name']; ?>
                                </h4>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="p-10">
                                            <div class="pull-left text-bold">
                                                Price: <span class="price">$<?php echo $row['price']; ?></span>
                                            </div>

                                            <div class="pull-right text-bold">
                                                Quantity: <span class="price"><?php echo $row['quantity']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php
                    }
                     ?>
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

<?php
include_once 'includes/end.php';
?>
