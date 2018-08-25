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
<style media="screen">
    /*set a border on the images to prevent shifting*/
    #gallery_01 img{border:2px solid white;}

    /*Change the colour*/
    .active img{border:2px solid #333 !important;
    }
</style>


<?php
include_once 'includes/navigation.php';
?>

<div class="row">
    <div class="col-md-12">
        <h2 class="page-header">LOI Details</h2>
        <div class="bg-white p-20">
            <?php

            //get the id of the loi and get its details
            if(isset($_GET['offer']))
            {
                $id  = filter($_GET['offer']);
            }
            else {
                $id = '';
            }

            $query = "SELECT * FROM `loi` WHERE `id` = '$id' ";
            $result = $dbc->query($query);

            while($row = $result->fetch_assoc())
            {
                ?>
            <div class="row">
                <h3 class="page-header">
                    <?php echo $row['title']; ?>
                </h3>
                <div class=" col-xs-12 col-md-6">
                    <div class="p-20 border-gray">
                        <img src="admin/<?php echo $row['image']; ?>" alt="LOI Image Document" class="loi-image" id="img_01">
                        <!-- <img id="img_01" src="small/image1.png" data-zoom-image="large/image1.jpg"/> -->

                        <div id="gallery_01">

                            <!-- default image  -->
                            <a href="#" data-image="admin/<?php echo $row['image']; ?>" data-zoom-image="admin/<?php echo $row['image']; ?>">
                              <img id="img_01" src="admin/<?php echo $row['image']; ?>" class="thumbnail" />
                            </a>

                            <?php
                            //get all the other loi images and show them
                            $query = "SELECT * FROM `loi_files` WHERE (`type` = 'jpg' OR `type` = 'gif' OR `type` = 'png')  AND (`loi_id` = '$id')";
                            $res = $dbc->query($query);

                            //now sho them
                            while($r = $res->fetch_assoc())
                            {
                                $location = 'admin/' . $r['location'];

                                ?>
                            <a href="#" data-image="<?php echo $location; ?>" data-zoom-image="<?php echo $location; ?>">
                              <img id="img_01" src="<?php echo $location;  ?>" class="thumbnail" />
                            </a>
                                <?php
                            }

                            ?>

                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <?php
                    echo $row['description'];
                     ?>
                </div>
            </div>
                <?php
            }

             ?>

             <br><br>
             <div class="row">
                 <div class="col-md-12">
                     <h3 class="page-header">Other LOI Documents</h3>

                     <div class="row">
                         <?php
                         $query = "SELECT * FROM `loi_files` WHERE `loi_id` = '$id' AND (`type` = 'jpg' OR `type` = 'gif' OR `type` = 'png') ";
                         $result = $dbc->query($query);

                         while($row = $result->fetch_assoc())
                         {
                             ?>
                        <div class="col-md-3">
                            <a href="admin/<?php echo $row['location']; ?>" target="_blank">
                                <?php echo $row['file_name']; ?>
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

<br><br>
<div class="row">
    <div class="col-md-12">
        <?php
        $status = Status::AVAILABLE;

        //generate the previous
        $query = "SELECT `id` FROM `loi` WHERE `id` < $id AND `status` = '$status' ORDER BY `id` DESC LIMIT 1";
        $result = mysqli_query($dbc, $query)
            or die("Error.");

        if(mysqli_num_rows($result) == 0)
        {

        }
        else {

            list($prev) = mysqli_fetch_array($result);
            ?>
            <div class="pull-left">
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?offer=<?php echo $prev; ?>" class="btn btn-info">
                    <i class="fa fa-chevron-left"></i>
                    Previous  LOI
                </a>
            </div>
            <?php
        }

         ?>

        <?php
        //generate the previous
        $query = "SELECT `id` FROM `loi` WHERE `id` > $id AND `status` = '$status' ORDER BY `id` DESC LIMIT 1";
        $result = mysqli_query($dbc, $query)
            or die("Error.");

        if(mysqli_num_rows($result) == 0)
        {

        }
        else {

            list($next) = mysqli_fetch_array($result);
            ?>
            <div class="pull-right">
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?offer=<?php echo $next; ?>" class="btn btn-info">

                    Next LOI
                    <i class="fa fa-chevron-right"></i>
                </a>
            </div>
            <?php
        }

         ?>
    </div>
</div>

<?php
include_once 'includes/footer.php';
include_once 'includes/scripts.php';
include_once 'includes/toast.php';
?>

<!-- custom scripts here -->
<script type="text/javascript" src="js/jquery.elevatezoom.js"></script>
<script>
   //  $('#zoom_01').elevateZoom({
	// 	cursor: "crosshair",
	// 	zoomWindowFadeIn: 500,
	// 	zoomWindowFadeOut: 750,
	// 	tint:true,
	// 	tintColour:'#F90',
	// 	tintOpacity:0.5
   // });

   $("#img_01").elevateZoom({
       gallery: "gallery_01",
       cursor: "pointer",
       galleryActiveClass: "active",
       imageCrossFade: true,
       loadingIcon: "loading.gif"
   })
</script>

<?php
include_once 'includes/end.php';
?>
