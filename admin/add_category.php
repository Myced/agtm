<?php
//database and other function initialisations
include_once '../classes/class.dbc.php';
include_once '../includes/functions.php';
include_once '../includes/day.php';

//initialise the database connection
$db = new dbc();
$dbc = $db->get_instance();

//include other custom plugins needed
$errors = [];

//program logic goes here
if(isset($_POST['save']))
{
    $category = filter($_POST['category']);

    if(empty($category))
    {
        $errors = "Sorry, Category cannot be empty";
    }

    //check that this category does not exist
    $query = "SELECT * FROM `categories` WHERE `category_name` = '$category'";
    $result = mysqli_query($dbc, $query)
        or die("Cannot get the Categories");

    //if this category exists then alert the user about that
    if(mysqli_num_rows($result) == 1)
    {
        $error = "Sorry. This Category already exist";
    }
    else {
        if(count($errors) == 0 )
        {
            //save the cateory
            $query = "INSERT INTO `categories` (`category_name`)
                        VALUES('$category')";

            $result = mysqli_query($dbc, $query)
                or die("Cannot Insert Category");

            //then alert the user of the success
            $success = "Category Added";
        }
    }
}

include_once 'includes/head.php';
include_once 'includes/stylesheets.php';
?>
<!--//custom style here-->

<?php
//configurations before calling the page start files
$page_title = "Add New Category";

include_once 'includes/middle.php';
include_once 'includes/left_sidebar.php';
include_once 'includes/start.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="card-box">

            <div class="row">
                <div class="col-md-5">
                    <h4 class="page-header">
                        Add New Category
                    </h4>

                    <form class="form-horizontal" method="POST">
                        <div class="form-group">
                            <label class="control-label col-md-5">Category Name: </label>
                            <div class="col-md-7">
                                <input type="text" name="category" class="form-control" placeholder="Category Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-5"></label>
                            <div class="col-md-7">
                                <input type="submit" name="save" class="btn btn-primary" value="Save">
                            </div>
                        </div>
                    </form>


                </div>

                <div class="col-md-7">
                    <h4 class="page-header">
                        Latest Categories
                    </h4>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>S/N</th>
                                <th>Category</th>
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
