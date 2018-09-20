<?php

include_once 'includes/class.dbc.php';
include_once 'includes/session.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';
include_once 'classes/class.AccountStatus.php';

//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();


include_once 'includes/head.php';
?>
<!-- custom styles can go here  -->

<?php
include_once 'includes/navigation.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="bg-white p-20">
            <h3 class="page-header">Email Confirmation</h3>

            <div class="row">
                <div class="col-md-12">
                    <?php
                    //grab the token and verify it
                    if(isset($_GET['token']))
                    {
                        $token = filter($_GET['token']);
                    }
                    else {
                        $token = '';
                    }


                    if(empty($token))
                    {
                        ?>
                    <div  class="text-center">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2" style="width: 100px; height: 100px;">
                            <circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                            <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
                            <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
                        </svg>

                        <br>
                        <p class=" text-danger">
                            <strong>Sorry. Invalid token</strong>
                        </p>

                        <p>
                            <a href="index.php">
                                Back to Home
                            </a>
                        </p>
                    </div>
                        <?php
                    }
                    else {
                        //verify that the token has not expired
                        $query  = "SELECT * FROM `users` WHERE `token` = '$token' ";
                        $result = mysqli_query($dbc, $query)
                            or die("Error. Cannot query");

                        if(mysqli_num_rows($result) == 0)
                        {
                            ?>
                        <div  class="text-center">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2" style="width: 100px; height: 100px;">
                                <circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
                                <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
                            </svg>

                            <br>
                            <p class=" text-danger">
                                <strong>Sorry. Invalid token</strong>
                            </p>

                            <p>
                                <a href="index.php">
                                    Back to Home
                                </a>
                            </p>
                        </div>
                            <?php
                        }
                        else {
                            //check that the token is still valid
                            while($row = mysqli_fetch_array($result))
                            {
                                $time_added = $row['time_added'];
                                $now = time();
                            }

                            //now check that the link has not expired.
                            $time_laps = 24 * 60 * 60; //24 hours.

                            //convert the start date to string
                            $start_date = strtotime($time_added);

                            //get the difference between the dates
                            $difference = $now - $start_date;

                            //if the time difference is more thatn 24 hours then
                            // then link has expired.
                            if($difference > $time_laps)
                            {
                                //the link has expired
                                ?>
                                <div  class="text-center">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2" style="width: 100px; height: 100px;">
                                        <circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                        <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
                                        <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
                                    </svg>

                                    <br>
                                    <p class=" text-danger">
                                        <strong>Sorry. The Link has expired</strong>
                                    </p>

                                    <p>
                                        <a href="index.php">
                                            Back to Home
                                        </a>
                                    </p>
                                </div>
                                <?php
                            }
                            else {
                                //activate the account;
                                $status = AccountStatus::ACTIVE;

                                //update the accunt
                                $query = "UPDATE `users` SET
                                        `account_status` = '$status', `confirmed_at` = NOW()
                                        WHERE `token` = '$token' ";
                                $result = mysqli_query($dbc, $query)
                                    or die("Error. Could not confirm email");

                                ?>
                                <div  class="text-center">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2" style="width: 100px; height: 100px;">
                                        <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6"
                                        stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                        <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6"
                                        stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                                    </svg>

                                    <br>
                                    <p class=" text-success">
                                        <strong>Email has been verified. You can now log in </strong>
                                    </p>

                                    <p>
                                        <a href="index.php">
                                            Back to Home
                                        </a>

                                        |

                                        <a href="login.php">Login</a>
                                    </p>
                                </div>
                                <?php

                            }
                        }

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
