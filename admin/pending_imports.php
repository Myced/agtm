<?php
//
//database and other function initialisations
include_once '../classes/class.dbc.php';
include_once '../includes/functions.php';
include_once '../includes/day.php';
include_once 'classes/class.Status.php';
include_once 'classes/class.User.php';

//initialise the database connection
$db = new dbc();
$dbc = $db->get_instance();

//include other custom plugins needed
$errors = [];

//page application logic here
//the page status goes here
$status  = Status::PENDING;

//pageinate
//query initialisation
$results_per_page = RESULTS_PER_PAGE; //number of results to show on a sigle page

//data manipulation
if(isset($_GET['page']))
{
    //get the page number
    $page_number = filter($_GET['page']);

    //Variable to maintain countring
    $inter  = $page_number - 1; //reduces the page numer in order to count
    $count = (int) ($inter * $results_per_page) + 1;
}
else
{
    $page_number = 1;

    //Variable to do countring
    $count = 1;
}

//START OF search results
if($page_number < 2)
{
    $start = 0;
}
 else {
     $start = (($page_number - 1) * ($results_per_page));
}

//total data in the database;
$query = "SELECT * from `importers` WHERE `status` = '$status' ";
$result  = mysqli_query($dbc, $query);

$total = mysqli_num_rows($result);

if($results_per_page >= 1)
{

   $number_of_pages = ceil($total/$results_per_page);

   if($number_of_pages < 1)
   {
       $page_count = 1;
   }
   else
   {
       $page_count = $number_of_pages;
   }

}
else
{
    $error = "Results Per page Cannot be zero or Less";
    $page_count = 1;
}
//end
$end = $results_per_page;

//now if page number is greater that
if($page_number > $page_count)
{
    $error = "That Page does not Exist";
}

//do the query here
$query = "SELECT * FROM `importers` WHERE `status` = '$status' ORDER BY `id` DESC LIMIT $start, $end";
$result = mysqli_query($dbc, $query)
        or die("Error");

include_once 'includes/head.php';
include_once 'includes/stylesheets.php';
?>
<!--//custom style here-->

<?php
include_once 'includes/middle.php';
include_once 'includes/left_sidebar.php';
include_once 'includes/start.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <h1 class="page-header">
                Pending Import Requests
            </h1>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Destination</th>
                                <th>Contact Name</th>
                                <th>Status</th>
                                <th>User</th>
                                <th>Action</th>
                            </tr>

                            <?php

                            while($row = mysqli_fetch_array($result))
                            {
                                //list them all out
                                ?>
                            <tr>
                                <td> <?php echo $count++; ?> </td>
                                <td> <?php echo $row['date']; ?> </td>
                                <td> <?php echo $row['product_name']; ?> </td>
                                <td> <?php echo $row['quantity']; ?> </td>
                                <td> <?php echo $row['destination']; ?> </td>
                                <td> <?php echo $row['contact_name']; ?> </td>
                                <td class="text-center">
                                    <strong class="text-warning"> <i class="fa fa-clock-o"></i> </strong>
                                </td>
                                <td>
                                    <?php
                                        $user = new User($row['user_id']);
                                        echo $user->username;
                                    ?>
                                </td>

                                <td>
                                    <a href="import_details.php?id=<?php echo $row['id']; ?>"
                                        class="btn btn-info btn-rounded waves-light waves-effect" >
                                        Details
                                    </a>


                                </td>
                            </tr>
                                <?php
                            }
                             ?>
                        </table>
                    </div>
                </div>

                <!-- //page number -->
                <div class="col-md-12">
                    <div class="pull-right">
                        Page <?php echo $page_number; ?>/<?php echo $page_count; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <?php

                            //the scrpt name
                            $script = basename(__FILE__);

                            if($page_count > 1)
                            {
                                ?>
                            <ul class="pagination">
                                <?php
                                if($page_number != 1)
                                {
                                    ?>
                                <li class="previous">
                                    <a href="<?php echo $script; ?>?page=<?php echo $page_number - 1; ?>" >Prev</a>
                                </li>
                                    <?php
                                }
                                ?>
                                <?php
                                for($i = 1; $i <= $page_count; $i++)
                                {
                                    ?>
                                <li class="<?php  $i == $page_number ? print 'active' : ''; ?>">
                                    <a href="<?php echo $script; ?>?page=<?php echo $i; ?>"  >
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                                    <?php
                                }
                                ?>

                                <?php
                                //If the pages and page number are not the same then show the next button
                                if($page_number != $page_count)
                                {
                                    ?>
                                <li class="next">
                                    <a href="<?php echo $script; ?>?page=<?php echo $page_number + 1; ?>"> Next</a>
                                </li>
                                    <?php
                                }
                                ?>

                            </ul>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once 'includes/footer.php';
include_once 'includes/scripts.php';
include_once 'includes/notification.php';
?>

<!--//any custom javascript here-->

<?php
include_once 'includes/end.php';
?>
