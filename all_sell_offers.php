
<?php

include_once 'includes/class.dbc.php';
include_once 'includes/session.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';
include_once 'admin/classes/class.Status.php';

$status = Status::ACCEPTED;

//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();


include_once 'includes/head.php';
?>
<!-- custom styles can go here  -->
<link rel="stylesheet" href="css/lib/dataTables.bootstrap.min.css">

<?php
include_once 'includes/navigation.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Sell Offers</h3>
            </div>
            <!-- /.box-header -->
            <br><br>
            <div class="box-body">
              <div class="table-responsive">
                  <table id="example1" class="table table-striped table-hover">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Product Name</th>
                      <th>Quantity</th>
                      <th>Unit </th>
                      <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    //initialise the count variable
                    $count = 1;

                    //get the data from the database with a query
                    $query = "SELECT * FROM `sell_offers` WHERE `status` = '$status' ";
                    $result = mysqli_query($dbc, $query)
                        or die("Error. Cannot get buy offers");

                    if(mysqli_num_rows($result) == 0)
                    {
                        //
                        ?>
                    <tr>
                        <td colspan="6">
                            <strong class="text-primary">No Buy Offers</strong>
                        </td>
                    </tr>
                        <?php
                    }
                    else {
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td>
                                <a href="sell_offer_details.php?offer=<?php echo $row['id']; ?>">
                                    <?php echo $row['product_name']; ?>
                                </a>
                            </td>

                            <td>
                                <?php echo $row['quantity']; ?>
                            </td>

                            <td>
                                <?php echo $row['packaging']; ?>
                            </td>

                            <td>
                                $<?php echo $row['price']; ?>
                            </td>
                        </tr>
                            <?php
                        }
                    }


                    ?>
                    </tfoot>
                  </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>
</div>

<?php
include_once 'includes/footer.php';
include_once 'includes/scripts.php';
include_once 'includes/toast.php';
?>
<!-- custom scripts here -->
<script type="text/javascript" src="js/lib/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/lib/dataTables.bootstrap.min.js"></script>
<script>


  $(function () {
    $('#example1').DataTable()

  })
</script>

<?php
include_once 'includes/end.php';
?>
