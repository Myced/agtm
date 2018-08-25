<?php

include_once 'includes/class.dbc.php';
include_once 'includes/session.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';
include_once 'admin/classes/class.User.php';

//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();

$errors = [];

//save the reply
if(isset($_POST['reply']))
{
    //get the thread id.
    $thread_id = filter($_GET['id']);

    $reply = filter($_POST['reply']);

    //now validate the reply
    if(empty($reply))
    {
        array_push($errors, "Sorry. Your reply cannot be empty");
    }

    if(count($errors) == 0)
    {
        //save the reply
        $query = "INSERT INTO `replies` (`thread_id`, `reply`, `user_id`, `day`, `month`, `year`)
                VALUES('$thread_id', '$reply', '$user_id', '$day', '$month', '$year')";

        $result = $dbc->query($query);

        //indicate a success message
        $success = "Reply Posted";
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
        <h2 class="page-header">Forum Discussions</h2>

        <div class="row">
            <div class="col-md-3">
                <br>
                <div class="row">
                    <div class="col-md-12 bg-white p-20">
                        <a href="forum.php">
                            <img src="images/back.png" alt="Back to Forum Index" width="50px" height="50px">
                            Back To Forum
                        </a>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-12 bg-white p-20">
                        <div class="">
                            <ul class="list-group">
                                <li class="list-group-item active">
                                    Latest Posts
                                </li>

                                <?php
                                $query = "SELECT * FROM `threads` ORDER BY `id` DESC LIMIT 7 ";
                                $result = $dbc->query($query);

                                while($row = $result->fetch_assoc())
                                {
                                    ?>
                                <li class="list-group-item">
                                    <a href="thread.php?id=<?php echo $row['id']; ?>">
                                        <?php echo $row['title']; ?>
                                    </a>
                                </li>
                                    <?php
                                }
                                 ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 bg-white p-20">
                        <div class="">
                            <ul class="list-group">
                                <li class="list-group-item active">
                                    Most Viewed Posts
                                </li>

                                <?php
                                $query = "SELECT * FROM `threads` ORDER BY `views` DESC LIMIT 7 ";
                                $result = $dbc->query($query);

                                while($row = $result->fetch_assoc())
                                {
                                    ?>
                                <li class="list-group-item">
                                    <a href="thread.php?id=<?php echo $row['id']; ?>">
                                        <?php echo $row['title']; ?>
                                    </a>
                                </li>
                                    <?php
                                }
                                 ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class=" p-20">

                    <?php
                    if(isset($_GET['id']))
                    {
                        $id = filter($_GET['id']);
                    }
                    else {
                        $id = '';
                    }

                    //add the thread viewcount

                    //get the forum thread details
                    $query = "SELECT  * FROM `threads` WHERE `id` = '$id' ";
                    $result = $dbc->query($query);

                    while($row = $result->fetch_assoc())
                    {

                        (int) $views = $row['views'];
                        $views++;

                        //update the views
                        $query = "UPDATE `threads` SET `views` = '$views' WHERE `id` = '$id' ";
                        $res = $dbc->query($query);


                        //add the views
                        ?>
                    <div class="box box-widget">
                      <div class="box-header with-border">
                        <div class="user-block">
                          <img class="img-circle" src="<?php echo USER_PROFILE; ?>" alt="User Image">
                          <span class="username"><a href="#">
                              <?php
                              $user = new User($row['user_id']);
                              $username =  $user->full_name;
                              if(empty($username))
                              {
                                  echo 'User';
                              }
                              else {
                                  echo $username;
                              }
                               ?>
                          </a></span>
                          <span class="description">Posted - <?php echo time_from_timestamp($row['time_added']); ?>
                              On <?php echo date_from_timestamp($row['time_added']); ?>
                          </span>
                        </div>

                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">

                          <h4>
                              <?php echo $row['title']; ?>
                          </h4>
                          <br><br>

                        <!-- post text -->
                        <?php
                        $text = nl2br($row['description']);

                        echo $text;
                         ?>

                        <!-- /.attachment-block -->

                        <!-- Social sharing buttons -->

                      </div>

                      <!-- /.box-footer -->
                      <div class="box-footer">
                          <button type="button" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</button>
                          <span class="pull-right text-muted">
                              <?php
                              //get the replies.

                              $query = "SELECT * FROM `replies` WHERE `thread_id` = '$id' ";

                              $replies =  $dbc->query($query); //contains a collection of replies.
                              //to be displayed below.



                              echo $replyNumber =  $replies->num_rows;
                               ?>
                                replies
                           </span>
                      </div>
                      <!-- /.box-footer -->
                    </div>
                    <br>
                        <?php
                    }
                     ?>

                     <!-- //now show the replies -->
                     <?php
                     if($replyNumber == 0)
                     {
                         ?>
                     <div class="box box-widget">
                       <div class="box-header with-border">
                         <div class="user-block">
                           <h3 class="box-title">
                               <span class="username">
                                   Reply to this post
                               </span>
                           </h3>
                         </div>

                       </div>
                       <!-- /.box-header -->
                       <div class="box-body">
                           <br>
                           <strong>Be the First to reply to this Post</strong>

                           <div class="row">
                               <div class="col-md-12">
                                   <br>
                                  <?php
                                  if(isset($_SESSION['user_id']))
                                  {
                                      ?>
                                  <form class="form-horizontal" action="" method="post">
                                      <textarea name="reply" rows="8" placeholder="Please Leave your reply here"
                                       required class="form-control"></textarea>
                                       <br>
                                       <input type="submit" name="submit" value="Post Reply" class="btn btn-primary">
                                  </form>
                                      <?php
                                  }
                                  else {
                                      echo '<strong class="text-info"> You must be logged in to reply </strong>';
                                  }
                                   ?>
                               </div>
                           </div>


                       </div>

                       <!-- /.box-footer -->
                     </div>
                         <?php
                     }
                     else {
                         //loop through the replies and show them
                         while($row = $replies->fetch_assoc())
                         {
                             ?>
                         <div class="box box-widget">
                           <div class="box-header with-border">
                             <div class="user-block">
                               <img class="img-circle" src="<?php echo USER_PROFILE; ?>" alt="User Image">
                               <span class="username"><a href="#">
                                   <?php
                                   $user = new User($row['user_id']);
                                   $username =  $user->full_name;
                                   if(empty($username))
                                   {
                                       echo 'User';
                                   }
                                   else {
                                       echo $username;
                                   }
                                    ?>
                               </a></span>
                               <span class="description">Replied - <?php echo time_from_timestamp($row['time_added']); ?>
                                   <?php echo date_from_timestamp($row['time_added']) ?>
                               </span>
                             </div>

                           </div>
                           <!-- /.box-header -->
                           <div class="box-body">


                             <!-- post text -->
                             <?php
                             $text = nl2br($row['reply']);

                             echo $text;
                              ?>

                             <!-- /.attachment-block -->

                             <!-- Social sharing buttons -->

                           </div>


                           <!-- /.box-footer -->
                         </div>
                             <?php
                         }

                         //at the end. show the form for a user to reply.
                         ?>
                         <div class="box box-widget">
                           <div class="box-header with-border">
                             <div class="user-block">
                               <h3 class="box-title">
                                   <span class="username">
                                       Reply to this post
                                   </span>
                               </h3>
                             </div>

                           </div>
                           <!-- /.box-header -->
                           <div class="box-body">
                               <br>
                               <strong>Enter your reply below</strong>

                               <div class="row">
                                   <div class="col-md-12">
                                       <br>
                                      <?php
                                      if(isset($_SESSION['user_id']))
                                      {
                                          ?>
                                      <form class="form-horizontal" action="" method="post">
                                          <textarea name="reply" rows="8" placeholder="Please Leave your reply here"
                                           required class="form-control"></textarea>
                                           <br>
                                           <input type="submit" name="submit" value="Post Reply" class="btn btn-primary">
                                      </form>
                                          <?php
                                      }
                                      else {
                                          echo '<strong class="text-info"> You must be logged in to reply </strong>';
                                      }
                                       ?>
                                   </div>
                               </div>


                           </div>

                           <!-- /.box-footer -->
                         </div>
                         <?php
                     }
                      ?>
                </div>


            </div>
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
