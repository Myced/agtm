<?php

include_once 'includes/class.dbc.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';
include_once 'admin/classes/class.Status.php';

//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();

$status = Status::ACCEPTED;


include_once 'includes/head.php';
?>
<!-- custom styles can go here  -->

<?php
include_once 'includes/navigation.php';
?>
<div class="row">
    <div class="col-md-12">
        <h2 class="page-header">Approved Trades</h2>

        <div class="row">
          <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#loi" data-toggle="tab">Available LOI </a>
                </li>
                <li><a href="#sco" data-toggle="tab">Available SCO</a></li>
                <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="loi">
                    <h3 class="page-header">Available LOI (Buy Offers)</h3>

                    <div class="row">
                        <div class="col-md-5">

                            <ul class="timeline">
                                <li class="">
                                    <?php

                                    //get all the offers
                                    $query = "SELECT * FROM `buy_offers` WHERE `status` = '$status' ";
                                    $result = mysqli_query($dbc, $query)
                                        or die("Error.");
                                    while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <div class="timeline-item">
                                          <span class="time"><i class="fa fa-clock-o"></i> <?php echo date_from_timestamp($row['time_added']); ?> </span>

                                          <h3 class="timeline-header"><a href="buy_offer_details.php?offer=<?php echo $row['id']; ?>">
                                              <?php echo $row['product_name']; ?> Nedded
                                              </a>
                                          </h3>

                                          <div class="timeline-body">
                                            <?php
                                            echo $row['description'];
                                             ?>
                                          </div>
                                          <div class="timeline-footer">
                                            <a class="btn btn-primary btn-xs" href="buy_offer_details.php?offer=<?php echo $row['id']; ?>">Read more</a>
                                          </div>
                                        </div>

                                        <br><br>
                                        <?php
                                    }
                                     ?>
                                </li>
                            </ul>


                        </div>

                        <div class="col-md-6">
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
                                             Needed
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


                <!-- /.tab-pane -->
                <div class="tab-pane" id="sco">
                      <h3 class="page-header">Available SCO (Sell Offer)</h3>

                      <div class="row">
                          <div class="col-md-6">
                              <ul class="timeline">
                                  <li class="">
                                      <?php

                                      //get all the offers
                                      $query = "SELECT * FROM `sell_offers` WHERE `status` = '$status' ";
                                      $result = mysqli_query($dbc, $query)
                                          or die("Error.");
                                      while ($row = mysqli_fetch_array($result)) {
                                          ?>
                                          <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> <?php echo date_from_timestamp($row['time_added']); ?> </span>

                                            <h3 class="timeline-header"><a href="sell_offer_details.php?offer=<?php echo $row['id']; ?>">
                                                <?php echo $row['product_name']; ?> For Sale
                                                </a>
                                            </h3>

                                            <div class="timeline-body">
                                              <?php
                                              echo $row['description'];
                                               ?>
                                            </div>
                                            <div class="timeline-footer">
                                              <a class="btn btn-primary btn-xs" href="sell_offer_details.php?offer=<?php echo $row['id']; ?>">Read more</a>
                                            </div>
                                          </div>

                                          <br><br>
                                          <?php
                                      }
                                       ?>
                                  </li>
                              </ul>
                          </div>

                          <div class="col-md-6">
                              <table class="table table-type-1">
                                  <tr class="mandis">
                                      <th colspan="3">
                                          <i class="fa fa-list"></i>
                                          LATEST SELL OFFERS
                                      </th>
                                  </tr>

                                  <?php
                                  $query = "SELECT * FROM `sell_offers` ORDER BY `id` DESC LIMIT 7";
                                  $result = mysqli_query($dbc, $query)
                                      or die("Error");

                                  while($row = mysqli_fetch_array($result))
                                  {
                                      ?>
                                  <tr>
                                      <td>
                                          <a href="sell_offer_details.php?offer=<?php echo $row['id']; ?>">
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
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
          </div>
          <!-- /.col -->


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
