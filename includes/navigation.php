</head>
<body>

    <div class="navigation">
       <nav class="navbar  navbar-fixed-top">
       <!-- Brand and toggle get grouped for better mobile display -->
           <div class="navbar-header">
               <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                   <span class="sr-only">Toggle navigation</span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
               </button>
               <a href="index.php" class="navbar-brand">
                   <img src="images/logo_nam.png" alt="">
               </a>
           </div>
           <!-- Collection of nav links and other content for toggling -->
           <div id="navbarCollapse" class="collapse navbar-collapse">
               <ul class="nav navbar-nav ">
                   <li class=""><a href="index.php">Home</a></li>
                   <li class="">
                        <a href="importers.php">Importers/Buyers</a>
                    </li>
                    <li>
                        <a href="exporters.php">Exporters/Sellers</a>
                    </li>
                    <li>
                        <a href="approved_trades.php">Approved Trades</a>
                    </li>
                    <li>
                        <a href="forum.php"> Buy/Sell Forum</a>
                    </li>
                    <li>
                        <a href="price_watch.php">Price Watch</a>
                    </li>

                    <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">More <span class="fa fa-chevron-down pull-right"></span></a>
                          <ul class="dropdown-menu">

                                <li><a href="products.php">Products</a></li>
                                <li class="divider"></li>
                                <li><a href="all_sell_offers.php"> Sell Offers </a></li>
                                <li class="divider"></li>
                                <li><a href="all_buy_offers.php"> Buy  Offers </a></li>
                                <li class="divider"></li>
                                <li><a href="sell_offer.php">Make Sell Offer </a></li>
                                <li class="divider"></li>
                                <li><a href="buy_offer.php">Make Buy Offer</a></li>

                          </ul>
                    </li>
                    <!-- <li>
                        <a href="#">CONTACT US</a>
                    </li> -->

               </ul>

               <?php
               if(isset($_SESSION['user_id']))
               {
                   //prepare the user informatin and avatart
                   $usrid = filter($_SESSION['user_id']);

                   include_once 'admin/classes/class.User.php';

                   $user = new User($usrid);

                   $fullname = $user->full_name;
                   $avatar = 'admin/' . $user->photo;
                   $date = $user->time_added;


                   //validate the user picture
                   if(empty($user->photo))
                   {
                       $avatar = USER_PROFILE;
                   }
                   else {
                       if(!file_exists($avatar))
                       {
                           $avatar = USER_PROFILE;
                       }
                   }

                   //once the avatar is configures. save it back
                   $user->photo = $avatar;

                   ?>
                   <ul class="nav navbar-nav navbar-right">
                       <li class="dropdown user user-menu">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                           <img src="<?php echo $avatar; ?>" class="user-image" alt="User Image">
                           <span class="hidden-xs">
                               <?php
                               echo $_SESSION['username'];
                                ?>
                           </span>
                         </a>
                         <ul class="dropdown-menu">
                           <!-- User image -->
                           <li class="user-header skin-blue">
                             <img src="<?php echo $avatar; ?>" class="img-circle" alt="User Image">

                             <p>
                                 <?php echo $fullname; ?>
                               <small>Member since <?php echo join_date($date); ?></small>
                             </p>
                           </li>
                           <!-- Menu Body -->
                           <li class="user-body">
                             <div class="row">
                               <div class="col-xs-4 text-center">
                                 <a href="#">Buy Offers</a>
                                 <br>
                                 <?php echo $user->getBuyOfferCount(); ?>
                               </div>
                               <div class="col-xs-4 text-center">
                                 <a href="#" class="text-bold">Sell Offers</a>
                                 <br>
                                 <?php echo $user->getSellOfferCount(); ?>
                               </div>
                               <div class="col-xs-4 text-center">
                                 <a href="#" class="text-bold">Orders</a>
                                 <br>
                                 <?php echo $user->getOrdersCount(); ?>
                               </div>
                             </div>
                             <!-- /.row -->
                           </li>
                           <!-- Menu Footer-->
                           <li class="user-footer">
                             <div class="pull-left">
                               <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                             </div>
                             <div class="pull-right">
                               <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                             </div>
                           </li>
                         </ul>
                       </li>
                   </ul>
                   <?php
               }
               else {
                   ?>
                  <ul class="nav navbar-nav navbar-right">
                      <li><a href="login.php">Login</a></li>
                  </ul>
                   <?php
               }
                ?>

           </div>
       </nav>
    </div>



   <div class="main">
       <div class="container-fluid">
