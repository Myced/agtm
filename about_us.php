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

<div class="row">
    <div class="col-md-12">
        <h2 class="page-header">About Us</h2>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="bg-white p-20">
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                <strong>APEX GLOBAL TRADING AND MARKETING </strong> is an international trader and placement agent.
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-info">As A Trader:</h3>

                            <br>
                            <ul>
                                <li>We Buy and Sell Commodities</li>
                                <li>We work as commision based agents/mandates. Facilitating sales, purchases and negotiation.</li>
                                <li>We serve as a platform where traders and business people meet, share ideas, talk business and propagate creativity.</li>
                                <li>We are affiliates and partners to a few business around the globe</li>
                            </ul>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-info">As A Placement Agent:</h3>

                            <ul>
                                <li>
                                    We offer visible agents who serve as representatives, inspectors, visitors in any country,
                                    <br>
                                    who provide clients with real time details such as live video, live photo, government authentication, etc.

                                    <br><br>

                                    This feature has gone a long way to boost our sales and the trust-worthiness of us to our clients.
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-info">Products we deal in:</h3>

                            <ul>
                                <li>Food and Agricultural Products</li>
                                <li>Household Chemicals</li>
                                <li>Lumber / Timber</li>
                                <li>General household Commodities</li>
                                <li>Health Products</li>
                                <li>Machinery</li>
                                <li>Spare parts</li>
                                <li>Petroleum</li>
                            </ul>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-info">QUARANTEE OF TRADE</h3>

                            <p>
                                In this module of business, we guarantee trade in the following ways
                            </p>

                            <ul>
                                <li>
                                    We provide agents in every country, where they serve as day to day
                                    monitor of trade process, provide live feeds as videos, photos of
                                     entire process, they also investigate both legal and existence
                                     wise of all parties involved, they serve as representatives to
                                      all parties involved and initiate sit down meetings
                                    (this service is paid for and is categorized, please contact us)
                                </li>

                                <li>
                                    We also serve as mediators for any trade and in which case we
                                    monitor both, and in this case , we seek a commission which is
                                    mandatory but payable after successful closure of deal
                                    ( 4 – 8% based on trade type and requirements )
                                </li>

                                <li>
                                    We can link both parties up, and in which case we do not
                                    collect any commission from them, they both will pay a
                                     non-refundable fee to us
                                </li>
                            </ul>

                            <p>

                                Any LOI or SCO placed on this platform are confirmed and verified

                                <br>
                                Any Supply or Buyer on this platform is been verified and 100% legit
                            </p>

                            <br><br>
                            <p>
                                WE ARE CONFIDENT OF OUR BRAND AND MODULE, THAT IS WHY WE CHOOSE TO WORK WITH THE BEST ONLY

                                <br><br>
                                LET YOUR MONEY WORK FOR YOU
                            </p>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="">
                                <h4 class="text-info page-header text-center"> Info</h4>

                                <div class="col-md-10 col-md-offset-1">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="col-xs-1" >
                                                <i class="fa fa-map-marker fa-3x"></i>
                                            </div>
                                            <div class="col-xs-8">
                                                <strong class="text-primary" style="font-size: 1.2em;">Location <br> </strong>
                                                Worldwide
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="col-xs-2" >
                                                <i class="fa fa-envelope-o fa-3x"></i>
                                            </div>
                                            <div class="col-xs-8">
                                                <strong class="text-primary" style="font-size: 1.2em;">Email Us <br> </strong>
                                                info@a-gtm.com
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
include_once 'includes/toast.php';
?>

<!-- custom scripts here -->

<?php
include_once 'includes/end.php';
?>
