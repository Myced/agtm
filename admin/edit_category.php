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
    $id = filter($_GET['id']);

    if(empty($category))
    {
        array_push($errors, "Sorry, Category name cannot be empty");
    }

    if(count($errors) == 0)
    {
        //save the cateory
        $query = "UPDATE  `categories` SET `category_name` = '$category'
                    WHERE `id` = '$id'
                    ";

        $result = mysqli_query($dbc, $query)
            or die("Cannot Update Category");

        //then alert the user of the success
        $success = "Category Updated";
    }

}

if(isset($_GET['id']))
{
    $id = filter($_GET['id']);

    $query = " SELECT `category_name` FROM `categories` WHERE `id` = '$id'";
    $result = mysqli_query($dbc, $query)
        or die("Error, Cannot get category");

    list($cat_name) = mysqli_fetch_array($result);


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
                <div class="col-md-6">
                    <h4 class="page-header">
                        Edit Category
                    </h4>

                    <form class="form-horizontal" method="POST">
                        <div class="form-group">
                            <label class="control-label col-md-5">Category Name: </label>
                            <div class="col-md-7">
                                <input type="text" name="category" class="form-control" placeholder="Category Name"
                                    value=" <?php echo $cat_name; ?> ">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-5"></label>
                            <div class="col-md-7">
                                <input type="submit" name="save" class="btn btn-primary" value="Save">
                                <a href="category_list.php" class="btn btn-primary">
                                    Back to Category List
                                </a>
                            </div>
                        </div>
                    </form>


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
