<?php
//
//database and other function initialisations
include_once 'includes/session.php';
include_once '../classes/class.dbc.php';
include_once '../includes/functions.php';
include_once '../includes/day.php';
include_once 'classes/class.Status.php';
include_once 'includes/admin.php';
include_once '../classes/class.AccountStatus.php';
include_once '../classes/class.Level.php';

//initialise the database connection
$db = new dbc();
$dbc = $db->get_instance();

//include other custom plugins needed
$errors = [];

//page application logic here

function get_position($position)
{
    //get the positon and return the type
    $type = '';

    if($position == Level::ADMIN)
        $type = "Admin";
    elseif($position == Level::MODERATOR)
        $type = "Moderator";
    elseif($position == Level::USER)
        $type = "Normal User";
    else {
      $type = "Unknown";
    }

    return $type;
}

if(isset($_GET['action']))
{
    //get the id of the item to perform on
    $id = filter($_GET['id']);

    //now perform the action
    $action = filter($_GET['action']);

    if($action == 'del')
    {
        //dele the category
        $query = "DELETE FROM `users` WHERE `user_id` = '$id'";
        $result = mysqli_query($dbc, $query);

        $success = "USER DELETED";
    }
    elseif($action == 'block')
    {
        $sta = AccountStatus::BLOCKED;
        $query = "UPDATE `users` SET `account_status` = '$sta' WHERE `user_id` = '$id'";
        $result = mysqli_query($dbc, $query);

        $success = "User has been banned";
    }
    elseif($action == 'unblock')
    {
        $sta = AccountStatus::ACTIVE;
        $query = "UPDATE `users` SET `account_status` = '$sta' WHERE `user_id` = '$id'";
        $result = mysqli_query($dbc, $query);

        $success = "User has been Unbanned";
    }
    else {
      $warning = "Unkown Action";
    }

}

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
$query = "SELECT * from `users` WHERE `level` >= '5' ";
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
$query = "SELECT * FROM `users` WHERE `level` >= '5' ORDER BY `id` DESC LIMIT $start, $end";
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
            <h2 class="page-header">
                Manage Administrative Users.
            </h2>

            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-stripped table-info table-hover table-bordered">
                            <tr class="bg-success">
                                <th> S/N </th>
                                <th> Avatar</th>
                                <th> User ID </th>
                                <th> Username</th>
                                <th> Level </th>
                                <th> Full Name </th>
                                <th> Contact </th>
                                <th> Status </th>
                                <th> Action </th>
                            </tr>

                              <?php
                              $count = 1;
                              //fetch all the restaurants.
                              $result = mysqli_query($dbc, $query);

                              while($row = mysqli_fetch_array($result))
                              {
                                $status = $row['account_status'];
                              ?>
                                <tr>
                                    <td> <?php echo $count++; ?> </td>

                                    <td>
                                        <?php
                                            if(empty($row['avatar']))
                                            {
                                              echo 'No Image';
                                            }
                                            else {
                                              ?>
                                              <img src="<?php echo $row['avatar']; ?>" width='60' height='60' class="img-circle">
                                              <?php
                                            }
                                         ?>
                                    </td>
                                    <td>
                                        <?php echo $row['user_id']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['username']; ?>
                                    </td>

                                    <td>
                                        <?php
                                          echo get_position($row['level']);
                                         ?>
                                    </td>

                                    <td>
                                        <?php echo $row['full_name']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['tel']; ?>
                                    </td>

                                    <td>
                                      <?php
                                      if($status == AccountStatus::BLOCKED)
                                      {
                                        ?>
                                          <span class="badge badge-danger">
                                              Banned
                                          </span>
                                        <?php

                                          }
                                          elseif ($status == AccountStatus::SUSPENDED) {
                                              ?>
                                                <span class="badge badge-danger">
                                                    Suspended
                                                </span>
                                              <?php
                                          }
                                          else
                                          {
                                            ?>
                                            <span class="badge badge-success">
                                                Active
                                            </span>
                                              <?php
                                          }
                                          ?>
                                    </td>

                                    <td>
                                        <a href="edit_user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-primary btn-xs"
                                          title="Edit this User">
                                            <i class="fa fa-pencil"></i>
                                        </a>

                                        <?php
                                        if($status == AccountStatus::BLOCKED || $status == AccountStatus::SUSPENDED)
                                        {
                                            ?>
                                            <a href="admin_users.php?id=<?php echo $row['user_id']; ?>&action=unblock" class="btn btn-success btn-xs"
                                                title="UnBan User">
                                                <i class="fa fa-check"></i>
                                            </a>
                                            <?php
                                        }
                                        else {
                                          ?>
                                          <a href="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $row['user_id']; ?>&action=block"
                                             class="btn btn-warning btn-xs"
                                              title="Ban This User">
                                              <i class="fa fa-ban"></i>
                                          </a>
                                          <?php
                                        }
                                         ?>
                                         <a href="reset_password.php?id=<?php echo $row['user_id']; ?>&action=reset" class="btn btn-info btn-xs"
                                             title="Reset Password">
                                             <i class="fa fa-key"></i>
                                         </a>
                                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $row['user_id']; ?>&action=del" class="btn btn-danger btn-xs"
                                            title="Delete this User">
                                            <i class="fa fa-trash"></i>
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
