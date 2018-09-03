<?php

include_once 'includes/class.dbc.php';
include_once 'includes/session.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';
include_once 'classes/class.Level.php';

//custom imports
include_once 'admin/classes/class.User.php';

//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();

//prepare an aray of errors
$errors = [];

//if the id isset
if(isset($_GET['id']))
{
    //grab the id and the action
    $id = filter($_GET['id']);
    $action  = filter($_GET['action']);

    if($action == 'del')
    {
        //delete the post
        $query  = "DELETE FROM `threads` WHERE `id` = '$id'";
        $result = $dbc->query($query);

        $success = "Post Deleted";

    }
    elseif ($action == 'flag')
    {
        //flage the post
        $query = "UPDATE `threads` SET `flagged` = '1' WHERE `id` = '$id' ";
        $result = $dbc->query($query);

        $success = "Post Flagged";

    }
    elseif ($action == 'unflag') {
        //flage the post
        $query = "UPDATE `threads` SET `flagged` = '0' WHERE `id` = '$id' ";
        $result = $dbc->query($query);

        $success = "Post Unflagged";
    }
    else {
        $warning = "Unknown Action";
    }
}

//process the form here
if(isset($_POST['title']))
{
    $title = filter($_POST['title']);
    $category = filter($_POST['category']);
    $description = filter($_POST['description']);

    //by default, Flag is false
    $flagged = FALSE;

    //validate the post
    if(empty($title))
    {
        array_push($errors, "Post Title is required");
    }

    //validate the category
    if($category == '' )
    {
        array_push($errors,  "Category must be choosen");
    }

    //validate the post details
    if(empty($description))
    {
        array_push($errors, "Sorry. You must enter the Post details");
    }


    //if there are no errors. then save the thread
    if(count($errors) == 0)
    {
        //save the thread
        $query = "INSERT INTO `threads` (`category`, `title`, `description`, `user_id`,
                `day`, `month`, `year`, `date`, `flagged`
        )

                VALUES('$category', '$title', '$description', '$user_id',
                '$day', '$month', '$year', '$date', '$flagged'
                )
        ";

        $result = mysqli_query($dbc, $query)
            or die("Error, Cannot add forum thread");

        $success = "Your post has been saved";
    }
}

include_once 'includes/head.php';
?>
<!-- custom styles can go here  -->

<?php
include_once 'includes/navigation.php';
?>

<div class="row">
    <div class="col-md-12">
        <h2 class="page-header">Welcome to Our Forum </h2>

        <div class="row">
            <div class="col-md-12">
                <div class="bg-white p-20">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="page-header">Recent Forum Posts</h3>
                        </div>

                        <div class="col-md-4">
                            <a href="#newThread" class="btn btn-primary"
                                data-toggle="modal"
                            >
                                New Post
                            </a>
                        </div>
                    </div>

                    <br>
                    <!-- //row for the threads -->
                    <div class="row">
                        <div class="col-md-10">
                            <div class="table-responsive">
                                <table class="table forum-table">

                                    <tr>
                                        <th>Date Posted</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Views</th>
                                        <th>Author</th>
                                        <th>Replies</th>
                                        <?php
                                        if(isset($_SESSION['user_id']))
                                        {
                                            if(isset($_SESSION['level']))
                                            {
                                                if($_SESSION['level'] > 1)
                                                {
                                                    ?>
                                                <th>Status</th>
                                                <th>Action</th>
                                                    <?php
                                                }
                                            }
                                        }
                                         ?>
                                    </tr>
                                    <?php
                                    //get all forum posts
                                    $query = "SELECT * FROM `threads` LIMIT 30 ";
                                    $result = mysqli_query($dbc, $query)
                                        or die('Could not get forum posts');

                                    if(mysqli_num_rows($result) == 0 )
                                    {
                                        ?>
                                    <tr>
                                        <td colspan="10">
                                            <strong class="text-info">
                                                No Forum Posts.
                                            </strong>
                                        </td>
                                    </tr>
                                        <?php
                                    }
                                    else {
                                        while($row = mysqli_fetch_array($result))
                                        {
                                            $status = $row['flagged'];
                                            ?>
                                        <tr>
                                            <td> <?php echo $row['date']; ?> </td>
                                            <td>
                                                <a href="thread.php?id=<?php echo $row['id']; ?>" class="forum-title">
                                                    <?php echo $row['title']; ?>
                                                </a>

                                                <br>
                                                <p>
                                                    <?php
                                                    //just show a port of the description.
                                                    //the person has to click on the link to see the details
                                                    $description = substr($row['description'], 0, 100);

                                                    echo $description;
                                                     ?>
                                                </p>
                                            </td>

                                            <td>
                                                <?php
                                                $cat = $row['category'];
                                                $query = "SELECT `title` FROM `thread_categories` WHERE `id` = '$cat' ";
                                                $resul = mysqli_query($dbc, $query)
                                                    or die("Error.");

                                                list($cat_title) = mysqli_fetch_array($resul);

                                                echo $cat_title;
                                                 ?>
                                            </td>

                                            <td><?php echo $row['views']; ?></td>

                                            <td>
                                                <?php
                                                //get the user
                                                $user = new User($row['user_id']);

                                                echo $user->username;
                                                 ?>
                                            </td>

                                            <td>
                                                <?php
                                                $thread = $row['id'];

                                                $query = "SELECT * FROM `replies` WHERE `thread_id` = '$thread' ";
                                                $resul = mysqli_query($dbc, $query)
                                                    or die("Error. Could not get the replies");

                                                $replies = mysqli_num_rows($resul);

                                                echo $replies;
                                                 ?>
                                            </td>
                                            <?php
                                            if(isset($_SESSION['user_id']))
                                            {
                                                if(isset($_SESSION['level']))
                                                {
                                                    if($_SESSION['level'] == Level::MODERATOR )
                                                    {
                                                        ?>
                                                    <td>
                                                        <?php

                                                            if($status == TRUE)
                                                            {
                                                                ?>
                                                            <div class="badge bg-red">
                                                                <i class="fa fa-times"></i>
                                                                Flagged
                                                            </div>
                                                                <?php
                                                            }
                                                            else {
                                                                ?>
                                                            <div class="badge bg-green">
                                                                <i class="fa fa-check"></i>
                                                                Ok
                                                            </div>
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if($status == TRUE)
                                                        {
                                                            ?>
                                                            <a href="forum.php?id=<?php echo $row['id'] ?>&action=unflag"
                                                                class="btn btn-success btn-xs">
                                                                <i class="fa fa-check"></i>
                                                                Unflag
                                                            </a>
                                                            <?php
                                                        }
                                                        else {
                                                            ?>
                                                            <a href="forum.php?id=<?php echo $row['id'] ?>&action=flag"
                                                                class="btn btn-warning btn-xs">
                                                                <i class="fa fa-exclamation"></i>
                                                                Flag
                                                            </a>
                                                            <?php
                                                        }
                                                         ?>
                                                    </td>
                                                        <?php
                                                    }

                                                    if($_SESSION['level'] == Level::ADMIN)
                                                    {
                                                        ?>
                                                    <td>
                                                        <?php

                                                            if($status == TRUE)
                                                            {
                                                                ?>
                                                            <div class="badge bg-red">
                                                                <i class="fa fa-times"></i>
                                                                Flagged
                                                            </div>
                                                                <?php
                                                            }
                                                            else {
                                                                ?>
                                                            <div class="badge bg-green">
                                                                <i class="fa fa-check"></i>
                                                                Ok
                                                            </div>
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>

                                                        <?php
                                                        if($status == TRUE)
                                                        {
                                                            ?>
                                                            <a href="forum.php?id=<?php echo $row['id'] ?>&action=unflag"
                                                                class="btn btn-success btn-xs">
                                                                <i class="fa fa-check"></i>
                                                                Unflag
                                                            </a>
                                                            <?php
                                                        }
                                                        else {
                                                            ?>
                                                            <a href="forum.php?id=<?php echo $row['id'] ?>&action=flag"
                                                                class="btn btn-warning btn-xs">
                                                                <i class="fa fa-exclamation"></i>
                                                                Flag
                                                            </a>
                                                            <?php
                                                        }
                                                         ?>


                                                        <a href="forum.php?id=<?php echo $row['id'] ?>&action=del"
                                                            class="btn btn-danger btn-xs">
                                                            <i class="fa fa-trash"></i>
                                                            Del
                                                        </a>
                                                    </td>
                                                        <?php
                                                    }
                                                }
                                            }
                                             ?>
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
            </div>
        </div>
    </div>
</div>

<!-- start of modal -->

<div class="modal fade top" id="newThread" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
    data-backdrop="false">
    <div class="modal-dialog modal-frame" role="document">
        <!--Content-->
        <div class="modal-content">
            <form class="form-horizontal" action="forum.php" method="post">

            <!-- modal head  -->
            <div class="modal-header">
                <h3 class="box-title">Create New Forum Post</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!--Body-->
            <div class="modal-body ">

                    <?php
                    if(!isset($_SESSION['user_id']))
                    {
                        echo "<strong> This is only for Registered users </strong>";
                        echo "<br>";
                        echo 'Click <a href="login.php"> here </a> to login';
                    }
                    else {
                        ?>
                        <div class="form-group">
                            <label for="title" class="control-label col-md-3">Post Title:</label>
                            <div class="col-md-9">
                                <input type="text" name="title" value="" class="form-control" required
                                placeholder="Enter the topic of your post">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category" class="control-label col-md-3">Post Category:</label>
                            <div class="col-md-9">
                                <select class="form-control" name="category" required>
                                    <option value=""></option>
                                    <?php
                                    $query = "SELECT * FROM `thread_categories`";
                                    $result = mysqli_query($dbc, $query)
                                        or die("Could not get Post Categories");
                                    while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['title']; ?>
                                    </option>
                                        <?php
                                    }
                                     ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="control-label col-md-3">Post Details:</label>
                            <div class="col-md-9">
                                <textarea name="description" rows="8" class="form-control" placeholder="Enter your Post here" required></textarea>
                            </div>
                        </div>
                        <?php
                    }
                     ?>

            </div>

            <!-- //modal footer -->
            <div class="modal-footer">
                <button type="submit" name="" value="Post" class="btn btn-primary">
                    <i class="fa fa-send"></i>
                    Post
                </button>
                <button type="button" name="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                    Close
                </button>
            </div>
            </form>
        </div>
        <!--/.Content-->
    </div>
</div>


<!-- end of modal -->


<?php
include_once 'includes/footer.php';
include_once 'includes/scripts.php';
include_once 'includes/toast.php';
?>

<!-- custom scripts here -->

<?php
include_once 'includes/end.php';
?>
