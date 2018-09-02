<?php
//
//database and other function initialisations
include_once 'includes/session.php';
include_once '../classes/class.Level.php';
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
if(isset($_GET['id']))
{
    //get the id to delete
    $id = filter($_GET['id']);

    $query  = "DELETE FROM `replies` WHERE `id` = '$id' ";
    $result =  $dbc->query($query);

    $success = "Reply Deleted";
}

$flagged = TRUE;

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
$query = "SELECT * from `replies` ";
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
$query = "SELECT * FROM `replies`   ORDER BY `id` DESC LIMIT $start, $end";
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
                All Forum Replies
            </h1>

            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Post Title</th>
                                <th>Reply</th>
                                <th>Flagged</th>
                                <th>Replied By</th>
                                <th>Action</th>
                            </tr>

                            <?php

                            while($row = mysqli_fetch_array($result))
                            {
                                //list them all out
                                $thread_id = $row['thread_id'];
                                $query = "SELECT `title` from `threads` WHERE `id` = '$thread_id' ";
                                $res = mysqli_query($dbc, $query);

                                list($title) = mysqli_fetch_array($res);

                                if(empty($title))
                                {
                                    $title = '<strong> Post Deleted </strong>';
                                }

                                ?>
                            <tr>
                                <td> <?php echo $count++; ?> </td>
                                <td> <?php echo $row['day'] . '/' . $row['month'] . '/' . $row['year']; ?> </td>
                                <td> <?php echo $title; ?> </td>
                                <td> <?php echo $row['reply']; ?> </td>
                                <td>
                                    <?php
                                        $flagged = $row['flagged'];

                                        if($flagged == TRUE)
                                        {
                                            ?>
                                        <div class="badge badge-danger">
                                            <i class="fa fa-times"></i>
                                            Flagged
                                        </div>
                                            <?php
                                        }
                                        else {
                                            ?>
                                        <div class="badge badge-success">
                                            <i class="fa fa-check"></i>
                                            Ok
                                        </div>
                                            <?php
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        $user = new User($row['user_id']);
                                        echo $user->username;
                                    ?>
                                </td>

                                <td>
                                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $row['id']; ?>
                                        <?php if(isset($_GET['page'])) {echo '&page=' . $_GET['page']; } ?>"
                                        class="btn btn-danger waves-light waves-effect" >
                                        <i class="fa fa-trash"></i>
                                        Delete
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