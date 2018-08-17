<?php

include_once 'includes/class.dbc.php';
include_once 'includes/session.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';


//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();

//set the array of errors
$errors = [];

//CHECK THAT THE FORM HAS BEEN posted
if(isset($_POST['name']))
{
    //grab all the form values
    $name  = filter($_POST['name']);
    $tel = filter($_POST['tel']);
    $email = filter($_POST['email']);
    $message = filter($_POST['message']);

    //if the user is logged in . then we should get the user id
    $user_id = $user_id;

    //we do some validation
    if(empty($name))
    {
        array_push($errors, 'Your contact Name is Required');
    }

    if(empty($email))
    {
        array_push($errors, 'Contact Email is Required');
    }

    if(empty($message))
    {
        array_push($errors, 'Your message cannot be empty');
    }

    //now if there is not error. Then save to the database;
    if(count($errors) == 0)
    {
        //generate the insert to the database;
        $query = "INSERT INTO `contact_us` (`name`, `tel`, `email`, `message`, `user_id`)

            VALUES('$name', '$tel', '$email', '$message', '$user_id');
        ";

        $result = mysqli_query($dbc, $query)
            or die("Error. Cannot query the database");

        //show a success message
        $success = "Message Sent. We will contact you later!";
    }
}


include_once 'includes/head.php';
?>
<!-- custom styles can go here  -->

<?php
include_once 'includes/navigation.php';
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2 class="page-header">Contact Us</h2>

        <form class="" action="" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="callout callout-info">
                        Please Leave your message here
                    </div>
                </div>

                <br><br>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <input type="text" name="name" value="" placeholder="Full Name" class="form-control" required>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <input type="text" name="tel" value="" placeholder="Telephone" class="form-control">
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <input type="email" name="email" value="" placeholder="Your Email Address" class="form-control" required="">
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <textarea name="message" rows="8" class="form-control"
                            placeholder="Enter your message here" required
                        ></textarea>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <button type="submit" name="contact" class="btn btn-primary btn-block">
                            <i class="fa fa-send"></i>
                            Send Message
                        </button>
                    </div>
                </div>
            </div>
        </form>

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
