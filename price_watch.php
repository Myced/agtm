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
<!-- custom styles can go here  -->

<?php
include_once 'includes/navigation.php';
?>

<div class="row">
    <div class="col-md-12">
        <h2 class="page-header">Price Watch</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="bg-white">
            <div class="p-20">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>S/N</th>
                            <th>Comodity Name</th>
                            <th>Arrivals</th>
                            <th>Price</th>
                        </tr>
                        <?php

                        //set the count variable to 1
                        $count = 1;

                        //get the commodities from the database
                        $query = "SELECT * FROM `spot_price`";
                        $result = mysqli_query($dbc, $query)
                            or die("Could not get the commodities");
                        while($row = mysqli_fetch_assoc($result))
                        {
                            ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $row['item']; ?></td>
                            <td><?php echo $row['quantity'] . ' ' . $row['unit']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                        </tr>
                            <?php
                        }
                         ?>
                    </table>
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
