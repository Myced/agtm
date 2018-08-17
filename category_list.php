<?php
//
//database and other function initialisations
include_once '../classes/class.dbc.php';
include_once '../includes/functions.php';
include_once '../includes/day.php';

//initialise the database connection
$db = new dbc();
$dbc = $db->get_instance();

//include other custom plugins needed
$errors = [];

//page application logic here


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
                All Categories
            </h1>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>S/N </th>
                                <th> Category Name </th>
                                <th> Status </th>
                                <th> Action </th>
                            </tr>

                            <?php
                            $count = 1;

                            $query = "SELECT * FROM `categories`";
                            $result = mysqli_query($dbc, $query);

                            while($row = mysqli_fetch_array($result))
                            {
                                ?>
                            <tr>
                                <td> <?php echo $count++; ?> </td>
                                <td> <?php echo $row['category_name']; ?> </td>
                                <td>
                                    <?php
                                    if($row['status'] == '1')
                                    {
                                        echo 'Active';
                                    }
                                    else {
                                        echo 'InActive';
                                    }
                                    ?>
                                </td>

                                <td>
                                    <a href="#" class="btn btn-primary btn-xs"
                                        title="Edit Category">
                                        <i class="fa fa-pencil"></i>
                                        Edit
                                    </a>

                                    <a href="#" class="btn btn-danger btn-xs"
                                        title="Delete Category">
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
