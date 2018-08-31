<?php

include_once 'includes/class.dbc.php';
include_once 'includes/session.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';

//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();


include_once 'includes/head.php';
?>
<!-- custom styles can go here  -->

<?php
include_once 'includes/navigation.php';
?>

<div class="p-20 bg-white">
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header"> Advertise With Us</h2>
        </div>

        <br>
        <br>
        <div class="advert">
            <div class="col-md-12 ad-list">
                Do you wish to advertise your products with us?
            </div>

            <div class="col-md-12 ad-list">
                Do you want to partner with us?
            </div>

            <div class="col-md-12 ad-list">
                Do you want to create an affiliate program with us?
            </div>

            <div class="col-md-12 ad-list">
                Do you want to form an agent group with us?
            </div>

            <div class="col-md-12 ad-list">
                Do you want to act like a representative?
            </div>

            <div class="col-md-12 ad-list">
                Do you want to form an agent group with us?
            </div>

            <br><br>
            <div class="col-md-12">
                <h3>Then send us an email at <a href="mailto:info@a-gtm.com">info@a-gtm.com</a>
                    
                    Or Contact us <a href="contact.php">here</a>
                </h3>
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
