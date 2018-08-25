<?php

include_once 'includes/class.dbc.php';
include_once 'includes/session.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';

//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();


include_once 'includes/head.php';
?>

<?php
include_once 'includes/navigation.php';
?>

<div class="row">
    <div class="col-md-12">
        <h2 class="page-header">Buy Offer Details.</h2>
    </div>
</div>



<div class="row">
    <div class="col-md-7">
        <div class="bg-white p-20 ">
        <!-- //get the id and show the details  -->
        <?php
        if(isset($_GET['offer']))
        {
            $id  = filter($_GET['offer']);
        }
        else {
            $id = '';
        }

        //get the offer detaisl
        $query = "SELECT * FROM `buy_offers` WHERE `id` = '$id' ";
        $result = mysqli_query($dbc, $query)
            or die("Error, could not get the details");

        if(mysqli_num_rows($result) == 0)
        {
            ?>
        <div class="text-center text-info text-bold">
            Buy Offer Details could not be found
        </div>
            <?php
        }
        else {
            while($row = mysqli_fetch_array($result))
            {
                ?>
            <!-- get the order details  -->
            <div class="row">
                <div class="form-group">
                    <label for="" class="control-lable col-md-5 right-align" >Product Name :</label>
                    <div class="col-md-7">
                        <?php echo $row['product_name']; ?>
                    </div>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="form-group">
                    <label for="" class="control-lable col-md-5 right-align" >Quantity :</label>
                    <div class="col-md-7">
                        <?php echo $row['quantity']; ?>
                    </div>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="form-group">
                    <label for="" class="control-lable col-md-5 right-align" >Unit :</label>
                    <div class="col-md-7">
                        <?php echo $row['packaging']; ?>
                    </div>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="form-group">
                    <label for="" class="control-lable col-md-5 right-align" >Price :</label>
                    <div class="col-md-7">
                        <?php echo $row['price']; ?>
                    </div>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="form-group">
                    <label for="" class="control-lable col-md-5 right-align" >Contact Name :</label>
                    <div class="col-md-7">
                        <?php echo $row['contact_name']; ?>
                    </div>
                </div>
            </div>
                <?php
            }
        }

         ?>




        </div>
    </div>

    <!-- //next column -->
    <div class="col-md-5">
        <div class="bg-white">
            <table class="table table-type-1">
                <tr class="mandis">
                    <th colspan="3">
                        <i class="fa fa-list"></i>
                        LATEST BUY OFFERS
                    </th>
                </tr>

                <?php
                $query = "SELECT * FROM `buy_offers` ORDER BY `id` DESC LIMIT 7";
                $result = mysqli_query($dbc, $query)
                    or die("Error");

                while($row = mysqli_fetch_array($result))
                {
                    ?>
                <tr>
                    <td>
                        <a href="buy_offer_details.php?offer=<?php echo $row['id']; ?>">
                            <?php echo $row['product_name']; ?>
                             For Sale
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

<?php
include_once 'includes/footer.php';
include_once 'includes/scripts.php';
include_once 'includes/toast.php';
?>

<!-- custom scripts here -->

<?php
include_once 'includes/end.php';
?>
