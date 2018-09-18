<?php

include_once 'includes/class.dbc.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';
include_once 'admin/classes/class.Status.php';

//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();

$status = Status::AVAILABLE;


include_once 'includes/head.php';
?>
<!-- custom styles can go here  -->

<?php
include_once 'includes/navigation.php';
?>
<div class="row">
    <div class="col-md-12">
        <h2 class="page-header">Approved Trades</h2>

        <?php
        //prepare the active link
        if(isset($_GET['sco']))
        {
            $loi = "";
            $sco = "active";
        }
        else {
            $loi = "active";
            $sco = "";
        }
         ?>

        <div class="row">
          <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="<?php echo $loi; ?>">
                    <a href="#sco" data-toggle="tab"> <strong>Available SCO</strong> </a>
                </li>
                <li class="<?php echo $sco ?>">
                    <a href="#loi" data-toggle="tab"> <strong>Available LOI</strong> </a>
                </li>
                <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
              </ul>
              <div class="tab-content">

                <!-- /.tab-pane -->
                <div class="tab-pane" id="sco">
                      <h3 class="page-header">Available SCO </h3>

                      <div class="row">
                          <div class="col-md-10">
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
                <!-- /.tab-pane -->

                <div class="tab-pane active" id="loi">
                    <h3 class="page-header">Available LOI </h3>

                    <div class="row">
                        <div class="col-md-10">

                            <ul class="timeline" >
                                <li class="">
                                    <?php

                                    //get all the offers
                                    $query = "SELECT * FROM `loi` WHERE `status` = '$status' ";
                                    $result = mysqli_query($dbc, $query)
                                        or die("Error.");
                                    while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <div class="timeline-item" style="border: 1px solid #aaa;">
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
