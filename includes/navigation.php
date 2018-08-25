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
                   ?>
                   <ul class="nav navbar-nav navbar-right">
                       <li><a href="logout.php">Logout</a></li>
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
