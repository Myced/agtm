<?php

include_once 'includes/class.dbc.php';
include_once 'includes/session.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';
include_once 'admin/classes/class.Status.php';

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
        <h2 class="page-header">My Profile</h2>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3">


                <div class="box box-primary ">
                   <div class="box-body box-profile">
                    <div class="row text-center">
                         <img class="profile-user-img  img-circle" src="<?php echo $avatar; ?>" alt="User profile picture">
                    </div>

                     <h3 class="profile-username text-center"><?php echo $user->full_name; ?></h3>

                     <p class="text-muted text-center"></p>

                     <ul class="list-group list-group-unbordered">
                       <!-- <li class="list-group-item">
                         <b># SCOs</b> <a class="pull-right"> <?php echo $user->getSCOCount(); ?> </a>
                       </li> -->
                       <li class="list-group-item">
                         <b># Buy Offerss</b> <a class="pull-right"> <?php echo $user->getBuyOfferCount(); ?> </a>
                       </li>
                       <li class="list-group-item">
                         <b># Sell Offers</b> <a class="pull-right"><?php echo $user->getSellOfferCount(); ?></a>
                       </li>

                       <li class="list-group-item">
                         <b># Product Orders</b> <a class="pull-right"><?php echo $user->getOrdersCount(); ?></a>
                       </li>
                     </ul>

                     <a href="edit_profile.php" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
                   </div>
                   <!-- /.box-body -->
               </div>
             <!-- /.box -->

             <!-- About Me Box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">About Me</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <strong><i class="fa fa-envelope-o  margin-r-5"></i> Email </strong>

                  <p class="text-muted">
                      <?php echo $user->email; ?>
                  </p>

                  <hr>

                  <strong><i class="fa fa-map-marker margin-r-5"></i> Nationality</strong>

                  <p class="text-muted"><?php echo $user->nationality; ?></p>

                  <hr>

                  <strong><i class="fa fa-phone margin-r-5"></i> Telephone</strong>

                  <p class="text-muted">
                      <?php echo $user->tel; ?>
                  </p>

                  <hr>

                  <strong><i class="fa fa-file-text-o margin-r-5"></i> About Me</strong>

                  <p class="text-muted">
                      <?php echo $user->about_me; ?>
                  </p>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>

            <!-- next column -->
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">My Sell Offers</h3>
                    </div>

                    <div class="box-body">
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>Date Added</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Packaging</th>
                                    <th>Status</th>
                                </tr>
                                <?php
                                $offers = $user->getSellOffers();

                                if(mysqli_num_rows($offers) == 0)
                                {
                                    ?>
                                <tr>
                                    <td colspan="10" class="text-center">
                                         <strong class="text-primary">You don't have any sell offers</strong>
                                    </td>
                                </tr>
                                    <?php
                                }
                                else {
                                    $count = 1;

                                    while($row = $offers->fetch_assoc())
                                    {
                                        ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td>
                                            <?php echo $row['date']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['product_name']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['quantity']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['packaging']; ?>
                                        </td>

                                        <td>
                                            <?php
                                            $status =  $row['status'];

                                            if($status == Status::PENDING)
                                            {
                                                ?>
                                                <div class="badge bg-yellow">
                                                    PENDING
                                                </div>
                                                <?php
                                            }
                                            elseif($status == Status::REJECTED)
                                            {
                                                ?>
                                                <div class="badge bg-red">
                                                    REJECTED
                                                </div>
                                                <?php
                                            }
                                            elseif($status == Status::ACCEPTED)
                                            {
                                                ?>
                                                <div class="badge bg-green">
                                                    APPROVED
                                                </div>
                                                <?php
                                            }
                                            else {
                                                ?>
                                                <div class="badge bg-blue">
                                                    PENDING
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                        <?php
                                    }
                                }
                                 ?>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">My Buy Offers</h3>
                    </div>

                    <div class="box-body">
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>Date Added</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Packaging</th>
                                    <th>Status</th>
                                </tr>

                                <?php
                                $offers = $user->getBuyOffers();

                                if(mysqli_num_rows($offers) == 0)
                                {
                                    ?>
                                <tr>
                                    <td colspan="10" class="text-center">
                                         <strong class="text-primary">You don't have any buy offers</strong>
                                    </td>
                                </tr>
                                    <?php
                                }
                                else {
                                    $count = 1;

                                    while($row = $offers->fetch_assoc())
                                    {
                                        ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td>
                                            <?php echo $row['date']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['product_name']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['quantity']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['packaging']; ?>
                                        </td>

                                        <td>
                                            <?php
                                            $status =  $row['status'];

                                            if($status == Status::PENDING)
                                            {
                                                ?>
                                                <div class="badge bg-yellow">
                                                    PENDING
                                                </div>
                                                <?php
                                            }
                                            elseif($status == Status::REJECTED)
                                            {
                                                ?>
                                                <div class="badge bg-red">
                                                    REJECTED
                                                </div>
                                                <?php
                                            }
                                            elseif($status == Status::ACCEPTED)
                                            {
                                                ?>
                                                <div class="badge bg-green">
                                                    APPROVED
                                                </div>
                                                <?php
                                            }
                                            else {
                                                ?>
                                                <div class="badge bg-blue">
                                                    PENDING
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                        <?php
                                    }
                                }
                                 ?>

                            </table>
                        </div>

                    </div>
                </div>

                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">My Product Orders</h3>
                    </div>

                    <div class="box-body">
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>Date Added</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Destination</th>
                                </tr>

                                <?php
                                $offers = $user->getOrders();

                                if(mysqli_num_rows($offers) == 0)
                                {
                                    ?>
                                <tr>
                                    <td colspan="10" class="text-center">
                                         <strong class="text-primary">You don't have any orders</strong>
                                    </td>
                                </tr>
                                    <?php
                                }
                                else {
                                    $count = 1;

                                    while($row = $offers->fetch_assoc())
                                    {
                                        ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td>
                                            <?php echo $row['date']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['product_name']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['quantity']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['name']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['email']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['destination']; ?>
                                        </td>
                                    </tr>
                                        <?php
                                    }
                                }
                                 ?>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end of column -->
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
